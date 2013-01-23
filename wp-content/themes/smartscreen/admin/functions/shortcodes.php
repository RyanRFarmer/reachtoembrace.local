<?php
/**
 *
 * HighThemes Options Framework
 * twitter : http://twitter.com/theHighthemes
 *
 */



/**
 * Disable Automatic Formatting on Posts
 *
 * @param string $content
 * @return string
 */
if( ! function_exists( 'ht_formatter' ) ) {
    function ht_formatter($content) {

        $new_content = '';
        $pattern_full = '{(\[raw\].*?\[/raw\])}is';
        $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
        $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($pieces as $piece) {
            if (preg_match($pattern_contents, $piece, $matches)) {
                $new_content .= $matches[1];
            } else {
                $new_content .= wptexturize(wpautop($piece));
            }
        }

        return $new_content;
    }
}
remove_filter('the_content',	'wpautop');
remove_filter('the_content',	'wptexturize');

add_filter('the_content', 'ht_formatter', 99);
add_filter('widget_text', 'ht_formatter', 99);


/*
 * Lists
 */
if( ! function_exists( 'ht_list' ) ) {
    function ht_list( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'type'	=> 'bulletlist'
        ), $atts));

        return str_replace('<ul>', '<ul class="'.$type.'">', do_shortcode($content));
    }
}
add_shortcode("list", "ht_list");

/*
 * Buttons
 */
if( ! function_exists( 'ht_button' ) ) {
    function ht_button( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'link'      => '#',
            'type'      => 'glossy', // simple, glossy
            'size' 		=> 'small', // small, medium. large
            'color'		=> 'black' // magenta, rosy, pink, orange, yellow, red, green, blue, grey, black, purple, teal
        ), $atts));

        if($type == 'glossy') {
            return '<a class="button '.$size.' '.$color.'" href="'.$link.'"><span></span>'.$content.'</a>';
        } else {
            return '<a class="s-button '.$size.' s-'.$color.'" href="'.$link.'"><span></span>'.$content.'</a>';
        }
    }
}
add_shortcode('button', 'ht_button');

/*
 * Icon Link
 */
if( ! function_exists( 'ht_icon_link' ) ) {
    function ht_icon_link( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'link'      => '#',
            'icon'      => 'print-icon'
        ), $atts));

        return '[raw]<a class="icon-link" href="'.$link.'"><span class="'.$icon.'">'.$content.'</span></a>[/raw]';
    }
}
add_shortcode('icon_link', 'ht_icon_link');

/*
 * Special Boxes
 */
if( ! function_exists( 'ht_simple_box' ) ) {
    function ht_simple_box( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'border_size'	=> '1px',
            'border_color'	=> '#000'
        ), $atts));

        return '<div style="border:'.$border_size.' solid '.$border_color.'" class="simple-box">'. do_shortcode($content) .'</div>';
    }
}
add_shortcode('simple_box', 'ht_simple_box');

/*
 * Titled Box
 */
if( ! function_exists( 'ht_titled_box' ) ) {
    function ht_titled_box( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'      => 'title',
            'color'		=> 'white'
        ), $atts));
        $out = '';
        $out .= '<h6 class="titled-box-header s-'.$color.'"><span>'.$title.'</span></h6>';
        $out .= '<div class="titled-box">'. do_shortcode($content) .'</div>';

        return $out;
    }
}
add_shortcode('titled_box', 'ht_titled_box');

/*
 * Info Box
 */
if( ! function_exists( 'ht_info_box' ) ) {
    function ht_info_box( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'type' => 'titled',
            'title' => 'title',
            'color' => 'green',
            'icon' => 'download'
        ), $atts));
        $out = '';
        if($type == 'titled') {
            $out .= '<div class="info-box-wrapper">';
            if($icon == 'noicon') {
                $out .= '<div class="info-box-'.$color.'-header"><div class="info-content-box">'.do_shortcode($title).'</div></div>';
            } else {
                $out .= '<div class="info-box-'.$color.'-header info-box-'.$icon.'"><div class="info-content-box-icon">'.do_shortcode($title).'</div></div>';
            }
            $out .= '</div>';
        } else {
            $out .= '<div class="info-box-wrapper">';
            if($icon == 'noicon') {
                $out .= '<div class="info-box-'.$color.'-header"><div class="info-content-box">'.do_shortcode($title).'</div></div>';
            } else {
                $out .= '<div class="info-box-'.$color.'-header info-box-'.$icon.'"><div class="info-content-box-icon">'.do_shortcode($title).'</div></div>';
            }
            $out .= '<div class="info-box-'.$color.'-body"><div class="info-content-box">'. do_shortcode($content) .'</div></div>';
            $out .= '</div>';
        }

        return $out;
    }

}
add_shortcode('info_box', 'ht_info_box');

