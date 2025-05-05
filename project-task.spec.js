const { test, expect } = require('@playwright/test');

test('User can mark a project task as completed', async ({ page }) => {
  await page.goto('http://localhost/f/a.php');

  // Select a career to load projects
  await page.locator('#careerSelect').selectOption({ index: 1 });

  const checkbox = page.locator('#projectsList input[type="checkbox"]').first();
  await expect(checkbox).toBeVisible();

  // Check the task
  await checkbox.check();
  await expect(checkbox).toBeChecked();
});
