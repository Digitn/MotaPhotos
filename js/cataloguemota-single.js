document.addEventListener('DOMContentLoaded', function() {
    const photoPrincipale = document.querySelector('.photo-post-single');
    const categoriePrincipale = photoPrincipale ? photoPrincipale.dataset.category : '';
    const loadMoreBtn = document.querySelector('.load-more-btn');
    let offset = 2;

    if (loadMoreBtn){
        loadMoreBtn.addEventListener('click', function() {
            const postId = loadMoreBtn.dataset.postId;
            fetch(ajax_vars.ajaxurl + `?action=load_more_cat_photos&offset=${offset}&post_id=${postId}&category=${categoriePrincipale}`)
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
                                        <div class="photo-detail-expand">
                                            <img src="../../wp-content/themes/MotaPhotos/assets/img/expand.png" class="photo-expand" alt="icon photo-expand">
                                            <p class="photo-expand-message">Agrandir cette photo</p>
                                        </div>
                                        <a href="${photo.detail_url}" class="photo-detail-link">
                                            <img src="../../wp-content/themes/MotaPhotos/assets/img/eye-regular.png" class="photo-infolink" alt="icon photo-infolink">
                                            <p class="photo-infolink-message">Plus d'infos sur cette photo</p>
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
    