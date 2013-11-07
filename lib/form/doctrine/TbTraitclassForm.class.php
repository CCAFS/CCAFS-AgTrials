<?php

/**
 * TbTraitclass form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTraitclassForm extends BaseTbTraitclassForm {

    public function configure() {

        $this->setWidgets(array(
            'id_traitclass' => new sfWidgetFormInputHidden(),
            'trclname' => new sfWidgetFormInputText(),
            'created_at' => new sfWidgetFormDateTime(),
            'updated_at' => new sfWidgetFormDateTime(),
        ));

        $this->setValidators(array(
            'id_traitclass' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_traitclass')), 'empty_value' => $this->getObject()->get('id_traitclass'), 'required' => false)),
            'trclname' => new sfValidatorString(),
            'created_at' => new sfValidatorDateTime(),
            'updated_at' => new sfValidatorDateTime(),
        ));

        $this->widgetSchema->setNameFormat('tb_traitclass[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();

        unset($this['created_at'], $this['updated_at']);
    }

}
