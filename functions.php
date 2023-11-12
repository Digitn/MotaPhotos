<?php

// Enregistrement des styles et scripts
function theme_enqueue_styles() {
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


function motaphoto_scripts() {
    //wp_register_script( 'menumobilemota', get_stylesheet_directory_uri() . '/js/menumobilemota.js', array(), null, true );
    wp_register_script( 'swiperjs', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), null, true );
    wp_register_script( 'swipermota', get_stylesheet_directory_uri() . '/js/swipermota.js', array('swiper'), null, true );

    $inline_script = <<<EOD
    function loadScript(src, id) {
        // Si le script avec l'ID spécifié existe déjà, ne le charge pas à nouveau
        if (document.getElementById(id)) return;
    
        var script = document.createElement("script");
        script.src = src;
        script.id = id;
        script.async = false;
        document.head.appendChild(script);
    }
    
    window.addEventListener("load", function() {
        var screenWidth = window.innerWidth;
        if (screenWidth <= 768) {
            loadScript("https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js");
            loadScript("./wp-content/themes/MotaPhotos/js/swipermota.js", "swipermota-script");
        }
    });
    
    window.addEventListener("resize", function() {
        var screenWidth = window.innerWidth;
        if (screenWidth <= 768) {
            loadScript("https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js");
            loadScript("./wp-content/themes/MotaPhotos/js/swipermota.js", "swipermota-script");
        }
    });    
    EOD;

    // Ajouter les scripts personnalisés selon les conditions
    if (is_front_page()) {
        wp_enqueue_script('cataloguemota-page', get_stylesheet_directory_uri() . '/js/cataloguemota-page.js', array(), null, true);
        wp_enqueue_script('lightboxmota-page', get_stylesheet_directory_uri() . '/js/lightboxmota-page.js', array(), null, true);
        wp_add_inline_script('popupmota', $inline_script);
    }

    if (is_single() || is_category()) {
        wp_enqueue_script('cataloguemota-single', get_stylesheet_directory_uri() . '/js/cataloguemota-single.js', array(), null, true);
        wp_enqueue_script('lightboxmota-single', get_stylesheet_directory_uri() . '/js/lightboxmota-single.js', array(), null, true);
    }

    // Scripts toujours nécessaires
    wp_enqueue_script('menumota', get_stylesheet_directory_uri() . '/js/menumota.js', array(), null, true);
    wp_enqueue_script('popupmota', get_stylesheet_directory_uri() . '/js/popupmota.js', array(), null, true);

    // Localiser les scripts pour l'AJAX
    wp_localize_script('popupmota', 'ajax_vars', array('ajaxurl' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'motaphoto_scripts');
    


//**************************************** */
// Menu admin - thème WP Motaphotos
//**************************************** */
function motaphoto_login_logo_url() {
    return home_url(); // URL à laquelle le logo doit pointer
}
add_filter('login_headerurl', 'motaphoto_login_logo_url');

function motaphoto_login_logo_url_title() {
    return 'Nathalie Mota'; 
}
add_filter('login_headertext', 'motaphoto_login_logo_url_title');

function motaphoto_login_message($message) {
    if (empty($message)) {
        return "<p class='message'>Bienvenue sur l'interface de connexion de votre site web</p>";
    } else {
        return $message;
    }
}
add_filter('login_message', 'motaphoto_login_message');


function motaphoto_custom_login_style() {
    echo '<style type="text/css">
            @font-face {
            font-family: \'Space Mono\';
            src: url(' . get_template_directory_uri() . '/assets/fonts/SpaceMono-Regular.ttf) format(\'truetype\'),
            font-weight: normal;
            font-style: normal;
            font-display: swap;
            }
            @font-face {
                font-family: \'Space Mono Bold\';
                src: url(' . get_template_directory_uri() . '/assets/fonts/SpaceMono-Bold.ttf) format(\'truetype\'),
                font-weight: bold;
                font-style: normal;
                font-display: swap;
                }
            body.login {
                background-image: url(' . get_template_directory_uri() . '/assets/img/banner.webp); 
                background-size: cover;
                background-blend-mode: color-burn;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: \'Space Mono\';
            }
            #login{
                display: flex;
                align-content: center;
                justify-content: center;
                flex-wrap: wrap;
                margin: auto;
                position: absolute;
                padding: 0;
                width: 300px;
            }
            .login .message, .login .notice, .login .success {
                border-left: 4px solid #e00000;
                width: 320px;
                font-size: 13px;
                display: flex;
                text-align: center;
            }
            #login label{
                cursor: default;
            }
            #login .button-primary{
                background: #000;
                border-color: #000;
                border-radius: 2px;
                float: unset;
                margin: 20px auto 0px;
                display: flex;
                width: 175px;
                justify-content: center;
                height: 45px;
                align-items: center;
                align-content: center;
                flex-wrap: wrap;
                font-size: 16px;
            }
            #login .button-secondary {
                color: #000;
            }
            #login .button-secondary:focus {
                border-color: unset; 
                box-shadow: none;
            }
            #login .button-primary:hover{
                transform: scale(1.02);
            }
            #login .button-primary:active{
                transform: scale(0.98);
            }
            #login .button-primary:focus{
                box-shadow: none;
            }
            #login .button-primary:focus-visible{
                border-radius: 2px;
            }
            #login input[type=text]:focus, #login input[type=password]:focus{
                border-color: #e00000;
                box-shadow: 0 0 0 1px #e00000;
            }
            body.login div#login h1 a {
                background-image: url(' . get_template_directory_uri() . '/assets/img/Logo.png); 
                background-size: contain; /* Ajustez la taille du logo */
                mix-blend-mode: hard-light;
                width: 300px;
                height: auto;
            }
            #login #nav a:hover, #login #backtoblog a:hover{
                color: #000;
                font-weight: bold;
                transform: scale(1.02);
            }
            .login form {
                margin-top:0;
                border: 2px solid #000;
            }
            .login .language-switcher, .login .privacy-policy-page-link, .login .forgetmenot { 
                display: none; 
            }

        </style>';
}
add_action('login_head', 'motaphoto_custom_login_style');



