<?php
/**
 * The main template file
 * @package WordPress
 * @subpackage MotaPhotos
 */

get_header(); 
    //Contenu de la page d'accueil
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            the_title('<h2>', '</h2>');
            the_content();
        endwhile;
    else :
        echo '<p>Aucun contenu trouvé</p>';
    endif;

get_footer();
?>