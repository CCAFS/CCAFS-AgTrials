<?php

/**
 * TbTrialgrouptype form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialgrouptypeForm extends BaseTbTrialgrouptypeForm {

    public function configure() {
        $this->setWidgets(array(
            'id_trialgrouptype' => new sfWidgetFormInputHidden(),
            'trgptyname' => new sfWidgetFormInput()
        ));

        $this->setValidators(array(
            'id_trialgrouptype' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_trialgrouptype')), 'empty_value' => $this->getObject()->get('id_trialgrouptype'), 'required' => false)),
            'trgptyname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_trialgrouptype[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