function motaphotos_admin_scripts($hook) {
    if ('toplevel_page_motaphotos-settings' !== $hook) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('motaphotos-admin-js', get_template_directory_uri() . '/js/admin.js', array(), '1.0', true);
}
add_action('admin_enqueue_scripts', 'motaphotos_admin_scripts');


//Ajout menu perso MotaPhotos dans interface admin
// Section Paramètres perso
function motaphotos_add_admin_pages() {
    add_menu_page(
        __('Votre thème Motaphotos', 'motaphotos'),
        __('Motaphotos', 'motaphotos'),
        'manage_options',
        'motaphotos-settings',
        'motaphotos_theme_settings',
        'dashicons-admin-settings',
        60
    );
}
//Section Historique de modifications du site
function motaphotos_theme_settings() {
    echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>';
    echo '<form action="options.php" method="post" name="motaphotos_settings" enctype="multipart/form-data">';
    echo '<div>';
    settings_fields('motaphotos_settings_fields');
    do_settings_sections('motaphotos_settings_section');
    submit_button();
    echo '</div>';
    echo '</form>';

    motaphotos_dev_section_introduction(); 
}

//Enregistrement favicon
function motaphotos_favicon() {
    $favicon_url = get_option('motaphotos_favicon_url'); 
    if (!empty($favicon_url)) {
        echo '<link rel="icon" href="' . esc_url($favicon_url) . '" sizes="32x32" />';
    }
}
add_action('wp_head', 'motaphotos_favicon');

function motaphotos_admin_favicon() {
    $favicon_url = get_option('motaphotos_favicon_url'); // Remplacez par l'URL de votre favicon.
    echo '<link rel="icon" href="' . esc_url($favicon_url) . '" sizes="32x32" />';
}
add_action('admin_head', 'motaphotos_admin_favicon');


