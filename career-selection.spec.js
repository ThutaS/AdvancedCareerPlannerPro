const { test, expect } = require('@playwright/test');

test('Career selection shows skills, projects, and AI section', async ({ page }) => {
  await page.goto('http://localhost/f/a.php', { waitUntil: 'domcontentloaded' });

  // Confirm the dropdown is visible
  const dropdown = page.locator('#careerSelect');
  await expect(dropdown).toBeVisible();

  // Select the first available career option (index 1 skips the placeholder)
  await dropdown.selectOption({ index: 1 });

  // Check that summary is updated
  const summary = page.locator('#summaryCareer');
  await expect(summary).not.toHaveText('-');

  // Check that skills section becomes visible
  await expect(page.locator('#roadmapSection')).toBeVisible();

  // Check at least one skill card appears
  await expect(page.locator('#skillsContainer .skill-item').first()).toBeVisible();

  // Check that AI section appears
  await expect(page.locator('#aiSection')).toBeVisible();

  // Check that Projects section appears
  await expect(page.locator('#projectsSection')).toBeVisible();

  // Check that Goal section appears
  await expect(page.locator('#goalSection')).toBeVisible();
});
