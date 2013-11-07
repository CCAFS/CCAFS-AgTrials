<?php

require_once dirname(__FILE__).'/../lib/tbfieldnamenumberGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/tbfieldnamenumberGeneratorHelper.class.php';

/**
 * tbfieldnamenumber actions.
 *
 * @package    trialsites
 * @subpackage tbfieldnamenumber
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbfieldnamenumberActions extends autoTbfieldnamenumberActions
{
    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbfieldnamenumber = $this->form->getObject();
        $this->form = new tbfieldnamenumberForm(null, array('url' => 'tbfieldnamenumber/'));
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbfieldnamenumber = $this->form->getObject();
        $this->form = new tbfieldnamenumberForm(null, array('url' => 'tbfieldnamenumber/tbfieldnamenumber/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeAutotrialsite($request) {
        $this->getResponse()->setContentType('application/json');
        $Trialsites = Doctrine::getTable('TbTrialsite')->retrieveForSelect(
                        $request->getParameter('q'),
                        $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Trialsites));
    }


}