// Champs de saisie informations interventions développeurs
function motaphotos_settings_register() {
    register_setting('motaphotos_settings_fields', 'motaphotos_settings_fields', 'motaphotos_settings_fields_validate');
    add_settings_section('motaphotos_settings_section', __('Paramètres', 'motaphotos'), 'motaphotos_settings_section_introduction', 'motaphotos_settings_section');
    add_settings_field('motaphotos_settings_field_slogan', __('Slogan', 'motaphotos'), 'motaphotos_settings_field_slogan_output', 'motaphotos_settings_section', 'motaphotos_settings_section');
    add_settings_field('motaphotos_settings_field_introduction', __('Introduction', 'motaphotos'), 'motaphotos_settings_field_introduction_output', 'motaphotos_settings_section', 'motaphotos_settings_section');
    add_settings_field('motaphotos_settings_field_favicon', __('Favicon', 'motaphotos'), 'motaphotos_settings_field_favicon_output', 'motaphotos_settings_section', 'motaphotos_settings_section');
    add_settings_field('motaphotos_settings_field_phone_number', __('Numéro de téléphone', 'motaphotos'), 'motaphotos_settings_field_phone_number_output', 'motaphotos_settings_section', 'motaphotos_settings_section');
    add_settings_field('motaphotos_settings_field_email', __('Email', 'motaphotos'), 'motaphotos_settings_field_email_output', 'motaphotos_settings_section', 'motaphotos_settings_section');
}

function motaphotos_settings_fields_validate($inputs) {
    if (!empty($_POST['motaphotos_settings_field_slogan'])) {
        update_option('blogdescription', $_POST['motaphotos_settings_field_slogan']);
    }
    if (!empty($_POST['motaphotos_settings_field_introduction'])) {
        update_option('motaphotos_settings_field_introduction', $_POST['motaphotos_settings_field_introduction']);
    }
    if (!empty($_POST['motaphotos_favicon_url'])) {
        update_option('motaphotos_favicon_url', $_POST['motaphotos_favicon_url']);
    }
    if (!empty($_POST['motaphotos_settings_field_phone_number'])) {
        update_option('motaphotos_settings_field_phone_number', $_POST['motaphotos_settings_field_phone_number']);
    }
    if (!empty($_POST['motaphotos_settings_field_email'])) {
        update_option('motaphotos_settings_field_email', $_POST['motaphotos_settings_field_email']);
    }
    return $inputs;
}

function motaphotos_settings_section_introduction() {
    _e('Paramètrez les différentes options de votre thème Motaphotos.', 'motaphotos');
}
function motaphotos_settings_field_slogan_output() {
    $slogan = get_option('blogdescription');
    echo '<input name="motaphotos_settings_field_slogan" type="text" value="' . esc_attr($slogan) . '" />';
}
function motaphotos_settings_field_introduction_output() {
    $value = get_option('motaphotos_settings_field_introduction');
    echo '<input name="motaphotos_settings_field_introduction" type="text" value="' . $value . '" />';
}
function motaphotos_settings_field_favicon_output() {
    $favicon_url = get_option('motaphotos_favicon_url');
    echo '<input type="text" name="motaphotos_favicon_url" value="' . esc_attr($favicon_url) . '" readonly /></br></br>'; 
    echo '<input type="button" class="button" value="' . __('Sélectionner un Favicon', 'motaphotos') . '" id="upload-favicon-button">';
}
function motaphotos_settings_field_phone_number_output() {
    $value = get_option('motaphotos_settings_field_phone_number');
    echo '<input name="motaphotos_settings_field_phone_number" type="text" value="' . $value . '" />';
}
function motaphotos_settings_field_email_output() {
    $value = get_option('motaphotos_settings_field_email');
    echo '<input name="motaphotos_settings_field_email" type="text" value="' . $value . '" />';
}


