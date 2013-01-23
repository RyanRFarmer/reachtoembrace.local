<?php
/*
Template Name: Homepage Default
*/
get_header();
global $data;
$ht_slideshow_category = get_post_meta($post->ID, '_slideshow_category', true);
?>
<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>
<?php get_footer(); ?>