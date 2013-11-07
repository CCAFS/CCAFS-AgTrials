<?php

/**
 * help actions.
 *
 * @package    trialsites
 * @subpackage help
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions {

    public function executeError404() {
        $this->setLayout(false);
    }

    public function executeLogin() {
        $this->setLayout(false);
    }

}
