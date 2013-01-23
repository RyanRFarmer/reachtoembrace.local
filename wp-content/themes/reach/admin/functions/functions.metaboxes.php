<?php
/**
 *
 * HighThemes Options Framework
 * twitter : http://twitter.com/theHighthemes
 *
 */

/**
 * Page, Post, Portfolio, and Slideshow Metaboxes
 */


/* Pages */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('add_ht_page_options_cb') ) {
    function add_ht_page_options_cb() {
        add_meta_box(
            'ht_page_options_cb',
            'HighThemes Page Options',
            'show_ht_page_options_cb',
            'page',
            'normal',
            'high');
    }

}

add_action('add_meta_boxes', 'add_ht_page_options_cb');


// prefix of options
$prefix = '_';

// getting categories list
$categories = array();
$categories_obj = get_categories('hide_empty=0');
foreach ($categories_obj as $highcat) {
    $categories[$highcat->cat_ID]['label'] = $highcat->cat_name;
    $categories[$highcat->cat_ID]['value'] = $highcat->cat_ID;
}

// slideshow tax
$sterms = array();
$sterms = ht_create_terms_list('slideshow-category');
$sterms_array = array(
    'all' => array (
        'label' => __('All Items', 'highthemes'),
        'value' => ''
    ));
if($sterms){
    foreach($sterms as $sterm){
        $sterms_array[$sterm['slug']]['label']  = $sterm['name'];
        $sterms_array[$sterm['slug']]['value']  =$sterm['slug'];
    }
}


// portfolio tax

    $terms = ht_create_terms_list('portfolio-category');
    if($terms){
        $terms_array = array();
        foreach($terms as $term){
            $terms_array[$term['slug']]['label']  = $term['name'];
            $terms_array[$term['slug']]['value']  =$term['slug'];
        }
    }

$custom_meta_fields = array(
    array(
        'label'=> __('Override Page Title', 'highthemes'),
        'desc'  => __('By default, the page name will display as the title, you can override it here.', 'highthemes'),
        'id'    => $prefix.'override_title',
        'type'  => 'textarea'
    ),
    array(
        'label' =>__('Disable Sidebar?', 'highthemes'),
        'desc'  =>__('Check this box to disable sidebar.', 'highthemes'),
        'id'    =>$prefix.'disable_sidebar',
        'type'  =>'checkbox'
    ),
    array(
        'label'=> __('Slideshow Status', 'highthemes'),
        'desc'  => __('You can override the slideshow status for this page/post.', 'highthemes'),
        'id'    => $prefix.'slideshow_status',
        'type'  => 'select',
        'options' => array (
            'default' => array (
                'label' => __('Default Settings', 'highthemes'),
                'value' => ''
            ),
            'enable' => array (
                'label' => __('Enable Slideshow', 'highthemes'),
                'value' => 1
            ),
            'disable' => array (
                'label' => __('Disable Slideshow', 'highthemes'),
                'value' => 'false'
            )
        )
    ),

    array (
        'label' => __('Slideshow Category', 'highthemes'),
        'desc'  => __('Check the categories you wish to show items from', 'highthemes'),
        'id'    => $prefix.'slideshow_category',
        'type'  => 'select',
        'options' => $sterms_array
    ),
    array(
        'label'=> __('Page Type', 'highthemes'),
        'desc'  => __('Select the type of the page, if you want to create special pages like portfolio, contact, etc.', 'highthemes'),
        'id'    => $prefix.'page_type',
        'type'  => 'select',
        'options' => array (
            'page' => array (
                'label' => __('Page', 'highthemes'),
                'value' => 'page'
            ),
            'contact' => array (
                'label' => __('Contact Page', 'highthemes'),
                'value' => 'contact'
            ),
            'subblog' => array (
                'label' => __('Sub-Blog', 'highthemes'),
                'value' => 'subblog'
            ),
            'portfolio' => array (
                'label' => __('Classic Portfolio', 'highthemes'),
                'value' => 'portfolio'
            ),
            'portfolio-filterable' => array (
                'label' => __('Filterable Portfolio', 'highthemes'),
                'value' => 'portfolio-filterable'
            )
        )
    ),
    array(
        'label'=> __('Items per Page', 'highthemes'),
        'desc'  => __('Enter the number of items you like to display per page', 'highthemes'),
        'id'    => $prefix.'item_number',
        'type'  => 'text'
    ),

    array (
        'label' => __('Sub-Blog Category', 'highthemes'),
        'desc'  => __('Check the categories you wish to show items from in the sub blog', 'highthemes'),
        'id'    => $prefix.'subblog_category',
        'type'  => 'checkbox_group',
        'options' => $categories
    )  ,

    array (
        'label' => __('Portfolio Category', 'highthemes'),
        'desc'  => __('Check the categories you wish to show items from', 'highthemes'),
        'id'    => $prefix.'portfolio_category',
        'type'  => 'checkbox_group',
        'options' => $terms_array
    )  ,

    array(
        'label'=> __('Portfolio Layouts', 'highthemes'),
        'desc'  => __('Select your desired layout for portfolio page.', 'highthemes'),
        'id'    => $prefix.'portfolio_layout',
        'type'  => 'select',
        'options' => array (
            '1c' => array (
                'label' => __('1 Column', 'highthemes'),
                'value' => '1c'
            ),
            '2c' => array (
                'label' => __('2 Columns', 'highthemes'),
                'value' => '2c'
            ),
            '3c' => array (
                'label' => __('3 Columns', 'highthemes'),
                'value' => '3c'
            ),
            '4c' => array (
                'label' => __('4 Columns', 'highthemes'),
                'value' => '4c'
            )
        )
    )


);
if ( ! function_exists('show_ht_page_options_cb') ) {
    function show_ht_page_options_cb() {
        global $custom_meta_fields, $post;
        echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

        echo '<table class="form-table">';
        foreach ($custom_meta_fields as $field) {
            $meta = get_post_meta($post->ID, $field['id'], true);

            echo '<tr>
                    <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                    <td>';
            switch($field['type']) {
                // text
                case 'text':
                    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // textarea
                case 'textarea':
                    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // checkbox
                case 'checkbox':
                    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                    break;
                // checkbox_group
                case 'checkbox_group':
                    foreach ($field['options'] as $option) {
                        echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
                    }
                    echo '<span class="description">'.$field['desc'].'</span>';
                    break;
                // select
                case 'select':
                    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                    }
                    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                    break;



            }
            echo '</td></tr>';
        }
        echo '</table>';
    }

}