/*
 * Call to action 
 */
if( ! function_exists( 'ht_cta_box' ) ) {
    function ht_cta_box( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'button_color' => 'green',
            'button_title' => '',
            'button_url' => '',
            'title' => ''
        ), $atts));


        $out = '';
        $out .= ' [raw]<div class="cta-box">';
        if(!empty($button_title)) {
            $out .= ' <a href="'.$button_url.'" class="s-button large s-'.$button_color.'"><span></span>'.$button_title.'</a>';
        }
        $out .= ' <div class="cta-text">';
        $out .= ' <h2>'.$title.'</h2>';
        $out .= ' <p>'.$content.'</p>';
        $out .= ' </div>';
        $out .= ' </div>[/raw]';

        return $out;

    }

}
add_shortcode('cta_box', 'ht_cta_box');

/*
 * Tooltip
 */
if( ! function_exists( 'ht_tooltip' ) ) {
    function ht_tooltip( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'trigger'      => '',
        ), $atts));
        $out = '';
        $out .= '[raw]<span class="tooltip_sc">'.$trigger.'</span>';
        $out .= '<div class="tool_tip">';
        $out .= '<div class="tooltip_body">'.$content.'</div>';
        $out .= '<div class="tooltip_tip"></div>';
        $out .= '</div>[/raw]';

        return $out;
    }

}
add_shortcode('tooltip', 'ht_tooltip');

/*
 * Embed Video
 */
if( ! function_exists( 'ht_embed_video' ) ) {
    function ht_embed_video( $atts) {
        extract(shortcode_atts(array(
            'url'      => 'videmo, youtube, daily motion or flv, mp4, and swf',
            'width'		=> '550',
            'height' 	=> '400'
        ), $atts));



        return "[raw]". embed_video($url, $width, $height). "[/raw]";
    }

}
add_shortcode('video', 'ht_embed_video');

/*
 * Code & Pre
 */
if( ! function_exists( 'ht_code' ) ) {
    function ht_code( $atts, $content = null ) {
        return '<code class="code">'.$content.'</code>';
    }
}
add_shortcode('code_sc', 'ht_code');

// pre
if( ! function_exists( 'ht_pre' ) ) {
    function ht_pre( $atts, $content = null ) {
        return '<pre class="pre">'.$content.'</pre>';
    }

}
add_shortcode('pre', 'ht_pre');

/*
 * Dividers
 */
if( ! function_exists( 'ht_divider' ) ) {
    function ht_divider( $atts, $content = null ) {
        return '<div class="divider"></div>';
    }

}
add_shortcode('hr', 'ht_divider');


// with top link
if( ! function_exists( 'ht_divider_top' ) ) {
    function ht_divider_top( $atts, $content = null ) {
        return '<div class="divider top"><a href="#wrap">'.__('Top','highthemes').'</a></div>';
    }
}
add_shortcode('hr_top', 'ht_divider_top');

/*
 * Drop-Caps
 */
if( ! function_exists( 'ht_drop_cap' ) ) {
    function ht_drop_cap( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'type'      => 'dropcap1'
        ), $atts));

        return '<span class="'.$type.'">'.$content.'</span>';
    }

}
add_shortcode('dropcap', 'ht_drop_cap');

/*
 * Pullquote
 */
if( ! function_exists( 'ht_callout_right' ) ) {
    function ht_callout_right( $atts, $content = null ) {
        return '<blockquote class="pullquote-right"><p>'. do_shortcode($content) .'</p></blockquote>';
    }
}
add_shortcode('callout_right', 'ht_callout_right');

// callout left
if( ! function_exists( 'ht_callout_left' ) ) {
    function ht_callout_left( $atts, $content = null ) {
        return '<blockquote class="pullquote-left"><p>' . do_shortcode($content) . '</p></blockquote>';
    }
}
add_shortcode('callout_left', 'ht_callout_left');

// pullquote
if( ! function_exists( 'ht_pullquote' ) ) {
    function ht_pullquote( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'cite'      => ''
        ), $atts));
        $out = '';
        $out .= '<blockquote class="pullquote">';
        $out .= 	'<p>'. do_shortcode($content) .'<cite>'.$cite.'</cite></p>';
        $out .= '</blockquote>';

        return $out;
    }

}
add_shortcode('pullquote', 'ht_pullquote');

