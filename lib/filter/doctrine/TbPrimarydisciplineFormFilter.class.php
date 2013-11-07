<?php

/**
 * TbPrimarydiscipline filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbPrimarydisciplineFormFilter extends BaseTbPrimarydisciplineFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'prdsname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
        ));

        $this->setValidators(array(
            'prdsname' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_primarydiscipline_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
