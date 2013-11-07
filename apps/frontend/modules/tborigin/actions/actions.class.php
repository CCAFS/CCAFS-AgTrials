<?php

require_once dirname(__FILE__) . '/../lib/tboriginGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tboriginGeneratorHelper.class.php';

/**
 * tborigin actions.
 *
 * @package    trialsites
 * @subpackage tborigin
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tboriginActions extends autoTboriginActions {

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tborigin = $this->form->getObject();
        $this->form = new tboriginForm(null, array('url' => 'tborigin/'));
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tborigin = $this->form->getObject();
        $this->form = new tboriginForm(null, array('url' => 'tborigin/tborigin/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeAutoinstitution($request) {
        $this->getResponse()->setContentType('application/json');

        $Institution = Doctrine::getTable('TbInstitution')->retrieveForSelect(
                        $request->getParameter('q'),
                        $request->getParameter('limit')
        );

        return $this->renderText(json_encode($Institution));
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
