<?php

require_once dirname(__FILE__) . '/../lib/tbtrialGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbtrialGeneratorHelper.class.php';
require_once ('/../../../../../lib/zip/pclzip.lib.php');
require_once '../lib/funtions/funtion.php';
require_once '../lib/funtions/html.php';
require_once '../lib/excel/Classes/PHPExcel.php';
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/excel/reader.php';

/**
 * tbtrial actions.
 *
 * @package    trialsites
 * @subpackage tbtrial
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbtrialActions extends autoTbtrialActions {

    public function executeIndex(sfWebRequest $request) {
        $this->id_trialgroup = $request->getParameter("id_trialgroup");
        if ($request->hasParameter('id_trialgroup')) {
            $this->setFilters($this->configuration->getFilterDefaults());
        }
        parent::executeIndex($request);
    }

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbtrial = $this->form->getObject();
        $this->form = new tbtrialForm(null, array('url' => 'tbtrial/'));
        sfContext::getInstance()->getUser()->setAttribute('numbertrials', 1);
        sfContext::getInstance()->getUser()->setAttribute('replications', 1);
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_crop');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialdata');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_name');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->tbtrial = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->tbtrial);
        $user = sfContext::getInstance()->getUser();
//        ini_set("memory_limit", "2048M");
//        set_time_limit(900000000000);
//VERIFICAMOS LOS PERMISOS DE MODIFICACION
        $id_user = $this->getUser()->getGuardUser()->getId();
        $id_trial = $request->getParameter("id_trial");
        $Query00 = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
        $id_user_registro = $Query00->getIdUser();
        $user->setAttribute('id_crop', $Query00->getIdCrop());
        $user->setAttribute('replications', $Query00->getTrlreplications());
        $user->setAttribute('numbertrials', 1);

        if ($id_user == $id_user_registro || (CheckUserPermission($id_user, "1")) || (PermissionChangeTrial($id_user, $id_trial))) {

            //INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialvariety
            $session_varieties_id = array();
            $Trialvariety = Doctrine::getTable('TbTrialvariety')->findByIdTrial($id_trial);
            for ($cont = 0; $cont < count($Trialvariety); $cont++) {
                $Variety = Doctrine::getTable('TbVariety')->findOneByIdVariety($Trialvariety[$cont]->getIdVariety());
                $varieties_id_saved[] = $Variety->getIdVariety();
                $varieties_name_saved[] = $Variety->getVrtname();
            }
            $user->setAttribute('varieties_id', $varieties_id_saved);
            $user->setAttribute('varieties_name', $varieties_name_saved);

            //INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialvariablesmeasured
            $Trialvariablesmeasured = Doctrine::getTable('TbTrialvariablesmeasured')->findByIdTrial($id_trial);
            for ($cont = 0; $cont < count($Trialvariablesmeasured); $cont++) {
                $Variablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($Trialvariablesmeasured[$cont]->getIdVariablesmeasured());
                $variablesmeasured_id_saved[] = $Variablesmeasured->getIdVariablesmeasured();
                $variablesmeasured_name_saved[] = $Variablesmeasured->getVrmsname();
            }
            $user->setAttribute('variablesmeasured_id', $variablesmeasured_id_saved);
            $user->setAttribute('variablesmeasured_name', $variablesmeasured_name_saved);

            //INICIO: AQUI CONSUILTAMOS LOS DATOS DEL ENSAYO EN LA TABLA tb_trialdata
            $Trialdata = Doctrine::getTable('TbTrialdata')->findByIdTrial($id_trial);
            for ($cont = 0; $cont < count($Trialdata); $cont++) {
                $id_variablesmeasured = $Trialdata[$cont]->getIdVariablesmeasured();
                if ($Unit == '')
                    $Unit = "N.A.";
                $trialdata[] = array('replication' => $Trialdata[$cont]->getTrdtreplication(), 'id_variety' => $Trialdata[$cont]->getIdVariety(), 'id_variablesmeasured' => $id_variablesmeasured, 'value' => $Trialdata[$cont]->getTrdtvalue(), 'unit' => $Unit);
            }
            $user->setAttribute('trialdata', $trialdata);

            //INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialuserpermissionfiles
            $Trialuserpermissionfiles = Doctrine::getTable('TbTrialuserpermissionfiles')->findByIdTrial($id_trial);
            for ($cont = 0; $cont < count($Trialuserpermissionfiles); $cont++) {
                $SfGuardUser = Doctrine::getTable('SfGuardUser')->findOneById($Trialuserpermissionfiles[$cont]->getIdUserpermission());
                $user_id_saved[] = $SfGuardUser->getId();
                $user_name_saved[] = $SfGuardUser->getFirstName() . " " . $SfGuardUser->getLastName();
            }
            $user->setAttribute('user_id', $user_id_saved);
            $user->setAttribute('user_name', $user_name_saved);

            //INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialgrouppermission
            $TbTrialgrouppermission = Doctrine::getTable('TbTrialgrouppermission')->findByIdTrial($id_trial);
            for ($cont = 0; $cont < count($TbTrialgrouppermission); $cont++) {
                $SfGuardGroup = Doctrine::getTable('SfGuardGroup')->findOneById($TbTrialgrouppermission[$cont]->getIdGroup());
                $group_id_saved[] = $SfGuardGroup->getId();
                $group_name_saved[] = $SfGuardGroup->getName();
            }
            $user->setAttribute('group_id', $group_id_saved);
            $user->setAttribute('group_name', $group_name_saved);
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not permissions to EDIT!'); window.history.back();</script>";
            Die();
        }
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbtrial = $this->form->getObject();
        $this->form = new tbtrialForm(null, array('url' => 'tbtrial/tbtrial/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();
//VERIFICAMOS LOS PERMISOS DE ELIMINACION
        $id_user = $this->getUser()->getGuardUser()->getId();
        $id_trial = $request->getParameter("id_trial");
        $Query00 = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
        $id_user_registro = $Query00->getIdUser();
        $user = $this->getUser();

        if ($id_user == $id_user_registro || (CheckUserPermission($id_user, "1")) || (PermissionChangeTrial($id_user, $id_trial))) {
            TbTrialvarietyTable::delVariety($id_trial);
            TbTrialvariablesmeasuredTable::delVariablesmeasured($id_trial);
            TbTrialdataTable::delData($id_trial);
            TbTrialuserpermissionfilesTable::delUsers($id_trial);
            TbTrialgrouppermissionTable::delTrialgrouppermission($id_trial);
            TbTrialcommentsTable::delTrialcommentsbyidtrial($id_trial);
            SfGuardUserDownloadsTable::delSfGuardUserDownloads($id_trial);
            TbTrialsGftTable::delTrialsGft($id_trial);

            //ELIMINAMOS EL REGISTRO DE GOOGLE FUSION TABLE
            //DeleteFusionTable($id_trial);

            $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
            $this->getRoute()->getObject()->delete();
            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
            echo "<script> alert('The item was deleted successfully!');</script>";
            $this->redirect('@list');
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not permissions to DELETE!'); window.history.back();</script>";
            Die();
        }
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

            $tbtrial = $form->save();
            $id_user = $this->getUser()->getGuardUser()->getId();
            $id_trial = $tbtrial->getIdTrial();
            $id_crop = $tbtrial->getIdCrop();
            $user = sfContext::getInstance()->getUser();

//INICIO: AQUI AGREGAMOS LAS VARIEDADES A LA TABLA tb_trialvariety
            $session_varieties_id = $user->getAttribute('varieties_id');
            $list_variety = "";
            TbTrialvarietyTable::delVariety($tbtrial->getIdTrial());
            for ($cont = 0; $cont < count($session_varieties_id); $cont++) {
                $Variety = Doctrine::getTable('TbVariety')->findOneByIdVariety($session_varieties_id[$cont]);
                $list_variety .= $Variety->getVrtname() . ", ";
                TbTrialvarietyTable::addVariety($tbtrial->getIdTrial(), $session_varieties_id[$cont], $id_user);
            }
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');

//INICIO: AQUI AGREGAMOS LAS VARIABLES MEDIDAS A LA TABLA tb_trialvariablesmeasured
            $user = sfContext::getInstance()->getUser();
            $session_variablesmeasured = $user->getAttribute('variablesmeasured_id');
            $list_variablesmeasured = "";
            TbTrialvariablesmeasuredTable::delVariablesmeasured($tbtrial->getIdTrial());
            for ($cont = 0; $cont < count($session_variablesmeasured); $cont++) {
                $Variablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($session_variablesmeasured[$cont]);
                $list_variablesmeasured .= $Variablesmeasured->getVrmsname() . ", ";
                TbTrialvariablesmeasuredTable::addVariablesmeasured($tbtrial->getIdTrial(), $session_variablesmeasured[$cont], $id_user);
            }
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasureds_name');

//INICIO: AQUI AGREGAMOS LOS DATOS DE RESULTADOS A LA TABLA tb_trialdata
            TbTrialdataTable::delData($tbtrial->getIdTrial());
            $filedata = $_FILES["filedata"]['name'];
            if ($filedata != '') {
                $UploadDir = sfConfig::get("sf_upload_dir");
                $TmpUploadDir = $UploadDir . "/tmp$id_user";
                if (!is_dir($TmpUploadDir)) {
                    mkdir($TmpUploadDir, 0777);
                }
                move_uploaded_file($_FILES["filedata"]['tmp_name'], "$TmpUploadDir/$filedata");
                $inputFileName = "$TmpUploadDir/$filedata";
                $id_trial = $tbtrial->getIdTrial();
                SaveTrialData($id_trial, $inputFileName, $id_user, $id_crop);
            } else {
                $trialdata = $user->getAttribute('trialdata');
                if (isset($trialdata)) {
                    foreach ($trialdata AS $key => $valor) {
                        $trdtreplication = $valor['replication'];
                        $id_variety = $valor['id_variety'];
                        $id_variablesmeasured = $valor['id_variablesmeasured'];
                        $value = $valor['value'];
                        TbTrialdataTable::addData($id_trial, $trdtreplication, $id_variety, $id_variablesmeasured, $value);
                    }
                }
            }
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialdata');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_crop');

            if (($tbtrial->getTrlfileaccess() == 'Open to all users') || ($tbtrial->getTrlfileaccess() == 'Public domain')) {
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_id');
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_name');
            }

            //INICIO: AQUI ASIGNAMOS LOS PERMISOS A LA TABLA tb_trialuserpermissionfiles
            $session_user = $user->getAttribute('user_id');
            $list_user = "";
            TbTrialuserpermissionfilesTable::delUsers($tbtrial->getIdTrial());
            for ($cont = 0; $cont < count($session_user); $cont++) {
                $SfguardUser = Doctrine::getTable('SfguardUser')->findOneById($session_user[$cont]);
                $list_user .= $SfguardUser->getFirstName() . " " . $SfguardUser->getLastName() . ", ";
                TbTrialuserpermissionfilesTable::addUser($tbtrial->getIdTrial(), $session_user[$cont], $id_user);
            }
            $list_user = substr($list_user, 0, strlen($list_user) - 2);
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');

            //INICIO: AQUI ASIGNAMOS LOS PERMISOS A LA TABLA tb_trialgrouppermission
            $session_group = $user->getAttribute('group_id');
            $list_group = "";
            TbTrialgrouppermissionTable::delTrialgrouppermission($tbtrial->getIdTrial());
            for ($cont = 0; $cont < count($session_group); $cont++) {
                $SfGuardGroup = Doctrine::getTable('SfGuardGroup')->findOneById($session_group[$cont]);
                $list_group .= $SfGuardGroup->getName() . ", ";
                TbTrialgrouppermissionTable::addTrialgrouppermission($tbtrial->getIdTrial(), $session_group[$cont], $id_user);
            }
            $list_group = substr($list_group, 0, strlen($list_group) - 2);
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_name');


//GRABAMOS O ACTUALIZAMOS LA TABLA DE GOOGLE FUSION TABLE
            SaveFusionTable($tbtrial->getIdTrial()); //OJO HABILITAR EN PRODUCCION

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $tbtrial)));

            if ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@tbtrial_new');
            } else {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'tbtrial_edit', 'sf_subject' => $tbtrial));
            }
        } else {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }

    public function executeAutocontactperson($request) {
        $this->getResponse()->setContentType('application/json');
        $Contactperson = Doctrine::getTable('TbContactperson')->retrieveForSelect(
                $request->getParameter('q'), null, $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Contactperson));
    }

    public function executeAutocountry($request) {
        $this->getResponse()->setContentType('application/json');

        $countries = Doctrine::getTable('TbCountry')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($countries));
    }

    public function executeAutotrialsite($request) {
        $this->getResponse()->setContentType('application/json');

        $Trialsites = Doctrine::getTable('TbTrialsite')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Trialsites));
    }

    public function executeSelectfieldnamenumber(sfWebRequest $request) {
        $id_trialsite = $request->getParameter('id_trialsite');
        $HTML = "<select id=\"tb_trial_id_fieldnamenumber\" name=\"tb_trial[id_fieldnamenumber]\">";
        $HTML .= "<option selected=\"selected\" value=\"\"></option>";
        $TbFieldnamenumber = Doctrine::getTable('TbFieldnamenumber')->findByIdTrialsite($id_trialsite);
        foreach ($TbFieldnamenumber AS $valor) {
            $HTML .= "<option value=\"$valor->id_fieldnamenumber\">$valor->trialenvironmentname</option>";
        }
        $HTML .= "</select>";
        die($HTML);
    }

    public function executeAutocrop($request) {
        $this->getResponse()->setContentType('application/json');
        $Crop = Doctrine::getTable('TbCrop')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Crop));
    }

    public function executeAutoanimal($request) {
        $this->getResponse()->setContentType('application/json');
        $Animal = Doctrine::getTable('TbAnimal')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Animal));
    }

    public function executeAutotrialgroup($request) {
        $this->getResponse()->setContentType('application/json');
        $Trialgroup = Doctrine::getTable('TbTrialgroup')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Trialgroup));
    }

    public function executeLicence(sfWebRequest $request) {
        $this->setLayout(false);
    }

    public function executeDownload(sfWebRequest $request) {
        $this->setLayout(false);
        $id_trial = $request->getParameter("id_trial");
        $TbTrial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
        $Trlfileaccess = $TbTrial->getTrlfileaccess();
        $user = sfContext::getInstance()->getUser();
        $Continue = false;

        //SI TIENE LA REGLA PARA USUARIOS VERIFICAMOS EL USUARIO
        if ($Trlfileaccess == 'Open to specified users') {
            if ($this->getUser()->isAuthenticated()) {
                $id_user = $this->getUser()->getGuardUser()->getId();
                $filas = 0;
                $QUERY00 = Doctrine_Query::create()
                        ->select("T.id_trialuserpermissionfiles AS id")
                        ->from("TbTrialuserpermissionfiles T")
                        ->where("T.id_trial = $id_trial")
                        ->andWhere("T.id_userpermission = $id_user");
                $Resultado00 = $QUERY00->execute();
                if (count($Resultado00) > 0) {
                    $Continue = true;
                }
            } else {
                echo "<script> alert('*** ERROR *** \\n\\n You must be authenticated.!'); self.parent.tb_remove();</script>";
                Die();
            }
        }

        //SI TIENE LA REGLA PARA GRUPOS VERIFICAMOS EL GRUPO DEL USUARIO
        if ($Trlfileaccess == 'Open to specified groups') {
            if ($this->getUser()->isAuthenticated()) {
                $id_user = $this->getUser()->getGuardUser()->getId();
                $SfGuardUserGroup = Doctrine::getTable('SfGuardUserGroup')->findByUserId($id_user);
                foreach ($SfGuardUserGroup AS $Group) {
                    $id_group = $Group->group_id;
                    $TbTrialgrouppermission = Doctrine::getTable('TbTrialgrouppermission')->findByIdGroup($id_group);
                    if (count($TbTrialgrouppermission) > 0) {
                        $Continue = true;
                        break;
                    }
                }
            } else {
                echo "<script> alert('*** ERROR *** \\n\\n You must be authenticated.!'); self.parent.tb_remove();</script>";
                Die();
            }
        }

        //SI TIENE LA REGLA PARA TODOS LOS USUARIOS DEL SISTEMA SE VERIFICA QUE ESTE AUTENTICADO
        if ($Trlfileaccess == 'Open to all users') {
            if ($this->getUser()->isAuthenticated()) {
                $Continue = true;
            } else {
                echo "<script> alert('*** ERROR *** \\n\\n You must be authenticated.!'); self.parent.tb_remove();</script>";
                Die();
            }
        }

        if ($Trlfileaccess == 'Public domain') {
            $Continue = true;
        }

        if (!$Continue) {
            echo "<script> alert('*** ERROR *** \\n\\n Not permissions to DOWNLOAD.!'); self.parent.tb_remove();</script>";
            Die();
        }
    }

    public function executeBatchupload(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $form = false;
        if (!$request->getParameter("form")) {
            $form = true;
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('numbertrials');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_crop');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('replications');
        } else {
            $numbertrials = $request->getParameter("numbertrials");
            $replications = $request->getParameter("replications");
            $user->setAttribute('numbertrials', $numbertrials);
            $user->setAttribute('replications', $replications);
        }

        $this->form = $form;
        $this->step = $request->getParameter("flag_step");
    }

    public function executeInformationbatchupload(sfWebRequest $request) {
        $this->setLayout(false);
    }

    public function executeDownloadestruture(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $crop_id = $user->getAttribute('id_crop');
        $SS_varieties_id = $user->getAttribute('varieties_id');
        $numbertrials = $user->getAttribute('numbertrials');
        $list_varieties = "";
        if (isset($SS_varieties_id)) {
            foreach ($SS_varieties_id AS $varieties_id) {
                $list_varieties .= $varieties_id . ",";
            }
            $list_varieties = substr($list_varieties, 0, strlen($list_varieties) - 1);
        }
        $SS_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
        $list_variablesmeasureds = "";
        if (isset($SS_variablesmeasured_id)) {
            foreach ($SS_variablesmeasured_id AS $variablesmeasured_id) {
                $list_variablesmeasureds .= $variablesmeasured_id . ",";
            }
            $list_variablesmeasureds = substr($list_variablesmeasureds, 0, strlen($list_variablesmeasureds) - 1);
        }
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(600);
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("Template Metadata Trials")
                ->setSubject("Template Metadata Trials")
                ->setDescription("Template Metadata Trials")
                ->setKeywords("Template Metadata Trials")
                ->setCategory("Template Metadata Trials");

// Add some data

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Exp-code')
                ->setCellValue('B1', 'Id trial group')
                ->setCellValue('C1', 'Id contact person')
                ->setCellValue('D1', 'Id country')
                ->setCellValue('E1', 'Id trial site')
                ->setCellValue('F1', 'Id field name number')
                ->setCellValue('G1', 'Id Technology')
                ->setCellValue('H1', 'Variety_Race')
                ->setCellValue('I1', 'Variables Measured')
                ->setCellValue('J1', 'Name')
                ->setCellValue('K1', 'Sow date (yyyy-mm-dd)')
                ->setCellValue('L1', 'Harvest date (yyyy-mm-dd)')
                ->setCellValue('M1', 'Trial results file')
                ->setCellValue('N1', 'Supplemental information file')
                ->setCellValue('O1', 'Weather during trial file')
                ->setCellValue('P1', 'Soil type conditions during trial file')
                ->setCellValue('Q1', 'License')
                ->setCellValue('R1', 'Files access (All or Users)')
                ->setCellValue('S1', 'Id specified users')
                ->setCellValue('T1', 'Trial type');
        $aa = 2;
        for ($a = 1; $a <= $numbertrials; $a++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $aa, $a);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $aa)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $aa)->getFont()->setBold(true);
            $aa++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:T1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

//APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('G1:L1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('R1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Metadata Trials');

//inicio: GENERAMOS EL LIBRO DE Information
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Information');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Field');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Description');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Exp-code');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'This makes a link with Trial Data Template (put 1,2,3 ..)');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Id trial group');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Id trial group.');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Id country');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Id country.');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Id trial site');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Id trial site.');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Id field name number');
        $objPHPExcel->getActiveSheet()->setCellValue('B6', 'Id field name number (Optional).');
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Id Technology');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', 'Id Technology.');
        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Varieties/Races');
        $objPHPExcel->getActiveSheet()->setCellValue('B8', 'List of codes Varieties/races Separated by Coma', ' (e.g. 5,32,44).');
        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Variables measured');
        $objPHPExcel->getActiveSheet()->setCellValue('B9', 'List of codes Variables Measured Separated by Coma', ' (e.g. 5,32,44).');
        $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Name');
        $objPHPExcel->getActiveSheet()->setCellValue('B10', 'Name of trial');
        $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Sow date');
        $objPHPExcel->getActiveSheet()->setCellValue('B11', 'Permitted format yyyy-mm-dd (e.g. 2010-08-25)');
        $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Harvest date');
        $objPHPExcel->getActiveSheet()->setCellValue('B12', 'Permitted format yyyy-mm-dd (e.g. 2011-12-03)');
        $objPHPExcel->getActiveSheet()->setCellValue('A13', 'Trial results file');
        $objPHPExcel->getActiveSheet()->setCellValue('B13', 'Only name file -> Permitted extensions (xls, xlsx, doc, docx, ppt, pptx, pdf, zip, rar).');
        $objPHPExcel->getActiveSheet()->setCellValue('A14', 'Supplemental information file');
        $objPHPExcel->getActiveSheet()->setCellValue('B14', 'Only name file -> Permitted extensions (xls, xlsx, doc, docx, ppt, pptx, pdf, zip, rar) - (Optional).');
        $objPHPExcel->getActiveSheet()->setCellValue('A15', 'Weather during trial file');
        $objPHPExcel->getActiveSheet()->setCellValue('B15', 'Only name file -> Permitted extensions (xls, xlsx, doc, docx, ppt, pptx, pdf, zip, rar) - (Optional).');
        $objPHPExcel->getActiveSheet()->setCellValue('A16', 'Soil type conditions during trial file');
        $objPHPExcel->getActiveSheet()->setCellValue('B16', 'Only name file -> Permitted extensions (xls, xlsx, doc, docx, ppt, pptx, pdf, zip, rar) - (Optional).');
        $objPHPExcel->getActiveSheet()->setCellValue('A17', 'License');
        $objPHPExcel->getActiveSheet()->setCellValue('B17', 'Creative Commons License Generator - (Optional)');
        $objPHPExcel->getActiveSheet()->setCellValue('A18', 'File access');
        $objPHPExcel->getActiveSheet()->setCellValue('B18', 'Permitted value (All - Users - Public).');
        $objPHPExcel->getActiveSheet()->setCellValue('A19', 'Specified users');
        $objPHPExcel->getActiveSheet()->setCellValue('B19', 'List of codes system user Separated by Coma', ' (e.g. 5,32,44) - (Optional).');
        $objPHPExcel->getActiveSheet()->setCellValue('A20', 'Trial type');
        $objPHPExcel->getActiveSheet()->setCellValue('B20', 'Permitted value (Real - Simulated) - (Optional).');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE Information
//inicio: GENERAMOS EL LIBRO DE TRIAL GROUP ABIERTOS
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet(2)->setTitle('Trial Group');
        $QUERY01 = Doctrine_Query::create()
                ->select("TG.id_trialgroup AS id, TG.trgrname AS name")
                ->from("TbTrialgroup TG")
                ->where("TG.trgrtrialgrouprecordstatus = 'Open'")
                ->orderBy("TG.trgrname");
        $Resultado01 = $QUERY01->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado01 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE TRIAL GROUP ABIERTOS
//inicio: GENERAMOS EL LIBRO DE CONTACT PERSON
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->getActiveSheet(3)->setTitle('Contact Person');
        $QUERY02 = Doctrine_Query::create()
                ->select("CP.id_contactperson AS id, (CP.cnprfirstname||' ' ||CP.cnprlastname) AS name")
                ->from("TbContactperson CP")
                ->orderBy("CP.cnprfirstname");
        $Resultado02 = $QUERY02->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado02 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE CONTACT PERSON
//inicio: GENERAMOS EL LIBRO DE COUNTRY
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(4);
        $objPHPExcel->getActiveSheet(4)->setTitle('Country');
        $QUERY03 = Doctrine_Query::create()
                ->select("C.id_country AS id, C.cntname AS name")
                ->from("TbCountry C")
                ->orderBy("C.cntname");
        $Resultado03 = $QUERY03->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado03 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE COUNTRY
//inicio: GENERAMOS EL LIBRO DE TRIAL SITE
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(5);
        $objPHPExcel->getActiveSheet(5)->setTitle('Trial Site');
        $QUERY04 = Doctrine_Query::create()
                ->select("TS.id_trialsite")
                ->addSelect("(TS.trstname||' - '||I.insname) AS name")
                ->from("TbTrialsite TS")
                ->innerJoin("TS.TbInstitution I")
                ->where("TS.trstactive = 'TRUE'")
                ->orderBy("TS.trstname");
        $Resultado04 = $QUERY04->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado04 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id_trialsite);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->name);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE TRIAL SITE
//inicio: GENERAMOS EL LIBRO DE Technology
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(6);
        $objPHPExcel->getActiveSheet(6)->setTitle('Technology');
        $QUERY05 = Doctrine_Query::create()
                ->select("C.id_crop AS id, C.crpname AS name, C.crpscientificname AS scientificname")
                ->from("TbCrop C")
                ->where("C.id_crop = $crop_id")
                ->orderBy("C.crpname");
        $Resultado05 = $QUERY05->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Scientific Name');
        foreach ($Resultado05 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila['scientificname']);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE Technology
//inicio: GENERAMOS EL LIBRO DE VARIETY/RACE
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(7);
        $objPHPExcel->getActiveSheet(7)->setTitle('Variety_Race');
        $QUERY06 = Doctrine_Query::create()
                ->select("V.id_variety, V.vrtname")
                ->addSelect("C.crpname AS crop")
                ->from("TbVariety V")
                ->innerJoin("V.TbCrop C")
                ->where("V.id_variety IN ($list_varieties)")
                ->orderBy('C.crpname, V.vrtname');
//echo $QUERY06->getSqlQuery(); die();
        $Resultado06 = $QUERY06->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Technology');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Name');
        foreach ($Resultado06 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id_variety);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->crop);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila->vrtname);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE VARIETY/RACE
//inicio: GENERAMOS EL LIBRO DE VARIABLES MEASURED
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(8);
        $objPHPExcel->getActiveSheet(8)->setTitle('Variables Measured');
        $QUERY07 = Doctrine_Query::create()
                ->select("V.id_variablesmeasured, V.vrmsname")
                ->addSelect("C.crpname AS crop")
                ->addSelect("T.trclname AS traitclass")
                ->from("tbVariablesmeasured V")
                ->innerJoin("V.TbCrop C")
                ->innerJoin("V.TbTraitclass T")
                ->where("V.id_variablesmeasured IN ($list_variablesmeasureds)")
                ->orderBy('C.crpname, T.trclname, V.vrmsname');
//        echo $QUERY07->getSqlQuery(); die();
        $Resultado07 = $QUERY07->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Technology');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Trait class');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Name');
        foreach ($Resultado07 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id_variablesmeasured);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->crop);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila->traitclass);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $fila->vrmsname);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B:D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

//fin: GENERAMOS EL LIBRO DE VARIABLES MEASURED
//inicio: GENERAMOS EL LIBRO DE USUARIOS
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(9);
        $objPHPExcel->getActiveSheet(9)->setTitle('Specified users');
        $QUERY08 = Doctrine_Query::create()
                ->select("U.id, (U.first_name||' '||U.last_name) AS name")
                ->from("SfGuardUser U")
                ->where("U.id <> 1")
                ->orderBy("U.first_name,U.last_name");
        $Resultado08 = $QUERY08->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado08 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->name);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

//fin: GENERAMOS EL LIBRO DE USUARIOS
//ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="TrialTemplate.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeTemplatedownload(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();

//AQUI CONSULTAMOS LA VARIEDADES SELECIONADAS Y GENERAMOS LA CADENA LA CREAR EL SELECT CON ESTOS DATOS
        $SS_replications = $user->getAttribute('replications');
        $SS_varieties_id = $user->getAttribute('varieties_id');
        if ($user->getAttribute('numbertrials') == "") {
            $numbertrials = 1;
        } else {
            $numbertrials = $user->getAttribute('numbertrials');
        }

        $list_varieties = "";
        foreach ($SS_varieties_id AS $varieties_id) {
            $list_varieties .= $varieties_id . ",";
        }
        $list_varieties = substr($list_varieties, 0, strlen($list_varieties) - 1);

//AQUI CONSULTAMOS LAS VARIABLES MEDIDAS SELECIONADAS Y GENERAMOS LA CADENA LA CREAR EL SELECT CON ESTOS DATOS
        $SS_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
        $list_variablesmeasureds = "";
        foreach ($SS_variablesmeasured_id AS $variablesmeasured_id) {
            $list_variablesmeasureds .= $variablesmeasured_id . ",";
        }
        $list_variablesmeasureds = substr($list_variablesmeasureds, 0, strlen($list_variablesmeasureds) - 1);

        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(600);
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("Template Trial Data")
                ->setSubject("Template Trial Data")
                ->setDescription("Template Trial Data")
                ->setKeywords("Template Trial Data")
                ->setCategory("Template Trial Data");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet(0)->setTitle('Template Trial Data');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Exp-code');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Replication');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Varieties/Races');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

//AQUI GENERAMOS LAS FILA DE VARIABLES MEDIDAS
        $letter = "C";
        foreach ($SS_variablesmeasured_id AS $variablesmeasured_id) {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT VM.id_variablesmeasured, VM.vrmsname, VM.vrmsunit AS unit ";
            $QUERY00 .= "FROM tb_variablesmeasured VM ";
            $QUERY00 .= "WHERE VM.id_variablesmeasured = $variablesmeasured_id ";
            $st = $connection->execute($QUERY00);
            $Resultado02 = $st->fetchAll();
            foreach ($Resultado02 AS $fila) {
                $Vrmsname = $fila['vrmsname'];
                $Unit = $fila['unit'];
            }
//$NameVariablesmeasured = "$variablesmeasured_id-$Vrmsname-($Unit)";
            $NameVariablesmeasured = "$Vrmsname";
            $TbVariablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($variablesmeasured_id);
            $Vrmsname = $TbVariablesmeasured->getVrmsname();
            $letter = NextLetter($letter);
            $objPHPExcel->getActiveSheet()->setCellValue($letter . '1', $NameVariablesmeasured);
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($letter . '1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle($letter . '1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        }
        $objPHPExcel->getActiveSheet()->protectCells("A1:" . $letter . "1");
//AQUI GENERAMOS LAS COLUMNAS DE REPLICACION Y VARIEDADES
        $i = 2;
        for ($NT = 1; $NT <= $numbertrials; $NT++) {
            for ($a = 1; $a <= $SS_replications; $a++) {
                foreach ($SS_varieties_id AS $varieties_id) {
                    $TbVariety = Doctrine::getTable('TbVariety')->findOneByIdVariety($varieties_id);
                    $Vrtname = $TbVariety->getVrtname();
//$NameVariety = "$Vrtname | ($varieties_id)";
                    $NameVariety = "$Vrtname";
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $NT);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $a);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $NameVariety);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);
                    $i++;
                }
            }
        }
//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $letter . '1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

//APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Template Trial Data');

//inicio: GENERAMOS EL LIBRO DE VARIEDADES
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Validated varieties');
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Validated varieties');
        foreach ($SS_varieties_id AS $varieties_id) {
            $TbVariety = Doctrine::getTable('TbVariety')->findOneByIdVariety($varieties_id);
            $Vrtname = $TbVariety->getVrtname();
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Vrtname);
            $i++;
        }
//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE VARIEDADES
//inicio: GENERAMOS EL LIBRO DE VARIABLES MEDIDAS
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet(2)->setTitle('Selected-Measured Variables');
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Selected-Measured Variables');
        foreach ($SS_variablesmeasured_id AS $variablesmeasured_id) {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT VM.id_variablesmeasured, VM.vrmsname, VM.vrmsunit AS unit ";
            $QUERY00 .= "FROM tb_variablesmeasured VM ";
            $QUERY00 .= "WHERE VM.id_variablesmeasured = $variablesmeasured_id ";
            $st = $connection->execute($QUERY00);
            $Resultado02 = $st->fetchAll();
            foreach ($Resultado02 AS $fila) {
                $Vrmsname = $fila['vrmsname'];
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Vrmsname);
            $i++;
        }
//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE VARIABLES MEDIDAS
//ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="TrialDataTemplate.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeUpload(sfWebRequest $request) {
        //PARAMETROS MAXIMOS
        $MaxRecordsFile = 1000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB
        $MaxSizeFileZip = 20;

        $connection = Doctrine_Manager::getInstance()->connection();
        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $TmpUploadDir = $UploadDir . "/tmp$id_user";
        $metadata_uploads = $UploadDir . "/metadata";
        if (!is_dir($metadata_uploads)) {
            mkdir($metadata_uploads, 0777);
        }
        rrmdir($TmpUploadDir);

        //ARCHIVO DE ARCHIVOS COMPRIMIDOS
        $CompressedFiles = $request->getFiles('file');
        $CompressedFilesSize = $CompressedFiles['size'];
        $CompressedFilesType = $CompressedFiles['type'];
        $CompressedFilesName = $CompressedFiles['name'];
        $CompressedFilesTmpName = $CompressedFiles['tmp_name'];
        $CompressedFilesSizeMB = round(($CompressedFilesSize / 1048576), 2);

        //INICIO: AQUI SUBIMOS Y DESCOMPRIMIMOS LOS ARCHIVOS
        if ($CompressedFilesName != '') {
            $extension = explode(".", $CompressedFilesName);
            $CompressedFilesExt = strtoupper($extension[1]);
            if ((!($CompressedFilesExt == "ZIP")) || ($CompressedFilesSizeMB > $MaxSizeFileZip)) {
                $Forma = "TrialFileErrorZip";
                die(include("../lib/html/HTML.php"));
            } else {
                if (!is_dir($TmpUploadDir)) {
                    mkdir($TmpUploadDir, 0777);
                }
                move_uploaded_file($CompressedFilesTmpName, "$TmpUploadDir/$CompressedFilesName");
                $archive = new PclZip("$TmpUploadDir/$CompressedFilesName");
                if ($archive->extract(PCLZIP_OPT_PATH, $TmpUploadDir) == 0) {
                    unlink("$TmpUploadDir/$CompressedFilesName");
                    $ErrorInfo = $archive->errorInfo(true);
                    $Forma = "TrialFileErrorZipUncompress";
                    die(include("../lib/html/HTML.php"));
                }
                unlink("$TmpUploadDir/$CompressedFilesName");
            }
        }

        //ARCHIVO DE DATOS DE ENSAYOS
        $TrialDataFile = $request->getFiles('data');
        $TrialDataFileSize = $TrialDataFile['size'];
        $TrialDataFileType = $TrialDataFile['type'];
        $TrialDataFileName = $TrialDataFile['name'];
        $TrialDataFileTmpName = $TrialDataFile['tmp_name'];
        $TrialDataFileSizeMB = round(($TrialDataFileSize / 1048576), 2);

        //ARCHIVO DE ENSAYOS
        $TrialFile = $request->getFiles('metadata');
        $TrialFileSize = $TrialFile['size'];
        $TrialFileType = $TrialFile['type'];
        $TrialFileName = $TrialFile['name'];
        $TrialFileTmpName = $TrialFile['tmp_name'];
        $TrialFileSizeMB = round(($TrialFileSize / 1048576), 2);

        if ($TrialFileName != '') {
            $extension = explode(".", $TrialFileName);
            $TrialFileExt = strtoupper($extension[1]);
            if ((!($TrialFileExt == "XLS")) || ($TrialFileSizeMB < 0) || ($TrialFileSizeMB > 5) || ($TrialDataFileSizeMB > 5)) {
                $Forma = "TrialFileErrorTemplates";
                die(include("../lib/html/HTML.php"));
            }

            move_uploaded_file($TrialFileTmpName, "$metadata_uploads/$TrialFileName");
            $InputFileTrial = "$metadata_uploads/$TrialFileName";
            $ExcelFileTrial = new Spreadsheet_Excel_Reader();
            $ExcelFileTrial->setOutputEncoding('UTF-8');
            $ExcelFileTrial->read($InputFileTrial);
            error_reporting(E_ALL ^ E_NOTICE);
            $NumRows = $ExcelFileTrial->sheets[0]['numRows'];
            $NumCols = $ExcelFileTrial->sheets[0]['numCols'];
            $TotalRecord = $NumRows - 1;

            if (($TotalRecord > 300) && ($TrialDataFileName != '')) {
                $Forma = "TrialFileErrorTemplatesRecord";
                $MaxRecord = 300;
                die(include("../lib/html/HTML.php"));
            }

            if (($TotalRecord > 1000) && ($TrialDataFileName == '')) {
                $Forma = "TrialFileErrorTemplatesRecord";
                $MaxRecord = 1000;
                die(include("../lib/html/HTML.php"));
            }

            $Forma = "TrialBody";
            include("../lib/html/HTML.php");
            $error_filas = "";
            $grabados = 0;
            $errores = 0;
            $ArrTrial = null;
            for ($row = 2; $row <= $NumRows; ++$row) {
                $banderaerrorfila = false;
                $ExpCode = trim($ExcelFileTrial->sheets[0]['cells'][$row][1]);
                $id_trialgroup = trim($ExcelFileTrial->sheets[0]['cells'][$row][2]);
                $id_contactperson = trim($ExcelFileTrial->sheets[0]['cells'][$row][3]);
                $id_country = trim($ExcelFileTrial->sheets[0]['cells'][$row][4]);
                $id_trialsite = trim($ExcelFileTrial->sheets[0]['cells'][$row][5]);
                $id_fieldnamenumber = trim($ExcelFileTrial->sheets[0]['cells'][$row][6]);
                if (trim($ExcelFileTrial->sheets[0]['cells'][$row][7]) != '')
                    $id_crop = trim($ExcelFileTrial->sheets[0]['cells'][$row][7]);
                $trlvarieties = trim($ExcelFileTrial->sheets[0]['cells'][$row][8]);
                $trlvariablesmeasured = trim($ExcelFileTrial->sheets[0]['cells'][$row][9]);
                $trlname = trim($ExcelFileTrial->sheets[0]['cells'][$row][10]);
                $trlname = str_replace("'", "''", $trlname);
                $trlname = ucfirst(mb_strtolower($trlname, 'UTF-8'));
                $trlname = mb_convert_encoding($trlname, 'UTF-8');

                $trlsowdate = $ExcelFileTrial->sheets[0]['cells'][$row][11];
                $trlharvestdate = $ExcelFileTrial->sheets[0]['cells'][$row][12];

                $trltrialresultsfile = trim($ExcelFileTrial->sheets[0]['cells'][$row][13]);
                $trlsupplementalinformationfile = trim($ExcelFileTrial->sheets[0]['cells'][$row][14]);
                $trlweatherduringtrialfile = trim($ExcelFileTrial->sheets[0]['cells'][$row][15]);
                $trlsoiltypeconditionsduringtrialfile = trim($ExcelFileTrial->sheets[0]['cells'][$row][16]);
                $trllicense = $ExcelFileTrial->sheets[0]['cells'][$row][17];
                $trllicense = mb_convert_encoding($trllicense, 'UTF-8');
                $trlfileaccess = trim($ExcelFileTrial->sheets[0]['cells'][$row][18]);
                $specified_users_groups = trim($ExcelFileTrial->sheets[0]['cells'][$row][19]);
                $trltrialtype = trim($ExcelFileTrial->sheets[0]['cells'][$row][20]);

                //ACONDICIONAMIENTO DE CAMPOS
                if ($id_fieldnamenumber == '')
                    $id_fieldnamenumber = null;
                if ($trlharvestdate == '')
                    $trlharvestdate = null;
                if ($TrialDataFileName != '') {
                    $trlvarieties = "N/A";
                    $trlvariablesmeasured = "N/A";
                } else {
                    $ArrVarieties = explode(",", $trlvarieties);
                    $ArrVarietiesOK = array_values(array_diff($ArrVarieties, array('')));
                    $trlvarieties = implode(",", $ArrVarietiesOK);
                    $ArrVariablesmeasured = explode(",", $trlvariablesmeasured);
                    $ArrVariablesmeasuredOK = array_values(array_diff($ArrVariablesmeasured, array('')));
                    $trlvariablesmeasured = implode(",", $ArrVariablesmeasuredOK);
                }
                if ($trlfileaccess == "Public") {
                    $trlfileaccess = 'Public domain';
                    $specified_users_groups = '';
                } else if ($trlfileaccess == "All") {
                    $trlfileaccess = 'Open to all users';
                    $specified_users_groups = '';
                } else if ($trlfileaccess == "Users") {
                    $trlfileaccess = 'Open to specified users';
                } else if ($trlfileaccess == "Groups") {
                    $trlfileaccess = 'Open to specified groups';
                }
                if ($trltrialtype == '')
                    $trltrialtype = "Real";


                //AQUI VALIDAMOS LOS TODOS LOS CAMPOS
                $Fields = '{"' . $ExpCode . '","' . $id_trialgroup . '","' . $id_contactperson . '","' . $id_country . '","' . $id_trialsite . '","' . $id_fieldnamenumber . '","' . $id_crop . '","' . $trlvarieties . '","' . $trlvariablesmeasured . '","' . $trlname . '","' . $trlsowdate . '","' . $trlharvestdate . '","' . $trltrialresultsfile . '","' . $trlsupplementalinformationfile . '","' . $trlweatherduringtrialfile . '","' . $trlsoiltypeconditionsduringtrialfile . '","' . null . '","' . $trlfileaccess . '","' . $specified_users_groups . '","' . $trltrialtype . '"}';
                $Fields = str_replace("'", "''", $Fields);
                $Fields = utf8_encode($Fields);
                $QUERY = "SELECT fc_checkfieldsbatchtrial('$Fields'::text[]) AS info;";
                //die($QUERY);
                $st = $connection->execute($QUERY);
                $Result = $st->fetchAll();
                if (count($Result) > 0) {
                    $info = null;
                    foreach ($Result AS $Value) {
                        $info = $Value['info'];
                        if ($info != "OK")
                            $banderaerrorfila = true;
                    }
                }

                if ($info == "OK") {
                    //MOVEMOS AL DESTINO FINAL ARCHIVO TRIAL RESULTS FILE
                    if ($trltrialresultsfile != '')
                        $trltrialresultsfile = MoveFile($UploadDir, $TmpUploadDir, $trltrialresultsfile);

                    //MOVEMOS AL DESTINO FINAL ARCHIVO SUPPLEMENTAL INFORMATION FILE
                    if ($trlsupplementalinformationfile != '')
                        $trlsupplementalinformationfile = MoveFile($UploadDir, $TmpUploadDir, $trlsupplementalinformationfile);

                    //MOVEMOS AL DESTINO FINAL ARCHIVO WEATHER DURING TRIAL FILE
                    if ($trlweatherduringtrialfile != '')
                        $trlweatherduringtrialfile = MoveFile($UploadDir, $TmpUploadDir, $trlweatherduringtrialfile);

                    //MOVEMOS AL DESTINO FINAL ARCHIVO SOIL TYPE CONDITIONS DURING TRIAL FILE
                    if ($trlsoiltypeconditionsduringtrialfile != '')
                        $trlsoiltypeconditionsduringtrialfile = MoveFile($UploadDir, $TmpUploadDir, $trlsoiltypeconditionsduringtrialfile);
                }

                if ($banderaerrorfila)
                    $error_filas .= "<b>Fila $row:</b> (" . substr($info, 2, (strlen($info) - 1)) . ") <br>";

                if (!$banderaerrorfila) {
                    //GRABAMOS EL REGISTRO EN LA TABLA TbTrial
                    $id_trial = TbTrialTable::addTrial($id_trialgroup, $id_contactperson, $id_country, $id_trialsite, $id_fieldnamenumber, $id_crop, '', '', $trlname, $trlsowdate, $trlharvestdate, $trltrialresultsfile, $trlsupplementalinformationfile, $trlweatherduringtrialfile, $trlsoiltypeconditionsduringtrialfile, $trllicense, $trlfileaccess, $trltrialtype, $id_user);

                    //GRABAMOS EN LA TABLA DE GOOGLE FUSION TABLE TEMPORAL
                    TbTrialsGftTable::addTrialsGft($id_trial, 'NO');

                    //INICIO: SI NO CONTIENE PLANTILLA DE RESULTADOS REGISTRAMOS LAS VARIEDEDES Y VARIABLES MEDIDAS
                    if ($TrialDataFileName == '') {
                        if ($trlvarieties != '') {
                            $QUERY01 = "SELECT fc_savetrialvariety($id_trial,'$trlvarieties');";
                            $connection->execute($QUERY01);
                        }
                        if ($trlvariablesmeasured != '') {
                            $QUERY02 = "SELECT fc_savetrialvariablesmeasured($id_trial,'$trlvariablesmeasured');";
                            $connection->execute($QUERY02);
                        }
                    }

                    //INICIO: AQUI REGISTRAMOS LOS USUARIOS ESPECIFICADOS EN LA TABLA tb_trialuserpermissionfiles
                    if (($trlfileaccess == "Open to specified users") && ($specified_users_groups != '')) {
                        $QUERY03 = "SELECT fc_savetrialuserpermissionfiles($id_trial,'$specified_users_groups');";
                        $connection->execute($QUERY03);
                    }

                    //INICIO: AQUI REGISTRAMOS LOS USUARIOS ESPECIFICADOS EN LA TABLA tb_trialuserpermissionfiles
                    if (($trlfileaccess == "Open to specified groups") && ($specified_users_groups != '')) {
                        $QUERY04 = "SELECT fc_savetrialgrouppermission($id_trial,'$specified_users_groups');";
                        $connection->execute($QUERY04);
                    }

                    //ASIGNAMOS EL ID DEL ENSAYO GRABADO AL ARRAY
                    $ArrTrial[$id_trial] = $ExpCode;

                    $grabados++;
                } else {
                    $errores++;
                }

                $fila_actual = ($row - 1);
                $porcentaje = $fila_actual * 100 / $TotalRecord; //saco mi valor en porcentaje
                echo "<script>callprogress(" . round($porcentaje) . ",$fila_actual,$TotalRecord);</script>";
                flush();
                ob_flush();
                echo "<script>counter($grabados,$errores);</script>";
                flush();
                ob_flush();
            }
        }

        //Inicio: LEEMOS Y GRABAMOS LOS DATOS DEL ENSAYO
        if (($TrialDataFileName != '') && (count($ArrTrial) > 0)) {
            move_uploaded_file($TrialDataFileTmpName, "$metadata_uploads/$TrialDataFileName");
            $inputFileNameData = "$metadata_uploads/$TrialDataFileName";
            $inputFileNameData = str_replace("/", "\\", $inputFileNameData);

            //INICIO:AQUI GRABAMOS LOS DATOS DEL ENSAYO
            $ExcelFile = new Spreadsheet_Excel_Reader();
            $ExcelFile->setOutputEncoding('UTF-8');
            $ExcelFile->read($inputFileNameData);
            error_reporting(E_ALL ^ E_NOTICE);
            $numRows = $ExcelFile->sheets[0]['numRows'];
            $numCols = $ExcelFile->sheets[0]['numCols'];
            $TotRegDat = $numRows - 1;

            //AQUI CAPTURAMOS LAS VARIABLES MEDIDAS
            $Arr_variablesmeasured_id = null;
            for ($col = 4; $col <= $numCols; $col++) {
                $Vrmsname = $ExcelFile->sheets[0]['cells'][1][$col];
                $Vrmsname = mb_strtoupper(trim($Vrmsname), "UTF-8");
                if ($Vrmsname != '') {
                    $QUERY00 = "SELECT V.id_variablesmeasured FROM tb_variablesmeasured V WHERE id_crop = $id_crop AND UPPER(REPLACE(V.vrmsname,' ','')) = UPPER(REPLACE('$Vrmsname',' ',''))";
                    $st = $connection->execute($QUERY00);
                    $Result = $st->fetchAll();
                    if (count($Result) > 0) {
                        foreach ($Result AS $Value) {
                            $Arr_variablesmeasured_id[$col] = $Value['id_variablesmeasured'];
                            break;
                        }
                    }
                }
            }

            //AQUI CAPTURAMOS LAS VARIEDADES
            $Arr_variety_id = null;
            for ($row = 2; $row <= $numRows; ++$row) {
                $Vrtname = $ExcelFile->sheets[0]['cells'][$row][3];
                $Vrtname = mb_strtoupper(trim($Vrtname), "UTF-8");
                if ($Vrtname != '') {
                    $QUERY01 = "SELECT V.id_variety FROM tb_variety V WHERE id_crop = $id_crop AND UPPER(REPLACE(vrtname,' ','')) = UPPER(REPLACE('$Vrtname',' ',''))";
                    $st = $connection->execute($QUERY01);
                    $Result = $st->fetchAll();
                    if (count($Result) > 0) {
                        foreach ($Result AS $Value) {
                            $Arr_variety_id[$row] = $Value['id_variety'];
                            break;
                        }
                    }
                }
            }

            //AQUI CUNSULTAMOS LAS FILAS QUE CONTIENE LAS REPLICACION-VARIEDAD-VALOR VARIABLE MEDIDA
            $ArrVariablesMeasuredSave = null;
            $ArrVarietySave = null;
            $TmpIdTrial = "";
            for ($row = 2; $row <= $numRows; ++$row) {
                $trdtreplication = "";
                $id_variety = "";
                $id_variablesmeasured = "";
                $trvmvalue = "";
                $ExpCodeData = $ExcelFile->sheets[0]['cells'][$row][1];
                $trdtreplication = $ExcelFile->sheets[0]['cells'][$row][2];
                $id_variety = $Arr_variety_id[$row];
                $id_trial = array_search($ExpCodeData, $ArrTrial);
                if ($id_trial != '') {
                    for ($col = 4; $col <= $numCols; $col++) {
                        $id_variablesmeasured = $Arr_variablesmeasured_id[$col];
                        $trvmvalue = $ExcelFile->sheets[0]['cells'][$row][$col];
                        $trvmvalue = mb_convert_encoding($trvmvalue, 'UTF-8');
                        if (($trdtreplication != '') && ($id_variety != '') && ($id_variablesmeasured != '') && ($trvmvalue != '')) {
                            TbTrialdataTable::addData($id_trial, $trdtreplication, $id_variety, $id_variablesmeasured, $trvmvalue);
                        }
                    }
                }

                $fila_actual = ($row - 1);
                $porcentajeData = $fila_actual * 100 / $TotRegDat; //saco mi valor en porcentaje
                echo "<script>callprogressData(" . round($porcentajeData) . ", $fila_actual, $TotRegDat);</script>";
                flush();
                ob_flush();
            }
            //FIN:AQUI GRABAMOS LOS DATOS DEL ENSAYO
        }

        if (count($ArrTrial) > 0) {
            $ListTrials = implode(",", array_keys($ArrTrial));
            if ($ListTrials != '')
                $connection->execute("SELECT fc_savetrialvarietyvariablesmeasured('$ListTrials', $id_user);");
        }

        $TmpUploadDir = str_replace('/', '\\', $TmpUploadDir);
        if (@chdir($TmpUploadDir)) {
            $command = "rmdir /s /q " . $TmpUploadDir;
            exec($command);
        }

        echo "<script>FinishedProcess();</script>";
        if ($errores > 0)
            echo "<script>errores('$error_filas');</script>";
        die();
    }

    public function executeGetidcrop($request) {
        
    }

    public function executeGetidcropvariablesmeasured($request) {
        
    }

//    public function executeVarieties($request) {
//        $this->setLayout(false);
//    }
//    public function executeVariablesmeasured($request) {
//        $this->setLayout(false);
//    }

    public function executeSpecifiedusers($request) {
        $this->setLayout(false);
    }

    public function executeSpecifiedgroups($request) {
        $this->setLayout(false);
    }

    public function executeTrials($request) {
        $this->setLayout(false);
    }

    public function executeCountries($request) {
        $this->setLayout(false);
    }

    public function executeSavevarieties(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $array_varieties = sfContext::getInstance()->getRequest()->getParameterHolder()->get('varieties');
        $varieties_id = $array_varieties['user']['id'];
        $varieties_name = $array_varieties['user']['title'];
        $list_variety = "";
        $session_varieties_id = array();
        $session_varieties_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        foreach ($varieties_id as $key => $id_variety) {
            $session_varieties_id[] = $id_variety;
            $user->setAttribute('varieties_id', $session_varieties_id);
            $session_varieties_name[] = $varieties_name[$key];
            $user->setAttribute('varieties_name', $session_varieties_name);
            $list_variety_id .= $id_variety . ", ";
            $list_variety .= $varieties_name[$key] . ", ";
        }
        $list_variety_id = substr($list_variety_id, 0, strlen($list_variety_id) - 2);
        $list_variety = substr($list_variety, 0, strlen($list_variety) - 2);
        $this->name = $list_variety;

//GENERACION CODIGO HTML PARA LOS DATOS DE RESULTADOS
        $this->html = SesionTrialData();
    }

    public function executeValidatelistvarieties(sfWebRequest $request) {
        $connection = Doctrine_Manager::getInstance()->connection();
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $listvarieties = $request->getParameter('listvarieties');
        $Arr_varieties = explode(", ", $listvarieties);
        $ListVarieties = "";
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        foreach ($Arr_varieties AS $variety) {
            $variety = strtoupper(trim($variety));
            $variety = utf8_encode($variety);
            $ListVarieties .= "'$variety', ";
        }
        $ListVarieties = substr($ListVarieties, 0, strlen($ListVarieties) - 2);
        $QUERY = "SELECT id_variety, vrtname FROM tb_variety WHERE UPPER(vrtname) IN ($ListVarieties) AND id_crop = $id_crop";
//die($QUERY);
        $ValidateVarieties = $connection->execute($QUERY);
        $R_ValidateVarieties = $ValidateVarieties->fetchAll();
        foreach ($R_ValidateVarieties AS $Value) {
            $session_varieties_id[] = $Value[0];
            $user->setAttribute('varieties_id', $session_varieties_id);
            $session_varieties_name[] = $Value[1];
            $user->setAttribute('varieties_name', $session_varieties_name);
            $list_variety_id .= $id_variety . ", ";
            $list_variety .= $Value[1] . ", ";
        }
        $list_variety_id = substr($list_variety_id, 0, strlen($list_variety_id) - 2);
        $list_variety = substr($list_variety, 0, strlen($list_variety) - 2);

//CONSULTAMOS LOS REGISTROS NO ENCONTRADOS
        $ListVarieties = utf8_encode(strtoupper($ListVarieties));
        $list_variety = utf8_encode(strtoupper($list_variety));
//echo "$ListVarieties **** $list_variety"; die("Stop");

        $ORG_ARRAY = explode(", ", str_replace("'", "", $ListVarieties));
        $NEW_ARRAY = explode(",", str_replace(", ", ",", $list_variety));
        $error_variety = NotInArray($ORG_ARRAY, $NEW_ARRAY);
//die("e:".$error_variety);

        if (!(isset($list_variety)))
            $arr_data['data'] = '';
        else
            $arr_data['data'] = $list_variety;

        if (!(isset($error_variety)))
            $arr_data['error'] = '';
        else
            $arr_data['error'] = utf8_decode($error_variety);

//GENERACION CODIGO HTML PARA LOS DATOS DE RESULTADOS
        $this->html = SesionTrialData();
        die(json_encode($arr_data));
    }

//AQUI SE GUARDA EN UN ARREGLO TEMPORAL DE SESION LAS VARIABLES MEDIDAS
    public function executeAddrow(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $trialdata = $user->getAttribute('trialdata');
        $replication = $request->getParameter('replication');
        $id_variety = $request->getParameter('id_variety');
        $id_variablesmeasured = $request->getParameter('id_variablesmeasured');
        $value = $request->getParameter('value');
        $unit = $request->getParameter('unit');
        $trialdata[] = array('replication' => $replication, 'id_variety' => $id_variety, 'id_variablesmeasured' => $id_variablesmeasured, 'value' => $value, 'unit' => $unit);
        $user->setAttribute('trialdata', $trialdata);
        die(SesionTrialData());
    }

//AQUI SE ELIMINA UN REGISTRO DEL ARREGLO TEMPORAL DE SESION LAS VARIABLES MEDIDAS
    public function executeDeleterow(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $trialdata = $user->getAttribute('trialdata');
        $id = $request->getParameter('id');

        $id_crop = $user->getAttribute('id_crop');
        $varieties_id = $user->getAttribute('varieties_id');
        foreach ($varieties_id as $key => $id_variety) {
            $list_variety_id .= $id_variety . ", ";
        }
        $list_variety_id = substr($list_variety_id, 0, strlen($list_variety_id) - 2);

        foreach ($trialdata as $key => $value) {
            if ($key != $id) {
                $trialdata_tmp[] = $value;
            }
        }
        $user->setAttribute('trialdata', $trialdata_tmp);
        die(SesionTrialData());
    }

//AQUI SE ELIMINAN DATOS POR CAMBIO DE CULTIVO
    public function executeCleardatacrops(sfWebRequest $request) {
        $id_crop = $request->getParameter('id_crop');
        if ($id_crop != '')
            sfContext::getInstance()->getUser()->setAttribute('id_crop', $id_crop);
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialdata');
        die("");
    }

//AQUI SE CAMBIA EL NUMERO DE REPLICACION EN LA SESSION
    public function executeChangereplications(sfWebRequest $request) {
        $trlreplications = $request->getParameter('replications');
        sfContext::getInstance()->getUser()->setAttribute('replications', $trlreplications);
        die("");
    }

//AQUI SE OPTINE LA UNIDAD DE LA VARIABLE MEDIDA
    public function executeGetunitvariablesmeasured(sfWebRequest $request) {
        $id_variablesmeasured = $request->getParameter('id_variablesmeasured');
        $consulta = Doctrine_Query::create()
                ->select("V.*")
                ->from("TbVariablesmeasured V")
                ->Where("V.id_variablesmeasured = $id_variablesmeasured");
//echo $consulta->getSqlQuery(); die();
        foreach ($consulta->execute() as $valor) {
            $Unit = trim($valor['vrmsunit']);
        }
        if ($Unit != '')
            die($Unit);
        else
            die("N.A.");
    }

    public function executeSavevariablesmeasured(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_variablesmeasured = sfContext::getInstance()->getRequest()->getParameterHolder()->get('variablesmeasured');
        $variablesmeasured_id = $array_variablesmeasured['user']['id'];
        $variablesmeasured_name = $array_variablesmeasured['user']['title'];
        $list_variablesmeasured = "";
        $session_variablesmeasured_id = array();
        $session_variablesmeasured_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        foreach ($variablesmeasured_id as $key => $id_variablesmeasured) {
            $session_variablesmeasured_id[] = $id_variablesmeasured;
            $user->setAttribute('variablesmeasured_id', $session_variablesmeasured_id);
            $session_variablesmeasured_name[] = $variablesmeasured_name[$key];
            $user->setAttribute('variablesmeasured_name', $session_variablesmeasured_name);
            $list_variablesmeasured .= $variablesmeasured_name[$key] . ", ";
        }

        $list_variablesmeasured = substr($list_variablesmeasured, 0, strlen($list_variablesmeasured) - 2);
        $this->name = $list_variablesmeasured;

//GENERACION CODIGO HTML PARA LOS DATOS DE RESULTADOS
        $this->html = SesionTrialData();
    }

    public function executeSavespecifiedusers(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_users = sfContext::getInstance()->getRequest()->getParameterHolder()->get('users');
        $user_id = $array_users['user']['id'];
        $user_name = $array_users['user']['title'];
        $list_user = "";
        $session_user_id = array();
        $session_user_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
        foreach ($user_id as $key => $id_user) {
            $session_user_id[] = $id_user;
            $user->setAttribute('user_id', $session_user_id);
            $session_user_name[] = $user_name[$key];
            $user->setAttribute('user_name', $session_user_name);
            $list_user .= $user_name[$key] . ", ";
        }
        $list_user = substr($list_user, 0, strlen($list_user) - 2);
        $this->name = $list_user;
    }

    public function executeSavespecifiedgroups(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_groups = sfContext::getInstance()->getRequest()->getParameterHolder()->get('groups');
        $group_id = $array_groups['user']['id'];
        $group_name = $array_groups['user']['title'];
        $list_group = "";
        $session_group_id = array();
        $session_group_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('group_name');
        foreach ($group_id as $key => $id_group) {
            $session_group_id[] = $id_group;
            $user->setAttribute('group_id', $session_group_id);
            $session_group_name[] = $group_name[$key];
            $user->setAttribute('group_name', $session_group_name);
            $list_group .= $group_name[$key] . ", ";
        }
        $list_group = substr($list_group, 0, strlen($list_group) - 2);
        $this->name = $list_group;
    }

    public function executeSavetrials(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_trials = sfContext::getInstance()->getRequest()->getParameterHolder()->get('trials');
        $trial_id = $array_trials['user']['id'];
        $trial_name = $array_trials['user']['title'];
        $list_trial = "";
        $session_trial_id = array();
        $session_trial_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_name');
        foreach ($trial_id as $key => $id_trial) {
            $session_trial_id[] = $id_trial;
            $user->setAttribute('trial_id', $session_trial_id);
            $session_trial_name[] = $trial_name[$key];
            $user->setAttribute('trial_name', $session_trial_name);
            $list_trial .= $trial_name[$key] . ", ";
        }
        $list_trial = substr($list_trial, 0, strlen($list_trial) - 2);
        $this->name = $list_trial;
    }

    public function executeSavecountries(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_countries = sfContext::getInstance()->getRequest()->getParameterHolder()->get('countries');
        $country_id = $array_countries['user']['id'];
        $country_name = $array_countries['user']['title'];
        $list_country = "";
        $session_countries_id = array();
        $session_countries_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('countries_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('countries_name');
        foreach ($country_id as $key => $id_country) {
            $session_countries_id[] = $id_country;
            $user->setAttribute('countries_id', $session_countries_id);
            $session_countries_name[] = $country_name[$key];
            $user->setAttribute('countries_name', $session_countries_name);
            $list_country .= $country_name[$key] . ", ";
        }
        $list_country = substr($list_country, 0, strlen($list_country) - 2);
        $this->name = $list_country;
    }

    public function executeAutovarieties($request) {
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $dato = strtolower($request->getParameter('term'));
        $QUERY01 = Doctrine_Query::create()
                ->select("V.id_variety AS id, V.vrtname AS name")
                ->from("TbVariety V")
                ->where("V.id_crop = $id_crop")
                ->andWhere("LOWER(V.vrtname) LIKE '$dato%'")
                ->orderBy("V.vrtname")
                ->limit(20);
        $Resultado01 = $QUERY01->execute();
        $rv = "";
        foreach ($Resultado01 AS $fila) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($fila['name'], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $fila['id'] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeAutovariablesmeasured($request) {
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $dato = strtolower($request->getParameter('term'));
        $QUERY01 = Doctrine_Query::create()
                ->select("V.id_variablesmeasured AS id, V.vrmsname AS name")
                ->from("TbVariablesmeasured V")
                ->where("V.id_crop = $id_crop")
                ->andWhere("LOWER(V.vrmsname) LIKE '$dato%'")
                ->orderBy("V.vrmsname")
                ->limit(20);
        $Resultado01 = $QUERY01->execute();
        $rv = "";
        foreach ($Resultado01 AS $fila) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($fila['name'], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $fila['id'] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeAutousers($request) {
        $dato = strtolower($request->getParameter('term'));
        $QUERY01 = Doctrine_Query::create()
                ->select("U.id AS id, (U.first_name||''||U.last_name) AS name")
                ->from("SfGuardUser U")
                ->where("LOWER((U.first_name||''||U.last_name)) LIKE '$dato%'")
                ->orderBy("U.first_name")
                ->limit(20);
        $Resultado01 = $QUERY01->execute();
        $rv = "";
        foreach ($Resultado01 AS $fila) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($fila['name'], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $fila['id'] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeAutogroups($request) {
        $dato = strtolower($request->getParameter('term'));
        $QUERY01 = Doctrine_Query::create()
                ->select("G.id AS id, (G.name) AS name")
                ->from("SfGuardGroup G")
                ->where("LOWER(G.name) LIKE '$dato%'")
                ->orderBy("G.name")
                ->limit(20);
        $Resultado01 = $QUERY01->execute();
        $rv = "";
        foreach ($Resultado01 AS $fila) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($fila['name'], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $fila['id'] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeAutotrials($request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        $dato = strtolower($request->getParameter('term'));

        $QUERY01 = Doctrine_Query::create()
                ->select("T.*,T.id_trial AS id, (CR.crpname||' - '||TS.trstname||' - '||T.trlname) AS name")
                ->from("TbTrial T")
                ->innerJoin("T.TbTrialsite TS")
                ->innerJoin("T.TbCrop CR")
                ->where("LOWER(T.trlname) LIKE '$dato%'")
                ->orderBy("CR.crpname,TS.trstname,T.trlname")
                ->limit(20);

        $Resultado01 = $QUERY01->execute();
        $rv = "";
        foreach ($Resultado01 AS $fila) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($fila['name'], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $fila['id'] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeAutocountries($request) {
        $dato = strtolower($request->getParameter('term'));
        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT CN.id_country AS id, CN.cntname AS name ";
        $QUERY00 .= "FROM tb_trial T ";
        $QUERY00 .= "INNER JOIN tb_country CN ON T.id_country = CN.id_country ";
        $QUERY00 .= "WHERE LOWER(CN.cntname) LIKE LOWER('$dato%') ";
        $QUERY00 .= "GROUP BY CN.id_country, CN.cntname ";
        $QUERY00 .= "ORDER BY CN.cntname ";
        $st = $connection->execute($QUERY00);
        $Result = $st->fetchAll();
        foreach ($Result AS $Value) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($Value[1], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $Value[0] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeAssigncrop($request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_crop');
        $id_crop = $request->getParameter('id_crop');
        $user = sfContext::getInstance()->getUser();
        $user->setAttribute('id_crop', $id_crop);
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        die();
    }

    public function executeResetlistcountries($request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('countries_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('countries_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereCountries');
        die();
    }

    public function executeResetlistsvarieties($request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereVariety');
        die();
    }

    public function executeResetlistsvariablesmeasured($request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereVariablesmeasured');
        die();
    }

    public function executeReloadField($request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereList');
        $ArrayFields = explode(",", $request->getParameter('ArrayFields'));
        $ArrayValuesFields = explode(",", $request->getParameter('ArrayValuesFields'));
        $countries_id = sfContext::getInstance()->getUser()->getAttribute('countries_id');
        $varieties_id = sfContext::getInstance()->getUser()->getAttribute('varieties_id');
        $variablesmeasured_id = sfContext::getInstance()->getUser()->getAttribute('variablesmeasured_id');

        $InfoField['id_trialgroup'] = array("id_trialgroup_list", "tb_trialgroup", "id_trialgroup", "trgrname");
        $InfoField['id_contactperson'] = array("id_contactperson_list", "tb_contactperson", "id_contactperson", "(cnprfirstname||' '||cnprlastname)");
        $InfoField['id_trialsite'] = array("id_trialsite_list", "tb_trialsite", "id_trialsite", "trstname");
        $InfoField['id_crop'] = array("id_crop_list", "tb_crop", "id_crop", "crpname");

        for ($a = 0; $a < count($ArrayFields); $a++) {
            if ($ArrayValuesFields[$a] != '') {
                $Where .= " AND T2.{$ArrayFields[$a]} = {$ArrayValuesFields[$a]} ";
            }
        }

        $Country_id = "";
        if (count($countries_id) > 0) {
            foreach ($countries_id AS $valor) {
                $Country_id .= "$valor,";
            }
        }
        $Country_id = substr($Country_id, 0, (strlen($Country_id) - 1));
        if ($Country_id != "")
            $WhereCountries = " AND T2.id_country IN ($Country_id) ";


        $Variety_id = "";
        if (count($varieties_id) > 0) {
            foreach ($varieties_id AS $valor) {
                $Variety_id .= "$valor,";
            }
        }
        $Variety_id = substr($Variety_id, 0, (strlen($Variety_id) - 1));
        if ($Variety_id != "")
            $WhereVariety = " AND TV.id_variety IN ($Variety_id)";

        $Variablesmeasured_id = "";
        if (count($variablesmeasured_id) > 0) {
            foreach ($variablesmeasured_id AS $valor) {
                $Variablesmeasured_id .= "$valor,";
            }
        }
        $Variablesmeasured_id = substr($Variablesmeasured_id, 0, (strlen($Variablesmeasured_id) - 1));
        if ($Variablesmeasured_id != "")
            $WhereListVariablesMeasured = " AND TVM.id_variablesmeasured IN ($Variablesmeasured_id)";

        sfContext::getInstance()->getUser()->setAttribute('WhereList', $Where);
        sfContext::getInstance()->getUser()->setAttribute('WhereCountries', $WhereCountries);
        sfContext::getInstance()->getUser()->setAttribute('WhereVariety', $WhereVariety);
        sfContext::getInstance()->getUser()->setAttribute('WhereListVariablesMeasured', $WhereListVariablesMeasured);

        $Where = $Where . $WhereCountries . $WhereVariety . $WhereListVariablesMeasured;


        foreach ($InfoField AS $Field => $ArrayInfoField) {
            $Key = array_search($Field, $ArrayFields); // $clave = 2;
            $name = $InfoField[$Field][0];
            $table = $InfoField[$Field][1];
            $idfield = $InfoField[$Field][2];
            $namefield = $InfoField[$Field][3];
            $value = $ArrayValuesFields[$Key];
            $ArrayHTML[$Field . "_list"] = select_from_table_ReloadField($name, $table, $idfield, $namefield, $Where, $value);
        }
        $JSONHTML = json_encode($ArrayHTML);
        die($JSONHTML);
    }

    public function executeList_Comments(sfWebRequest $request) {
        $id_trial = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_trial');
        $trialcomment = sfContext::getInstance()->getRequest()->getParameterHolder()->get('trialcomment');
        if (isset($id_trial) && isset($trialcomment)) {
            $id_user = $this->getUser()->getGuardUser()->getId();
            TbTrialcommentsTable::addTrialcomments($id_trial, $trialcomment, $id_user);
        }
    }

    public function executeList(sfWebRequest $request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $user = sfContext::getInstance()->getUser();
        $id_contactperson = $request->getParameter('id_contactperson_list');
        $id_trialgroup = $request->getParameter('id_trialgroup_list');
        $countries = $request->getParameter('countries');
        $id_trialsite = $request->getParameter('id_trialsite_list');
        $id_crop = $request->getParameter('id_crop_list');
        $varieties = $request->getParameter('varieties');
        $variablesmeasured = $request->getParameter('variablesmeasured');
        $trlname = $request->getParameter('trlname');
        $trlsowdate1 = $request->getParameter('trlsowdate1');
        $trlsowdate2 = $request->getParameter('trlsowdate2');
        $trlharvestdate1 = $request->getParameter('trlharvestdate1');
        $trlharvestdate2 = $request->getParameter('trlharvestdate2');
        $trialtype = $request->getParameter('trialtype');
        $paginar = $request->getParameter('paginar');
        $pagination = $request->getParameter('pagination');

        if ($id_crop != '') {
            $varieties_id = $user->getAttribute('varieties_id');
            $variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
            $Variety_id = "";
            if (count($varieties_id) > 0) {
                foreach ($varieties_id AS $valor) {
                    $Variety_id .= "$valor,";
                }
            }
            $Variety_id = substr($Variety_id, 0, (strlen($Variety_id) - 1));
            $Variablesmeasured_id = "";
            if (count($variablesmeasured_id) > 0) {
                foreach ($variablesmeasured_id AS $valor) {
                    $Variablesmeasured_id .= "$valor,";
                }
            }
            $Variablesmeasured_id = substr($Variablesmeasured_id, 0, (strlen($Variablesmeasured_id) - 1));
            $id_trials = "";
            if ($Variety_id != "") {
                $QUERYTMP1 = Doctrine_Query::create()
                        ->from("TbTrialvariety TVR")
                        ->where("TVR.id_variety IN ($Variety_id)");
                $ResgistrosTMP1 = $QUERYTMP1->execute();
                foreach ($ResgistrosTMP1 AS $fila) {
                    $id_trials .= $fila['id_trial'] . ",";
                }
            }
            if ($Variablesmeasured_id != "") {
                $QUERYTMP2 = Doctrine_Query::create()
                        ->from("TbTrialvariablesmeasured TVM")
                        ->where("TVM.id_variablesmeasured IN ($Variablesmeasured_id)");
                $ResgistrosTMP2 = $QUERYTMP2->execute();
                foreach ($ResgistrosTMP2 AS $fila) {
                    $id_trials .= $fila['id_trial'] . ",";
                }
            }
            $id_trials = substr($id_trials, 0, (strlen($id_trials) - 1));
            if (($Variety_id != '' || $Variablesmeasured_id != '') && $id_trials == '') {
                echo "<script> alert('*** Warning *** \\n\\n There are no records for selected varieties or variable measures!'); window.history.back();</script>";
            }
        } else {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereList');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereVariety');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereListVariablesMeasured');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_crop');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        }
        if (($paginar == '') || ($paginar == '1')) {
            $offset = 0;
            $paginar = 1;
        } else {
            $offset = (($paginar * 10) - 10);
        }
        $where = "";
        if ($id_contactperson != '')
            $where .= " AND T.id_contactperson = $id_contactperson";
        if ($id_trialgroup != '')
            $where .= " AND T.id_trialgroup = $id_trialgroup";
        if ($countries != '') {
            $countries_id = $user->getAttribute('countries_id');
            $country_id = "";
            if (count($countries_id) > 0) {
                foreach ($countries_id AS $valor) {
                    $country_id .= "$valor,";
                }
            }
            $country_id = substr($country_id, 0, (strlen($country_id) - 1));
            $where .= " AND T.id_country IN ($country_id)";
        } else {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('WhereCountries');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('countries_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('countries_name');
        }
        if ($id_trialsite != '')
            $where .= " AND T.id_trialsite = $id_trialsite";
        if ($id_crop != '')
            $where .= " AND T.id_crop = $id_crop";
        if ($id_trials != '')
            $where .= " AND T.id_trial IN ($id_trials)";
        if ($trlname != '')
            $where .= " AND UPPER(T.trlname) LIKE UPPER('%$trlname%')";
        if ($iduser != '')
            $where .= " AND T.id_user = $iduser";
        if (($trlsowdate1 != '')) {
            if ($trlsowdate2 == '')
                $trlsowdate2 = $trlsowdate1;

            $where .= " AND T.trlsowdate BETWEEN '$trlsowdate1' AND '$trlsowdate2'";
        }
        if (($trlharvestdate1 != '')) {
            if ($trlharvestdate2 == '')
                $trlharvestdate2 = $trlharvestdate1;

            $where .= " AND T.trlharvestdate BETWEEN '$trlharvestdate1' AND '$trlharvestdate2'";
        }
        if ($trialtype != '') {
            $where .= " AND T.trltrialtype = '$trialtype'";
        }

        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('wheretrial');

        if ($where != '') {
            $wheretrial = $where;
            $where = "TRUE " . $where;
            $user->setAttribute('wheretrial', $wheretrial);
            $QUERY = Doctrine_Query::create()
                    ->select("COUNT(T.id_trial) AS count")
                    ->from("TbTrial T")
                    ->innerJoin("T.TbContactperson CP")
                    ->innerJoin("T.TbTrialgroup TG")
                    ->innerJoin("T.TbCountry CN")
                    ->innerJoin("T.TbTrialsite TS")
                    ->innerJoin("T.TbCrop CR")
                    ->where($where);
            $Resgistros = $QUERY->execute();
            foreach ($Resgistros AS $fila) {
                $Filas = $fila['count'];
            }
            $paginas = ceil(($Filas / 10));
            if ($pagination == "YES") {
                $QUERY00 = Doctrine_Query::create()
                        ->select("(CP.cnprfirstname||' '||CP.cnprlastname) AS contactperson, TG.trgrname AS trialgroup, CN.cntname AS country, TS.trstname AS trialsite, TS.trstlatitudedecimal AS lat, TS.trstlongitudedecimal AS long, CR.crpname AS crop, T.*")
                        ->from("TbTrial T")
                        ->innerJoin("T.TbContactperson CP")
                        ->innerJoin("T.TbTrialgroup TG")
                        ->innerJoin("T.TbCountry CN")
                        ->innerJoin("T.TbTrialsite TS")
                        ->innerJoin("T.TbCrop CR")
                        ->where($where)
                        ->orderBy("T.id_trial")
                        ->offset($offset)
                        ->limit(10);
            } else {
                $QUERY00 = Doctrine_Query::create()
                        ->select("(CP.cnprfirstname||' '||CP.cnprlastname) AS contactperson, TG.trgrname AS trialgroup, CN.cntname AS country, TS.trstname AS trialsite, TS.trstlatitudedecimal AS lat, TS.trstlongitudedecimal AS long, CR.crpname AS crop, T.*")
                        ->from("TbTrial T")
                        ->innerJoin("T.TbContactperson CP")
                        ->innerJoin("T.TbTrialgroup TG")
                        ->innerJoin("T.TbCountry CN")
                        ->innerJoin("T.TbTrialsite TS")
                        ->innerJoin("T.TbCrop CR")
                        ->where($where)
                        ->orderBy("T.id_trial");
            }

            //echo $QUERY00->getSqlQuery();
            //die();
            $vwtrial = new Doctrine_View($QUERY00, 'vw_trial');
            $vwtrial->create();
            $listtrial = $QUERY00->execute();
            $vwtrial->drop();
            $this->listtrial = $listtrial;
            $this->rows = $Filas;
        } elseif (($where == '') && ($pagination != '')) {
            echo "<script> alert('*** Warning *** \\n\\n Please select one or more filters!'); window.history.back();</script>";
        }

//PAGINACION
        if (($paginar - 1) > 1)
            $paginaprev = $paginar - 1;
        else
            $paginaprev = 1;

        if (($paginar + 1) >= $paginas)
            $paginanext = $paginas;
        else
            $paginanext = $paginar + 1;

        $this->id_contactperson = $id_contactperson;
        $this->id_trialgroup = $id_trialgroup;
        $this->countries = $countries;
        $this->id_trialsite = $id_trialsite;
        $this->id_crop = $id_crop;
        $this->varieties = $varieties;
        $this->variablesmeasured = $variablesmeasured;
        $this->trlname = $trlname;
        $this->iduser = $iduser;
        $this->trlsowdate1 = $trlsowdate1;
        $this->trlsowdate2 = $trlsowdate2;
        $this->trlharvestdate1 = $trlharvestdate1;
        $this->trlharvestdate2 = $trlharvestdate2;
        $this->trialtype = $trialtype;
        $this->pagination = $pagination;
        $this->paginar = $paginar;
        $this->pagina = $pagina;
        $this->paginas = $paginas;
        $this->paginaprev = $paginaprev;
        $this->paginanext = $paginanext;
    }

//INICIO: Acciones lista de trial
    public function executeListvarieties($request) {
        $this->setLayout(false);
    }

    public function executeListvariablesmeasured($request) {
        $this->setLayout(false);
    }

    public function executeSavelistvarieties(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $list_variety = "";
        $session_varieties_id = array();
        $session_varieties_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        $Datos = $request->getParameter('datos');
        for ($i = 1; $i <= $Datos; $i++) {
            $Valor = $request->getParameter('varieties' . $i);
            if ($Valor != '') {
                $session_varieties_id[] = $Valor;
                $user->setAttribute('varieties_id', $session_varieties_id);
                $TbVariety = Doctrine::getTable('TbVariety')->findOneByIdVariety($Valor);
                $name = $TbVariety->getVrtname();
                $session_varieties_name[] = $name[$key];
                $user->setAttribute('varieties_name', $session_varieties_name);
                $list_variety .= $name . ", ";
            }
        }
        $list_variety = substr($list_variety, 0, strlen($list_variety) - 2);
        $this->name = $list_variety;

//GENERACION CODIGO HTML PARA LOS DATOS DE RESULTADOS
        $this->html = SesionTrialData();
    }

    public function executeSavelistvariablesmeasured(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $list_variablesmeasured = "";
        $session_variablesmeasured_id = array();
        $session_variablesmeasured_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        $Datos = $request->getParameter('datos');
        for ($i = 1; $i <= $Datos; $i++) {
            $Valor = $request->getParameter('variablesmeasured' . $i);
            if ($Valor != '') {
                $session_variablesmeasured_id[] = $Valor;
                $user->setAttribute('variablesmeasured_id', $session_variablesmeasured_id);
                $TbVariablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($Valor);
                $name = $TbVariablesmeasured->getVrmsname();
                $session_variablesmeasured_name[] = $name[$key];
                $user->setAttribute('variablesmeasured_name', $session_variablesmeasured_name);
                $list_variablesmeasured .= $name . ", ";
            }
        }
        $list_variablesmeasured = substr($list_variablesmeasured, 0, strlen($list_variablesmeasured) - 2);
        $this->name = $list_variablesmeasured;

//GENERACION CODIGO HTML PARA LOS DATOS DE RESULTADOS
        $this->html = SesionTrialData();
    }

    public function executeDownloadexcel(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $wheretrial = $user->getAttribute('wheretrial');
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(600);
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("")
                ->setSubject("Trials List")
                ->setDescription("Trials List")
                ->setKeywords("Trials List")
                ->setCategory("Trials List");

// Add some data

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Trials')
                ->setCellValue('B1', 'Trial group')
                ->setCellValue('C1', 'Contact person')
                ->setCellValue('D1', 'Country')
                ->setCellValue('E1', 'Trial site')
                ->setCellValue('F1', 'Latitude')
                ->setCellValue('G1', 'Longitude')
                ->setCellValue('H1', 'Crop')
                ->setCellValue('I1', 'Trial Name')
                ->setCellValue('J1', 'Varieties')
                ->setCellValue('K1', 'Variables measured')
                ->setCellValue('L1', 'Sow date')
                ->setCellValue('M1', 'Harvest date')
                ->setCellValue('N1', 'Trial type')
                ->setCellValue('O1', 'Irrigation')
                ->setCellValue('P1', 'Link');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Trials');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT T.id_trial,TG.trgrname,(CP.cnprfirstname||' '||CP.cnprlastname),CN.cntname,TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal,C.crpname, ";
        $QUERY00 .= "T.trlname,fc_trialvarietylist(T.id_trial),fc_trialvariablesmeasuredlist(T.id_trial),T.trlsowdate,T.trlharvestdate,T.trltrialtype,T.trlirrigation,'http://www.agtrials.org/tbtrial/'||T.id_trial ";
        //$QUERY00 .= ",COUNT(TVR.id_variety) AS Count_VR, COUNT(TVM.id_variablesmeasured) AS Count_TVM ";
        $QUERY00 .= "FROM tb_trial T ";
        $QUERY00 .= "INNER JOIN tb_trialgroup TG ON T.id_trialgroup = TG.id_trialgroup ";
        $QUERY00 .= "INNER JOIN tb_contactperson CP ON T.id_contactperson = CP.id_contactperson ";
        $QUERY00 .= "INNER JOIN tb_country CN ON T.id_country = CN.id_country ";
        $QUERY00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
        $QUERY00 .= "INNER JOIN tb_crop C ON T.id_crop = C.id_crop ";
        //$QUERY00 .= "LEFT JOIN tb_trialvariety TVR ON t.id_trial = TVR.id_trial ";
        //$QUERY00 .= "LEFT JOIN tb_trialvariablesmeasured TVM ON t.id_trial = TVM.id_trial ";
        $QUERY00 .= "WHERE true $wheretrial ";
        //$QUERY00 .= "GROUP BY T.id_trial,TG.trgrname,CP.cnprfirstname,CP.cnprlastname,CN.cntname,TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal,C.crpname, ";
        //$QUERY00 .= "T.trlname,fc_trialvariety(T.id_trial),fc_trialvariablesmeasured(T.id_trial),T.trlsowdate,T.trlharvestdate,T.trltrialtype,T.trlirrigation,'http://www.agtrials.org/tbtrial/'||T.id_trial ";
        $QUERY00 .= "ORDER BY T.id_trial ";
        //die($QUERY00);
        $st = $connection->execute($QUERY00);
        $Result = $st->fetchAll();
        $i = 2;
        foreach ($Result AS $Value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Value[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $Value[1]);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $Value[2]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $Value[3]);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $Value[4]);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $Value[5]);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $Value[6]);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $Value[7]);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $Value[8]);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $Value[9]);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $Value[10]);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $Value[11]);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $Value[12]);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $Value[13]);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $Value[14]);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, 'Go to Trial ' . $Value[0]);
            $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setUrl($Value[15]);
            $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setTooltip('Navigate to website');
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('P2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

//ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Trials List.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeShowtrialdata($request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $id_trial = $request->getParameter('id_trial');
        if ($id_trial != "") {
            die(ShowTrialData($id_trial));
        }
        die();
    }

    public function executePermissionstrials($request) {
        $this->notice = null;
        $form = $request->getParameter('form');
        $id_user_session = $this->getUser()->getGuardUser()->getId();
        if ($form == "add") {
            $Flag = false;
            $session_trialgroup_id = sfContext::getInstance()->getUser()->getAttribute('trialgroup_id');
            $session_trial_id = sfContext::getInstance()->getUser()->getAttribute('trial_id');
            $session_user_id = sfContext::getInstance()->getUser()->getAttribute('user_id');
            $Count_Trialgroup = count($session_trialgroup_id);
            if ($Count_Trialgroup > 0) {
                for ($cont = 0; $cont < count($session_trialgroup_id); $cont++) {
                    $id_trialgroup = $session_trialgroup_id[$cont];
                    $TbTrial = Doctrine::getTable('TbTrial')->findByIdTrialgroup($id_trialgroup);
                    foreach ($TbTrial AS $valor) {
                        $id_trial = $valor->id_trial;
                        $id_user_trial = $valor->id_user;
                        if (($id_user_trial == $id_user_session) || (CheckUserPermission($id_user_session, "1")) || (PermissionChangeTrial($id_user_session, $id_trial))) {
                            for ($cont2 = 0; $cont2 < count($session_user_id); $cont2++) {
                                $id_user = $session_user_id[$cont2];
                                $QUERY00 = Doctrine_Query::create()
                                        ->select("T.id_trialuserpermissionfiles AS id")
                                        ->from("TbTrialuserpermissionfiles T")
                                        ->where("T.id_trial = $id_trial")
                                        ->andWhere("T.id_userpermission = $id_user");
                                $Resultado00 = $QUERY00->execute();
                                if (count($Resultado00) == 0) {
                                    TbTrialuserpermissionfilesTable::addUser($id_trial, $id_user, $id_user_session);
                                    $Flag = true;
                                }
                            }
                        }
                    }
                }
            } else {
                for ($cont = 0; $cont < count($session_trial_id); $cont++) {
                    $id_trial = $session_trial_id[$cont];
                    $TbTrial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
                    $id_user_trial = $TbTrial->getIdUser();
                    if (($id_user_trial == $id_user_session) || (CheckUserPermission($id_user_session, "1")) || (PermissionChangeTrial($id_user_session, $id_trial))) {
                        for ($cont2 = 0; $cont2 < count($session_user_id); $cont2++) {
                            $id_user = $session_user_id[$cont2];
                            $QUERY00 = Doctrine_Query::create()
                                    ->select("T.id_trialuserpermissionfiles AS id")
                                    ->from("TbTrialuserpermissionfiles T")
                                    ->where("T.id_trial = $id_trial")
                                    ->andWhere("T.id_userpermission = $id_user");
                            $Resultado00 = $QUERY00->execute();
                            if (count($Resultado00) == 0) {
                                TbTrialuserpermissionfilesTable::addUser($id_trial, $id_user, $id_user_session);
                                $Flag = true;
                            }
                        }
                    }
                }
            }
            if ($Flag)
                $this->notice = "The permissions added successfully.";
            else
                $this->notice = "The permissions don't added successfully.";

            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
        } elseif ($form == "remove") {
            $Flag = false;
            $session_trialgroup_id = sfContext::getInstance()->getUser()->getAttribute('trialgroup_id');
            $session_trial_id = sfContext::getInstance()->getUser()->getAttribute('trial_id');
            $session_user_id = sfContext::getInstance()->getUser()->getAttribute('user_id');
            $Count_Trialgroup = count($session_trialgroup_id);
            if ($Count_Trialgroup > 0) {
                for ($cont = 0; $cont < count($session_trialgroup_id); $cont++) {
                    $id_trialgroup = $session_trialgroup_id[$cont];
                    $TbTrial = Doctrine::getTable('TbTrial')->findByIdTrialgroup($id_trialgroup);
                    foreach ($TbTrial AS $valor) {
                        $id_trial = $valor->id_trial;
                        $id_user_trial = $valor->id_user;
                        if (($id_user_trial == $id_user_session) || (CheckUserPermission($id_user_session, "1")) || (PermissionChangeTrial($id_user_session, $id_trial))) {
                            for ($cont2 = 0; $cont2 < count($session_user_id); $cont2++) {
                                $id_user = $session_user_id[$cont2];
                                $QUERY00 = Doctrine_Query::create()
                                        ->select("T.id_trialuserpermissionfiles AS id")
                                        ->from("TbTrialuserpermissionfiles T")
                                        ->where("T.id_trial = $id_trial")
                                        ->andWhere("T.id_userpermission = $id_user");
                                $Resultado00 = $QUERY00->execute();
                                if (count($Resultado00) > 0) {
                                    TbTrialuserpermissionfilesTable::delUser($id_trial, $id_user);
                                    $Flag = true;
                                }
                            }
                        }
                    }
                }
            } else {
                for ($cont = 0; $cont < count($session_trial_id); $cont++) {
                    $id_trial = $session_trial_id[$cont];
                    $TbTrial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
                    $id_user_trial = $TbTrial->getIdUser();
                    if (($id_user_trial == $id_user_session) || (CheckUserPermission($id_user_session, "1")) || (PermissionChangeTrial($id_user_session, $id_trial))) {
                        for ($cont2 = 0; $cont2 < count($session_user_id); $cont2++) {
                            $id_user = $session_user_id[$cont2];
                            $QUERY00 = Doctrine_Query::create()
                                    ->select("T.id_trialuserpermissionfiles AS id")
                                    ->from("TbTrialuserpermissionfiles T")
                                    ->where("T.id_trial = $id_trial")
                                    ->andWhere("T.id_userpermission = $id_user");
                            $Resultado00 = $QUERY00->execute();
                            if (count($Resultado00) > 0) {
                                TbTrialuserpermissionfilesTable::delUser($id_trial, $id_user);
                                $Flag = true;
                            }
                        }
                    }
                }
            }
            if ($Flag)
                $this->notice = "The permissions removed successfully.";
            else
                $this->notice = "The permissions don't removed successfully.";

            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
        } else {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trial_name');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
        }
    }

    public function executeRegisterdownload(sfWebRequest $request) {
        $id_user = null;
        $connection = Doctrine_Manager::getInstance()->connection();
        if ($this->getUser()->isAuthenticated())
            $id_user = $this->getUser()->getGuardUser()->getId();
        $uploadDir = sfConfig::get("sf_upload_dir") . "/";
        $uploadDir = str_replace("\\", "/", $uploadDir);
        $size = 0;
        $id_trial = $request->getParameter('id_trial');
        $type = $request->getParameter('type');
        $file = $request->getParameter('file');
        $date = date("Y-m-d") . " " . date("H:i:s");

        if ($type != 'All') {
            $TotalTamano = 0;
            if ($type == "Metadata_Data") {
                //ESTE ES UN VALOR PROMEDIO DE LAS PLANTILLAS DE DATOS
                $TotalTamano = $TotalTamano + 200000;
            } else if (file_exists($uploadDir . $file)) {
                $Tamano = filesize($uploadDir . $file);
                $TotalTamano = $TotalTamano + $Tamano;
            }
        } else {
            $QUERY01 = "SELECT trltrialresultsfile,trlsupplementalinformationfile,trlweatherduringtrialfile,trlsoiltypeconditionsduringtrialfile FROM tb_trial WHERE id_trial = $id_trial";
            $st = $connection->execute($QUERY01);
            $Result = $st->fetchAll();
            if (count($Result) > 0) {
                $trltrialresultsfile = "";
                $trlsupplementalinformationfile = "";
                $trlweatherduringtrialfile = "";
                $trlsoiltypeconditionsduringtrialfile = "";

                foreach ($Result AS $Value) {
                    $trltrialresultsfile = $Value[0];
                    $trlsupplementalinformationfile = $Value[1];
                    $trlweatherduringtrialfile = $Value[2];
                    $trlsoiltypeconditionsduringtrialfile = $Value[3];
                }

                if ((file_exists($uploadDir . $trltrialresultsfile)) && ($trltrialresultsfile != "")) {
                    $Tamano = 0;
                    $Tamano = filesize($uploadDir . $trltrialresultsfile);
                    $TotalTamano = $TotalTamano + $Tamano;
                }
                if ((file_exists($uploadDir . $trlsupplementalinformationfile)) && ($trlsupplementalinformationfile != "")) {
                    $Tamano = 0;
                    $Tamano = filesize($uploadDir . $trlsupplementalinformationfile);
                    $TotalTamano = $TotalTamano + $Tamano;
                }
                if ((file_exists($uploadDir . $trlweatherduringtrialfile)) && ($trlweatherduringtrialfile != "")) {
                    $Tamano = 0;
                    $Tamano = filesize($uploadDir . $trlweatherduringtrialfile);
                    $TotalTamano = $TotalTamano + $Tamano;
                }
                if ((file_exists($uploadDir . $trlsoiltypeconditionsduringtrialfile)) && ($trlsoiltypeconditionsduringtrialfile != "")) {
                    $Tamano = 0;
                    $Tamano = filesize($uploadDir . $trlsoiltypeconditionsduringtrialfile);
                    $TotalTamano = $TotalTamano + $Tamano;
                }
            }
            //ESTE ES UN VALOR PROMEDIO DE LAS PLANTILLAS DE DATOS
            $TotalTamano = $TotalTamano + 200000;
        }

        $TotalTamanoMB = round(($TotalTamano / 1024000), 2);
        $SfGuardUserDownloads = new SfGuardUserDownloads();
        $SfGuardUserDownloads->setUserId($id_user);
        $SfGuardUserDownloads->setIdTrial($id_trial);
        $SfGuardUserDownloads->setUsdwtype($type);
        $SfGuardUserDownloads->setUsdwfile($file);
        $SfGuardUserDownloads->setUsdwdate($date);
        $SfGuardUserDownloads->setUsdwsize($TotalTamanoMB);
        $SfGuardUserDownloads->save();
        die();
    }

    public function executeDownloadMetadataData(sfWebRequest $request) {
        $id_trial = $request->getParameter('id_trial');
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("MetadataData_Trial_{$id_trial}")
                ->setSubject("MetadataData_Trial_{$id_trial}")
                ->setDescription("MetadataData_Trial_{$id_trial}")
                ->setKeywords("MetadataData_Trial_{$id_trial}")
                ->setCategory("MetadataData_Trial_{$id_trial}");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Trials')
                ->setCellValue('B1', 'Trial group')
                ->setCellValue('C1', 'Contact person')
                ->setCellValue('D1', 'Country')
                ->setCellValue('E1', 'Trial site')
                ->setCellValue('F1', 'Latitude')
                ->setCellValue('G1', 'Longitude')
                ->setCellValue('H1', 'Crop')
                ->setCellValue('I1', 'Trial Name')
                ->setCellValue('J1', 'Varieties')
                ->setCellValue('K1', 'Variables measured')
                ->setCellValue('L1', 'Sow date')
                ->setCellValue('M1', 'Harvest date')
                ->setCellValue('N1', 'Trial type')
                ->setCellValue('O1', 'Irrigation')
                ->setCellValue('P1', 'Link');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Metadata');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT T.id_trial,TG.trgrname,(CP.cnprfirstname||' '||CP.cnprlastname),CN.cntname,TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal,C.crpname, ";
        $QUERY00 .= "T.trlname,fc_trialvariety(T.id_trial),fc_trialvariablesmeasured(T.id_trial),T.trlsowdate,T.trlharvestdate,T.trltrialtype,T.trlirrigation,'http://www.agtrials.org/tbtrial/'||T.id_trial ";
        $QUERY00 .= "FROM tb_trial T ";
        $QUERY00 .= "INNER JOIN tb_trialgroup TG ON T.id_trialgroup = TG.id_trialgroup ";
        $QUERY00 .= "INNER JOIN tb_contactperson CP ON T.id_contactperson = CP.id_contactperson ";
        $QUERY00 .= "INNER JOIN tb_country CN ON T.id_country = CN.id_country ";
        $QUERY00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
        $QUERY00 .= "INNER JOIN tb_crop C ON T.id_crop = C.id_crop ";
        $QUERY00 .= "WHERE T.id_trial = $id_trial ";
        $QUERY00 .= "ORDER BY T.id_trial ";
//die($QUERY00);
        $st = $connection->execute($QUERY00);
        $Result = $st->fetchAll();
        $i = 2;
        foreach ($Result AS $Value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Value[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $Value[1]);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $Value[2]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $Value[3]);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $Value[4]);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $Value[5]);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $Value[6]);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $Value[7]);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $Value[8]);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $Value[9]);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $Value[10]);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $Value[11]);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $Value[12]);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $Value[13]);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $Value[14]);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, 'Go to Trial ' . $Value[0]);
            $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setUrl($Value[15]);
            $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setTooltip('Navigate to website');
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('P2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        //inicio: GENERAMOS EL LIBRO DE DATA
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Data');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Replication');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Varieties/Race');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Variables Measured');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Value');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Unit');
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
        $QUERY00 = "SELECT TD.trdtreplication AS replication, V.vrtname AS variety, VM.vrmsname AS variablesmeasured, TD.trdtvalue AS value, CASE WHEN VM.vrmsunit IS NULL THEN 'N.A.' ELSE VM.vrmsunit END AS unit ";
        $QUERY00 .= "FROM tb_trialdata TD ";
        $QUERY00 .= "INNER JOIN tb_variety V ON TD.id_variety = V.id_variety ";
        $QUERY00 .= "INNER JOIN tb_variablesmeasured VM ON TD.id_variablesmeasured = VM.id_variablesmeasured ";
        $QUERY00 .= "WHERE TD.id_trial = $id_trial ";
        $QUERY00 .= "ORDER BY V.vrtname,VM.vrmsname, TD.trdtreplication ";
        $st = $connection->execute($QUERY00);
        $Result = $st->fetchAll();
        $i = 2;
        foreach ($Result AS $Value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Value[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $Value[1]);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $Value[2]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $Value[3]);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $Value[4]);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="MetadataDataTrial_' . $id_trial . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
        die();
    }

    public function executeDownloadAll(sfWebRequest $request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $id_user = null;
        if ($this->getUser()->isAuthenticated())
            $id_user = $this->getUser()->getGuardUser()->getId();
        $UploadDir = sfConfig::get("sf_upload_dir");
        $id_trial = $request->getParameter('id_trial');
        $TbTrial = Doctrine::getTable('TbTrial')->find($id_trial);

        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(3000);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("MetadataData_Trial_{$id_trial}")
                ->setSubject("MetadataData_Trial_{$id_trial}")
                ->setDescription("MetadataData_Trial_{$id_trial}")
                ->setKeywords("MetadataData_Trial_{$id_trial}")
                ->setCategory("MetadataData_Trial_{$id_trial}");


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Trials')
                ->setCellValue('B1', 'Trial group')
                ->setCellValue('C1', 'Contact person')
                ->setCellValue('D1', 'Country')
                ->setCellValue('E1', 'Trial site')
                ->setCellValue('F1', 'Latitude')
                ->setCellValue('G1', 'Longitude')
                ->setCellValue('H1', 'Crop')
                ->setCellValue('I1', 'Trial Name')
                ->setCellValue('J1', 'Varieties')
                ->setCellValue('K1', 'Variables measured')
                ->setCellValue('L1', 'Sow date')
                ->setCellValue('M1', 'Harvest date')
                ->setCellValue('N1', 'Trial type')
                ->setCellValue('O1', 'Irrigation')
                ->setCellValue('P1', 'Link');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Metadata');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT T.id_trial,TG.trgrname,(CP.cnprfirstname||' '||CP.cnprlastname),CN.cntname,TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal,C.crpname, ";
        $QUERY00 .= "T.trlname,T.trlvarieties,T.trlvariablesmeasured,T.trlsowdate,T.trlharvestdate,T.trltrialtype,T.trlirrigation,'http://www.agtrials.org/tbtrial/'||T.id_trial ";
        $QUERY00 .= "FROM tb_trial T ";
        $QUERY00 .= "INNER JOIN tb_trialgroup TG ON T.id_trialgroup = TG.id_trialgroup ";
        $QUERY00 .= "INNER JOIN tb_contactperson CP ON T.id_contactperson = CP.id_contactperson ";
        $QUERY00 .= "INNER JOIN tb_country CN ON T.id_country = CN.id_country ";
        $QUERY00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
        $QUERY00 .= "INNER JOIN tb_crop C ON T.id_crop = C.id_crop ";
        $QUERY00 .= "WHERE T.id_trial = $id_trial ";
        $QUERY00 .= "ORDER BY T.id_trial ";
//die($QUERY00);
        $st = $connection->execute($QUERY00);
        $Result = $st->fetchAll();
        $i = 2;
        foreach ($Result AS $Value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Value[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $Value[1]);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $Value[2]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $Value[3]);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $Value[4]);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $Value[5]);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $Value[6]);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $Value[7]);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $Value[8]);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $Value[9]);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $Value[10]);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $Value[11]);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $Value[12]);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $Value[13]);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $Value[14]);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, 'Go to Trial ' . $Value[0]);
            $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setUrl($Value[15]);
            $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setTooltip('Navigate to website');
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('P2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        //inicio: GENERAMOS EL LIBRO DE DATA
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Data');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Replication');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Varieties/Race');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Variables Measured');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Value');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Unit');
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
        $QUERY00 = "SELECT TD.trdtreplication AS replication, V.vrtname AS variety, VM.vrmsname AS variablesmeasured, TD.trdtvalue AS value, CASE WHEN VM.vrmsunit IS NULL THEN 'N.A.' ELSE VM.vrmsunit END AS unit ";
        $QUERY00 .= "FROM tb_trialdata TD ";
        $QUERY00 .= "INNER JOIN tb_variety V ON TD.id_variety = V.id_variety ";
        $QUERY00 .= "INNER JOIN tb_variablesmeasured VM ON TD.id_variablesmeasured = VM.id_variablesmeasured ";
        $QUERY00 .= "WHERE TD.id_trial = $id_trial ";
        $QUERY00 .= "ORDER BY V.vrtname,VM.vrmsname, TD.trdtreplication ";
        $st = $connection->execute($QUERY00);
        $Result = $st->fetchAll();
        $i = 2;
        foreach ($Result AS $Value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Value[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $Value[1]);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $Value[2]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $Value[3]);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $Value[4]);
            $i++;
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0);

        $tmp_download = $UploadDir . "/tmp$id_user";
        if (!is_dir($tmp_download)) {
            mkdir($tmp_download, 0777);
        }

        $FileMetadataData = "MetadataDataTrial_{$id_trial}.xls";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save("$tmp_download/$FileMetadataData");

        /* $trltrialresultsfile = str_replace("\\", '/', $trltrialresultsfile);
          $trlsupplementalinformationfile = str_replace("\\", '/', $trlsupplementalinformationfile);
          $trlweatherduringtrialfile = str_replace("\\", '/', $trlweatherduringtrialfile);
          $trlsoiltypeconditionsduringtrialfile = str_replace("\\", '/', $trlsoiltypeconditionsduringtrialfile); */
        $zip = new ZipArchive();
        $filename = "$tmp_download/FilesTrial_{$id_trial}.zip";

        if ($zip->open($filename, ZIPARCHIVE::CREATE) === true) {
            $zip->addFile("$tmp_download/$FileMetadataData", "$FileMetadataData");
            if ($TbTrial->getTrltrialresultsfile() != "") {
                $PartFile1 = explode(".", $TbTrial->getTrltrialresultsfile());
                $trltrialresultsfile = $UploadDir . "/" . $TbTrial->getTrltrialresultsfile();
                $zip->addFile("$trltrialresultsfile", "ResultsFileTrial_$id_trial.{$PartFile1[1]}");
            }
            if ($TbTrial->getTrlsupplementalinformationfile() != "") {
                $PartFile2 = explode(".", $TbTrial->getTrlsupplementalinformationfile());
                $trlsupplementalinformationfile = $UploadDir . "/" . $TbTrial->getTrlsupplementalinformationfile();
                $zip->addFile("$trlsupplementalinformationfile", "SupplementalInformationFile_$id_trial.{$PartFile2[1]}");
            }
            if ($TbTrial->getTrlweatherduringtrialfile() != "") {
                $PartFile3 = explode(".", $TbTrial->getTrlweatherduringtrialfile());
                $trlweatherduringtrialfile = $UploadDir . "/" . $TbTrial->getTrlweatherduringtrialfile();
                $zip->addFile("$trlweatherduringtrialfile", "WeatherDuringTrialFile_$id_trial.{$PartFile3[1]}");
            }
            if ($TbTrial->getTrlsoiltypeconditionsduringtrialfile() != "") {
                $PartFile4 = explode(".", $TbTrial->getTrlsoiltypeconditionsduringtrialfile());
                $trlsoiltypeconditionsduringtrialfile = $UploadDir . "/" . $TbTrial->getTrlsoiltypeconditionsduringtrialfile();
                $zip->addFile("$trlsoiltypeconditionsduringtrialfile", "SoilTypeConditionsDuringTrialFile_$id_trial.{$PartFile4[1]}");
            }
            $zip->close();
        } else {
            die("Error Creating Zip File");
        }
        if (file_exists($filename)) {
            header('Content-type: "application/zip"');
            header('Content-Disposition: attachment; filename="FilesTrial_' . $id_trial . '.zip"');
            readfile($filename);
            unlink($filename);
        }
        if (@chdir($tmp_download)) {
            $command = "rmdir /s /q " . $tmp_download;
            exec($command);
        }
        die();
    }

    //inicio: VERSION NUEVA DEL SELECTOR DE VARIEDADES
    public function executeVarieties($request) {
        $this->setLayout(false);
    }

    public function executeVarietiessave(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $list_variety = "";
        $session_varieties_id = array();
        $session_varieties_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('varieties_name');
        $Datos = $request->getParameter('datos');
        for ($i = 1; $i <= $Datos; $i++) {
            $Valor = $request->getParameter('varieties' . $i);
            if ($Valor != '') {
                $session_varieties_id[] = $Valor;
                $user->setAttribute('varieties_id', $session_varieties_id);
                $TbVariety = Doctrine::getTable('TbVariety')->findOneByIdVariety($Valor);
                $name = $TbVariety->getVrtname();
                $session_varieties_name[] = $name[$key];
                $user->setAttribute('varieties_name', $session_varieties_name);
                $list_variety .= $name . ", ";
            }
        }
        $list_variety = substr($list_variety, 0, strlen($list_variety) - 2);
        $this->name = $list_variety;

        //GENERACION CODIGO HTML PARA LOS DATOS DE RESULTADOS
        $this->html = SesionTrialData();
    }

    public function executeSelectVarieties($request) {
        $this->setLayout(false);
        $Valor = $request->getParameter('Valor');
        if ($Valor != "") {
            $user = sfContext::getInstance()->getUser();
            $connection = Doctrine_Manager::getInstance()->connection();
            $session_varieties_id = $user->getAttribute('varieties_id');
            $session_varieties_campo = $user->getAttribute('varieties_campo');
            $session_varieties_id[] = $Valor;
            $user->setAttribute('varieties_id', $session_varieties_id);
            $TbVariety = Doctrine::getTable('TbVariety')->findOneByIdVariety($Valor);
            $session_varieties_campo[] = $TbVariety->getVrtname();
            $user->setAttribute('varieties_campo', $session_varieties_campo);

            $width1 = '5%';
            $width2 = '30%';
            $width3 = '45%';
            $width4 = '20%';
            $flag = 1;
            $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
            $total = count($session_varieties_id);
            if ($total > 0) {
                foreach ($session_varieties_id AS $varieties_id) {
                    $QUERY01 = "SELECT V.id_variety,V.vrtname,O.orgname,V.vrtsynonymous FROM tb_variety V LEFT JOIN tb_origin O ON V.id_origin = O.id_origin WHERE V.id_variety = $varieties_id";
                    $Results = $connection->execute($QUERY01);
                    $Record = $Results->fetchAll();
                    foreach ($Record AS $Value) {
                        $checked = 'checked';
                        $html .= "<tr bgcolor='#DEBF43' id=fila$flag name=fila$flag onmouseover=\"this.style.backgroundColor='#1298F7'\" onmouseout=\"this.style.backgroundColor='#DEBF43'\">";
                        $html .= "<td width=$width1><input type='checkbox' $checked name='varieties$flag' id='varieties$flag' value='$Value[0]' onclick=RemoveVarieties(this,$flag,'$bgcolor')></td>";
                        $html .= "<td width=$width2>$Value[1]</td>";
                        $html .= "<td width=$width3>$Value[2]</td>";
                        $html .= "<td width=$width4>$Value[3]</td>";
                        $html .= "</tr>";
                        $flag++;
                    }
                }
            }
            $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        }
        die($html);
    }

    public function executeRemoveVarieties($request) {
        $this->setLayout(false);
        $Valor = $request->getParameter('Valor');
        $user = sfContext::getInstance()->getUser();
        $connection = Doctrine_Manager::getInstance()->connection();
        $session_varieties_id = $user->getAttribute('varieties_id');
        $session_varieties_campo = $user->getAttribute('varieties_campo');
        $posicionAEliminar = array_search($Valor, $session_varieties_id, false);
        array_splice($session_varieties_id, $posicionAEliminar, 1);
        array_splice($session_varieties_campo, $posicionAEliminar, 1);
        $user->setAttribute('varieties_id', $session_varieties_id);
        $user->setAttribute('varieties_campo', $session_varieties_campo);
        $width1 = '5%';
        $width2 = '30%';
        $width3 = '45%';
        $width4 = '20%';
        $flag = 1;
        $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
        $total = count($session_varieties_id);
        if ($total > 0) {
            foreach ($session_varieties_id AS $varieties_id) {
                $QUERY01 = "SELECT V.id_variety,V.vrtname,O.orgname,V.vrtsynonymous FROM tb_variety V INNER JOIN tb_origin O ON V.id_origin = O.id_origin WHERE V.id_variety = $varieties_id";
                $Results = $connection->execute($QUERY01);
                $Record = $Results->fetchAll();
                foreach ($Record AS $Value) {
                    $checked = 'checked';
                    $html .= "<tr bgcolor='#DEBF43' id=fila$flag name=fila$flag onmouseover=\"this.style.backgroundColor='#1298F7'\" onmouseout=\"this.style.backgroundColor='#DEBF43'\">";
                    $html .= "<td width=$width1><input type='checkbox' $checked name='varieties$flag' id='varieties$flag' value='$Value[0]' onclick=RemoveVarieties(this,$flag,'$bgcolor')></td>";
                    $html .= "<td width=$width2>$Value[1]</td>";
                    $html .= "<td width=$width3>$Value[2]</td>";
                    $html .= "<td width=$width4>$Value[3]</td>";
                    $html .= "</tr>";
                    $flag++;
                }
            }
        }
        $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        die($html);
    }

    public function executeVarietiesList($request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $WhereList = sfContext::getInstance()->getUser()->getAttribute('WhereList');
        $id_crop = $user->getAttribute('id_crop');
        $session_varieties_id = $user->getAttribute('varieties_id');
        $Accion = $request->getParameter('Accion');
        $txt = trim($request->getParameter('txt_filtar'));
        $NotIn = "";
        if ($txt == '9999')
            $txt = '';
        $Valor = $request->getParameter('Valor');
        if ($Accion == 'Seleccionar') {
            $NotIn = "$Valor,";
        } else {
            $posicionAEliminar = array_search($Valor, $session_varieties_id, false);
            array_splice($session_varieties_id, $posicionAEliminar, 1);
        }
        $connection = Doctrine_Manager::getInstance()->connection();
        if (count($session_varieties_id) > 0) {
            foreach ($session_varieties_id AS $Value) {
                $NotIn .= "$Value,";
            }
        }
        if (strlen($NotIn) > 1) {
            $NotIn = substr($NotIn, 0, strlen($NotIn) - 1);
            $AndNotIn = "AND V.id_variety NOT IN ($NotIn)";
        }

        $width1 = '5%';
        $width2 = '30%';
        $width3 = '45%';
        $width4 = '20%';

        $QUERY = "SELECT V.id_variety,V.vrtname,O.orgname,V.vrtsynonymous FROM tb_variety V INNER JOIN tb_trialvariety TV ON V.id_variety = TV.id_variety INNER JOIN tb_trial T2 ON TV.id_trial = T2.id_trial LEFT JOIN tb_origin O ON V.id_origin = O.id_origin WHERE true $WhereList AND UPPER(vrtname) LIKE UPPER('$txt%') $AndNotIn  GROUP BY V.id_variety,V.vrtname,O.orgname,V.vrtsynonymous ORDER BY V.vrtname,O.orgname";
        $Results = $connection->execute($QUERY);
        $Record = $Results->fetchAll();
        $total = count($Record);
        $flag = 1;
        $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
        $bgcolor = "#C0C0C0";
        foreach ($Record AS $Value) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            $html .= "<tr bgcolor='$bgcolor' id=fila$flag name=fila$flag onmouseover=\"cambiacolor_over(this)\" onmouseout=\"cambiacolor_out(this,$flag)\">";
            $html .= "<td width=$width1><input type='checkbox' name='varieties$flag' id='varieties$flag' value='$Value[0]' onclick=SelectVarieties(this)></td>";
            $html .= "<td width=$width2>$Value[1]</td>";
            $html .= "<td width=$width3>$Value[2]</td>";
            $html .= "<td width=$width4>$Value[3]</td>";
            $html .= "</tr>";
            $flag++;
        }


        $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        die($html);
    }

    public function executeFilterVarieties($request) {
        $this->setLayout(false);
        $NotIn = "";
        $WhereList = sfContext::getInstance()->getUser()->getAttribute('WhereList');
        $txt = $request->getParameter('txt');
        $txt = str_replace("*quot*", " ", $txt);
        $connection = Doctrine_Manager::getInstance()->connection();
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $session_varieties_id = $user->getAttribute('varieties_id');
        if (count($session_varieties_id) > 0) {
            foreach ($session_varieties_id AS $Value) {
                $NotIn .= "$Value,";
            }
        }

        if (strlen($NotIn) > 1) {
            $NotIn = substr($NotIn, 0, strlen($NotIn) - 1);
            $AndNotIn = "AND V.id_variety NOT IN ($NotIn)";
        }

        $width1 = '5%';
        $width2 = '30%';
        $width3 = '45%';
        $width4 = '20%';

        $QUERY = "SELECT V.id_variety,V.vrtname,O.orgname,V.vrtsynonymous FROM tb_variety V INNER JOIN tb_trialvariety TV ON V.id_variety = TV.id_variety INNER JOIN tb_trial T2 ON TV.id_trial = T2.id_trial LEFT JOIN tb_origin O ON V.id_origin = O.id_origin WHERE true $WhereList AND UPPER(vrtname) LIKE UPPER('$txt%') $AndNotIn  GROUP BY V.id_variety,V.vrtname,O.orgname,V.vrtsynonymous ORDER BY V.vrtname,O.orgname";
        $Results = $connection->execute($QUERY);
        $Record = $Results->fetchAll();
        $total = count($Record);
        $flag = 1;
        $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
        $bgcolor = "#C0C0C0";
        foreach ($Record AS $Value) {
            $ValueName = $Value[1];

            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            $html .= "<tr bgcolor='$bgcolor' id=fila$flag name=fila$flag onmouseover=\"cambiacolor_over(this)\" onmouseout=\"cambiacolor_out(this,$flag)\">";
            $html .= "<td width=$width1><input type='checkbox' name='varieties$flag' id='varieties$flag' value='$Value[0]' onclick=SelectVarieties(this,$flag,'$bgcolor')></td>";
            $html .= "<td width=$width2>$ValueName</td>";
            $html .= "<td width=$width3>$Value[2]</td>";
            $html .= "<td width=$width4>$Value[3]</td>";
            $html .= "</tr>";
            $flag++;
        }
        $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        die($html);
    }

    //fin: VERSION NUEVA DEL SELECTOR DE VARIEDADES
    //inicio: VERSION NUEVA DEL SELECTOR DE Variablesmeasured
    public function executeVariablesmeasured($request) {
        $this->setLayout(false);
    }

    public function executeVariablesmeasuredsave(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $list_variablesmeasured = "";
        $session_variablesmeasured_id = array();
        $session_variablesmeasured_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
        $Datos = $request->getParameter('datos');
        for ($i = 1; $i <= $Datos; $i++) {
            $Valor = $request->getParameter('variablesmeasured' . $i);
            if ($Valor != '') {
                $session_variablesmeasured_id[] = $Valor;
                $user->setAttribute('variablesmeasured_id', $session_variablesmeasured_id);
                $TbVariablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($Valor);
                $name = $TbVariablesmeasured->getVrmsname();
                $session_variablesmeasured_name[] = $name[$key];
                $user->setAttribute('variablesmeasured_name', $session_variablesmeasured_name);
                $list_variablesmeasured .= $name . ", ";
            }
        }
        $list_variablesmeasured = substr($list_variablesmeasured, 0, strlen($list_variablesmeasured) - 2);
        $this->name = $list_variablesmeasured;

        //GENERACION CODIGO HTML PARA LOS DATOS DE RESULTADOS
        $this->html = SesionTrialData();
    }

    public function executeSelectVariablesmeasured($request) {
        $this->setLayout(false);
        $Valor = $request->getParameter('Valor');
        $user = sfContext::getInstance()->getUser();
        $connection = Doctrine_Manager::getInstance()->connection();
        $session_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
        $session_variablesmeasured_campo = $user->getAttribute('variablesmeasured_campo');
        $session_variablesmeasured_id[] = $Valor;
        $user->setAttribute('variablesmeasured_id', $session_variablesmeasured_id);
        $TbVariablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($Valor);
        $session_variablesmeasured_campo[] = $TbVariablesmeasured->getVrmsname();
        $user->setAttribute('variablesmeasured_campo', $session_variablesmeasured_campo);

        $width1 = '5%';
        $width2 = '35%';
        $width3 = '20%';
        $width4 = '40%';
        $flag = 1;
        $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
        $total = count($session_variablesmeasured_id);
        if ($total > 0) {
            foreach ($session_variablesmeasured_id AS $variablesmeasured_id) {
                $QUERY01 = "SELECT V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition FROM tb_variablesmeasured V INNER JOIN tb_traitclass TC ON V.id_traitclass = TC.id_traitclass WHERE V.id_variablesmeasured = $variablesmeasured_id";
                $Results = $connection->execute($QUERY01);
                $Record = $Results->fetchAll();
                foreach ($Record AS $Value) {
                    $checked = 'checked';
                    $html .= "<tr bgcolor='#DEBF43' id=fila$flag name=fila$flag onmouseover=\"this.style.backgroundColor='#1298F7'\" onmouseout=\"this.style.backgroundColor='#DEBF43'\">";
                    $html .= "<td width=$width1><input type='checkbox' $checked name='variablesmeasured$flag' id='variablesmeasured$flag' value='$Value[0]' onclick=RemoveVariablesmeasured(this,$flag,'$bgcolor')></td>";
                    $html .= "<td width=$width2>$Value[1]</td>";
                    $html .= "<td width=$width3>$Value[2]</td>";
                    $html .= "<td width=$width4>$Value[3]</td>";
                    $html .= "</tr>";
                    $flag++;
                }
            }
        }
        $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        die($html);
    }

    public function executeRemoveVariablesmeasured($request) {
        $this->setLayout(false);
        $connection = Doctrine_Manager::getInstance()->connection();
        $Valor = $request->getParameter('Valor');
        $user = sfContext::getInstance()->getUser();
        $session_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
        $session_variablesmeasured_campo = $user->getAttribute('variablesmeasured_campo');
        $posicionAEliminar = array_search($Valor, $session_variablesmeasured_id, false);
        array_splice($session_variablesmeasured_id, $posicionAEliminar, 1);
        array_splice($session_variablesmeasured_campo, $posicionAEliminar, 1);
        $user->setAttribute('variablesmeasured_id', $session_variablesmeasured_id);
        $user->setAttribute('variablesmeasured_campo', $session_variablesmeasured_campo);
        $width1 = '5%';
        $width2 = '35%';
        $width3 = '20%';
        $width4 = '40%';
        $flag = 1;
        $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
        $total = count($session_variablesmeasured_id);
        if ($total > 0) {
            foreach ($session_variablesmeasured_id AS $variablesmeasured_id) {
                $QUERY01 = "SELECT V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition FROM tb_variablesmeasured V INNER JOIN tb_traitclass TC ON V.id_traitclass = TC.id_traitclass WHERE V.id_variablesmeasured = $variablesmeasured_id";
                $Results = $connection->execute($QUERY01);
                $Record = $Results->fetchAll();
                foreach ($Record AS $Value) {
                    $checked = 'checked';
                    $html .= "<tr bgcolor='#DEBF43' id=fila$flag name=fila$flag onmouseover=\"this.style.backgroundColor='#1298F7'\" onmouseout=\"this.style.backgroundColor='#DEBF43'\">";
                    $html .= "<td width=$width1><input type='checkbox' $checked name='variablesmeasured$flag' id='variablesmeasured$flag' value='$Value[0]' onclick=RemoveVariablesmeasured(this,$flag,'$bgcolor')></td>";
                    $html .= "<td width=$width2>$Value[1]</td>";
                    $html .= "<td width=$width3>$Value[2]</td>";
                    $html .= "<td width=$width4>$Value[3]</td>";
                    $html .= "</tr>";
                    $flag++;
                }
            }
        }
        $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        die($html);
    }

    public function executeVariablesmeasuredList($request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $WhereList = sfContext::getInstance()->getUser()->getAttribute('WhereList');
        $id_crop = $user->getAttribute('id_crop');
        $session_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
        $Accion = $request->getParameter('Accion');
        $txt = trim($request->getParameter('txt_filtar'));
        $NotIn = "";
        if ($txt == '9999')
            $txt = '';
        $Valor = $request->getParameter('Valor');
        if ($Accion == 'Seleccionar') {
            $NotIn = "$Valor,";
        } else {
            $posicionAEliminar = array_search($Valor, $session_variablesmeasured_id, false);
            array_splice($session_variablesmeasured_id, $posicionAEliminar, 1);
        }
        $connection = Doctrine_Manager::getInstance()->connection();
        if (count($session_variablesmeasured_id) > 0) {
            foreach ($session_variablesmeasured_id AS $Value) {
                $NotIn .= "$Value,";
            }
        }
        if (strlen($NotIn) > 1) {
            $NotIn = substr($NotIn, 0, strlen($NotIn) - 1);
            $AndNotIn = "AND V.id_variablesmeasured NOT IN ($NotIn)";
        }

        $width1 = '5%';
        $width2 = '35%';
        $width3 = '20%';
        $width4 = '40%';

        $QUERY = "SELECT V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition FROM tb_variablesmeasured V INNER JOIN tb_trialvariablesmeasured TV ON V.id_variablesmeasured = TV.id_variablesmeasured INNER JOIN tb_trial T2 ON TV.id_trial = T2.id_trial INNER JOIN tb_traitclass TC ON V.id_traitclass = TC.id_traitclass WHERE true $WhereList AND UPPER(vrmsname) LIKE UPPER('$txt%') $AndNotIn GROUP BY V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition ORDER BY V.vrmsname,TC.trclname";
        $Results = $connection->execute($QUERY);
        $Record = $Results->fetchAll();
        $total = count($Record);
        $flag = 1;
        $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
        $bgcolor = "#C0C0C0";
        foreach ($Record AS $Value) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            $html .= "<tr bgcolor='$bgcolor' id=fila$flag name=fila$flag onmouseover=\"cambiacolor_over(this)\" onmouseout=\"cambiacolor_out(this,$flag)\">";
            $html .= "<td width=$width1><input type='checkbox' name='variablesmeasured$flag' id='variablesmeasured$flag' value='$Value[0]' onclick=SelectVariablesmeasured(this)></td>";
            $html .= "<td width=$width2>$Value[1]</td>";
            $html .= "<td width=$width3>$Value[2]</td>";
            $html .= "<td width=$width4>$Value[3]</td>";
            $html .= "</tr>";
            $flag++;
        }


        $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        die($html);
    }

    public function executeFilterVariablesmeasured($request) {
        $this->setLayout(false);
        $NotIn = "";
        $WhereList = sfContext::getInstance()->getUser()->getAttribute('WhereList');
        $txt = $request->getParameter('txt');
        $connection = Doctrine_Manager::getInstance()->connection();
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $session_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
        if (count($session_variablesmeasured_id) > 0) {
            foreach ($session_variablesmeasured_id AS $Value) {
                $NotIn .= "$Value,";
            }
        }

        if (strlen($NotIn) > 1) {
            $NotIn = substr($NotIn, 0, strlen($NotIn) - 1);
            $AndNotIn = "AND V.id_variablesmeasured NOT IN ($NotIn)";
        }

        $width1 = '5%';
        $width2 = '35%';
        $width3 = '20%';
        $width4 = '40%';

        $QUERY = "SELECT V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition FROM tb_variablesmeasured V INNER JOIN tb_trialvariablesmeasured TV ON V.id_variablesmeasured = TV.id_variablesmeasured INNER JOIN tb_trial T2 ON TV.id_trial = T2.id_trial INNER JOIN tb_traitclass TC ON V.id_traitclass = TC.id_traitclass WHERE true $WhereList AND UPPER(vrmsname) LIKE UPPER('$txt%') $AndNotIn GROUP BY V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition ORDER BY V.vrmsname,TC.trclname";
        $Results = $connection->execute($QUERY);
        $Record = $Results->fetchAll();
        $total = count($Record);
        $flag = 1;
        $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
        $bgcolor = "#C0C0C0";
        foreach ($Record AS $Value) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            $html .= "<tr bgcolor='$bgcolor' id=fila$flag name=fila$flag onmouseover=\"cambiacolor_over(this)\" onmouseout=\"cambiacolor_out(this,$flag)\">";
            $html .= "<td width=$width1><input type='checkbox' name='variablesmeasured$flag' id='variablesmeasured$flag' value='$Value[0]' onclick=SelectVariablesmeasured(this,$flag,'$bgcolor')></td>";
            $html .= "<td width=$width2>$Value[1]</td>";
            $html .= "<td width=$width3>$Value[2]</td>";
            $html .= "<td width=$width4>$Value[3]</td>";
            $html .= "</tr>";
            $flag++;
        }
        $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";
        die($html);
    }

    //fin: VERSION NUEVA DEL SELECTOR DE Variablesmeasured

    public function executeDownloaddata($request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $wheretrial = $user->getAttribute('wheretrial');
        $Form = $request->getParameter('Form');
        $UploadDir = sfConfig::get("sf_upload_dir");
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(600);
        $InfoQuery = null;
        $HTML = "";

        if (($wheretrial != '') && ($Form == '')) {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY = "SELECT TVM.id_variablesmeasured,VM.vrmsname ";
            $QUERY .= "FROM tb_trial T ";
            $QUERY .= "INNER JOIN tb_trialvariablesmeasured TVM ON T.id_trial = TVM.id_trial ";
            $QUERY .= "INNER JOIN tb_variablesmeasured VM ON TVM.id_variablesmeasured = VM.id_variablesmeasured ";
            $QUERY .= "WHERE TRUE $wheretrial ";
            $QUERY .= "GROUP BY TVM.id_variablesmeasured,VM.vrmsname ";
            $st = $connection->execute($QUERY);
            $InfoQuery = $st->fetchAll(PDO::FETCH_ASSOC);
            $i = 1;
            foreach ($InfoQuery AS $Value) {
                $HTML .="<div><input type=checkbox value={$Value['id_variablesmeasured']} name=variablesmeasured$i id=variablesmeasured$i> {$Value['vrmsname']}</div>";
                $i++;
            }
            $i--;
            $HTML .="<div><input type=hidden value=$i name=count_variablesmeasured id=count_variablesmeasured></div>";
        } else if ($Form == 'Enviar') {
            $resultsfile = $request->getParameter('resultsfile');
            $supplementalfile = $request->getParameter('supplementalfile');
            $weatherfile = $request->getParameter('weatherfile');
            $soilfile = $request->getParameter('soilfile');

            $connection = Doctrine_Manager::getInstance()->connection();
            $CountVM = $request->getParameter('count_variablesmeasured');
            $ListIdVariablesmeasured = "";
            for ($i = 1; $i <= $CountVM; $i++) {
                $id_variablesmeasured = $request->getParameter("variablesmeasured$i");
                if ($id_variablesmeasured != '') {
                    $ListIdVariablesmeasured .= "$id_variablesmeasured,";
                }
            }
            $ListIdVariablesmeasured = substr($ListIdVariablesmeasured, 0, (strlen($ListIdVariablesmeasured) - 1));

            //inicio: GENERAMOS LA LISTA DE ENSAYOS CON PERMISOS
            $QUERY = "SELECT T.id_trial,T.trlfileaccess ";
            $QUERY .= "FROM tb_trial T ";
            $QUERY .= "WHERE T.id_trial IN (SELECT id_trial FROM tb_trialvariablesmeasured WHERE id_variablesmeasured IN ($ListIdVariablesmeasured)) $wheretrial ";
            $st = $connection->execute($QUERY);
            $Result = $st->fetchAll();
            $ListIdTrial = "";
            foreach ($Result AS $Value) {
                $id_trial = $Value[0];
                $Trlfileaccess = $Value[1];
                //SI TIENE LA REGLA PARA USUARIOS VERIFICAMOS EL USUARIO
                if ($Trlfileaccess == 'Open to specified users') {
                    if ($this->getUser()->isAuthenticated()) {
                        $id_user = $this->getUser()->getGuardUser()->getId();
                        $filas = 0;
                        $QUERY00 = Doctrine_Query::create()
                                ->select("T.id_trialuserpermissionfiles AS id")
                                ->from("TbTrialuserpermissionfiles T")
                                ->where("T.id_trial = $id_trial")
                                ->andWhere("T.id_userpermission = $id_user");
                        $Resultado00 = $QUERY00->execute();
                        if (count($Resultado00) > 0) {
                            $ListIdTrial .= "$id_trial,";
                        }
                    }
                }

                //SI TIENE LA REGLA PARA GRUPOS VERIFICAMOS EL GRUPO DEL USUARIO
                if ($Trlfileaccess == 'Open to specified groups') {
                    if ($this->getUser()->isAuthenticated()) {
                        $id_user = $this->getUser()->getGuardUser()->getId();
                        $SfGuardUserGroup = Doctrine::getTable('SfGuardUserGroup')->findByUserId($id_user);
                        foreach ($SfGuardUserGroup AS $Group) {
                            $id_group = $Group->group_id;
                            $TbTrialgrouppermission = Doctrine::getTable('TbTrialgrouppermission')->findByIdGroup($id_group);
                            if (count($TbTrialgrouppermission) > 0) {
                                $ListIdTrial .= "$id_trial,";
                            }
                        }
                    }
                }

                //SI TIENE LA REGLA PARA TODOS LOS USUARIOS DEL SISTEMA SE VERIFICA QUE ESTE AUTENTICADO
                if ($Trlfileaccess == 'Open to all users') {
                    if ($this->getUser()->isAuthenticated()) {
                        $ListIdTrial .= "$id_trial,";
                    }
                }

                if ($Trlfileaccess == 'Public domain') {
                    $ListIdTrial .= "$id_trial,";
                }
            }
            $ListIdTrial = substr($ListIdTrial, 0, (strlen($ListIdTrial) - 1));
            if ($ListIdTrial == '') {
                echo "<script> alert('*** ERROR *** \\n\\n Not permissions to DOWNLOAD.!'); window.close();</script>";
                Die();
            }

            //fin: GENERAMOS LA LISTA DE ENSAYOS CON PERMISOS


            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getProperties()->setCreator("AgTrials")
                    ->setLastModifiedBy("AgTrials")
                    ->setTitle("Trials Data")
                    ->setSubject("Trials Data")
                    ->setDescription("Trials Data")
                    ->setKeywords("Trials Data")
                    ->setCategory("Trials Data");

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Id Trials')
                    ->setCellValue('B1', 'Trial group')
                    ->setCellValue('C1', 'Contact person')
                    ->setCellValue('D1', 'Country')
                    ->setCellValue('E1', 'Trial site')
                    ->setCellValue('F1', 'Latitude')
                    ->setCellValue('G1', 'Longitude')
                    ->setCellValue('H1', 'Crop')
                    ->setCellValue('I1', 'Trial Name')
                    ->setCellValue('J1', 'Varieties')
                    ->setCellValue('K1', 'Variables measured')
                    ->setCellValue('L1', 'Sow date')
                    ->setCellValue('M1', 'Harvest date')
                    ->setCellValue('N1', 'Trial type')
                    ->setCellValue('O1', 'Irrigation')
                    ->setCellValue('P1', 'Link');

            $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

            $objPHPExcel->getActiveSheet(0)->setTitle('Metadata');

            $QUERY00 = "SELECT T.id_trial,TG.trgrname,(CP.cnprfirstname||' '||CP.cnprlastname),CN.cntname,TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal,C.crpname, ";
            $QUERY00 .= "T.trlname,fc_trialvariety(T.id_trial),fc_trialvariablesmeasured(T.id_trial),T.trlsowdate,T.trlharvestdate,T.trltrialtype,T.trlirrigation,'http://www.agtrials.org/tbtrial/'||T.id_trial ";
            $QUERY00 .= "FROM tb_trial T ";
            $QUERY00 .= "INNER JOIN tb_trialgroup TG ON T.id_trialgroup = TG.id_trialgroup ";
            $QUERY00 .= "INNER JOIN tb_contactperson CP ON T.id_contactperson = CP.id_contactperson ";
            $QUERY00 .= "INNER JOIN tb_country CN ON T.id_country = CN.id_country ";
            $QUERY00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
            $QUERY00 .= "INNER JOIN tb_crop C ON T.id_crop = C.id_crop ";
            $QUERY00 .= "WHERE T.id_trial IN ($ListIdTrial) ";
            $QUERY00 .= "ORDER BY T.id_trial ";
            $st = $connection->execute($QUERY00);
            $Result = $st->fetchAll();
            $i = 2;
            foreach ($Result AS $Value) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Value[0]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $Value[1]);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $Value[2]);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $Value[3]);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $Value[4]);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $Value[5]);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $Value[6]);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $Value[7]);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $Value[8]);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $Value[9]);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $Value[10]);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $Value[11]);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $Value[12]);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $Value[13]);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $Value[14]);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, 'Go to Trial ' . $Value[0]);
                $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setUrl($Value[15]);
                $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getHyperlink()->setTooltip('Navigate to website');
                $i++;
            }
            $objPHPExcel->getActiveSheet()->getStyle('P2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            //GENERAMOS EL LIBRO DE DATOS
            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex(1);
            $objPHPExcel->getActiveSheet(1)->setTitle('Data');
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id Trial');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Replication');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Varieties/Races');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

            //AQUI GENERAMOS LAS FILA DE VARIABLES MEDIDAS
            $letter = "C";

            $QUERY00 = "SELECT VM.id_variablesmeasured, VM.vrmsname, VM.vrmsunit AS unit ";
            $QUERY00 .= "FROM tb_variablesmeasured VM ";
            $QUERY00 .= "WHERE VM.id_variablesmeasured IN ($ListIdVariablesmeasured) ";
            $st = $connection->execute($QUERY00);
            $Resultado02 = $st->fetchAll();
            $ArrLeter = null;
            foreach ($Resultado02 AS $fila) {
                $id_variablesmeasured = $fila['id_variablesmeasured'];
                $Vrmsname = $fila['vrmsname'];
                $Unit = $fila['unit'];
                $letter = NextLetter($letter);
                $objPHPExcel->getActiveSheet()->setCellValue($letter . '1', $Vrmsname);
                $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getStyle($letter . '1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objPHPExcel->getActiveSheet()->getStyle($letter . '1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                $ArrLeter[$id_variablesmeasured] = $letter;
            }
            $objPHPExcel->getActiveSheet()->protectCells("A1:" . $letter . "1");

            //GENERAMOS LOS DATOS
            $QUERY01 = "SELECT T.id_trial,TD.trdtreplication,V.vrtname,VM.id_variablesmeasured,VM.vrmsname,TD.trdtvalue ";
            $QUERY01 .= "FROM tb_trial T ";
            $QUERY01 .= "INNER JOIN tb_trialdata TD ON T.id_trial = TD.id_trial ";
            $QUERY01 .= "INNER JOIN tb_variety V ON TD.id_variety = V.id_variety ";
            $QUERY01 .= "INNER JOIN tb_variablesmeasured VM ON TD.id_variablesmeasured = VM.id_variablesmeasured ";
            $QUERY01 .= "WHERE T.id_trial IN ($ListIdTrial) ";
            $QUERY01 .= "AND TD.id_variablesmeasured IN ($ListIdVariablesmeasured) ";
            $st = $connection->execute($QUERY01);
            $Resultado01 = $st->fetchAll();
            $i = 2;
            $ListIdTrialData = "";
            foreach ($Resultado01 AS $Fila01) {
                $id_trial = $Fila01['id_trial'];
                $Replication = $Fila01['trdtreplication'];
                $Variety = $Fila01['vrtname'];
                $id_variablesmeasured = $Fila01['id_variablesmeasured'];
                $Value = $Fila01['trdtvalue'];
                $letter = $ArrLeter[$id_variablesmeasured];
                $objPHPExcel->getActiveSheet()->setCellValue("A$i", $id_trial);
                $objPHPExcel->getActiveSheet()->setCellValue("B$i", $Replication);
                $objPHPExcel->getActiveSheet()->setCellValue("C$i", $Variety);
                $objPHPExcel->getActiveSheet()->setCellValue("$letter$i", $Value);
                $ListIdTrialData .= "$id_trial,";
                $i++;
            }
            $ListIdTrialData = substr($ListIdTrialData, 0, (strlen($ListIdTrialData) - 1));
            $ArrIdTrial = explode(",", $ListIdTrial);
            $ArrIdTrial = array_unique($ArrIdTrial);
            $ArrIdTrialData = explode(",", $ListIdTrialData);
            $ArrIdTrialData = array_unique($ArrIdTrialData);

            if ((count($ArrIdTrial) != count($ArrIdTrialData)) && ($resultsfile != "SI")) {
                $ArrIdTrialNoData = array_diff($ArrIdTrial, $ArrIdTrialData);
            }


            $objPHPExcel->setActiveSheetIndex(0);

            $tmp_download = $UploadDir . "/tmp$id_user";
            if (!is_dir($tmp_download)) {
                mkdir($tmp_download, 0777);
            }

            $FileMetadataData = "MetadataDataTrials.xls";
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save("$tmp_download/$FileMetadataData");

            $zip = new ZipArchive();
            $filename = "$tmp_download/FilesTrials.zip";

            if ($zip->open($filename, ZIPARCHIVE::CREATE) === true) {
                $zip->addFile("$tmp_download/$FileMetadataData", "$FileMetadataData");

                $QUERY = "SELECT T.id_trial,T.trltrialresultsfile,T.trlsupplementalinformationfile,T.trlweatherduringtrialfile,T.trlsoiltypeconditionsduringtrialfile ";
                $QUERY .= "FROM tb_trial T ";
                $QUERY .= "WHERE T.id_trial IN ($ListIdTrial) ";
                $st = $connection->execute($QUERY);
                $Result = $st->fetchAll();

                foreach ($Result AS $Value) {
                    $id_trial = $Value[0];
                    $trltrialresultsfile = $Value[1];
                    $trlsupplementalinformationfile = $Value[2];
                    $trlweatherduringtrialfile = $Value[3];
                    $trlsoiltypeconditionsduringtrialfile = $Value[4];

                    if ((($trltrialresultsfile != "") && ($resultsfile == "SI")) || (($trltrialresultsfile != "") && (in_array($id_trial, $ArrIdTrialNoData)))) {
                        $PartFile1 = explode(".", $trltrialresultsfile);
                        $trltrialresultsfile = $UploadDir . "/" . $trltrialresultsfile;
                        $zip->addFile("$trltrialresultsfile", "ResultsFileTrial_$id_trial.{$PartFile1[1]}");
                    }
                    if (($trlsupplementalinformationfile != "") && ($supplementalfile == "SI")) {
                        $PartFile2 = explode(".", $trlsupplementalinformationfile);
                        $trlsupplementalinformationfile = $UploadDir . "/" . $trlsupplementalinformationfile;
                        $zip->addFile("$trlsupplementalinformationfile", "SupplementalInformationFile_$id_trial.{$PartFile2[1]}");
                    }
                    if (($trlweatherduringtrialfile != "") && ($weatherfile == "SI")) {
                        $PartFile3 = explode(".", $trlweatherduringtrialfile);
                        $trlweatherduringtrialfile = $UploadDir . "/" . $trlweatherduringtrialfile;
                        $zip->addFile("$trlweatherduringtrialfile", "WeatherDuringTrialFile_$id_trial.{$PartFile3[1]}");
                    }
                    if (($trlsoiltypeconditionsduringtrialfile != "") && ($soilfile == "SI")) {
                        $PartFile4 = explode(".", $trlsoiltypeconditionsduringtrialfile);
                        $trlsoiltypeconditionsduringtrialfile = $UploadDir . "/" . $trlsoiltypeconditionsduringtrialfile;
                        $zip->addFile("$trlsoiltypeconditionsduringtrialfile", "SoilTypeConditionsDuringTrialFile_$id_trial.{$PartFile4[1]}");
                    }
                }
                $zip->close();
            } else {
                die("Error Creating Zip File");
            }
            if (file_exists($filename)) {
                header('Content-type: "application/zip"');
                header('Content-Disposition: attachment; filename="FilesTrials.zip"');
                readfile($filename);
                unlink($filename);
            }
            if (@chdir($tmp_download)) {
                $command = "rmdir /s /q " . $tmp_download;
                exec($command);
            }
            die();
        }

        $this->HTML = $HTML;
    }

