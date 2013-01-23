<?php
global $data;
$video_link     =   get_post_meta($post->ID, '_video_link', true);
$disable_post_image	        =   get_post_meta($post->ID, '_disable_post_image', true);
if($disable_post_image=='' && $data['disable_post_image'] =='1'){
    $disable_post_image = 'false';
}

$image_url = ht_get_featured_image_url($post->ID);
if(!isset($data['post_image_height']) || !is_numeric($data['post_image_height']) || $data['post_image_height']=="")
{
    $data['post_image_height'] = 292;
}
$thumb_url = ht_image_resize($data['post_image_height'],560,$image_url);

if( trim($video_link) <> '' ) {
    $video_status = 'video';
    $image_url = $video_link;
}
else {
    $video_status = 'zoom';
}
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
    <?php if(has_post_thumbnail() && $data['disable_post_image'] !='1'){?>
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
                <?php echo ht_excerpt(150, '...'); ?>
            </p>
            <?php } ?>
        <?php if(!is_single()){?> <a class="read-more" href="<?php the_permalink(); ?>"><?php _e("Continue Reading &rarr;","highthems");?></a><?php }?>

    </div>
</div><!-- [/post-item] -->
