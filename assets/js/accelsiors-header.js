document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.sticky-header');
    const searchOverlay = document.querySelector('.search-overlay-container');
    const searchTriggers = document.querySelectorAll('.js-search-trigger');
    const searchCloses = document.querySelectorAll('.js-search-close');
    let lastScroll = 0;

    if (header) {
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll <= 0) {
                header.classList.remove('header-hidden');
                lastScroll = 0;
                return;
            }

            if (currentScroll > lastScroll) {
                header.classList.add('header-hidden');
            } else {
                header.classList.remove('header-hidden');
            }

            lastScroll = currentScroll;
        });
    }

    if (!searchOverlay) {
        return;
    }

    const openSearchOverlay = function(event) {
        event.preventDefault();
        searchOverlay.classList.add('search-active');
        document.body.classList.add('search-overlay-open');
    };

    const closeSearchOverlay = function(event) {
        event.preventDefault();
        searchOverlay.classList.remove('search-active');
        document.body.classList.remove('search-overlay-open');
    };

    searchTriggers.forEach(function(trigger) {
        trigger.addEventListener('click', openSearchOverlay);
    });

    searchCloses.forEach(function(closeButton) {
        closeButton.addEventListener('click', closeSearchOverlay);
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && searchOverlay.classList.contains('search-active')) {
            searchOverlay.classList.remove('search-active');
            document.body.classList.remove('search-overlay-open');
        }
    });
});
