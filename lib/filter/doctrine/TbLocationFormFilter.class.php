<?php

/**
 * TbLocation filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbLocationFormFilter extends BaseTbLocationFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'add_empty' => true, 'order_by' => array('cntname', 'asc'))),
            'lctname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
        ));

        $this->setValidators(array(
            'id_country' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country')),
            'lctname' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_location_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
