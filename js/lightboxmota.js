document.addEventListener('DOMContentLoaded', function() {
    if (document.body.classList.contains('single')) {
        const photos = document.querySelectorAll('.photo-post-single');
        const lightbox = document.getElementById('lightbox-light');
        const lightboxImage = document.querySelector('.lightbox-image'); 
        const imageReference = document.querySelector('.image-reference'); 
        const imageCategory = document.querySelector('.image-category'); 
        const closeLightbox = document.querySelectorAll('.lightbox-close'); 

        photos.forEach(photo => {
            photo.addEventListener('click', e => {
                lightboxImage.src = photo.src; 
                imageReference.textContent = photo.getAttribute('data-reference'); 
                imageCategory.textContent = photo.getAttribute('data-category'); 
                lightbox.style.display = 'flex'; 
            });
        });

        closeLightbox.forEach(closeBtn => { 
            closeBtn.addEventListener('click', () => {
                lightbox.style.display = 'none'; 
            });
        });
    }
});
