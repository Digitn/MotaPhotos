document.addEventListener('DOMContentLoaded', function() {
    const popup = document.querySelector('.popup');
    const selectField = document.querySelector('select[name="your-subject"]');

    // Fonction pour ouvrir le popup
    function openPopup() {
        popup.style.display = 'block';
    }

    // Fonction pour fermer le popup
    function closePopup() {
        popup.style.display = 'none';
    }

    // Charger les références de photos
    function loadPhotoReferences() {
        const ajaxUrl = getAjaxUrl();
        const action = 'get_photo_references';

        fetch(`${ajaxUrl}?action=${action}`)
            .then(response => response.json())
            .then(data => {
                data.sort();
                selectField.innerHTML = '';

                data.forEach(reference => {
                    const option = document.createElement('option');
                    option.value = reference;
                    option.textContent = reference;
                    selectField.appendChild(option);
                });
            })
            .catch(error => console.error('Erreur: la liste des références n\'a pas été chargée', error));
    }
    loadPhotoReferences();
    defautRef();

    // Choix ref par défaut
    // Choix ref par défaut
    function defautRef() {
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '-- Choisissez une photo --';
        selectField.appendChild(defaultOption);

        // Définir l'option par défaut comme sélectionnée
        defaultOption.selected = true;
    }


    // Présélectionner les références
    function preselectRef() {
        const photoRef = document.querySelector('img[data-reference]');
        
        if (photoRef) {
            const referenceValue = photoRef.getAttribute('data-reference').split(':')[1].trim();
            selectField.value = referenceValue;
        }
    }
    
    // Fonction pour le chemin d'accès au fichier ajax
    function getAjaxUrl() {
        const currentPage = window.location.href;
        const parts = currentPage.split('/');

        // Calcul du niveau de profondeur
        const depth = parts.length - 6;  

        // Générer le chemin relatif
        let relativePath = '';
        for (let i = 0; i < depth; i++) {
            relativePath += '../';
        }

        // Combiner avec le chemin d'admin-ajax.php
        const ajaxUrl = relativePath + 'wp-admin/admin-ajax.php';
        return ajaxUrl;
    }

    // Gestion de l'ouverture du popup
    const menuItems = document.querySelectorAll('.menu-item');
    const buttonContact = document.querySelectorAll('.contact-btn');
    const btnSingle = document.querySelectorAll('.preselect-ref');

    menuItems.forEach(menuItem => {
        const menuLink = menuItem.querySelector('a');
        if (menuLink.textContent.includes('Contact')) {
            menuLink.addEventListener('click', e => {
                e.preventDefault();
                openPopup();
                defautRef();
            });
        }
    });

    buttonContact.forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            openPopup();
            defautRef();
        });
    });

    btnSingle.forEach(btnSingleRef => {
        btnSingleRef.addEventListener('click', e => {
            e.preventDefault();
            openPopup();
            preselectRef();
        });
    });

    // Gestion de la fermeture du popup
    const popupOverlay = document.querySelector('.popup-overlay');
    popupOverlay.addEventListener('click', e => {
        if (e.target === popupOverlay) {
            closePopup();
        }
    });

    const handleMouseMove = () => {
        popupClose.style.visibility = 'visible';
        popupClose.style.display = 'block';
    };

    const handleMouseOut = () => popupClose.style.visibility = 'hidden';
    const popupContact = document.querySelector('.popup-contact');
    const popupClose = popupContact.querySelector('.popup-close');

    popupContact.addEventListener('mousemove', handleMouseMove);
    popupContact.addEventListener('mouseout', handleMouseOut);

    popupClose.addEventListener('click', () => closePopup());

    // Répétition titre popup
    const animatedTitle = document.querySelector('.animated-title');
    const originalText = animatedTitle.textContent;
    const newText = originalText.repeat(10); 

    animatedTitle.textContent = newText;

    // Duplication titre modale sur seconde ligne (balise <p>)
    const animatedTitle2 = document.querySelector('.animated-title2');
    animatedTitle2.textContent = animatedTitle.textContent;

});

