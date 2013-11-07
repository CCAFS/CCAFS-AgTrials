<?php

/**
 * TbTrialsite form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialsiteForm extends BaseTbTrialsiteForm {

    public function configure() {
        if (!($this->isNew)) {
            $this->setOption('url', '');
        }

        // OJO CAMPO NUEVO QUE SE AGREGUE EN EL MODELO SE DEBE REGISTAR AQUI PARA QUE SE PUEDA MOSTAR
        $this->setWidgets(array(
            'id_trialsite' => new sfWidgetFormInputHidden(),
            'id_institution' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbInstitution',
                        'url' => $this->getOption('url') . 'autoinstitution',
                        'method_for_query' => 'findOneByIdInstitution',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 40)),
            'id_country' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbCountry',
                        'url' => $this->getOption('url') . 'autocountry',
                        'method_for_query' => 'findOneByIdCountry',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 40)),
            'id_location' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbLocation',
                        'url' => $this->getOption('url') . 'autolocation',
                        'method_for_query' => 'findOneByIdLocation',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 40)),
            'trstname' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'trstlatitude' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'trstlatitudedecimal' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'trstlongitude' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'trstlongitudedecimal' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'trstaltitude' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'trstph' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'id_soil' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbSoil'), 'add_empty' => true)),
            'id_taxonomyfao' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTaxonomyfao'), 'add_empty' => true)),
            'weatherstation' => new sfWidgetFormInputText(),
            'trstfileaccess' => new sfWidgetFormChoice(array('choices' => array('Open to all users' => "Open to all users", 'Open to specified users' => "Open to specified users", 'Public domain' => 'Public domain'), 'expanded' => true, 'default' => 'Open to all users')),
            'trststatus' => new sfWidgetFormChoice(array('choices' => array('LOW RES' => 'LOW RES', 'PLAUSIBLE' => 'PLAUSIBLE', 'UNLIKELY' => 'UNLIKELY', 'UNSURE' => 'UNSURE', 'CONFIRMED' => 'CONFIRMED', 'SELECTIVE AVAILABILITY' => 'SELECTIVE AVAILABILITY'), 'expanded' => false)),
            'trststatereason' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'id_trialsitetype' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialsitetype'), 'add_empty' => true)),
            'trstactive' => new sfWidgetFormInputCheckbox(),
        ));

        $this->setValidators(array(
            'id_trialsite' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_trialsite')), 'empty_value' => $this->getObject()->get('id_trialsite'), 'required' => false)),
            'id_location' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbLocation'))),
            'id_institution' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'))),
            'id_country' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'))),
            'trstname' => new sfValidatorString(),
            'trstlatitude' => new sfValidatorString(),
            'trstlatitudedecimal' => new sfValidatorString(),
            'trstlongitude' => new sfValidatorString(),
            'trstlongitudedecimal' => new sfValidatorString(),
            'trstaltitude' => new sfValidatorInteger(array('required' => false)),
            'trstph' => new sfValidatorNumber(array('required' => false)),
            'id_soil' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbSoil'), 'required' => false)),
            'id_taxonomyfao' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTaxonomyfao'), 'required' => false)),
            'weatherstation' => new sfValidatorString(array('required' => false)),
            'trstfileaccess' => new sfValidatorString(array('required' => false)),
            'trststatus' => new sfValidatorChoice(array('choices' => array('LOW RES' => 'LOW RES', 'PLAUSIBLE' => 'PLAUSIBLE', 'UNLIKELY' => 'UNLIKELY', 'UNSURE' => 'UNSURE', 'CONFIRMED' => 'CONFIRMED', 'SELECTIVE AVAILABILITY' => 'SELECTIVE AVAILABILITY'))),
            'trststatereason' => new sfValidatorString(),
            'id_trialsitetype' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialsitetype'), 'required' => false)),
            'trstactive' => new sfValidatorBoolean(array('required' => false)),
        ));


        //VALORES POR DEFECTO
        $this->setDefault('trstsupplementalinformationfileaccess', 'None');

        //AYUDA PARA CAMPOS
        $this->widgetSchema->setHelp('trstlatitude', 'Latitude of site. Degree (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South) (e.g. 103020S)');
        $this->widgetSchema->setHelp('trstlongitude', 'Longitude of site. Degree (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West) (e.g. 0762510W)');
        $this->widgetSchema->setHelp('trstaltitude', 'Elevation of site expressed in meters above sea level. Negative values are allowed');


        $this->widgetSchema->setNameFormat('tb_trialsite[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
