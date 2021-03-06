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
            <?php if ( is_search() ) {
                $title = sprintf( __( 'Search results for %s','highthemes'), '"' . get_search_query() . '"' );
                echo  $title;
            } ?>
            <span id="entries-toggle"><?php _e("Toggle", "highthemes");?></span>
            <?php if($data['breadcrumb_inner']){ ?>
            <div id="breadcrumb">
                <?php if (class_exists('simple_breadcrumb')) { $bc = new simple_breadcrumb; } ?>
            </div>
            <?php } ?>
        </h2>
        <div id="entries-box">
        <?php
        if (have_posts()) :
            while ( have_posts() ) : the_post();
                get_template_part( 'content', get_post_format() );
            endwhile;
        ?>
        <?php  else: ?>
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