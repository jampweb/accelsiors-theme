document.addEventListener('DOMContentLoaded', function() {
    var menuLinks = document.querySelectorAll('.wp-block-navigation-item a');
    
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Εντοπισμός όλων των ανοιχτών submenus και αφαίρεση της κλάσης is-opened
            var openedItems = document.querySelectorAll('.wp-block-navigation-item.is-opened');
            openedItems.forEach(function(item) {
                item.classList.remove('is-opened');
            });
            
            // Κλείσιμο και του mobile μενού αν είναι ανοιχτό
            var closeBtn = document.querySelector('.wp-block-navigation__responsive-container-close');
            var mobileMenu = document.querySelector('.wp-block-navigation__responsive-container.is-menu-open');
            
            if (closeBtn && mobileMenu) {
                closeBtn.click();
            }
        });
    });
});