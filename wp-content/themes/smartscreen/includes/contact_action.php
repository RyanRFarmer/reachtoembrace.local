<?php
global $data;
if(isset($_POST['sendContact'])){

    // ENTER YOUR EMAIL HERE
     $to_email = $data['contact_email_address'];

    $hasError = 'false';
    if(trim($_POST['fullname']) == '') {
        $hasError = "true";
        $error = __('Please enter your name.','highthemes');
        echo "
        <div class=\"info-box-wrapper\">
            <div class=\"info-box-red-header info-box-warning\">
                <div class=\"info-content-box-icon\">$error</div>
            </div>
        </div>
        ";
        exit;

    } else {
        $name = trim($_POST['fullname']);
    }

    if(trim($_POST['email']) == '')  {
        $hasError = "true";
        $error = __('Please enter email address.','highthemes');
        echo "
        <div class=\"info-box-wrapper\">
            <div class=\"info-box-red-header info-box-warning\">
                <div class=\"info-content-box-icon\">$error</div>
            </div>
        </div>
        ";
        exit;


    } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/',strtolower(trim($_POST['email'])))) {
        $hasError = "true";
        $error = __('Please enter your valid email address.','highthemes');
        echo "
        <div class=\"info-box-wrapper\">
            <div class=\"info-box-red-header info-box-warning\">
                <div class=\"info-content-box-icon\">$error</div>
            </div>
        </div>
        ";
        exit;

    } else {
        $email = trim($_POST['email']);
    }
    if($data['disable_captcha'] !="1") {
        if(trim($_POST['captcha']) == '') {
            $hasError = "true";
            $error = __('Please enter captcha.','highthemes');
            echo "
            <div class=\"info-box-wrapper\">
                <div class=\"info-box-red-header info-box-warning\">
                    <div class=\"info-content-box-icon\">$error</div>
                </div>
            </div>
            ";
            exit;
        } elseif (trim($_POST['captcha']) != $_SESSION['seccode']) {
            $hasError = "true";
            $error = __('Please enter captcha correctly','highthemes');
            echo "
            <div class=\"info-box-wrapper\">
                <div class=\"info-box-red-header info-box-warning\">
                    <div class=\"info-content-box-icon\">$error</div>
                </div>
            </div>
            ";
            exit;
        }
    }

    if(trim($_POST['form_message']) == '') {
        $hasError = "true";
        $error = __('Please enter your message.','highthemes');
        echo "
        <div class=\"info-box-wrapper\">
            <div class=\"info-box-red-header info-box-warning\">
                <div class=\"info-content-box-icon\">$error</div>
            </div>
        </div>
        ";
        exit;

    } else {

            $comment = stripslashes(trim($_POST['form_message']));

    }
    if(isset($_POST['url'])) $website = stripslashes(trim($_POST['url']));


    if($hasError!="true") {


        $e_date    = date( 'Y/m/d - h:i A', time() );
        $e_subject = ''.__('New Message By','highthemes'	).' ' . $name . ' '.__('on','highthemes').' ' . $e_date . '';
        $e_body    = $name . __(" has contacted you",'highthemes') ."\r\n\n";
        $e_body .= __("Comment: ",'highthemes') . $comment ." \r\n\n";
        $e_body .= __("Email: ",'highthemes') .  $email . " \r\n\n";
        $e_body .= __("website: ",'highthemes') . $website ." \r\n\n";
        $msg = $e_body;

     mail( $to_email, $e_subject, $msg, "From: $email\r\nReply-To: $email\r\nReturn-Path: $email\r\n" );

     echo "";
     echo '<div class="info-box-wrapper success">
            <div class="info-box-green-header">
            <div class="info-content-box">'.__("Message Sent Successfully!",'highthemes').' </div>
            </div>
            <div class="info-box-green-body">
            <div class="info-content-box">';
     echo __("Thank you ",'highthemes') . "<strong>$name</strong>, " . __("your message has been submitted to us.",'highthemes') ."";
     echo '</div>
            </div>
            </div>';
        exit;
    }
}
?>