// Fonction pour afficher et enregistrer les interventions
function motaphotos_dev_section_introduction() {
    
    // Récupérer les développeurs enregistrés
    $developers = get_option('motaphotos_developers', array());

    // Afficher le formulaire pour ajouter un nouveau développeur
    echo '<div class="developer-form">';
    echo '<br><h2>Historique du site</h2>';
    _e('Renseignez les différents développeurs de votre thème Motaphotos ainsi que leurs contributions :', 'motaphotos');
    echo '<form action="' . admin_url('admin-post.php') . '" method="post">';
    echo '<input type="hidden" name="action" value="add_new_developer">';

    // Champs de saisie
    echo '<p>Date: <input type="date" name="motaphotos_dev_field_date" required></p>';
    echo '<p>Action effectuée: <input type="text" name="motaphotos_dev_field_typemodif" required></p>';
    echo '<p>Nom  du développeur ou de la société: <input type="text" name="motaphotos_dev_field_name" required></p>';
    echo '<p>Email: <input type="email" name="motaphotos_dev_field_email" required></p>';

    // Bouton d'enregistrement
    echo '<p><input class="button button-primary" type="submit" value="Enregistrer"></p>';
    echo '</form>';
    echo '</div>';
    echo '<br><h3>Liste des développeurs ayant contribué au développement :</h3>';

    // Vérifier si des développeurs ont été enregistrés
    if (!empty($developers)) {
        // Trier les développeurs par date
        usort($developers, function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Afficher les développeurs
        echo '<div class="developers-list">';
        foreach ($developers as $key => $developer) {
            echo '<div class="developer">';
            echo '<h4>Intervention n°' . ($key + 1) . '</h4>';
            $date = new DateTime($developer['date']);
            setlocale(LC_TIME, 'fr_FR.UTF-8');
            echo '<p>Date : ' . strftime('%d %B %Y', strtotime($date->format('Y-m-d'))) . '</p>';
            echo '<p>Action effectuée : ' . $developer['typemodif'] . '</p>';
            echo '<p>Nom : ' . $developer['name'] . '</p>';
            echo '<p>Email: ' . $developer['email'] . '</p>';
            echo '<form action="' . admin_url('admin-post.php') . '" method="post">';
            echo '<input type="hidden" name="action" value="delete_developer">';
            echo '<input type="hidden" name="developer_index" value="' . $key . '">';
            echo '<input class="button" type="submit" value="Supprimer cette entrée">';
            echo '<p><span class="dashicons dashicons-warning"></span> Attention, cette action est irréversible</p><br>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
    }
}

// Ajout nouvelle intervention
function add_new_developer() {
    $date = isset( $_POST['motaphotos_dev_field_date'] ) ? $_POST['motaphotos_dev_field_date'] : '';
    $typemodif = isset( $_POST['motaphotos_dev_field_typemodif'] ) ? $_POST['motaphotos_dev_field_typemodif'] : '';
    $name = isset( $_POST['motaphotos_dev_field_name'] ) ? $_POST['motaphotos_dev_field_name'] : '';
    $email = isset( $_POST['motaphotos_dev_field_email'] ) ? $_POST['motaphotos_dev_field_email'] : '';

    if ( $date && $name && $email ) {
        $developer = array(
            'date' => $date,
            'typemodif' => $typemodif,
            'name' => $name,
            'email' => $email,
        );

        $developers = get_option( 'motaphotos_developers', array() );
        $developers[] = $developer;

        update_option( 'motaphotos_developers', $developers );
    }
    wp_redirect( admin_url( 'admin.php?page=motaphotos-settings' ) );
    exit;
}

// Suppression intervention
function delete_developer() {
    $index = isset($_POST['developer_index']) ? $_POST['developer_index'] : '';

    if ($index !== '') {
        $developers = get_option('motaphotos_developers', array());

        if (isset($developers[$index])) {
            unset($developers[$index]);
            $developers = array_values($developers);
            update_option('motaphotos_developers', $developers);
        }
    }
    wp_redirect( admin_url( 'admin.php?page=motaphotos-settings' ) );
    exit;
}

add_action('admin_menu', 'motaphotos_add_admin_pages', 10);
add_action('admin_init', 'motaphotos_settings_register');
add_action( 'admin_post_add_new_developer', 'add_new_developer' );
add_action( 'admin_post_nopriv_add_new_developer', 'add_new_developer' );
add_action( 'admin_post_delete_developer', 'delete_developer' );



// Gestion des menus du site
function register_my_menu(){
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}
add_action('after_setup_theme', 'register_my_menu');

function add_active_class($classes, $item) {
    if (is_page($item->title) || is_page($item->object_id)) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'add_active_class' , 10 , 2);



//****************************************************************************** */
//****************************************************************************** */
//****************************************************************************** */
//***********************Code nécessaire pour le front ************************* */
//**Toutes les fonctions et hooks nécessaires pour les fonctionnalités du site * */
//****************************************************************************** */
//****************************************************************************** */
//****************************************************************************** */


//**Gestion filtres photos Ajax
// Page d'accueil : Gestion affichage
function get_and_display_photos() {
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format_photo']) ? sanitize_text_field($_POST['format_photo']) : '';
    $sort = isset($_POST['date_photo']) && in_array($_POST['date_photo'], ['ASC', 'DESC']) ? $_POST['date_photo'] : 'DESC'; 

    $args = array(
        'post_type' => 'photos',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'meta_value_num', 
        'meta_key' => 'date_photo', 
        'order' => $sort,
        'offset' => $offset,
    );

    $tax_query = array();
    if ($category) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }
    if ($format) {
        $tax_query[] = array(
            'taxonomy' => 'format_photo',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }
    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);
    $photos_data = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photo_url = get_field('affichage_photo');
            if ($photo_url) {
                $categories = get_the_terms(get_the_ID(), 'category'); 
                $category_names = wp_list_pluck($categories, 'name');

                $photos_data[] = array(
                    'photo_url'    => esc_url($photo_url),
                    'title'        => get_the_title(),
                    'category'     => implode(', ', $category_names),
                    'reference'    => get_field('reference_photo'),
                    'detail_url'   => get_permalink(''),
                );
            }
        }
    } else {
        $photos_data['error'] = 'Aucune photo trouvée.';
    }
    wp_reset_postdata();
    echo json_encode($photos_data);
    wp_die();

}
add_action('wp_ajax_get_and_display_photos', 'get_and_display_photos');
add_action('wp_ajax_nopriv_get_and_display_photos', 'get_and_display_photos');



