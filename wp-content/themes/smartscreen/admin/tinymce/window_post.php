<?php

// Bootstrap file for getting the ABSPATH constant to wp-load.php
require_once('config.php');

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
    wp_die(__("You are not allowed to be here",'highthemes'));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $theme_name .' Shortcodes'; ?></title>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
    <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/admin/tinymce/tinymce.js"></script>
    <base target="_self" />
</head>


<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
<form name="ht_shortcodes" action="#">
<div class="tabs">
    <ul>
        <li id="shortcodes_tab" class="current"><span><a href="javascript:mcTabs.displayTab('shortcodes_tab','shortcodes_panel');" onMouseDown="return false;">General Styles</a></span></li>
        <li id="button_tab"><span><a href="javascript:mcTabs.displayTab('button_tab','button_panel');" onMouseDown="return false;">Buttons </a></span></li>
        <li id="list_tab"><span><a href="javascript:mcTabs.displayTab('list_tab','list_panel');" onMouseDown="return false;">Lists</a></span></li>

        <li id="box_tab"><span><a href="javascript:mcTabs.displayTab('box_tab','box_panel');" onMouseDown="return false;">Info Boxes</a></span></li>
        <li id="sbox_tab"><span><a href="javascript:mcTabs.displayTab('sbox_tab','sbox_panel');" onMouseDown="return false;">Simple Boxes</a></span></li>
        <li id="tbox_tab"><span><a href="javascript:mcTabs.displayTab('tbox_tab','tbox_panel');" onMouseDown="return false;">Titled Boxes</a></span></li>
        <li id="link_tab"><span><a href="javascript:mcTabs.displayTab('link_tab','link_panel');" onMouseDown="return false;">Links</a></span></li>
    </ul>
</div>
<div class="panel_wrapper" style="height:200px;">
<!-- shortcodes_panel -->
<div id="shortcodes_panel" class="panel current">
    <br />
    <fieldset>
        <legend><?php _e('Select the Style Shortcode you would like to insert into the post.','highthemes'); ?></legend>
        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td nowrap="nowrap"><label for="style_shortcode"><?php _e('Select Custom Shortcode:','highthemes'	); ?></label></td>
                <td>
                    <select id="style_shortcode" name="style_shortcode" style="width: 200px">
                        <option value="0"><?php _e('No Style','highthemes'); ?></option>

                        <optgroup label="<?php _e('Misc','highthemes'); ?>">
                            <option value="googlemap"><?php _e('Googel Map','highthemes'); ?></option>
                            <option value="progress"><?php _e('Progress Bar','highthemes'); ?></option>
                            <option value="socialized"><?php _e('Social Icons','highthemes'); ?></option>
                            <option value="slideshow"><?php _e('Slideshow','highthemes'); ?></option>
                            <option value="testimonial"><?php _e('Testimonial','highthemes'); ?></option>
                            <option value="tooltip"><?php _e('Tooltip','highthemes'); ?></option>
                            <option value="cta_box"><?php _e('Call To Action Box','highthemes'); ?></option>
                            <option value="video"><?php _e('Video','highthemes'); ?></option>
                            <option value="code_sc"><?php _e('Code','highthemes'); ?></option>
                            <option value="pre"><?php _e('Pre','highthemes'); ?></option>
                        </optgroup>

                        <optgroup label="<?php _e('Pricing Table','highthemes'); ?>">
                            <option value="pricing_3col"><?php _e('3 Column','highthemes'); ?></option>
                            <option value="pricing_4col"><?php _e('4 Column','highthemes'); ?></option>
                            <option value="pricing_5col"><?php _e('5 Column','highthemes'); ?></option>
                        </optgroup>

                        <optgroup label="<?php _e('DropCap','highthemes'); ?>">
                            <option value="dropcap1"><?php _e('Drop Cap1','highthemes'); ?></option>
                            <option value="dropcap2"><?php _e('Drop Cap2','highthemes'); ?></option>
                            <option value="dropcap3"><?php _e('Drop Cap3','highthemes'); ?></option>

                        </optgroup>
                        <optgroup label="<?php _e('Divider','highthemes'); ?>">
                            <option value="hr_top"><?php _e('Divider Top','highthemes'); ?></option>
                            <option value="hr"><?php _e('Divider','highthemes'); ?></option>
                            <option value="hr_2dot"><?php _e('Divider 2Dot','highthemes'); ?></option>
                            <option value="hr_3dot"><?php _e('Divider 3Dot','highthemes'); ?></option>

                        </optgroup>
                        <optgroup label="<?php _e('Callout / Pullquote','highthemes'); ?>">
                            <option value="callout_left"><?php _e('Left Aligned','highthemes'); ?></option>
                            <option value="callout_right"><?php _e('Right Aligned','highthemes'); ?></option>
                            <option value="pullquote"><?php _e('Pullquote','highthemes'); ?></option>
                        </optgroup>

                        <optgroup label="<?php _e('Highlights','highthemes'); ?>">
                            <option value="h_yellow"><?php _e('Yello','highthemes'); ?></option>
                            <option value="h_black"><?php _e('Black','highthemes'); ?></option>
                            <option value="h_red"><?php _e('Red','highthemes'); ?></option>
                        </optgroup>

                        <optgroup label="<?php _e('Image alignment/lightbox','highthemes'); ?>">
                            <option value="lightbox"><?php _e('Image With Lightbox Effect','highthemes'); ?></option>
                            <option value="image_left"><?php _e('Left Aligned','highthemes'); ?></option>
                            <option value="image_right"><?php _e('Right Aligned','highthemes'); ?></option>
                            <option value="image_center"><?php _e('Centered','highthemes'); ?></option>
                        </optgroup>

                        <optgroup label="<?php _e('Tabs, Accordings, Toggle','highthemes'); ?>">
                            <option value="tabs"><?php _e('Tabs','highthemes'); ?></option>
                            <option value="accordions"><?php _e('Accordion','highthemes'); ?></option>

                            <option value="toggle"><?php _e('Toggle','highthemes'); ?></option>
                        </optgroup>
                    </select>
                </td>
            </tr>
        </table>
    </fieldset>
