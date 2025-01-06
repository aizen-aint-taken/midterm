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
        <li class="nav-item">
          <a href="products.php" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>Products</p>
          </a>
        </li>

        <!-- Divider -->
        <li class="nav-item">
          <hr class="sidebar-divider my-3">
        </li>

        <!-- Analytics and Reports -->
        <li class="nav-item">
          <a href="analytics/analysis.php" class="nav-link">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Analytics</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="reports.php" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Reports</p>
          </a>
        </li>

        <!-- Divider -->
        <li class="nav-item">
          <hr class="sidebar-divider my-3">
        </li>

        <!-- Messages -->
        <li class="nav-item">
          <a href="messages.php" class="nav-link">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Messages</p>
          </a>
        </li>

        <!-- Divider -->
        <li class="nav-item">
          <hr class="sidebar-divider my-3">
        </li>

        <!-- Support and Notifications -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-headset"></i>
            <p>Support</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-bell"></i>
            <p>Notifications</p>
          </a>
        </li>

        <!-- Add Student -->
        <li class="nav-item">
          <a href="../admin/student.php" class="nav-link">
            <i class="nav-icon fa-regular fa-circle-user"></i>
            <p>Add Student</p>
          </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
          <a href="../logout.php" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
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
    width: 250px; /* Adjust width as needed */
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    z-index: 1000;
    background-color: #f8f9fa; /* Light background */
}

/* Content Wrapper */
.content-wrapper {
    margin-left: 250px; /* Same as the sidebar width */
    padding: 20px; /* Add some padding for better appearance */
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

