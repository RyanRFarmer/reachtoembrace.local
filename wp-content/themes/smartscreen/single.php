<?php
get_header();
$ht_slideshow_category = get_post_meta($post->ID, '_slideshow_category', true);

if (get_post_type() == 'portfolio') {

    $portfolio_layout = get_post_meta($post->ID, '_ht_portfolio_post_layout', true);
    include (HT_TEMPLATES_PATH . "single_folio.php");

} else {

    include (HT_TEMPLATES_PATH . "single.php");
}
?>