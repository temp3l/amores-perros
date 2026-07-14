import { expect, test } from '@playwright/test';
import fs from 'node:fs';
import path from 'node:path';

function localCredentials() {
  const values: Record<string, string> = {};
  const envPath = path.join(__dirname, '..', '..', '.env');

  if (fs.existsSync(envPath)) {
    for (const line of fs.readFileSync(envPath, 'utf8').split(/\r?\n/)) {
      const separator = line.indexOf('=');
      if (separator > 0 && !line.trim().startsWith('#')) {
        values[line.slice(0, separator).trim()] = line.slice(separator + 1).trim();
      }
    }
  }

  return {
    username: process.env.WORDPRESS_ADMIN_USER || values.WORDPRESS_ADMIN_USER || 'local_admin',
    password: process.env.WORDPRESS_ADMIN_PASSWORD || values.WORDPRESS_ADMIN_PASSWORD || 'change-me'
  };
}

async function login(page: Parameters<typeof test>[0]['page']) {
  const credentials = localCredentials();
  await page.goto('/wp-login.php');
  await page.locator('#user_login').fill(credentials.username);
  await page.locator('#user_pass').fill(credentials.password);
  await page.locator('#wp-submit').click();
  await expect(page).toHaveURL(/\/wp-admin\//);
}

async function pageId(page: Parameters<typeof test>[0]['page'], slug: string): Promise<number> {
  const response = await page.request.get(`/wp-json/wp/v2/pages?slug=${slug}&context=view`);
  expect(response.ok()).toBeTruthy();
  const records = await response.json();
  expect(records).toHaveLength(1);
  return records[0].id;
}

test.describe('Editor-first smoke checks', () => {
  test.skip(({ isMobile }) => isMobile, 'The WordPress editing smoke check runs once in the desktop project.');

  test('canonical pages open without invalid block warnings', async ({ page }) => {
    test.setTimeout(300000);
    await login(page);

    for (const slug of [
      'startseite',
      'hundetraining-hamburg',
      'erstgespraech',
      'einzeltraining',
      'dogspace-hamburg',
      'workshops-seminare',
      'coaching-mit-hund',
      'ueber-jacky-rebien',
      'preise',
      'kontakt',
      'faq',
      'ratgeber',
      'impressum',
      'datenschutz'
    ]) {
      const id = await pageId(page, slug);
      await page.goto(`/wp-admin/post.php?post=${id}&action=edit`, { waitUntil: 'domcontentloaded' });

      const canvas = page.frameLocator('iframe[name="editor-canvas"]');
      await expect(canvas.locator('body')).toBeVisible();
      await page.waitForTimeout(1000);
      await expect(canvas.getByText(/unerwarteten oder ungültigen Inhalt|unexpected or invalid content/i)).toHaveCount(0);
      await expect(canvas.locator('[contenteditable="true"]').first()).toBeVisible();
    }
  });

  test('Startseite image blocks expose the Replace control', async ({ page }) => {
    await login(page);
    const id = await pageId(page, 'startseite');
    await page.goto(`/wp-admin/post.php?post=${id}&action=edit`, { waitUntil: 'domcontentloaded' });

    const canvas = page.frameLocator('iframe[name="editor-canvas"]');
    const imageBlocks = canvas.locator('[data-type="core/image"]');
    await expect(imageBlocks).toHaveCount(9);
    await expect(page.getByRole('button', { name: /Vorlage bearbeiten|Edit pattern/i })).toHaveCount(0);

    await imageBlocks.first().click();
    await page.getByRole('button', { name: /Ersetzen|Replace/i }).click();
    const mediaLibrary = page.getByRole('menuitem', { name: /Mediathek|Medienbibliothek|Media Library/i });
    await expect(mediaLibrary).toBeVisible();
    await mediaLibrary.click();
    await expect(page.getByRole('dialog')).toBeVisible();
    await page.keyboard.press('Escape');

    for (let index = 0; index < await imageBlocks.count(); index += 1) {
      const imageBlock = imageBlocks.nth(index);
      await imageBlock.scrollIntoViewIfNeeded();
      await imageBlock.click();
      await expect(page.getByRole('button', { name: /Ersetzen|Replace/i })).toBeVisible();
    }
  });

  test('canonical frontends have no runtime, asset, image or duplicate-id errors', async ({ page }) => {
    test.setTimeout(180000);
    const errors: string[] = [];

    page.on('pageerror', (error) => errors.push(`pageerror: ${error.message}`));
    page.on('console', (message) => {
      if (message.type() === 'error') {
        errors.push(`console: ${message.text()}`);
      }
    });
    page.on('response', (response) => {
      const pageUrl = page.url();
      const isSameOrigin = pageUrl.startsWith('http')
        && new URL(response.url()).origin === new URL(pageUrl).origin;
      if (response.status() >= 400 && isSameOrigin) {
          errors.push(`http ${response.status()}: ${response.url()}`);
      }
    });

    for (const definition of [
      '/',
      '/hundetraining-hamburg/',
      '/erstgespraech/',
      '/einzeltraining/',
      '/dogspace-hamburg/',
      '/workshops-seminare/',
      '/coaching-mit-hund/',
      '/ueber-jacky-rebien/',
      '/preise/',
      '/kontakt/',
      '/faq/',
      '/impressum/',
      '/datenschutz/'
    ]) {
      await page.goto(definition, { waitUntil: 'domcontentloaded' });
      await page.waitForTimeout(300);

      const diagnostics = await page.evaluate(() => {
        const ids = Array.from(document.querySelectorAll<HTMLElement>('[id]')).map((element) => element.id);
        const duplicates = ids.filter((id, index) => ids.indexOf(id) !== index);
        const brokenImages = Array.from(document.images)
          .filter((image) => image.complete && image.naturalWidth === 0)
          .map((image) => image.currentSrc || image.src);
        return { duplicates: Array.from(new Set(duplicates)), brokenImages };
      });

      for (const id of diagnostics.duplicates) errors.push(`${definition}: duplicate id ${id}`);
      for (const image of diagnostics.brokenImages) errors.push(`${definition}: broken image ${image}`);
    }

    expect(errors).toEqual([]);
  });

  test('Site Editor exposes header, navigation and footer blocks', async ({ page }) => {
    await login(page);
    await page.goto('/wp-admin/site-editor.php?postType=wp_template_part&postId=beziehungssache-hund%2F%2Fheader&canvas=edit', { waitUntil: 'domcontentloaded' });

    await expect(page.locator('body')).not.toContainText(/kritischer Fehler|critical error/i);
    let canvas = page.frameLocator('iframe[name="editor-canvas"]');
    await expect(canvas.locator('body')).toBeVisible();
    await expect(canvas.locator('.site-header')).toHaveCount(1);
    await expect(canvas.locator('.site-header .wp-block-navigation')).toHaveCount(1);

    await page.goto('/wp-admin/site-editor.php?postType=wp_template_part&postId=beziehungssache-hund%2F%2Ffooter&canvas=edit', { waitUntil: 'domcontentloaded' });
    canvas = page.frameLocator('iframe[name="editor-canvas"]');
    await expect(canvas.locator('body')).toBeVisible();
    await expect(canvas.locator('.site-footer')).toHaveCount(1);
  });
});
