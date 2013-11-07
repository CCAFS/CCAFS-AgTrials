<?php

/**
 * TbWeatherstation form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbWeatherstationForm extends BaseTbWeatherstationForm {

    public function configure() {
        $this->setWidgets(array(
            'id_weatherstation' => new sfWidgetFormInputHidden(),
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'add_empty' => true)),
            'id_institution' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'add_empty' => true)),
            'id_contactperson' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactperson'), 'add_empty' => true)),
            'wtstname' => new sfWidgetFormInputText(),
            'wtstlatitude' => new sfWidgetFormInputText(),
            'wtstlongitude' => new sfWidgetFormInputText(),
            'wtstelevation' => new sfWidgetFormInputText(),
            'wtstrestricted' => new sfWidgetFormChoice(array('choices' => array('NO' => "NO", 'YES' => "YES"), 'expanded' => true, 'default' => 'NO')),
            'wtstlicence' => new sfWidgetFormTextarea(),
            'id_weatherstationsource' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbWeatherstationsource'), 'add_empty' => true)),
        ));

        $this->setValidators(array(
            'id_weatherstation' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_weatherstation')), 'empty_value' => $this->getObject()->get('id_weatherstation'), 'required' => false)),
            'id_country' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'))),
            'id_institution' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'required' => false)),
            'id_contactperson' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactperson'), 'required' => false)),
            'wtstname' => new sfValidatorString(),
            'wtstlatitude' => new sfValidatorString(),
            'wtstlongitude' => new sfValidatorString(),
            'wtstelevation' => new sfValidatorInteger(),
            'wtstrestricted' => new sfValidatorString(array('required' => false)),
            'wtstlicence' => new sfValidatorString(array('required' => false)),
            'id_weatherstationsource' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbWeatherstationsource'))),
        ));

        $this->widgetSchema->setNameFormat('tb_weatherstation[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
