<?php

/**
 * TbVariablesmeasured form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbVariablesmeasuredForm extends BaseTbVariablesmeasuredForm {

    public function configure() {

        if (!($this->isNew)) {
            $this->setOption('url', '');
        }

        $this->setWidgets(array(
            'id_variablesmeasured' => new sfWidgetFormInputHidden(),
            'id_crop' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbCrop',
                        'url' => $this->getOption('url') . 'autocrop',
                        'method_for_query' => 'findOneByIdCrop',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 30)),
            'id_traitclass' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTraitclass'), 'add_empty' => 'Select One')),
            'vrmsname' => new sfWidgetFormInputText(array(), array('size' => 30)),
            'vrmsshortname' => new sfWidgetFormInputText(array(), array('size' => 30)),
            'vrmsdefinition' => new sfWidgetFormTextarea(),
            'vrmnmethod' => new sfWidgetFormTextarea(),
            'vrmsunit' => new sfWidgetFormInputText(array(), array('size' => 30)),
        ));

        $this->setValidators(array(
            'id_variablesmeasured' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_variablesmeasured')), 'empty_value' => $this->getObject()->get('id_variablesmeasured'), 'required' => false)),
            'id_crop' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'column' => 'id_crop', 'multiple' => false)),
            'id_traitclass' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTraitclass'))),
            'vrmsname' => new sfValidatorString(),
            'vrmsshortname' => new sfValidatorString(),
            'vrmsdefinition' => new sfValidatorString(array('required' => false)),
            'vrmnmethod' => new sfValidatorString(array('required' => false)),
            'vrmsunit' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_variablesmeasured[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
