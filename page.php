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

echo '<div id="primary" class="content-area">';
echo '<main id="main" class="site-main">';

    while ( have_posts() ) :
        the_post();

        get_template_part( 'template_parts/content', 'page' ); // Inclut le contenu de la page

        // Si les commentaires sont ouverts ou s'il y a au moins un commentaire, charge le template de commentaires.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // Fin de la boucle.


echo  '</main>'; // main 
echo  '</div>'; // primary


get_footer();
?>
