//Affichage et fermeture modale
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.menu-item');
    const popup = document.querySelector('.popup');
    const popupContact = document.querySelector('.popup-contact');
    const popupOverlay = document.querySelector('.popup-overlay');

    menuItems.forEach(menuItem => {
        const menuLink = menuItem.querySelector('a');

        if (menuLink.textContent.includes('Contact')) {
            menuLink.addEventListener('click', e => {
                e.preventDefault();
                popup.style.display = 'block';
            });
        }
    });

    popupOverlay.addEventListener('click', e => {
        if (e.target === popupOverlay) {
            popup.style.display = 'none';
        }
    });

    const handleMouseMove = () => {
        popupClose.style.visibility = 'visible';
        popupClose.style.display = 'block';
    };
    const handleMouseOut = () => popupClose.style.visibility = 'hidden';

    popupContact.addEventListener('mousemove', handleMouseMove);
    popupContact.addEventListener('mouseout', handleMouseOut);

    const popupClose = document.querySelector('.popup-contact .popup-close');
    popupClose.addEventListener('click', () => popup.style.display = 'none');
});

//Répétition titre modale
document.addEventListener('DOMContentLoaded', function() {
    const animatedTitle = document.querySelector('.animated-title');
    const originalText = animatedTitle.textContent;
    const newText = originalText.repeat(10); 

    animatedTitle.textContent = newText;
});

//Duplication titre modale sur seconde ligne (balise <p>)
document.addEventListener('DOMContentLoaded', function() {
    var animatedTitle = document.querySelector('.animated-title1');
    var animatedTitle2 = document.querySelector('.animated-title2');

    animatedTitle2.textContent = animatedTitle.textContent;
});


