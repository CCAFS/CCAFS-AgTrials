<?php

/**
 * TbCountry form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbCountryForm extends BaseTbCountryForm {

    public function configure() {
        $this->setWidgets(array(
            'id_country' => new sfWidgetFormInputHidden(),
            'cntname' => new sfWidgetFormInputText(),
            'cntiso' => new sfWidgetFormInputText(),
            'cntiso3' => new sfWidgetFormInputText(),
            'cntnumcode' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_country' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_country')), 'empty_value' => $this->getObject()->get('id_country'), 'required' => false)),
            'cntname' => new sfValidatorString(),
            'cntiso' => new sfValidatorString(array('required' => false)),
            'cntiso3' => new sfValidatorString(array('required' => false)),
            'cntnumcode' => new sfValidatorInteger(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_country[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
