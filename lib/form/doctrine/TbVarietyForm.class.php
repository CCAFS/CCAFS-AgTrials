<?php

/**
 * TbVariety form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbVarietyForm extends BaseTbVarietyForm {

    public function configure() {

        if (!($this->isNew)) {
            $this->setOption('url', '');
        }
        
        $this->setWidgets(array(
            'id_variety' => new sfWidgetFormInputHidden(),
            'id_crop' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbCrop',
                        'url' => $this->getOption('url') . 'autocrop',
                        'method_for_query' => 'findOneByIdCrop',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 40)),
            'id_origin' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbOrigin',
                        'url' => $this->getOption('url') . 'autoorigin',
                        'method_for_query' => 'findOneByIdOrigin',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 40)),
            'vrtname' => new sfWidgetFormInputText(array(), array('size' => 40)),
            'vrtsynonymous' => new sfWidgetFormTextarea(),
            'vrtdescription' => new sfWidgetFormTextarea(),
        ));

        $this->setValidators(array(
            'id_variety' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_variety')), 'empty_value' => $this->getObject()->get('id_variety'), 'required' => false)),
            'id_crop' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'column' => 'id_crop', 'multiple' => false)),
            'id_origin' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbOrigin'), 'required' => false, 'column' => 'id_origin', 'multiple' => false)),
            'vrtname' => new sfValidatorString(),
            'vrtsynonymous' => new sfValidatorString(array('required' => false)),
            'vrtdescription' => new sfValidatorString(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_variety[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
