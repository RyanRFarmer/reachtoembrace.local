<?php
get_header();

// variables
global $data;
$teaser = get_the_title();
?>
<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>

<div id="wrap" class="clearfix <?php echo ht_sidebar_layout(1); ?>">
    <div id="main">
    <div id="entries">
        <h2 class="page-title">
            <?php
            if ( have_posts() ):
                the_post();
                printf( __( 'Author Archives: %s','highthemes' ), get_the_author() );
            endif;
            rewind_posts();
            ?>
            <span id="entries-toggle"><?php _e("Toggle", "highthemes");?></span>
        </h2>
        <div id="entries-box">
        <?php
        // include the post author bio box
        ht_author_bio();

        if (have_posts()) :

            while ( have_posts() ) : the_post();
                get_template_part( 'content', get_post_format() );

        endwhile;
        ?>
        <?php  else:   ?>
            <div class="post-item ">
                <div class="info-box-wrapper">
                    <div class="info-box-orange-header info-box-warning">
                        <div class="info-content-box-icon"><?php _e("There's no post here yet!",'highthemes'); ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
            <div class="navi">
                <?php ($data['pagenavi_status']) ? wp_pagenavi() :posts_nav_link("","<span class='fl'>&larr; ". __('Previous Page','highthemes') ."</span>", "<span class='fr'>".__('Next Page', 'highthemes')." &rarr;</span>"); ?>
            </div>
    </div><!-- [/entries-box] -->
    </div><!-- [/entries] -->
    </div><!-- [/main] -->
    <?php if( ht_sidebar_layout(1) != 'no-sidebar') get_sidebar(); ?>
</div><!-- [/wrap] -->
<?php get_footer();?>