// Save the Data
if ( ! function_exists('save_custom_meta') ) {
    function save_custom_meta($post_id) {
        global $custom_meta_fields;
        if(isset($_POST['custom_meta_box_nonce'])){

            if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
                return $post_id;
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            foreach ($custom_meta_fields as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                $new = $_POST[$field['id']];
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }

        }
    }

}

add_action('save_post', 'save_custom_meta');



/* Posts */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('add_ht_post_options_cb') ) {
    function add_ht_post_options_cb() {
        add_meta_box(
            'ht_post_options_cb',
            'HighThemes Post Options',
            'show_ht_post_options_cb',
            'post',
            'normal',
            'high');
    }

}

add_action('add_meta_boxes', 'add_ht_post_options_cb');

$custom_post_meta_fields = array(
    array(
        'label'=> __('Slideshow Status', 'highthemes'),
        'desc'  => __('You can override the slideshow status for this page/post.', 'highthemes'),
        'id'    => $prefix.'slideshow_status',
        'type'  => 'select',
        'options' => array (
            'default' => array (
                'label' => __('Default Settings', 'highthemes'),
                'value' => ''
            ),
            'enable' => array (
                'label' => __('Enable Slideshow', 'highthemes'),
                'value' => 1
            ),
            'disable' => array (
                'label' => __('Disable Slideshow', 'highthemes'),
                'value' => 'false'
            )
        )
    ),

    array (
        'label' => __('Slideshow Category', 'highthemes'),
        'desc'  => __('Check the categories you wish to show items from', 'highthemes'),
        'id'    => $prefix.'slideshow_category',
        'type'  => 'select',
        'options' => $sterms_array
    )  ,
    array(
        'label' =>__('Disable Sidebar?', 'highthemes'),
        'desc'  =>__('Check to disable sidebar', 'highthemes'),
        'id'    =>$prefix.'disable_sidebar',
        'type'  =>'checkbox'
    ),
    array(
        'label' =>__('Featured image on single page', 'highthemes'),
        'desc'  =>__('You can enable/disable featured image on this page.', 'highthemes'),
        'id'    =>$prefix.'disable_post_image',
        'type'  =>'select',
        'options'=>array(
            'select' => array(
                'label' => __('Select An Option', 'highthemes'),
                'value' =>''
            ),
            'true' => array (
                'label' => __('Enable', 'highthemes'),
                'value' => 'true'
            ),
            'false' => array (
                'label' => __('Disable', 'highthemes'),
                'value' => 'false'
            )
        )
    ),
    array(
        'label'=> __('Embed Video ', 'highthemes'),
        'desc'  => __('To embed a video, you can paste its link here.  what type? (http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/)', 'highthemes'),
        'id'    => $prefix.'video_link',
        'type'  => 'text'
    ),
    array(
        'label'=> __('External Link for Link Post Format ', 'highthemes'),
        'desc'  => __('Paste an external link address, if you\'ve chosen "link" post format type. ', 'highthemes'),
        'id'    => $prefix.'link_post_format',
        'type'  => 'text'
    )


);

