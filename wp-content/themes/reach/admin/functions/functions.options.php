<?php
/**
 *
 * HighThemes Options Framework
 * twitter : http://twitter.com/theHighthemes
 *
 */

add_action('init', 'of_options');

if (!function_exists('of_options')) {
    function of_options()
    {
        // categories
        $of_categories = array();
        $of_categories_obj = get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
        }
        //$categories_tmp = array_unshift($of_categories, "Select a category:");

        // pages
        $of_pages = array();
        $of_pages_obj = get_pages('sort_column=post_parent,menu_order');
        foreach ($of_pages_obj as $of_page) {
            $of_pages[$of_page->ID] = $of_page->post_name;
        }
        $of_pages_tmp = array_unshift($of_pages, "Select a page:");


        // read background images
        $bg_images_path = get_stylesheet_directory() . '/images/bg/';
        $bg_images_url = get_template_directory_uri() . '/images/bg/';
        $bg_images = array();

        if (is_dir($bg_images_path)) {
            if ($bg_images_dir = opendir($bg_images_path)) {
                while (($bg_images_file = readdir($bg_images_dir)) !== false) {
                    if (stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                        $bg_images[] = $bg_images_url . $bg_images_file;
                    }
                }
            }
        }




        //More Options
        $uploads_arr = wp_upload_dir();

        // Image Alignment radio box
        $of_options_thumb_align = array("alignleft" => "Left", "alignright" => "Right", "aligncenter" => "Center");

        // Image Links to Options
        $of_options_image_link_to = array("image" => "The Image", "post" => "The Post");


        /*-----------------------------------------------------------------------------------*/
        /* The Options Array */
        /*-----------------------------------------------------------------------------------*/

        // Set the Options Array
        global $of_options;
        $of_options = array();

        /* Social Media */
        /*-----------------------------------------------------------------------------------*/
        $of_options[] = array("name" => "Social Media",
            "type" => "heading");

        $of_options[] = array("name" => __("RSS Feed", "highthemes"),
            "desc" => __("Enter your rss feed url here", "highthemes"),
            "id" => "rss_id",
            "std" => get_bloginfo_rss('rss2_url'),
            "type" => "text");
        $of_options[] = array("name" => __("Twitter ID", "highthemes"),
            "desc" => __("Enter your twitter id here, e.g. thehighthemes", "highthemes"),
            "id" => "twitter_id",
            "std" => "",
            "type" => "text");
        $of_options[] = array("name" => __("Facebook Profile", "highthemes"),
            "desc" => __("Enter your facebook profile url here", "highthemes"),
            "id" => "facebook_id",
            "std" => "",
            "type" => "text");
        $of_options[] = array("name" => __("Google Plus Profile", "highthemes"),
            "desc" => __("Enter your gplus profile url here", "highthemes"),
            "id" => "gplus_id",
            "std" => "",
            "type" => "text");
        $of_options[] = array("name" => __("Flickr Profile", "highthemes"),
            "desc" => __("Enter your flickr profile url here", "highthemes"),
            "id" => "flickr_id",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => __("LinkedIn Profile", "highthemes"),
            "desc" => __("Enter your linkedin profile url here", "highthemes"),
            "id" => "linkedin_id",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => __("Vimeo Profile", "highthemes"),
            "desc" => __("Enter your Vimeo profile url here", "highthemes"),
            "id" => "vimeo_id",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => __("Behance Profile", "highthemes"),
            "desc" => __("Enter your Behance profile url here", "highthemes"),
            "id" => "behance_id",
            "std" => "",
            "type" => "text");


        $of_options[] = array("name" => __("Picasa Profile", "highthemes"),
            "desc" => __("Enter your Picasa profile url here", "highthemes"),
            "id" => "picasa_id",
            "std" => "",
            "type" => "text");


        $of_options[] = array("name" => __("Dribble Profile", "highthemes"),
            "desc" => __("Enter your Dribble profile url here", "highthemes"),
            "id" => "dribble_id",
            "std" => "",
            "type" => "text");



        $of_options[] = array("name" => __("Digg Profile", "highthemes"),
            "desc" => __("Enter your Digg profile url here", "highthemes"),
            "id" => "digg_id",
            "std" => "",
            "type" => "text");



        $of_options[] = array("name" => __("Blogger Profile", "highthemes"),
            "desc" => __("Enter your Blogger profile url here", "highthemes"),
            "id" => "blogger_id",
            "std" => "",
            "type" => "text");


        $of_options[] = array("name" => __("Delicious Profile", "highthemes"),
            "desc" => __("Enter your Delicious profile url here", "highthemes"),
            "id" => "delicious_id",
            "std" => "",
            "type" => "text");


        $of_options[] = array("name" => __("Tumblr Profile", "highthemes"),
            "desc" => __("Enter your Tumblr profile url here", "highthemes"),
            "id" => "tumblr_id",
            "std" => "",
            "type" => "text");


        $of_options[] = array("name" => __("Yahoo Profile", "highthemes"),
            "desc" => __("Enter your Yahoo profile url here", "highthemes"),
            "id" => "yahoo_id",
            "std" => "",
            "type" => "text");

        /* General Settings */
        /*-----------------------------------------------------------------------------------*/
        $of_options[] = array("name" => __("General Settings", "highthemes"),
            "type" => "heading");

        $url = ADMIN_DIR . 'assets/images/';

        $of_options[] = array("name" => __("Main Sidebar Layout", "highthemes"),
            "desc" => __("Select main content and sidebar alignment. Choose between left, right or full-width layout.", "highthemes"),
            "id" => "sidebar_layout",
            "std" => "has-rightsidebar",
            "type" => "images",
            "options" => array(
                'no-sidebar' => $url . '1col.png',
                'has-rightsidebar' => $url . '2cr.png',
                'has-leftsidebar' => $url . '2cl.png')
        );

        $of_options[] = array( "name" => __("Fixed or Responsive?", "highthemes"),
            "desc" => __("By default the theme adapts to the screen size of the visitor and uses a layout best suited.
                        You can disable this behavior so the theme will only show the default layout without adaptation", "highthemes"),
            "id" => "responsive_layout",
            "std" => "responsive",
            "type" => "select",
            "options" => array("fixed"=>"Fixed Layout", "responsive"=>"Responsive Layout"));


        $of_options[] = array("name" => __("404 Error Custom Message", "highthemes"),
            "desc" => __("You can write your own 404 error message here..", "highthemes"),
            "id" => "custom_404",
            "std" => "The page you are looking for isn't here. Try searching again.",
            "type" => "textarea");

        $of_options[] = array("name" => __("Upload Logo", "highthemes"),
            "desc" => __("Upload your logo here, or define the URL directly", "highthemes"),
            "id" => "logo_url",
            "std" => "",
            "type" => "media");

        $of_options[] = array("name" => __("Breadcrumb", "highthemes"),
            "desc" => __("Enable or disable breadcrumb navigation in all pages.", "highthemes"),
            "id" => "breadcrumb_inner",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Social Bookmarks", "highthemes"),
            "desc" => __("Enable or disable social bookmarks in all pages.", "highthemes"),
            "id" => "sb_inner",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Related Posts for Portfolio items", "highthemes"),
            "desc" => __("Check this box to disable related items for portfolio items.", "highthemes"),
            "id" => "disable_related_folio",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Custom Favicon", "highthemes"),
            "desc" => __("Upload a 16px x 16px Png/Gif image that will represent your website's favicon.", "highthemes"),
            "id" => "custom_favicon",
            "std" => "",
            "type" => "upload");
        $of_options[] = array("name" => __("Tracking Code", "highthemes"),
            "desc" => __("Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.", "highthemes"),
            "id" => "google_analytics",
            "std" => "",
            "type" => "textarea");

        $of_options[] = array("name" => __("Page Navi Pagination?", "highthemes"),
            "desc" => __("By default, the theme uses wp-pagenavi, uncheck this box if you don't want it. ", "highthemes"),
            "id" => "pagenavi_status",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Footer?", "highthemes"),
            "desc" => __("Check this box if you like to disable footer blocks", "highthemes"),
            "id" => "footer_disable",
            "std" => 0,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Footer Text", "highthemes"),
            "desc" => __("Enter a copyright or something else at the very bottom of the pages.", "highthemes"),
            "id" => "footer_text",
            "std" => "Powered by HighThemes. All rights reserved.",
            "type" => "textarea");

        $of_options[] = array("name" => __("Your email address for contact page", "highthemes"),
            "desc" => __("Enter your email address. used for sending emails from contact page.", "highthemes"),
            "id" => "contact_email_address",
            "std" => "",
            "type" => "text");

        $of_options[] = array("name" => __("Captcha for contact form?", "highthemes"),
            "desc" => __("Check this box if you like to disable contact page captcha", "highthemes"),
            "id" => "disable_captcha",
            "std" => 0,
            "type" => "checkbox");

        /* Slideshow */
        /*-----------------------------------------------------------------------------------*/
        $of_options[] = array("name" => __("Slideshow Settings", "highthemes"),
            "type" => "heading");

        $of_options[] = array("name" => __("Slideshow", "highthemes"),
            "desc" => __("Uncheck this box to disable the slideshow for all pages.", "highthemes"),
            "id" => "slideshow_status",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Slideshow Caption", "highthemes"),
            "desc" => __("Enable / Disable slideshow caption here.", "highthemes"),
            "id" => "slideshow_caption",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Slideshow Thumbnails", "highthemes"),
            "desc" => __("When you check this box, an icon will be shown on the footer of homepage. When a user clicks on it, slideshow thumbnail images will display. You can disable/enable it here.", "highthemes"),
            "id" => "slideshow_thumbs",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Slideshow Play/Pause Buttons", "highthemes"),
            "desc" => __("Enable / Disable slideshow Buttons Here.", "highthemes"),
            "id" => "slideshow_button_status",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Slideshow Progress Bar", "highthemes"),
            "desc" => __("Enable / Disable slideshow progres bar here.", "highthemes"),
            "id" => "slideshow_progress_status",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Randomize Slideshow Rotating Order", "highthemes"),
            "desc" => __("If you like to use a random order for slideshow items, check this box.", "highthemes"),
            "id" => "slideshow_ranomize",
            "std" => 1,
            "type" => "checkbox");

        $of_options[] = array("name" => __("Choose Transition Effect", "highthemes"),
            "desc" => __("Choose a transition effect.", "highthemes"),
            "id" => "slideshow_transition_effect",
            "std" => '1',
            "type" => "select",
            "options" =>array("1"=>"Fade", "2"=>"Slide Top", "3" =>" Slide Right", "4" =>"Slide Bottom", "5" =>"Slide Left", "6" =>"Carousel Right", "7" =>"Carousel Left", "0" =>"None")
        );

        $of_options[] = array("name" => __("Number of seconds", "highthemes"),
            "desc" => __("Seconds between each transition? ", "highthemes"),
            "id" => "slideshow_timeout",
            "std" => "10",
            "type" => "text");




        /* Blog Options */
        /*-----------------------------------------------------------------------------------*/
        $of_options[] = array("name" => __("Blog Settings", "highthemes"),
            "type" => "heading");


        $of_options[] = array( "name" => __("Exclude Categories", "highthemes"),
            "desc" => __("Excluded categories from the main blog.", "highthemes"),
            "id" => "excluded_categories",
            "std" =>"",
            "type" => "multicheck",
            "options" => $of_categories);

        $of_options[] = array("name" => __("Post Images Height", "highthemes"),
            "desc" => __("You can change the default height of post featured images here. ", "highthemes"),
            "id" => "post_image_height",
            "std" => "280",
            "type" => "text");

        $of_options[] = array("name" => __("Disable Featured images at top of posts", "highthemes"),
            "desc" => __("check this box to disable featured images at top of posts. You can always override this option on each post by post options.", "highthemes"),
            "id" => "disable_post_image",
            "std" => 0,
            "type" => "checkbox");



        /* Style Options */
        /*-----------------------------------------------------------------------------------*/

        $of_options[] = array( "name" => __("Styling Options", "highthemes"),
            "type" => "heading");

        $of_options[] = array( "name" => __("Body Font", "highthemes"),
            "desc" => __("Specify the body font properties", "highthemes"),
            "id" => "body_font",
            "std" => array('size' => '12px','face' => 'google_Droid Sans','color' => '#333333'),
            "type" => "typography2");

        $of_options[] = array( "name" => __("Headings Font", "highthemes"),
            "desc" => __("Specify the Headings font properties", "highthemes"),
            "id" => "heading_font",
            "std" => array('face' => 'google_Oswald','color' => '#444'),
            "type" => "typography1");

        $of_options[] = array( "name" => __("Sidebar Heading Font", "highthemes"),
            "desc" => __("Specify the Sidebar Heading font properties", "highthemes"),
            "id" => "sidebar_font",
            "std" => array('face' => 'google_Oswald','size' => '14px', 'style'=>'normal'),
            "type" => "typography3");

        $of_options[] = array( "name" => __("Sidebar Heading Font Color", "highthemes"),
            "desc" => __("Pick a color for the sidebar headings.", "highthemes"),
            "id" => "sidebar_font_color",
            "std" => '#ffffff',
            "type" => "color");


        $of_options[] = array( "name" => __("Navigation Font", "highthemes"),
            "desc" => __("Specify the Navigation font properties", "highthemes"),
            "id" => "navigation_font",
            "std" => array('face' => 'google_Oswald','size' => '17px', 'style'=>'300'),
            "type" => "typography3");

        $of_options[] = array( "name" => __("Navigation Font Color", "highthemes"),
            "desc" => __("Pick a color for the navigation font.", "highthemes"),
            "id" => "navigation_font_color",
            "std" => '#ffffff',
            "type" => "color");

        $of_options[] = array( "name" => __("Navigation Separator Line Color", "highthemes"),
            "desc" => __("Pick a color for the navigation separator line.", "highthemes"),
            "id" => "navigation_line_color",
            "std" => '#777777',
            "type" => "color");

        $of_options[] = array( "name" => __("Navigation Sub-Title Font Color", "highthemes"),
            "desc" => __("Pick a color for the navigation sub-title font.", "highthemes"),
            "id" => "navigation_desc_color",
            "std" => '#adadad',
            "type" => "color");

        $of_options[] = array( "name" => __("Page Title Color", "highthemes"),
            "desc" => __("You may would like to change the page title color, here you can do it.", "highthemes"),
            "id" => "page_heading_color",
            "std" => '#444444',
            "type" => "color");

        $of_options[] = array( "name" =>  __("Link Color", "highthemes"),
            "desc" => __("Pick a color for the links.", "highthemes"),
            "id" => "link_color",
            "std" => "#a10000",
            "type" => "color");

        $of_options[] = array( "name" =>  __("Link Hover Color", "highthemes"),
            "desc" => __("Choose the color you'd like applied to links when they are hovered over.", "highthemes"),
            "id" => "link_hover_color",
            "std" => "#e66000",
            "type" => "color");


        $of_options[] = array( "name" => __("Custom CSS", "highthemes"),
            "desc" => __("Quickly add some CSS to your theme by adding it to this block.", "highthemes"),
            "id" => "custom_css",
            "std" => "",
            "type" => "textarea");



        /* Background Patterns & Colors */
        /*-----------------------------------------------------------------------------------*/

        $of_options[] = array( "name" => __("Backgrounds", "highthemes"),
            "type" => "heading");

        $of_options[] = array( "name" =>  __("Body Background Color", "highthemes"),
            "desc" => __("Pick a background color for the theme.", "highthemes"),
            "id" => "body_background",
            "std" => "#545454",
            "type" => "color");

        $of_options[] = array( "name" =>  __("Main Background Color", "highthemes"),
            "desc" => __("Pick a background color for Menu, Caption, Sidebar , etc.", "highthemes"),
            "id" => "main_background_color",
            "std" => "#000000",
            "type" => "color");

        $of_options[] = array( "name" => __("Background Pattern (boxed layout)", "highthemes"),
            "desc" => __("If you choose boxed layout for the theme, you can select a background image from the list below.", "highthemes"),
            "id" => "custom_bg",
            "std" => $bg_images_url."01.png",
            "type" => "tiles",
            "options" => $bg_images,
        );

// Backup Options
        $of_options[] = array("name" => __("Backup Options", "highthemes"),
            "type" => "heading");

        $of_options[] = array("name" => __("Backup and Restore Options", "highthemes"),
            "id" => "of_backup",
            "std" => "",
            "type" => "backup",
            "desc" => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', "highthemes"),
        );

        $of_options[] = array("name" => __("Transfer Theme Options Data", "highthemes"),
            "id" => "of_transfer",
            "std" => "",
            "type" => "transfer",
            "desc" => __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options"', "highthemes"),
        );

    }
}
?>
