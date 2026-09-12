import { defineConfig, devices } from '@playwright/test';

const baseURL = process.env.PLAYWRIGHT_BASE_URL || 'http://127.0.0.1:8000';

export default defineConfig({
  testDir: './tests/e2e',
  timeout: 45_000,
  expect: {
    timeout: 15_000,
  },
  fullyParallel: true,
  workers: process.env.CI ? 2 : 4,
  retries: 0,
  reporter: [['list'], ['html', { open: 'never' }]],
  webServer: process.env.PLAYWRIGHT_BASE_URL ? undefined : {
    command: 'php artisan serve --host=127.0.0.1 --port=8000',
    url: 'http://127.0.0.1:8000/up',
    reuseExistingServer: !process.env.CI,
    timeout: 120_000,
  },
  use: {
    baseURL,
    headless: process.env.PW_HEADLESS !== 'false',
    viewport: { width: 1366, height: 768 },
    actionTimeout: 15_000,
    navigationTimeout: 20_000,
    screenshot: 'only-on-failure',
    video: 'retain-on-failure',
    trace: 'retain-on-failure',
  },
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },
  ],
});
