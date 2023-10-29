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
				<button class="contact-btn preselect-ref">Contact</button>
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

<?php
endwhile; // End of the loop.

get_footer();