</div>

<!--/ shortcodes_panel -->

<!-- button_panel -->
<div id="button_panel" class="panel">
    <br />
    <fieldset>
        <legend><?php _e('Generate Buttons','highthemes'); ?></legend>
        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td nowrap="nowrap"><label for="button_title"><?php _e('Title: ','highthemes'); ?></label></td>
                <td><input type="text" id="button_title" name="button_title" size="44" /><br /></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><label for="button_link"><?php _e('Link: ','highthemes'); ?></label></td>
                <td><input type="text" id="button_link" name="button_link" size="44" /><br /></td>
            </tr>



            <tr>
                <td nowrap="nowrap"><label for="button_color"><?php _e('Background Color','highthemes'); ?></label></td>
                <td><select id="button_color" name="button_color" style="width: 100px">
                    <option value="red"><?php _e('Red','highthemes'); ?></option>
                    <option value="magenta"><?php _e('Magenta','highthemes'); ?></option>
                    <option value="pink"><?php _e('Pink','highthemes'); ?></option>
                    <option value="orange"><?php _e('Orange','highthemes'); ?></option>
                    <option value="green"><?php _e('Green','highthemes'); ?></option>
                    <option value="blue"><?php _e('Blue','highthemes'); ?></option>
                    <option value="grey"><?php _e('Grey','highthemes'); ?></option>
                    <option value="black"><?php _e('Black','highthemes'); ?></option>
                    <option value="purple"><?php _e('Purple','highthemes'); ?></option>
                </select><br /></td>
            </tr>

            <tr>
                <td nowrap="nowrap"><label for="button_size"><?php _e('Button Size: ','highthemes'); ?></label></td>
                <td><select id="button_size" name="button_size" style="width: 100px">
                    <option value="small"><?php _e('Small','highthemes'); ?></option>
                    <option value="medium"><?php _e('Medium','highthemes'); ?></option>
                    <option value="large"><?php _e('Large','highthemes'); ?></option>
                </select><br /></td>
            </tr>

            <tr>
                <td nowrap="nowrap"><label for="button_type"><?php _e('Button Type: ','highthemes'); ?></label></td>
                <td><select id="button_type" name="button_size" style="width: 100px">
                    <option value="simple"><?php _e('Simple','highthemes'); ?></option>
                    <option value="glossy"><?php _e('Glossy','highthemes'); ?></option>
                </select><br /></td>
            </tr>

        </table>
    </fieldset>
</div>
<!-- button_panel -->