/*
 * Toggle
 */
if( ! function_exists( 'ht_toggle' ) ) {
    function ht_toggle( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'		=> ''
        ), $atts));
        $out = '';
        $out .= '<div class="toggle-item">';
        $out .= 	'<div class="toggle-head"><h3><span class="arrow"></span>'.$title.'</h3></div>';
        $out .= 	'<div class="toggle-body"><p>'.do_shortcode($content).'</p></div>';
        $out .= '</div>';


        return $out;
    }

}
add_shortcode('toggle', 'ht_toggle');

/*
 * Text Highlight
 */
if( ! function_exists( 'ht_highlight' ) ) {
    function ht_highlight ($atts, $content = null) {
        extract(shortcode_atts(array(
            'color'      => 'yellow' //red, black
        ), $atts));

        return '<span class="highlight-'.$color.'">'. do_shortcode($content) .'</span>';
    }

}
add_shortcode('highlight', 'ht_highlight');

/*
 * Image Frames
 */
if( ! function_exists( 'ht_lightbox' ) ) {
    function ht_lightbox ($atts, $content = null) {
        extract(shortcode_atts(array(
            'big_image_url'      => '',
            'video_url'      => '',
            'type'      => 'image', //image , video
            'align'      => '', // left , right
            'title'      => '',
        ), $atts));

        $out = '';
        if($type == 'image' || empty($type)) {
            $out .=  '<a href="'.$big_image_url.'" title="'.$title.'" data-rel="prettyPhoto[gallery]">';
            $out .=  '<img src="'.$content.'" alt="" />';
            $out .=  '<span class="zoom"></span>';
            $out .=  '</a>';
        } else {
            $out .=  '<a href="'.$video_url.'" title="'.$title.'" data-rel="prettyPhoto[gallery]">';
            $out .=  '<img src="'.$content.'" alt="" />';
            $out .=  '<span class="video"></span>';
            $out .=  '</a>';
        }
        if($align == 'right') {
            $out = '<div class="frame fr sc-lightbox">'.$out.'</div>';
        } elseif($align == 'left') {
            $out = '<div class="frame fl sc-lightbox">'.$out.'</div>';
        } else {
            $out = '<div class="frame sc-lightbox">'.$out.'</div>';
        }
        return $out;
    }

}
add_shortcode('lightbox', 'ht_lightbox');

if( ! function_exists( 'ht_image_left' ) ) {
    function ht_image_left( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'link'      => '',
        ), $atts));
        $out = '';
        if(trim($link) !='') {
            $out .= '<a href="'.$link.'"><p class="alignleft"><img class="frame" src="' . $content . '" title="" alt="" /></p></a>';
        } else {
            $out .= '<p class="alignleft"><img class="frame" src="' . $content . '" title="" alt="" /></p>';
        }
        return $out;
    }

}
add_shortcode('image_left', 'ht_image_left');

// image right
if( ! function_exists( 'ht_image_right' ) ) {
    function ht_image_right( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'link'      => '',
        ), $atts));
        $out = '';
        if(trim($link) !='') {
            $out .= '<a href="'.$link.'"><p class="alignright"><img class="frame" src="' . $content . '" title="" alt="" /></p></a>';
        } else {
            $out .= '<p class="alignright"><img class="frame" src="' . $content . '" title="" alt="" /></p>';
        }

        return $out;
    }

}
add_shortcode('image_right', 'ht_image_right');

// image centered
if( ! function_exists( 'ht_image_center' ) ) {
    function ht_image_center( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'link'      => '',
        ), $atts));
        $out = '';
        if(trim($link) !='') {
            $out .= '<p class="aligncenter"><a href="'.$link.'"><img class="aligncenter" src="' . $content . '" title="" alt="" /></a></p>';
        } else {
            $out .= '<p class="aligncenter"><img class="frame aligncenter" src="' . $content . '" title="" alt="" /></p>';
        }

        return $out;
    }

}
add_shortcode('image_center', 'ht_image_center');

