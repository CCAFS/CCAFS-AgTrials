<?php

/**
 * TbMeteorologicalfields form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbMeteorologicalfieldsForm extends BaseTbMeteorologicalfieldsForm {

    public function configure() {
        $this->setWidgets(array(
            'id_meteorologicalfields' => new sfWidgetFormInputHidden(),
            'mtflname' => new sfWidgetFormInputText(),
            'mtfldescription' => new sfWidgetFormTextarea(),
            'mtflsynonyms' => new sfWidgetFormTextarea(),
            'mtflunit' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_meteorologicalfields' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_meteorologicalfields')), 'empty_value' => $this->getObject()->get('id_meteorologicalfields'), 'required' => false)),
            'mtflname' => new sfValidatorString(),
            'mtfldescription' => new sfValidatorString(),
            'mtflsynonyms' => new sfValidatorString(array('required' => false)),
            'mtflunit' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_meteorologicalfields[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