if ( ! function_exists('show_ht_post_options_cb') ) {
    function show_ht_post_options_cb() {
        global $custom_post_meta_fields, $post;
        echo '<input type="hidden" name="custom_post_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

        echo '<table class="form-table">';
        foreach ($custom_post_meta_fields as $field) {
            $meta = get_post_meta($post->ID, $field['id'], true);

            echo '<tr>
                    <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                    <td>';
            switch($field['type']) {
                // text
                case 'text':
                    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // textarea
                case 'textarea':
                    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // checkbox
                case 'checkbox':
                    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                    break;
                // checkbox_group
                case 'checkbox_group':
                    foreach ($field['options'] as $option) {
                        echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
                    }
                    echo '<span class="description">'.$field['desc'].'</span>';
                    break;
                // select
                case 'select':
                    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                    }
                    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                    break;



            }
            echo '</td></tr>';
        }
        echo '</table>';
    }

}

// Save the Data
if ( ! function_exists('save_custom_post_meta') ) {
    function save_custom_post_meta($post_id) {
        global $custom_post_meta_fields;
        if(isset($_POST['custom_post_meta_box_nonce'])){

            if (!wp_verify_nonce($_POST['custom_post_meta_box_nonce'], basename(__FILE__)))
                return $post_id;
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            // loop through fields and save the data
            foreach ($custom_post_meta_fields as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                $new = $_POST[$field['id']];
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }

        }
    }

}

add_action('save_post', 'save_custom_post_meta');



/* Portfolio */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('add_ht_portfolio_options_cb') ) {
    function add_ht_portfolio_options_cb() {
        add_meta_box(
            'ht_portfolio_options_cb',
            'HighThemes Portfolio Options',
            'show_ht_portfolio_options_cb',
            'portfolio',
            'normal',
            'high');
    }

}

add_action('add_meta_boxes', 'add_ht_portfolio_options_cb');


$custom_portfolio_meta_fields = array(
    array(
        'label'=> __('Override Page Title', 'highthemes'),
        'desc'  => __('By default, the page name will display as the title, you can override it here.', 'highthemes'),
        'id'    => $prefix.'override_title',
        'type'  => 'textarea'
    ),
    array(

        'label'=> __('Slideshow Status', 'highthemes'),
        'desc'  => __('You can override the slideshow status for this page/post.', 'highthemes'),
        'id'    => $prefix.'slideshow_status',
        'type'  => 'select',
        'options' => array (
            'default' => array (
                'label' => __('Default Settings', 'highthemes'),
                'value' => ''
            ),
            'enable' => array (
                'label' => __('Enable Slideshow', 'highthemes'),
                'value' => 1
            ),
            'disable' => array (
                'label' => __('Disable Slideshow', 'highthemes'),
                'value' => 'false'
            )
        )
    ),

    array (
        'label' => __('Slideshow Category', 'highthemes'),
        'desc'  => __('Check the categories you wish to show items from', 'highthemes'),
        'id'    => $prefix.'slideshow_category',
        'type'  => 'select',
        'options' => $sterms_array
    )  ,


    array(
        'label'=> __('Embed Video ', 'highthemes'),
        'desc'  => __('To embed a video, you can paste its link here.  what type? (http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/)', 'highthemes'),
        'id'    => $prefix.'video_link',
        'type'  => 'text'
    ),
    array(
        'label'=> __('Extra Information ', 'highthemes'),
        'desc'  =>__("Here you can enter a little more about the project. For example designer: John Smith<br/>", "highthemes") . "
        &lt;span&gt;ِDesigner: &lt;/span&gt; John Smith <br/>&lt;span&gt;Skills:&lt;/span&gt; Photoshop, CSS",
        'id'    => $prefix.'extra_info',
        'type'  => 'textarea'
    )



);



