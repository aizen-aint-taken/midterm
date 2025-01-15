<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
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
      color: #343a40; /* Dark color for light mode */
    }

    body.dark-mode .theme-toggle {
      color: #f8f9fa; /* Light color for dark mode */
    }

    /* Transition for Smooth Mode Switch */
    body {
      transition: background-color 0.3s, color 0.3s;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed light-mode">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
    <span class="theme-toggle fas fa-moon" id="themeToggle"></span>
  </nav>
  

  <script>
    
    const themeToggle = document.getElementById('themeToggle');
    console.log(themeToggle);
    const body = document.body;

    themeToggle.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      body.classList.toggle('light-mode');

    
      if (body.classList.contains('dark-mode')) {
        themeToggle.classList.replace('fa-moon', 'fa-sun');
      } else {
        themeToggle.classList.replace('fa-sun', 'fa-moon');
      }
    });
  </script>

  <!-- AdminLTE Script -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</div>
</body>
</html>
