<?php
global 	$data;
$output = '';

if($data['body_background'] || $data['custom_bg']){
    $output .="
    body {
        background-color:  {$data['body_background']};
    }
    ";
}

if($data['main_background_color'] || $data['custom_bg']){
    $output .="
    ul.arrowlist li:before, .dropcap2, .dropcap3, .widget .tagcloud a, .tags a, .search-box .search-field {
        background-color: ".$data['main_background_color'].";
    }
    .special-heading {
        border-left-color: ".$data['main_background_color'].";
    }
    #main, #controls-wrap {
        border-top-color: ".$data['main_background_color'].";
    }
    #menu-wrap, #sidebar, #slidecaption, .social-bookmarks ul li, #controls-wrap, #thumb-tray, #nav ul ul, #nav-horizontal ul li ul {
        background-color:rgba( ".hex_to_rgb($data['main_background_color']) . ", .7);
    }
    #menu-wrap, #sidebar, #slidecaption, .social-bookmarks ul li, #controls-wrap, #thumb-tray, #nav ul ul, #nav-horizontal ul li ul {
        background-color:rgb( ".hex_to_rgb($data['main_background_color']) . ")\9;
    }
    ";
}

if($data['custom_bg'] && $data['custom_bg'] != get_template_directory_uri() . '/images/bg/0.png'){
    $output .="
    body, #wrap-wide {
        background-image: url(". $data['custom_bg'].");
    }
    ";
}

if($data['body_font']){
    $output .="
    body {
        font-size:{$data['body_font']['size']} ;
        font-family:  ".trim_google_font($data['body_font']['face']).", sans-serif;
        color:{$data['body_font']['color']};
    }
    ";
}

if($data['link_color']){
    $output .='
    a:link, a:visited {
        color: '.$data['link_color'].';
    }';
}

if($data['link_hover_color']){
    $output .='
    a:hover, a:active {
        color: '.$data['link_hover_color'].';
    }
    #entries .post-meta a:hover, #nav a:hover, #sidebar ul li a:hover,#entries .read-more:hover,
     #portfolio .folio-cats a:hover, .single-portfolio .meta a:hover, a.icon-link:hover, .comment-author-info a:hover,
      .entry ul li a:hover, .widget .tagcloud a:hover, .tags a:hover {
        color: '.$data['link_hover_color'].' !important;
    }';
}


if($data['sidebar_font']['face']){
    $output .='
    #sidebar .widget h3.widget-title{
        font: '.$data['sidebar_font']['style'].' '.$data['sidebar_font']['size'].' "'.trim_google_font($data['sidebar_font']['face']).'", Arial, sans-serif;
    }
    ';

}

if($data['sidebar_font_color']){
    $output .='
    #sidebar .widget h3.widget-title {
        color: '.$data['sidebar_font_color'].';
    }
    ';

}

if($data['heading_font']['face']){
    $output .='
    h1,h2,h3,h4,h5,h6, #entries h3.post-title, #entries h3.post-title a , #entries h3.post-title a:active, .special-heading, #entries h2.page-title,
     #portfolio .folio-box h3.folio-title, #portfolio .folio-box h3.folio-title a, #portfolio .folio-box h3.folio-title:active
     {
        font-family: "'.trim_google_font($data['heading_font']['face']).'", Arial, sans-serif;
        color: '.$data['heading_font']['color'].';
    }

    #filters li a,#content a.button,  #slidecaption h2,
     #related-folio .folio-box h3.folio-title, #related-folio .folio-box h3.folio-title a, #related-folio .folio-box h3.folio-title:active
     { font-family: "'.trim_google_font($data['heading_font']['face']).'", Arial, sans-serif;}
    ';

}

if($data['navigation_font']['face']){
    $output .='
    #nav a {
        font-family: "'.trim_google_font($data['navigation_font']['face']).'", Arial, sans-serif;
        font-weight: '.$data['navigation_font']['style'].';
        font-size:'.$data['navigation_font']['size'].';
    }';
}

if($data['navigation_font_color']){
    $output .='
    #nav a {
        color:'.$data['navigation_font_color'].';
    }';
}

if($data['navigation_line_color']){
    $output .='
    .jqueryslidemenu ul li, #nav-toggle-content ul li {
        color:'.$data['navigation_line_color'].';
    }';
}

if($data['navigation_desc_color']){
    $output .='
    .jqueryslidemenu span {
        color:'.$data['navigation_desc_color'].';
    }';
}


if($data['page_heading_color']){
    $output .='
    #entries h2.page-title {
        color: '.$data['page_heading_color'].';
    }';
}

if($data['custom_css']){
    $output .= $data['custom_css'];
}

//compress output
$output = preg_replace('/\r|\n|\t/', '', $output);


    echo "\n<!-- custom styles set at your backend-->\n";
    echo "<style type='text/css' id='dynamic-styles'>\n";
    echo $output;
    echo "\n</style>\n";
    echo "\n<!-- end custom styles-->\n\n";
?>