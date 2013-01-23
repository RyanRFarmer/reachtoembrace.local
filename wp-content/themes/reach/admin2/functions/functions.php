<?php
/**
 *
 * HighThemes Options Framework
 * twitter : http://twitter.com/theHighthemes
 *
 */


/*
 *  necessary js files used in the theme
 */
function ht_enqueue_scripts() {
    if(!is_admin()){
        wp_enqueue_script('jquery.easing' , HT_JS_PATH . 'jquery.easing.1.3.js', array('jquery'), '1.3');
        wp_enqueue_script( 'jquery.tools', HT_JS_PATH .'jquery.tools.min.js', array('jquery'));
        wp_enqueue_script( 'flex-js', HT_JS_PATH .'jquery.flexslider-min.js', array('jquery'));
        wp_enqueue_script( 'prettyPhoto', HT_JS_PATH .'jquery.prettyPhoto.js', array('jquery'));
        wp_enqueue_script( 'twitter.min', HT_JS_PATH .'twitter.min.js', array('jquery'));
        wp_enqueue_script( 'flowplayer', HT_JS_PATH .'flowplayer-3.2.6.min.js', array('jquery'));
        wp_enqueue_script( 'filterable', HT_JS_PATH .'jquery.isotope.min.js', array('jquery'));
        if(ht_slideshow_status() == '1') {
            wp_enqueue_script( 'supersized', HT_JS_PATH .'supersized.3.2.7.min.js', array('jquery'));
        }
        wp_enqueue_script( 'custom-js', HT_JS_PATH .'custom.js', array('jquery'));


    }
}

add_action('wp_print_scripts', 'ht_enqueue_scripts');


/*
 * Formatting description of menu items
 */

