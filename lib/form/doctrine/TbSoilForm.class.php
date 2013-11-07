<?php

/**
 * TbSoil form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbSoilForm extends BaseTbSoilForm {

    public function configure() {
        $this->setWidgets(array(
            'id_soil' => new sfWidgetFormInputHidden(),
            'soiname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_soil' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_soil')), 'empty_value' => $this->getObject()->get('id_soil'), 'required' => false)),
            'soiname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_soil[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
