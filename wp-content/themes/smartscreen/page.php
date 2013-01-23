<?php
// getting the page type
$ht_page_type = get_post_meta($post->ID, '_page_type', true);

// start the session for contact
if($ht_page_type == 'contact') session_start();

get_header();

// load variables
global $data;

$ht_portfolio_category      =       get_post_meta($post->ID, '_portfolio_category', true);
$ht_slideshow_category      =       get_post_meta($post->ID, '_slideshow_category', true);
$ht_item_number             =       get_post_meta($post->ID, '_item_number', true);
$ht_subblog_category        =       get_post_meta($post->ID, '_subblog_category', true);
$override_title             =       get_post_meta($post->ID, '_override_title', true);
$teaser                     =       ($override_title != '' ? $override_title : get_the_title());


if($ht_page_type == 'contact') {

    include (HT_TEMPLATES_PATH . "tpl_contact.php");
    exit;

} elseif($ht_page_type == 'subblog') {

    include (HT_TEMPLATES_PATH . "tpl_subblog.php");
    exit;

} elseif ($ht_page_type == 'portfolio') {

    //select portfolio layout
    $ht_portfolio_layout = get_post_meta($post->ID, '_portfolio_layout', true);
    if(!is_numeric($ht_item_number) || !isset($ht_item_number)) {
        $ht_item_number = 9;
    }

    if($ht_portfolio_layout == '1c') {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_1col.php");
        exit;

    } elseif($ht_portfolio_layout == '2c') {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_2col.php");
        exit;

    } elseif($ht_portfolio_layout == '3c') {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_3col.php");
        exit;

    } elseif($ht_portfolio_layout == '4c' ) {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_4col.php");
        exit;

    } else {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_3col.php");
        exit;

    }

} elseif ($ht_page_type == 'portfolio-filterable') {

    //select portfolio layout
    $ht_portfolio_layout = get_post_meta($post->ID, '_portfolio_layout', true);

    if(!is_numeric($ht_item_number) || !isset($ht_item_number)) {
        $ht_item_number = 9;
    }


    if($ht_portfolio_layout == '1c') {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_1col_filtered.php");
        exit;

    } elseif($ht_portfolio_layout == '2c') {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_2col_filtered.php");
        exit;

    } elseif($ht_portfolio_layout == '3c') {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_3col_filtered.php");
        exit;

    } elseif($ht_portfolio_layout == '4c' ) {

        include (HT_TEMPLATES_PATH . "tpl_portfolio_4col_filtered.php");
        exit;

    } else {

        include (HT_TEMPLATES_PATH . "tpl-portfolio-3col_filtered.php");
        exit;

    }

} else {
?>

<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>
<div id="wrap" class="clearfix <?php echo ht_sidebar_layout(); ?>">
    <div id="main">
        <?php if (have_posts()) : ?>
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
            while (have_posts()) :the_post();
            ?>
            <div  id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                <div class="entry">
                    <?php the_content();?>
                    <div class="fix"></div>
                    <?php wp_link_pages();?>
                </div>
            </div>
            <?php endwhile;?>
        <?php else: ?>
        <div class="post-item ">
            <div class="info-box-wrapper">
                <div class="info-box-orange-header info-box-warning">
                    <div class="info-content-box-icon"><?php _e("There's no post here yet!",'highthemes'); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        </div><!-- [/entries-box] -->
    </div><!-- [/entries] -->
    </div><!-- [/main] -->
    <?php if( ht_sidebar_layout() != 'no-sidebar') get_sidebar(); ?>
</div><!-- [/wrap] -->

<?php get_footer(); }?>