<div class="popup popup-overlay">
    <div class="popup-contact">
        <div class="popup-header">
            <h3 class= "animated-title animated-title1">Contact</h3>
            <p class="animated-title animated-title2"></p>
            <img src="<?php echo get_stylesheet_directory_uri() .'/assets/img/square-xmark.png' ; ?>" class="popup-close">
        </div>
        <?php
        // Formulaire de contact
        echo do_shortcode('[contact-form-7 id="a1e911b" title="Contact"]');
        ?>
    </div>
</div>