// Page single : Récupérer les références des photos en AJAX
function get_photo_references() {
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => -1
    );

    $photos = get_posts($args);
    $references = array();

    foreach ($photos as $photo) {
        $reference = get_field('reference_photo', $photo->ID);
        if ($reference) {
            $references[] = $reference;
        }
    }

    wp_send_json($references);
}

add_action('wp_ajax_get_photo_references', 'get_photo_references');
add_action('wp_ajax_nopriv_get_photo_references', 'get_photo_references');



//Page single : Charger plus de photos de la même catégorie
function load_more_cat_photos() {
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    $category = get_the_category($post_id)[0]->slug;

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 12,
        'offset' => $offset,
        'category_name' => $category,
        'post__not_in' => array($post_id),
    );

    $query = new WP_Query($args);

    $photos = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photos[] = array(
                'src' => get_field('affichage_photo'),
                'alt' => get_the_title(),
                'reference' => get_field('reference_photo'),
                'category' => get_the_category()[0]->name,
                'post_id' => get_the_ID(),
                'detail_url'   => get_permalink(''),
            );
        }
    }

    wp_send_json_success(array(
        'photos' => $photos,
        'hasMore' => ($query->found_posts > $offset + 12),
    ));
}
add_action('wp_ajax_load_more_cat_photos', 'load_more_cat_photos');
add_action('wp_ajax_nopriv_load_more_cat_photos', 'load_more_cat_photos');


function load_cat_photos() {
    $post_id = isset($_GET['post_id']) ? (int) $_GET['post_id'] : 0;
    if (!$post_id) {
        wp_send_json_error('Aucun ID de publication fourni');
        return;
    }

    $category = get_the_category($post_id);
    if (empty($category)) {
        wp_send_json_error('Aucune catégorie trouvée pour cet ID de publication');
        return;
    }
    $category_slug = $category[0]->slug;

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => -1, 
        'category_name' => $category_slug,
    );

    $query = new WP_Query($args);

    $photos = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photos[] = array(
                'src' => get_field('affichage_photo'),
                'alt' => get_the_title(),
                'reference' => get_field('reference_photo'),
                'category' => $category[0]->name,
                'detail_url'   => get_permalink(''),

            );
        }
    }

    wp_reset_postdata(); 

    wp_send_json_success($photos); 
}

add_action('wp_ajax_load_cat_photos', 'load_cat_photos');
add_action('wp_ajax_nopriv_load_cat_photos', 'load_cat_photos');