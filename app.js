document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Swup for Slide-Over Page Transitions
    const swup = new Swup({
        containers: ['#swup'], // The container to replace
        animationSelector: '[class*="transition-"]'
    });

    // 2. Mobile Swipe-to-Go-Back Gesture
    let touchStartX = 0;
    let touchEndX = 0;

    document.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, {passive: true});

    document.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, {passive: true});

    function handleSwipe() {
        // If swipe right > 50px, go back
        if (touchEndX > touchStartX + 50) {
            window.history.back();
        }
    }
});