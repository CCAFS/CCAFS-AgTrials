<?php

require_once dirname(__FILE__) . '/../lib/tbbibliographyGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbbibliographyGeneratorHelper.class.php';

/**
 * tbbibliography actions.
 *
 * @package    trialsites
 * @subpackage tbbibliography
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbbibliographyActions extends autoTbbibliographyActions {

    public function executeEdit(sfWebRequest $request) {
        $this->tbbibliography = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->tbbibliography);

        //VERIFICAMOS LOS PERMISOS DE MODIFICACION
        $id_user = $this->getUser()->getGuardUser()->getId();
        $id_bibliography = $request->getParameter("id_bibliography");
        $Query00 = Doctrine::getTable('TbBibliography')->findOneByIdBibliography($id_bibliography);
        $id_user_registro = $Query00->getIdUser();
        $user = $this->getUser();
        if (($id_user != $id_user_registro) && (!($user->hasCredential('Administrator')))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions edit!'); window.history.back();</script>";
            Die();
        }
    }

}
