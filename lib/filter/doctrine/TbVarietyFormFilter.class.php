<?php

/**
 * TbVariety filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbVarietyFormFilter extends BaseTbVarietyFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_crop' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'add_empty' => true, 'order_by' => array('crpname', 'asc'))),
            'id_origin' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbOrigin'), 'add_empty' => true, 'order_by' => array('orgname', 'asc'))),
            'vrtname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
        ));

        $this->setValidators(array(
            'id_crop' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCrop'), 'column' => 'id_crop')),
            'id_origin' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbOrigin'), 'column' => 'id_origin')),
            'vrtname' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_variety_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }
}
