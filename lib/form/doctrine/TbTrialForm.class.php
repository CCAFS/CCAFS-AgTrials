<?php

/**
 * TbTrial form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialForm extends BaseTbTrialForm {

    public function configure() {
        if (!($this->isNew)) {
            $this->setOption('url', '');
        }
        $range = range(1950, date('Y'));
        $years = array_combine($range, $range);

        // OJO CAMPO NUEVO QUE SE AGREGUE EN EL MODELO SE DEBE REGISTAR AQUI PARA QUE SE PUEDA MOSTAR
        $this->setWidgets(array(
            'id_trial' => new sfWidgetFormInputHidden(),
            'id_trialgroup' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                'model' => 'TbTrialgroup',
                'url' => $this->getOption('url') . 'autotrialgroup',
                'method_for_query' => 'findOneByIdTrialgroup',
                'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}',
                    ), array('size' => 40)),
            'trlname' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'id_contactperson' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                'model' => 'TbContactperson',
                'url' => $this->getOption('url') . 'autocontactperson',
                'method_for_query' => 'findOneByIdContactperson',
                'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}',
                    ), array('size' => 40)),
            'id_country' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                'model' => 'TbCountry',
                'url' => $this->getOption('url') . 'autocountry',
                'method_for_query' => 'findOneByIdCountry',
                'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ), array('size' => 40)),
            'id_trialsite' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                'model' => 'TbTrialsite',
                'url' => $this->getOption('url') . 'autotrialsite',
                'method_for_query' => 'findOneByIdTrialsite',
                'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}',
                    ), array('size' => 40)),
            'id_fieldnamenumber' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbFieldnamenumber'), 'add_empty' => true)),
            'trlsowdate' => new sfWidgetFormInputText(array(), array('size' => 11)),
            'trlharvestdate' => new sfWidgetFormInputText(array(), array('size' => 11)),
            'trlirrigation' => new sfWidgetFormChoice(array('choices' => array('N/A' => 'N/A', 'No' => 'No', 'Yes' => 'Yes'), 'expanded' => true, 'default' => 'N/A')),
            'id_crop' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                'model' => 'TbCrop',
                'url' => $this->getOption('url') . 'autocrop',
                'method_for_query' => 'findOneByIdCrop',
                'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ), array('size' => 40)),
            'trlreplications' => new sfWidgetFormChoice(array('choices' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15'), 'expanded' => false, 'default' => '1')),
            'trlvarieties' => new sfWidgetFormTextarea(array(), array('readonly' => 'readonly')),
            'trlvariablesmeasured' => new sfWidgetFormTextarea(array(), array('readonly' => 'readonly')),
            'trltrialresultsfile' => new sfWidgetFormInputFileEditable(array('label' => 'Load file trial results', 'file_src' => $this->getObject()->getTrltrialresultsfile())),
            'trlsupplementalinformationfile' => new sfWidgetFormInputFileEditable(array('label' => 'Load file supplemental information', 'file_src' => $this->getObject()->getTrlsupplementalinformationfile())),
            'trlweatherduringtrialfile' => new sfWidgetFormInputFileEditable(array('label' => 'Load file weather during the trial', 'file_src' => $this->getObject()->getTrlweatherduringtrialfile())),
            'trlsoiltypeconditionsduringtrialfile' => new sfWidgetFormInputFileEditable(array('label' => 'Load file soil type and/or conditions during trial', 'file_src' => $this->getObject()->getTrlsoiltypeconditionsduringtrialfile())),
            'trllicense' => new sfWidgetFormTextarea(),
            'trlfileaccess' => new sfWidgetFormChoice(array('choices' => array('Open to all users' => "Open to all users", 'Open to specified users' => "Open to specified users", 'Open to specified groups' => "Open to specified groups", 'Public domain' => 'Public domain'), 'expanded' => true, 'default' => 'Open to all users')),
            'trltrialtype' => new sfWidgetFormChoice(array('choices' => array('Real' => 'Real', 'Simulated' => 'Simulated'), 'expanded' => true, 'default' => 'Real')),
        ));

        $this->setValidators(array(
            'id_trial' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_trial')), 'empty_value' => $this->getObject()->get('id_trial'), 'required' => false)),
            'id_trialgroup' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgroup'))),
            'trlname' => new sfValidatorString(array('required' => true)),
            'id_contactperson' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactperson'), 'column' => 'id_contactperson', 'multiple' => false)),
            'id_country' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country', 'multiple' => false)),
            'id_trialsite' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialsite'), 'column' => 'id_trialsite', 'multiple' => false)),
            'id_fieldnamenumber' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbFieldnamenumber'), 'required' => false)),
            'trlsowdate' => new sfValidatorString(array('required' => false)),
            'trlharvestdate' => new sfValidatorString(array('required' => false)),
            'trlirrigation' => new sfValidatorString(array('required' => false)),
            'id_crop' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'column' => 'id_crop', 'multiple' => false, 'required' => true)),
            'trlreplications' => new sfValidatorString(array('required' => false)),
            'trlvarieties' => new sfValidatorString(array('required' => false)),
            'trlvariablesmeasured' => new sfValidatorString(array('required' => false)),
            'trltrialresultsfile' => new sfValidatorFile(
                    array(
                'required' => false,
                'max_size' => '10485760',
                'path' => sfConfig::get('sf_upload_dir'),
                'mime_types' => array(
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/excel',
                    'application/vnd.ms-excel',
                    'application/x-excel',
                    'application/x-msexcel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/mspowerpoint',
                    'application/powerpoint',
                    'application/vnd.ms-powerpoint',
                    'application/x-mspowerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/pdf',
                    'application/x-compressed',
                    'application/x-zip-compressed',
                    'application/zip',
                    'multipart/x-zip')), array(
                'invalid' => 'Invalid file.',
                'required' => 'Select a file to upload.',
                'mime_types' => 'The file must be of .doc, .xls, .ppt, pdf and .zip format.',
                'max_size' => 'Invalid file max size 10 MB')),
            'trlsupplementalinformationfile' => new sfValidatorFile(
                    array(
                'required' => false,
                'max_size' => '10485760',
                'path' => sfConfig::get('sf_upload_dir'),
                'mime_types' => array(
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/excel',
                    'application/vnd.ms-excel',
                    'application/x-excel',
                    'application/x-msexcel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/mspowerpoint',
                    'application/powerpoint',
                    'application/vnd.ms-powerpoint',
                    'application/x-mspowerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/pdf',
                    'application/x-compressed',
                    'application/x-zip-compressed',
                    'application/zip',
                    'multipart/x-zip')), array(
                'invalid' => 'Invalid file.',
                'required' => 'Select a file to upload.',
                'mime_types' => 'The file must be of .doc, .xls, .ppt, pdf and .zip format.',
                'max_size' => 'Invalid file max size 10 MB')),
            'trlweatherduringtrialfile' => new sfValidatorFile(
                    array(
                'required' => false,
                'max_size' => '10485760',
                'path' => sfConfig::get('sf_upload_dir'),
                'mime_types' => array(
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/excel',
                    'application/vnd.ms-excel',
                    'application/x-excel',
                    'application/x-msexcel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/mspowerpoint',
                    'application/powerpoint',
                    'application/vnd.ms-powerpoint',
                    'application/x-mspowerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/pdf',
                    'application/x-compressed',
                    'application/x-zip-compressed',
                    'application/zip',
                    'multipart/x-zip')), array(
                'invalid' => 'Invalid file.',
                'required' => 'Select a file to upload.',
                'mime_types' => 'The file must be of .doc, .xls, .ppt, pdf and .zip format.',
                'max_size' => 'Invalid file max size 10 MB')),
            'trlsoiltypeconditionsduringtrialfile' => new sfValidatorFile(
                    array(
                'required' => false,
                'max_size' => '10485760',
                'path' => sfConfig::get('sf_upload_dir'),
                'mime_types' => array(
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/excel',
                    'application/vnd.ms-excel',
                    'application/x-excel',
                    'application/x-msexcel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/mspowerpoint',
                    'application/powerpoint',
                    'application/vnd.ms-powerpoint',
                    'application/x-mspowerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/pdf',
                    'application/x-compressed',
                    'application/x-zip-compressed',
                    'application/zip',
                    'multipart/x-zip')), array(
                'invalid' => 'Invalid file.',
                'required' => 'Select a file to upload.',
                'mime_types' => 'The file must be of .doc, .xls, .ppt, pdf and .zip format.',
                'max_size' => 'Invalid file max size 10 MB')),
            'trllicense' => new sfValidatorString(array('required' => false)),
            'trlfileaccess' => new sfValidatorString(array('required' => false)),
            'trltrialtype' => new sfValidatorString(array('required' => false)),
        ));

        //ID que viene del modulo Trial Group
        $id_trialgroup = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_trialgroup');
        $this->setDefault('id_trialgroup', $id_trialgroup);
        $this->setDefault('trltrialrecorddate', date('Y/m/d'));


        $this->validatorSchema->setPostValidator(
                new sfValidatorCallback(
                array('callback' => array($this, 'validarLicencia'))
                )
        );


        $this->widgetSchema->setNameFormat('tb_trial[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

    public function validarLicencia(sfValidatorBase $validator, array $values) {
        if (($values['trltrialresultsfileaccess'] == 'Private') && ($values['trllicense'] == '')) {
            throw new sfValidatorError($validator, '* License Required');
        } elseif (($values['trltrialresultsfileaccess'] == 'Private') && ($values['trllicense'] != '')) {
            $textoevaluar = '<a rel="license" href="http://creativecommons.org/licenses';
            $textolicencia = trim($values['trllicense']);
            if (!(strstr($textolicencia, $textoevaluar))) {
                throw new sfValidatorError($validator, '* Invalid License');
            }
        }
        return $values;
    }

}