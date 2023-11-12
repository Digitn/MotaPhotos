document.addEventListener('DOMContentLoaded', function() {
    let photosData = []; 
    let displayedPhotos = 0; 
    const photosPerLoad = 12; 
    let currentFilters = { category: '', format: '', sort: '' }; // Initialisation des filtres actuels
    let offset = 0; 
    const photosContainer = document.querySelector('.photos-container');

    function displayPhotos() {
        let existingDivs = photosContainer.querySelectorAll('.photos-catalogue');
        const photosToDisplay = photosData.slice(0, displayedPhotos + photosPerLoad);
    
        // Mise à jour ou ajout de photos
        photosToDisplay.forEach((photo, index) => {
            if (index < existingDivs.length) {
                // Mise à jour des photos existantes
                const photoDiv = existingDivs[index];
                const img = photoDiv.querySelector('img');
                img.src = photo.photo_url;
                img.alt = photo.title;
                img.dataset.reference = photo.reference;
                img.dataset.category = photo.category;
                const detailLink = photoDiv.querySelector('.photo-detail-link');
                detailLink.href = photo.detail_url;
            } else {
                // Ajout de nouvelles divs si nécessaire
                photosContainer.insertAdjacentHTML('beforeend',
                    `<div class="photos-catalogue">
                        <img src="${photo.photo_url}" class="photo-catalogue photo-catalogue-overlay" alt="${photo.title}"
                        data-reference="Réf. photo : ${photo.reference}"
                        data-category="Catégorie : ${photo.category}">
                        <div class="photo-detail-expand">
                            <img src="./wp-content/themes/MotaPhotos/assets/img/expand.png" class="photo-expand" alt="icon photo-expand">
                            <p class="photo-expand-message">Agrandir cette photo</p>
                        </div>
                        <a href="${photo.detail_url}" class="photo-detail-link">
                            <img src="./wp-content/themes/MotaPhotos/assets/img/eye-regular.png" class="photo-infolink" alt="icon photo-infolink">
                            <p class="photo-infolink-message">Plus d'infos sur cette photo</p>
                        </a>
                    </div>`);
            }
        });
    
        // Suppression des divs en trop
        for (let i = photosToDisplay.length; i < existingDivs.length; i++) {
            existingDivs[i].remove();
        }
    
        displayedPhotos = photosToDisplay.length; // Mise à jour du nombre de photos affichées
        updateLoadMoreButton(); // Vérifier si le bouton "load more" doit être affiché
    }
    

    function loadPhotos() {
        const params = new URLSearchParams();
        params.append('action', 'get_and_display_photos');
        params.append('offset', offset);
        params.append('category', currentFilters.category);
        params.append('format_photo', currentFilters.format);
        params.append('date_photo', currentFilters.sort);
        
        fetch(ajax_vars.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: params
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            photosData = JSON.parse(data);
            if (Array.isArray(photosData) && photosData.length > 0) {
                let photos = photosData;
                if (currentFilters.sort === 'RAND') {
                    photos = shuffleArray(photos);
                }
                displayPhotos(); // Afficher les photos
            } else {
                // S'il n'y a pas de photos, effacez l'affichage et montrez un message
                photosContainer.innerHTML = '';
                const message = document.createElement('p');
                message.classList.add('no-photos-message');
                message.textContent = "Aucune photo n'a été trouvée selon vos critères de sélection.";
                photosContainer.appendChild(message);
            }
        })        
        .catch(error => {
            console.error('Erreur :', error);
        });
    }

    function updateLoadMoreButton() {
        const loadMoreBtn = document.querySelector('.load-more-btn');
        if (displayedPhotos >= photosData.length) {
            loadMoreBtn.style.display = 'none';
        } else {
            loadMoreBtn.style.display = 'block';
        }
    }

    function applyFilters() {
        const message = photosContainer.querySelector('.no-photos-message');
        const categorie = document.getElementById('select-filter-category').value;
        const format = document.getElementById('select-filter-format').value;
        const tri = document.getElementById('select-filter-sort').value;
    
        if (currentFilters.category !== categorie || currentFilters.format !== format || currentFilters.sort !== tri) {
            if (message) {
                message.remove();
            }
            displayedPhotos = 0;
        }
    
        currentFilters.category = categorie;
        currentFilters.format = format;
        currentFilters.sort = tri;
        displayedPhotos = 0; 
        loadPhotos();
    }
    
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    //Fonction permettant de customiser le css des <select> de formulaire
    function initCustomSelects() {
        document.querySelectorAll('select:not(.wpcf7-form select)').forEach(function (selectElement) {
            var numberOfOptions = selectElement.children.length;
            selectElement.classList.add('s-hidden');

            var divWrapper = document.createElement('div');
            divWrapper.classList.add('select');
            selectElement.parentNode.insertBefore(divWrapper, selectElement);
            divWrapper.appendChild(selectElement);

            var styledSelect = document.createElement('div');
            styledSelect.classList.add('styledSelect');
            styledSelect.textContent = selectElement.children[0].textContent;
            divWrapper.appendChild(styledSelect);

            var list = document.createElement('ul');
            list.classList.add('options');
            divWrapper.appendChild(list);

            for (var i = 0; i < numberOfOptions; i++) {
                var listItem = document.createElement('li');
                listItem.textContent = selectElement.children[i].textContent;
                listItem.setAttribute('rel', selectElement.children[i].value);
                list.appendChild(listItem);
            }

            styledSelect.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleOptionsList(this, list);
            });

            Array.from(list.children).forEach(function (listItem) {
                listItem.addEventListener('click', function (e) {
                    e.stopPropagation();
                    styledSelect.textContent = this.textContent;
                    selectElement.value = this.getAttribute('rel');
                    selectElement.dispatchEvent(new Event('change'));
                    toggleOptionsList(styledSelect, list, true);
                });
            });
        });

        function toggleOptionsList(styledSelect, list, close = false) {
            if (!close) {
                var isActive = styledSelect.classList.contains('active');
                if (!isActive) {
                    closeAllSelects(); // Ferme toutes les autres listes déroulantes
                    styledSelect.classList.add('active');
                    list.classList.add('options-open');
                    list.classList.remove('options-close');
                } else {
                    styledSelect.classList.remove('active');
                    list.classList.remove('options-open');
                    list.classList.add('options-close');
                }
            } else {
                styledSelect.classList.remove('active');
                list.classList.remove('options-open');
                list.classList.add('options-close');
            }
        }

        function closeAllSelects() {
            document.querySelectorAll('.styledSelect').forEach(function (select) {
                select.classList.remove('active');
            });
            document.querySelectorAll('.options').forEach(function (optionList) {
                optionList.classList.remove('options-open');
                optionList.classList.add('options-close');
            });
        }

        document.addEventListener('click', function () {
            closeAllSelects();
        });

        cacherOptionsNull();
    }


    function cacherOptionsNull() {
        document.querySelectorAll('.select').forEach(function(selectWrapper) {
            var optionsList = selectWrapper.querySelector('.options');
            if (optionsList) {
                Array.from(optionsList.children).forEach(function(listItem) {
                    var optionValue = listItem.getAttribute('rel');
                    if (optionValue === 'null' || optionValue === '__label__' || optionValue === 'non-classe') {
                        listItem.style.display = 'none';
                    } else {
                        listItem.style.display = 'block';
                    }
                });
            }
        });
    } 

    // Event listeners pour les filtres
    document.getElementById('select-filter-category').addEventListener('change', applyFilters);
    document.getElementById('select-filter-format').addEventListener('change', applyFilters);
    document.getElementById('select-filter-sort').addEventListener('change', applyFilters);
    document.querySelector('.load-more-btn').addEventListener('click', function() {
        loadPhotos(); 
    });
    
    loadPhotos();
    initCustomSelects();
});  


