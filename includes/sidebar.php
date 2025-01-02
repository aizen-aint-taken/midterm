<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light elevation-4">
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

<!-- Custom Styling -->
<style>
  /* Ensure sidebar styles are applied correctly */
  .main-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 250px;
    background-color: #f4f6f9;
    transition: all 0.3s ease;
  }

  .sidebar-open .main-sidebar {
    transform: translateX(0);
  }

  .main-sidebar.active {
    transform: translateX(-250px);
  }

  .sidebar .nav-link {
    color: #333;
  }

  .sidebar .nav-link.active {
    background-color: #007bff;
    color: #fff;
    border-radius: 4px;
  }

  .sidebar-divider {
    border-top: 1px solid #dee2e6;
  }
</style>

<!-- Sidebar Toggle Script -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.main-sidebar');
    const body = document.body;

    const toggleSidebar = () => {
      sidebar.classList.toggle('active');
      body.classList.toggle('sidebar-open');
    };

    const toggleButton = document.querySelector('.navbar .nav-link[data-widget="pushmenu"]');
    if (toggleButton) {
      toggleButton.addEventListener('click', toggleSidebar);
    }
  });
</script>
