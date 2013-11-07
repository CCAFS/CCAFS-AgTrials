<?php

/**
 * TbTrialgroup filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbTrialgroupFormFilter extends BaseTbTrialgroupFormFilter {

    public function configure() {
        if (!($this->isNew)) {
            $this->setOption('url', '');
        }

        $this->setWidgets(array(
            'id_institution' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbInstitution'), 'add_empty' => true, 'order_by' => array('insname', 'asc'))),
            'id_contactperson' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbContactperson'), 'add_empty' => true, 'order_by' => array('cnprfirstname', 'asc'))),
            'id_trialgrouptype' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgrouptype'), 'add_empty' => true, 'order_by' => array('trgptyname', 'asc'))),
            'id_objective' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbObjective'), 'add_empty' => true, 'order_by' => array('objname', 'asc'))),
            'id_primarydiscipline' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbPrimarydiscipline'), 'add_empty' => true, 'order_by' => array('prdsname', 'asc'))),
            'trgrname' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'trgrstartyear' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'trgrendyear' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'trgrtrialgrouprecordstatus' => new sfWidgetFormChoice(array('choices' => array('Open' => 'Open', 'Closed' => 'Closed', 'Inactive' => 'Inactive', 'Canceled' => 'Canceled'))),
        ));

        $this->setValidators(array(
            'id_institution' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbInstitution'), 'column' => 'id_institution')),
            'id_contactperson' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbContactperson'), 'column' => 'id_contactperson')),
            'id_trialgrouptype' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTrialgrouptype'), 'column' => 'id_trialgrouptype')),
            'id_objective' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbObjective'), 'column' => 'id_objective')),
            'id_primarydiscipline' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbPrimarydiscipline'), 'column' => 'id_primarydiscipline')),
            'trgrname' => new sfValidatorPass(array('required' => false)),
            'trgrstartyear' => new sfValidatorPass(array('required' => false)),
            'trgrendyear' => new sfValidatorPass(array('required' => false)),
            'trgrtrialgrouprecordstatus' => new sfValidatorPass(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('tb_trialgroup_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