//plantilla de pruebas
    public function executePruebas($request) {
        
    }

    public function executeAutoprueba($request) {
        $dato = $request->getParameter('tag');
        $dato = strtolower($dato);
        $consulta = Doctrine_Query::create()
                ->from("TbCountry")
                ->Where("LOWER(cntname) like '%$dato%'")
                ->OrderBy("cntname");
        $valores = "";
//echo $consulta->getSqlQuery();
        foreach ($consulta->execute() as $valor) {
            $valores .= '{"caption":"' . $valor->getCntname() . '","value":' . $valor->getIdCountry() . '},';
        }
        $valores = substr($valores, 0, strlen($valores) - 1);
        return $this->renderText("[$valores]");
    }

}

function SesionTrialData() {
    $user = sfContext::getInstance()->getUser();
//AQUI CONSULTAMOS LA VARIEDADES SELECIONADAS Y GENERAMOS LA CADENA LA CREAR EL SELECT CON ESTOS DATOS
    $SS_varieties_id = $user->getAttribute('varieties_id');
    $list_varieties = "";
    if (isset($SS_varieties_id)) {
        foreach ($SS_varieties_id AS $varieties_id) {
            $list_varieties .= $varieties_id . ",";
        }
        $list_varieties = substr($list_varieties, 0, strlen($list_varieties) - 1);
    }
//AQUI CONSULTAMOS LAS VARIABLES MEDIDAS SELECIONADAS Y GENERAMOS LA CADENA LA CREAR EL SELECT CON ESTOS DATOS
    $SS_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
    $list_variablesmeasureds = "";
    if (isset($SS_variablesmeasured_id)) {
        foreach ($SS_variablesmeasured_id AS $variablesmeasured_id) {
            $list_variablesmeasureds .= $variablesmeasured_id . ",";
        }
        $list_variablesmeasureds = substr($list_variablesmeasureds, 0, strlen($list_variablesmeasureds) - 1);
    }

    $trialdata = $user->getAttribute('trialdata');

    $html = "";
    $html .= "<tr><td colspan='6'><label>Form 1: Result data adding one by one<label></td></tr>";
    $html .= "<tr bgcolor='#808080'>";
    $html .= "<td width='10%'><b>Replication</b></td>";
    $html .= "<td width='30%'><b>Varieties/Race</b></td>";
    $html .= "<td width='30%'><b>Variables Measured</b></td>";
    $html .= "<td width='10%'><b>Value</b></td>";
    $html .= "<td width='10%'><b>Unit</b></td>";
    $html .= "<td width='10%'><b>Action</b></td>";
    $html .= "</tr>";
    $Flag = true;
    $bgcolor = "#C0C0C0";
    if (isset($trialdata)) {
        foreach ($trialdata AS $key => $valor) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            $Flag = false;
            $replication = $valor['replication'];
            $id_variety = $valor['id_variety'];
            $id_variablesmeasured = $valor['id_variablesmeasured'];
            $value = $valor['value'];
            $unit = $valor['unit'];
            $html .= "<tr bgcolor='$bgcolor'>";
            $html .= "<td>$replication</td>";
            $html .= "<td>" . getTable("TbVariety", "vrtname", "id_variety", $id_variety) . "</td>";
            $html .= "<td>" . getTable("TbVariablesmeasured", "vrmsname", "id_variablesmeasured", $id_variablesmeasured) . "</td>";
            $html .= "<td>$value</td>";
            $html .= "<td>$unit</td>";
            $html .= "<td><span title='Delete' onclick='deleterow($key)'><img src='/images/cross.png'> <b>Delete</b></span></td>";
            $html .= "</tr>";
        }
    }
    if (($list_varieties != '') && ($list_variablesmeasureds != '')) {
        if ($bgcolor != "#FFFFD9")
            $bgcolor = "#FFFFD9";
        else
            $bgcolor = "#C0C0C0";
        $Flag = false;
        $html .= "<tr bgcolor='$bgcolor'>";
        $html .= "<td><input type='text' value='1' id='trdtreplication_new' name='trdtreplication_new' size='3'></td>";
        $html .= "<td>" . select_from_table("id_variety_new", "TbVariety", "id_variety", "vrtname", "id_variety IN ($list_varieties)") . "</td>";
        $html .= "<td>" . select_from_table("id_variablesmeasured_new", "TbVariablesmeasured", "id_variablesmeasured", "vrmsname", "id_variablesmeasured IN ($list_variablesmeasureds)", null, "onchange='getunitvariablesmeasured()'") . "</td>";
        $html .= "<td><input type='text' value='' id='value_new' name='value_new' size='5' placeholder='Value'></td>";
        $html .= "<td><span id='unit_label'></span><input type='hidden' id='unit_new' name='unit_new'></td>";
        $html .= "<td><span title='Add' onclick='addrow()'><img src='/images/add-icon.png'> <b>Add</b></span></td>";
        $html .= "</tr>";
        $html .= "</br>";
        $html .= "<tr><td colspan='6'><label>Form 2: Batch upload result data<label></td></tr>";
        $html .= "<tr>";
        $html .= "<td colspan='5'>";
        $html .= "<div id='VariablesMeasuredsLote'>";
        $html .= "<div class='help'>";
        $html .= "<span class='ui-icon ui-icon-info floatleft'></span>";
        $html .= "Download the template for adding variables measured in batch upload.";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<label>Template Data Trial: </label>";
        $html .= "<span title='Download'><a href='/templatedownload'><img src='/images/download-icon.png'> Download</a></span>";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<label>Upload Template Data Trial: </label>";
        $html .= "<span><input type='file' name='filedata' id='filedata'></span>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</td>";
        $html .= "</tr>";
    }

    if ($Flag)
        $html = "";

    return $html;
}

