<?php

// Enregistrement des styles et scripts
function theme_enqueue_styles() {
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


function motaphoto_scripts() {
    wp_enqueue_script( 'popupmota', get_stylesheet_directory_uri() . '/js/popupmota.js', array(), null, false );
    wp_enqueue_script( 'lightboxmota', get_stylesheet_directory_uri() . '/js/lightboxmota.js', array(), null, false );
    wp_enqueue_script( 'lightboxgallerymota', get_stylesheet_directory_uri() . '/js/lightboxgallerymota.js', array(), null, false );
    wp_enqueue_script( 'cataloguemota-page', get_stylesheet_directory_uri() . '/js/cataloguemota-page.js', array(), null, false );
    wp_enqueue_script( 'cataloguemota-single', get_stylesheet_directory_uri() . '/js/cataloguemota-single.js', array(), null, false );
}
add_action( 'wp_enqueue_scripts', 'motaphoto_scripts' );


// Menu admin - thème WP Motaphotos

// Section Paramètres
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
//Section Historique
function motaphotos_theme_settings() {
    echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>';
    echo '<form action="options.php" method="post" name="motaphotos_settings">';
    echo '<div>';
    settings_fields('motaphotos_settings_fields');
    do_settings_sections('motaphotos_settings_section');
    submit_button();
    echo '</div>';
    echo '</form>';

    motaphotos_dev_section_introduction(); 
}

// Champs de saisie informations interventions
function motaphotos_settings_register() {
    register_setting('motaphotos_settings_fields', 'motaphotos_settings_fields', 'motaphotos_settings_fields_validate');
    add_settings_section('motaphotos_settings_section', __('Paramètres', 'motaphotos'), 'motaphotos_settings_section_introduction', 'motaphotos_settings_section');
    add_settings_field('motaphotos_settings_field_slogan', __('Slogan', 'motaphotos'), 'motaphotos_settings_field_slogan_output', 'motaphotos_settings_section', 'motaphotos_settings_section');
    add_settings_field('motaphotos_settings_field_introduction', __('Introduction', 'motaphotos'), 'motaphotos_settings_field_introduction_output', 'motaphotos_settings_section', 'motaphotos_settings_section');
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
    $sort = isset($_POST['date_photo']) && in_array($_POST['date_photo'], ['ASC', 'DESC']) ? $_POST['date_photo'] : 'RAND'; // Default to 'RAND' if not set

    $args = array(
        'post_type' => 'photos',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => $sort === 'RAND' ? 'rand' : 'meta_value',
        'meta_key' => $sort === 'RAND' ? '' : 'date_photo',
        'order' => $sort !== 'RAND' ? $sort : '',
        'offset' => $offset,
    );

    if ($category || $format) {
        $args['tax_query'] = array('relation' => 'AND');
    }

    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format_photo',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    $query = new WP_Query($args);
    $photos_data = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photo_url = get_field('affichage_photo');
            $category_names = array();
            $categories = get_the_category();

            foreach($categories as $cat) {
                $category_names[] = $cat->name;
            }
            $category_names_list = implode(', ', $category_names);

            if ($photo_url) {
                $photos_data[] = [
                    'photo_url'    => esc_url($photo_url),
                    'title'        => get_the_title(),
                    'category'     => $category_names_list, // Here we get slugs
                    'reference'    => get_field('reference_photo'),
                ];
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



// Cacher la section hero sur les pages de type 'photos'
function hide_hero_on_posts() {
    if (is_single() && get_post_type() === 'photos') {
        echo '<style>.hero { display: none; }</style>';
    }
}
add_action('wp_head', 'hide_hero_on_posts');
