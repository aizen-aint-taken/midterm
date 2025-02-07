<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>

  <link rel="stylesheet" href="../public/assets/css/adminLTE.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body.light-mode {
      background-color: #f8f9fa;
      color: #343a40;

    }

    body.dark-mode {
      background-color: #343a40;
      color: #f8f9fa;
    }

    .navbar-light {
      background-color: #f8f9fa !important;
      border-bottom: 1px solid #dee2e6;
    }

    .navbar-dark {
      background-color: #343a40 !important;
      border-bottom: 1px solid #495057;
    }

    .navbar-toggler-icon {
      filter: invert(100%);
    }

    .theme-toggle {
      cursor: pointer;
      font-size: 1.5rem;
      margin-left: auto;
      transition: color 0.3s ease;
    }

    body.light-mode .theme-toggle {
      color: #343a40;
    }

    body.dark-mode .theme-toggle {
      color: #f8f9fa;
    }

    body {
      transition: background-color 0.3s, color 0.3s;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed light-mode">
  <div class="wrapper">

    <form id="logout-form" action="logout.php" method="POST" style="display:none;">

    </form>

    <nav class="main-header navbar navbar-expand navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>




      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="../aboutUs/index.php" class="nav-link">About</a>
        </li>
        <li class="nav-item">
          <a href="../admin/reservations.php" class="nav-link">Reservations</a>
        </li>
        <!-- User Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <span id="usernameDisplay">
              <?php
              // Check if admin's email exists in session and display it
              echo isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : 'Admin Account';
              ?>
            </span>
          </a>


          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
          </ul>
        </li>

        <script>
          // Check session data on page load and update if necessary
          document.addEventListener('DOMContentLoaded', function() {
            function fetchSessionData() {
              fetch('getSession.php')
                .then(response => response.json())
                .then(data => {
                  const usernameDisplay = document.getElementById('usernameDisplay');
                  if (usernameDisplay && usernameDisplay.innerText !== data.user) {
                    usernameDisplay.innerText = data.user;
                  }
                })
                .catch(error => console.error('Error fetching session data:', error));
            }

            // Fetch session info periodically (e.g., every 5 seconds)
            setInterval(fetchSessionData, 5000);
            fetchSessionData(); // initial fetch
          });
        </script>

    </nav>


    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to log out?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
      // setInterval(() => {
      //   const cookies = document.cookie.split(';').map(cookie => cookie.trim());
      //   console.log(cookies);
      //   const loggedOut = cookies.find(cookie => cookie.startsWith('loggedOut='));
      //   if (loggedOut && loggedOut.split('=')[1] === 'true') {
      //     alert('You have been logged out. Redirecting to login...');
      //     window.location.href = 'login.php';
      //   }
      // }, 2000);

      // setInterval(() => {
      //   fetch('check_auth.php')
      //     .then(response => response.json())
      //     .then(data => {
      //       if (data.logged_out) {
      //         alert('You have been logged out. Redirecting to login...');
      //         window.location.href = 'login.php';
      //       }
      //     })
      //     .catch(err => console.error('Error checking auth:', err));
      // }, 2000); // Check every 2 seconds
    </script>
  </div>
</body>

</html>