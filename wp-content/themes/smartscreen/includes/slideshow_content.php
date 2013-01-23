<?php
global $data;

if ($data['slideshow_ranomize'] =='1'){
    $orderby = 'rand';
} else {
    $orderby = 'date';
}
// Selecting slider items
if(!isset($ht_slideshow_category) || $ht_slideshow_category ==''){
    $slideshow_args=array(
        'post_type' => 'slideshow',
        'post_status' => 'publish',
        'orderby' => $orderby,
        'posts_per_page' => -1
    );

} else {
    $slideshow_args = array(
        'posts_per_page'        => -1,
        'post_type'			    => 'slideshow',
        'orderby'			    => $orderby,
        'post_status' => 'publish',
        'tax_query' => array(
            array(  'taxonomy'  => 'slideshow-category',
                'field'     => 'slug',
                'terms'     => $ht_slideshow_category
            )
        )
    );
}




$my_query = null;
$my_query = new WP_Query($slideshow_args);
if( $my_query->have_posts() ):
    $j=0;
    $slides = '';
    while( $my_query->have_posts() ): $my_query->the_post();
        $image_url = ht_get_featured_image_url($post->ID);
        if(trim(get_the_content()) != ''){
            $description = "<p>" . ht_excerpt(300, '...') . "</p>";
        } else {
            $description = '';
        }

        $disable_slider_caption = get_post_meta($post->ID, '_slider_disable_caption', true);
        if($disable_slider_caption) {
            $slides .= "{image : '" . $image_url . "',  thumb : '".$image_url."', url : ''} ,\n\t";

        } else {
            $slides .= "{image : '" . $image_url . "', title : '<div class=\"slider-caption\"><h2>". the_title("", "", false) ."</h2>".$description."</div>',  thumb : '".$image_url."', url : '/wtnr/'} ,\n\t";

        }
        $j++;
    endwhile;
endif;
$slides = trim($slides);
$data['NUMBEROFSLIDES'] = $j;

?>

<?php wp_reset_query();?>
<script type="text/javascript">
    jQuery(document).ready(function () {
                jQuery.supersized({

                    // Functionality
                    slide_interval          :   <?php echo $data['slideshow_timeout'] * 1000;?>,		// Length between transitions
                    transition              :   <?php echo $data['slideshow_transition_effect'];?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed		:	1000,
                    keyboard_nav            :   1,

                    // Speed of transition

                    // Components
                    slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    slides 					:  	[			// Slideshow Images
                    <?php echo substr($slides,0, strlen($slides)-1);?>
                    ]

                });
            }

    );
</script>
