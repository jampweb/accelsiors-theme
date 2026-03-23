document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.main-navigation .menu-item-has-children');
    const isMobile = () => window.innerWidth <= 768;

    // Toggle submenu on click for mobile
    menuItems.forEach(item => {
        item.addEventListener('click', function(event) {
            if (isMobile()) {
                // Prevent link from being followed on first click
                if (!item.classList.contains('open')) {
                    event.preventDefault();
                }

                // Close other open menus
                menuItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('open');
                    }
                });

                // Toggle the 'open' class
                item.classList.toggle('open');
            }
        });
    });

    // Close menus if clicking outside
    document.addEventListener('click', function(event) {
        if (isMobile()) {
            const isClickInside = document.querySelector('.main-navigation').contains(event.target);
            if (!isClickInside) {
                menuItems.forEach(item => {
                    item.classList.remove('open');
                });
            }
        }
    });

    // Basic focus management for accessibility, works with the CSS :focus-within
    // This helps ensure the menu closes when focus moves away.
    const navLinks = document.querySelectorAll('.main-navigation a');
    navLinks.forEach(link => {
        link.addEventListener('focus', (event) => {
            // The :focus-within CSS does most of the work here.
            // We can add more complex logic if needed.
        });
        link.addEventListener('blur', (event) => {
            // When an element loses focus, we could check if focus is still within the nav
            // but :focus-within is more efficient.
        });
    });
});
