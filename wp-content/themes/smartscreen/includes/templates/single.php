<?php
$category = get_the_category();
if(isset($category[0]->cat_name))$teaser = $category[0]->cat_name;
global $data;
$ht_sidebar_status = ht_sidebar_layout();

?>
<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>

<div id="wrap" class="<?php echo ht_sidebar_layout(); ?> clearfix">
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

                while ( have_posts() ) : the_post();

                    $video_link             =       get_post_meta($post->ID, '_video_link', true);
                    $disable_post_image	    =       get_post_meta($post->ID, '_disable_post_image', true);
                    $image_url              =       ht_get_featured_image_url($post->ID);
                    $thumb_url              =       ht_image_resize(250,576,$image_url);

                    if($disable_post_image =='' && $data['disable_post_image'] =='1')  {
                        $disable_post_image = 'false';
                    }

                    if( trim($video_link) <> '' ) {
                        $video_status = 'video';
                        $image_url = $video_link;
                    } else {
                        $video_status = 'zoom';
                    }
                ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                    <?php if(has_post_thumbnail() && $disable_post_image !='false'){?>
                    <div class="post-image frame">
                        <a href="<?php echo $image_url;?>" title="<?php the_title();?>" data-rel="prettyPhoto">
                            <img  src="<?php echo $thumb_url;?>" alt="<?php the_title_attribute();?>" />
                            <span class="image-pat"></span>

                            <span class="<?php echo $video_status;?>"></span>
                        </a>
                    </div>
                    <?php }?>

                    <div class="post-meta">
                        <span class="post-date"><?php the_time("M d, Y");?></span> / <?php comments_popup_link(__('Leave a Comment','highthemes'), __('1 Comment','highthemes'), __('% Comments','highthemes')); ?>
                    </div>
                    <h3 class="post-title"><a title="<?php the_title_attribute();?>" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                    <div class="entry">
                        <?php
                        if(is_single()){
                            the_content();
                        } else { ?>
                            <p>
                                <?php echo ht_excerpt(300, '...'); ?>
                            </p>
                            <?php } ?>
                    </div>
                </div><!-- [/post-item] -->
                <?php endwhile;?>
        <?php  else: ?>
            <div class="post-item ">
                <div class="info-box-wrapper">
                    <div class="info-box-orange-header info-box-warning">
                        <div class="info-content-box-icon"><?php _e("There's no post here yet!",'highthemes'); ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php comments_template( '', true ); ?>
        </div><!-- [/entries-box] -->
    </div><!-- [/entries] -->
    </div><!-- [/main] -->
    <?php if( $ht_sidebar_status != 'no-sidebar') get_sidebar(); ?>
</div><!-- [/wrap] -->
<?php get_footer();?>