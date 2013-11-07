<?php

/**
 * TbTrialenvironmenttype form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialenvironmenttypeForm extends BaseTbTrialenvironmenttypeForm {

    public function configure() {
        $this->setWidgets(array(
            'id_trialenvironmenttype' => new sfWidgetFormInputHidden(),
            'trnvtyname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_trialenvironmenttype' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_trialenvironmenttype')), 'empty_value' => $this->getObject()->get('id_trialenvironmenttype'), 'required' => false)),
            'trnvtyname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_trialenvironmenttype[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
