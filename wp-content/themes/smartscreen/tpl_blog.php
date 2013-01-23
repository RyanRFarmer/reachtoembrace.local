<?php
/*
Template Name: Blog
*/
get_header();

// variables
global $data;

// title of the page goes here
$override_title = get_post_meta($post->ID, '_override_title', true);
$teaser = ($override_title != '' ? $override_title : get_the_title());

// slideshow group
$ht_slideshow_category = get_post_meta($post->ID, '_slideshow_category', true);
$ht_sidebar_status = ht_sidebar_layout();
?>

<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>
<div id="wrap" class="clearfix <?php echo ht_sidebar_layout(); ?>">
    <div id="main">
        <div id="entries">
            <h2 class="page-title"><?php echo $teaser;?>
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

                    if($data['excluded_categories']){
                        $exclude_blog_cats = implode(',', $data['excluded_categories']);
                        $exclude_blog_cats = preg_replace('!(\d)+!','-${0}', $exclude_blog_cats);
                    }
                    $query_string = "cat=".$exclude_blog_cats."&paged=$paged";
                    query_posts($query_string);
                    while ( have_posts() ) : the_post();
                        global $more;
                        $more = 0;
                        get_template_part( 'content', get_post_format() );

                    endwhile;

            ?>
            <?php  else:  ?>
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
    <?php if( $ht_sidebar_status != 'no-sidebar') get_sidebar(); ?>
</div><!-- [/wrap] -->
<?php get_footer();?>