<!-- list_panel -->
<div id="list_panel" class="panel">
    <br />
    <fieldset>
        <legend><?php _e('List Icons','highthemes'); ?></legend>
        <table border="0" cellpadding="4" cellspacing="0">

            <tr>
                <td nowrap="nowrap"><label for="list_type"><?php _e('List Type','highthemes'); ?></label></td>
                <td><select id="list_type" name="list_type" style="width: 100px">
                    <option value="dottedlist"><?php _e('Dotted','highthemes'); ?></option>
                    <option value="dashedlist"><?php _e('Dashed','highthemes'); ?></option>
                    <option value="linelist"><?php _e('Line','highthemes'); ?></option>
                    <option value="checklist"><?php _e('Check','highthemes'); ?></option>
                    <option value="bulletlist"><?php _e('Circle Bullet','highthemes'); ?></option>
                    <option value="arrowlist"><?php _e('Arrow','highthemes'); ?></option>
                </select><br /></td>
            </tr>

        </table>
    </fieldset>
</div>
<!-- list_panel -->

<!-- box_panel -->
<div id="box_panel" class="panel">
    <br />
    <fieldset>
        <legend><?php _e('Info Boxes','highthemes'); ?></legend>
        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td nowrap="nowrap"><label for="info_title"><?php _e('Title: ','highthemes'); ?></label></td>
                <td><input type="text" id="info_title" name="info_title" size="44" /><br /></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><label for="info_type"><?php _e('Box Type: ','highthemes'); ?></label></td>
                <td><select id="info_type" name="info_type" style="width: 100px">
                    <option value="titled"><?php _e('Title Only','highthemes'); ?></option>
                    <option value="description"><?php _e('With Description','highthemes'); ?></option>
                </select><br /></td>
            </tr>

            <tr>
                <td nowrap="nowrap"><label for="info_color"><?php _e('Box Color: ','highthemes'); ?></label></td>
                <td><select id="info_color" name="info_color" style="width: 100px">
                    <option value="green"><?php _e('Green','highthemes'); ?></option>
                    <option value="red"><?php _e('Red','highthemes'); ?></option>
                    <option value="blue"><?php _e('Blue','highthemes'); ?></option>
                    <option value="silver"><?php _e('Silver','highthemes'); ?></option>
                    <option value="orange"><?php _e('Orange','highthemes'); ?></option>

                </select><br /></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><label for="info_icon"><?php _e('Box Icon: ','highthemes'); ?></label></td>
                <td><select id="info_icon" name="info_icon" style="width: 100px">
                    <option value="noicon"><?php _e('NO ICON','highthemes'); ?></option>
                    <option value="note"><?php _e('Note','highthemes'); ?></option>
                    <option value="rss"><?php _e('RSS','highthemes'); ?></option>
                    <option value="heart"><?php _e('Heart','highthemes'); ?></option>
                    <option value="info"><?php _e('Info','highthemes'); ?></option>
                    <option value="close"><?php _e('Close','highthemes'); ?></option>
                    <option value="download"><?php _e('Download','highthemes'); ?></option>
                    <option value="warning"><?php _e('Warning','highthemes'); ?></option>
                    <option value="twitter"><?php _e('Twitter','highthemes'); ?></option>
                    <option value="star"><?php _e('Star','highthemes'); ?></option>
                    <option value="error"><?php _e('Error','highthemes'); ?></option>

                </select><br /></td>
            </tr>



        </table>
    </fieldset>
</div>
<!-- box_panel -->


<!-- simple_box -->
<div id="sbox_panel" class="panel">
    <br />
    <fieldset>
        <legend><?php _e('Simple Boxes','highthemes'); ?></legend>
        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td nowrap="nowrap"><label for="sbox_border"><?php _e('Border Size (px): ','highthemes'); ?></label></td>
                <td><input type="text" id="sbox_border" name="sbox_border" size="44" /><br /></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><label for="sbox_border_color"><?php _e('Border Color','highthemes'); ?></label></td>
                <td><select id="sbox_border_color" name="sbox_border_color" style="width: 100px">
                    <option value="#da2e2e"><?php _e('Red','highthemes'); ?></option>
                    <option value="#980143"><?php _e('Magenta','highthemes'); ?></option>
                    <option value="#d6288e"><?php _e('Pink','highthemes'); ?></option>
                    <option value="#f15f0c"><?php _e('Orange','highthemes'); ?></option>
                    <option value="#8eb614"><?php _e('Green','highthemes'); ?></option>
                    <option value="#0ba6e1"><?php _e('Blue','highthemes'); ?></option>
                    <option value="#686868"><?php _e('Grey','highthemes'); ?></option>
                    <option value="#000"><?php _e('Black','highthemes'); ?></option>
                    <option value="#8a5092"><?php _e('Purple','highthemes'); ?></option>
                </select><br /></td>
            </tr>


        </table>
    </fieldset>
