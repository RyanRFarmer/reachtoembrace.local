function init() {
    tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
    if(!radioObj)
        return "";
    var radioLength = radioObj.length;
    if(radioLength == undefined)
        if(radioObj.checked)
            return radioObj.value;
        else
            return "";
    for(var i = 0; i < radioLength; i++) {
        if(radioObj[i].checked) {
            return radioObj[i].value;
        }
    }
    return "";
}

function InsertShortcodes() {

    var tagtext;

    var style = document.getElementById('shortcodes_panel');
    var button = document.getElementById('button_panel');
    var list = document.getElementById('list_panel');
    var sbox = document.getElementById('sbox_panel');
    var tbox = document.getElementById('tbox_panel');
    var infobox = document.getElementById('box_panel');
    var linkpanel = document.getElementById('link_panel');

    /*************** Button Generator ****************/
    if (button.className.indexOf('current') != -1) {

        var button_title = document.getElementById('button_title').value;
        var button_color = document.getElementById('button_color').value;
        var button_link = document.getElementById('button_link').value;
        var button_size = document.getElementById('button_size').value;
        var button_type = document.getElementById('button_type').value;


        tagtext = "[button link=\"" + button_link + "\" size=\"" + button_size + "\" color=\"" + button_color + "\" type=\"" + button_type + "\"]"+ button_title + "[/button]";

    }
    /*
     ************** Links ****************/
    if (linkpanel.className.indexOf('current') != -1) {

        var link_title = document.getElementById('link_title').value;
        var link_icon = document.getElementById('link_icon').value;
        var link_url = document.getElementById('link_url').value;

        tagtext = "[icon_link link=\"" + link_url + "\"  icon=\"" + link_icon + "\"]"+ link_title + "[/icon_link]";

    }	/*************** List Generator ****************/
    if (list.className.indexOf('current') != -1) {

        var list_type = document.getElementById('list_type').value;
        tagtext = "[list type=\"" + list_type + "\"]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/list]";

    }

    /*************** Simple Box Generator ****************/
    if (sbox.className.indexOf('current') != -1) {

        var sbox_border = document.getElementById('sbox_border').value;
        var sbox_border_color = document.getElementById('sbox_border_color').value;

        tagtext = "[simple_box border_size=\"" + sbox_border + "\" border_color=\"" + sbox_border_color + "\"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.[/simple_box]";

    }

    /*************** Titled Box Generator ****************/
    if (tbox.className.indexOf('current') != -1) {

        var tbox_color = document.getElementById('tbox_color').value;
        var tbox_title = document.getElementById('tbox_title').value;

        tagtext = "[titled_box title=\"" + tbox_title + "\" color=\"" + tbox_color + "\"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.[/titled_box]";

    }

    /*************** Info Box Generator ****************/
    if (infobox.className.indexOf('current') != -1) {

        var info_type = document.getElementById('info_type').value;
        var info_color = document.getElementById('info_color').value;
        var info_title = document.getElementById('info_title').value;
        var info_icon = document.getElementById('info_icon').value;

        if(info_type == 'titled'){

            tagtext = "[info_box title=\"" + info_title + "\" color=\"" + info_color + "\" type=\"" + info_type + "\" icon=\"" + info_icon + "\"] [/info_box]";

        } else {

            tagtext = "[info_box title=\"" + info_title + "\" color=\"" + info_color + "\" type=\"" + info_type + "\" icon=\"" + info_icon + "\"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.[/info_box]";

        }



    }

    /*************** General Style Shortcodes ****************/

    if (style.className.indexOf('current') != -1) {

        var styleid = document.getElementById('style_shortcode').value;


        if (styleid != 0 ){
            tagtext = "["+ styleid + "]Insert your text here[/" + styleid + "]";
        }
        if (styleid != 0 && styleid=='hr' || styleid=='hr_2dot' || styleid=='hr_3dot' || styleid=='hr_top' ){
            tagtext = "["+ styleid + "]";
        }

        if ( styleid != 0 && styleid=='pricing_3col' ){

            tagtext = '[pricing_table cols="3"] \
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="true" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[/pricing_table]\
';
        }

        if ( styleid != 0 && styleid=='pricing_4col' ){

            tagtext = '[pricing_table cols="4"] \
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="true" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[/pricing_table]	\
';
        }

        if ( styleid != 0 && styleid=='pricing_5col' ){

            tagtext = '[pricing_table cols="5"] \
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="true" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
\[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[/pricing_table]\
';
        }

        if ( styleid != 0 && styleid=='pricing_4col' ){

            tagtext = '[pricing_table cols="4"] \
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="true" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[col title="Title" color="green" price="99.99" special="false" special_color="orange" button_title="Buy Now" button_link="#"]\
<ul class="linelist">\
    <li>24/7 Lorem Ipsum</li>\
    <li class="odd">Advanced Lorem</li>\
    <li>100GB Dolor</li>\
    <li class="odd">1GB sit</li>\
    <li>Something amet</li>\
    <li class="odd">25 Email Address</li>\
</ul>\
[/col]\
<br />\
[/pricing_table]\
';
        }

        if (styleid != 0 && styleid == 'tooltip'){
            tagtext = '\
[tooltip trigger="Tooltip Text Goes Here..." ]Lorem Ipsum dolor sit[/tooltip]\
';
        }
        if (styleid != 0 && styleid == 'testimonial' ){
            tagtext = '\
[testimonials]\
<br />\
[testimonial name="John Smith" website_url="http://www.johnsmith.com"]\
<br />\
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. \
Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, \
posuere a, pede.\
<br />\
[/testimonial]\
<br />\
[testimonial name="Lorem Ipsum" website_url="http://www.lorem.com"]\
<br />\
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. \
Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, \
posuere a, pede.\
<br />\
[/testimonial]\
<br />\
[testimonial name="" website_url=""]\
<br />\
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. \
Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, \
posuere a, pede.\
<br />\
[/testimonial]\
<br />\
[/testimonials]\
			';
        }


        if (styleid != 0 && styleid == 'slideshow'){
            tagtext = '\
[slideshow]\
<br />\
[slide width="500" height="150" resize="true"]PATH-TO-IMAGE[/slide]\
<br />\
[slide width="500" height="150" resize="true" link="http://highthemes.com"]PATH-TO-IMAGE[/slide]\
<br />\
[slide width="500" height="150" resize="true" link=""]PATH-TO-IMAGE[/slide]\
<br />\
[/slideshow]\
';
        }

        if (styleid != 0 && styleid == 'cta_box'){
            tagtext = "["+ styleid + " button_title=\"sample title\" button_color=\"black\" button_url=\"full url\" title=\"Sample call to action title\"]Insert the call to action description.[/" + styleid + "]";
        }

        if (styleid != 0 && styleid == 'video'){
            tagtext = "["+ styleid + " url=\"Vimeo, youtube, dailymotion or path to flv, mp4, swf\" /]";
        }

        if (styleid != 0 && styleid == 'googlemap' ){
            tagtext = '\
[google_map type="ROADMAP, SATELLITE, HYBRID, TERRAIN" zoom="1-19" lat="" lng=""]Bubble Info here[/google_map]\
';
        }

        if (styleid != 0 && styleid == 'progress' ){
            tagtext = '\
[progress type="simple,round" value="1-100" color="color name" width="1-100"][/progress]\
';
        }

        if (styleid != 0 && styleid == 'socialized' ){
            tagtext = '\
                        [socialized]\
                        <ul>\
                        <li class="facebook"><a href="#">facebook</a></li>\
                        <li class="gplus"><a href="#">googel plus</a></li>\
                        <li class="twitter"><a href="#">twitter</a></li>\
                        <li class="youtube"><a href="#">youtube</a></li>\
                        <li class="vimeo"><a href="#">vimeo</a></li>\
                        <li class="flickr"><a href="#">flickr</a></li>\
                        <li class="skype"><a href="#">skype</a></li>\
                        <li class="linkedin"><a href="#">linked in</a></li>\
                        <li class="behance"><a href="#">behance</a></li>\
                        <li class="picasa"><a href="#">picasa</a></li>\
                        <li class="dribble"><a href="#">dribble</a></li>\
                        <li class="digg"><a href="#">digg</a></li>\
                        <li class="blogger"><a href="#">blogger</a></li>\
                        <li class="supon"><a href="#">stumble upon</a></li>\
                        <li class="delicious"><a href="#">delicious</a></li>\
                        <li class="tumblr"><a href="#">Tumblr</a></li>\
                        <li class="dropbox"><a href="#">dropbox</a></li>\
                        <li class="google"><a href="#">google</a></li>\
                        <li class="rss"><a href="#">rss</a></li>\
                        <li class="wordpress"><a href="#">wordpress</a></li>\
                        <li class="apple"><a href="#">apple</a></li>\
                        <li class="yahoo"><a href="#">yahoo</a></li>\
                        <li class="android"><a href="#">android</a></li>\
                        <li class="html5"><a href="#">html5</a></li>\
                        </ul>\
                        [/socialized]\ ';
        }

        if (styleid != 0 && styleid == 'toggle'){
            tagtext = '\
[toggle title="Toggle Title"]Insert your text here[/toggle]\
';
        }

        if (styleid != 0 && styleid == 'h_red' ){
            tagtext = '\
[highlight color="red"]Lorem ipsum[/highlight]\
';
        }
        if (styleid != 0 && styleid == 'h_yellow' ){
            tagtext = '\
[highlight color="yellow"]Lorem ipsum[/highlight]\
';
        }
        if (styleid != 0 && styleid == 'h_black' ){
            tagtext = '\
[highlight color="black"]Lorem ipsum[/highlight]\
';
        }

        if (styleid != 0 && styleid == 'image_left' || styleid == 'image_right' || styleid == 'image_center' ){
            tagtext = "["+ styleid + " link=\"link address here (optional)\"]Insert the Full URL of the image.[/" + styleid + "]";
        }
        if (styleid != 0 && styleid == 'lightbox'){
            tagtext = "["+ styleid + " title=\"lightbox title\" big_image_url=\"Insert Bigger Image's URL here\" video_url=\"Insert Video URL here\" type=\"image\" align=\"left\"]Insert the Full URL of the thumbnail image.[/" + styleid + "]";
        }
        if (styleid != 0 && styleid == 'dropcap1' ){
            tagtext = '\
[dropcap type="dropcap1"]A[/dropcap]\
';
        }
        if (styleid != 0 && styleid == 'dropcap2' ){
            tagtext = '\
[dropcap type="dropcap2"]A[/dropcap]\
';
        }
        if (styleid != 0 && styleid == 'dropcap3' ){
            tagtext = '\
[dropcap type="dropcap3"]A[/dropcap]\
';
        }

        if (styleid != 0 && styleid == 'tabs' ){
            tagtext = "["+ styleid + " tab1=\"Tab 1\" tab2=\"Tab 2\" tab3=\"Tab 3\"]<br /><br />[tab]Tab content 1[/tab]<br />[tab]Tab content 2[/tab]<br />[tab]Tab content 3[/tab]<br /><br />[/" + styleid + "]";
        }
        if (styleid != 0 && styleid == 'accordions' ){
            tagtext = "["+ styleid + "]<br /><br />[accordion title=\"Title 1\"]content 1[/accordion]<br />[accordion title=\"Title 2\"]content 2[/accordion]<br />[accordion title=\"Title 3\"]content 3[/accordion]<br /><br />[/" + styleid + "]";
        }
        if (styleid != 0 && styleid == 'pullquote' ){
            tagtext = "["+ styleid + " cite=\"Insert the cite here\"]Insert the quote here.[/" + styleid + "]";
        }


        if ( styleid == 0 ){
            tinyMCEPopup.close();
        }
    }



    if(window.tinyMCE) {
        //TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
        //Peforms a clean up of the current editor HTML.
        //tinyMCEPopup.editor.execCommand('mceCleanup');
        //Repaints the editor. Sometimes the browser has graphic glitches.
        tinyMCEPopup.editor.execCommand('mceRepaint');
        tinyMCEPopup.close();
    }
    return;
}