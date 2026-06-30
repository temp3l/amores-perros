import { defineConfig, devices } from '@playwright/test';
import fs from 'node:fs';
import path from 'node:path';

function readDotEnvFile(filePath: string): Record<string, string> {
  if (!fs.existsSync(filePath)) {
    return {};
  }

  const entries: Record<string, string> = {};
  const content = fs.readFileSync(filePath, 'utf8');

  for (const line of content.split(/\r?\n/)) {
    const trimmed = line.trim();
    if (!trimmed || trimmed.startsWith('#')) {
      continue;
    }

    const separatorIndex = trimmed.indexOf('=');
    if (separatorIndex === -1) {
      continue;
    }

    const key = trimmed.slice(0, separatorIndex).trim();
    const value = trimmed.slice(separatorIndex + 1).trim();
    entries[key] = value;
  }

  return entries;
}

const repoRoot = __dirname;
const envFile = path.join(repoRoot, '.env');
const env = readDotEnvFile(envFile);
const baseURL = process.env.WORDPRESS_URL || env.WORDPRESS_URL || 'http://localhost:8080';

export default defineConfig({
  testDir: path.join(repoRoot, 'tests', 'visual'),
  fullyParallel: false,
  forbidOnly: !!process.env.CI,
  retries: 0,
  timeout: 60000,
  expect: {
    timeout: 15000
  },
  reporter: [
    ['list'],
    ['html', { open: 'never', outputFolder: path.join(repoRoot, 'artifacts', 'visual', 'report') }],
    ['json', { outputFile: path.join(repoRoot, 'artifacts', 'visual', 'report', 'results.json') }]
  ],
  outputDir: path.join(repoRoot, 'artifacts', 'visual', 'test-results'),
  snapshotPathTemplate: path.join(repoRoot, 'tests', 'visual', 'baselines', '{projectName}', '{arg}{ext}'),
  use: {
    baseURL,
    trace: 'retain-on-failure',
    screenshot: 'only-on-failure'
  },
  projects: [
    {
      name: 'desktop',
      use: {
        browserName: 'chromium',
        viewport: { width: 1440, height: 900 },
        colorScheme: 'light'
      }
    },
    {
      name: 'mobile',
      use: {
        ...devices['Pixel 5'],
        browserName: 'chromium',
        viewport: { width: 390, height: 844 },
        colorScheme: 'light'
      }
    }
  ]
});
