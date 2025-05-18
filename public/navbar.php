<?php session_start(); ?>
<!-- Start of Navbar -->
<header>
  <nav>
    <div class="nav-container">

      <!-- Centered Title -->
      <span class="navbar-title">Student Management System</span>

      <!-- Right Side Navigation -->
      <ul class="nav-links">
        <li><a href="../public/index.php" class="nav-btn">Home</a></li>
        <?php if (empty($_SESSION['admin'])): ?>
          <li><a href="../auth/login.php" class="nav-btn">Login as Admin</a></li>
        <?php else: ?>
          <li><a href="../auth/logout.php" class="nav-btn">Logout</a></li>
        <?php endif; ?>
      </ul>

    </div>
  </nav>
</header>
