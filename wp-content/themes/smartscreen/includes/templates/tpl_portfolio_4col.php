<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php";} ?>
<div id="wrap" class="clearfix no-sidebar">
    <div id="main" class="portfolio">
        <div id="entries">
            <h2 class="page-title"><?php echo $teaser;?>
                <span id="entries-toggle"><?php _e("Toggle", "highthemes");?></span>
                <?php if ($data['breadcrumb_inner']) { ?>
                    <div id="breadcrumb">
                        <?php
                        if (class_exists('simple_breadcrumb')) {
                            $bc = new simple_breadcrumb;
                        }
                        ?>
                    </div>
                    <?php } ?>
            </h2>
            <div id="entries-box">
                <?php
                while (have_posts()) :the_post();
                    if (trim(get_the_content()) != ""):
                        ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                            <div class="entry">
                                <?php the_content();?>
                                <div class="fix"></div>
                                <?php wp_link_pages();?>
                            </div>
                        </div>
                        <?php
                    endif;
                endwhile;
                ?>
            <?php
            $posts_per_page = (int) $ht_item_number;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                'paged'	 			    => $paged,
                'posts_per_page'        => $posts_per_page,
                'post_type'			    => 'portfolio',
                'order_by'			    => 'date',
                'tax_query' => array(
                    array(  'taxonomy'  => 'portfolio-category',
                        'field'     => 'slug',
                        'terms'     => $ht_portfolio_category
                    )
                )
            );

            $temp = $wp_query;

            $wp_query = new WP_Query($args);
            if ($wp_query->have_posts()) : ?>
                <div id="filters">
                    <ul>
                        <?php
                        if(is_array($ht_portfolio_category)) {
                            $n=1;
                            foreach($ht_portfolio_category as $index=>$value){
                                $term_details = get_term_by( 'slug', $value, 'portfolio-category');
                                $term_link = get_term_link($term_details->slug, 'portfolio-category');
                                ?>
                                <li>
                                    <a href="<?php echo $term_link;?>" title=""><?php echo $term_details->name;?></a>
                                    <?php $n++;?>
                                </li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>

            <div id="portfolio" >
                <div class="entry">
            <?php
                $i=1;
                while( $wp_query->have_posts() ) : $wp_query->the_post();
                    $terms = get_the_terms( $post->ID, 'portfolio-category' );

                    $video_link = get_post_meta($post->ID, '_video_link', true);

                    $image_url = ht_get_featured_image_url($post->ID);
                    $thumb_url = ht_image_resize(198,330,$image_url);

                    if(trim($video_link) <> ''){
                        $video_status = 'video';
                        $image_url = $video_link;
                    } else {
                        $video_status = 'zoom';
                    }
                    ?>

                    <div id="post-<?php the_ID();?>" class=" one_fourth folio-box clearfix <?php if(($i%4)==0 && $i<>0){ echo "last"; } ?>">
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


                        </div>
                    </div>
                    <?php if(($i%4)==0 && $i<>0){ echo '<div class="fix"></div>'; } ?>
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
            <?php
            $wp_query = null; $wp_query = $temp;
            ?>
        </div><!--.entry-->
        </div><!--#portfolio-->
        </div><!-- [/entries-box] -->
        </div><!--/entries-->



    </div><!-- [/main] -->
</div><!-- [/wrap] -->


<?php get_footer();?>