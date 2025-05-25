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
  <title>Contact Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="site-header">
  <div class="header-inner">
    <h1 class="site-title">Smart Focus Tracker</h1>

    <nav class="site-nav">
      <ul>
        <li><a href="index.php" >Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php" arria-current="page">Contact</a></li>
        <li><a href="weekly_summary.php">Weekly Summary</a></li>
        <li> <a href="logout.php">Log out</a> </li>
      </ul>
    </nav>

    <label class="theme-switch" for="theme-toggle">
      <input type="checkbox" id="theme-toggle" />
      <span class="slider"></span>
    </label>
  </div>
</header>


  <main>
    <section class="contact-section layout">
      <div class="contact-panel panel">
        <h2>Contact Us</h2>
        <p>Have questions or want to get in touch? Fill out the form below and we’ll get back to you as soon as possible.</p>

        <form id="contact-form" action="#" method="POST" novalidate>
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required placeholder="Your full name" />

          <label for="email">Email</label>
          <input type="email" id="email" name="email" required placeholder="your.email@example.com" />

          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" placeholder="Subject (optional)" />

          <label for="message">Message</label>
          <textarea id="message" name="message" rows="6" required placeholder="Write your message here..."></textarea>

          <button type="submit">Send Message</button>
        </form>

        <div id="form-response" role="alert" aria-live="polite" style="margin-top: 15px;"></div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    &copy; 2025 Smart Focus Tracker. All rights reserved.
  </footer>


    <script src="script.js"></script>
 </body>