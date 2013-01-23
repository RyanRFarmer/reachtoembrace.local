<!-- [RELATED-ITEMS] -->
<?php
$the_term = wp_get_post_terms( $post->ID, 'portfolio-category' );
$term_id = $the_term[0]->term_id;

$args = array(
    'showposts'                 => 4,
    'post_type'                 => 'portfolio',
    'post__not_in'              => array($post->ID),
    'order_by'                  => 'rand',
    'ignore_sticky_posts'       =>1,
    'tax_query' => array(
                        array('taxonomy' => 'portfolio-category',
                              'field' => 'id',
                              'terms' => $term_id
                             )
                        )
            );

$temp = $wp_query;
$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) :
?>
    <div id="related-folio" class="projects clearfix">
        <div class="section-title"><h2><?php _e("Related Projects", "highthemes");?></h2></div>

        <ul>
            <?php
            $i=1;
            while ($wp_query->have_posts()) : $wp_query->the_post();
                $video_link = get_post_meta($post->ID, '_video_link', true);

                // getting the featured images
                $post_images = ht_get_featured_images($post->ID);
                $image_url = $post_images[0];
                $sheight=204;
                $swidth=320;
                $thumb_url = ht_image_resize($sheight,$swidth,$image_url);

                if(trim($video_link) <> ''){
                    $video_status = 'video';
                    $image_url = $video_link;
                } else {$video_status = 'zoom';}
                ?>
                <li <?php ( ($i%4) == 0 && $i!=0 ) ? post_class("one_fourth last folio-box"): post_class("one_fourth folio-box");?>>
                    <div class="frame">
                        <a title="<?php the_title();?>" data-rel="prettyPhoto"  href="<?php echo $image_url;?>">
                            <img  alt="" src="<?php echo $thumb_url;?>">
                            <span class="image-pat"></span>
                            <span class="zoom"></span>
                        </a>
                    </div>
                    <div class="portfolio-info">
                        <h3 class="folio-title"><a title="<?php the_title();?>" href="<?php the_permalink();?>"><?php the_title();?></a></h3>

                    </div>
                </li>
                <?php $i++;
            endwhile;?>
        </ul>
    </div>
<?php endif;
$wp_query = null; $wp_query = $temp;
?>
<!-- [/RELATED-ITEMS] -->