function ResultTrialData($id_trial) {
    $return = false;
    $TbTrialdata = Doctrine::getTable('TbTrialdata')->findByIdTrial($id_trial);
    if (count($TbTrialdata) > 0) {
        $return = true;
    }
    return $return;
}

function ShowTrialData($id_trial) {
    ini_set("memory_limit", "2048M");
    set_time_limit(900000000000);
    $user = sfContext::getInstance()->getUser();
    $id_user = sfContext::getInstance()->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
    $trial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
    $trlfileaccess = $trial->getTrlfileaccess();
    $id_contactperson = $trial->getIdContactperson();

//PERSONA DE CONTACTO
    $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($id_contactperson);
    $cnprfirstname = $TbContactperson->getCnprfirstname();
    $cnprlastname = $TbContactperson->getCnprlastname();
    $cnpremail = $TbContactperson->getCnpremail();
    $cnpremail = strtolower(trim($cnpremail));
    $Continue = false;

    //VERIFICAMOS LOS PERMISOS DE DESCARGA
    if (($trlfileaccess == 'Open to specified users')) {
        if ($user->isAuthenticated()) {
            $id_user = $user->getGuardUser()->getId();
            $filas = 0;
            $QUERY00 = Doctrine_Query::create()
                    ->select("T.id_trialuserpermissionfiles AS id")
                    ->from("TbTrialuserpermissionfiles T")
                    ->where("T.id_trial = $id_trial")
                    ->andWhere("T.id_userpermission = $id_user");
            $Resultado00 = $QUERY00->execute();
            if (count($Resultado00) > 0) {
                $Continue = true;
            }
        }
    }

    //SI TIENE LA REGLA PARA GRUPOS VERIFICAMOS EL GRUPO DEL USUARIO
    if ($trlfileaccess == 'Open to specified groups') {
        if ($user->isAuthenticated()) {
            $id_user = $user->getGuardUser()->getId();
            $SfGuardUserGroup = Doctrine::getTable('SfGuardUserGroup')->findByUserId($id_user);
            foreach ($SfGuardUserGroup AS $Group) {
                $id_group = $Group->group_id;
                $TbTrialgrouppermission = Doctrine::getTable('TbTrialgrouppermission')->findByIdGroup($id_group);
                if (count($TbTrialgrouppermission) > 0) {
                    $Continue = true;
                    break;
                }
            }
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n You must be authenticated.!'); self.parent.tb_remove();</script>";
        }
    }

    if ($trlfileaccess == 'Open to all users') {
        if ($user->isAuthenticated()) {
            $Continue = true;
        }
    }

    if ($trlfileaccess == 'Public domain') {
        $Continue = true;
    }

    if (!$Continue) {
        return "<b>*** You do not have permission to view results data. Please Contact at: ***</b> <BR>" . ContactpersonTrial($id_trial);
        die();
    }

    $trialdata = $user->getAttribute('trialdata');

    $html = "";
    $html .= "<tr bgcolor='#808080'>";
    $html .= "<td width='10%'><b>Replication</b></td>";
    $html .= "<td width='30%'><b>Varieties/Race</b></td>";
    $html .= "<td width='30%'><b>Variables Measured</b></td>";
    $html .= "<td width='10%'><b>Value</b></td>";
    $html .= "<td width='10%'><b>Unit</b></td>";
    $html .= "</tr>";

    $connection = Doctrine_Manager::getInstance()->connection();
    $QUERY00 = "SELECT TD.trdtreplication AS replication, V.vrtname AS variety, VM.vrmsname AS variablesmeasured, VM.id_ontology AS id_ontology, TD.trdtvalue AS value, CASE WHEN VM.vrmsunit IS NULL THEN 'N.A.' ELSE VM.vrmsunit END AS unit ";
    $QUERY00 .= "FROM tb_trialdata TD ";
    $QUERY00 .= "INNER JOIN tb_variety V ON TD.id_variety = V.id_variety ";
    $QUERY00 .= "INNER JOIN tb_variablesmeasured VM ON TD.id_variablesmeasured = VM.id_variablesmeasured ";
    $QUERY00 .= "WHERE TD.id_trial = $id_trial ";
    $QUERY00 .= "ORDER BY V.vrtname,VM.vrmsname, TD.trdtreplication ";

    $st = $connection->execute($QUERY00);
    $Result = $st->fetchAll();
    $bgcolor = "#C0C0C0";
    $flag = true;
    foreach ($Result AS $Value) {
        $flag = false;
        if ($bgcolor != "#FFFFD9")
            $bgcolor = "#FFFFD9";
        else
            $bgcolor = "#C0C0C0";

        $html .= "<tr bgcolor='$bgcolor'>";
        $html .= "<td>{$Value['replication']}</td>";
        $html .= "<td>{$Value['variety']}</td>";
        $html .= "<td>{$Value['variablesmeasured']}</td>";
        $html .= "<td>{$Value['value']}</td>";
        $html .= "<td>{$Value['unit']}</td>";
        $html .= "</tr>";
    }

    if ($flag)
        $html = "";
    return $html;
}

