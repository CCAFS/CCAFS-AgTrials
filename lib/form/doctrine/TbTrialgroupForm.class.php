<?php

/**
 * TbTrialgroup form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialgroupForm extends BaseTbTrialgroupForm {

    public function configure() {

        if (!($this->isNew)) {
            $this->setOption('url', '');
        } else {
            $usuario = sfContext::getInstance()->getUser()->getName();
        }
        $range = range(1990, date('Y'));
        $years = array_combine($range, $range);

        $this->setWidgets(array(
            'id_trialgroup' => new sfWidgetFormInputHidden(),
            'id_institution' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbInstitution',
                        'url' => $this->getOption('url') . 'autoinstitution',
                        'method_for_query' => 'findOneByIdInstitution',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: " - ",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 30)),
            'id_contactperson' => new sfWidgetFormInputText(array(), array('size' => 30)),
            'id_trialgrouptype' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgrouptype'), 'add_empty' => 'Select One')),
            'id_objective' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbObjective'), 'add_empty' => 'Select One')),
            'id_primarydiscipline' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbPrimarydiscipline'), 'add_empty' => 'Select One')),
            'trgrname' => new sfWidgetFormInputText(array(), array('size' => 30)),
            'trgrstartyear' => new sfWidgetFormInputText(array(), array('size' => 5, 'maxlength' => 4)),
            'trgrendyear' => new sfWidgetFormInputText(array(), array('size' => 5, 'maxlength' => 4)),
            'trgrtrialgrouprecorddate' => new sfWidgetFormJQueryDate(array(
                'image' => dirname($_SERVER['SCRIPT_NAME']) . '/images/calendar-icon.png',
                'culture' => 'fr',
                'date_widget' => new sfWidgetFormDate(array(
                    'format' => '%day%%month%%year%',
                    'years' => $years))
            )),
            'trgrtrialgrouprecordstatus' => new sfWidgetFormChoice(array('choices' => array('Open' => 'Open', 'Closed' => 'Closed', 'Inactive' => 'Inactive', 'Canceled' => 'Canceled'))),
            'id_user' => new sfWidgetFormInputHidden(),
            'id_user_update' => new sfWidgetFormInputHidden(),
        ));

        $this->setValidators(array(
            'id_trialgroup' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_trialgroup')), 'empty_value' => $this->getObject()->get('id_trialgroup'), 'required' => false)),
            'id_institution' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'column' => 'id_institution', 'multiple' => false)),
            'id_contactperson' => new sfValidatorString(array('required' => false)),
            'id_trialgrouptype' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgrouptype'))),
            'id_objective' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbObjective'))),
            'id_primarydiscipline' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbPrimarydiscipline'))),
            'trgrname' => new sfValidatorString(),
            'trgrstartyear' => new sfValidatorInteger(),
            'trgrendyear' => new sfValidatorInteger(),
            'trgrtrialgrouprecorddate' => new sfValidatorDate(),
            'trgrtrialgrouprecordstatus' => new sfValidatorString(),
            'id_user' => new sfValidatorString(array('required' => false)),
            'id_user_update' => new sfValidatorString(array('required' => false)),
        ));

        $this->setDefault('trgrtrialgrouprecorddate', date('Y/m/d'));

        $this->widgetSchema->setNameFormat('tb_trialgroup[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
