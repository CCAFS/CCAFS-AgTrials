<?php

/**
 * administration actions.
 *
 * @package    trialsites
 * @subpackage administration
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class forumActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeForum(sfWebRequest $request) {
        $QUERY00 = Doctrine_Query::create()
                        ->select("C.id_category,C.ctgname,C.ctgdescription,(SELECT COUNT(M1.id_message) FROM TbMessage M1 WHERE M1.id_category = C.id_category) AS totalpublications,(SELECT (M2.created_at||' by '||U.username) FROM TbMessage M2 INNER JOIN M2.SfGuardUser U WHERE M2.id_category = C.id_category ORDER BY M2.created_at DESC LIMIT 1) AS lastpublications ")
                        ->from("TbCategory C")
                        ->orderBy("C.created_at DESC");
        //echo $QUERY00->getSqlQuery(); die();
        $Resultado00 = $QUERY00->execute();
        $this->categorias = $Resultado00;
    }

    public function executeTheme(sfWebRequest $request) {
        $id_category = $request->getParameter('cat');
        $TbCategory = Doctrine::getTable('TbCategory')->findOneByIdCategory($id_category);
        $ctgname = "/ " . $TbCategory->ctgdescription;
        $QUERY00 = Doctrine_Query::create()
                        ->select("T.id_theme,T.thmname,T.id_category,(SELECT COUNT(M1.id_message) FROM TbMessage M1 WHERE M1.id_theme = T.id_theme) AS publications,U.username AS username,T.created_at ")
                        ->from("TbTheme T")
                        ->innerJoin("T.SfGuardUser U")
                        ->where("T.id_category = $id_category")
                        ->orderBy("T.created_at DESC");
        //echo $QUERY00->getSqlQuery(); die();
        $Resultado00 = $QUERY00->execute();
        $this->themes = $Resultado00;
        $this->ctgname = $ctgname;
    }

    public function executeMessage(sfWebRequest $request) {
        $id_theme = $request->getParameter('them');
        $TbTheme = Doctrine::getTable('TbTheme')->findOneByIdTheme($id_theme);
        $thmname = " / ".$TbTheme->thmname;
        $id_category = $TbTheme->getIdCategory();
        $TbCategory = Doctrine::getTable('TbCategory')->findOneByIdCategory($id_category);
        $ctgname = "/ " . $TbCategory->ctgdescription;
        $QUERY00 = Doctrine_Query::create()
                        ->select("M.mnsmessage, M.id_category,C.ctgname AS ctgname, T.thmname AS thmname, M.created_at")
                        ->addSelect("(U.first_name||' '||U.last_name) AS user")
                        ->from("TbMessage M")
                        ->innerJoin("M.SfGuardUser U")
                        ->innerJoin("M.TbCategory C")
                        ->innerJoin("M.TbTheme T")
                        ->where("M.id_theme = $id_theme")
                        ->orderBy("M.created_at DESC");
        //echo $QUERY00->getSqlQuery(); die();
        $Resultado00 = $QUERY00->execute();
        $this->message = $Resultado00;
        $this->id_theme = $id_theme;
        $this->id_category = $id_category;
        $this->thmname = $thmname;
        $this->ctgname = $ctgname;
    }

    public function executeSavemessage(sfWebRequest $request) {
        $id_theme = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_theme');
        $txtmessage = sfContext::getInstance()->getRequest()->getParameterHolder()->get('txtmessage');
        if (isset($id_theme) && isset($txtmessage)) {
            if ($txtmessage == "") {
                echo "<script> alert('Write your message'); window.history.back();</script>";
                die();
            }
            $id_user = $this->getUser()->getGuardUser()->getId();
            $TbTheme = Doctrine::getTable('TbTheme')->findOneByIdTheme($id_theme);
            $id_category = $TbTheme->getIdCategory();
            TbMessageTable::addMessage($txtmessage, $id_category, $id_theme, $id_user);
            $this->redirect("/message?them=$id_theme");
        }
    }

    public function executeNewcategory(sfWebRequest $request) {
        $ctgname = sfContext::getInstance()->getRequest()->getParameterHolder()->get('ctgname');
        $ctgdescription = sfContext::getInstance()->getRequest()->getParameterHolder()->get('ctgdescription');
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (isset($ctgname) && isset($ctgdescription)) {
            $id_category = TbCategoryTable::addCategory($ctgname, $ctgdescription, $id_user);
            //echo "<script> alert('Created category successfully!');</script>";
            $this->redirect("/theme?cat=$id_category");
        }
    }

    public function executeNewtheme(sfWebRequest $request) {
        $thmname = sfContext::getInstance()->getRequest()->getParameterHolder()->get('thmname');
        $id_category = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_category');
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (isset($thmname) && isset($id_category)) {
            $id_theme = TbThemeTable::addTheme($thmname, $id_category, $id_user);
            //echo "<script> alert('Created Theme successfully!');</script>";
            $this->redirect("/message?them=$id_theme");
        }
    }

}