function ContactpersonTrial($id_trial) {
    $ListContactperson = "";
    $TbTrial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
    $TbTrialgroupcontactperson = Doctrine::getTable('TbTrialgroupcontactperson')->findByIdTrialgroup($TbTrial->getIdTrialgroup());
    foreach ($TbTrialgroupcontactperson AS $Trialgroupcontactperson) {
        $Contactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($Trialgroupcontactperson->id_contactperson);
        $ListContactperson .= $Contactperson->getCnprfirstname() . " " . $Contactperson->getCnprlastname() . " - <a href=\"mailto:{$Contactperson->getCnpremail()}\"><font color=\"#48732A\">{$Contactperson->getCnpremail()}</font></a> <br>";
    }
    $ListContactperson = substr($ListContactperson, 0, strlen($ListContactperson) - 2);
    return $ListContactperson;
}

function cambiarFormatoFecha($fecha) {
    if ($fecha != '') {
        list($dia, $mes, $anio) = explode("-", $fecha);
        return $anio . "-" . $mes . "-" . $dia;
    } else {
        return '';
    }
}

function encryptfile($file) {
    $part_file = explode(".", $file);
    $extension = $part_file[1];
    $nombre = $part_file[0];
    $nombre = md5($nombre);
    return $nombre . "." . $extension;
}

