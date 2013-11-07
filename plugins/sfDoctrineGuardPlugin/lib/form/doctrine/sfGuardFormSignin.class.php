<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardFormSignin extends BasesfGuardFormSignin {

    public function configure() {
        
    }

    public function setup() {
        $this->setWidgets(array(
            'username' => new sfWidgetFormInputText(array(), array('placeholder' => 'Username')),
            'password' => new sfWidgetFormInputPassword(array('type' => 'password'), array('placeholder' => 'Password')),
        ));

        $this->setValidators(array(
            'username' => new sfValidatorString(),
            'password' => new sfValidatorString(),
        ));

        if (sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true)) {
            $this->widgetSchema['username']->setLabel('Username');
        }

        $this->validatorSchema->setPostValidator(new sfGuardValidatorUser());

        $this->widgetSchema->setNameFormat('signin[%s]');
    }

}
