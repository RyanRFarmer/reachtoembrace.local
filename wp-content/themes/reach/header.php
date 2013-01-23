<?php include( get_template_directory()  . '/includes/contact_action.php');?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php global $data; ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php if($data['custom_favicon']) { echo ht_favicon($data['custom_favicon']);} ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/styles/flexslider.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/styles/prettyPhoto.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/styles/supersized.css" type="text/css" media="screen" />

<!--[if lt IE 9]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/styles/ie.css" type="text/css" media="screen" />
<![endif]-->

<!-- MOBILE SETTINGS -->
<?php
if($data['responsive_layout'] == 'responsive') {?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri();?>/scripts/css3-mediaqueries.js"></script>
<![endif]-->
<?php }?>
<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/styles/ie8.css" type="text/css" media="screen" />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/styles/ie7.css" type="text/css" media="screen" />
<![endif]-->



<!-- RSS FEED -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php if ( $data['rss_id'] <> "" ) { echo $data['rss_id']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
if ( is_singular() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );
    wp_head();
?>

</head>
<body <?php body_class(); ?>>

<?php if(is_front_page()){
    $social_class = "social-in-homepage";
} else {
    $social_class = "social-in-page";
}
?>

<?php if($data['sb_inner']){ ?>
<div class="<?php echo $social_class;?> social-bookmarks">
    <ul>
        <?php if($data['twitter_id']){?><li class="twitter"><a href="http://twitter.com/<?php echo $data['twitter_id'];?>">Twitter</a></li><?php }?>
        <?php if($data['facebook_id']){?><li class="facebook"><a href="<?php echo $data['facebook_id'];?>">Facebook</a></li><?php }?>
        <?php if($data['gplus_id']){?><li class="gplus"><a href="<?php echo $data['gplus_id'];?>">Google Plus</a></li><?php }?>
        <?php if($data['flickr_id']){?><li class="flickr"><a href="<?php echo $data['flickr_id'];?>">Flickr</a></li><?php }?>
        <?php if($data['rss_id']){;?><li class="rss"><a href="<?php echo $data['rss_id'];?>">RSS</a></li><?php }?>
        <?php if($data['linkedin_id']){?><li class="linkedin"><a href="<?php echo $data['linkedin_id'];?>">LinkedIn</a></li><?php }?>
        <?php if($data['vimeo_id']){?><li class="vimeo"><a href="<?php echo $data['vimeo_id'];?>">Vimeo</a></li><?php }?>
        <?php if($data['behance_id']){?><li class="behance"><a href="<?php echo $data['behance_id'];?>">Behance</a></li><?php }?>
        <?php if($data['picasa_id']){?><li class="picasa"><a href="<?php echo $data['picasa_id'];?>">Picasa</a></li><?php }?>
        <?php if($data['dribble_id']){?><li class="dribble"><a href="<?php echo $data['dribble_id'];?>">Dribble</a></li><?php }?>
        <?php if($data['digg_id']){?><li class="digg"><a href="<?php echo $data['digg_id'];?>">Digg</a></li><?php }?>
        <?php if($data['blogger_id']){?><li class="blogger"><a href="<?php echo $data['blogger_id'];?>">Blogger</a></li><?php }?>
        <?php if($data['delicious_id']){?><li class="delicious"><a href="<?php echo $data['delicious_id'];?>">Delicious</a></li><?php }?>
        <?php if($data['tumblr_id']){?><li class="tumblr"><a href="<?php echo $data['tumblr_id'];?>">Tumblr</a></li><?php }?>
        <?php if($data['yahoo_id']){?><li class="yahoo"><a href="<?php echo $data['yahoo_id'];?>">Yahoo</a></li><?php }?>
    </ul>
</div><!-- [/social-bookmarks] -->

<div class="social-in-page social-bookmarks res-social-bookmarks">
    <ul>
        <?php if($data['twitter_id']){?><li class="twitter"><a href="http://twitter.com/<?php echo $data['twitter_id'];?>">Twitter</a></li><?php }?>
        <?php if($data['facebook_id']){?><li class="facebook"><a href="<?php echo $data['facebook_id'];?>">Facebook</a></li><?php }?>
        <?php if($data['gplus_id']){?><li class="gplus"><a href="<?php echo $data['gplus_id'];?>">Google Plus</a></li><?php }?>
        <?php if($data['flickr_id']){?><li class="flickr"><a href="<?php echo $data['flickr_id'];?>">Flickr</a></li><?php }?>
        <?php if($data['rss_id']){;?><li class="rss"><a href="<?php echo $data['rss_id'];?>">RSS</a></li><?php }?>
        <?php if($data['linkedin_id']){?><li class="linkedin"><a href="<?php echo $data['linkedin_id'];?>">LinkedIn</a></li><?php }?>
        <?php if($data['vimeo_id']){?><li class="vimeo"><a href="<?php echo $data['vimeo_id'];?>">Vimeo</a></li><?php }?>
        <?php if($data['behance_id']){?><li class="behance"><a href="<?php echo $data['behance_id'];?>">Behance</a></li><?php }?>
        <?php if($data['picasa_id']){?><li class="picasa"><a href="<?php echo $data['picasa_id'];?>">Picasa</a></li><?php }?>
        <?php if($data['dribble_id']){?><li class="dribble"><a href="<?php echo $data['dribble_id'];?>">Dribble</a></li><?php }?>
        <?php if($data['digg_id']){?><li class="digg"><a href="<?php echo $data['digg_id'];?>">Digg</a></li><?php }?>
        <?php if($data['blogger_id']){?><li class="blogger"><a href="<?php echo $data['blogger_id'];?>">Blogger</a></li><?php }?>
        <?php if($data['delicious_id']){?><li class="delicious"><a href="<?php echo $data['delicious_id'];?>">Delicious</a></li><?php }?>
        <?php if($data['tumblr_id']){?><li class="tumblr"><a href="<?php echo $data['tumblr_id'];?>">Tumblr</a></li><?php }?>
        <?php if($data['yahoo_id']){?><li class="yahoo"><a href="<?php echo $data['yahoo_id'];?>">Yahoo</a></li><?php }?>
    </ul>
</div><!-- [/Responsive social-bookmarks] -->
<?php } ?>

<div id="wrap-wide"></div><!-- [/wrap-wide] -->
<div id="menu-wrap">
    <div id="menu">
        <a id="logo" title="<?php bloginfo("description");?>" href="<?php echo home_url();?>">
            <?php if ($data['logo_url']) { ?>
            <img src="<?php echo $data['logo_url'];?>" alt="<?php bloginfo('description'); ?>"/>
            <?php } else { ?>
            <img  src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="Logo"/>
            <?php }?>
        </a><!-- [/logo] -->
        <?php
        $params = array('container_class' => 'jqueryslidemenu', 'theme_location' => 'nav', 'container_id' => 'nav','walker' => new description_walker());
        wp_nav_menu($params);
        ?>
        <?php
        $params = array('container_class' => '', 'theme_location' => 'nav', 'container_id' => 'nav-horizontal','walker' => new description_walker());
        wp_nav_menu($params);
        ?>
        <h3 id="nav-toggle">Navigation</h3>
        <?php
        $params = array('theme_location' => 'nav', 'container_id' => 'nav-toggle-content');
        wp_nav_menu($params);
        ?>
        <span id="menu-toggle"><?php _e("menu toggle", "highthemes");?></span>
    </div>
</div><!-- [/menu] -->