</div>
<!-- simple_box -->

<!-- tbox_panel -->
<div id="tbox_panel" class="panel">
    <br />
    <fieldset>
        <legend><?php _e('Titled Boxes','highthemes'); ?></legend>
        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td nowrap="nowrap"><label for="tbox_title"><?php _e('Title : ','highthemes'); ?></label></td>
                <td><input type="text" id="tbox_title" name="tbox_title" size="44" /><br /></td>
            </tr>

            <tr>
                <td nowrap="nowrap"><label for="tbox_color"><?php _e('Background Color','highthemes'); ?></label></td>
                <td><select id="tbox_color" name="tbox_color" style="width: 100px">
                    <option value="red"><?php _e('Red','highthemes'); ?></option>
                    <option value="magenta"><?php _e('Magenta','highthemes'); ?></option>
                    <option value="pink"><?php _e('Pink','highthemes'); ?></option>
                    <option value="orange"><?php _e('Orange','highthemes'); ?></option>
                    <option value="green"><?php _e('Green','highthemes'); ?></option>
                    <option value="blue"><?php _e('Blue','highthemes'); ?></option>
                    <option value="grey"><?php _e('Grey','highthemes'); ?></option>
                    <option value="black"><?php _e('Black','highthemes'); ?></option>
                    <option value="purple"><?php _e('Purple','highthemes'); ?></option>
                </select><br /></td>
            </tr>


        </table>
    </fieldset>
</div>
<!-- tbox_panel -->

<!-- link_panel -->
<div id="link_panel" class="panel">
    <br />
    <fieldset>
        <legend><?php _e('Links with icons','highthemes'); ?></legend>
        <table border="0" cellpadding="4" cellspacing="0">
            <tr>
                <td nowrap="nowrap"><label for="link_title"><?php _e('Title: ','highthemes'); ?></label></td>
                <td><input type="text" id="link_title" name="link_title" size="44" /><br /></td>
            </tr>
            <tr>
                <td nowrap="nowrap"><label for="link_url"><?php _e('URL: ','highthemes'); ?></label></td>
                <td><input type="text" id="link_url" name="link_url" size="44" /><br /></td>
            </tr>


            <tr>
                <td nowrap="nowrap"><label for="link_icon"><?php _e('Background Color','highthemes'); ?></label></td>
                <td><select id="link_icon" name="link_icon" style="width: 100px">
                    <option value="email-icon"><?php _e('Email','highthemes'); ?></option>
                    <option value="print-icon"><?php _e('Print','highthemes'); ?></option>
                    <option value="add-icon"><?php _e('Add','highthemes'); ?></option>
                    <option value="star-icon"><?php _e('Start','highthemes'); ?></option>
                    <option value="heart-icon"><?php _e('Heart','highthemes'); ?></option>
                    <option value="twitter-icon"><?php _e('Twitter','highthemes'); ?></option>
                    <option value="download-icon"><?php _e('Download','highthemes'); ?></option>
                    <option value="phone-icon"><?php _e('Phone','highthemes'); ?></option>
                    <option value="link-icon"><?php _e('Link','highthemes'); ?></option>
                    <option value="exlink-icon"><?php _e('External Link','highthemes'); ?></option>
                </select><br /></td>
            </tr>


        </table>
    </fieldset>
</div>
<!-- link_panel -->

</div>

<div class="mceActionPanel">
    <div style="float: left">
        <input type="button" id="cancel" name="cancel" value="<?php _e("Cancel",'highthemes'); ?>" onClick="tinyMCEPopup.close();" />
    </div>

    <div style="float: right">
        <input type="submit" id="insert" name="insert" value="<?php echo _e("Insert",'highthemes'); ?>" onClick="InsertShortcodes();" />
    </div>
</div>
</form>
</body>
</html>
