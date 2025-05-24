let startTime, timerInterval;
let totalFocusedTime = 0;
let isWindowFocused = true;
let sessionDuration = 0; // in seconds

function toggleTheme() {
  const isDark = document.getElementById("theme-toggle").checked;
  document.body.classList.toggle("dark", isDark);
  localStorage.setItem("theme", isDark ? "dark" : "light");
}

function startSession() {
  const task = document.getElementById("task-name").value.trim();
  if (!task) return alert("Please enter a task name.");

  const durationSelect = document.getElementById("session-duration");
  sessionDuration = parseInt(durationSelect.value);

  document.getElementById("current-task").innerText = task;
  document.getElementById("session").style.display = "block";
  document.getElementById("summary").style.display = "none";

  startTime = Date.now();
  totalFocusedTime = 0;
  isWindowFocused = true;

  timerInterval = setInterval(updateStats, 1000);
}

function updateStats() {
  const now = Date.now();
  const elapsedSec = Math.floor((now - startTime) / 1000);

  document.getElementById("time-elapsed").innerText = `${elapsedSec}s`;

  if (isWindowFocused) {
    totalFocusedTime += 1;
  }

  const unfocusedTime = elapsedSec - totalFocusedTime;

  document.getElementById("focused-time").innerText = `${totalFocusedTime}s`;
  document.getElementById("unfocused-time").innerText = `${unfocusedTime}s`;

  const focusScore = elapsedSec > 0 ? Math.round((totalFocusedTime / elapsedSec) * 100) : 100;
  document.getElementById("focus-score").innerText = `${focusScore}%`;

  if (sessionDuration > 0 && elapsedSec >= sessionDuration) {
    endSession();
    alert("Session complete!");
  }
}

function endSession() {
  clearInterval(timerInterval);

  const stats = getFocusStats();
  const taskName = document.getElementById("current-task").innerText;

  const sessionData = {
    task: taskName,
    focused: stats.focused,
    unfocused: stats.unfocused,
    score: stats.focusScore,
    timestamp: new Date().toLocaleString()
  };

  saveSessionHistory(sessionData);

  document.getElementById("session").style.display = "none";
  document.getElementById("task-name").value = "";

  document.getElementById("summary-focused").innerText = `${stats.focused}s`;
  document.getElementById("summary-unfocused").innerText = `${stats.unfocused}s`;
  document.getElementById("summary-score").innerText = `${stats.focusScore}%`;

  document.getElementById("summary").style.display = "block";

  loadSessionHistory();
}

function getFocusStats() {
  const now = Date.now();
  const totalElapsedSeconds = Math.floor((now - startTime) / 1000);
  const unfocusedTime = totalElapsedSeconds - totalFocusedTime;

  return {
    focused: totalFocusedTime,
    unfocused: unfocusedTime,
    total: totalElapsedSeconds,
    focusScore: Math.round((totalFocusedTime / totalElapsedSeconds) * 100)
  };
}

function saveSessionHistory(data) {
  const history = JSON.parse(localStorage.getItem("focusHistory") || "[]");
  history.unshift(data); // add to the beginning
  localStorage.setItem("focusHistory", JSON.stringify(history.slice(0, 10))); // keep last 10
}

function loadSessionHistory() {
  const history = JSON.parse(localStorage.getItem("focusHistory") || "[]");
  const list = document.getElementById("history-list");
  if (!list) return;

  list.innerHTML = "";
  history.forEach(session => {
    const li = document.createElement("li");
    li.textContent = `[${session.timestamp}] ${session.task} — Focus: ${session.focused}s, Unfocus: ${session.unfocused}s, Score: ${session.score}%`;
    list.appendChild(li);
  });
}

window.addEventListener("blur", () => {
  isWindowFocused = false;
});

window.addEventListener("focus", () => {
  isWindowFocused = true;
});

window.addEventListener("DOMContentLoaded", () => {
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") {
    document.body.classList.add("dark");
    document.getElementById("theme-toggle").checked = true;
  }

  loadSessionHistory();
});
