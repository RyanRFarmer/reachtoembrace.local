<?php
global $data;

$video_link             =   get_post_meta($post->ID, '_video_link', true);
$disable_post_image	    =   get_post_meta($post->ID, '_disable_post_image', true);
$link_post_format	    =   get_post_meta($post->ID, '_link_post_format', true);
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
    <div class="post-meta">
        <span class="post-date"><?php the_time("M d, Y");?></span> / <?php comments_popup_link(__('Leave a Comment','highthemes'), __('1 Comment','highthemes'), __('% Comments','highthemes')); ?>
    </div>
    <h3 class="post-title">
        <?php if (trim($link_post_format) !="") {?>
        <a title="<?php the_title_attribute();?>" href="<?php echo $link_post_format;?>"><?php the_title();?> <span>/ <?php echo get_post_format();?></span></a>
        <?php } else { ?>
        <?php the_title();
    } ?>
    </h3>
    <div class="entry">
        <?php the_content();?>
    </div>
</div><!-- [/post-item] -->
