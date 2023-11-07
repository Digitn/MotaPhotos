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
    <header>
        <div class="barmenu">
            <div class="topmenu">
                <!-- Logo -->
                <a href="<?php echo home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Logo.png" alt="Logo Motaphoto" id="logo"></a>
                <!-- Navigation -->
                <nav>
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'main',
                            'menu_id' => 'primary-menu',
                        ) );
                    ?>
                </nav>
            </div>
        </div>
        <?php if ( is_front_page() ) : ?>
            <div class="hero">
                <h1>Photographe Event</h1>
            </div>
        <?php endif; ?>
    </header>

    <!-- Contenu de la page -->
    <main id="content">
