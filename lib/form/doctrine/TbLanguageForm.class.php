<?php

/**
 * TbLanguage form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbLanguageForm extends BaseTbLanguageForm {

    public function configure() {
        $this->setWidgets(array(
            'id_language' => new sfWidgetFormInputHidden(),
            'lngname' => new sfWidgetFormInputText(),
            'lngcode' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_language' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_language')), 'empty_value' => $this->getObject()->get('id_language'), 'required' => false)),
            'lngname' => new sfValidatorString(),
            'lngcode' => new sfValidatorString(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_language[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
