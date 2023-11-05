document.addEventListener('DOMContentLoaded', function() {
    if (document.body.classList.contains('single')) {
        const photoPrincipale = document.querySelector('.photo-post-single');
        const categoriePrincipale = photoPrincipale ? photoPrincipale.dataset.category : '';
        const loadMoreBtn = document.querySelector('.load-more-btn');
        const postId = loadMoreBtn.dataset.postId;
        let offset = 2;

        function getAjaxUrl() {
            const depth = window.location.href.split('/').length - 6;
            return `${'../'.repeat(depth)}wp-admin/admin-ajax.php`;
        }

        loadMoreBtn.addEventListener('click', function() {
            const ajaxUrl = getAjaxUrl();
            fetch(ajaxUrl + `?action=load_more_cat_photos&offset=${offset}&post_id=${postId}&category=${categoriePrincipale}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const container = document.querySelector('.photos-container');
                    const loadedPhotos = data.data.photos;
                    loadedPhotos.forEach(photo => {
                        const div = document.createElement('div');
                        div.className = 'photos-catalogue';
                        div.innerHTML = `<img src="${photo.src}" class="photo-catalogue" alt="${photo.alt}" data-reference="Réf. photo : ${photo.reference}" data-category="Catégorie : ${photo.category}">`;
                        container.appendChild(div);
                    });

                    offset += loadedPhotos.length;
                    if (loadedPhotos.length < 12) {
                        loadMoreBtn.style.display = 'none';
                    }
                } else {
                    console.error('Erreur lors du chargement des photos');
                    loadMoreBtn.style.display = 'none';  // Cachez le bouton en cas d'erreur
                }
            })
            .catch(error => {
                console.error('Erreur :', error);
                loadMoreBtn.style.display = 'none';  // Cachez le bouton en cas d'erreur
            });
        });
    }
});
    