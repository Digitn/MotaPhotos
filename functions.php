<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}

function add_active_class($classes, $item) {
    if (is_page($item->title) || is_page($item->object_id)) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'add_active_class' , 10 , 2);