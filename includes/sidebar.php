<aside class="main-sidebar sidebar-light-secondary elevation-5">
  <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
  <img src="../maharlika/logo.jpg" alt="">
  <div class="sidebar">
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <hr class="sidebar-divider">
        </li>

        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Home</p>
            <!-- <span class="badge badge-pill badge-danger">New</span> Notification Badge -->
          </a>

        <li class="nav-item">
          <hr class="sidebar-divider">
        </li>


        </li>
        <li class="nav-item">
          <a href="../analysis/displayStats.php" class="nav-link">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Analytics</p>
            <!-- <span class="badge badge-pill badge-danger">New</span> Notification Badge -->
          </a>
        </li>

        <li class="nav-item">
          <hr class="sidebar-divider">
        </li>

        <li class="nav-item">
          <a href="../admin/reservations.php" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>Reservation</p>
          </a>
        </li>

        <li class="nav-item">
          <hr class="sidebar-divider">
        </li>

        <li class="nav-item">
          <a href="../admin/student.php" class="nav-link">
            <i class="nav-icon fa-regular fa-circle-user"></i>
            <p>Add Student</p>
          </a>
        </li>

        <li class="nav-item">
          <hr class="sidebar-divider">
        </li>
      </ul>
    </nav>
  </div>
</aside>

<style>
  .main-sidebar {
    width: 250px;
    height: 100vh;
    top: 0;
    left: 0;
    height: 100%;
    z-index: 1000;
    background: linear-gradient(180deg, rgb(218, 208, 223), rgb(206, 225, 238));
    overflow-y: auto;
    transition: all 0.3s ease-in-out;
    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
    border-right: 1px solid #dee2e6;

  }

  img {
    margin: 15px;
    border-radius: 50%;
    padding: 20px;
    height: 200px;
    width: 200px;
    box-shadow: #007bff;
  }

  .sidebar-logo {
    width: 80%;
    max-height: 100px;
    object-fit: contain;
    border-radius: 5px;
    display: block;
    margin: 10px auto;
  }

  .nav-link {
    color: #ffffff;
    font-size: 16px;
    font-weight: 500;
    padding: 12px 20px;
    position: relative;
    transition: background-color 0.3s, color 0.3s, transform 0.3s;
    border-radius: 10px;
  }


  .nav-link:hover {
    background-color: #1c74b0;
    color: #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
  }

  .nav-link i {
    margin-right: 10px;
    transition: transform 0.2s ease, color 0.2s ease;
  }

  .nav-link:hover i {
    transform: scale(1.2);
    color: #ffd700;
    /* Gold color on hover */
  }


  .nav-item.active .nav-link {
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    animation: pulse 1s infinite;
  }

  /* Badge Styling */
  .badge {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 12px;
    padding: 5px;
    border-radius: 50%;
  }

  /* Sidebar Divider */
  .sidebar-divider {
    border-top: 3px solid rgba(25, 116, 206, 0.8);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding-top: 10px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    margin: 10px 0;
  }

  .menu-toggle {
    display: none;
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 24px;
    background-color: transparent;
    border: none;
    color: #495057;
    cursor: pointer;
    z-index: 1050;
  }

  @media (max-width: 768px) {
    .main-sidebar {
      width: 0;
      left: -250px;
      transition: left 0.3s ease-in-out;
    }

    .main-sidebar.open {
      left: 0;
      width: 250px;
    }

    .content-wrapper {
      margin-left: 0;
    }

    .menu-toggle {
      display: block;
    }
  }

  .main-sidebar::-webkit-scrollbar {
    width: 8px;
  }

  .main-sidebar::-webkit-scrollbar-thumb {
    background: #adb5bd;
    border-radius: 4px;
  }

  .main-sidebar::-webkit-scrollbar-thumb:hover {
    background: #6c757d;
  }


  .sidebar-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 1040;
  }

  .sidebar-backdrop.show {
    display: block;
  }


  @keyframes pulse {
    0% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.1);
    }

    100% {
      transform: scale(1);
    }
  }
</style>

<script>
  function toggleSidebar() {
    const sidebar = document.querySelector('.main-sidebar');
    const backdrop = document.querySelector('.sidebar-backdrop');
    const contentContainer = document.querySelector('.content-container');

    sidebar.classList.toggle('open');
    backdrop.classList.toggle('show');

    if (sidebar.classList.contains('open')) {
      contentContainer.style.marginLeft = '250px';
    } else {
      contentContainer.style.marginLeft = '0';
    }
  }
</script>

<!-- Backdrop for mobile -->