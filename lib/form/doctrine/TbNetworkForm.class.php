<?php

/**
 * TbNetwork form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbNetworkForm extends BaseTbNetworkForm {

    public function configure() {
        $this->setWidgets(array(
            'id_network' => new sfWidgetFormInputHidden(),
            'ntwname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_network' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_network')), 'empty_value' => $this->getObject()->get('id_network'), 'required' => false)),
            'ntwname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_network[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
