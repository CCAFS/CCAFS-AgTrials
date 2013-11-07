<?php

/**
 * TbFieldnamenumber form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbFieldnamenumberForm extends BaseTbFieldnamenumberForm {

    public function configure() {
        if (!($this->isNew)) {
            $this->setOption('url', '');
        }

        // OJO CAMPO NUEVO QUE SE AGREGUE EN EL MODELO SE DEBE REGISTAR AQUI PARA QUE SE PUEDA MOSTAR
        $this->setWidgets(array(
            'id_fieldnamenumber' => new sfWidgetFormInputHidden(),
            'id_trialsite' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbTrialsite',
                        'url' => $this->getOption('url') . 'autotrialsite',
                        'method_for_query' => 'findOneByIdTrialsite',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}',
                    ),
                    array('size' => 40)),
            'id_trialenvironmenttype' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialenvironmenttype'), 'add_empty' => 'Select One')),
            'trialenvironmentname' => new sfWidgetFormInput(array(), array('size' => 30)),
            'finanulatitude' => new sfWidgetFormInput(array(), array('size' => 30)),
            'finanulatitudedecimal' => new sfWidgetFormInput(array(), array('size' => 30)),
            'finanulongitude' => new sfWidgetFormInput(array(), array('size' => 30)),
            'finanulongitudedecimal' => new sfWidgetFormInput(array(), array('size' => 30)),
            'finanualtitude' => new sfWidgetFormInput(array(), array('size' => 30)),
            'finanuph' => new sfWidgetFormInput(array(), array('size' => 30)),
            'id_soil' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbSoil'), 'add_empty' => 'Select One')),
            'id_taxonomyfao' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTaxonomyfao'), 'add_empty' => 'Select One')),
        ));

        $this->setValidators(array(
            'id_fieldnamenumber' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_fieldnamenumber')), 'empty_value' => $this->getObject()->get('id_fieldnamenumber'), 'required' => false)),
            'id_trialsite' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialsite'))),
            'id_trialenvironmenttype' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialenvironmenttype'))),
            'trialenvironmentname' => new sfValidatorString(),
            'finanulatitude' => new sfValidatorString(array('required' => false)),
            'finanulatitudedecimal' => new sfValidatorString(array('required' => false)),
            'finanulongitude' => new sfValidatorString(array('required' => false)),
            'finanulongitudedecimal' => new sfValidatorString(array('required' => false)),
            'finanualtitude' => new sfValidatorInteger(array('required' => false)),
            'finanuph' => new sfValidatorNumber(array('required' => false)),
            'id_soil' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbSoil'), 'required' => false)),
            'id_taxonomyfao' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTaxonomyfao'), 'required' => false)),
        ));

        //AYUDA PARA CAMPOS
        $this->widgetSchema->setHelp('finanulatitude', 'Latitude of site. Degree (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South) (e.g. 103020S)');
        $this->widgetSchema->setHelp('finanulongitude', 'Longitude of site. Degree (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West) (e.g. 0762510W)');
        $this->widgetSchema->setHelp('finanualtitude', 'Elevation of site expressed in meters above sea level. Negative values are allowed');

        $this->widgetSchema->setNameFormat('tb_fieldnamenumber[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
