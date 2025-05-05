<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Advanced Career Planner Pro</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .dark body { background-color: #1f2937; color: #f9fafb; }
    .dark header, .dark footer { background-color: #374151; color: #f9fafb; }
    .dark .bg-white { background-color: #374151 !important; }
    .dark .text-gray-800 { color: #f9fafb !important; }
    #toast { transition: opacity 0.4s ease, transform 0.4s ease; z-index: 50; transform: translateY(-10px); }
    #toast.show { opacity: 1; transform: translateY(0); }
    #toast.hide { opacity: 0; transform: translateY(-10px); }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 font-sans">
  <header class="bg-white dark:bg-gray-800 shadow p-4 sm:p-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
      <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-indigo-700 dark:text-indigo-300 text-center sm:text-left">🚀 Advanced Career Planner Pro</h1>
      <div class="flex flex-wrap justify-center sm:justify-end gap-2">
        <button id="darkModeToggle" class="bg-gray-200 dark:bg-gray-700 text-sm px-4 py-2 rounded hover:bg-gray-300 dark:hover:bg-gray-600">Toggle Dark Mode</button>
        <button id="exportBtn" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700">Export</button>
        <label for="importInput" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded cursor-pointer hover:bg-indigo-700">Import</label>
        <input type="file" id="importInput" class="hidden" />
      </div>
    </div>
  </header>
  <!-- HEADER -->
  <section class="max-w-7xl mx-auto px-4 mt-4 text-center">
    <h2 class="text-xl sm:text-2xl font-semibold text-indigo-700 dark:text-indigo-300">Plan & Track Your IT Career</h2>
    <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">Select a path, explore required skills, and track your progress.</p>
  </section>

  <!-- SUMMARY SECTION -->
  <section class="max-w-7xl mx-auto mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 px-4">
    <div class="bg-indigo-100 dark:bg-indigo-700 p-5 rounded-2xl shadow">
      <h3 class="text-sm text-gray-500 dark:text-gray-300 mb-1">Selected Career</h3>
      <p id="summaryCareer" class="text-lg font-semibold text-indigo-700 dark:text-indigo-200">-</p>
    </div>
    <div class="bg-green-100 dark:bg-green-700 p-5 rounded-2xl shadow">
      <h3 class="text-sm text-gray-500 dark:text-gray-300 mb-1">Skills Completed</h3>
      <p id="summarySkills" class="text-lg font-semibold text-green-600 dark:text-green-200">0</p>
    </div>
    <div class="bg-blue-100 dark:bg-blue-700 p-5 rounded-2xl shadow">
      <h3 class="text-sm text-gray-500 dark:text-gray-300 mb-1">Total Skills</h3>
      <p id="summaryTotalSkills" class="text-lg font-semibold text-blue-600 dark:text-blue-200">0</p>
    </div>
    <div class="bg-yellow-100 dark:bg-yellow-700 p-5 rounded-2xl shadow">
      <h3 class="text-sm text-gray-500 dark:text-gray-300 mb-1">Days Left</h3>
      <p id="summaryDaysLeft" class="text-lg font-semibold text-yellow-600 dark:text-yellow-200">-</p>
    </div>
  </section>
  
  <!-- CAREER SELECTION SECTION -->
  <section class="max-w-7xl mx-auto mt-10 px-4">
    <label class="block mb-2 font-semibold text-lg text-gray-800 dark:text-gray-100">🎯 Select Your Desired Career Path:</label>
    <select id="careerSelect" class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
      <option value="">-- Choose a Career Path --</option>
    </select>
  </section>

  <!-- AI ASSISTANT SECTION -->
  <section class="max-w-7xl mx-auto mt-10 px-4 hidden" id="aiSection">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">🤖 Ask AI about Your Career</h2>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex flex-col md:flex-row gap-4">
      <input type="text" id="aiQuestion" class="flex-1 p-3 rounded border border-gray-300 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Ask something about your career...">
      <button id="askAiBtn" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Ask AI</button>
    </div>
    <div id="aiResponse" class="mt-4 text-sm text-gray-800 dark:text-gray-200"></div>
  </section>
 
  <!-- SKILL ROADMAP SECTION -->
  <section class="max-w-7xl mx-auto mt-10 px-4 hidden" id="roadmapSection">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">🎓 Career Skills Roadmap</h2>
    <div class="mb-4">
      <label for="skillSearch" class="block mb-2 font-semibold">Search Skills</label>
      <input type="text" id="skillSearch" placeholder="Type to filter skills..." class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
    </div>
    <div class="flex flex-wrap gap-2" id="skillsContainer"></div>
    <div class="mt-4">
      <button id="addCustomSkillBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Custom Skill</button>
    </div>
  </section>

  <!-- COMPLETED SKILLS SECTION -->
  <section class="max-w-7xl mx-auto mt-10 px-4 hidden" id="completedSection">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">✅ Completed Skills</h2>
    <div class="flex flex-wrap gap-2 bg-green-100 dark:bg-green-900 p-4 rounded" id="completedSkills"></div>
    <button id="clearSkillsBtn" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Clear Completed Skills</button>
  </section>

  <!-- PROJECTS SECTION -->
  <section id="projectsSection" class="max-w-7xl mx-auto mt-10 px-4 hidden">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">💡 Recommended Projects</h2>
    <div id="projectsList" class="space-y-4"></div>
  </section>

  <!-- GOAL SETTING SECTION -->
  <section class="max-w-7xl mx-auto mt-10 px-4 hidden" id="goalSection">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">🎯 Learning Goal</h2>
    <input type="number" id="goalInput" placeholder="Days to finish..." class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
    <div class="flex flex-col sm:flex-row gap-2 mt-3">
      <button id="setGoalBtn" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Set Goal</button>
      <button id="resetGoalBtn" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Reset Goal</button>
    </div>
    <p id="goalDisplay" class="mt-3 text-gray-800 dark:text-gray-200"></p>
    <p id="countdownDisplay" class="text-indigo-600 dark:text-indigo-300 font-medium"></p>
  </section>
  
  <!-- RESOURCES SECTION -->
  <section class="max-w-7xl mx-auto mt-10 px-4 hidden" id="resourcesSection">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">📚 Recommended Resources</h2>
    <ul id="resourceList" class="list-disc pl-6 text-gray-700 dark:text-gray-300"></ul>
  </section>

   <!-- PROGRESS CHART SECTION -->
  <section class="max-w-7xl mx-auto mt-10 px-4">
  <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800 dark:text-white">📊 Progress Chart</h2>
  <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
    <div class="relative w-full aspect-square max-w-xs sm:max-w-md mx-auto">
      <canvas id="progressChart" class="w-full h-full"></canvas>
      <div id="progressCenterLabel" class="absolute inset-0 flex items-center justify-center text-lg sm:text-2xl font-semibold text-gray-800 dark:text-gray-100 text-center px-2"></div>
    </div>
  </div>
</section>
  <!-- FOOTER -->
  <div id="toast" class="fixed top-6 right-6 bg-green-600 text-white px-4 py-2 rounded shadow-lg text-sm opacity-0 pointer-events-none"></div>
  <footer class="bg-white dark:bg-gray-800 shadow mt-16 py-6">
    <div class="container mx-auto text-center text-gray-500 dark:text-gray-400">
      <p class="text-sm">&copy; 2025 Advanced Career Planner Pro. All rights reserved.</p>
    </div>
  </footer>

  <!-- MAIN SCRIPT -->
  <script>

  // Define global state
  let careerAPIData = {};
  let completedSkills = JSON.parse(localStorage.getItem("completedSkills")) || [];
  let customSkills = JSON.parse(localStorage.getItem("customSkills")) || {};
  let learningGoalDays = parseInt(localStorage.getItem("learningGoalDays")) || 0;
  let learningGoalSetDate = parseInt(localStorage.getItem("learningGoalSetDate")) || 0;
  let projectProgress = JSON.parse(localStorage.getItem("projectProgress")) || {};
  let chartInstance = null;

  // Load JSON Data
  fetch("./careerData.json")
    .then(res => res.json())
    .then(data => {
      careerAPIData = data;
      populateCareerDropdown();
    });

    function populateCareerDropdown() {
  const sel = document.getElementById("careerSelect");
  for (const careerKey in careerAPIData) {
    const opt = document.createElement("option");
    opt.value = careerKey;
    opt.textContent = careerAPIData[careerKey].displayName || careerKey;
    sel.appendChild(opt);
  }

  // After populating the dropdown, restore previous selection
  const lastCareer = localStorage.getItem("lastCareer");
if (lastCareer) {
  $("#careerSelect").val(lastCareer).trigger("change");
}

}


  // Career Selection Handler
  $("#careerSelect").on("change", function () {
    const val = $(this).val();
    if (val) {
      $("#summaryCareer").text(careerAPIData[val].displayName || val);
      $("#roadmapSection, #completedSection, #goalSection, #projectsSection, #aiSection").removeClass("hidden");
      renderSkills(val);
      renderProjects(val);
      renderResources(val);
      updateSkillSummary(val);
      updateProgressChart(val);
    } else {
      $("#summaryCareer").text("-");
    }
  });

  // Skill rendering & drag-drop
  function renderSkills(careerKey) {
    const container = $("#skillsContainer");
    container.empty();
    const career = careerAPIData[careerKey];
    career.skills.forEach((sk) => {
      container.append(`<div class="skill-item p-2 bg-blue-500 text-white rounded cursor-pointer" title="${sk.info}" draggable="true">${sk.name}</div>`);
    });

    if (customSkills[careerKey]) {
      customSkills[careerKey].forEach((sk) => {
        container.append(`<div class="skill-item p-2 bg-blue-400 text-white rounded cursor-pointer" title="Custom Skill" draggable="true">${sk}</div>`);
      });
    }

    enableDragDrop();
  }

  function enableDragDrop() {
    $(".skill-item").on("dragstart", function (e) {
      e.originalEvent.dataTransfer.setData("text/plain", $(this).text());
    });

    $("#completedSkills").on("dragover", function (e) { e.preventDefault(); });
    $("#completedSkills").on("drop", function (e) {
      e.preventDefault();
      const skillName = e.originalEvent.dataTransfer.getData("text/plain");
      if (!completedSkills.includes(skillName)) {
        completedSkills.push(skillName);
        localStorage.setItem("completedSkills", JSON.stringify(completedSkills));
        $(this).append(`<div class="p-2 bg-green-600 text-white rounded">${skillName}</div>`);
        showToast("Skill marked as completed!");
        updateSkillSummary($("#careerSelect").val());
        updateProgressChart($("#careerSelect").val());
      }
    });

    $("#completedSection").removeClass("hidden");
  }
  // Summary update
  function updateSkillSummary(careerKey) {
    const totalSkills = careerAPIData[careerKey].skills.length + (customSkills[careerKey]?.length || 0);
    $("#summarySkills").text(completedSkills.length);
    $("#summaryTotalSkills").text(totalSkills);
  }
  // Progress chart update
  function updateProgressChart(careerKey) {
  const ctx = document.getElementById("progressChart").getContext("2d");

  const totalSkills = careerAPIData[careerKey]?.skills.length + (customSkills[careerKey]?.length || 0) || 0;
  const completed = completedSkills.length;
  const remaining = totalSkills - completed;
  const percentage = totalSkills > 0 ? Math.round((completed / totalSkills) * 100) : 0;

  // Update the center label in the chart
  $("#progressCenterLabel").text(`${percentage}%`);

  if (chartInstance) chartInstance.destroy();

  chartInstance = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Completed', 'Remaining'],
      datasets: [{
        label: 'Skill Progress',
        data: [completed, remaining],
        backgroundColor: ['#10B981', '#E5E7EB'], // Green & Light Gray
        borderWidth: 4,
        borderColor: '#ffffff',
        hoverOffset: 10,
        cutout: '70%',
        radius: '90%'
      }]
    },
    options: {
      responsive: true,
      animation: {
        animateRotate: true,
        duration: 1000, // 1 second animation duration
        easing: 'easeOutBounce' // Smooth bounce effect
      },
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#374151',
            font: {
              size: 14,
              weight: '500'
            }
          }
        },
        tooltip: {
          backgroundColor: '#111827',
          titleColor: '#F9FAFB',
          bodyColor: '#F9FAFB',
          borderColor: '#374151',
          borderWidth: 1
        }
      }
    }
  });
}
// Goal setting & countdown
$("#setGoalBtn").on("click", function () {
  const days = parseInt($("#goalInput").val());
  if (days > 0) {
    learningGoalDays = days;
    learningGoalSetDate = Date.now();
    localStorage.setItem("learningGoalDays", learningGoalDays);
    localStorage.setItem("learningGoalSetDate", learningGoalSetDate);
    updateGoalCountdown();
  } else {
    // If invalid, reset values
    learningGoalDays = 0;
    learningGoalSetDate = 0;
    localStorage.removeItem("learningGoalDays");
    localStorage.removeItem("learningGoalSetDate");
    $("#goalDisplay").text("Please enter a valid number of days.");
    $("#countdownDisplay").text("");
    $("#summaryDaysLeft").text("-");
  }
});
// Reset Goal Button Handler
$("#resetGoalBtn").on("click", function () {
  learningGoalDays = 0;
  learningGoalSetDate = 0;
  localStorage.removeItem("learningGoalDays");
  localStorage.removeItem("learningGoalSetDate");
  $("#goalDisplay").text("No goal set.");
  $("#countdownDisplay").text("");
  $("#summaryDaysLeft").text("-");
});



