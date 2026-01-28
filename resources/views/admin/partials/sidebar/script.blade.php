<script>
    /**
     * Toggles the sidebar on mobile devices
     */
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebar && overlay) {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    }

    /**
     * Toggles submenus in the sidebar and ensures only one is open at a time (Accordion)
     */
    function toggleSubmenu(id, arrowId) {
        const submenu = document.getElementById(id);
        const arrow = document.getElementById(arrowId);

        // Find all submenus
        const allSubmenus = document.querySelectorAll('aside nav ul ul');
        const allArrows = document.querySelectorAll('aside nav ul button svg[id^="arrow-"]');

        // Close other submenus
        allSubmenus.forEach(sub => {
            if (sub.id !== id) {
                sub.classList.add('hidden');
            }
        });

        // Reset other arrows
        allArrows.forEach(arr => {
            if (arr.id !== arrowId) {
                arr.style.transform = 'rotate(0deg)';
            }
        });

        // Toggle the target submenu
        submenu.classList.toggle('hidden');

        // Rotate arrow
        if (submenu.classList.contains('hidden')) {
            arrow.style.transform = 'rotate(0deg)';
        } else {
            arrow.style.transform = 'rotate(180deg)';
        }
    }

    // Add event listener to close sidebar when clicking overlay
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('sidebar-overlay');
        if (overlay) {
            overlay.addEventListener('click', () => {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        }
    });
</script>