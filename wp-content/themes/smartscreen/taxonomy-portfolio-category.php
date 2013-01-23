<?php
get_header();

// variables
global $data;
$teaser = get_the_title();
// TODO : THE TITLE ISN't CORRECT
?>
<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>

<div id="wrap" class="clearfix no-sidebar">
    <div id="main">
        <div id="entries">
            <h2 class="page-title">
                <span id="entries-toggle"><?php _e("Toggle", "highthemes");?></span>
                <?php echo $teaser;?>
                <?php if($data['breadcrumb_inner']){ ?>
                <div id="breadcrumb">
                    <?php if (class_exists('simple_breadcrumb')) { $bc = new simple_breadcrumb; } ?>
                </div>
                <?php } ?>
            </h2>
            <div id="entries-box">
           <?php
            if (have_posts()) : ?>

            <div id="portfolio" >
                <div class="entry">
            <?php
                $i=1;
                while(have_posts() ) :the_post();
                    $terms = get_the_terms( $post->ID, 'portfolio-category' );

                    $video_link = get_post_meta($post->ID, '_video_link', true);
                    $exlink_title = get_post_meta($post->ID, '_exlink_title', true);
                    $exlink_url = get_post_meta($post->ID, '_exlink_url', true);
                    $image_url = ht_get_featured_image_url($post->ID);
                    $thumb_url = ht_image_resize(150,250,$image_url);

                    if(trim($video_link) <> '') {
                        $video_status = 'video';
                        $image_url = $video_link;
                    } else {
                        $video_status = 'zoom';
                    }
                    ?>

                    <div id="post-<?php the_ID();?>" class=" one_third folio-box clearfix <?php if(($i%3)==0 && $i<>0){ echo "last"; } ?>">
                        <div class="frame">
                            <a title="<?php the_title();?>" data-rel="prettyPhoto"  href="<?php echo $image_url;?>">
                                <img  alt="" src="<?php echo $thumb_url;?>">
                                <span class="image-pat"></span>
                                <span class="<?php echo $video_status;?>"></span>
                            </a>
                        </div>

                        <div class="portfolio-info">
                            <h3 class="folio-title"><a title="<?php the_title();?>" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                            <div class="folio-cats">
                                <?php
                                $z = 1;
                                foreach($terms as $term=>$value){
                                    $term_link =  get_term_link($value->slug, 'portfolio-category');
                                    $term_name =  $value->name;
                                    echo '<a href="'.$term_link.'" >'.$term_name.'</a>';
                                    if( count($terms)!=$z ){
                                        echo  ", ";
                                    }
                                    $z++;
                                }
                                ?>
                            </div>
                            <p>
                                <?php echo ht_excerpt(150, '...');?>
                            </p>

                        </div>
                    </div>
                    <?php if(($i%3)==0 && $i<>0){ echo '<div class="fix"></div>'; } ?>
                    <?php
                    $i++;
                endwhile;?>
                <?php else: ?>
                <div class="post-item ">
                    <div class="info-box-wrapper">
                        <div class="info-box-orange-header info-box-warning">
                            <div class="info-content-box-icon"><?php _e("There's no post here yet!",'highthemes'); ?></div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <div class="navi">
                    <?php ($data['pagenavi_status']) ? wp_pagenavi() :posts_nav_link("","<span class='fl'>&larr; ". __('Previous Page','highthemes') ."</span>", "<span class='fr'>".__('Next Page', 'highthemes')." &rarr;</span>"); ?>
                </div>
        </div><!--.entry-->
        </div><!--#portfolio-->
        </div><!-- [/entries-box] -->
        </div><!--/entries-->



    </div><!-- [/main] -->
</div><!-- [/wrap] -->
<?php get_footer();?>