/*
* Tabs
*/
if( ! function_exists( 'ht_tabs_sc' ) ) {
    function ht_tabs_sc( $atts, $content = null ) {
        extract(shortcode_atts(array(
        ), $atts));
        $out = '';
        $out .= '[raw]<div class="tab-set">[/raw]';
        $out .= '<ul class="tabs-titles">';
        foreach ($atts as $tab) {
            $out .= '<li><a href="#">' .$tab. '</a></li>';
        }
        $out .= '</ul>';
        $out .= do_shortcode($content) .'[raw]</div>[/raw]';

        return $out;
    }

}
add_shortcode('tabs', 'ht_tabs_sc');
if( ! function_exists( 'custom_tabs_sc' ) ) {
    function custom_tabs_sc( $atts, $content = null ) {
        extract(shortcode_atts(array(
        ), $atts));

        return '[raw]<div class="tab-content">[/raw]' . do_shortcode($content) .'</div>';
    }

}
add_shortcode('tab', 'custom_tabs_sc');

/* 
* Accordions
*/
if( ! function_exists( 'ht_accordions_sc' ) ) {
    function ht_accordions_sc( $atts, $content = null ) {
        extract(shortcode_atts(array(
        ), $atts));
        $out = '';
        $out .= '[raw]<div class="accordion">[/raw]';
        $out .= 	do_shortcode($content);
        $out .= '[raw]</div>[/raw]';

        return $out;
    }

}
add_shortcode('accordions', 'ht_accordions_sc');

if( ! function_exists( 'ht_accordion_sc' ) ) {
    function ht_accordion_sc( $atts, $content = null ) {
        extract(shortcode_atts(array('title'=>'',
        ), $atts));
        $out = '';
        $out .= '[raw]<div class="acc-item"><div class="acc-head"><h3><span class="arrow"></span>' .$title. '</h3></div>[/raw]';
        $out .= 	'[raw]<div class="acc-content"><p>'.$content.'</p></div>';
        $out .= '</div>[/raw]';

        return $out;
    }

}
add_shortcode('accordion', 'ht_accordion_sc');

/* 
* Slideshow
*/
if( ! function_exists( 'ht_slideshow' ) ) {
    function ht_slideshow( $atts, $content = null ) {
        extract(shortcode_atts(array('width' =>'500'
        ), $atts));
        $out = '';
        $out .= '<div style="width: ' . $width . 'px" class="slideshow-sc flexslider"><ul class="slides">';
        $out .= 	do_shortcode($content);
        $out .= '</ul></div>';

        return $out;
    }

}
add_shortcode('slideshow', 'ht_slideshow');

if( ! function_exists( 'ht_slide' ) ) {
    function ht_slide( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'link'		=> '#',
            'width' => '',
            'height' =>'',
            'resize' =>'true'
        ), $atts));
        $out = '';
        if($resize == 'true'){

            $image_size = ht_image_resize($height, $width, $content);

            if($link == '') {
                $out .= '[raw]<li><img width="'.$width.'" height="'.$height.'" class="frame" src="'.$image_size.'" alt="" /></li>[/raw]';
            } else {
                $out .= '[raw]<li><a href="'.$link.'"><img width="'.$width.'" height="'.$height.'" class="frame" src="'.$image_size.'" alt="" /></a></li>[/raw]';
            }
        } else {
            if($link == '') {
                $out .= '[raw]<li><img width="'.$width.'" height="'.$height.'" class="frame" src="'.$content.'" alt="" /></li>[/raw]';

            } else {
                $out .= '[raw]<li><a href="'.$link.'"><img width="'.$width.'" height="'.$height.'" class="frame" src="'.$content.'" alt="" /></a></li>[/raw]';
            }

        }

        return $out;
    }

}
add_shortcode('slide', 'ht_slide');

/* 
* Testimonial
*/
if( ! function_exists( 'ht_testimonials' ) ) {
    function ht_testimonials( $atts, $content = null ) {
        $out="";
        $out .= '<div class="sc-testimonials"><div class="flexslider"><ul class="slides">';
        $out .= 	do_shortcode($content);
        $out .= '</ul></div></div>';

        return $out;
    }

}
add_shortcode('testimonials', 'ht_testimonials');

if( ! function_exists( 'ht_testimonial' ) ) {
    function ht_testimonial( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'name'			=> 'John Smith',
            'website_url'	=> 'http://www.site.com'
        ), $atts));

        if($name == '' && $website_url !='') {
            return '<li class="testimonial"><p>'.$content.'<cite>'.$website_url.'</cite></p></li>';
        } elseif($name != '' && $website_url =='') {
            return '<li class="testimonial"><p>'.$content.'<cite>- '.$name.'</cite></p></li>';
        } elseif($name == '' && $website_url =='') {
            return '<li class="testimonial"><p>'.$content.'</p></li>';
        } else {
            return '<li class="testimonial"><p>'.$content.'<cite>- '.$name.', '.$website_url.'</cite></p></li>';
        }
    }

}
add_shortcode('testimonial', 'ht_testimonial');

