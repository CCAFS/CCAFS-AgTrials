<?php

/**
 * TbWeatherstation filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbWeatherstationFormFilter extends BaseTbWeatherstationFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_country' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCountry'), 'add_empty' => true, 'order_by' => array('cntname', 'asc'))),
            'wtstname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'wtstlatitude' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'wtstlongitude' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'wtstelevation' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'id_weatherstationsource' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbWeatherstationsource'), 'add_empty' => true)),
        ));

        $this->setValidators(array(
            'id_country' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCountry'), 'column' => 'id_country')),
            'wtstname' => new sfValidatorPass(array('required' => false)),
            'wtstlatitude' => new sfValidatorPass(array('required' => false)),
            'wtstlongitude' => new sfValidatorPass(array('required' => false)),
            'wtstelevation' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
            'id_weatherstationsource' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbWeatherstationsource'), 'column' => 'id_weatherstationsource')),
        ));

        $this->widgetSchema->setNameFormat('tb_weatherstation_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
