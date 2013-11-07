<?php

/**
 * TbInstitution form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbInstitutionForm extends BaseTbInstitutionForm {

    public function configure() {
        $this->setWidgets(array(
            'id_institution' => new sfWidgetFormInputHidden(),
            'id_country' => new sfWidgetFormDoctrineJQueryAutocompleter(array(
                'model' => 'TbCountry',
                'url' => $this->getOption('url').'autocountry',
                'method_for_query' => 'findOneByIdCountry',
                'config' => '{ width: 220,max: 10,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 300}'
            )),            'insname' => new sfWidgetFormInputText(),
            'insaddress' => new sfWidgetFormInputText(),
            'insphone' => new sfWidgetFormInputText(),
            'insfax' => new sfWidgetFormInputText(),
            'insemail' => new sfWidgetFormInputText(),
            'inswebsite' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_institution' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_institution')), 'empty_value' => $this->getObject()->get('id_institution'), 'required' => false)),
            'id_country' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country', 'multiple' => false)),
            'insname' => new sfValidatorString(),
            'insaddress' => new sfValidatorString(),
            'insphone' => new sfValidatorString(),
            'insfax' => new sfValidatorString(array('required' => false)),
            'insemail' => new sfValidatorEmail(array('required' => false), array('invalid' => 'The email address is not valid.')),
            'inswebsite' => new sfValidatorUrl(array('required' => false), array('invalid' => 'The web site is not valid. <br>Format: http://www.site.com or http://site.com')),
        ));

//        $subForm = new sfForm();
//        for ($i = 0; $i < 1; $i++) {
//            $Institutionnetwork = new TbInstitutionnetwork();
//            $Institutionnetwork->TbInstitution = $this->getObject();
//            $form = new TbInstitutionnetworkForm($Institutionnetwork);
//            $subForm->embedForm($i, $form);
//        }
//        $this->embedForm('Institutionnetwork', $subForm);

        $this->widgetSchema->setNameFormat('tb_institution[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
