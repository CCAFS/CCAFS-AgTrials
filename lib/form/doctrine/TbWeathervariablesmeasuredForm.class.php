<?php

/**
 * TbWeathervariablesmeasured form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbWeathervariablesmeasuredForm extends BaseTbWeathervariablesmeasuredForm
{
  public function configure()
  {

      $this->setWidgets(array(
      'id_weathervariablesmeasured' => new sfWidgetFormInputHidden(),
      'wtvrmsname'                  => new sfWidgetFormInputText(),
      'wtvrmsshortname'             => new sfWidgetFormInputText(),
      'wtvrmsdefinition'            => new sfWidgetFormTextarea(),
      'wtvrmsunit'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_weathervariablesmeasured' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_weathervariablesmeasured')), 'empty_value' => $this->getObject()->get('id_weathervariablesmeasured'), 'required' => false)),
      'wtvrmsname'                  => new sfValidatorString(),
      'wtvrmsshortname'             => new sfValidatorString(),
      'wtvrmsdefinition'            => new sfValidatorString(array('required' => false)),
      'wtvrmsunit'                  => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('tb_weathervariablesmeasured[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

  }
}
