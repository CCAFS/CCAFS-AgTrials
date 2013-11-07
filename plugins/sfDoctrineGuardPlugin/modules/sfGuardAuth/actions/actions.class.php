<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__) . '/../lib/BasesfGuardAuthActions.class.php');

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions {

    public function executeForgotpassword(sfWebRequest $request) {
        $emailaddress = sfContext::getInstance()->getRequest()->getParameterHolder()->get('emailaddress');
        if (isset($emailaddress)) {
            $emailaddress = strtolower(trim($emailaddress));
            $sf_guard_user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($emailaddress);
            if (count($sf_guard_user) > 1) {
                $Username = $sf_guard_user->username;
                $cadena = "[^A-Z0-9]";
                $newpassword = substr(eregi_replace($cadena, "", md5(rand())) . eregi_replace($cadena, "", md5(rand())) . eregi_replace($cadena, "", md5(rand())), 0, 6);
                $sf_guard_user->setPassword($newpassword);
                $sf_guard_user->save();

                //ENVIO DE CORREO
                $destinatario = trim($emailaddress);
                $asunto = "Trial Sites Account Notification - New Password - Don't reply";
                $cuerpo = "<html>";
                $cuerpo .= "<head>";
                $cuerpo .= "<title>Trial Sites Account Notification - New Password - Don't reply</title>";
                $cuerpo .= "</head>";
                $cuerpo .= "<body>";
                $cuerpo .= "<h1>Trial Sites Account Notification - New Password - Don't reply!</h1>";
                $cuerpo .= "<p>";
                $cuerpo .= "<b>Username: </b>$Username<br> <b>New Password: </b>$newpassword<br><br><a href='http://www.agtrials.org/login' target='blank'>www.agtrials.org</a><br><br><b>Please remember to change your password. After you login: ADMIN>>CHANGE PASSWORD</b>";
                $cuerpo .= "</p>";
                $cuerpo .= "</body>";
                $cuerpo .= "</html>";
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
                if (mail($destinatario, $asunto, $cuerpo, $headers)) {
                    echo "<script language='JavaScript'>alert('***The Username and Password sent at email: $emailaddress ***');</script>";
                    $this->getUser()->setAuthenticated(false);
                    $this->redirect('/login');
                } else {
                    echo "<script> alert('*** Email Error! ***'); window.history.back();</script>";
                    die();
                }
            } else {
                echo "<script> alert('*** Incorrect Email address! ***'); window.history.back();</script>";
            }
        }
    }

}
