<?php

/**
 * TbObjective form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbObjectiveForm extends BaseTbObjectiveForm {

    public function configure() {
        $this->setWidgets(array(
            'id_objective' => new sfWidgetFormInputHidden(),
            'objname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_objective' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_objective')), 'empty_value' => $this->getObject()->get('id_objective'), 'required' => false)),
            'objname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_objective[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
