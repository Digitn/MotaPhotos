document.addEventListener('DOMContentLoaded', function () {
    const popup = document.querySelector('.popup');
    const selectField = document.querySelector('.wpcf7-form select[name="your-subject"]');
    const popupOverlay = document.querySelector('.popup-overlay');
    const popupContact = document.querySelector('.popup-contact');
    const popupClose = popupContact.querySelector('.popup-close');
    const animatedTitle = document.querySelector('.animated-title');
    const animatedTitle2 = document.querySelector('.animated-title2');

    function openPopup() {
        popup.style.display = 'block';
    }

    function closePopup() {
        popup.style.display = 'none';
    }

    function loadPhotoReferences() {
        const ajaxUrl = getAjaxUrl();
        const action = 'get_photo_references';

        fetch(`${ajaxUrl}?action=${action}`)
            .then(response => response.json())
            .then(data => {
                data.sort();
                selectField.innerHTML = '';

                const placeholderOption = document.createElement('option');
                placeholderOption.textContent = 'Choisissez une photo';
                placeholderOption.disabled = true;
                placeholderOption.selected = true;
                selectField.appendChild(placeholderOption);

                data.forEach(reference => {
                    const option = document.createElement('option');
                    option.value = reference;
                    option.textContent = reference;
                    selectField.appendChild(option);
                });
            })
            .catch(error => console.error('Erreur: la liste des références n\'a pas été chargée', error));
    }

    if (document.body.classList.contains('page') || document.body.classList.contains('single')) {
        loadPhotoReferences();
    }
    

    function preselectRef() {
        const photoRef = document.querySelector('img[data-reference]');

        if (photoRef) {
            const referenceValue = photoRef.getAttribute('data-reference').split(':')[1].trim();
            selectField.value = referenceValue;
        }
    }

    function getAjaxUrl() {
        const depth = window.location.href.split('/').length - 6;
        return `${'../'.repeat(depth)}wp-admin/admin-ajax.php`;
    }

    document.querySelectorAll('.menu-item a').forEach(menuLink => {
        if (menuLink.textContent.includes('Contact')) {
            menuLink.addEventListener('click', e => {
                e.preventDefault();
                openPopup();
            });
        }
    });

    document.querySelectorAll('.contact-btn-defaut, .contact-btn-preselect').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            openPopup();
            if (button.classList.contains('contact-btn-preselect')) {
                preselectRef();
            }
        });
    });

    popupOverlay.addEventListener('click', e => {
        if (e.target === popupOverlay) {
            closePopup();
        }
    });

    const handleMouseMove = () => popupClose.style.opacity = '1';
    const handleMouseOut = () => popupClose.style.opacity = '0';

    popupContact.addEventListener('mousemove', handleMouseMove);
    popupContact.addEventListener('mouseout', handleMouseOut);
    popupClose.addEventListener('click', () => closePopup());

    const originalText = animatedTitle.textContent;
    const newText = originalText.repeat(10);
    animatedTitle.textContent = newText;
    animatedTitle2.textContent = newText;
});
