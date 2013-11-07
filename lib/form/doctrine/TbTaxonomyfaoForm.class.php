<?php

/**
 * TbTaxonomyfao form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTaxonomyfaoForm extends BaseTbTaxonomyfaoForm {

    public function configure() {
        $this->setWidgets(array(
            'id_taxonomyfao' => new sfWidgetFormInputHidden(),
            'txnname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_taxonomyfao' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_taxonomyfao')), 'empty_value' => $this->getObject()->get('id_taxonomyfao'), 'required' => false)),
            'txnname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_taxonomyfao[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
