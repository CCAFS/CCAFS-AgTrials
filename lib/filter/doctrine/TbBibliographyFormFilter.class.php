<?php

/**
 * TbBibliography filter form.
 *
 * @package    trialsites
 * @subpackage filter
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbBibliographyFormFilter extends BaseTbBibliographyFormFilter {

    public function configure() {
        $this->setWidgets(array(
            'id_crop' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'add_empty' => true, 'order_by' => array('crpname', 'asc'))),
            'id_trialgroup' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgroup'), 'add_empty' => true, 'order_by' => array('trgrname', 'asc'))),
            'id_language' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbLanguage'), 'add_empty' => true, 'order_by' => array('lngname', 'asc'))),
            'bbgreferencetype' => new sfWidgetFormChoice(array('choices' => array('Generic' => 'Generic', 'Blog' => 'Blog', 'Book' => 'Book', 'Journal Article' => 'Journal Article'))),
            'bbgtitle' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'bbgauthor' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'bbgvolume' => new sfWidgetFormFilterInput(),
            'bbgnumber' => new sfWidgetFormFilterInput(),
            'bbgyear' => new sfWidgetFormFilterInput(),
            'bbgdocumenttitle' => new sfWidgetFormFilterInput(),
            'bbgpublisher' => new sfWidgetFormFilterInput(),
            'bbgpages' => new sfWidgetFormFilterInput(),
            'bbgabstract' => new sfWidgetFormFilterInput(),
            'bbgkeywords' => new sfWidgetFormFilterInput(array('with_empty' => false)),
            'bbgnotes' => new sfWidgetFormFilterInput(),
            'bbgaddedtolibrary' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
        ));

        $this->setValidators(array(
            'id_crop' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbCrop'), 'column' => 'id_crop')),
            'id_trialgroup' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbTrialgroup'), 'column' => 'id_trialgroup')),
            'id_language' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TbLanguage'), 'column' => 'id_language')),
            'bbgreferencetype' => new sfValidatorChoice(array('choices' => array('Generic' => 'Generic', 'Blog' => 'Blog', 'Book' => 'Book', 'Journal Article' => 'Journal Article'))),
            'bbgtitle' => new sfValidatorPass(array('required' => false)),
            'bbgauthor' => new sfValidatorPass(array('required' => false)),
            'bbgvolume' => new sfValidatorPass(array('required' => false)),
            'bbgnumber' => new sfValidatorPass(array('required' => false)),
            'bbgyear' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
            'bbgdocumenttitle' => new sfValidatorPass(array('required' => false)),
            'bbgpublisher' => new sfValidatorPass(array('required' => false)),
            'bbgpages' => new sfValidatorPass(array('required' => false)),
            'bbgabstract' => new sfValidatorPass(array('required' => false)),
            'bbgkeywords' => new sfValidatorPass(array('required' => false)),
            'bbgnotes' => new sfValidatorPass(array('required' => false)),
            'bbgaddedtolibrary' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
        ));

        $this->widgetSchema->setNameFormat('tb_bibliography_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
