<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
    <header id="header">
        <div class="topmenu">
            <!-- Logo -->
            <a href="<?php echo home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Logo.png" alt="Logo Motaphoto" id="logo"></a>
            <!-- Navigation -->
            <nav>
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                    ) );
                ?>
            </nav>
        </div>
        <div class="banner">
            <h1>Photographe Event</h1>
        </div>
    </header>

    <!-- Contenu de la page -->
    <div id="content">
