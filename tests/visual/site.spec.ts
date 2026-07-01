import { expect, test } from '@playwright/test';
import fs from 'node:fs/promises';
import path from 'node:path';

const pages = [
  { slug: '/', snapshotName: 'startseite.png' },
  { slug: '/hundetraining-hamburg/', snapshotName: 'hundetraining-hamburg.png' },
  { slug: '/erstgespraech/', snapshotName: 'erstgespraech.png' },
  { slug: '/einzeltraining/', snapshotName: 'einzeltraining.png' },
  { slug: '/dogspace-hamburg/', snapshotName: 'dogspace-hamburg.png' },
  { slug: '/workshops-seminare/', snapshotName: 'workshops-seminare.png' },
  { slug: '/coaching-mit-hund/', snapshotName: 'coaching-mit-hund.png' },
  { slug: '/ueber-jacky-rebien/', snapshotName: 'ueber-jacky-rebien.png' },
  { slug: '/kontakt/', snapshotName: 'kontakt.png' },
  { slug: '/preise/', snapshotName: 'preise.png' },
  { slug: '/impressum/', snapshotName: 'impressum.png' },
  { slug: '/datenschutz/', snapshotName: 'datenschutz.png' }
];

const stabilityStyles = `
  *,
  *::before,
  *::after {
    animation-duration: 0s !important;
    animation-delay: 0s !important;
    transition-duration: 0s !important;
    transition-delay: 0s !important;
    caret-color: transparent !important;
    scroll-behavior: auto !important;
  }
`;

const faqTopicIds = [
  'ablauf-einzeltraining',
  'hundebegegnungen',
  'angespannte-spaziergaenge',
  'leinenfuehrigkeit',
  'stress-belebte-umgebung',
  'rueckruf-unter-ablenkung',
  'unsicherheit-hundehalter',
  'trainingsansaetze-ohne-erfolg',
  'alltagstauglicher-trainingsplan',
  'aggressives-verhalten'
];

const einzeltrainingAnchors = [
  ['/faq/#hundebegegnungen', 'Hundebegegnungen'],
  ['/faq/#angespannte-spaziergaenge', 'Spaziergaenge kaum noch moeglich'],
  ['/faq/#leinenfuehrigkeit', 'stark zieht'],
  ['/faq/#stress-belebte-umgebung', 'belebter Umgebung schnell gestresst'],
  ['/faq/#rueckruf-unter-ablenkung', 'Rueckruf unter Ablenkung'],
  ['/faq/#unsicherheit-hundehalter', 'unsicher geworden'],
  ['/faq/#trainingsansaetze-ohne-erfolg', 'verschiedene Trainingsansaetze ohne Erfolg'],
  ['/faq/#alltagstauglicher-trainingsplan', 'alltagstauglichen Trainingsplan fuer deinen Hund']
];

async function waitForStablePage(page: Parameters<typeof test>[0]['page']) {
  await page.waitForLoadState('domcontentloaded');
  await page.waitForLoadState('networkidle');
  await page.addStyleTag({ content: stabilityStyles });
  await page.waitForTimeout(250);
  await page.evaluate(async () => {
    await Promise.race([
      document.fonts.ready,
      new Promise<void>((resolve) => window.setTimeout(resolve, 5000))
    ]);

    const images = Array.from(document.images).filter((image) => !image.complete);
    await Promise.race([
      Promise.all(
        images.map(
          (image) =>
            new Promise<void>((resolve) => {
              image.addEventListener('load', () => resolve(), { once: true });
              image.addEventListener('error', () => resolve(), { once: true });
            })
        )
      ),
      new Promise<void>((resolve) => window.setTimeout(resolve, 5000))
    ]);
  });
}

test.describe('Visual regressions', () => {
  for (const pageDefinition of pages) {
    test(`${pageDefinition.slug} matches baseline`, async ({ page }, testInfo) => {
      const response = await page.goto(pageDefinition.slug, { waitUntil: 'domcontentloaded' });

      expect(response, `Page ${pageDefinition.slug} did not return a valid response.`).not.toBeNull();
      expect(response?.ok(), `Page ${pageDefinition.slug} returned HTTP ${response?.status()}.`).toBeTruthy();

      await waitForStablePage(page);
      const currentScreenshotDirectory = path.join(testInfo.config.rootDir, '..', '..', 'artifacts', 'visual', 'current', testInfo.project.name);
      await fs.mkdir(currentScreenshotDirectory, { recursive: true });
      await page.screenshot({
        path: path.join(currentScreenshotDirectory, pageDefinition.snapshotName),
        fullPage: true,
        animations: 'disabled',
        caret: 'hide'
      });

      await expect(page).toHaveScreenshot(pageDefinition.snapshotName, {
        fullPage: true,
        animations: 'disabled',
        caret: 'hide'
      });
    });
  }
});

test('Einzeltraining page links to the FAQ topics', async ({ page }) => {
  const response = await page.goto('/einzeltraining/', { waitUntil: 'domcontentloaded' });

  expect(response, '/einzeltraining/ did not return a valid response.').not.toBeNull();
  expect(response?.ok(), `/einzeltraining/ returned HTTP ${response?.status()}.`).toBeTruthy();

  await waitForStablePage(page);

  await expect(page.getByRole('heading', { name: 'Einzeltraining mit Hund in Hamburg – nah an eurem Alltag' })).toBeVisible();
  await expect(page.getByText('Wer mit einem Hund in Hamburg lebt, kennt die kleinen Herausforderungen des Alltags.')).toBeVisible();

  const topicsSection = page.locator('section').filter({
    has: page.getByRole('heading', { name: 'Typische Themen im Einzeltraining' })
  });

  await expect(topicsSection).toHaveCount(1);

  for (const [href, textFragment] of einzeltrainingAnchors) {
    const link = topicsSection.locator(`a[href="${href}"]`);
    await expect(link).toHaveCount(1);
    await expect(link).toContainText(textFragment);
  }
});

