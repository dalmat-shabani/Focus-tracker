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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - Smart Focus Tracker</title>
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3064/3064197.png">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="site-header">
  <div class="header-inner">
    <h1 class="site-title">Smart Focus Tracker</h1>

    <nav class="site-nav">
      <ul>
        <li><a href="index.php" >Home</a></li>
        <li><a href="about.php" aria-current="page">About</a></li>
        <li><a href="contact.php">Contact</a></li>
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


  <main class="layout about-layout">
  <section class="panel about-panel">
    <h2>About Smart Focus Tracker</h2>

    <p>
      Smart Focus Tracker is a lightweight productivity tool designed to help you stay on task, track your focus, and reflect on your attention habits.
      Whether you're working from home, studying, or just trying to stay more mindful, our tracker gives you insight into how present you really are.
    </p>

    <h3>🎯 Our Mission</h3>
    <p>
      We aim to help people do deep, meaningful work by bringing awareness to their attention. We believe focus should be measured, not guessed — and our tool helps you do just that, without tracking or spying.
    </p>

    <h3>👨‍💻 Meet the Makers</h3>
    <ul>
      <li><strong>Dalmati:</strong> Developer & Designer — built the core app and crafted the clean interface.</li>
    </ul>

    <h3>🛠 Why We Built It</h3>
    <p>
      We noticed that even the best productivity tools often track time, not *focus*. We wanted a tool that didn't judge you, didn't sell your data, and just helped you stay aware. So we built it.
    </p>

    <h3>🚀 What’s Next?</h3>
    <p>
      We're planning to add session analytics, export options, community focus challenges, and even ambient sound integrations — while keeping the experience private and ad-free.
    </p>

    <h3>📬 Let’s Talk</h3>
    <p>
      Got an idea, bug, or just want to say hello? Reach out on our <a href="contact.php">Contact Page</a> — we read every message.
    </p>
  </section>
</main>

  

  <footer class="site-footer">
    &copy; 2025 Smart Focus Tracker. All rights reserved.
  </footer>

  <script src="script.js"></script>
</body>
</html>
