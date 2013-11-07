<?php

/**
 * TbContactpersontype form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbContactpersontypeForm extends BaseTbContactpersontypeForm {

    public function configure() {
        $this->setWidgets(array(
            'id_contactpersontype' => new sfWidgetFormInputHidden(),
            'ctprtpname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_contactpersontype' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_contactpersontype')), 'empty_value' => $this->getObject()->get('id_contactpersontype'), 'required' => false)),
            'ctprtpname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_contactpersontype[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
