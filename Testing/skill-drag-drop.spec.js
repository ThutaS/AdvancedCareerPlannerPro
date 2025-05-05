const { test, expect } = require('@playwright/test');

test('Skill card appears in Completed Skills after drag-drop', async ({ page }) => {
  await page.goto('http://localhost/f/a.php');

  // Select a career
  await page.locator('#careerSelect').selectOption({ index: 1 });

  // Grab the first skill card and its text
  const skill = page.locator('#skillsContainer .skill-item').first();
  const skillText = await skill.innerText();

  // Use JS to manually simulate drag/drop DOM events
  await page.evaluate(() => {
    const skill = document.querySelector('#skillsContainer .skill-item');
    const target = document.querySelector('#completedSkills');
    if (!skill || !target) return;

    const dataTransfer = new DataTransfer();

    const dragStartEvent = new DragEvent('dragstart', {
      bubbles: true,
      cancelable: true,
      dataTransfer
    });

    const dragOverEvent = new DragEvent('dragover', {
      bubbles: true,
      cancelable: true,
      dataTransfer
    });

    const dropEvent = new DragEvent('drop', {
      bubbles: true,
      cancelable: true,
      dataTransfer
    });

    skill.dispatchEvent(dragStartEvent);
    target.dispatchEvent(dragOverEvent);
    target.dispatchEvent(dropEvent);
  });

  await page.waitForTimeout(1000); // wait for DOM update

  // ✅ Assert the skill appears in the completed section
  const completed = await page.locator('#completedSkills').innerText();
  expect(completed).toContain(skillText.trim());
});