function changedate($date) {
    if ($date != '' && (strlen($date) == 10)) {
        $part_date = explode("-", $date);
        $dato = $part_date[2];
        $var = strlen($dato);
        if ($var == 4)
            return $part_date[2] . "-" . $part_date[1] . "-" . $part_date[0];
        else
            return $date;
    } else {
        return '';
    }
}

function SaveTrialData($id_trial, $UrlTemplate, $id_user, $id_crop) {

    set_time_limit(3000000);
    $connection = Doctrine_Manager::getInstance()->connection();
    $ExcelFile = new Spreadsheet_Excel_Reader();
    $ExcelFile->setOutputEncoding('UTF-8');
    $ExcelFile->read($UrlTemplate);
    error_reporting(E_ALL ^ E_NOTICE);
    $numRows = $ExcelFile->sheets[0]['numRows'];
    $numCols = $ExcelFile->sheets[0]['numCols'];

//AQUI CAPTURAMOS LAS VARIABLES MEDIDAS
    $Arr_variablesmeasured_id = null;
    for ($col = 4; $col <= $numCols; $col++) {
        $Vrmsname = $ExcelFile->sheets[0]['cells'][1][$col];
        $Vrmsname = mb_convert_encoding($Vrmsname, 'UTF-8');
        $Vrmsname = mb_strtoupper($Vrmsname, 'UTF-8');
        $QUERY00 = "SELECT V.id_variablesmeasured FROM tb_variablesmeasured V WHERE id_crop = $id_crop AND UPPER(V.vrmsname) = '$Vrmsname'";
        $st = $connection->execute($QUERY00);
        $Result = $st->fetchAll();
        if (count($Result) > 0) {
            foreach ($Result AS $Value) {
                $Arr_variablesmeasured_id[$col] = $Value['id_variablesmeasured'];
            }
        }
    }

//AQUI CAPTURAMOS LAS VARIEDADES
    $Arr_variety_id = null;
    for ($row = 2; $row <= $numRows; ++$row) {
        $Vrtname = $ExcelFile->sheets[0]['cells'][$row][3];
        $Vrtname = mb_convert_encoding($Vrtname, 'UTF-8');
        $Vrtname = mb_strtoupper($Vrtname, 'UTF-8');
        $QUERY01 = "SELECT V.id_variety FROM tb_variety V WHERE id_crop = $id_crop AND UPPER(V.vrtname) = '$Vrtname'";
        $st = $connection->execute($QUERY01);
        $Result = $st->fetchAll();
        if (count($Result) > 0) {
            foreach ($Result AS $Value) {
                $Arr_variety_id[$row] = $Value['id_variety'];
            }
        }
    }

//AQUI CUNSULTAMOS LAS FILAS QUE CONTIENE LAS REPLICACION-VARIEDAD-VALOR VARIABLE MEDIDA
    for ($row = 2; $row <= $numRows; ++$row) {
        $trdtreplication = "";
        $id_variety = "";
        $id_variablesmeasured = "";
        $trvmvalue = "";
        $trdtreplication = $ExcelFile->sheets[0]['cells'][$row][2];
        $id_variety = $Arr_variety_id[$row];
        for ($col = 4; $col <= $numCols; $col++) {
            $id_variablesmeasured = $Arr_variablesmeasured_id[$col];
            $trvmvalue = $ExcelFile->sheets[0]['cells'][$row][$col];
            $trvmvalue = mb_convert_encoding($trvmvalue, 'UTF-8');
            if (($trdtreplication != '') && ($id_variety != '') && ($id_variablesmeasured != '') && ($trvmvalue != '')) {
                if ($id_trial != '') {
                    TbTrialdataTable::addData($id_trial, $trdtreplication, $id_variety, $id_variablesmeasured, $trvmvalue);
                    TbTrialvarietyTable::addVariety($id_trial, $id_variety, $id_user);
                    TbTrialvariablesmeasuredTable::addVariablesmeasured($id_trial, $id_variablesmeasured, $id_user);
                }
            }
        }
    }
}