// The Callback
if ( ! function_exists('show_ht_portfolio_options_cb') ) {
    function show_ht_portfolio_options_cb() {
        global $custom_portfolio_meta_fields, $post;
        // Use nonce for verification
        echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

        // Begin the field table and loop
        echo '<table class="form-table">';
        foreach ($custom_portfolio_meta_fields as $field) {
            // get value of this field if it exists for this post
            $meta = get_post_meta($post->ID, $field['id'], true);

            // begin a table row with
            echo '<tr>
                    <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                    <td>';
            switch($field['type']) {
                // text
                case 'text':
                    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // textarea
                case 'textarea':
                    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // checkbox
                case 'checkbox':
                    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                    break;
                // checkbox_group
                case 'checkbox_group':
                    foreach ($field['options'] as $option) {
                        echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
                    }
                    echo '<span class="description">'.$field['desc'].'</span>';
                    break;
                // select
                case 'select':
                    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                    }
                    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                    break;



            } //end switch
            echo '</td></tr>';
        } // end foreach
        echo '</table>'; // end table
    }

}

// Save the Data
if ( ! function_exists('save_custom_portfolio_meta') ) {
    function save_custom_portfolio_meta($post_id) {
        global $custom_portfolio_meta_fields;
        if(isset($_POST['custom_meta_box_nonce'])) {
            // verify nonce
            if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
                return $post_id;
            // check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;
            // check permissions
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            // loop through fields and save the data
            foreach ($custom_portfolio_meta_fields as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                $new = $_POST[$field['id']];
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            } // end foreach
        }

    }

}

add_action('save_post', 'save_custom_portfolio_meta');




/* Slideshow */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('add_ht_slideshow_options_cb') ) {
    function add_ht_slideshow_options_cb() {
        add_meta_box(
            'ht_slideshow_options_cb',
            'HighThemes slideshow Options',
            'show_ht_slideshow_options_cb',
            'slideshow',
            'normal',
            'high');
    }

}

add_action('add_meta_boxes', 'add_ht_slideshow_options_cb');
// Field Array
$prefix = '_';


$custom_slideshow_meta_fields = array(

    array(
        'label' => __('Disable Caption?', 'highthemes'),
        'desc'  => __('Check this box to disable caption for this item.', 'highthemes'),
        'id'    => $prefix.'slider_disable_caption',
        'type'  => 'checkbox',
    )


);



// The Callback
if ( ! function_exists('show_ht_slideshow_options_cb') ) {
    function show_ht_slideshow_options_cb() {
        global $custom_slideshow_meta_fields, $post;
        // Use nonce for verification
        echo '<input type="hidden" name="custom__slideshow_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

        // Begin the field table and loop
        echo '<table class="form-table">';
        foreach ($custom_slideshow_meta_fields as $field) {
            // get value of this field if it exists for this post
            $meta = get_post_meta($post->ID, $field['id'], true);

            // begin a table row with
            echo '<tr>
                    <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                    <td>';
            switch($field['type']) {
                // text
                case 'text':
                    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // textarea
                case 'textarea':
                    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // checkbox
                case 'checkbox':
                    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                    break;
                // checkbox_group
                case 'checkbox_group':
                    foreach ($field['options'] as $option) {
                        echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
                    }
                    echo '<span class="description">'.$field['desc'].'</span>';
                    break;
                // radio
                case 'radio':
                    $selected = '';
                    foreach ( $field['options'] as $option ) {
                        if($meta ==''){
                            if($field['default'] == $option['value'] ) $selected = 'checked="checked"';
                        }
                        echo '<input '.$selected.' type="radio" name="'.$field['id'].'" id="'.$field['id'].'_'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
                    <label for="'.$field['id'].'_'.$option['value'].'">'.$option['label'].'</label><br />';
                        $selected = "";
                    }
                    break;
                // select
                case 'select':
                    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                    }
                    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                    break;



            } //end switch
            echo '</td></tr>';
        } // end foreach
        echo '</table>'; // end table
    }

}

