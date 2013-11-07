<?php

/**
 * TbTrialgrouptype filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialgrouptypeFormFilter extends BaseTbTrialgrouptypeFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'trgptyname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
        ));

        $this->setValidators(array(
            'trgptyname' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_trialgrouptype_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
