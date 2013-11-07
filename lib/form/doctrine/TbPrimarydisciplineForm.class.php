<?php

/**
 * TbPrimarydiscipline form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbPrimarydisciplineForm extends BaseTbPrimarydisciplineForm {

    public function configure() {
        $this->setWidgets(array(
            'id_primarydiscipline' => new sfWidgetFormInputHidden(),
            'prdsname' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id_primarydiscipline' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_primarydiscipline')), 'empty_value' => $this->getObject()->get('id_primarydiscipline'), 'required' => false)),
            'prdsname' => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('tb_primarydiscipline[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
