<?php

/**
 * TbInstitutionnetwork form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbInstitutionnetworkForm extends BaseTbInstitutionnetworkForm {

    public function configure() {
        $this->setWidgets(array(
            'id_institutionnetwork' => new sfWidgetFormInputHidden(),
            'id_institution' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'add_empty' => 'Select One')),
            'id_network' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbNetwork'), 'add_empty' => 'Select One')),
        ));

        $this->setValidators(array(
            'id_institutionnetwork' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_institutionnetwork')), 'empty_value' => $this->getObject()->get('id_institutionnetwork'), 'required' => false)),
            'id_institution' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'))),
            'id_network' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbNetwork'))),
        ));

        $this->widgetSchema->setNameFormat('tb_institutionnetwork[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