class description_walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth, $args)
    {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $prepend = '';
        $append = '';
        $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

        if($depth != 0)
        {
            $description = $append = $prepend = "";
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
        $item_output .= $description.$args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


/*
 * convert hexadecimal color to rgb
 */
if( ! function_exists('hex_to_rgb') ){
    function hex_to_rgb($color) {
        $without_hash = substr($color, 1);
        $r = substr($without_hash, 0, 2);
        $g = substr($without_hash, 2, 2);
        $b = substr($without_hash, 4, 2);

        return hexdec($r) . "," . hexdec($g) . "," . hexdec($b);
    }

}



/*
 *  google fonts come with a 'google_' prefix. with this function we will remove it from the font name
 */
if( ! function_exists('trim_google_font')){
    function trim_google_font($font){
        if(substr($font, 0, 6) == 'google'){
            return substr($font, 7);
        }
        else{
            return $font;
        }
    }
}



/*
 *  include google fonts link in the header
 */
if( ! function_exists('ht_include_google_font') ){
    function ht_include_google_font() {
        global $data;
        $font = $data['heading_font'];
        $font_nav = $data['navigation_font'];
        $font_body = $data['body_font'];
        $font_sidebar = $data['sidebar_font'];

        if($font_sidebar)

        if( ! empty( $font ) || ! empty( $font_nav )) {
            if( isset( $_SERVER['HTTPS'] ) )
                $protocol = 'https://'; // Google does support https
            else
                $protocol = 'http://';

            if(substr($font['face'], 0, 6) == 'google'){
                $font['face'] = substr($font['face'], 7);
                $font['face'] = str_replace( ' ', '+', $font['face'] );
                if($font['face'] == 'Oswald'){
                  $font['face'] = $font['face'] . ":700,400,300";
                }
                echo '<link href="'.$protocol.'fonts.googleapis.com/css?family='.$font['face'].'" rel="stylesheet" type="text/css">'."\n";
            }

           
        }
    }

}

add_action('wp_head', 'ht_include_google_font', 19);


/*
 *  output custom dynamic css. it's controlled by admin options style section
 */
if( ! function_exists('ht_custom_css') ){
    function ht_custom_css(){
        require_once( get_template_directory()  .'/styles/custom-css.php');
    }
}
add_action('wp_head', 'ht_custom_css', 20);



/*
 *  include custom favicon
 */
if( ! function_exists('ht_favicon') ){
    function ht_favicon($url = "")
    {
        $link = "";
        if($url)
        {
            $type = "image/x-icon";
            if(strpos($url,'.png' )) $type = "image/png";
            if(strpos($url,'.gif' )) $type = "image/gif";

            $link = '<link rel="icon" href="'.$url.'" type="'.$type.'">';
        }

        return $link;
    }
}



/**
 * create list of available terms for $taxonomy
 *
 * @param $taxonomy
 * @return mixed
 */
if( ! function_exists('ht_create_terms_list') ){
    function ht_create_terms_list($taxonomy)
    {
        global $wpdb;
        $sql = "SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = '$taxonomy'";
        $res = $wpdb->get_results($sql,'ARRAY_A');
        if(count($res)>0){
            $term_ids = '';
            foreach ( $res as $col=>$value ){
                $term_ids .= $value['term_id'] . ",";
            }

            $term_ids = substr($term_ids, 0, strlen($term_ids)-1);
            $term_res = $wpdb->get_results("SELECT * from $wpdb->terms WHERE term_id IN ($term_ids)",'ARRAY_A');

            return $term_res;
        } else {
            return false;
        }

    }

}



/*
 *  add excerpt to pages
 */
add_post_type_support( 'page', 'excerpt' );



/*
 *  enable shortcodes on text widgets
 */
add_filter('widget_text', 'do_shortcode');



/*
 *  register post formats
 */
add_theme_support('post-formats', array('link', 'quote', 'video','audio'));




/*
 * enable posts thumbnail
 */
if ( function_exists('add_theme_support') ) {
    add_theme_support('post-thumbnails');
}



/*
 *  enable automatic feed links
 */
add_theme_support('automatic-feed-links');



/*
 *  register navigation menus
 */
register_nav_menu( 'nav', __('Primary Navigation of '.THEMENAME,'highthemes') );



/*
 * resize images with timthumb scripts
 */
if( ! function_exists('ht_image_resize') ){
    function ht_image_resize($height,$width,$img_url) {

        if($img_url =='') return '';

        $image['url'] = $img_url;
        $image_path = explode($_SERVER['SERVER_NAME'], $image['url']);
        $image_path = $_SERVER['DOCUMENT_ROOT'] . $image_path[1];
        $image_info = @getimagesize($image_path);

        if (!$image_info)
            $image_info = @getimagesize($image['url']);

        $image['width'] = $image_info[0];
        $image['height'] = $image_info[1];
        if($img_url != "" && ($image['width'] > $width || $image['height'] > $height || !isset($image['width']))){
            $img_url = HT_JS_PATH."thumb.php?src=$img_url&amp;w=$width&amp;h=$height&amp;zc=1&amp;q=100";
        }

        return $img_url;
    }

}



/*
 * use multipostthumbnails plugin for multiple featured images
 */

if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(array(
            'label' => __('Second Featured Image','highthemes'),
            'id' => 'second-featured-image',
            'post_type' => 'portfolio'
        )
    );

    new MultiPostThumbnails(array(
            'label' => __('Third Featured Image','highthemes'),
            'id' => 'third-featured-image',
            'post_type' => 'portfolio'
        )
    );

    new MultiPostThumbnails(array(
            'label' => __('Fourth Featured Image','highthemes'),
            'id' => 'fourth-featured-image',
            'post_type' => 'portfolio'
        )
    );

    new MultiPostThumbnails(array(
            'label' => __('Fifth Featured Image','highthemes'),
            'id' => 'fifth-featured-image',
            'post_type' => 'portfolio'
        )
    );

}



/*
 *  get all featured images that are attached to a post
 *  @param: $post_id
 */
if( ! function_exists('ht_get_featured_images') ){
    function ht_get_featured_images($post_id){
        $featured_images = array();

        if( ht_get_featured_image_url($post_id) != '' )
            $featured_images[] = ht_get_featured_image_url($post_id);

        if( ht_get_featured_image_url($post_id, 'second-featured-image') != '' )
            $featured_images[] = ht_get_featured_image_url($post_id, 'second-featured-image');

        if( ht_get_featured_image_url($post_id, 'third-featured-image') != '' )
            $featured_images[] = ht_get_featured_image_url($post_id, 'third-featured-image');

        if( ht_get_featured_image_url($post_id, 'fourth-featured-image') != '' )
            $featured_images[] = ht_get_featured_image_url($post_id, 'fourth-featured-image');

        if( ht_get_featured_image_url($post_id, 'fifth-featured-image') != '' )
            $featured_images[] = ht_get_featured_image_url($post_id, 'fifth-featured-image');

        return $featured_images;

    }
}



/*
 *  get image url of a certain featured image
 */
if( ! function_exists('ht_get_featured_image_url') ){
    function ht_get_featured_image_url($post_id, $image_id = ''){

        if($image_id =='') {
            $id = get_post_meta($post_id, "_thumbnail_id", true);
        } else {
            $id = get_post_meta($post_id, "portfolio_{$image_id}_thumbnail_id", true);
        }
        $image = wp_get_attachment_image_src($id,'full');

        return $image[0];

    }

}



/*
 * custom excerpt with custom length and ellipsis
 */
if( ! function_exists('ht_excerpt') ){
    function ht_excerpt($length, $ellipsis) {
        $text = get_the_content();
        $text = preg_replace('`\[[^\]]*\]`','',$text);
        $text = strip_tags($text);
        if(strlen($text) <= $length) {

            return $text;
        }
        else {
            $text = substr($text, 0, $length);
            $text = substr($text, 0, strripos($text, " "));
            $text = $text.$ellipsis;
            return $text;
        }
    }

}



/*
 *  new excerpt more
 */
if( ! function_exists('new_excerpt_more') ){
    function new_excerpt_more($more) {
        return ' ...';
    }
}
add_filter('excerpt_more', 'new_excerpt_more');



/*
 *  twitter like time
 */
if( ! function_exists('ht_days_date') ){
    function ht_days_date($date){

        $days = round((date('U') - $date) / (60*60*24));
        if ($days==0) {
            _e("Published today", "highthemes");
        }
        elseif ($days==1) {
            _e("1 day ago", "highthemes");
        }
        else {
            echo $days . __(" days ago", "highthemes");
        }
    }
}



/*
 * enablle threaded comments
 */
function enable_threaded_comments(){
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
            wp_enqueue_script('comment-reply');
    }
}
add_action('get_header', 'enable_threaded_comments');



