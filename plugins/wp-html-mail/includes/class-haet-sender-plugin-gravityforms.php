<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
*   detect the origin of an email
*
**/
class Haet_Sender_Plugin_GravityForms extends Haet_Sender_Plugin {
    public function __construct($mail) {
        if( !array_key_exists('gform_submit', $_POST) && !array_key_exists( 'gform_send_resume_link', $_POST) && !array_key_exists( 'gf_resend_notifications', $_POST) )
            throw new Haet_Different_Plugin_Exception();
    }



    /**
    *   modify_content()
    *   mofify the email content before applying the template
    **/
    public function modify_content($content){
        if( preg_match('/<body*>(.*)<\/body>/Ums', $content, $matches) ){
            if( is_array( $matches ) )
                $content = $matches[1];
        }

        if( array_key_exists('gform_submit', $_POST) )
            $content = wpautop( $content );
        return $content;
    }

    /**
    *   modify_template()
    *   mofify the email template before the content is added
    **/
    public function modify_template($template){
        return $template;
    } 

    /**
    *   modify_styled_mail()
    *   mofify the email body after the content has been added to the template
    **/
    public function modify_styled_mail($message){
        return $message;
    }  

}