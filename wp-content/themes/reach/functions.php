<?php

/*

HighThemes.com
Twitter: theHighThemes

*/

/*
 * change the default.po file with poedit to create .mo file
 * The .mo file must be named based on the locale exactly.
 */
load_theme_textdomain('highthemes');

/*
 * include the framework
 */
require_once ('admin/index.php');

/*

 * redirect the user to admin page
*/
if (isset($_GET['activated']) && $_GET['activated']){
    wp_redirect(admin_url("admin.php?page=optionsframework"));
}
?>