/*
 * comments template. this function used to make a custom template for comments
 */
if( ! function_exists('custom_comment') ){
    function custom_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
<div <?php comment_class(); ?> id="div-comment-<?php comment_ID() ?>">
	<div class="comment-entry clearfix" id="comment-<?php comment_ID(); ?>">

        <div class="comment-author-wrap">
            <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        </div>

        <div class="comment-content">
            <div class="comment-author-info">
                <span class="comment-author">
                    <?php ($comment->comment_author_url == 'http://Website' || $comment->comment_author_url == '') ? comment_author() : comment_author_link(); ?>
                </span> -
                <span class="comment-time"><span><?php comment_date('d. M, Y'); ?></span></span> -
                <span class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
            </div>
            <?php
            if($comment->comment_approved == '0'){
                echo '<strong><em>'.__('Your comment is awaiting moderation.', 'highthemes').'</em></strong>';
            }
            ?>
            <?php comment_text() ?>
        </div>

    </div>
        <?php
    }

}



/*
 * display related posts for posts.
 */
if( ! function_exists('ht_related_post') ){
    function ht_related_post() {
        global $post, $wpdb;
        $backup = $post;  // backup the current object
        $tags = wp_get_post_tags($post->ID);
        $tagIDs = array();
        if ($tags) {
            $tagcount = count($tags);
            for ($i = 0; $i < $tagcount; $i++) {
                $tagIDs[$i] = $tags[$i]->term_id;
            }
            $args=array(
                'tag__in' => $tagIDs,
                'post__not_in' => array($post->ID),
                'showposts'=>4,
                'caller_get_posts'=>1
            );
            $my_query = new WP_Query($args);
            if( $my_query->have_posts() ) { $related_post_found = true; ?>
            <div class="related-posts">

                <h2 class="htitle"><span><?php _e('Related Posts','highthemes'); ?></span></h2>
                <ul class="thumb-list">
                    <?php
                    $i=1;
                    while ($my_query->have_posts()) : $my_query->the_post();

                        $post_id = get_the_ID();
                        $post_thumbnail = get_the_post_thumbnail($post_id, array(60, 60), array("class" => "post_thumbnail frame"));

                        if(!$post_thumbnail){
                            $post_thumbnail = '<img class="frame" alt="image" src="'.get_template_directory_uri() .'/images/empty_thumb.gif" />';
                        }
                        ?>
                        <li class="one_half <?php if(($i%2)==0 && $i<>0){ echo ' last';}?>">
                            <a class="fl" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                <?php echo $post_thumbnail;?></a>
                            <p><a class="thumb-title" href="<?php the_permalink() ?>"	rel="bookmark"> <?php the_title(); ?></a><br />
        <span class="date">
        <?php the_date(); ?>
        </span>
                                <br class="fix" />
                            </p>
                        </li>
                        <?php
                        $i++;
                    endwhile;
                    ?>
                </ul>
            </div>

                <?php
            }
        }

        wp_reset_query();

        ?>

        <?php

    }

}



