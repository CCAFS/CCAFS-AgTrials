<?php

/**
 * tbtrial module configuration.
 *
 * @package    trialsites
 * @subpackage tbtrial
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbtrialGeneratorConfiguration extends BaseTbtrialGeneratorConfiguration {

    public function getFilterDefaults() {
        if (sfContext::getInstance()->getRequest()->getParameter("id_trialgroup")) {
            sfContext::getInstance()->getUser()->setAttribute("id_trialgroup", sfContext::getInstance()->getRequest()->getParameter("id_trialgroup"));
            return array("id_trialgroup" => sfContext::getInstance()->getRequest()->getParameter("id_trialgroup"));
        } else {
            return array("id_trialgroup" => sfContext::getInstance()->getUser()->getAttribute("id_trialgroup"));
        }
    }

}
