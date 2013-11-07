<?php

/**
 * sfGuardUser filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserFormFilter extends PluginsfGuardUserFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'first_name' => new sfWidgetFormFilterInput(),
            'last_name' => new sfWidgetFormFilterInput(),
            'email_address' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'username' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'last_login' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
            'is_active' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
            'is_super_admin' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
            'permissions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
        ));

        $this->setValidators(array(
            'first_name' => new sfValidatorPass(array('required' => false)),
            'last_name' => new sfValidatorPass(array('required' => false)),
            'email_address' => new sfValidatorPass(array('required' => false)),
            'username' => new sfValidatorPass(array('required' => false)),
            'last_login' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
            'is_active' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
            'is_super_admin' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
            'permissions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
        ));

        $this->widgetSchema->setNameFormat('sf_guard_user_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
