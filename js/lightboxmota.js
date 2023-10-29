document.addEventListener('DOMContentLoaded', function() {
    const photos = document.querySelectorAll('.photo-post-single');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const imageReference = document.getElementById('image-reference');
    const imageCategory = document.getElementById('image-category');
    const closeLightbox = document.getElementById('lightbox-close');

    lightbox.style.display = "none";

    photos.forEach(photo => {
        photo.addEventListener('click', e => {
            lightboxImage.src = photo.src;
            imageReference.textContent = photo.getAttribute('data-reference');
            imageCategory.textContent = photo.getAttribute('data-category');
            lightbox.style.display = 'flex';
        });
    });

    closeLightbox.addEventListener('click', () => {
        lightbox.style.display = 'none';
    });
});

