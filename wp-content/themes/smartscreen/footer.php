<?php global $data;?>
<?php if($data['footer_disable'] !=1){ ?>
<a id="scrollup" href="#"><?php _e("Scroll", "highthemes");?></a><!-- [/scrollup] -->
<?php if($data['NUMBEROFSLIDES']  > 1 && ht_slideshow_status() =='1' && $data['slideshow_progress_status'] =='1' ){?>
    <div id="progress-back" class="load-item">
        <div id="progress-bar"></div>
    </div><!-- [/Time Bar] -->
<?php }?>
<?php if(is_front_page()){?>
    <?php if($data['NUMBEROFSLIDES']  > 1 && ht_slideshow_status() =='1' ){?>
        <div id="thumb-tray" class="load-item">
            <div id="thumb-back"></div>
            <div id="thumb-forward"></div>
        </div>
    <?php }?>
<!--Slide captions displayed here-->
    <?php if($data['NUMBEROFSLIDES']  > 1 && ht_slideshow_status() =='1' ){?>
    <?php if($data['slideshow_caption']) { ?>
    <div id="slidecaption"></div>
<?php } }?>

<?php }?>
<div id="controls-wrap" class="load-item">
    <?php if($data['NUMBEROFSLIDES']  > 1  && ht_slideshow_status() =='1' && $data['slideshow_button_status'] =='1' ){?>
        <a id="nextslide" class="load-item"></a>
        <a id="play-button"><img alt="" id="pauseplay" src="<?php echo get_template_directory_uri();?>/images/slider/pause.png"/></a>
        <a id="prevslide" class="load-item"></a>
    <?php }?>
    <p <?php if(!$data['slideshow_thumbs'] ){echo 'style="padding-left: 45px;"';}?> class="copyright"><?php echo stripslashes($data['footer_text']); ?></p>
    <?php if($data['slideshow_thumbs']) { ?>
    <?php if(is_front_page()){ ?>
            <?php if($data['NUMBEROFSLIDES']  > 1 && ht_slideshow_status() =='1' ){?>

                <a id="tray-button"><img id="tray-arrow" src="<?php echo get_template_directory_uri();?>/images/slider/button-tray-up.png"/></a>
    <?php } } } ?>
   <?php if(is_front_page()){?> <a href="#" id="shutdown"><?php _e("ShutDown", "highthemes");?></a><?php }?>
</div><!-- [/Control Bar] -->

<?php } ?>

<?php echo stripslashes($data['google_analytics']); ?>
<?php wp_footer(); ?>

</body>
</html>
