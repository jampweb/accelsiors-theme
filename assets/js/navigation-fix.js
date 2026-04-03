document.addEventListener('DOMContentLoaded', function() {
    // Function to force-close any open navigation overlays
    var closeMenu = function() {
        var openedItems = document.querySelectorAll('.wp-block-navigation-item.is-opened');
        openedItems.forEach(function(item) {
            item.classList.remove('is-opened');
        });
        
        var mobileMenus = document.querySelectorAll('.wp-block-navigation__responsive-container.is-menu-open');
        mobileMenus.forEach(function(menu) {
            menu.classList.remove('is-menu-open');
        });

        var toggleBtns = document.querySelectorAll('.wp-block-navigation button[aria-expanded="true"], .wp-block-navigation a[aria-expanded="true"]');
        toggleBtns.forEach(function(btn) {
            btn.setAttribute('aria-expanded', 'false');
        });
    };

    // 1. Force-close immediately when the initial page loads
    closeMenu();

    // 2. Hook into Barba.js lifecycle for SPA transitions
    if (typeof barba !== 'undefined') {
        barba.hooks.beforeLeave(function() {
            closeMenu();
        });
    }

    // 3. Use event delegation for links so it survives Barba DOM replacements
    document.addEventListener('click', function(e) {
        var navLink = e.target.closest('.wp-block-navigation__container a');
        if (navLink) {
            setTimeout(function() {
                closeMenu();
            }, 100);
        }
    });
});