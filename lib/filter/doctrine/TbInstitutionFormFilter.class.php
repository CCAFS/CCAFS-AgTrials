<?php

/**
 * TbInstitution filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbInstitutionFormFilter extends BaseTbInstitutionFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'add_empty' => true, 'order_by' => array('cntname', 'asc'))),
            'insname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'insaddress' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'insphone' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'insfax' => new sfWidgetFormFilterInput(),
            'insemail' => new sfWidgetFormFilterInput(),
            'inswebsite' => new sfWidgetFormFilterInput(),
        ));

        $this->setValidators(array(
            'id_country' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country')),
            'insname' => new sfValidatorPass(array('required' => false)),
            'insaddress' => new sfValidatorPass(array('required' => false)),
            'insphone' => new sfValidatorPass(array('required' => false)),
            'insfax' => new sfValidatorPass(array('required' => false)),
            'insemail' => new sfValidatorPass(array('required' => false)),
            'inswebsite' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_institution_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
