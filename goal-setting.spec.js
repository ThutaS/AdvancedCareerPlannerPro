const { test, expect } = require('@playwright/test');

test('User can set a learning goal and see countdown', async ({ page }) => {
  await page.goto('http://localhost/f/a.php');

  // Select a career to reveal the goal section
  await page.locator('#careerSelect').selectOption({ index: 1 });

  await page.fill('#goalInput', '5');
  await page.click('#setGoalBtn');

  // Verify countdown and display updates
  await expect(page.locator('#goalDisplay')).toContainText('Goal: Finish in 5 days');
  await expect(page.locator('#countdownDisplay')).not.toHaveText('');
});
