<?php

/**
 * TbOrigin filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbOriginFormFilter extends BaseTbOriginFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'add_empty' => true, 'order_by' => array('cntname', 'asc'))),
            'orgname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'id_institution' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'add_empty' => true, 'order_by' => array('insname', 'asc'))),
        ));

        $this->setValidators(array(
            'id_country' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country')),
            'orgname' => new sfValidatorPass(array('required' => false)),
            'id_institution' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbInstitution'), 'column' => 'id_institution')),
        ));

        $this->widgetSchema->setNameFormat('tb_origin_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
