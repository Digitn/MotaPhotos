<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage MotaPhotos
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :

	the_post();

		// Affichez les champs ACF
	?>
	<article class="picsinfo">
		<div class="bloc-info">
			<section class="infos-photo bloc-50">
				<h1><?= get_the_title() ?></h1>
				<p>Référence : <?= get_field('reference_photo') ?></p>
				<p>Catégorie : <?= the_category (',') ?></p>
				<p>Format : <?= get_the_term_list (get_the_ID(), 'format_photo' ) ?></p>
				<p>Type : <?= get_the_term_list (get_the_ID(), 'type_photo') ?></p>
				<p>Année : <?= get_field('date_photo') ?></p>				
			</section>
			<section class="photo-post bloc-50">
				<img src= "<?= get_field('affichage_photo') ?>" class= "photo-post-single photo-post-single-overlay" alt ="<?= get_the_title() ?>" 
				data-reference=" Réf. photo : <?= get_field('reference_photo') ?>" data-category= "Catégorie : <?= get_the_category()[0]->name ?>">
				<div class="icon-circle-container">
					<img src= "<?php echo get_stylesheet_directory_uri(); ?>/assets/img/expand.png" alt="icon-zoom" id="icon-zoom2" class="icon-zoom">
				</div>
				<?php //Lightbox pour les photos
					get_template_part ('template_parts/lightbox'); 
				?>
			</section>
		</div>
		<div class="bloc-link">
			<div class="contact-link bloc-50">
				<p>Cette photo vous intéresse ?</p>
				<button class="contact-btn contact-btn-preselect">Contact</button>
			</div>
			<div class="nav-link-photo">
				<?php
				// Previous/next post navigation.
				$arrow_left = get_stylesheet_directory_uri() . '/assets/img/Line 6.svg';
				$arrow_right = get_stylesheet_directory_uri() . '/assets/img/Line 7.svg';
				$next_post_image = get_field('affichage_photo', get_next_post());
				$prev_post_image = get_field('affichage_photo', get_previous_post());

				the_post_navigation(
					array(
						'next_text' => '<p class="meta-nav">' . '<img src="' . $next_post_image . '" alt="Next Image">' . '<img src="' . $arrow_right . '"class="arrow" alt="Next Image">',
						'prev_text' => '<p class="meta-nav">' . '<img src="' . $prev_post_image . '" alt="Previous Image">' . '<img src="' . $arrow_left . '"class="arrow" alt="Previous Image">',
					)
				);
				?>
			</div>
		</div>
	</article>

	<div class="picssame">
        <div class="catalogue-photos">
			<h3>Vous aimerez aussi</h3>
			<div class="photos-container">
				<?php
				$category = get_the_category()[0]->slug;
				$args = array(
					'post_type' => 'photos',
					'posts_per_page' => 2,
					'category_name' => $category,
					'post__not_in' => array(get_the_ID()),
				);

				$query = new WP_Query($args);

				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						?>
						<div class="photos-catalogue">
							<img src="<?= get_field('affichage_photo') ?>" class="photo-catalogue" alt="<?= get_the_title() ?>" 
								data-reference="Réf. photo : <?= get_field('reference_photo') ?>" 
								data-category="Catégorie : <?= get_the_category()[0]->name ?>">
						</div>
						<?php
					}
				} else {
					echo 'Aucune autre photo trouvée dans cette catégorie.';
				}
				
				
				// Remettre les données du post principal
				wp_reset_postdata();
				
				// Compter le nombre total de photos dans la catégorie
				$total_photos_args = array(
					'post_type' => 'photos',
					'category_name' => $category,
					'post__not_in' => array(get_the_ID()),
					'fields' => 'ids',
				);
				
				$total_photos_query = new WP_Query($total_photos_args);
				$total_photos = $total_photos_query->found_posts;
			echo '</div>';
			if ($total_photos > 2) {
				echo '<button class="load-more-btn photos-container-btn" data-post-id="' . get_the_ID() . '">Toutes les photos</button>';  
			}
			?>
		</div>
    </div>
<?php
endwhile; // End of the loop.

//Lightbox pour les photos
get_template_part ('template_parts/lightbox-gallery'); 

get_footer();
?>