// Accurate Countdown Updater
function updateGoalCountdown() {
  const now = Date.now();
  const daysPassed = Math.floor((now - learningGoalSetDate) / (1000 * 60 * 60 * 24));
  const daysLeft = learningGoalDays - daysPassed;

  let displayText = "";
  let summaryDays = "-";

  if (learningGoalDays > 0 && learningGoalSetDate > 0) {
    if (daysLeft > 0) {
      displayText = `${daysLeft} day(s) left`;
      summaryDays = daysLeft;
    } else if (daysLeft === 0) {
      displayText = "Today is your final day!";
      summaryDays = "0";
    } else {
      displayText = `Deadline passed ${Math.abs(daysLeft)} day(s) ago`;
      summaryDays = "0"; // Or leave it as "-", your choice
    }
  } else {
    displayText = "No goal set.";
    summaryDays = "-";
  }

  $("#goalDisplay").text(learningGoalDays > 0 ? `Goal: Finish in ${learningGoalDays} days.` : "No goal set.");
  $("#countdownDisplay").text(displayText);
  $("#summaryDaysLeft").text(summaryDays);
}

  // Add Custom Skill
  $("#addCustomSkillBtn").on("click", function () {
    const skName = prompt("Enter a custom skill name:");
    if (!skName || !skName.trim()) return;
    const key = $("#careerSelect").val();
    customSkills[key] = customSkills[key] || [];
    if (!customSkills[key].includes(skName)) {
      customSkills[key].push(skName);
      localStorage.setItem("customSkills", JSON.stringify(customSkills));
      renderSkills(key);
    } else {
      alert("Skill already exists.");
    }
  });

  //export handlers
  document.getElementById("exportBtn").addEventListener("click", () => {
  const selectedCareer = $("#careerSelect").val(); // Save selected career
  const goalDateTimestamp = parseInt(localStorage.getItem("learningGoalSetDate")) || 0;
  const formattedDate = goalDateTimestamp
    ? new Date(goalDateTimestamp).toLocaleString("en-GB") // or use toISOString()
    : "";

  const data = {
    completedSkills: JSON.parse(localStorage.getItem("completedSkills")) || [],
    customSkills: JSON.parse(localStorage.getItem("customSkills")) || {},
    learningGoalDays: parseInt(localStorage.getItem("learningGoalDays")) || 0,
    learningGoalSetDate: goalDateTimestamp,
    learningGoalSetDateFormatted: formattedDate,
    selectedCareer: selectedCareer || ""
  };

  const blob = new Blob([JSON.stringify(data, null, 2)], { type: "application/json" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "careerPlannerBackup.json";
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
  showToast("Progress Exported!");
});


// Import handlers
$("#importInput").on("change", function (e) {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();

  reader.onload = function (evt) {
  try {
    const data = JSON.parse(evt.target.result);

    if (data.completedSkills && data.customSkills) {
      localStorage.setItem("completedSkills", JSON.stringify(data.completedSkills));
      localStorage.setItem("customSkills", JSON.stringify(data.customSkills));
      localStorage.setItem("learningGoalDays", data.learningGoalDays || 0);
      localStorage.setItem("learningGoalSetDate", data.learningGoalSetDate || 0);

      // ✅ Save selected career (this is missing in your version)
      if (data.selectedCareer) {
        localStorage.setItem("lastCareer", data.selectedCareer); // use same key your app expects
      }

      showToast("Imported successfully! Refreshing...");
      setTimeout(() => {
        location.reload(); // make sure reload happens *after* everything is saved
      }, 1200);
    } else {
      showToast("Invalid file format.");
    }
  } catch (err) {
    showToast("Error reading the file.");
  }
};


  reader.readAsText(file);
});



// Toast
function showToast(msg) {
  const toast = document.getElementById("toast");
  toast.textContent = msg;
  toast.classList.remove("opacity-0", "pointer-events-none");
  toast.classList.add("show");
  setTimeout(() => {
    toast.classList.add("opacity-0", "pointer-events-none");
    toast.classList.remove("show");
  }, 2000);
}

  // clear skills button
  $("#clearSkillsBtn").on("click", function () {
  completedSkills = [];
  localStorage.removeItem("completedSkills");
  
  // Optional: also reset custom skills if you want
  customSkills = {};
  localStorage.removeItem("customSkills");

  $("#completedSkills").empty();
  renderSkills($("#careerSelect").val()); // Reset skill list
  updateSkillSummary($("#careerSelect").val());
  updateProgressChart($("#careerSelect").val());
  showToast("Skills & custom entries cleared.");
});

$("#importInput").on("change", function (e) {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();

  reader.onload = function (evt) {
    try {
      const data = JSON.parse(evt.target.result);

      // Validate required keys
      if (data.completedSkills && data.customSkills) {
        localStorage.setItem("completedSkills", JSON.stringify(data.completedSkills));
        localStorage.setItem("customSkills", JSON.stringify(data.customSkills));
        localStorage.setItem("learningGoalDays", data.learningGoalDays || 0);
        localStorage.setItem("learningGoalSetDate", data.learningGoalSetDate || 0);

        showToast("Imported successfully! Refreshing...");
        setTimeout(() => {
          location.reload(); // Force reload to reflect changes across dropdown/UI
        }, 1500);
      } else {
        showToast("Invalid file format. Make sure you're importing the correct backup.");
      }
    } catch (err) {
      console.error("Import error:", err);
      showToast("Failed to read file. Please try again.");
    }
  };

  reader.readAsText(file);
});


  // Dark Mode Toggle
  $("#darkModeToggle").on("click", function () {
    document.documentElement.classList.toggle("dark");
    localStorage.setItem("darkMode", document.documentElement.classList.contains("dark"));
  });

  // Toast Message
  function showToast(msg) {
    $("#toast").text(msg).removeClass("opacity-0 pointer-events-none").addClass("show");
    setTimeout(() => {
      $("#toast").addClass("opacity-0 pointer-events-none").removeClass("show");
    }, 2000);
  } 
  // Render Resources
function renderResources(careerKey) {
  const data = careerAPIData[careerKey];
  const list = $("#resourceList");
  list.empty();
  if (data && data.resources) {
    data.resources.forEach((res) => {
      list.append(`<li><a href="${res.url}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">${res.title}</a></li>`);
    });
    $("#resourcesSection").removeClass("hidden");
  }
}

// Update renderProjects function
function renderProjects(careerKey) {
      const data = careerAPIData[careerKey];
      const container = $("#projectsList");
      container.empty();

      if (data && data.projects && data.projects.length > 0) {
        data.projects.forEach((proj) => {
          const wrap = $("<div>").addClass("p-4 border rounded bg-white dark:bg-gray-800 shadow");
          wrap.append(`<h3 class="text-lg font-semibold mb-1">${proj.title}</h3>`);
          if (proj.description) {
            wrap.append(`<p class="text-sm text-gray-600 dark:text-gray-300 mb-2">${proj.description}</p>`);
          }
          const ul = $("<ul>").addClass("list-disc ml-6");
          proj.tasks.forEach((task, idx) => {
            const li = $("<li>");
            const key = `${careerKey}_${proj.title}`;
            const isChecked = projectProgress[key]?.includes(idx);
            const checkbox = $("<input type='checkbox'>").prop("checked", isChecked);
            checkbox.on("change", () => updateProjectTaskProgress(careerKey, proj.title, idx, checkbox.prop("checked")));
            li.append(checkbox).append(` ${task}`);
            ul.append(li);
          });
          wrap.append(ul);
          container.append(wrap);
        });
        $("#projectsSection").removeClass("hidden");
      }
    }
    
    function updateProjectTaskProgress(careerKey, projectTitle, taskIdx, isChecked) {
  const key = `${careerKey}_${projectTitle}`;
  projectProgress[key] = projectProgress[key] || [];

  if (isChecked) {
    if (!projectProgress[key].includes(taskIdx)) {
      projectProgress[key].push(taskIdx);
    }
  } else {
    projectProgress[key] = projectProgress[key].filter((i) => i !== taskIdx);
  }

  // Save to localStorage
  localStorage.setItem("projectProgress", JSON.stringify(projectProgress));

  // 🔥 Refresh the chart to show updated progress
  updateProgressChart(careerKey);
}


  //Update Progress Chart
  function updateProgressChart(careerKey) {
  const ctx = document.getElementById("progressChart").getContext("2d");

  const totalSkills = careerAPIData[careerKey]?.skills.length + (customSkills[careerKey]?.length || 0) || 0;
  const completedSkillsCount = completedSkills.length;
  const remainingSkills = totalSkills - completedSkillsCount;
  const skillPercent = totalSkills > 0 ? Math.round((completedSkillsCount / totalSkills) * 100) : 0;

  // 🔸 Project Completion Calculation
  const totalProjects = careerAPIData[careerKey]?.projects?.length || 0;
  let completedProjects = 0;
  careerAPIData[careerKey]?.projects?.forEach((proj) => {
    const key = `${careerKey}_${proj.title}`;
    const completedTasks = projectProgress[key]?.length || 0;
    if (completedTasks === proj.tasks.length) completedProjects++;
  });
  const projectPercent = totalProjects > 0 ? Math.round((completedProjects / totalProjects) * 100) : 0;

  // 🏷 Update Center Label
  $("#progressCenterLabel").html(`
    <div class="text-center">
      <div class="text-2xl font-bold">${skillPercent}%</div>
      <div class="text-xs text-gray-500 dark:text-gray-300">Skills</div>
      <div class="text-sm font-medium mt-1">${projectPercent}% Projects</div>
    </div>
  `);

  if (chartInstance) chartInstance.destroy();

  chartInstance = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Completed Skills', 'Remaining Skills'],
      datasets: [{
        label: 'Skill Progress',
        data: [completedSkillsCount, remainingSkills],
        backgroundColor: ['#10B981', '#E5E7EB'],
        borderWidth: 4,
        borderColor: '#ffffff',
        hoverOffset: 10,
        cutout: '70%',
        radius: '90%'
      }]
    },
    options: {
      responsive: true,
      animation: {
        animateRotate: true,
        duration: 1000,
        easing: 'easeOutBounce'
      },
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#374151',
            font: {
              size: 14,
              weight: '500'
            }
          }
        },
        tooltip: {
          backgroundColor: '#111827',
          titleColor: '#F9FAFB',
          bodyColor: '#F9FAFB',
          borderColor: '#374151',
          borderWidth: 1
        }
      }
    }
  });
}

// AI Question submission
$("#askAiBtn").on("click", function () {
  const question = $("#aiQuestion").val().trim();
  const aiResp = $("#aiResponse");

  if (!question) {
    aiResp.text("Please enter a question.");
    return;
  }

  aiResp.text("Thinking...");

  fetch("askAI.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ question })
  })
    .then((resp) => {
      if (!resp.ok) throw new Error("Server error: " + resp.status);
      return resp.json();
    })
    .then((data) => {
      const aiAnswer = data?.answer || "(No response)";
      aiResp.html(`
        <p><strong>Your Question:</strong><br>${question}</p>
        <p><strong>AI Response:</strong><br>${aiAnswer}</p>
      `);
    })
    .catch((err) => {
      aiResp.text("AI Error: " + err.message);
    });
});



</script>
</body>
</html>
