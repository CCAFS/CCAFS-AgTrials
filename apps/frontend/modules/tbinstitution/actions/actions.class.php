<?php

require_once dirname(__FILE__) . '/../lib/tbinstitutionGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbinstitutionGeneratorHelper.class.php';

/**
 * tbinstitution actions.
 *
 * @package    trialsites
 * @subpackage tbinstitution
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbinstitutionActions extends autoTbinstitutionActions {

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbinstitution = $this->form->getObject();
        $this->form = new tbinstitutionForm(null, array('url' => 'tbinstitution/'));
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbinstitution = $this->form->getObject();
        $this->form = new tbinstitutionForm(null, array('url' => 'tbinstitution/tbinstitution/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeAutocountry($request) {
        $this->getResponse()->setContentType('application/json');

        $countries = Doctrine::getTable('TbCountry')->retrieveForSelect(
                        $request->getParameter('q'),
                        $request->getParameter('limit')
        );

        return $this->renderText(json_encode($countries));
    }
    

}
