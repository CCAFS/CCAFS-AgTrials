<?php

/**
 * TbContactperson filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbContactpersonFormFilter extends BaseTbContactpersonFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_institution' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'add_empty' => true, 'order_by' => array('insname', 'asc'))),
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'add_empty' => true, 'order_by' => array('cntname', 'asc'))),
            'id_contactpersontype' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactpersontype'), 'add_empty' => true, 'order_by' => array('ctprtpname', 'asc'))),
            'cnprfirstname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'cnprlastname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'cnpraddress' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'cnprphone' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'cnpremail' => new sfWidgetFormFilterInput(array('with_empty' => false)),
        ));

        $this->setValidators(array(
            'id_institution' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbInstitution'), 'column' => 'id_institution')),
            'id_country' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country')),
            'id_contactpersontype' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbContactpersontype'), 'column' => 'id_contactpersontype')),
            'cnprfirstname' => new sfValidatorPass(array('required' => false)),
            'cnprlastname' => new sfValidatorPass(array('required' => false)),
            'cnpraddress' => new sfValidatorPass(array('required' => false)),
            'cnprphone' => new sfValidatorPass(array('required' => false)),
            'cnpremail' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_contactperson_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
