// Globally available function to force-close any open navigation overlays
function forceResetMenu() {
    // 1. Trigger native WP close button click if it exists
    var closeBtn = document.querySelector('.wp-block-navigation__responsive-container-close');
    if (closeBtn) {
        closeBtn.click();
    }

    // 2. Remove modal & menu lock classes from html and body
    var classesToRemove = ['has-modal-open', 'is-menu-open', 'lock-scroll'];
    classesToRemove.forEach(function(cls) {
        document.documentElement.classList.remove(cls);
        document.body.classList.remove(cls);
    });

    // 3. Find ALL elements with is-menu-open or is-opened and forcefully remove those classes
    var openElements = document.querySelectorAll('.is-menu-open, .is-opened');
    openElements.forEach(function(el) {
        el.classList.remove('is-menu-open', 'is-opened');
    });

    // 4. Set aria-expanded="false" on every button inside .wp-block-navigation
    var toggleBtns = document.querySelectorAll('.wp-block-navigation button, .wp-block-navigation a');
    toggleBtns.forEach(function(btn) {
        if (btn.hasAttribute('aria-expanded')) {
            btn.setAttribute('aria-expanded', 'false');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Force-close immediately when the initial page loads
    forceResetMenu();

    // 2. Robust check to hook into Barba.js lifecycle for SPA transitions
    var barbaCheckInterval = setInterval(function() {
        if (typeof barba !== 'undefined' && barba.hooks) {
            clearInterval(barbaCheckInterval);
            
            barba.hooks.before(function() {
                document.documentElement.setAttribute('data-barba-transitioning', 'true');
                forceResetMenu();
            });
            barba.hooks.after(function() {
                document.documentElement.removeAttribute('data-barba-transitioning');
                forceResetMenu();
            });
            barba.hooks.requestError(function() {
                document.documentElement.removeAttribute('data-barba-transitioning');
                forceResetMenu();
            });
        }
    }, 100);

    // 3. Use event delegation for links so it survives Barba DOM replacements
    document.addEventListener('click', function(e) {
        var navLink = e.target.closest('.wp-block-navigation__container a');
        if (navLink && navLink.href && navLink.target !== '_blank' && !navLink.hasAttribute('download')) {
            forceResetMenu();
        }
    });
});