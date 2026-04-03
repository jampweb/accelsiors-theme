// Globally available function to force-close any open navigation overlays
function closeMenu() {
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

    // Trigger native WP close button click if it exists
    var closeBtn = document.querySelector('.wp-block-navigation__responsive-container-close');
    if (closeBtn) {
        closeBtn.click();
    }

    // Remove WP modal lock classes to restore page scrolling
    document.documentElement.classList.remove('has-modal-open');
    document.body.classList.remove('has-modal-open');
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Force-close immediately when the initial page loads
    closeMenu();

    // 2. Robust check to hook into Barba.js lifecycle for SPA transitions
    var barbaCheckInterval = setInterval(function() {
        if (typeof barba !== 'undefined' && barba.hooks) {
            clearInterval(barbaCheckInterval);
            
            barba.hooks.beforeLeave(function() {
                closeMenu();
            });
            barba.hooks.after(function() {
                closeMenu();
            });
        }
    }, 100);

    // 3. Use event delegation for links so it survives Barba DOM replacements
    document.addEventListener('click', function(e) {
        var navLink = e.target.closest('a');
        // Check if the link is a valid navigation trigger (not opening in a new tab/downloading)
        if (navLink && navLink.href && navLink.target !== '_blank' && !navLink.hasAttribute('download')) {
            // Execute immediately on click to ensure no delay before transition starts
            closeMenu();
        }
    });
});