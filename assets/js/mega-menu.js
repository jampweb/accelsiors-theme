document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.main-navigation .menu-item-has-children');

    // Set initial ARIA attributes
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        if (link) {
            link.setAttribute('aria-expanded', 'false');
            link.setAttribute('role', 'button');
        }
    });

    // Toggle submenu on click
    document.addEventListener('click', function(event) {
        let isClickInsideMenu = false;

        menuItems.forEach(item => {
            const link = item.querySelector('a');
            const isClickInsideThisItem = item.contains(event.target);

            if (isClickInsideThisItem) {
                isClickInsideMenu = true;

                // Only toggle if the click is on the link itself (not inside the sub-menu)
                if (event.target === link || link.contains(event.target)) {
                    event.preventDefault();
                    const isOpen = item.classList.contains('is-open');

                    // Close other menus
                    menuItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('is-open');
                            const otherLink = otherItem.querySelector('a');
                            if (otherLink) otherLink.setAttribute('aria-expanded', 'false');
                        }
                    });

                    // Toggle current menu
                    if (isOpen) {
                        item.classList.remove('is-open');
                        link.setAttribute('aria-expanded', 'false');
                    } else {
                        item.classList.add('is-open');
                        link.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        });

        // Close menus if clicking outside
        if (!isClickInsideMenu) {
            menuItems.forEach(item => {
                item.classList.remove('is-open');
                const link = item.querySelector('a');
                if (link) link.setAttribute('aria-expanded', 'false');
            });
        }
    });

    // Close on Escape Key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            menuItems.forEach(item => {
                if (item.classList.contains('is-open')) {
                    item.classList.remove('is-open');
                    const link = item.querySelector('a');
                    if (link) {
                        link.setAttribute('aria-expanded', 'false');
                        link.focus(); // Return focus to the trigger for screen readers
                    }
                }
            });
        }
    });
});
