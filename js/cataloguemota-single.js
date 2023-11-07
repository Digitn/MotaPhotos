document.addEventListener('DOMContentLoaded', function() {
    const photoPrincipale = document.querySelector('.photo-post-single');
    const categoriePrincipale = photoPrincipale ? photoPrincipale.dataset.category : '';
    const loadMoreBtn = document.querySelector('.load-more-btn');
    let offset = 2;

    function getAjaxUrl() {
        const depth = window.location.href.split('/').length - 6;
        return `${'../'.repeat(depth)}wp-admin/admin-ajax.php`;
    }

    if (loadMoreBtn){
        loadMoreBtn.addEventListener('click', function() {
            const postId = loadMoreBtn.dataset.postId;
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
                        div.innerHTML = `<img src="${photo.src}" class="photo-catalogue photo-catalogue-overlay" alt="${photo.alt}" 
                                        data-reference="Réf. photo : ${photo.reference}" data-category="Catégorie : ${photo.category}"
                                        data-post-id="${photo.post_id}">
                                        <img src="../../wp-content/themes/MotaPhotos/assets/img/expand.png" class="photo-expand" alt="icon photo-expand">
                                        <a href="${photo.detail_url}" target="_blank" class="photo-detail-link">
                                            <img src="../../wp-content/themes/MotaPhotos/assets/img/eye-regular.png" class="photo-infolink" alt="icon photo-infolink">
                                        </a>`;
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
    