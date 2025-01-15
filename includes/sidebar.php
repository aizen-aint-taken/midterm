<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light elevation-5">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link text-center py-3">
    <span class="brand-text font-weight-bold text-primary">Inventory Dashboard</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Products -->

        <!-- Divider -->
        <li class="nav-item">
          <hr class="sidebar-divider">
        </li>

        <!-- Analytics and Reports -->
        <li class="nav-item">
          <a href="analytics/analysis.php" class="nav-link">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Analytics</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="reservations.php" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>Reservation</p>
          </a>
        </li>


        <!-- Add Student -->
        <li class="nav-item">
          <a href="../admin/student.php" class="nav-link">
            <i class="nav-icon fa-regular fa-circle-user"></i>
            <p>Add Student</p>
          </a>
        </li>

        <!-- Divider -->
        <li class="nav-item">
          <hr class="sidebar-divider">
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
          <a href="../logout.php" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
        <li class="nav-item mt-3">
          <a href="javascript:(0)" class="nav-link text-danger">
            <i class="fa-solid fa-clock"></i>
            <p id="orasan" style="font-size: 1.5rem;"></p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<style>
  /* Sidebar */
  .main-sidebar {
    width: 250px;
    /* Adjust width as needed */
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    z-index: 1000;
    background-color: #f8f9fa;
    /* Light background */
  }

  /* Divider */
  .sidebar-divider {
    border-top: 1px solid #ddd;
    /* Light grey border */
    margin: 10px 0;
    /* Spacing around the divider */
  }

  /* Content Wrapper */
  .content-wrapper {
    margin-left: 250px;
    /* Same as the sidebar width */
    padding: 20px;
    /* Add some padding for better appearance */
  }

  /* Mobile View */
  @media (max-width: 768px) {
    .main-sidebar {
      width: 100%;
      height: auto;
      position: relative;
    }

    .content-wrapper {
      margin-left: 0;
    }
  }
</style>

<!-- Sidebar Toggle Button (for Mobile) -->
<button class="sidebar-toggle-btn" aria-label="Toggle Sidebar">
  <i class="fas fa-bars"></i>
</button>

<link rel="stylesheet" href="../public/assets/css/sidebar.css">
<script src="../public/assets/js/sidebar.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const clockElement = document.getElementById('orasan');

    function updateClock() {
      const now = new Date();
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');
      const seconds = String(now.getSeconds()).padStart(2, '0');
      clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    }


    setInterval(updateClock, 1000);


    updateClock();
  });
</script>