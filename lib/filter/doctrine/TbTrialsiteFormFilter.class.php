<?php

/**
 * TbTrialsite filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialsiteFormFilter extends BaseTbTrialsiteFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_institution' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'order_by' => array('insname', 'asc'), 'add_empty' => true)),
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'order_by' => array('cntname', 'asc'), 'add_empty' => true)),
            'id_location' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbLocation'), 'order_by' => array('lctname', 'asc'), 'add_empty' => true)),
            'trstname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'trstlatitude' => new sfWidgetFormFilterInput(),
            'trstlongitude' => new sfWidgetFormFilterInput(),
            'trstaltitude' => new sfWidgetFormFilterInput(),
            'trstph' => new sfWidgetFormFilterInput(),
            'id_soil' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbSoil'), 'order_by' => array('soiname', 'asc'), 'add_empty' => true)),
            'id_taxonomyfao' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTaxonomyfao'), 'order_by' => array('txnname', 'asc'), 'add_empty' => true)),
            'trststatus' => new sfWidgetFormFilterInput(),
            'trstactive' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
        ));

        $this->setValidators(array(
            'id_institution' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbInstitution'), 'column' => 'id_institution')),
            'id_country' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country')),
            'id_location' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbLocation'), 'column' => 'id_location')),
            'trstname' => new sfValidatorPass(array('required' => false)),
            'trstlatitude' => new sfValidatorPass(array('required' => false)),
            'trstlongitude' => new sfValidatorPass(array('required' => false)),
            'trstaltitude' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
            'trstph' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
            'id_soil' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbSoil'), 'column' => 'id_soil')),
            'id_taxonomyfao' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTaxonomyfao'), 'column' => 'id_taxonomyfao')),
            'trststatus' => new sfValidatorPass(array('required' => false)),
            'trstactive' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
        ));

        $this->widgetSchema->setNameFormat('tb_trialsite_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
