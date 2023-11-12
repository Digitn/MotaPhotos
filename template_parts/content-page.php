<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <header class="entry-header">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
        ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        
        the_content();

        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'your-theme-domain' ),
            'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
        // Vous pouvez ajouter ici des éléments comme les métadonnées du post (auteur, date, catégories, tags, etc.)
        ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
