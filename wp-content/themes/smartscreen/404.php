<?php
get_header();

global $data;
$teaser = "Error 404! Page Not Found.";
?>
<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>
<div id="wrap" class="clearfix <?php echo ht_sidebar_layout(1); ?>">
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
            <div  id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                <div class="entry">
                    <div class="fix"></div>
                    <?php if( trim($data['custom_404'])!='' ) {?><p><?php echo stripslashes($data['custom_404']); ?></p><?php } ?>
                    <div class="divider top"><a href="#"><?php _e('Top','highthemes'); ?></a></div>
                    <?php require(get_template_directory() . "/includes/sitemap_content.php"); ?>
                </div>
            </div>

     </div><!-- [/entries-box] -->
    </div><!-- [/entries] -->
    </div><!-- [/main] -->
    <?php if( ht_sidebar_layout(1) != 'no-sidebar') get_sidebar(); ?>
</div><!-- [/wrap] -->
<?php get_footer();?>