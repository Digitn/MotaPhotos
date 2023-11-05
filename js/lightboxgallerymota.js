document.addEventListener('DOMContentLoaded', function() {
    // Cela devrait sélectionner tous les conteneurs individuels des photos s'ils ont la classe '.photos-container'
    const photosContainers = document.querySelectorAll('.photos-container');
    const lightbox = document.getElementById('lightbox-gallery');
    const lightboxImage = document.querySelector('.lightbox-image'); 
    const imageReference = document.querySelector('.image-reference'); 
    const imageCategory = document.querySelector('.image-category'); 
    const closeLightbox = document.querySelectorAll('.lightbox-close'); 

    // Boucle à travers chaque conteneur de photos
    photosContainers.forEach(container => {
        container.addEventListener('click', e => {
            if (e.target.tagName === 'IMG' && e.target.classList.contains('photo-catalogue')) {
                lightboxImage.src = e.target.src; 
                imageReference.textContent = e.target.getAttribute('data-reference'); 
                imageCategory.textContent = e.target.getAttribute('data-category'); 
                lightbox.style.display = 'flex'; 
            }
        });
    });

    // Ajoute l'écouteur d'événements à chaque bouton de fermeture
    closeLightbox.forEach(closeBtn => { 
        closeBtn.addEventListener('click', () => {
            lightbox.style.display = 'none'; 
        });
    });
});