/*
 * register widget areas, Default sidebar & footer blocks
 */
function the_widgets_init() {
    if ( !function_exists('register_sidebars') )
        return;

    register_sidebars(1,array('name' => __('Default Sidebar','highthemes'), 'id'=>'default-sidebar', 'before_widget' =>
    '<div id="%1$s" class="%2$s widget">','after_widget' => '</div>','before_title' => '<h3 class="widget-title"><span>','after_title' => '</span></h3>'));

    register_sidebar(array(	'name'=>'Footer-1',	'id'=> 'footer-1','before_widget' =>
    '<div id="footer%1$s" class="%2$s">','after_widget'  => '</div>','before_title'  => '<h3 class="widget-title">','after_title' => '</h3>' ));

    register_sidebar(array(	'name'=>'Footer-2',	'id'=> 'footer-2','before_widget' =>
    '<div id="footer%1$s" class="%2$s">','after_widget'  => '</div>','before_title'  => '<h3 class="widget-title">','after_title' => '</h3>' ));

    register_sidebar(array(	'name'=>'Footer-3',	'id'=> 'footer-3','before_widget' =>
    '<div id="footer%1$s" class="%2$s">','after_widget'  => '</div>','before_title'  => '<h3 class="widget-title">','after_title' => '</h3>' ));

    register_sidebar(array(	'name'=>'Footer-4',	'id'=> 'footer-4','before_widget' =>
    '<div id="footer%1$s" class="%2$s">','after_widget'  => '</div>','before_title'  => '<h3 class="widget-title">','after_title' => '</h3>' ));


}
add_action( 'init', 'the_widgets_init' );


/*
 * embed video from youtube, dailymotion, vimeo and your own host
 */