test.describe('FAQ page', () => {
  test('all expected FAQ topic ids are unique', async ({ page }) => {
    const response = await page.goto('/faq/', { waitUntil: 'domcontentloaded' });

    expect(response, 'FAQ page did not return a valid response.').not.toBeNull();
    expect(response?.ok(), `FAQ page returned HTTP ${response?.status()}.`).toBeTruthy();

    await waitForStablePage(page);

    for (const id of faqTopicIds) {
      await expect(page.locator(`#${id}`)).toHaveCount(1);
    }

    const questionTexts = await page.locator('.faq-item .faq-question').allTextContents();
    expect(new Set(questionTexts).size).toBe(questionTexts.length);
  });

  test('deep links open the requested section and focus the heading', async ({ page }) => {
    for (const [hash, id] of [
      ['/faq/#ablauf-einzeltraining', 'ablauf-einzeltraining'],
      ['/faq/#hundebegegnungen', 'hundebegegnungen'],
      ['/faq/#leinenfuehrigkeit', 'leinenfuehrigkeit'],
      ['/faq/#rueckruf-unter-ablenkung', 'rueckruf-unter-ablenkung']
    ] as const) {
      await page.goto('/faq/', { waitUntil: 'domcontentloaded' });
      await page.goto(hash, { waitUntil: 'domcontentloaded' });

      await waitForStablePage(page);

      await expect(page.locator(`#${id}`)).toHaveCount(1);
      await expect(page.locator(`#${id} details`).first()).toHaveAttribute('open', '');

      const anchorPositionIsSafe = await page.locator(`#${id}`).evaluate((element) => {
        const rect = element.getBoundingClientRect();
        const header = document.querySelector('.site-header');
        const headerRect = header ? header.getBoundingClientRect() : { bottom: 0 };

        return rect.top >= headerRect.bottom - 8;
      });

      expect(anchorPositionIsSafe).toBeTruthy();

      await expect.poll(async () => {
        return await page.evaluate(() => document.activeElement?.id ?? document.activeElement?.tagName ?? '');
      }).toBe(`faq-topic-${id}`);
    }
  });

  test('hash navigation updates the URL and keeps multiple FAQ items open', async ({ page }) => {
    const response = await page.goto('/faq/', { waitUntil: 'domcontentloaded' });

    expect(response, 'FAQ page did not return a valid response.').not.toBeNull();
    expect(response?.ok(), `FAQ page returned HTTP ${response?.status()}.`).toBeTruthy();

    await waitForStablePage(page);

    await page.locator('.faq-topics-nav__link[href="#alleinbleiben"]').click();
    await expect(page).toHaveURL(/#alleinbleiben$/);
    await expect(page.locator('#alleinbleiben details').first()).toHaveAttribute('open', '');

    await page.locator('#grenzen-setzen details summary').first().click();
    await expect(page.locator('#grenzen-setzen details').first()).toHaveAttribute('open', '');
    await expect(page.locator('#alleinbleiben details').first()).toHaveAttribute('open', '');
  });

  test('browser history works with hash navigation', async ({ page }) => {
    const response = await page.goto('/faq/', { waitUntil: 'domcontentloaded' });

    expect(response, 'FAQ page did not return a valid response.').not.toBeNull();
    expect(response?.ok(), `FAQ page returned HTTP ${response?.status()}.`).toBeTruthy();

    await waitForStablePage(page);

    await page.locator('.faq-topics-nav__link[href="#rueckruf-unter-ablenkung"]').click();
    await expect(page).toHaveURL(/#rueckruf-unter-ablenkung$/);

    await page.goBack();
    await expect(page).toHaveURL(/\/faq\/$/);

    await page.goForward();
    await expect(page).toHaveURL(/#rueckruf-unter-ablenkung$/);
    await expect(page.locator('#rueckruf-unter-ablenkung details').first()).toHaveAttribute('open', '');
  });

  test('reduced motion keeps animations disabled', async ({ page }) => {
    await page.emulateMedia({ reducedMotion: 'reduce' });

    const response = await page.goto('/faq/#grenzen-setzen', { waitUntil: 'domcontentloaded' });

    expect(response, 'FAQ page did not return a valid response.').not.toBeNull();
    expect(response?.ok(), `FAQ page returned HTTP ${response?.status()}.`).toBeTruthy();

    await waitForStablePage(page);

    const transitionDuration = await page.locator('#grenzen-setzen details').first().locator('.faq-answer').evaluate((element) => {
      return getComputedStyle(element).transitionDuration;
    });

    expect(transitionDuration).toBe('0s');
  });

  test('FAQ remains accessible without JavaScript', async ({ browser }, testInfo) => {
    const context = await browser.newContext({
      baseURL: testInfo.project.use.baseURL,
      javaScriptEnabled: false
    });
    const page = await context.newPage();

    const response = await page.goto('/faq/#aggressives-verhalten', { waitUntil: 'load' });

    expect(response, 'FAQ page did not return a valid response.').not.toBeNull();
    expect(response?.ok(), `FAQ page returned HTTP ${response?.status()}.`).toBeTruthy();

    await expect(page.locator('h1')).toHaveText('Häufige Fragen');
    await expect(page.locator('#aggressives-verhalten')).toBeVisible();

    await context.close();
  });
});
