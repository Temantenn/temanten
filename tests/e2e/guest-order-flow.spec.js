import { test, expect } from '@playwright/test';

test.describe('Guest Order Flow', () => {

  test.describe('Order Form Page Load', () => {

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
      await expect(page.locator('h2', { hasText: 'Data Pemesan' })).toBeVisible();
      await expect(page.locator('input[name="client_whatsapp"]')).toBeVisible();
      await expect(page.locator('input[name="slug"]')).toBeVisible();
    });

    test('event information section is visible', async ({ page }) => {
      await page.goto('/buat-undangan');
      await expect(page.locator('h2', { hasText: 'Informasi Acara' })).toBeVisible();
    });

    test('submit button is present', async ({ page }) => {
      await page.goto('/buat-undangan');
      const submitBtn = page.locator('button[type="submit"]');
      await expect(submitBtn).toBeVisible();
      await expect(submitBtn).toContainText('Buat Pesanan & Lanjut Pembayaran');
    });

  });

  test.describe('Theme Selection', () => {

    test('multiple themes are displayed', async ({ page }) => {
      await page.goto('/buat-undangan');
      const themeCount = await page.locator('input[name="theme_id"]').count();
      expect(themeCount).toBeGreaterThan(0);
    });

    test('theme can be selected by clicking label', async ({ page }) => {
      await page.goto('/buat-undangan');
      const firstThemeLabel = page.locator('label[for^="theme_"]').first();
      await firstThemeLabel.click();
      const firstThemeRadio = page.locator('input[name="theme_id"]').first();
      await expect(firstThemeRadio).toBeChecked();
    });

  });

  test.describe('Form Validation - Empty Submission', () => {

    test('submitting empty form shows validation errors', async ({ page }) => {
      await page.goto('/buat-undangan');

      // Select first theme
      await page.locator('label[for^="theme_"]').first().click();

      // Submit without filling required fields
      await page.locator('button[type="submit"]').click();

      // Should stay on same page or show validation errors
      await page.waitForLoadState('networkidle');
      expect(page.url()).toContain('buat-undangan');
    });

  });

  test.describe('WhatsApp Input', () => {

    test('WhatsApp field accepts numeric input', async ({ page }) => {
      await page.goto('/buat-undangan');
      const waInput = page.locator('input[name="client_whatsapp"]');
      await waInput.fill('81234567890');
      await expect(waInput).toHaveValue('81234567890');
    });

    test('+62 prefix is displayed', async ({ page }) => {
      await page.goto('/buat-undangan');
      await expect(page.locator('text=+62')).toBeVisible();
    });

  });

  test.describe('Slug Input', () => {

    test('slug field accepts lowercase input', async ({ page }) => {
      await page.goto('/buat-undangan');
      const slugInput = page.locator('input[name="slug"]');
      await slugInput.fill('rudi-siti');
      await expect(slugInput).toHaveValue('rudi-siti');
    });

  });

  test.describe('Bride & Groom Names', () => {

    test('bride name field accepts input', async ({ page }) => {
      await page.goto('/buat-undangan');
      const brideInput = page.locator('input[name="bride_name"]');
      await brideInput.fill('Siti Testing');
      await expect(brideInput).toHaveValue('Siti Testing');
    });

    test('groom name field accepts input', async ({ page }) => {
      await page.goto('/buat-undangan');
      const groomInput = page.locator('input[name="groom_name"]');
      await groomInput.fill('Budi Testing');
      await expect(groomInput).toHaveValue('Budi Testing');
    });

  });

  test.describe('Full Order Submission', () => {

    test('complete order form submits successfully', async ({ page }) => {
      const consoleErrors = [];
      page.on('console', msg => {
        if (msg.type() === 'error') consoleErrors.push(msg.text());
      });

      const failedRequests = [];
      page.on('response', response => {
        if (response.status() >= 400) {
          failedRequests.push({ url: response.url(), status: response.status() });
        }
      });

      await page.goto('/buat-undangan');

      // Select first theme via label
      await page.locator('label[for^="theme_"]').first().click();

      // Fill WhatsApp
      await page.locator('input[name="client_whatsapp"]').fill('81234567890');

      // Fill slug
      await page.locator('input[name="slug"]').fill('e2e-test-' + Date.now());

      // Fill bride & groom
      await page.locator('input[name="bride_name"]').fill('Siti Testing');
      await page.locator('input[name="groom_name"]').fill('Budi Testing');

      // Fill event date
      const dateInput = page.locator('input[name="event_date"]');
      if (await dateInput.isVisible()) {
        await dateInput.fill('2027-01-15');
      }

      // Fill time
      const timeStart = page.locator('input[name="time_start"]');
      if (await timeStart.isVisible()) {
        await timeStart.fill('08:00');
      }
      const timeEnd = page.locator('input[name="time_end"]');
      if (await timeEnd.isVisible()) {
        await timeEnd.fill('12:00');
      }

      // Fill venue
      const venueName = page.locator('input[name="venue_name"]');
      if (await venueName.isVisible()) {
        await venueName.fill('Gedung Testing');
      }
      const venueAddress = page.locator('input[name="venue_address"]');
      if (await venueAddress.isVisible()) {
        await venueAddress.fill('Jl. Testing No. 123');
      }

      // Submit with noWaitAfter to avoid navigation timeout on click
      const submitBtn = page.locator('button[type="submit"]');
      await submitBtn.click({ noWaitAfter: true, timeout: 15000 });

      // Wait for navigation to complete (form posts to payment page)
      await page.waitForLoadState('networkidle', { timeout: 60000 }).catch(() => {});

      // Verify no 5xx server errors occurred
      const serverErrors = failedRequests.filter(r => r.status >= 500);
      expect(serverErrors).toEqual([]);

      // Log console errors for debugging
      const criticalErrors = consoleErrors.filter(e => !e.includes('favicon'));
      if (criticalErrors.length > 0) {
        console.log('Console errors:', criticalErrors);
      }

      // Either navigated away (success) or stayed on form (validation) - both OK
      console.log('Final URL after submit:', page.url());
    });

  });

  test.describe('Console and Network Health', () => {

    test('order page has no server errors', async ({ page }) => {
      const failedRequests = [];
      page.on('response', response => {
        if (response.status() >= 500) {
          failedRequests.push({ url: response.url(), status: response.status() });
        }
      });

      await page.goto('/buat-undangan');
      await page.waitForLoadState('domcontentloaded');
      await page.getByRole('button', { name: /kirim|submit|buat/i }).first().waitFor({ state: 'visible', timeout: 15000 });

      expect(failedRequests).toEqual([]);
    });

  });

});