if( ! function_exists('embed_video') ){
    function embed_video($url, $width=550, $height=400) {
        $youtube = "/http:\/\/(.*youtube\.com\/watch.*|.*\.youtube\.com\/v\/.*|youtu";
        $youtube .="\.be\/.*|.*\.youtube\.com\/user\/.*#.*|.*\.youtube\.com\/.*#.*\/.*)/i";
        $dailymotion = "/http:\/\/(.*\.dailymotion\.com\/video\/.*|.*\.dailymotion\.com\/.*\/video\/.*)/i";
        $vimeo ="/http:\/\/(www\.vimeo\.com\/groups\/.*\/videos\/.*|www\.vimeo\.com\/.*|vimeo\.com\/groups\/.*\/videos\/.*|vimeo\.com\/.*)/i";

        if( preg_match($vimeo, $url) ) {
            $video_flag = 'vimeo';
        }
        elseif ( preg_match($youtube, $url) ) {
            $video_flag = 'youtube';
        }
        elseif ( preg_match($dailymotion, $url) ) {
            $video_flag = 'dailymotion';
        }
        else {
            $video_flag = 'flow';
        }

        switch ($video_flag) {
            case 'vimeo':
                $path = 'http://vimeo.com/moogaloop.swf?clip_id=';
                break;

            case 'youtube':
                $path = 'http://www.youtube.com/v/';
                break;

            case 'dailymotion':
                $path = 'http://www.dailymotion.com/swf/video/';
                break;
        }

        switch ($video_flag) {
            case 'vimeo':
                preg_match( '#http://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches );
                $video_id = $matches[3];
                break;

            case 'youtube':
                preg_match('#http://(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com/(watch\?v=|w/\?v=|\?v=)([\w-]+)(.*?)#i',$url, $matches);
                $video_id = $matches[3];
                break;

            case 'dailymotion':
                preg_match('#http://(www.dailymotion|dailymotion)\.com/(.+)/([0-9a-zA-Z]+)\_(.*?)#i',$url, $matches);
                $video_id = $matches[3];
                break;

        }

        switch ($video_flag) {
            case 'vimeo':
                $param = '&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1';
                break;

            case 'youtube':
                $param = '&amp;fs=1&amp;rel=0&amp;hd=1&amp;showsearch=0&amp;showinfo=1';
                break;

            case 'dailymotion':
                $param = '?additionalInfos=0';
                break;

        }

        if($video_flag == 'vimeo' || $video_flag =='youtube' || $video_flag == 'dailymotion') {
            $embedstring= '<div class="videox"><object type="application/x-shockwave-flash"  data="'. $path . $video_id . $param.'">'.
                '<param name="movie" value="' . $path . $video_id . $param . '" />' .
                '<param name="allowFullScreen" value="true" />' .
                '<param name="wmode" value="transparent" />' .
                '<param name="allowscriptaccess" value="always" />' .
                '<param name="flashvars" value="autoplay=false" />' .
                '</object></div>';

            return $embedstring;

        } else {

            $output = '<div class="videox"><a
				 href="'.$url.'"
				 style="display:block;"
				 id="player">
			</a>

			<!-- this will install flowplayer inside previous A- tag. -->
			<script type="text/javascript">
				flowplayer("player", { src: \''.HT_JS_PATH.'flowplayer-3.2.7.swf\', wmode: \'transparent\'},{ clip: { autoPlay: false },  canvas: {backgroundColor:\'#eeeeee\' }});
			</script></div>';
            return $output;
        }

    }

}



/*
* set the layout sidebar alignment.
*/
if( ! function_exists('ht_sidebar_layout') ){
    function ht_sidebar_layout($flag=0){
        if($flag){
            global $data;
            return $data['sidebar_layout'];

        }
        global $data, $post;

        if (get_post_meta($post->ID, '_disable_sidebar', true) !=''){
            $sidebar_layout ='no-sidebar';
        } elseif( get_post_meta($post->ID,'_sidebar_alignment',true) ){
            $sidebar_layout = get_post_meta($post->ID,'_sidebar_alignment',true);
        }
        else {
            $sidebar_layout = $data['sidebar_layout'];
        }

        return $sidebar_layout;

    }

}



/*
* Slideshow status.
*/
if( ! function_exists('ht_slideshow_status') ){
    function ht_slideshow_status($flag=0){
        if($flag){
            global $data;
            return $data['slideshow_status'];

        }
        global $data, $post;

        if (get_post_meta($post->ID, '_slideshow_status', true) !=''){
            $disable_slideshow = get_post_meta($post->ID, '_slideshow_status', true);
        }  else {
            $disable_slideshow = $data['slideshow_status'];
        }

        return $disable_slideshow;

    }

}




/*
 *  tweak wp_title to make it more useful
 */
if( ! function_exists('ht_filter_wp_title') ){
    function ht_filter_wp_title( $title, $separator ) {
        if ( is_feed() )
            return $title;

        global $paged, $page;

        if ( is_search() ) {
            $title = sprintf( __( 'Search results for %s','highthemes'), '"' . get_search_query() . '"' );
            if ( $paged >= 2 )
                $title .= " $separator " . sprintf( __( 'Page %s','highthemes' ), $paged );
            $title .= " $separator " . get_bloginfo( 'name', 'highthemes' );
            return $title;
        }

        $title .= get_bloginfo( 'name', 'highthemes' );

        $site_description = get_bloginfo( 'description', 'highthemes' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            $title .= " $separator " . $site_description;

        if ( $paged >= 2 || $page >= 2 )
            $title .= " $separator " . sprintf( __( 'Page %s','highthemes' ), max( $paged, $page ) );

        return $title;
    }

}
add_filter( 'wp_title', 'ht_filter_wp_title', 10, 2 );



/*
 *  limit Search Result
 */
if( ! function_exists('searchfilter') ){
    function searchfilter($query) {

        if ($query->is_search) {
            $query->set('post_type',array('post','portfolio'));
        }

        return $query;
    }
}
add_filter('pre_get_posts','searchfilter');



/*
 * comment form template
 */
if( ! function_exists('ht_comment_form') ){
    function ht_comment_form($form_options) {
        if(!isset($commenter['comment_author'])){$commenter['comment_author'] = 'Name';}
        if(!isset($commenter['comment_author_email'])){$commenter['comment_author_email'] = 'Email';}
        if(!isset($commenter['comment_author_url'])){$commenter['comment_author_url'] = 'Website';}


        // Fields Array
        $fields = array(

            'author' =>
            '<div class="personal-data"><p>' .
                ( $req ? '<span class="required">*</span>' : '' ) .
                '<label for="fullname">'.__('Full name','highthemes').'</label><input id="fullname" class="txt" name="author" type="text"  size="30"' . $aria_req . '  />' .
                '</p>',

            'email' =>
            '<p>' .
                ( $req ? '<span class="required">*</span>' : '' ) .
                '<label for="email">'.__('Email','highthemes').'</label><input  id="email" name="email" class="txt" type="text"  size="30"' . $aria_req . ' />' .
                '</p>',

            'url' =>
            '<p>'  .
                '<label for="url">'.__('Website URL','highthemes').'</label><input name="url" class="txt" size="30" id="url" type="text"  />' .
                '</p>
		</div>',

        );

        // Form Options Array
        $form_options = array(
            // Include Fields Array
            'fields' => apply_filters( 'comment_form_default_fields', $fields ),

            // Template Options
            'comment_field' =>

            '<div class="form-data"><p>' .
                '<label for="form_message">'. __('Comment','highthemes').'</label><textarea  name="comment" id="form_message" aria-required="true" rows="8" cols="45" ></textarea>' .
                '</p></div>',

            'must_log_in' =>
            '<p class="must-log-in">' .
                sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
                    wp_login_url( apply_filters( 'the_permalink', get_permalink($post_id) ) ) ) .
                '</p>',

            'logged_in_as' =>
            '<p class="logged-in-as">' .
                sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
                    admin_url('profile.php'), $user_identity, wp_logout_url( apply_filters('the_permalink', get_permalink($post_id)) ) ) .
                '</p>',

            'comment_notes_before' =>
            '',

            'comment_notes_after' => '',

            // Rest of Options
            'id_form' => 'form-comment',
            'id_submit' => 'submit',
            'title_reply' => __( 'Leave a Reply', 'highthemes' ),
            'title_reply_to' => __( 'Leave a Reply to %s', 'highthemes' ),
            'cancel_reply_link' => __( '<span>Cancel reply</span>', 'highthemes' ),
            'label_submit' => __( 'Post Comment' , 'highthemes'),
        );

        return $form_options;
    }
}
add_filter('comment_form_defaults', 'ht_comment_form');


/*
 * author bio box
 */
if( ! function_exists('ht_author_bio') ){
    function ht_author_bio() { ?>
    <div id="author-info">
        <div class="border-style">
            <div class="inner"><span class="fl"><?php echo get_avatar( get_the_author_meta('email'), '60' ); ?></span>
                <p>
                    <strong class="author-name">
                        <?php the_author_link(); ?>
                    </strong>
                    <?php if(get_the_author_meta('description') == '') {
                    echo __('The author didn\'t add any Information to his profile yet. ', 'highthemes');
                } else {
                    the_author_meta('description');
                } ?>
                </p>
                <div class="fix"></div>
            </div>
        </div>
    </div>
        <?php
    }

}


/*
*  print out the JS for homepage slider
*/
if( ! function_exists('ht_slider_js') ){
    function ht_slider_js() {
        global $data;
        ?>
    <script>
        jQuery(document).ready(function($) {
            $(window).load(function() {
                $('#slideshow .flexslider').flexslider({
                    animation: "<?php echo strtolower($data['slideshow_transition_effect']); ?>",
                    pauseOnHover: true,
                    keyboard: true,
                    animationLoop: true,
                    smoothHeight: true,
                    <?php if( $data['slideshow_timeout'] ) : ?>
                        slideshowSpeed: <?php echo $data['slideshow_timeout']; ?>000,
                        <?php else : ?>
                        slideshow: false,
                        <?php endif; ?>
                    <?php if( $data['disable_slideshow_nextprev']  ) echo 'directionNav: false,'; ?>
                    <?php if( $data['disable_slideshow_controlnav'] ) echo 'controlNav: false,'; ?>


                });

                $('#slideshow').hover(function(){
                    $('#slideshow .flex-next, #slideshow .flex-prev').css({'display':'block'});
                }, function(){
                    $('#slideshow .flex-next, #slideshow .flex-prev').css({'display':'none'});
                });

            });//end load
        });// end main jquery
    </script>
    <?php
    }

}
add_action('wp_head', 'ht_slider_js');

function add_googleplusone() {
    echo '<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
        <script type="text/javascript">
        function plusone_vote( obj ) {
            _gaq.push([\'_trackEvent\',\'plusone\',obj.state]);
        }
    </script>
    ';
}
add_action('wp_footer', 'add_googleplusone');


/*
*  print out the JS for homepage slider
*/
if( ! function_exists('ht_supersized_shutter') ){
    function ht_supersized_shutter() {
        global $data;
        ?>
    <script type="text/javascript">

(function(a){theme={_init:function(){if(api.options.slide_links){a(vars.slide_list).css("margin-left",-a(vars.slide_list).width()/2)}if(api.options.autoplay){if(api.options.progress_bar){theme.progressBar()}}else{if(a(vars.play_button).attr("src")){a(vars.play_button).attr("src",vars.image_path+"play.png")}if(api.options.progress_bar){a(vars.progress_bar).stop().animate({left:-a(window).width()},0)}}a(vars.thumb_tray).animate({bottom:-a(vars.thumb_tray).height()},0);a(vars.tray_button).toggle(function(){a(vars.thumb_tray).stop().animate({bottom:0,avoidTransforms:true},300);if(a(vars.tray_arrow).attr("src")){a(vars.tray_arrow).attr("src",vars.image_path+"button-tray-down.png")}return false},function(){a(vars.thumb_tray).stop().animate({bottom:-a(vars.thumb_tray).height(),avoidTransforms:true},300);if(a(vars.tray_arrow).attr("src")){a(vars.tray_arrow).attr("src",vars.image_path+"button-tray-up.png")}return false});a(vars.thumb_list).width(a("> li",vars.thumb_list).length*a("> li",vars.thumb_list).outerWidth(true));if(a(vars.slide_total).length){a(vars.slide_total).html(api.options.slides.length)}if(api.options.thumb_links){if(a(vars.thumb_list).width()<=a(vars.thumb_tray).width()){a(vars.thumb_back+","+vars.thumb_forward).fadeOut(0)}vars.thumb_interval=Math.floor(a(vars.thumb_tray).width()/a("> li",vars.thumb_list).outerWidth(true))*a("> li",vars.thumb_list).outerWidth(true);vars.thumb_page=0;a(vars.thumb_forward).click(function(){if(vars.thumb_page-vars.thumb_interval<=-a(vars.thumb_list).width()){vars.thumb_page=0;a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}else{vars.thumb_page=vars.thumb_page-vars.thumb_interval;a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}});a(vars.thumb_back).click(function(){if(vars.thumb_page+vars.thumb_interval>0){vars.thumb_page=Math.floor(a(vars.thumb_list).width()/vars.thumb_interval)*-vars.thumb_interval;if(a(vars.thumb_list).width()<=-vars.thumb_page){vars.thumb_page=vars.thumb_page+vars.thumb_interval}a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}else{vars.thumb_page=vars.thumb_page+vars.thumb_interval;a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}})}a(vars.next_slide).click(function(){api.nextSlide()});a(vars.prev_slide).click(function(){api.prevSlide()});if(jQuery.support.opacity){a(vars.prev_slide+","+vars.next_slide).mouseover(function(){a(this).stop().animate({opacity:1},100)}).mouseout(function(){a(this).stop().animate({opacity:0.6},100)})}if(api.options.thumbnail_navigation){a(vars.next_thumb).click(function(){api.nextSlide()});a(vars.prev_thumb).click(function(){api.prevSlide()})}a(vars.play_button).click(function(){api.playToggle()});if(api.options.mouse_scrub){a(vars.thumb_tray).mousemove(function(f){var c=a(vars.thumb_tray).width(),g=a(vars.thumb_list).width();if(g>c){var b=1,d=f.pageX-b;if(d>10||d<-10){b=f.pageX;newX=(c-g)*(f.pageX/c);d=parseInt(Math.abs(parseInt(a(vars.thumb_list).css("left"))-newX)).toFixed(0);a(vars.thumb_list).stop().animate({left:newX},{duration:d*3,easing:"easeOutExpo"})}}})}a(window).resize(function(){if(api.options.progress_bar&&!vars.in_animation){if(vars.slideshow_interval){clearInterval(vars.slideshow_interval)}if(api.options.slides.length-1>0){clearInterval(vars.slideshow_interval)}a(vars.progress_bar).stop().animate({left:-a(window).width()},0);if(!vars.progressDelay&&api.options.slideshow){vars.progressDelay=setTimeout(function(){if(!vars.is_paused){theme.progressBar();vars.slideshow_interval=setInterval(api.nextSlide,api.options.slide_interval)}vars.progressDelay=false},1000)}}if(api.options.thumb_links&&vars.thumb_tray.length){vars.thumb_page=0;vars.thumb_interval=Math.floor(a(vars.thumb_tray).width()/a("> li",vars.thumb_list).outerWidth(true))*a("> li",vars.thumb_list).outerWidth(true);if(a(vars.thumb_list).width()>a(vars.thumb_tray).width()){a(vars.thumb_back+","+vars.thumb_forward).fadeIn("fast");a(vars.thumb_list).stop().animate({left:0},200)}else{a(vars.thumb_back+","+vars.thumb_forward).fadeOut("fast")}}})},goTo:function(b){if(api.options.progress_bar&&!vars.is_paused){a(vars.progress_bar).stop().animate({left:-a(window).width()},0);theme.progressBar()}},playToggle:function(b){if(b=="play"){if(a(vars.play_button).attr("src")){a(vars.play_button).attr("src",vars.image_path+"pause.png")}if(api.options.progress_bar&&!vars.is_paused){theme.progressBar()}}else{if(b=="pause"){if(a(vars.play_button).attr("src")){a(vars.play_button).attr("src",vars.image_path+"play.png")}if(api.options.progress_bar&&vars.is_paused){a(vars.progress_bar).stop().animate({left:-a(window).width()},0)}}}},beforeAnimation:function(b){if(api.options.progress_bar&&!vars.is_paused){a(vars.progress_bar).stop().animate({left:-a(window).width()},0)}if(a(vars.slide_caption).length){(api.getField("title"))?a(vars.slide_caption).html(api.getField("title")):a(vars.slide_caption).html("")}if(vars.slide_current.length){a(vars.slide_current).html(vars.current_slide+1)}if(api.options.thumb_links){a(".current-thumb").removeClass("current-thumb");a("li",vars.thumb_list).eq(vars.current_slide).addClass("current-thumb");if(a(vars.thumb_list).width()>a(vars.thumb_tray).width()){if(b=="next"){if(vars.current_slide==0){vars.thumb_page=0;a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}else{if(a(".current-thumb").offset().left-a(vars.thumb_tray).offset().left>=vars.thumb_interval){vars.thumb_page=vars.thumb_page-vars.thumb_interval;a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}}}else{if(b=="prev"){if(vars.current_slide==api.options.slides.length-1){vars.thumb_page=Math.floor(a(vars.thumb_list).width()/vars.thumb_interval)*-vars.thumb_interval;if(a(vars.thumb_list).width()<=-vars.thumb_page){vars.thumb_page=vars.thumb_page+vars.thumb_interval}a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}else{if(a(".current-thumb").offset().left-a(vars.thumb_tray).offset().left<0){if(vars.thumb_page+vars.thumb_interval>0){return false}vars.thumb_page=vars.thumb_page+vars.thumb_interval;a(vars.thumb_list).stop().animate({left:vars.thumb_page},{duration:500,easing:"easeOutExpo"})}}}}}}},afterAnimation:function(){if(api.options.progress_bar&&!vars.is_paused){theme.progressBar()}},progressBar:function(){a(vars.progress_bar).stop().animate({left:-a(window).width()},0).animate({left:0},api.options.slide_interval)}};a.supersized.themeVars={progress_delay:false,thumb_page:false,thumb_interval:false,image_path:"<?php echo get_template_directory_uri();?>/images/slider/",play_button:"#pauseplay",next_slide:"#nextslide",prev_slide:"#prevslide",next_thumb:"#nextthumb",prev_thumb:"#prevthumb",slide_caption:"#slidecaption",slide_current:".slidenumber",slide_total:".totalslides",slide_list:"#slide-list",thumb_tray:"#thumb-tray",thumb_list:"#thumb-list",thumb_forward:"#thumb-forward",thumb_back:"#thumb-back",tray_arrow:"#tray-arrow",tray_button:"#tray-button",progress_bar:"#progress-bar"};a.supersized.themeOptions={progress_bar:1,mouse_scrub:0}})(jQuery);

    </script>
    <?php
    }

}
add_action('wp_head', 'ht_supersized_shutter');

?>