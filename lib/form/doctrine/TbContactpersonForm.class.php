<?php

/**
 * TbContactperson form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbContactpersonForm extends BaseTbContactpersonForm {

    public function configure() {

        if (!($this->isNew)) {
            $this->setOption('url', '');
        }

        $this->setWidgets(array(
            'id_contactperson' => new sfWidgetFormInputHidden(),
            //'id_institution' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'add_empty' => 'Select One')),
            'id_institution' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbInstitution',
                        'url' => $this->getOption('url') . 'autoinstitution',
                        'method_for_query' => 'findOneByIdInstitution',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ), array('size' => 30)),
            'id_country' => new sfWidgetFormDoctrineJQueryAutocompleter(
                    array(
                        'model' => 'TbCountry',
                        'url' => $this->getOption('url') . 'autocountry',
                        'method_for_query' => 'findOneByIdCountry',
                        'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
                    ), array('size' => 30)),
            'id_contactpersontype' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactpersontype'), 'add_empty' => 'Select One')),
            'cnprfirstname' => new sfWidgetFormInput(array() ,array('size' => 30)),
            'cnprlastname' => new sfWidgetFormInput(array() ,array('size' => 30)),
            'cnpraddress' => new sfWidgetFormInput(array() ,array('size' => 30)),
            'cnprphone' => new sfWidgetFormInput(array() ,array('size' => 30)),
            'cnpremail' => new sfWidgetFormInput(array() ,array('size' => 30)),
        ));

        $this->setValidators(array(
            'id_contactperson' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_contactperson')), 'empty_value' => $this->getObject()->get('id_contactperson'), 'required' => false)),
            'id_institution' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'column' => 'id_institution', 'multiple' => false)),
            'id_country' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country', 'multiple' => false)),
            'cnprlastname' => new sfValidatorString(),
            'id_contactpersontype' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactpersontype'))),
            'cnprfirstname' => new sfValidatorString(),
            'cnprlastname' => new sfValidatorString(),
            'cnpraddress' => new sfValidatorString(array('required' => false)),
            'cnprphone' => new sfValidatorString(array('required' => false)),
            'cnpremail' => new sfValidatorEmail(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_contactperson[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
