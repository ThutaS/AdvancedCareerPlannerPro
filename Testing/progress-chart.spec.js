const { test, expect } = require('@playwright/test');

test('Progress chart updates after skill completion', async ({ page }) => {
  await page.goto('http://localhost/f/a.php');

  // Select a career
  await page.locator('#careerSelect').selectOption({ index: 1 });

  // Simulate adding one skill to completed
  const skill = page.locator('#skillsContainer .skill-item').first();
  const completed = page.locator('#completedSkills');

  await skill.dispatchEvent('dragstart');
  await completed.dispatchEvent('dragover');
  await completed.dispatchEvent('drop');

  // Check that the center progress percentage label updates
  const label = page.locator('#progressCenterLabel');
  await expect(label).not.toHaveText('0%');
});
