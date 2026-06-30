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
