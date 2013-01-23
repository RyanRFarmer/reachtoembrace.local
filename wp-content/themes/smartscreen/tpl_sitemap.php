<?php
/*
Template Name: Sitemap
*/
get_header();
global $data;
$ht_slideshow_category = get_post_meta($post->ID, '_slideshow_category', true);
$override_title             =       get_post_meta($post->ID, '_override_title', true);
$teaser                     =       ($override_title != '' ? $override_title : get_the_title());
?>
<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>

<div id="wrap" class="no-sidebar clearfix">
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
        <?php if (have_posts()) : ?>
        <div id="entries-box">
            <?php while ( have_posts() ) : the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                    <div class="entry">
                        <?php the_content();?>
                        <div class="fix"></div>
                        <?php include (get_template_directory() . "/includes/sitemap_content.php");?>
                    </div>
                </div><!-- [/post-item] -->

                <?php endwhile;?>
        </div><!-- [/entries-box] -->
        </div><!-- [/entries] -->

        <?php endif; ?>
    </div><!-- [/main] -->
</div><!-- [/wrap] -->
<?php get_footer();?>