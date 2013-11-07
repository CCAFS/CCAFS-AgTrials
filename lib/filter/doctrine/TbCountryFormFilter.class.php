<?php

/**
 * TbCountry filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbCountryFormFilter extends BaseTbCountryFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'cntname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'cntiso' => new sfWidgetFormFilterInput(),
            'cntiso3' => new sfWidgetFormFilterInput(),
        ));

        $this->setValidators(array(
            'cntname' => new sfValidatorPass(array('required' => false)),
            'cntiso' => new sfValidatorPass(array('required' => false)),
            'cntiso3' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_country_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
