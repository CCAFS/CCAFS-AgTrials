<?php

/**
 * TbLocation form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbLocationForm extends BaseTbLocationForm {

    public function configure() {
        if (!($this->isNew)) {
            $this->setOption('url', '');
        }

        $this->setWidgets(array(
            'id_location' => new sfWidgetFormInputHidden(),
            'id_country' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbCountry',
                        'url' => $this->getOption('url') . 'autocountry',
                        'method_for_query' => 'findOneByIdCountry',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ),
                    array('size' => 40)),
            'lctname' => new sfWidgetFormInputText(array(), array('size' => 40)),
        ));

        $this->setValidators(array(
            'id_location' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_location')), 'empty_value' => $this->getObject()->get('id_location'), 'required' => false)),
            'id_country' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'))),
            'lctname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_location[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
