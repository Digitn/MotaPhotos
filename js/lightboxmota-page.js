document.addEventListener('DOMContentLoaded', function() {
    const photosContainers = document.querySelectorAll('.photos-container');
    const lightboxPrevious = document.querySelector('.lightbox-previous-photo');
    const lightboxNext = document.querySelector('.lightbox-next-photo');
    const lightbox = document.getElementById('lightbox-gallery');
    const lightboxImage = document.querySelector('.lightbox-image'); 
    const imageReference = document.querySelector('.image-reference'); 
    const imageCategory = document.querySelector('.image-category'); 
    const closeLightbox = document.querySelectorAll('.lightbox-close');

    let photosArray = [];
    let currentPhotoIndex = 0; 

    function fetchPhotos() {
        const currentFilters = getCurrentFilters();
        const data = {
            action: 'get_and_display_photos',
            ...currentFilters
        };

        fetch(ajax_vars.ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data).toString(),
        })
        .then(response => response.json())
        .then(data => {
            photosArray = data;
            if(photosArray.length > 0) {
                currentPhotoIndex = 0;
                updateLightboxImage();
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des photos:', error);
        });
    }

    // Gestion de l'ouverture de la lightbox lors du clic sur l'élément .photo-expand
    photosContainers.forEach(container => {
        container.addEventListener('click', e => {
            // Recherche si le clic a eu lieu sur .photo-expand ou un de ses enfants
            let target = e.target;
            while (target != null && !target.classList.contains('photo-expand')) {
                target = target.parentElement;
            }

            // Si un élément .photo-expand a été cliqué
            if (target != null && target.classList.contains('photo-expand')) {
                // Trouve l'élément .photo-catalogue associé
                const photoCatalogueElement = target.closest('.photos-catalogue').querySelector('.photo-catalogue');
                
                if (photoCatalogueElement) {
                    const clickedPhotoUrl = photoCatalogueElement.getAttribute('src');
                    const clickedPhotoIndex = photosArray.findIndex(photo => photo.photo_url === clickedPhotoUrl);

                    if(clickedPhotoIndex !== -1) {
                        currentPhotoIndex = clickedPhotoIndex; // Met à jour l'index de la photo actuelle
                        updateLightboxImage(); // Met à jour l'image et les infos affichées dans la lightbox
                        lightbox.style.display = 'flex'; // Affiche la lightbox
                    }
                }
            }
        });
    });


    function getCurrentFilters() {
        return {
            category: document.getElementById('select-filter-category').value,
            format_photo: document.getElementById('select-filter-format').value,
        };
    }

    function updateLightboxImage() {
        const photo = photosArray[currentPhotoIndex];
        lightboxImage.src = photo.photo_url;
        imageReference.textContent = "Réf. photo: " + photo.reference;
        imageCategory.textContent = "Catégorie: " + photo.category;
        updateNavigationButtonsVisibility();
    }

    function updateNavigationButtonsVisibility() {
        lightboxPrevious.style.display = currentPhotoIndex === 0 ? 'none' : 'flex';
        lightboxNext.style.display = currentPhotoIndex === photosArray.length - 1 ? 'none' : 'flex';
        if (photosArray.length <= 1) {
            lightboxPrevious.style.display = 'none';
            lightboxNext.style.display = 'none';
        }
    }

    lightboxPrevious.addEventListener('click', () => {
        if (currentPhotoIndex > 0) {
            currentPhotoIndex--;
            updateLightboxImage();
        }
    });

    lightboxNext.addEventListener('click', () => {
        if (currentPhotoIndex < photosArray.length - 1) {
            currentPhotoIndex++;
            updateLightboxImage();
        }
    });

    closeLightbox.forEach(closeBtn => { 
        closeBtn.addEventListener('click', () => {
            lightbox.style.display = 'none'; 
        });
    });

    // Gestion des changements de filtres
    document.getElementById('select-filter-category').addEventListener('change', fetchPhotos);
    document.getElementById('select-filter-format').addEventListener('change', fetchPhotos);

    // Mise à jour de la lightbox au chargement de la page
    fetchPhotos();
});

