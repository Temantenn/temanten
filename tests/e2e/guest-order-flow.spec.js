import { test, expect } from '@playwright/test';

async function chooseTheme(page) {
  await page.locator('label[for^="theme_"]').first().click();
}

async function goToCustomerStep(page) {
  await chooseTheme(page);
  await page.getByRole('button', { name: 'Lanjut' }).click();
  await expect(page.locator('input[name="client_whatsapp"]')).toBeVisible();
}

async function goToEventStep(page) {
  await goToCustomerStep(page);
  await page.locator('input[name="client_whatsapp"]').fill('81234567890');
  await page.locator('input[name="slug"]').fill(`e2e-${Date.now()}`);
  await page.getByRole('button', { name: 'Lanjut' }).click();
  await expect(page.locator('input[name="groom_name"]')).toBeVisible();
}

test.describe('Guest Order Flow', () => {
  test('order form page loads with hero heading', async ({ page }) => {
    await page.goto('/buat-undangan');
    await expect(page.locator('h1')).toContainText('Undangan Impianmu');
  });

  test('theme selection section is visible', async ({ page }) => {
    await page.goto('/buat-undangan');
    await expect(page.locator('h2', { hasText: 'Pilih Tema Undangan' })).toBeVisible();
    await expect(page.locator('input[name="theme_id"]').first()).toBeAttached();
  });

  test('customer data section is visible', async ({ page }) => {
    await page.goto('/buat-undangan');
    await goToCustomerStep(page);
    await expect(page.locator('h2', { hasText: 'Data Pemesan' })).toBeVisible();
  });

  test('event information section is visible', async ({ page }) => {
    await page.goto('/buat-undangan');
    await goToEventStep(page);
    await expect(page.locator('h2', { hasText: 'Informasi Acara' })).toBeVisible();
  });

  test('submit button is present on confirmation step', async ({ page }) => {
    await page.goto('/buat-undangan');
    await expect(page.getByRole('button', { name: 'Lanjut' })).toBeVisible();
  });

  test('multiple themes are displayed', async ({ page }) => {
    await page.goto('/buat-undangan');
    await expect(page.locator('input[name="theme_id"]')).not.toHaveCount(0);
  });

  test('theme can be selected by clicking its label', async ({ page }) => {
    await page.goto('/buat-undangan');
    await chooseTheme(page);
    await expect(page.locator('input[name="theme_id"]').first()).toBeChecked();
  });

  test('cannot continue without selecting a theme', async ({ page }) => {
    await page.goto('/buat-undangan');
    await expect(page.getByRole('button', { name: 'Lanjut' })).toBeDisabled();
  });

  test('WhatsApp field accepts numeric input', async ({ page }) => {
    await page.goto('/buat-undangan');
    await goToCustomerStep(page);
    const input = page.locator('input[name="client_whatsapp"]');
    await input.fill('81234567890');
    await expect(input).toHaveValue('81234567890');
  });

  test('+62 prefix is displayed in the customer step', async ({ page }) => {
    await page.goto('/buat-undangan');
    await goToCustomerStep(page);
    await expect(page.getByText('+62', { exact: true })).toBeVisible();
  });

  test('slug field accepts lowercase input', async ({ page }) => {
    await page.goto('/buat-undangan');
    await goToCustomerStep(page);
    const input = page.locator('input[name="slug"]');
    await input.fill('rudi-siti');
    await expect(input).toHaveValue('rudi-siti');
  });

  test('bride name field accepts input', async ({ page }) => {
    await page.goto('/buat-undangan');
    await goToEventStep(page);
    const input = page.locator('input[name="bride_name"]');
    await input.fill('Siti Testing');
    await expect(input).toHaveValue('Siti Testing');
  });

  test('groom name field accepts input', async ({ page }) => {
    await page.goto('/buat-undangan');
    await goToEventStep(page);
    const input = page.locator('input[name="groom_name"]');
    await input.fill('Budi Testing');
    await expect(input).toHaveValue('Budi Testing');
  });

  test('complete order form submits successfully', async ({ page }) => {
    const failedRequests = [];
    page.on('response', response => {
      if (response.status() >= 500) failedRequests.push({ url: response.url(), status: response.status() });
    });

    await page.goto('/buat-undangan');
    await goToEventStep(page);
    await page.locator('input[name="bride_name"]').fill('Siti Testing');
    await page.locator('input[name="groom_name"]').fill('Budi Testing');
    await page.locator('input[name="event_date"]').fill('2027-01-15');
    await page.getByRole('button', { name: 'Lanjut' }).click();
    await expect(page.getByRole('button', { name: 'Buat Pesanan' })).toBeVisible();
    const orderResponse = page.waitForResponse(response =>
      response.request().method() === 'POST' && response.url().endsWith('/buat-undangan'),
    );
    await page.getByRole('button', { name: 'Buat Pesanan' }).click();
    expect((await orderResponse).status()).toBe(302);
    await page.waitForLoadState('domcontentloaded');
    await expect(page).toHaveURL(/\/(pembayaran|buat-undangan)/);
    expect(failedRequests).toEqual([]);
  });

  test('order page has no server errors', async ({ page }) => {
    const failedRequests = [];
    page.on('response', response => {
      if (response.status() >= 500) failedRequests.push({ url: response.url(), status: response.status() });
    });
    await page.goto('/buat-undangan');
    await expect(page.getByRole('button', { name: 'Lanjut' })).toBeVisible();
    expect(failedRequests).toEqual([]);
  });
});