function GetValueMonth($month, $cad) {
    $value = 0;
    if ($month == "JAN")
        $value = substr($cad, 0, 3);
    if ($month == "FEB")
        $value = substr($cad, 4, 3);
    if ($month == "MAR")
        $value = substr($cad, 8, 3);
    if ($month == "APR")
        $value = substr($cad, 12, 3);
    if ($month == "MAY")
        $value = substr($cad, 16, 3);
    if ($month == "JUN")
        $value = substr($cad, 20, 3);
    if ($month == "JUL")
        $value = substr($cad, 24, 3);
    if ($month == "AUG")
        $value = substr($cad, 28, 3);
    if ($month == "SEP")
        $value = substr($cad, 32, 3);
    if ($month == "OCT")
        $value = substr($cad, 36, 3);
    if ($month == "NOV")
        $value = substr($cad, 40, 3);
    if ($month == "DEC")
        $value = substr($cad, 44, 3);

    return $value;
}

function GetNumberMonth($month) {
    $position = null;
    if ($month == "JAN")
        $position = "01";
    if ($month == "FEB")
        $position = "02";
    if ($month == "MAR")
        $position = "03";
    if ($month == "APR")
        $position = "04";
    if ($month == "MAY")
        $position = "05";
    if ($month == "JUN")
        $position = "06";
    if ($month == "JUL")
        $position = "07";
    if ($month == "AUG")
        $position = "08";
    if ($month == "SEP")
        $position = "09";
    if ($month == "OCT")
        $position = "10";
    if ($month == "NOV")
        $position = "11";
    if ($month == "DEC")
        $position = "12";
    return $position;
}

function factorial($num) {
    $num = 100;
    $factorial = 1;
    for ($i = $num; $i >= 1; $i--) {
        $factorial = $factorial * $i;
    }
    printf("%d", $factorial);
    die();
    return $factorial;
}

function rev($number) {
    $res = 0;
    while ($number > 0) {
        $res = $res * 10 + $number % 10;
        $number /= 10;
    }
    return $res;
}
