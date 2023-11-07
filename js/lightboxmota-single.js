document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox-gallery');
    const lightboxImage = lightbox.querySelector('.lightbox-image');
    const imageReference = lightbox.querySelector('.image-reference');
    const imageCategory = lightbox.querySelector('.image-category');
    const closeLightbox = lightbox.querySelector('.lightbox-close');
    const nextButton = lightbox.querySelector('.lightbox-next-photo');
    const previousButton = lightbox.querySelector('.lightbox-previous-photo');

    let imagesInCategory = [];
    let currentImageIndex = 0;

    function getAjaxUrl() {
        const depth = window.location.href.split('/').length - 6;
        return `${'../'.repeat(depth)}wp-admin/admin-ajax.php`;
    }
    
    function fetchImagesInCategory(postId, src) {
        const ajaxUrl = getAjaxUrl();
        fetch(`${ajaxUrl}?action=load_cat_photos&post_id=${postId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.data.length > 0) {
                imagesInCategory = data.data;
                const clickedImageIndex = imagesInCategory.findIndex(image => image.src === src);
                if (clickedImageIndex !== -1) {
                    updateLightbox(clickedImageIndex);
                } else {
                    updateLightbox(0); 
                }
            } else {
                throw new Error('Aucune photo trouvée dans cette catégorie.');
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des photos: ', error);
        });
    }

    function updateLightbox(index) {
        if (imagesInCategory.length > index) {
            const image = imagesInCategory[index];
            lightboxImage.src = image.src;
            lightboxImage.alt = image.alt;
            imageReference.textContent = "Réf. photo : " + image.reference;
            imageCategory.textContent = "Catégorie : " + image.category;
            currentImageIndex = index;
            toggleNavigation();
        }
    }

    function toggleNavigation() {
        previousButton.style.visibility = currentImageIndex === 0 ? 'hidden' : 'visible';
        nextButton.style.visibility = currentImageIndex === imagesInCategory.length - 1 ? 'hidden' : 'visible';
    }

    closeLightbox.addEventListener('click', function() {
        lightbox.style.display = 'none';
        clearLightboxInfo();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            lightbox.style.display = 'none';
            clearLightboxInfo();
        }
    });

    nextButton.addEventListener('click', function() {
        if (currentImageIndex < imagesInCategory.length - 1) {
            updateLightbox(currentImageIndex + 1);
        }
    });

    previousButton.addEventListener('click', function() {
        if (currentImageIndex > 0) {
            updateLightbox(currentImageIndex - 1);
        }
    });

    document.addEventListener('click', function(event) {
        let target = event.target;
        
        if (target.classList.contains('photo-expand')) {
            // Initialiser photoElement comme null
            let photoElement = null;
            
            // Si le clic est sur un élément .photo-expand dans .photos-catalogue
            if (target.closest('.photos-catalogue')) {
                photoElement = target.closest('.photos-catalogue').querySelector('.photo-catalogue');
            }
            // Sinon, si le clic est sur un élément .photo-expand dans .photo-post
            else if (target.closest('.photo-post')) {
                photoElement = target.closest('.photo-post').querySelector('.photo-post-single');
            }
            
            // Si photoElement a été trouvé, ouvrez la lightbox
            if (photoElement) {
                openLightboxWithPhotoElement(photoElement);
            }
        }
    });
      
    function openLightboxWithPhotoElement(photoElement) {
        const src = photoElement.getAttribute('src');
        const postId = photoElement.getAttribute('data-post-id');
        lightbox.style.display = 'flex';
        fetchImagesInCategory(postId, src);
    }

    function clearLightboxInfo() {
        // Effacer la source de l'image et les alt pour éviter d'afficher une image obsolète ou incorrecte
        lightboxImage.src = '';
        lightboxImage.alt = '';
        
        // Effacer le contenu des informations de l'image
        imageReference.textContent = '';
        imageCategory.textContent = '';
    }
});
