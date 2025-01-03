document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.main-sidebar');
    const body = document.body;

    const toggleSidebar = () => {
      sidebar.classList.toggle('active');
      body.classList.toggle('sidebar-open');
    };

    // If the sidebar toggle button exists, attach the event
    const toggleButton = document.querySelector('.sidebar-toggle-btn');
    if (toggleButton) {
      toggleButton.addEventListener('click', toggleSidebar);
    }
  });