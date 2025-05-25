let startTime, timerInterval;
let totalFocusedTime = 0;
let isWindowFocused = true;
let sessionDuration = 0; // in seconds
let warnedForLongFocus = false;

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
  warnedForLongFocus = false;

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

  if (!warnedForLongFocus && totalFocusedTime >= 3000) {
    warnedForLongFocus = true;
    alert("You've been working for over 50 minutes. Time to take a short break!");
  }

  if (sessionDuration > 0 && elapsedSec >= sessionDuration) {
    endSession();
    alert("Session complete!");
  }
}

function endSession() {
  clearInterval(timerInterval);

  const stats = getFocusStats();
  const taskName = document.getElementById("current-task").innerText;
  const taskType = document.getElementById("task-type")?.value || "Unspecified";

  const sessionData = {
    task: taskName,
    type: taskType,
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
  fetch("save_session.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  }).then(res => {
    if (!res.ok) throw new Error("Failed to save session");
  }).catch(err => console.error(err));
}


function loadSessionHistory() {
  fetch("load_sessions.php")
    .then(res => res.json())
    .then(history => {
      const list = document.getElementById("history-list");
      if (!list) return;

      list.innerHTML = "";
      history.forEach(session => {
        const li = document.createElement("li");
        li.textContent = `[${session.timestamp}] ${session.task} (${session.task_type}) — Focus: ${session.focused}s, Unfocus: ${session.unfocused}s, Score: ${session.score}%`;
        list.appendChild(li);
      });
    }).catch(err => {
      console.error("Failed to load session history", err);
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

document.addEventListener('DOMContentLoaded', () => {
  const themeToggleCheckbox = document.querySelector('#theme-toggle');

  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark');
    if (themeToggleCheckbox) themeToggleCheckbox.checked = true;
  }

  if (!themeToggleCheckbox) return;

  themeToggleCheckbox.addEventListener('change', () => {
    if (themeToggleCheckbox.checked) {
      document.body.classList.add('dark');
      localStorage.setItem('theme', 'dark');
    } else {
      document.body.classList.remove('dark');
      localStorage.setItem('theme', 'light');
    }
  });
});

const contactForm = document.getElementById('contact-form');
if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const name = this.name.value.trim();
    const email = this.email.value.trim();
    const message = this.message.value.trim();
    const responseEl = document.getElementById('form-response');

    if (!name || !email || !message) {
      responseEl.style.color = 'red';
      responseEl.textContent = 'Please fill in all required fields.';
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      responseEl.style.color = 'red';
      responseEl.textContent = 'Please enter a valid email address.';
      return;
    }

    responseEl.style.color = 'green';
    responseEl.textContent = 'Thank you for your message! We will get back to you shortly.';

    this.reset();
  });
}
