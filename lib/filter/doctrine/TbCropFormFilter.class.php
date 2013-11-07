<?php

/**
 * TbCrop filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbCropFormFilter extends BaseTbCropFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'crpname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'crpscientificname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
        ));

        $this->setValidators(array(
            'crpname' => new sfValidatorPass(array('required' => false)),
            'crpscientificname' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_crop_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