/*
* Progress Bar
*/
if( ! function_exists( 'ht_progress' ) ) {
    function ht_progress( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'value'	=> '10', // 1-100
            'color'	=> 'grey',
            'width'	=> '10', // 1-100
            'type'	=> 'simple' // Simple,Round
        ), $atts));

        $out = '';
        $out .= '<div style="width: '.$width.'%" class="progress '.($type == 'round' ? round : simple).'">';
        $out .= '<span class="meter s-'.$color.'" style="width: '.$value.'%;">'.$content.'</span>';
        $out .= '</div>';
        return $out;
    }

}
add_shortcode('progress', 'ht_progress');

/*
* Socialized
*/
if( ! function_exists( 'ht_socialized' ) ) {
    function ht_socialized( $atts, $content = null ) {
        $out = '';
        $out .= '<div class="social-bookmarks">'.$content.'</div>';
        return $out;
    }

}
add_shortcode('socialized', 'ht_socialized');

/*
* Google Map
*/
if( ! function_exists( 'ht_google_map' ) ) {
    function ht_google_map( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'lat'	=> '0',
            'lng'	=> '0',
            'zoom'	=> '10', // 1-19
            'type'	=> 'ROADMAP' // ROADMAP, SATELLITE, HYBRID, TERRAIN
        ), $atts));

        $unique = uniqid();
        $out = <<<EOF
[raw]<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var latlng=new google.maps.LatLng({$lat},{$lng});
function initialize()
{
var mapProp = {
center:latlng,
zoom:{$zoom},
zoomControl:true,
mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
navigationControl: true,
navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
panControl:true,
mapTypeId:google.maps.MapTypeId.{$type}
};
var map=new google.maps.Map(document.getElementById("google_map_{$unique}"),mapProp);
var marker=new google.maps.Marker({
position:latlng,
map: map,
title: ''
});
marker.setMap(map);
var infowindow = new google.maps.InfoWindow({
content:"{$content}"
});
google.maps.event.addListener(marker, 'click', function() {
infowindow.open(map,marker);
});
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>[/raw]
<div id="google_map_{$unique}" class="google-map"></div>
EOF;

        return $out;

    }

}

add_shortcode('google_map', 'ht_google_map');



/* 
* Pricing Table
*/
if( ! function_exists( 'ht_pricing_table' ) ) {
    function ht_pricing_table( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'cols'	=> '4'
        ), $atts));
        $out = '';
        $out .= '<div class="pricing-tables pricing-table-'.$cols.'col">';
        $out .= 	do_shortcode($content);
        $out .= '</div>';

        return $out;
    }

}
add_shortcode('pricing_table', 'ht_pricing_table');

if( ! function_exists( 'ht_pricing_col' ) ) {
    function ht_pricing_col( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'title'		=> 'standard',
            'color'		=> 'teal',
            'price'		=> '',
            'special'	=> 'false',
            'special_color'	=> 'orange',
            'button_title'	=> '',
            'button_link'	=> '#'
        ), $atts));
        $out = '';
        if($special == 'false') {
            $out .= '[raw]<div class="pricing-table">';
            $out .=     '<div class="pricing-block s-'.$color.'">';
        } else {
            $out .= '[raw]<div class="pricing-table pricing-special">';
            $out .=     '<div class="pricing-block s-'.$special_color.'">';
        }
        $out .=         '<h2 class="pricing-title">'.$title.'</h2>';
        $out .=     '</div>';
        $out .=     '<div class="pricing-block s-grey">';
        $out .=         '<h2 class="pricing-price">'.$price.'<span>$</span></h2>';
        $out .=     '</div>';
        $out .= 	'<div class="pricing-body">';
        $out .= 	    ''.do_shortcode($content).'';
        $out .= 	'</div>';
        $out .=     '<div class="pricing-block s-grey">';
        $out .=         '<a href="'.$button_link.'" class="s-button medium s-'.$special_color.'">'.$button_title.'</a>';
        $out .=     '</div>';
        $out .= '</div>[/raw]';

        return $out;
    }

}
add_shortcode('col', 'ht_pricing_col');

/*
 * Grid Columns
 */
