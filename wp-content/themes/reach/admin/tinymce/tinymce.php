<?php



class add_shortcodes_button {
	
	var $pluginname = 'highthemes_shortcode';
	var $path = '';
	var $internalVersion = 100;
	
	function add_shortcodes_button()  {
		
		// Set path to editor_plugin.js
		$this->path = get_template_directory_uri() . '/admin/tinymce/';	
		
		// Modify the version when tinyMCE plugins are changed.
		add_filter('tiny_mce_version', array (&$this, '1.0') );

		// init process for button control
		add_action('init', array (&$this, 'addbuttons') );
	}
	
	
	
	
	function addbuttons() {
		global $page_handle;
	
		// Don't bother doing this stuff if the current user lacks permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) 
			return;
		
		$svr_uri = $_SERVER['REQUEST_URI'];

		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
		 
		if ( strstr($svr_uri, 'post.php') || strstr($svr_uri, 'post-new.php') || strstr($svr_uri, 'page.php') || strstr($svr_uri, 'page-new.php') ) {
				add_filter("mce_external_plugins", array (&$this, 'add_tinymce_plugin' ), 5);
				add_filter('mce_buttons', array (&$this, 'register_button' ), 5);
				
			}
		}
	}
	
	function register_button($buttons) {
	
		array_push($buttons, 'separator', $this->pluginname );
	
		return $buttons;
	}
	
	function add_tinymce_plugin($plugin_array) {

        if(isset($_GET['post'])){
            $post_id = $_GET['post'];

        }
		$post = get_post($post_id);
		$post_type = $post->post_type;
        if(isset($_GET['post_type'])) {

            $post_type_get = $_GET['post_type'];
            if($post_type == 'page' || $post_type_get == 'page'){
                $plugin_array[$this->pluginname] =  $this->path . 'editor_plugin_post.js';
            }
            if($post_type == 'portfolio' || $post_type_get == 'portfolio'){
                $plugin_array[$this->pluginname] =  $this->path . 'editor_plugin_post.js';
            }
            if($post_type == 'portfolio' || $post_type_get == 'slideshow'){
                $plugin_array[$this->pluginname] =  $this->path . 'editor_plugin_post.js';
            }
        }


        if($post_type == 'post' || $post_type == 'page' || $post_type == 'portfolio' || $post_type == 'slideshow'){
			$plugin_array[$this->pluginname] =  $this->path . 'editor_plugin_post.js';
		}
		
		return $plugin_array;
	}

	function change_tinymce_version($version) {
			$version = $version + $this->internalVersion;
		return $version;
	}
	
}

$tinymce_button = new add_shortcodes_button ();

?>