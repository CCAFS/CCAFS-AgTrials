<?php

/**
 * TbCrop form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbCropForm extends BaseTbCropForm {

    public function configure() {
        $this->setWidgets(array(
            'id_crop' => new sfWidgetFormInputHidden(),
            'crpname' => new sfWidgetFormInputText(),
            'crpscientificname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_crop' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_crop')), 'empty_value' => $this->getObject()->get('id_crop'), 'required' => false)),
            'crpname' => new sfValidatorString(),
            'crpscientificname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_crop[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
