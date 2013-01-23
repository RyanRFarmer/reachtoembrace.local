<?php
global $data;

// title of the page goes here
$override_title = get_post_meta($post->ID, '_override_title', true);
$teaser = ($override_title != '' ? $override_title : get_the_title());
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
        <div id="entries-box">
              <div id="folio-nav">
                    <span class="fl folio-prev"> <?php previous_post_link('%link', __('&larr; Previous', 'highthemes')); ?></span>
                    <span class="fr folio-next">  <?php next_post_link('%link', __('Next &rarr;', 'highthemes')); ?></span>
                </div>
        <?php if (have_posts()) : the_post(); ?>

        <?php
        $video_link = get_post_meta($post->ID, '_video_link', true);
        $allow_sidebar = get_post_meta($post->ID, '_allow_sidebar', true);
        $extra_info = get_post_meta($post->ID, '_extra_info', true);


            // getting the featured images
        $post_images = ht_get_featured_images($post->ID);
        $image_url = $post_images[0];
        $sheight=600;
        $swidth=960;
        $thumb_url = ht_image_resize($sheight,$swidth,$image_url);
        $terms = get_the_terms( $post->ID, 'portfolio-category' );

        if(trim($video_link) <> ''){
            $video_status = 'video';
            $image_url = $video_link;
        } else {
            $video_status = 'zoom';
        }
        ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class('post-item clearfix'); ?>>
            <?php if( count($post_images)>1 ){ ?>
            <div id="folio-single-slideshow" class=" flexslider">
                <ul class="slides">
                    <?php for( $z=0; $z <count($post_images); $z++){
                    $post_image_resized = ht_image_resize(600,960,$post_images[$z]);
                    if($z == 0 && trim($video_link != '')){
                        $post_images[$z] = $video_link; $video_status='video';
                    } else {
                        $video_status = 'zoom';
                    }
                    ?>
                    <li>

                        <div class="post-image frame">
                            <a href="<?php echo $post_images[$z];?>" title="<?php the_title();?>" data-rel="prettyPhoto">
                                <img  src="<?php echo $post_image_resized;?>" alt="<?php the_title_attribute();?>" />
                                <span class="image-pat"></span>
                                <span class="<?php echo $video_status;?>"></span>
                            </a>
                        </div>

                    </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } else { ?>
            <?php if(has_post_thumbnail()){ ?>
                <div class="post-image">
                    <a href="<?php echo $image_url;?>" title="<?php the_title();?>" data-rel="prettyPhoto">
                                                     <span class="overlay">
                                                        <span class="overlay-ico">
                                                             <img alt="" src="<?php echo get_template_directory_uri();?>/images/overlay_<?php echo $video_status;?>.png">
                                                        </span>
                                                     </span>
                        <img class="frame" src="<?php echo $thumb_url;?>" alt="<?php the_title_attribute();?>" />
                    </a>
                </div>
                <?php } ?>
            <?php } ?>
            <div class="entry two_third">
                 <?php the_content();?>
            </div>
            <ul class="meta one_third last">
                <li class="post-date"><span>Date: </span><?php the_time("M d, Y");?></li>

                <li class="post-cats">
                    <span>Tags: </span>
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
                </li>
                <?php
                $extra_info = explode(PHP_EOL,$extra_info);
                foreach($extra_info as $info) {
                    echo '<li>'. $info .'</li>';
                }
                ?>
                <li>
                    <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
                    <a href="http://twitter.com/share" class="twitter-share-button"
                       data-url="<?php the_permalink(); ?>"
                       data-via="<?php echo $data['twitter_id'] ?>"
                       data-text="<?php the_title(); ?>"
                       data-count="horizontal">Tweet</a>
                </li>
                <li>
                    <div id="fb-root"></div>
                    <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="<?php echo get_permalink(); ?>" show_faces="false" layout="button_count" width="450"></fb:like>
                </li>
                <li>
                    <g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone>

                </li>


            </ul>

        </div>
        <?php endif;?>

        <?php
        if($data['disable_related_folio'] !="1"){
            get_template_part( 'includes/related_posts' );
        }
        ?>


        <?php comments_template( '', true ); ?>

    </div><!-- [/entries-box] -->
    </div><!-- [/entries] -->
    </div><!-- [/main] -->
</div><!-- [/wrap] -->
<?php get_footer();?>