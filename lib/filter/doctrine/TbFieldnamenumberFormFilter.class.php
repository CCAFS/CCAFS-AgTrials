<?php

/**
 * TbFieldnamenumber filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbFieldnamenumberFormFilter extends BaseTbFieldnamenumberFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_trialsite' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialsite'), 'add_empty' => true, 'order_by' => array('trstname', 'asc'))),
            'id_trialenvironmenttype' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialenvironmenttype'), 'add_empty' => true, 'order_by' => array('trnvtyname', 'asc'))),
            'trialenvironmentname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'finanulatitudedecimal' => new sfWidgetFormFilterInput(),
            'finanulongitudedecimal' => new sfWidgetFormFilterInput(),
            'finanualtitude' => new sfWidgetFormFilterInput(),
            'finanuph' => new sfWidgetFormFilterInput(),
            'id_soil' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbSoil'), 'add_empty' => true, 'order_by' => array('soiname', 'asc'))),
            'id_taxonomyfao' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTaxonomyfao'), 'add_empty' => true, 'order_by' => array('txnname', 'asc'))),
        ));

        $this->setValidators(array(
            'id_trialsite' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTrialsite'), 'column' => 'id_trialsite')),
            'id_trialenvironmenttype' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTrialenvironmenttype'), 'column' => 'id_trialenvironmenttype')),
            'trialenvironmentname' => new sfValidatorPass(array('required' => false)),
            'finanulatitudedecimal' => new sfValidatorPass(array('required' => false)),
            'finanulongitudedecimal' => new sfValidatorPass(array('required' => false)),
            'finanualtitude' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
            'finanuph' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
            'id_soil' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbSoil'), 'column' => 'id_soil')),
            'id_taxonomyfao' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTaxonomyfao'), 'column' => 'id_taxonomyfao')),
        ));

        $this->widgetSchema->setNameFormat('tb_fieldnamenumber_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