if( ! function_exists( 'ht_one_third' ) ) {
    function ht_one_third( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_third">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('one_third', 'ht_one_third');

if( ! function_exists( 'ht_one_third_last' ) ) {
    function ht_one_third_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('one_third_last', 'ht_one_third_last');

if( ! function_exists( 'ht_two_third' ) ) {
    function ht_two_third( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="two_third">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('two_third', 'ht_two_third');

if( ! function_exists( 'ht_two_third_last' ) ) {
    function ht_two_third_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('two_third_last', 'ht_two_third_last');

if( ! function_exists( 'ht_one_half' ) ) {
    function ht_one_half( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_half">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('one_half', 'ht_one_half');

if( ! function_exists( 'ht_one_half_last' ) ) {
    function ht_one_half_last( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('one_half_last', 'ht_one_half_last');

if( ! function_exists( 'ht_one_fourth' ) ) {
    function ht_one_fourth( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('one_fourth', 'ht_one_fourth');

if( ! function_exists( 'ht_one_fourth_last' ) ) {
    function ht_one_fourth_last( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('one_fourth_last', 'ht_one_fourth_last');

if( ! function_exists( 'ht_three_fourth' ) ) {
    function ht_three_fourth( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('three_fourth', 'ht_three_fourth');

if( ! function_exists( 'ht_three_fourth_last' ) ) {
    function ht_three_fourth_last( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('three_fourth_last', 'ht_three_fourth_last');
if( ! function_exists( 'ht_one_fifth' ) ) {
    function ht_one_fifth( $atts, $content = null ) {

        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('one_fifth', 'ht_one_fifth');

if( ! function_exists( 'ht_one_fifth_last' ) ) {
    function ht_one_fifth_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('one_fifth_last', 'ht_one_fifth_last');

if( ! function_exists( 'ht_two_fifth' ) ) {
    function ht_two_fifth( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('two_fifth', 'ht_two_fifth');

if( ! function_exists( 'ht_two_fifth_last' ) ) {
    function ht_two_fifth_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('two_fifth_last', 'ht_two_fifth_last');
if( ! function_exists( 'ht_three_fifth' ) ) {
    function ht_three_fifth( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('three_fifth', 'ht_three_fifth');

if( ! function_exists( 'ht_three_fifth_last' ) ) {
    function ht_three_fifth_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('three_fifth_last', 'ht_three_fifth_last');
if( ! function_exists( 'ht_four_fifth' ) ) {
    function ht_four_fifth( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('four_fifth', 'ht_four_fifth');

if( ! function_exists( 'ht_four_fifth_last' ) ) {
    function ht_four_fifth_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('four_fifth_last', 'ht_four_fifth_last');
if( ! function_exists( 'ht_one_sixth' ) ) {
    function ht_one_sixth( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('one_sixth', 'ht_one_sixth');

if( ! function_exists( 'ht_one_sixth_last' ) ) {
    function ht_one_sixth_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('one_sixth_last', 'ht_one_sixth_last');

if( ! function_exists( 'ht_five_sixth' ) ) {
    function ht_five_sixth( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('five_sixth', 'ht_five_sixth');

if( ! function_exists( 'ht_five_sixth_last' ) ) {
    function ht_five_sixth_last( $atts, $content = null ) {
        $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="fix"></div>';
    }

}
add_shortcode('five_sixth_last', 'ht_five_sixth_last');

/*
 * Misc
 */
if( ! function_exists( 'ht_line' ) ) {
    function ht_line( $atts, $content = null ) {
        return '<div class="line-sc"></div>';
    }

}
add_shortcode('line', 'ht_line');
if( ! function_exists( 'ht_p_sc' ) ) {
    function ht_p_sc( $atts, $content = null ) {
        return '<p class="p-sc">' . do_shortcode($content) . '</p>';
    }

}
add_shortcode('p', 'ht_p_sc');
if( ! function_exists( 'ht_image_sc' ) ) {
    function ht_image_sc( $atts, $content = null ) {
        return '<div class="image-sc">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('image', 'ht_image_sc');
if( ! function_exists( 'ht_text_align_center' ) ) {
    function ht_text_align_center( $atts, $content = null ) {
        return '<div style="text-align: center;">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('text_align_center', 'ht_text_align_center');
if( ! function_exists( 'ht_text_align_right' ) ) {
    function ht_text_align_right( $atts, $content = null ) {
        return '<div style="text-align: right;">' . do_shortcode($content) . '</div>';
    }

}
add_shortcode('text_align_right', 'ht_text_align_right');
?>