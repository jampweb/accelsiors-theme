document.addEventListener('DOMContentLoaded', function() {
    
    // ONLY initialize Barba on Desktop (screens wider than 1024px)
    if (window.matchMedia("(min-width: 1024px)").matches) {
        
        barba.init({
            sync: true,
            transitions: [{
                name: 'slide',
                leave(data) {
                    const container = data.current.container;
                    container.style.transition = 'transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.8s ease';
                    container.style.transform = 'translateX(-80px)';
                    container.style.opacity = '0';
                    return new Promise(resolve => setTimeout(resolve, 800));
                },
                enter(data) {
                    const container = data.next.container;
                    container.style.transform = 'translateX(80px)';
                    container.style.opacity = '0';
                    container.offsetHeight; // Force Reflow
                    container.style.transition = 'transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.8s ease';
                    container.style.transform = 'translateX(0)';
                    container.style.opacity = '1';
                    window.scrollTo(0, 0);
                }
            }]
        });
    }
    // Note: We REMOVED the custom swipe-back logic here since we want native browser behavior on mobile/touch.
});