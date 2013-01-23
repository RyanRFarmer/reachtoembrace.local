<?php
global $data;
$video_link             =   get_post_meta($post->ID, '_video_link', true);
$disable_post_image	    =   get_post_meta($post->ID, '_disable_post_image', true);
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
    <div class="post-meta">
        <span class="post-date"><?php the_time("M d, Y");?></span> / <?php comments_popup_link(__('Leave a Comment','highthemes'), __('1 Comment','highthemes'), __('% Comments','highthemes')); ?>
    </div>
    <h3 class="post-title"><a title="<?php the_title_attribute();?>" href="<?php the_permalink();?>"><?php the_title();?></a> <span>/ <?php echo get_post_format();?></span></h3>
    <div class="entry">
       <?php the_content(); ?>
    </div>
</div><!-- [/post-item] -->

