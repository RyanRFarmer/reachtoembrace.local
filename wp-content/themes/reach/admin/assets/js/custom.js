jQuery(document).ready(function () {


    function portfolio_show_details(value) {
        if (value == 'portfolio' || value == 'portfolio-filterable') {
            jQuery('label[for=_portfolio_category]').parent().parent().show();
            jQuery('label[for=_portfolio_layout]').parent().parent().show();
            jQuery('label[for=_subblog_category]').parent().parent().hide();
            jQuery('label[for=_item_number]').parent().parent().show();


        } else if (value == 'subblog') {
            jQuery('label[for=_portfolio_category]').parent().parent().hide();
            jQuery('label[for=_portfolio_layout]').parent().parent().hide();
            jQuery('label[for=_subblog_category]').parent().parent().show();
            jQuery('label[for=_item_number]').parent().parent().show();

        } else {
            jQuery('label[for=_portfolio_category]').parent().parent().hide();
            jQuery('label[for=_portfolio_layout]').parent().parent().hide();
            jQuery('label[for=_subblog_category]').parent().parent().hide();
            jQuery('label[for=_item_number]').parent().parent().hide();

        }
    }


    // hide items
    var portfolio_value = jQuery('#_page_type').val();
    portfolio_show_details(portfolio_value);


    jQuery('#_page_type').change(function () {
        var pvalue = jQuery(this).val();
        portfolio_show_details(pvalue);

    });
    //-------------------------- Slideshow

    function slider_show_details(value) {
        if (value == 'image') {
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_style]').parent().parent().show();
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_caption]').parent().parent().show();
            jQuery('#ht_slideshow_options_cb label[for=_slider_video_link]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_disable_link]').parent().parent().show();
            jQuery('#ht_slideshow_options_cb label[for=_slider_exlink]').parent().parent().show();
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_height]').parent().parent().show();


            jQuery('#ht_slideshow_options_cb label[for=_slider_video_style]').parent().parent().hide();


        } else if (value == 'video') {
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_style]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_caption]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_disable_link]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_exlink]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_video_link]').parent().parent().show();
            jQuery('#ht_slideshow_options_cb label[for=_slider_video_style]').parent().parent().show();
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_height]').parent().parent().hide();


        } else {
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_style]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_caption]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_video_link]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_disable_link]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_exlink]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_video_style]').parent().parent().hide();
            jQuery('#ht_slideshow_options_cb label[for=_slider_image_height]').parent().parent().hide();


        }
    }

    // hide items
    var slider_value = jQuery('#_slider_type').val();
    slider_show_details(slider_value);


    jQuery('#_slider_type').change(function () {
        var value = jQuery(this).val();
        slider_show_details(value);

    });


});