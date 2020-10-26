<?php
include_once(__DIR__ . '/../classes/Session.php');
?>


<nav id="nav">
  <div>
    <h2><i class="fas fa-pencil-alt"></i> Taskify</h2>
  </div>
  <ul>
    <li><a href="index.php">Home</a></li>
    <?php if (Session::exists('userId')) : ?>
      <li><a href="tasks.php">Tasks</a></li>
      <li><a href="logout.php">Logout</a></li>
    <?php else : ?>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>