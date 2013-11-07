<?php

/**
 * TbTrial filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialFormFilter extends BaseTbTrialFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_trialgroup' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgroup'), 'add_empty' => true)),
            'id_contactperson' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactperson'), 'add_empty' => true)),
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'add_empty' => true)),
            'id_trialsite' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialsite'), 'add_empty' => true)),
            'trlname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'id_crop' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'add_empty' => true)),
            'trlvarieties' => new sfWidgetFormFilterInput(),
            'trlvariablesmeasured' => new sfWidgetFormFilterInput(),
            'trltrialrecorddate' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
        ));

        $this->setValidators(array(
            'id_trialgroup' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTrialgroup'), 'column' => 'id_trialgroup')),
            'id_contactperson' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbContactperson'), 'column' => 'id_contactperson')),
            'id_country' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country')),
            'id_trialsite' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTrialsite'), 'column' => 'id_trialsite')),
            'trlname' => new sfValidatorPass(array('required' => false)),
            'id_crop' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCrop'), 'column' => 'id_crop')),
            'trlvarieties' => new sfValidatorPass(array('required' => false)),
            'trlvariablesmeasured' => new sfValidatorPass(array('required' => false)),
            'trltrialrecorddate' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
        ));

        $this->widgetSchema->setNameFormat('tb_trial_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
