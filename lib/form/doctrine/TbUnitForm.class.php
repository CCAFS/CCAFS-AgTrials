<?php

/**
 * TbUnit form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbUnitForm extends BaseTbUnitForm
{
  public function configure()
  {
      $this->setWidgets(array(
      'id_unit'        => new sfWidgetFormInputHidden(),
      'untname'        => new sfWidgetFormInputText(),
      'untdescription' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_unit'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_unit')), 'empty_value' => $this->getObject()->get('id_unit'), 'required' => false)),
      'untname'        => new sfValidatorString(),
      'untdescription' => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('tb_unit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();
  }
}
