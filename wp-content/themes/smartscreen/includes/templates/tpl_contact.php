<?php
include(HT_INCLUDES_PATH . "captcha/captcha.php");
$_SESSION['captcha'] = captcha();
$_SESSION['seccode'] = $_SESSION['captcha']['code'];
?>
<?php if (ht_slideshow_status() == '1') { require_once HT_INCLUDES_PATH . "slideshow_content.php"; } ?>
<div id="wrap" class="no-sidebar clearfix">
    <div id="main">
    <div id="entries">
        <h2 class="page-title"><?php echo $teaser;?>
            <span id="entries-toggle"><?php _e("Toggle", "highthemes");?></span>
            <?php if($data['breadcrumb_inner']){ ?>
                <div id="breadcrumb">
                    <?php if (class_exists('simple_breadcrumb')) { $bc = new simple_breadcrumb; } ?>
                </div>
                <?php } ?>
        </h2>
        <?php if (have_posts()) : ?>
        <div id="entries-box">
            <?php  while ( have_posts() ) : the_post();  ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                    <div class="entry">
                        <div id="contact-box">
                            <div class="two_third">
                                <?php the_content();?>
                            </div>
                            <div class="one_third last">
                                <h3 class="special-heading"><?php _e("Send us a message", "highthemes");?></h3>
                                <div class="log"></div>
                                <form action="<?php the_permalink();?>" method="post" id="contactform">
                                    <div class="form-details ">
                                        <p>
                                            <input type="text" name="fullname" id="fullname" tabindex="1" class="txt required" value="<?php if(isset($_POST['fullname'])) echo $_POST['fullname']; else echo 'Full Name:'; ?>">
                                        </p>
                                        <p>
                                            <input type="text" name="email" id="email" tabindex="2" value="<?php if(isset($_POST['email'])) echo $_POST['email']; else echo 'Email:'; ?>" class="txt required">
                                        </p>
                                        <p>
                                            <input type="text" name="url" id="url" tabindex="3" value="<?php if(isset($_POST['url'])) echo $_POST['url']; else echo 'Website URL:'; ?>" class="txt">
                                        </p>
                                        <?php if($data['disable_captcha'] !="1"){?>
                                        <p>
                                            <?php echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />'; ?>
                                            <input type="text" class="txt required" value="<?php if(isset($_POST['captcha'])) echo $_POST['captcha']; else echo 'Above Code:'; ?>" tabindex="4" id="captcha" name="captcha">
                                        </p>
                                        <?php } ?>
                                        <p>
                                            <textarea rows="10" cols="10" id="form_message" class="required" name="form_message" tabindex="5"><?php if(isset($_POST['form_message'])) echo $_POST['form_message']; else echo 'Comment:'; ?></textarea>
                                        </p>
                                        <p>
                                            <input type="hidden" value="send" name="sendContact" id="sendContact">
                                            <input type="submit" id="submit" class="submit-button" name="submit" value="Send">
                                            <input type="reset" class="submit-button" name="reset" value="Reset">
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- [/post-item] -->

                <?php endwhile;?>
        </div><!-- [/entries-box] -->
        </div><!-- [/entries] -->

        <?php endif; ?>
    </div><!-- [/main] -->
</div><!-- [/wrap] -->
<?php get_footer();?>