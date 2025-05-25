<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>


<script>
  if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.classList.add('dark');
  }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Smart Focus Tracker</title>
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3064/3064197.png">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <h1 class="site-title">Smart Focus Tracker</h1>

      <nav class="site-nav">
        <ul>
          <li><a href="index.html" aria-current="page">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="weekly_summary.php">Weekly Summary</a></li>
          <li><a href="logout.php">Log out</a></li>
        </ul>
      </nav>

      <label class="theme-switch" for="theme-toggle">
        <input type="checkbox" id="theme-toggle" />
        <span class="slider"></span>
      </label>
    </div>
  </header>

  <section class="hero">
    <h2>Boost Your Productivity with Smart Focus Tracker</h2>
    <p>Track your tasks, stay focused, and improve your concentration with ease.</p>
    <a href="#tracker" class="btn-primary">Start Tracking Now</a>
  </section>

  <main class="layout">
    <!-- Tracker Panel -->
    <div id="tracker" class="panel main-panel">
      <h2>Track Your Focus</h2>

      <label for="task-name">What are you working on?</label>
      <input type="text" id="task-name" placeholder="e.g. Writing blog post" />
      
      <label for="task-type">Task Type:</label>
      <select id="task-type">
        <option value="Coding">Coding</option>
        <option value="Watching Video">Watching Video</option>
        <option value="Reading">Reading</option>
        <option value="Writing">Writing</option>
        <option value="Other">Other</option>
      </select>
      
      <label for="session-duration">Focus Duration:</label>
      <select id="session-duration">
        <option value="1500">25 minutes</option>
        <option value="3000">50 minutes</option>
        <option value="600">10 minutes</option>
        <option value="0">No timer</option>
      </select>

      <button class="action-button start" onclick="startSession()">Start Focus Session</button>

      <section id="session" style="display: none; margin-top: 20px;">
        <h3>Focus Session</h3>
        <p><strong>Task:</strong> <span id="current-task"></span></p>
        <p><strong>Time Elapsed:</strong> <span id="time-elapsed">0s</span></p>
        <p><strong>Focused Time:</strong> <span id="focused-time">0s</span></p>
        <p><strong>Unfocused Time:</strong> <span id="unfocused-time">0s</span></p>
        <p><strong>Focus Score:</strong> <span id="focus-score">0%</span></p>
        <button class="action-button end" onclick="endSession()">End Task</button>
      </section>

      <div id="summary" style="display:none; margin-top:20px;">
        <h3>Session Summary</h3>
        <p><strong>Task:</strong> <span id="summary-task"></span></p>
        <p><strong>Focused Time:</strong> <span id="summary-focused">0s</span></p>
        <p><strong>Unfocused Time:</strong> <span id="summary-unfocused">0s</span></p>
        <p><strong>Focus Score:</strong> <span id="summary-score">0%</span></p>
      </div>
    </div>

    <!-- History Panel -->
    <div class="panel history-panel">
      <h2>📚 Session History</h2>
      <ul id="history-list" class="history-list"></ul>
    </div>
  </main>

  <!-- Features Section -->
  <section class="features layout">
    <div class="panel">
      <h3>🎯 Stay Focused</h3>
      <p>Track your focused and unfocused time automatically while working on any task.</p>
    </div>
    <div class="panel">
      <h3>📊 Smart Insights</h3>
      <p>Get a clear breakdown of your productivity after each session to help you improve.</p>
    </div>
    <div class="panel">
      <h3>🌙 Dark Mode</h3>
      <p>Switch between light and dark themes based on your preference and reduce eye strain.</p>
    </div>
  </section>

  <!-- How To Section -->
  <section class="layout">
    <div class="panel">
      <h3 class="center-heading">💡 How to Use Smart Focus Tracker</h3>
      <ol>
        <li>Enter what you're working on and choose a task type.</li>
        <li>Select how long you want to stay focused.</li>
        <li>Stay on this tab or check "external task" if working elsewhere.</li>
        <li>Review your focus score and session history afterward.</li>
      </ol>
    </div>
  </section>

  <footer class="site-footer">
    <p>&copy; 2025 Smart Focus Tracker. All rights reserved.</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
