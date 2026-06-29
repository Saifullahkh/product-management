document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const content = document.getElementById('content');

    function toggleSidebar() {
        if (window.innerWidth >= 992) {
            // Desktop behavior: collapse/expand
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
        } else {
            // Mobile behavior: show/hide
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        }
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', toggleSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', toggleSidebar);
    }

    // Close sidebar on window resize if it's open on mobile
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        }
    });
});