// Save the Data
if ( ! function_exists('save_custom_slideshow_meta') ) {
    function save_custom_slideshow_meta($post_id) {
        global $custom_slideshow_meta_fields;
        if(isset($_POST['custom__slideshow_meta_box_nonce'])) {

            // verify nonce
            if (!wp_verify_nonce($_POST['custom__slideshow_meta_box_nonce'], basename(__FILE__)))
                return $post_id;
            // check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;
            // check permissions
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            // loop through fields and save the data
            foreach ($custom_slideshow_meta_fields as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                $new = $_POST[$field['id']];
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            } // end foreach

        }
    }

}

add_action('save_post', 'save_custom_slideshow_meta');



/* Sidebar */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('add_ht_custom_sidebar_cb') ) {
    function add_ht_custom_sidebar_cb() {
        add_meta_box(
            'ht_custom_sidebar_cb',
            'Sidebar Options',
            'show_ht_custom_sidebar_cb',
            'page',
            'side',
            'low');

        add_meta_box(
            'ht_custom_sidebar_cb',
            'Sidebar Options',
            'show_ht_custom_sidebar_cb',
            'post',
            'side',
            'low');

    }

}

add_action('add_meta_boxes', 'add_ht_custom_sidebar_cb');
// Field Array
$prefix = '_';
$sidebars = ht_sidebar_generator::get_sidebars();

$sidebars_array =array (
    'default' => array (
        'label' => __('Select a Sidebar', 'highthemes'),
        'value' => ''
    ));

if(is_array($sidebars)){
    foreach($sidebars as $key=>$sidebar){
        $sidebars_array[$key]['label']  = $sidebar;
        $sidebars_array[$key]['value']  =$key;
    }
}

$custom_sidebar_fields = array(

    array(
        'label'=> __('Sidebar Alignment', 'highthemes'),
        'desc'  => '',
        'id'    => $prefix.'sidebar_alignment',
        'type'  => 'select',
        'options' => array (
            'select' => array (
                'label' => __('Select Sidebar Alignment', 'highthemes'),
                'value' => ''
            ),
            'Right' => array (
                'label' => __('Right Sidebar', 'highthemes'),
                'value' => 'has-rightsidebar'
            ),
            'Left' => array (
                'label' => __('Left Sidebar', 'highthemes'),
                'value' => 'has-leftsidebar'
            )
        )
    ),

    array(
        'label'=> __('Custom Sidebar', 'highthemes'),
        'desc'  => '',
        'id'    => $prefix.'selected_sidebar',
        'type'  => 'select',
        'options' => $sidebars_array
    )


);


if ( ! function_exists('show_ht_custom_sidebar_cb') ) {
    function show_ht_custom_sidebar_cb() {
        global $custom_sidebar_fields, $post;
        echo '<input type="hidden" name="ht_custom_sidebar_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

        foreach ($custom_sidebar_fields as $field) {
            $meta = get_post_meta($post->ID, $field['id'], true);

            echo '<p><strong>'.$field['label'].'</strong></p>';
            switch($field['type']) {
                // text
                case 'text':
                    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // textarea
                case 'textarea':
                    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                // checkbox
                case 'checkbox':
                    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                    break;
                // checkbox_group
                case 'checkbox_group':
                    foreach ($field['options'] as $option) {
                        echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
                    }
                    echo '<span class="description">'.$field['desc'].'</span>';
                    break;
                // select
                case 'select':
                    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                    }
                    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                    break;



            }
        } // end foreach
    }

}

// Save the Data
if ( ! function_exists('save_custom_sidebar_meta') ) {
    function save_custom_sidebar_meta($post_id) {
        global $custom_sidebar_fields;
        if(isset($_POST['ht_custom_sidebar_nonce'])){
            if (!wp_verify_nonce($_POST['ht_custom_sidebar_nonce'], basename(__FILE__)))
                return $post_id;
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            foreach ($custom_sidebar_fields as $field) {
                $old = get_post_meta($post_id, $field['id'], true);
                $new = $_POST[$field['id']];
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }
        }

    }

}

add_action('save_post', 'save_custom_sidebar_meta');

?>