<?php

/**
 * TbOrigin form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbOriginForm extends BaseTbOriginForm {

    public function configure() {

        if (!($this->isNew)) {
            $this->setOption('url', '');
        }

        $this->setWidgets(array(
            'id_origin' => new sfWidgetFormInputHidden(),
            'id_country' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbCountry',
                        'url' => $this->getOption('url') . 'autocountry',
                        'method_for_query' => 'findOneByIdCountry',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ), array('size' => 30)),
            'orgname' => new sfWidgetFormInputText(array(), array('size' => 30)),
            'id_institution' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbInstitution',
                        'url' => $this->getOption('url') . 'autoinstitution',
                        'method_for_query' => 'findOneByIdInstitution',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ), array('size' => 30)),
        ));

        $this->setValidators(array(
            'id_origin' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_origin')), 'empty_value' => $this->getObject()->get('id_origin'), 'required' => false)),
            'id_country' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country', 'multiple' => false)),
            'orgname' => new sfValidatorString(),
            'id_institution' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'required' => false, 'column' => 'id_institution', 'multiple' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_origin[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
