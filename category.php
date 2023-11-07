<?php
/**
 * The template for displaying category archives
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage MotaPhotos
 */

get_header();
?>
    <header class="archive-header">
        <h1 class="archive-title">
            Catégorie : <?php single_cat_title(); ?>
        </h1>
        <?php
        // Afficher la description de la catégorie, s'il y en a une.
        $category_description = category_description();
        if (!empty($category_description)) {
            echo '<div class="archive-meta">' . $category_description . '</div>';
        }
        ?>
    </header>

    <div class="picssame">
        <?php
        // Récupérer le slug de la catégorie en cours.
        $category = get_queried_object()->slug;

        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => -1, // Mettez -1 si vous voulez afficher toutes les photos
            'category_name' => $category
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            echo '<div class="catalogue-photos">';
            echo '<div class="photos-container">';

            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <div class="photos-catalogue">
                    <img src="<?= esc_url(get_field('affichage_photo')) ?>" class="photo-catalogue photo-catalogue-overlay" alt="<?= esc_attr(get_the_title()) ?>" 
                        data-url="<?= esc_url(get_field('affichage_photo')) ?>"
                        data-reference="Réf. photo : <?= esc_html(get_field('reference_photo')) ?>" 
                        data-category="Catégorie : <?= esc_html(get_the_category()[0]->name) ?>"
                        data-post-id="<?= esc_attr(get_the_ID()) ?>">
                    <img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/assets/img/expand.png" class="photo-expand" alt="icon photo-expand">
                    <a href="<?= esc_url(get_permalink()) ?>" target="_blank" class="photo-detail-link">
                        <img src="<?= esc_url(get_stylesheet_directory_uri()); ?>/assets/img/eye-regular.png" class="photo-infolink" alt="icon photo-infolink">
                    </a>
                </div>
                <?php
            }
            echo '</div>'; // .photos-container
            echo '</div>'; // .catalogue-photos
        } else {
            echo '<p>Aucune photo trouvée dans cette catégorie.</p>';
        }
        wp_reset_postdata();
        ?>
    </div>

<?php


// Fin de la boucle
get_template_part('template_parts/lightbox-gallery');
get_footer();
?>
