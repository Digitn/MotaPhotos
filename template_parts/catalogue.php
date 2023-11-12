<div class="catalogue-photos">

        <div class="catalogue-photos-filter swiper mySwiper">
            <div class="bloc-100 swiper-wrapper">
                <!-- Champ de sélection de catégorie -->
                <div class="catalogue-photos-select custom-select swiper-slide">
                    <select name="select-filter-category" id="select-filter-category" class="select-filter">
                        <option value="__label__"disabled select>Catégories</option>
                        <option value="">Toutes les catégories</option>
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) {
                            echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Champ de sélection de format -->
                <div class="catalogue-photos-select custom-select swiper-slide">
                    <select name="select-filter-format" id="select-filter-format" class="select-filter">
                        <option value="__label__"disabled select>Formats</option>
                        <option value="">Tous les formats</option>
                        <?php
                        $formats = get_terms('format_photo');
                        foreach ($formats as $format) {
                            echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Champ de tri -->
                <div class="catalogue-photos-select custom-select swiper-slide">
                    <select name="select-filter-sort"  id="select-filter-sort" class="select-filter">
                        <option value="__label__"disabled select>Tri par</option>
                        <option value="RAND">Tirage aléatoire</option>
                        <option value="DESC">Du plus récent au plus ancien</option>
                        <option value="ASC">Du plus ancien au plus récent</option>
                    </select>
                </div>
            </div>
        </div>

</div>

<div class="photos-container">
	<!-- Ici seront affichées les photos -->
</div>
<button class="load-more-btn photos-container-btn" data-post-id="<?= get_the_ID() ?>">Charger plus</button>
