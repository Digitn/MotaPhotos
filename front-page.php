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

get_template_part ('template_parts/catalogue');

get_template_part ('template_parts/lightbox-gallery');

get_footer();
?>
