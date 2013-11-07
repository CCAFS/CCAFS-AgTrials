<?php

/**
 * help actions.
 *
 * @package    trialsites
 * @subpackage help
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class helpActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

    }

    public function executeHelp(sfWebRequest $request) {

    }

    public function executeContact(sfWebRequest $request) {
        $firstname = sfContext::getInstance()->getRequest()->getParameterHolder()->get('firstname');
        $lastname = sfContext::getInstance()->getRequest()->getParameterHolder()->get('lastname');
        $emailaddress = sfContext::getInstance()->getRequest()->getParameterHolder()->get('emailaddress');
        $phonenumber = sfContext::getInstance()->getRequest()->getParameterHolder()->get('phonenumber');
        $country = sfContext::getInstance()->getRequest()->getParameterHolder()->get('country');
        $message = sfContext::getInstance()->getRequest()->getParameterHolder()->get('message');

        if(isset($firstname) && isset($lastname) && isset($emailaddress) && isset($message)){
            $emailaddress = strtolower($emailaddress);
            $sent = date ("d-M-Y")." ".date("h:i:s");
            //ENVIO DE CORREO
            $destinatario = trim("noreplyagtrials@gmail.com");
            $asunto = "New Contact - Trial Sites - Don't reply";
            $cuerpo = "<html>";
            $cuerpo .= "<head>";
            $cuerpo .= "<title>New Contact - Trial Sites - Don't reply</title>";
            $cuerpo .= "</head>";
            $cuerpo .= "<body>";
            $cuerpo .= "<h1>*** New Contact - Trial Sites - Don't reply ***</h1>";
            $cuerpo .= "<p>";
            $cuerpo .= "<b>First name: </b>$firstname<br>";
            $cuerpo .= "<b>Last name: </b>$lastname<br>";
            $cuerpo .= "<b>Email address: </b>$emailaddress<br>";
            $cuerpo .= "<b>Phone number: </b>$phonenumber<br>";
            $cuerpo .= "<b>Country: </b>$country<br>";
            $cuerpo .= "<b>Message: </b>$message<br>";
            $cuerpo .= "<b>Sent: </b>$sent<br>";
            $cuerpo .= "</p>";
            $cuerpo .= "</body>";
            $cuerpo .= "</html>";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
            if (mail($destinatario, $asunto, $cuerpo, $headers)) {
                echo "<script language='JavaScript'>alert('Thank you for contacting Trial Sites. \\n\\n Your e-mail has been received and will be answered as soon as possible.');</script>";
            } else {
                echo "<script> alert('*** Email Error! ***'); window.history.back();</script>";
                die();
            }
        }
    }

}
