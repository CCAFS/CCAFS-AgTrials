<?php

/**
 * TbBibliography form.
 *
 * @package    trialsites
 * @subpackage form
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TbBibliographyForm extends BaseTbBibliographyForm {

    public function configure() {
        $range = range(1950, date('Y'));
        $years = array_combine($range, $range);

        $this->setWidgets(array(
            'id_bibliography' => new sfWidgetFormInputHidden(),
            'id_crop' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'add_empty' => true)),
            'id_trialgroup' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgroup'), 'add_empty' => true)),
            'id_language' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TbLanguage'), 'add_empty' => false)),
            'bbgreferencetype' => new sfWidgetFormChoice(array('choices' => array('Generic' => 'Generic', 'Blog' => 'Blog', 'Book' => 'Book', 'Journal Article' => 'Journal Article'))),
            'bbgtitle' => new sfWidgetFormInputText(),
            'bbgauthor' => new sfWidgetFormTextareaTinyMCE(array(
                'width' => 450,
                'height' => 200,
                'config' => 'theme: "simple"',
            )),
            'bbgvolume' => new sfWidgetFormInputText(),
            'bbgnumber' => new sfWidgetFormInputText(),
            'bbgyear' => new sfWidgetFormInputText(),
            'bbgdocumenttitle' => new sfWidgetFormInputText(),
            'bbgpublisher' => new sfWidgetFormInputText(),
            'bbgpages' => new sfWidgetFormInputText(),
            'bbgabstract' => new sfWidgetFormTextareaTinyMCE(array(
                'width' => 450,
                'height' => 200,
                'config' => 'theme: "simple"',
            )),
            'bbgkeywords' => new sfWidgetFormTextareaTinyMCE(array(
                'width' => 450,
                'height' => 200,
                'config' => 'theme: "simple"',
            )),
            'bbgnotes' => new sfWidgetFormTextareaTinyMCE(array(
                'width' => 450,
                'height' => 200,
                'config' => 'theme: "simple"',
            )),
            'bbgaddedtolibrary' => new sfWidgetFormJQueryDate(array(
                'image' => dirname($_SERVER['SCRIPT_NAME']) . '/images/calendar-icon.png',
                'culture' => 'fr',
                'date_widget' => new sfWidgetFormDate(array('format' => '%day% %month%%year%'))
            )),
        ));

        //VALORES POR DEFECTO
        $this->setDefault('bbgaddedtolibrary', date('m/d/Y'));

        //AYUDA PARA CAMPOS
        $this->widgetSchema->setHelp('bbgauthor', 'Use format Last Name, First name. Enter each name on a new line.');
        $this->widgetSchema->setHelp('bbgkeywords', 'Enter each keyword on a new line.');

        $this->setValidators(array(
            'id_bibliography' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_bibliography')), 'empty_value' => $this->getObject()->get('id_bibliography'), 'required' => false)),
            'id_crop' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbCrop'), 'required' => false)),
            'id_trialgroup' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbTrialgroup'), 'required' => false)),
            'id_language' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TbLanguage'))),
            'bbgreferencetype' => new sfValidatorChoice(array('choices' => array('Generic' => 'Generic', 'Blog' => 'Blog', 'Book' => 'Book', 'Journal Article' => 'Journal Article'))),
            'bbgtitle' => new sfValidatorString(),
            'bbgauthor' => new sfValidatorString(),
            'bbgvolume' => new sfValidatorString(array('required' => false)),
            'bbgnumber' => new sfValidatorString(array('required' => false)),
            'bbgyear' => new sfValidatorInteger(),
            'bbgdocumenttitle' => new sfValidatorString(array('required' => false)),
            'bbgpublisher' => new sfValidatorString(array('required' => false)),
            'bbgpages' => new sfValidatorString(array('required' => false)),
            'bbgabstract' => new sfValidatorString(array('required' => false)),
            'bbgkeywords' => new sfValidatorString(),
            'bbgnotes' => new sfValidatorString(array('required' => false)),
            'bbgaddedtolibrary' => new sfValidatorDate(),
        ));

        $this->widgetSchema->setNameFormat('tb_bibliography[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();
    }

}
