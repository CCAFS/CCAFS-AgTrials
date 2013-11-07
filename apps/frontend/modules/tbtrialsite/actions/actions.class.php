<?php

require_once dirname(__FILE__) . '/../lib/tbtrialsiteGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbtrialsiteGeneratorHelper.class.php';
require_once '../lib/funtions/funtion.php';
require_once '../lib/funtions/html.php';
require_once '../lib/excel/Classes/PHPExcel.php';
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/excel/reader.php';

/**
 * tbtrialsite actions.
 *
 * @package    trialsites
 * @subpackage tbtrialsite
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbtrialsiteActions extends autoTbtrialsiteActions {

    public function executeIndex(sfWebRequest $request) {
// sorting
        if ($request->getParameter('sort')) {
            $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
        }
// pager
        if ($request->getParameter('page')) {
            $this->setPage($request->getParameter('page'));
        }
        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

// has filters? (usefull for activate reset button)

        $this->hasFilters = $this->getUser()->getAttribute('tbtrialsite.filters', $this->configuration->getFilterDefaults(), 'admin_module');
    }

    public function executeFilter(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $this->setPage(1);
        if ($request->hasParameter('_reset')) {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('wherelist');
            $this->setFilters($this->configuration->getFilterDefaults());
            $this->redirect('@tbtrialsite');
        }
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        $this->filters->bind($request->getParameter($this->filters->getName()));

        if ($this->filters->isValid()) {
            $this->setFilters($this->filters->getValues());
            $Arr_Filters = $this->getFilters();
            $wherelist = "";
            foreach ($Arr_Filters AS $Key => $Filters) {
                if ($Filters['text'] != '') {
                    if (intval($Filters['text'])) {
                        $wherelist .= "AND TS.$Key = $Filters,";
                    } else {
                        $wherelist .= "AND UPPER(TS.$Key) LIKE '%" . strtoupper($Filters['text']) . "%',";
                    }
                }
            }
            $wherelist = substr($wherelist, 0, strlen($wherelist) - 1);
            $user->setAttribute('wherelist', $wherelist);
            $this->redirect('@tbtrialsite');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbtrialsite = $this->form->getObject();
        $this->form = new tbtrialsiteForm(null, array('url' => 'tbtrialsite/'));
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weatherstation_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weatherstation_name');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbtrialsite = $this->form->getObject();
        $this->form = new tbtrialsiteForm(null, array('url' => 'tbtrialsite/tbtrialsite/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->tbtrialsite = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->tbtrialsite);
        $id_trialsite = $request->getParameter("id_trialsite");
        $user = $this->getUser();

//INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialsitecontactperson
        $list_contactperson = "";
        $Trialsitecontactperson = Doctrine::getTable('TbTrialsitecontactperson')->findByIdTrialsite($id_trialsite);
        for ($cont = 0; $cont < count($Trialsitecontactperson); $cont++) {
            $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($Trialsitecontactperson[$cont]->getIdContactperson());
            $contactperson_id_saved[] = $TbContactperson->getIdContactperson();
            $contactperson_name_saved[] = $TbContactperson->getCnprfirstname() . " " . $TbContactperson->getCnprlastname();
        }
        $user->setAttribute('contactperson_id', $contactperson_id_saved);
        $user->setAttribute('contactperson_name', $contactperson_name_saved);

//INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialsiteweatherstation
        $list_weatherstation = "";
        $TbTrialsiteweatherstation = Doctrine::getTable('TbTrialsiteweatherstation')->findByIdTrialsite($id_trialsite);
        for ($cont = 0; $cont < count($TbTrialsiteweatherstation); $cont++) {
            $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($TbTrialsiteweatherstation[$cont]->getIdWeatherstation());
            $weatherstation_id_saved[] = $TbWeatherstation->getIdWeatherstation();
            $weatherstation_name_saved[] = $TbWeatherstation->getWtstname();
        }
        $user->setAttribute('weatherstation_id', $weatherstation_id_saved);
        $user->setAttribute('weatherstation_name', $weatherstation_name_saved);

//INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialsiteuserpermissionfiles
        $Trialsiteuserpermissionfiles = Doctrine::getTable('TbTrialsiteuserpermissionfiles')->findByIdTrialsite($id_trialsite);
        for ($cont = 0; $cont < count($Trialsiteuserpermissionfiles); $cont++) {
            $SfGuardUser = Doctrine::getTable('SfGuardUser')->findOneById($Trialsiteuserpermissionfiles[$cont]->getIdUserpermission());
            $user_id_saved[] = $SfGuardUser->getId();
            $user_name_saved[] = $SfGuardUser->getFirstName() . " " . $SfGuardUser->getLastName();
        }
        $user->setAttribute('user_id', $user_id_saved);
        $user->setAttribute('user_name', $user_name_saved);

        $TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
        $trstactive = $TbTrialsite->getTrstactive();
        if ($trstactive != 1)
            $this->getUser()->setFlash('notice', "Pending for Activation!", false);
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->tbtrialsite = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->tbtrialsite);

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();
        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
        $id_trialsite = $request->getParameter("id_trialsite");
        $TbTrial = Doctrine::getTable('TbTrial')->findByIdTrialsite($id_trialsite);
        $TbTrialsitephotograph = Doctrine::getTable('TbTrialsitephotograph')->findByIdTrialsite($id_trialsite);
        $TbTrialsiteweather = Doctrine::getTable('TbTrialsiteweather')->findByIdTrialsite($id_trialsite);

        if ((count($TbTrial) > 0) || (count($TbTrialsitephotograph) > 0) || (count($TbTrialsiteweather) > 0)) {
            echo "<script> alert('*** The item has not been deleted due to some errors. Associated (Trials or Files) ***'); window.history.back();</script>";
            die();
        } else {
            TbTrialsitecontactpersonTable::delTrialsitecontactperson($id_trialsite);
            TbTrialsiteweatherstationTable::delWeatherstation($id_trialsite);
            TbTrialsiteuserpermissionfilesTable::delUser($id_trialsite);
            $this->getRoute()->getObject()->delete();
            echo "<script> alert('*** The item was deleted successfully ***');</script>";
            $this->redirect('@tbtrialsite');
        }
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        $form_trialsite = $request->getParameter('tb_trialsite');

        $FileValid = true;
        $errfiles = "";
        $errfoto = "";
        for ($a = 1; $a <= 10; $a++) {
            $nombre = $_FILES["file" . $a]['name'];
            $variablesmeasured = $request->getParameter("variablesmeasured" . $a);
            $trstwtstartdate = $request->getParameter("trstwtstartdate" . $a);
            $trstwtenddate = $request->getParameter("trstwtenddate" . $a);
            if (($nombre != '') && ($variablesmeasured == '')) {
                $FileValid = false;
                $errfiles = "(Select (Mariables Measured) for files!)";
            }

//VERIFICACION DEL OTRO DOCUMENTO
            $trstphfile = $_FILES["trstphfile" . $a]['name'];
            if ($trstphfile != '') {
                $extension = "";
                $part_name = explode(".", $trstphfile);
                $extension = strtoupper($part_name[1]);
                $extensiones = array('0' => 'JPG', '1' => 'JPEG', '2' => 'TIFF', '3' => 'PNG', '4' => 'BMP', '5' => 'PDF', '6' => 'GIF', '7' => 'DOC', '8' => 'DOCX', '9' => 'XLS', '10' => 'XLSX', '11' => 'ZIP', '12' => 'RAR');

                if (!in_array($extension, $extensiones)) {
                    $FileValid = false;
                    $errfoto = " (Format error Documents (permitted format: 'JPG,JPEG,TIFF,PNG,BMP,PDF,GIF,DOC,DOCX,XLS,XLSX,ZIP,RAR')";
                }
            }
        }

        if ($form->isValid() && $FileValid) {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully (Pending for Activation).' : 'The item was updated successfully.';

            $tbtrialsite = $form->save();
            $id_trialsite = $tbtrialsite['id_trialsite'];
            $user = sfContext::getInstance()->getUser();

//INICIO: AQUI AGREGAMOS LOS REGISTROS A LA TABLA tb_trialsitecontactperson
            $session_contactperson = $user->getAttribute('contactperson_id');
            $list_contactperson = "";
            TbTrialsitecontactpersonTable::delTrialsitecontactperson($id_trialsite);
            for ($cont = 0; $cont < count($session_contactperson); $cont++) {
                $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($session_contactperson[$cont]);
                $list_contactperson .= $TbContactperson->getCnprfirstname() . " " . $TbContactperson->getCnprlastname() . ", ";
                TbTrialsitecontactpersonTable::addTrialsitecontactperson($id_trialsite, $session_contactperson[$cont]);
            }
            $list_contactperson = substr($list_contactperson, 0, strlen($list_contactperson) - 2);
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_name');

//VERIFICACION DE ARCHIVOS y FOTOS
            $Weathertrialsite = "Weathertrialsite_$id_trialsite";
            $Photographtrialsite = "Photograph_$id_trialsite";
            $uploadDir = sfConfig::get("sf_upload_dir");
            $dir_uploads = "$uploadDir/$Weathertrialsite";
            $dir_uploads2 = "$uploadDir/$Photographtrialsite";
            if (!is_dir($dir_uploads))
                mkdir($dir_uploads, 0777);
            if (!is_dir($dir_uploads2))
                mkdir($dir_uploads2, 0777);

            for ($i = 1; $i <= 10; $i++) {
//Inicio: Archivos
                $nombre = $_FILES["file" . $i]['name'];
                $fileaccess = "";
                $trstwtstartdate = "";
                $trstwtenddate = "";
                $trstwtfileaccess = "None";
                $trstwtstartdate = $request->getParameter("trstwtstartdate" . $i);
                $trstwtenddate = $request->getParameter("trstwtenddate" . $i);
                if ($trstwtstartdate == '')
                    $trstwtstartdate = null;
                if ($trstwtenddate == '')
                    $trstwtenddate = null;

                if (($nombre != '') && ($variablesmeasured == '')) {
                    move_uploaded_file($_FILES["file" . $i]['tmp_name'], "$dir_uploads/$nombre");
                    $id_trialsiteweather = TbTrialsiteweatherTable::addTrialsiteweather($id_trialsite, $trstwtfileaccess, $nombre, $trstwtstartdate, $trstwtenddate);
//INICIO: AQUI AGREGAMOS REGISTROS A LA TABLA tb_trialsiteweathervariablesmeasured
                    $session_weathervariablesmeasured = $user->getAttribute('weathervariablesmeasured_id' . $i);
                    TbTrialsiteweathervariablesmeasuredTable::delTrialsiteweathervariablesmeasured($id_trialsiteweather);
                    for ($cont = 0; $cont < count($session_weathervariablesmeasured); $cont++) {
                        TbTrialsiteweathervariablesmeasuredTable::addTrialsiteweathervariablesmeasured($id_trialsiteweather, $session_weathervariablesmeasured[$cont]);
                    }
                }
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weathervariablesmeasured_id' . $i);
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weathervariablesmeasured_name' . $i);
//Fin: Archivos
//Inicio: Fotos
                $trstphfile = $_FILES["trstphfile" . $i]['name'];
                $trstphfileaccess = "None";
                $trstphpersonphotograph = "";
                $trstphpersonphotograph = $request->getParameter("trstphpersonphotograph" . $i);
                if (($trstphfile != '')) {
                    move_uploaded_file($_FILES["trstphfile" . $i]['tmp_name'], "$dir_uploads2/$trstphfile");
                    TbTrialsitephotographTable::addTrialsitephotograph($id_trialsite, $trstphfileaccess, $trstphfile, $trstphpersonphotograph);
                }
//Fin: Fotos
            }

//INICIO: AQUI REGISTRAMOS LAS ESTACIONES CLIMATICAS EN LA TABLA tb_trialsiteweatherstation
            $session_weatherstation = $user->getAttribute('weatherstation_id');
            $list_weatherstation = "";
            TbTrialsiteweatherstationTable::delWeatherstation($id_trialsite);
            for ($cont = 0; $cont < count($session_weatherstation); $cont++) {
                $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($session_weatherstation[$cont]);
                $list_weatherstation .= $TbWeatherstation->getWtstname() . ", ";
                TbTrialsiteweatherstationTable::addWeatherstation($id_trialsite, $session_weatherstation[$cont]);
            }
            $list_weatherstation = substr($list_weatherstation, 0, strlen($list_weatherstation) - 2);
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weatherstation_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weatherstation_name');


//INICIO: AQUI ASIGNAMOS LOS PERMISOS A LA TABLA tb_trialsiteuserpermissionfiles
            if ($tbtrialsite->getTrstfileaccess() == 'Open to all users') {
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
                TbTrialsiteuserpermissionfilesTable::delUser($id_trialsite);
            }
            $session_user = $user->getAttribute('user_id');
            $list_user = "";
            TbTrialsiteuserpermissionfilesTable::delUser($id_trialsite);
            for ($cont = 0; $cont < count($session_user); $cont++) {
                $SfguardUser = Doctrine::getTable('SfguardUser')->findOneById($session_user[$cont]);
                $list_user .= $SfguardUser->getFirstName() . " " . $SfguardUser->getLastName() . ", ";
                TbTrialsiteuserpermissionfilesTable::addUser($id_trialsite, $session_user[$cont], $id_user);
            }
            $list_user = substr($list_user, 0, strlen($list_user) - 2);
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');

            //ACTUALIZAMOS LAS COORDENADAS EN GOOGLE FUSION TABLE
//            if (!$form->getObject()->isNew()) {
//                $lat = $form_trialsite['trstlatitudedecimal'];
//                $long = $form_trialsite['trstlongitudedecimal'];
//                $ft = new FusionTable();
//                $Rowid = null;
//                $Resultado = $ft->query("SELECT ROWID  FROM 1596286 WHERE id_trialsite = $id_trialsite");
//                $count = count($Resultado);
//                if ($count > 0) {
//                    foreach ($Resultado AS $Value) {
//                        $Rowid = $Value['rowid'];
//                        $ft->query("UPDATE 1596286 SET lat = '$lat', long = '$long'  WHERE ROWID  = '$Rowid'");
//                    }
//                }
//            }

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $tbtrialsite)));

            if ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@tbtrialsite_new');
            } else {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'tbtrialsite_edit', 'sf_subject' => $tbtrialsite));
            }
        } else {
            $this->getUser()->setFlash('error', "The item has not been saved due to some errors. $errfiles $errfoto", false);
        }
    }

    public function executeAutoinstitution($request) {
        $this->getResponse()->setContentType('application/json');
        $Institution = Doctrine::getTable('TbInstitution')->retrieveForSelect(
                        $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Institution));
    }

    public function executeAutocontactperson($request) {
        $this->getResponse()->setContentType('application/json');
        $Contactperson = Doctrine::getTable('TbContactperson')->retrieveForSelect(
                        $request->getParameter('q'), $request->getParameter('where'), $request->getParameter('limit')
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

    public function executeAutolocation($request) {
        $this->getResponse()->setContentType('application/json');

        $Locations = Doctrine::getTable('TbLocation')->retrieveForSelect(
                        $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Locations));
    }

    public function executeMaptrialsites($request) {
        $this->setLayout(false);
    }

    public function executeBatchuploadtrialsite(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Trial Site";
        $Cols = 13;
        $MaxRecordsFile = 5000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB

        $connection = Doctrine_Manager::getInstance()->connection();
        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadstrialsite = $UploadDir . "/filetrialsite";
        if (!is_dir($uploadstrialsite)) {
            mkdir($uploadstrialsite, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filetrialsite');
        $FileSize = $File['size'];
        $FileType = $File['type'];
        $FileName = $File['name'];
        $FileTmpName = $File['tmp_name'];
        $FileSizeMB = round(($FileSize / 1048576), 2);

        if ($FileName != '') {
            $extension = explode(".", $FileName);
            $FileExt = strtoupper($extension[1]);
            if ((!($FileExt == "XLS")) || ($FileSizeMB < 0) || ($FileSizeMB > 5) || ($DataFileSizeMB > 5)) {
                $Forma = "FileErrorTemplates";
                die(include("../lib/html/HTML.php"));
            }

            move_uploaded_file($FileTmpName, "$uploadstrialsite/$FileName");
            $inputFileName = "$uploadstrialsite/$FileName";

            $ExcelFile = new Spreadsheet_Excel_Reader();
            $ExcelFile->setOutputEncoding('UTF-8');
            $ExcelFile->read($inputFileName);
            error_reporting(E_ALL ^ E_NOTICE);
            $NumRows = $ExcelFile->sheets[0]['numRows'];
            $NumCols = $ExcelFile->sheets[0]['numCols'];
            $TotalRecord = $NumRows - 1;

            if ($Cols != $NumCols) {
                $Forma = "FileErrorTemplatesCols";
                die(include("../lib/html/HTML.php"));
            }

            if ($TotalRecord > $MaxRecordsFile) {
                $Forma = "FileErrorTemplatesRecords";
                die(include("../lib/html/HTML.php"));
            }

            $Forma = "Body";
            include("../lib/html/HTML.php");
            $error_filas = "";
            $grabados = 0;
            $errores = 0;

            for ($row = 2; $row <= $NumRows; ++$row) {
                $banderaerrorfila = false;
                $id_contactpersons = trim($ExcelFile->sheets[0]['cells'][$row][1]);
                $id_location = trim($ExcelFile->sheets[0]['cells'][$row][2]);
                $id_institution = trim($ExcelFile->sheets[0]['cells'][$row][3]);
                $id_country = trim($ExcelFile->sheets[0]['cells'][$row][4]);
                $trstname = trim($ExcelFile->sheets[0]['cells'][$row][5]);
                $trstlatitudedecimal = trim($ExcelFile->sheets[0]['cells'][$row][6]);
                $trstlongitudedecimal = trim($ExcelFile->sheets[0]['cells'][$row][7]);
                $trstaltitude = trim($ExcelFile->sheets[0]['cells'][$row][8]);
                $trstph = trim($ExcelFile->sheets[0]['cells'][$row][9]);
                $id_soil = trim($ExcelFile->sheets[0]['cells'][$row][10]);
                $id_taxonomyfao = trim($ExcelFile->sheets[0]['cells'][$row][11]);
                $trststatus = trim($ExcelFile->sheets[0]['cells'][$row][12]);
                $trststatereason = trim($ExcelFile->sheets[0]['cells'][$row][13]);

                if ($trstph == '')
                    $trstph = null;
                if ($id_soil == '')
                    $id_soil = null;
                if ($id_taxonomyfao == '')
                    $id_taxonomyfao = null;

                $Fields = '{"' . $id_contactpersons . '","' . $id_location . '","' . $id_institution . '","' . $id_country . '","' . $trstname . '","' . $trstlatitudedecimal . '","' . $trstlongitudedecimal . '","' . $trstaltitude . '","' . $trstph . '","' . $id_soil . '","' . $id_taxonomyfao . '","' . $trststatus . '","' . $trststatereason . '"}';
                $Fields = str_replace("'", "''", $Fields);
                $Fields = utf8_encode($Fields);
                $QUERY = "SELECT fc_checkfieldsbatchtrialsite('$Fields'::text[]) AS info;";
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

                if ($banderaerrorfila)
                    $error_filas .= "<b>Fila $row:</b> (" . substr($info, 2, (strlen($info) - 1)) . ") <br>";

                if (!$banderaerrorfila) {
                    $trstname = utf8_encode($trstname);
                    $trstlatitude = LatitudeSexagesimal($trstlatitudedecimal);
                    $trstlongitude = LongitudeSexagesimal($trstlongitudedecimal);
                    $id_trialsite = TbTrialsiteTable::addTrialsite(null, $id_location, $id_institution, $id_country, $trstname, $trstlatitude, $trstlatitudedecimal, $trstlongitude, $trstlongitudedecimal, $trstaltitude, $trstph, $id_soil, $id_taxonomyfao, $trststatus, $trststatereason, $id_user);
                    TbTrialsitecontactpersonTable::delTrialsitecontactperson($id_trialsite);
                    $ArrContactPerson = explode(",", $id_contactpersons);
                    foreach ($ArrContactPerson AS $id_contactperson) {
                        TbTrialsitecontactpersonTable::addTrialsitecontactperson($id_trialsite, $id_contactperson);
                    }
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

            echo "<script>FinishedProcess();</script>";
            if ($errores > 0)
                echo "<script>errores('$error_filas');</script>";
            die();
        }

        $this->MaxRecordsFile = $MaxRecordsFile;
        $this->MaxSizeFile = $MaxSizeFile;
        $this->Cols = $Cols;
    }

    public function executeDownloadestruturetrialsite(sfWebRequest $request) {
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("Herlin R. Espinosa G")
                ->setLastModifiedBy("Herlin R. Espinosa G")
                ->setTitle("File Structure Trial Site")
                ->setSubject("File Structure Trial Site")
                ->setDescription("File Structure Trial Site")
                ->setKeywords("File Structure Trial Site")
                ->setCategory("File Structure File site");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Contact person')
                ->setCellValue('B1', 'Id Location')
                ->setCellValue('C1', 'Id Institution')
                ->setCellValue('D1', 'Id Country')
                ->setCellValue('E1', 'Name')
                ->setCellValue('F1', 'Latitude Decimal')
                ->setCellValue('G1', 'Longitude Decimal')
                ->setCellValue('H1', 'Altitude')
                ->setCellValue('I1', 'Ph')
                ->setCellValue('J1', 'Id Soil')
                ->setCellValue('K1', 'Id Taxonomyfao')
                ->setCellValue('L1', 'Location Verified')
                ->setCellValue('M1', 'Location Verified Reason');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
//APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('L1:M1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Batch Upload Information');

//inicio: GENERAMOS EL LIBRO DE CONTACT PERSON
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Contact Person');
        $QUERY01 = Doctrine_Query::create()
                        ->select("CP.id_contactperson AS id, (CP.cnprfirstname||' ' ||CP.cnprlastname) AS name")
                        ->from("TbContactperson CP")
                        ->orderBy("CP.cnprfirstname");
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
//fin: GENERAMOS EL LIBRO DE CONTACT PERSON
//inicio: GENERAMOS EL LIBRO DE LOCATION
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet(2)->setTitle('Location');
        $QUERY02 = Doctrine_Query::create()
                        ->select("LC.id_location, LC.lctname")
                        ->addSelect("CN.cntname AS country")
                        ->from("TbLocation LC")
                        ->innerJoin("LC.TbCountry CN")
                        ->orderBy('CN.cntname, LC.lctname');
        $Resultado02 = $QUERY02->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Country');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Name');
        foreach ($Resultado02 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id_location);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->country);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila->lctname);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE LOCATION
//inicio: GENERAMOS EL LIBRO DE INSTITUCION
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->getActiveSheet(3)->setTitle('Institution');
        $QUERY03 = Doctrine_Query::create()
                        ->select("I.id_institution,I.insname")
                        ->addSelect("CN.cntname AS country")
                        ->from("TbInstitution I")
                        ->innerJoin("I.TbCountry CN")
                        ->orderBy('CN.cntname, I.insname');
        $Resultado03 = $QUERY03->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Country');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Name');
        foreach ($Resultado03 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id_institution);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->country);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila->insname);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE INSTITUCION
//inicio: GENERAMOS EL LIBRO DE COUNTRY
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(4);
        $objPHPExcel->getActiveSheet(4)->setTitle('Country');
        $QUERY04 = Doctrine_Query::create()
                        ->select("C.id_country AS id, C.cntname AS name")
                        ->from("TbCountry C")
                        ->orderBy("C.cntname");
        $Resultado04 = $QUERY04->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado04 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE COUNTRY
//inicio: GENERAMOS EL LIBRO DE SOIL
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(5);
        $objPHPExcel->getActiveSheet(5)->setTitle('Soil');
        $QUERY05 = Doctrine_Query::create()
                        ->select("S.id_soil AS id, S.soiname AS name")
                        ->from("TbSoil S")
                        ->orderBy("S.soiname");
        $Resultado05 = $QUERY05->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado05 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $i++;
        }
//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE SOIL
//inicio: GENERAMOS EL LIBRO DE TAXONOMY FAO
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(6);
        $objPHPExcel->getActiveSheet(6)->setTitle('Taxonomt FAO');
        $QUERY06 = Doctrine_Query::create()
                        ->select("T.id_taxonomyfao AS id, T.txnname AS name")
                        ->from("TbTaxonomyfao T")
                        ->orderBy("T.txnname");
        $Resultado06 = $QUERY06->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado06 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $i++;
        }
//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE TAXONOMY FAO
//inicio: GENERAMOS EL LIBRO DE LOCATION VERIFIED 
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(7);
        $objPHPExcel->getActiveSheet(6)->setTitle('Location Verified');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Value');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LOW RES');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PLAUSIBLE');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'UNLIKELY');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'UNSURE');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'CONFIRMED');
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'SELECTIVE AVAILABILITY');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE LOCATION VERIFIED
//ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="TrialSitesTemplate.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeDownloadkml($request) {
        $QUERY00 = Doctrine_Query::create()
                        ->select("TS.id_trialsite,TS.trstname,CN.cntname AS cntname,LC.lctname AS lctname,TS.trstlatitudedecimal,TS.trstlongitudedecimal, I.insname AS insname, fc_trialsite_contactperson(TS.id_trialsite) AS contactperson, TS.trststatus")
                        ->from("TbTrialsite TS")
                        ->innerJoin("TS.TbInstitution I")
                        ->innerJoin("TS.TbCountry CN")
                        ->innerJoin("TS.TbLocation LC")
                        ->orderBy("TS.trstname");
//echo $QUERY00->getSqlQuery(); die();
        $Resultado00 = $QUERY00->execute();
        $kml = array('<?xml version="1.0" encoding="UTF-8"?>');
        $kml[] = "<kml xmlns='http://earth.google.com/kml/2.1'>";
        $kml[] = " <Document>";
        $kml[] = " <Style id='restsaurantStyle'>";
        $kml[] = " <IconStyle id='restuarantIcon'>";
        $kml[] = " <Icon>";
        $kml[] = " <href>http://maps.google.com/mapfiles/kml/pal2/icon63.png</href>";
        $kml[] = " </Icon>";
        $kml[] = " </IconStyle>";
        $kml[] = " </Style>";
        $kml[] = " <Style id='barStyle'>";
        $kml[] = " <IconStyle id='barIcon'>";
        $kml[] = " <Icon>";
        $kml[] = " <href>http://maps.google.com/mapfiles/kml/pal2/icon27.png</href>";
        $kml[] = " </Icon>";
        $kml[] = " </IconStyle>";
        $kml[] = " </Style>";
        foreach ($Resultado00 AS $fila) {
            $id = $fila->id_trialsite;
            $name = str_replace("&", "-", $fila->trstname);
            $contactperson = $fila->contactperson;
            $country = $fila->cntname;
            $location = $fila->lctname;
            $status = $fila->trststatus;
            $longitude = $fila->trstlongitudedecimal;
            $latitude = $fila->trstlatitudedecimal;

            $description = "<p>" . str_replace("&", "-", $fila->insname) . "</p>";
            $description .= "<p>" . str_replace("&", "-", "$country - $location") . "</p>";
            $description .= "<p>" . str_replace("&", "-", $contactperson) . "</p>";
            $description .= "<p>" . str_replace("&", "-", $status) . "</p>";
            $description .= "<p><b>Logitude: </b>$longitude<b> - Latitude: </b>$latitude</p>";

            $kml[] = " <Placemark id='$id'>";
            $kml[] = " <name>$name</name>";
            $kml[] = " <description>$description</description>";
            $kml[] = " <styleUrl># Style</styleUrl>";
            $kml[] = " <Point>";
            $kml[] = " <coordinates>$longitude,$latitude</coordinates>";
            $kml[] = " </Point>";
            $kml[] = " </Placemark>";
        }
        $kml[] = " </Document>";
        $kml[] = "</kml>";
        $kmlOutput = join("\n", $kml);
        header('Content-type: application/vnd.google-earth.kml+xml');
        header("Content-Disposition: attachment; filename=TrialSites.kml\r\n\r\n");
        die($kmlOutput);
        echo $kmlOutput;
    }

    public function executeDownloadfile(sfWebRequest $request) {
        $id_trialsiteweather = $request->getParameter('id_trialsiteweather');
        $TbTrialsiteweather = Doctrine::getTable('TbTrialsiteweather')->findOneByIdTrialsiteweather($id_trialsiteweather);
        $filename = $TbTrialsiteweather->getTrstwtfile();
        $fileaccess = $TbTrialsiteweather->getTrstwtfileaccess();
        $id_trialsite = $TbTrialsiteweather->getIdTrialsite();
        $Trstwtlock = $TbTrialsiteweather->getTrstwtlock();
        $TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
        $id_user_trialsite = $TbTrialsite->getIdUser();
        $trstfileaccess = $TbTrialsite->getTrstfileaccess();

//VERIFICAMOS LOS PERMISOS DE DESCARGA
        $Permission = false;
        if (($trstfileaccess == 'Open to specified users') && (!($this->getUser()->hasCredential('Administrator')))) {
            $user = $this->getUser();
            $id_user = $this->getUser()->getGuardUser()->getId();
            $filas = 0;
            $QUERY00 = Doctrine_Query::create()
                            ->select("T.id_trialsiteuserpermissionfiles AS id")
                            ->from("TbTrialsiteuserpermissionfiles T")
                            ->where("T.id_trialsite = $id_trialsite")
                            ->andWhere("T.id_userpermission = $id_user");
            $Resultado00 = $QUERY00->execute();
            $filas = count($Resultado00);
            if ($filas == 0) {
                $Permission = true;
            }
        } else if (($trstfileaccess == 'Open to all users') && (!($this->getUser()->isAuthenticated()))) {
            echo "<script> alert('*** ERROR *** \\n\\n You must authenticate to download.!'); self.parent.tb_remove();</script>";
            Die();
        }

        if ($Trstwtlock == "N")
            $Permission = false;

        if ($Permission) {
            echo "<script> alert('*** ERROR *** \\n\\n Not permissions to Download!'); window.history.back();</script>";
            Die();
        } else {
            $Weathertrialsite = "Weathertrialsite_$id_trialsite";
            $uploadDir = sfConfig::get("sf_upload_dir");
            $dir_file = "$uploadDir/$Weathertrialsite/$filename";
            $dir_file = str_replace("/", "\\", $dir_file);
            $file = file($dir_file);
            $file2 = implode("", $file);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . str_replace(" ", "_", $filename) . "\r\n\r\n");
            header("Content-Length: " . strlen($file2) . "\n\n");
            echo $file2;
            die();
        }
    }

    public function executeDownloadfile2(sfWebRequest $request) {
        $id_trialsitephotograph = $request->getParameter('id_trialsitephotograph');
		if($id_trialsitephotograph != ""){
			$TbTrialsitephotograph = Doctrine::getTable('TbTrialsitephotograph')->findOneByIdTrialsitephotograph($id_trialsitephotograph);
			$filename = $TbTrialsitephotograph->getTrstphfile();
			$id_trialsite = $TbTrialsitephotograph->getIdTrialsite();
			$Trstphlock = $TbTrialsitephotograph->getTrstphlock();
			$TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
			$id_user_trialsite = $TbTrialsite->getIdUser();
			$trstfileaccess = $TbTrialsite->getTrstfileaccess();


	//VERIFICAMOS LOS PERMISOS DE DESCARGA
			$Permission = false;
			if (($trstfileaccess == 'Open to specified users') && (!($this->getUser()->hasCredential('Administrator')))) {
				$user = $this->getUser();
				$id_user = $this->getUser()->getGuardUser()->getId();
				$filas = 0;
				$QUERY00 = Doctrine_Query::create()
								->select("T.id_trialsiteuserpermissionfiles AS id")
								->from("TbTrialsiteuserpermissionfiles T")
								->where("T.id_trialsite = $id_trialsite")
								->andWhere("T.id_userpermission = $id_user");
				$Resultado00 = $QUERY00->execute();
				$filas = count($Resultado00);
				if ($filas == 0) {
					$Permission = true;
				}
			} else if (($trstfileaccess == 'Open to all users') && (!($this->getUser()->isAuthenticated()))) {
				echo "<script> alert('*** ERROR *** \\n\\n You must authenticate to download.!'); self.parent.tb_remove();</script>";
				Die();
			}

			if ($Trstphlock == "N")
				$Permission = false;

			if ($Permission) {
				echo "<script> alert('*** ERROR *** \\n\\n Not permissions to Download!'); window.history.back();</script>";
				Die();
			} else {
				$Photographtrialsite = "Photograph_$id_trialsite";
				$uploadDir = sfConfig::get("sf_upload_dir");
				$dir_file = "$uploadDir/$Photographtrialsite/$filename";
				$dir_file = str_replace("/", "\\", $dir_file);
				$file = file($dir_file);
				$file2 = implode("", $file);
				header("Content-Type: application/octet-stream");
				header("Content-Disposition: attachment; filename=" . str_replace(" ", "_", $filename) . "\r\n\r\n");
				header("Content-Length: " . strlen($file2) . "\n\n");
				echo $file2;
				die();
			}
		}
    }

    public function executeDeleterow(sfWebRequest $request) {
        $id_trialsiteweather = $request->getParameter('id_trialsiteweather');

        $TbTrialsiteweather = Doctrine::getTable('TbTrialsiteweather')->findOneByIdTrialsiteweather($id_trialsiteweather);
        $filename = $TbTrialsiteweather->getTrstwtfile();
        $fileaccess = $TbTrialsiteweather->getTrstwtfileaccess();
        $id_trialsite = $TbTrialsiteweather->getIdTrialsite();
        $TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
        $id_user_trialsite = $TbTrialsite->getIdUser();
        $user = $this->getUser();
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (($id_user != $id_user_trialsite) && (!($user->hasCredential('Administrator')))) {
//ADICIONAMOS LAS LINEA DEL MENSAJE
            $HTML = "<tr><td colspan=5><font color='red'>*** Not permissions to Delete ***</font> </td></tr>";
        } else {
//ELIMINAMOS EL ARCHIVO DEL SERVIDOR
            $Weathertrialsite = "Weathertrialsite_$id_trialsite";
            $uploadDir = sfConfig::get("sf_upload_dir");
            $dir_file = "$uploadDir/$Weathertrialsite/$filename";
            $dir_file = str_replace('/', '\\', $dir_file);
            exec("del /f " . '"' . $dir_file . '"');

//ELIMINAMOS EL ARCHIVO DE LA TABLA
            TbTrialsiteweathervariablesmeasuredTable::delTrialsiteweathervariablesmeasured($id_trialsiteweather);
            TbTrialsiteweatherTable::delTrialsiteweather($id_trialsiteweather);
        }
//CONSTRUIMOS LA TABLA NUEVAMENTE
        $QUERY = Doctrine_Query::create()
                        ->select("TSW.id_trialsiteweather,fc_trialsiteweathervariablesmeasured(TSW.id_trialsiteweather) AS variablesmeasured,TSW.trstwtfileaccess,TSW.trstwtfile,TSW.trstwtstartdate,TSW.trstwtenddate,TSW.trstwtlock")
                        ->from("TbTrialsiteweather TSW")
                        ->where("TSW.id_trialsite = $id_trialsite")
                        ->orderBy("TSW.id_trialsiteweather");
//echo $QUERY->getSqlQuery(); die();
        $Results = $QUERY->execute();
        $bgcolor = "#C0C0C0";
//TAMANO DE LAS COLUMNAS
        $width1 = '30%';
        $width2 = '30%';
        $width3 = '15%';
        $width4 = '15%';
        $width5 = '10%';
        foreach ($Results AS $row) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            if ($row['trstwtlock'] == "Y") {
                $Imag_trstwtlock = "Lock1-icon.png";
            } else {
                $Imag_trstwtlock = "Unlock-icon.png";
            }

            $HTML .= "<tr bgcolor='$bgcolor'>";
            $HTML .= "<td width='$width1'>{$row['variablesmeasured']}</td>";
            $HTML .= "<td width='$width2'>{$row['trstwtfile']}</td>";
            $HTML .= "<td width='$width3'>{$row['trstwtstartdate']}</td>";
            $HTML .= "<td width='$width4'>{$row['trstwtenddate']}</td>";
            $HTML .= "<td width='$width5'>";
            $HTML .= "<span alt='Download' onclick='downloadfile({$row['id_trialsiteweather']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
            $HTML .= "<span alt='Delete' onclick='deleterow({$row['id_trialsiteweather']})'><img src=\"/images/cross.png\"></span>&ensp;";
            $HTML .= "<span title='Click on the lock to change' alt='Click on the lock to change' onclick='Lock_Unlock({$row['id_trialsiteweather']})'><img src=\"/images/$Imag_trstwtlock\"></span>&ensp;";
            $HTML .= "</td>";
            $HTML .= "</tr>";
        }
        die($HTML);
    }

    public function executeLockUnlock(sfWebRequest $request) {
        $id_trialsiteweather = $request->getParameter('id_trialsiteweather');
        $TbTrialsiteweather = Doctrine::getTable('TbTrialsiteweather')->findOneByIdTrialsiteweather($id_trialsiteweather);
        $filename = $TbTrialsiteweather->getTrstwtfile();
        $fileaccess = $TbTrialsiteweather->getTrstwtfileaccess();
        $id_trialsite = $TbTrialsiteweather->getIdTrialsite();
        $Trstwtlock = $TbTrialsiteweather->getTrstwtlock();
        $TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
        $id_user_trialsite = $TbTrialsite->getIdUser();
        $user = $this->getUser();
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (($id_user != $id_user_trialsite) && (!($user->hasCredential('Administrator')))) {
//ADICIONAMOS LAS LINEA DEL MENSAJE
            $HTML = "<tr><td colspan=5><font color='red'>*** Not permissions to Change ***</font> </td></tr>";
        } else {
//CAMBIAMOS DE ESTADO EL REGISTROS Lock/Unlock
            if ($Trstwtlock == 'Y')
                $LockUnlock_new = 'N';
            else
                $LockUnlock_new = 'Y';

            $TbTrialsiteweather->setTrstwtlock($LockUnlock_new);
            $TbTrialsiteweather->save();
        }
        $QUERY = Doctrine_Query::create()
                        ->select("TSW.id_trialsiteweather,fc_trialsiteweathervariablesmeasured(TSW.id_trialsiteweather) AS variablesmeasured,TSW.trstwtfileaccess,TSW.trstwtfile,TSW.trstwtstartdate,TSW.trstwtenddate,TSW.trstwtlock")
                        ->from("TbTrialsiteweather TSW")
                        ->where("TSW.id_trialsite = $id_trialsite")
                        ->orderBy("TSW.id_trialsiteweather");
//echo $QUERY->getSqlQuery();
        $Results = $QUERY->execute();
        $bgcolor = "#C0C0C0";
//TAMANO DE LAS COLUMNAS
        $width1 = '30%';
        $width2 = '30%';
        $width3 = '15%';
        $width4 = '15%';
        $width5 = '10%';
        foreach ($Results AS $row) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            if ($row['trstwtlock'] == "Y") {
                $Imag_trstwtlock = "Lock1-icon.png";
            } else {
                $Imag_trstwtlock = "Unlock-icon.png";
            }

            $HTML .= "<tr bgcolor='$bgcolor'>";
            $HTML .= "<td width='$width1'>{$row['variablesmeasured']}</td>";
            $HTML .= "<td width='$width2'>{$row['trstwtfile']}</td>";
            $HTML .= "<td width='$width3'>{$row['trstwtstartdate']}</td>";
            $HTML .= "<td width='$width4'>{$row['trstwtenddate']}</td>";
            $HTML .= "<td width='$width5'>";
            $HTML .= "<span alt='Download' onclick='downloadfile({$row['id_trialsiteweather']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
            $HTML .= "<span alt='Delete' onclick='deleterow({$row['id_trialsiteweather']})'><img src=\"/images/cross.png\"></span>&ensp;";
            $HTML .= "<span title='Click on the lock to change' alt='Click on the lock to change' onclick='Lock_Unlock({$row['id_trialsiteweather']})'><img src=\"/images/$Imag_trstwtlock\"></span>&ensp;";
            $HTML .= "</td>";
            $HTML .= "</tr>";
        }
        die($HTML);
    }

    public function executeLockUnlock2(sfWebRequest $request) {
        $id_trialsitephotograph = $request->getParameter('id_trialsitephotograph');
        $TbTrialsitephotograph = Doctrine::getTable('TbTrialsitephotograph')->findOneByIdTrialsitephotograph($id_trialsitephotograph);
        $trstphfile = $TbTrialsitephotograph->getTrstphfile();
        $trstphfileaccess = $TbTrialsitephotograph->getTrstphfileaccess();
        $id_trialsite = $TbTrialsitephotograph->getIdTrialsite();
        $Trstphlock = $TbTrialsitephotograph->getTrstphlock();
        $TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
        $id_user_trialsite = $TbTrialsite->getIdUser();
        $user = $this->getUser();
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (($id_user != $id_user_trialsite) && (!($user->hasCredential('Administrator')))) {
//ADICIONAMOS LAS LINEA DEL MENSAJE
            $HTML2 = "<tr><td colspan=3><font color='red'>*** Not permissions to Change ***</font> </td></tr>";
        } else {
//CAMBIAMOS DE ESTADO EL REGISTROS Lock/Unlock
            if ($Trstphlock == 'Y')
                $LockUnlock_new = 'N';
            else
                $LockUnlock_new = 'Y';

            $TbTrialsitephotograph->setTrstphlock($LockUnlock_new);
            $TbTrialsitephotograph->save();
        }
//CONSTRUIMOS LA TABLA NUEVAMENTE
        $QUERY = Doctrine_Query::create()
                        ->select("TSP.id_trialsitephotograph,TSP.trstphfileaccess,TSP.trstphfile,TSP.trstphpersonphotograph,TSP.trstphlock")
                        ->from("TbTrialsitephotograph TSP")
                        ->where("TSP.id_trialsite = $id_trialsite")
                        ->orderBy("TSP.id_trialsitephotograph");
//echo $QUERY->getSqlQuery(); die();
        $Results = $QUERY->execute();
        $bgcolor = "#C0C0C0";
        $width1 = '30%';
        $width2 = '50%';
        $width3 = '20%';
        foreach ($Results AS $row) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            if ($row['trstphlock'] == "Y") {
                $Imag_trstphlock = "Lock1-icon.png";
            } else {
                $Imag_trstphlock = "Unlock-icon.png";
            }

            $A_Extension = array('JPG', 'JPEG', 'TIFF', 'PNG', 'BMP');
            $trstphfile = $row['trstphfile'];
            $PartFile = explode(".", $trstphfile);
            $Extension = strtoupper($PartFile[1]);

            $HTML2 .= "<tr bgcolor='$bgcolor'>";
            $HTML2 .= "<td width='$width1'>{$row['trstphfile']}</td>";
            $HTML2 .= "<td width='$width2'>{$row['trstphpersonphotograph']}</td>";
            $HTML2 .= "<td width='$width3'>";
            if (in_array($Extension, $A_Extension))
                $HTML2 .= "<span alt='View' onclick='viewphotograph({$row['id_trialsitephotograph']})'><img src=\"/images/images-icon.png\"></span>&ensp;";
            else
                $HTML2 .= "<span alt='Download' onclick='downloadfile2({$row['id_trialsitephotograph']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
            $HTML2 .= "<span alt='Delete' onclick='deleterow2({$row['id_trialsitephotograph']})'><img src=\"/images/cross.png\"></span>&ensp;";
            $HTML2 .= "<span title='Click on the lock to change' alt='Click on the lock to change' onclick='Lock_Unlock2({$row['id_trialsitephotograph']})'><img src=\"/images/$Imag_trstphlock\"></span>&ensp;";
            $HTML2 .= "</td>";
            $HTML2 .= "</tr>";
        }
        die($HTML2);
    }

    public function executeDeleterow2(sfWebRequest $request) {
        $id_trialsitephotograph = $request->getParameter('id_trialsitephotograph');
        $TbTrialsitephotograph = Doctrine::getTable('TbTrialsitephotograph')->findOneByIdTrialsitephotograph($id_trialsitephotograph);
        $trstphfile = $TbTrialsitephotograph->getTrstphfile();
        $trstphfileaccess = $TbTrialsitephotograph->getTrstphfileaccess();
        $id_trialsite = $TbTrialsitephotograph->getIdTrialsite();

        $TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
        $id_user_trialsite = $TbTrialsite->getIdUser();
        $user = $this->getUser();
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (($id_user != $id_user_trialsite) && (!($user->hasCredential('Administrator')))) {
//ADICIONAMOS LAS LINEA DEL MENSAJE
            $HTML2 = "<tr><td colspan=5><font color='red'>*** Not permissions to Delete ***</font> </td></tr>";
        } else {
//ELIMINAMOS EL ARCHIVO DEL SERVIDOR
            $Photographtrialsite = "Photograph_$id_trialsite";
            $uploadDir = sfConfig::get("sf_upload_dir");
            $dir_file = "$uploadDir/$Photographtrialsite/$trstphfile";
            $dir_file = str_replace('/', '\\', $dir_file);
            exec("del /f " . '"' . $dir_file . '"');

//ELIMINAMOS EL ARCHIVO DE LA TABLA
            TbTrialsitephotographTable::delTrialsitephotograph($id_trialsitephotograph);
        }
//CONSTRUIMOS LA TABLA NUEVAMENTE
        $QUERY = Doctrine_Query::create()
                        ->select("TSP.id_trialsitephotograph,TSP.trstphfileaccess,TSP.trstphfile,TSP.trstphpersonphotograph,TSP.trstphlock")
                        ->from("TbTrialsitephotograph TSP")
                        ->where("TSP.id_trialsite = $id_trialsite")
                        ->orderBy("TSP.id_trialsitephotograph");
//echo $QUERY->getSqlQuery(); die();
        $Results = $QUERY->execute();
        $bgcolor = "#C0C0C0";
        $width1 = '30%';
        $width2 = '50%';
        $width3 = '20%';
        foreach ($Results AS $row) {
            if ($bgcolor != "#FFFFD9")
                $bgcolor = "#FFFFD9";
            else
                $bgcolor = "#C0C0C0";

            if ($row['trstphlock'] == "Y") {
                $Imag_trstphlock = "Lock1-icon.png";
            } else {
                $Imag_trstphlock = "Unlock-icon.png";
            }

            $A_Extension = array('JPG', 'JPEG', 'TIFF', 'PNG', 'BMP');
            $trstphfile = $row['trstphfile'];
            $PartFile = explode(".", $trstphfile);
            $Extension = strtoupper($PartFile[1]);

            $HTML2 .= "<tr bgcolor='$bgcolor'>";
            $HTML2 .= "<td width='$width1'>{$row['trstphfile']}</td>";
            $HTML2 .= "<td width='$width2'>{$row['trstphpersonphotograph']}</td>";
            $HTML2 .= "<td width='$width3'>";
            if (in_array($Extension, $A_Extension))
                $HTML2 .= "<span alt='View' onclick='viewphotograph({$row['id_trialsitephotograph']})'><img src=\"/images/images-icon.png\"></span>&ensp;";
            else
                $HTML2 .= "<span alt='Download' onclick='downloadfile2({$row['id_trialsitephotograph']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
            $HTML2 .= "<span alt='Delete' onclick='deleterow2({$row['id_trialsitephotograph']})'><img src=\"/images/cross.png\"></span>&ensp;";
            $HTML2 .= "<span title='Click on the lock to change' alt='Click on the lock to change' onclick='Lock_Unlock2({$row['id_trialsitephotograph']})'><img src=\"/images/$Imag_trstphlock\"></span>&ensp;";
            $HTML2 .= "</td>";
            $HTML2 .= "</tr>";
        }
        die($HTML2);
    }

//weather variables measured
    public function executeWeathervariablesmeasuredlist($request) {
        $this->setLayout(false);
    }

    public function executeSaveweathervariablesmeasuredlist(sfWebRequest $request) {
        $this->setLayout(false);
        $fila = $request->getParameter('fila');
        $user = sfContext::getInstance()->getUser();
        $array_weathervariablesmeasured = sfContext::getInstance()->getRequest()->getParameterHolder()->get('weathervariablesmeasured');
        $weathervariablesmeasured_id = $array_weathervariablesmeasured['data']['id'];
        $weathervariablesmeasured_name = $array_weathervariablesmeasured['data']['title'];
        $weathervariablesmeasured_list = "";
        $session_weathervariablesmeasured_id = array();
        $session_weathervariablesmeasured_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weathervariablesmeasured_id' . $fila);
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weathervariablesmeasured_name' . $fila);
        foreach ($weathervariablesmeasured_id as $key => $id_weathervariablesmeasured) {
            $session_weathervariablesmeasured_id[] = $id_weathervariablesmeasured;
            $session_weathervariablesmeasured_name[] = $weathervariablesmeasured_name[$key];
            $weathervariablesmeasured_list .= $weathervariablesmeasured_name[$key] . ", ";
        }
        $user->setAttribute('weathervariablesmeasured_id' . $fila, $session_weathervariablesmeasured_id);
        $user->setAttribute('weathervariablesmeasured_name' . $fila, $session_weathervariablesmeasured_name);
        $weathervariablesmeasured_list = substr($weathervariablesmeasured_list, 0, strlen($weathervariablesmeasured_list) - 2);
        $this->weathervariablesmeasuredlist = $weathervariablesmeasured_list;
        $this->fila = $fila;
    }

    public function executeAutocompleteweathervariablesmeasured($request) {
        $dato = strtolower($request->getParameter('term'));
        $QUERY = Doctrine_Query::create()
                        ->select("T.id_weathervariablesmeasured, T.wtvrmsname AS name")
                        ->from("TbWeathervariablesmeasured T")
                        ->where("LOWER(T.wtvrmsname) LIKE '$dato%'")
                        ->orderBy("T.wtvrmsname")
                        ->limit(20);
//echo $QUERY->getSqlQuery(); die();
        $Results = $QUERY->execute();
        $rv = "";
        foreach ($Results AS $row) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $row['id_weathervariablesmeasured'] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeViewphotograph(sfWebRequest $request) {
        $this->setLayout(false);
        $id_trialsitephotograph = $request->getParameter('id_trialsitephotograph');
		if($id_trialsitephotograph != ""){
			$TbTrialsitephotograph = Doctrine::getTable('TbTrialsitephotograph')->findOneByIdTrialsitephotograph($id_trialsitephotograph);
			$filename = $TbTrialsitephotograph->getTrstphfile();
			$fileaccess = $TbTrialsitephotograph->getTrstphfileaccess();
			$id_trialsite = $TbTrialsitephotograph->getIdTrialsite();
			$Trstphlock = $TbTrialsitephotograph->getTrstphlock();
			$TbTrialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($id_trialsite);
			$id_user_trialsite = $TbTrialsite->getIdUser();
			$trstfileaccess = $TbTrialsite->getTrstfileaccess();
			$user = $this->getUser();
			$id_user = $this->getUser()->getGuardUser()->getId();

	//VERIFICAMOS LOS PERMISOS DE DESCARGA
			$Permission = false;
			if ($trstfileaccess == 'Open to specified users') {
				$filas = 0;
				$QUERY00 = Doctrine_Query::create()
								->select("T.id_trialsiteuserpermissionfiles AS id")
								->from("TbTrialsiteuserpermissionfiles T")
								->where("T.id_trialsite = $id_trialsite")
								->andWhere("T.id_userpermission = $id_user");
				$Resultado00 = $QUERY00->execute();
				$filas = count($Resultado00);
				if ($filas == 0) {
					$Permission = true;
				}
			}

			if ($Trstphlock == "N")
				$Permission = false;

			if ($Permission) {
				echo "<script> alert('*** ERROR *** \\n\\n Not permissions to View!'); window.close();</script>";
				Die();
			} else {
				$Photographtrialsite = "Photograph_$id_trialsite";
				$dir_file = "/uploads/$Photographtrialsite/$filename";
				$dir_file = str_replace("\\", "/", $dir_file);
				$this->ruta = $dir_file;
				$this->name = $filename;
			}
		}
    }

    public function executeTrialsitecontactperson($request) {
        $this->setLayout(false);
    }

    public function executeSavetrialsitecontactperson(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_contactpersons = sfContext::getInstance()->getRequest()->getParameterHolder()->get('contactpersons');
        $contactperson_id = $array_contactpersons['user']['id'];
        $contactperson_name = $array_contactpersons['user']['title'];
        $list_contactperson = "";
        $session_contactperson_id = array();
        $session_contactperson_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_name');
        foreach ($contactperson_id as $key => $id_contactperson) {
            $session_contactperson_id[] = $id_contactperson;
            $user->setAttribute('contactperson_id', $session_contactperson_id);
            $session_contactperson_name[] = $contactperson_name[$key];
            $user->setAttribute('contactperson_name', $session_contactperson_name);
            $list_contactperson .= $contactperson_name[$key] . ", ";
        }
        $list_contactperson = substr($list_contactperson, 0, strlen($list_contactperson) - 2);
        $this->name = $list_contactperson;
    }

    public function executeAutocontactpersons($request) {
        $dato = strtolower($request->getParameter('term'));
        $QUERY01 = Doctrine_Query::create()
                        ->select("CP.id_contactperson AS id, (CP.cnprfirstname||' '||CP.cnprlastname) AS name")
                        ->from("TbContactperson CP")
                        ->where("LOWER((CP.cnprfirstname||' '||CP.cnprlastname)) LIKE '$dato%'")
                        ->orderBy("CP.cnprfirstname")
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

    public function executeTrialsitesmap(sfWebRequest $request) {
        
    }

    public function executeViewphotosJSON(sfWebRequest $request) {
        $id_trialsite = $request->getParameter("id_trialsite");
        $this->id_trialsite = $id_trialsite;
        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY = "SELECT trstphfile,trstphpersonphotograph FROM tb_trialsitephotograph WHERE id_trialsite = $id_trialsite AND trstphlock = 'N'";
        $st = $connection->execute($QUERY);
        $Result = $st->fetchAll();
        $photos = null;
        foreach ($Result AS $Value) {
            $trstphfile = $Value[0];
            $trstphpersonphotograph = $Value[1];
            $Part_file = explode(".", $trstphfile);
            $Ext_file = strtoupper($Part_file[1]);
            $A_Extension = array('JPG', 'JPEG', 'TIFF', 'PNG', 'BMP', 'GIF');
            if (in_array($Ext_file, $A_Extension)) {
                $Photographtrialsite = "Photograph_$id_trialsite";
                $dir_file = "/uploads/$Photographtrialsite/$trstphfile";
                $dir_file = str_replace("\\", "/", $dir_file);
                $photos[] = array('name' => $trstphfile, 'url' => 'http://www.agtrials.org' . $dir_file);
            }
        }
        $photos_JSON = json_encode($photos);
        die($photos_JSON);
    }

    public function executeWeatherJSON(sfWebRequest $request) {
        $id_trialsite = $request->getParameter("id_trialsite");
        $this->id_trialsite = $id_trialsite;
        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY = "SELECT trstwtfile,trstwtstartdate,trstwtenddate  FROM tb_trialsiteweather WHERE id_trialsite = $id_trialsite AND trstwtlock = 'N'";
        $st = $connection->execute($QUERY);
        $Result = $st->fetchAll();
        $photos = null;
        foreach ($Result AS $Value) {
            $trstwtfile = $Value[0];
            $trstwtstartdate = $Value[1];
            $trstwtenddate = $Value[2];
            $DirWeathertrialsite = "Weathertrialsite_$id_trialsite";
            $dir_file = "/uploads/$DirWeathertrialsite/$trstwtfile";
            $dir_file = str_replace("\\", "/", $dir_file);
            $photos[] = array('name' => $trstwtfile, 'startdate' => $trstwtstartdate, 'enddate' => $trstwtenddate, 'url' => 'http://www.agtrials.org' . $dir_file);
        }
        $photos_JSON = json_encode($photos);
        die($photos_JSON);
    }

    public function executeDownloadlist(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $wherelist = $user->getAttribute('wherelist');
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(600);
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("")
                ->setSubject("Trial Site List")
                ->setDescription("Trial Site List")
                ->setKeywords("Trial Site List")
                ->setCategory("Trial Site List");

// Add some data

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id trial site')
                ->setCellValue('B1', 'Contact person')
                ->setCellValue('C1', 'Location')
                ->setCellValue('D1', 'Institution')
                ->setCellValue('E1', 'Country')
                ->setCellValue('F1', 'Name')
                ->setCellValue('G1', 'Latitude')
                ->setCellValue('H1', 'Longitude')
                ->setCellValue('I1', 'Altitude')
                ->setCellValue('J1', 'Ph')
                ->setCellValue('K1', 'Soil')
                ->setCellValue('L1', 'Taxonomy FAO')
                ->setCellValue('M1', 'Status')
                ->setCellValue('N1', 'Status Reason');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);


//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Trial Site');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT TS.id_trialsite, fc_trialsite_contactperson(TS.id_trialsite) AS contactperson,LC.lctname,INS.insname,CN.cntname, ";
        $QUERY00 .= "TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal,TS.trstaltitude,TS.trstph,S.soiname,TX.txnname,TS.trststatus,TS.trststatereason ";
        $QUERY00 .= "FROM tb_trialsite TS ";
        $QUERY00 .= "INNER JOIN tb_location LC ON TS.id_location = LC.id_location  ";
        $QUERY00 .= "INNER JOIN tb_institution INS ON TS.id_institution = INS.id_institution  ";
        $QUERY00 .= "INNER JOIN tb_country CN ON TS.id_country = CN.id_country  ";
        $QUERY00 .= "LEFT JOIN tb_soil S ON TS.id_soil = S.id_soil ";
        $QUERY00 .= "LEFT JOIN tb_taxonomyfao TX ON TS.id_taxonomyfao = TX.id_taxonomyfao ";
        $QUERY00 .= "WHERE true $wherelist ";
        $QUERY00 .= "ORDER BY TS.id_trialsite ";
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
            $i++;
        }

//ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Trial Site List.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeTrialsiteweatherstation($request) {
        $this->setLayout(false);
    }

    public function executeSavetrialsiteweatherstation(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_weatherstations = sfContext::getInstance()->getRequest()->getParameterHolder()->get('weatherstations');
        $weatherstation_id = $array_weatherstations['user']['id'];
        $weatherstation_name = $array_weatherstations['user']['title'];
        $list_weatherstation = "";
        $session_weatherstation_id = array();
        $session_weatherstation_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weatherstation_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('weatherstation_name');
        foreach ($weatherstation_id as $key => $id_weatherstation) {
            $session_weatherstation_id[] = $id_weatherstation;
            $user->setAttribute('weatherstation_id', $session_weatherstation_id);
            $session_weatherstation_name[] = $weatherstation_name[$key];
            $user->setAttribute('weatherstation_name', $session_weatherstation_name);
            $list_weatherstation .= $weatherstation_name[$key] . ", ";
        }
        $list_weatherstation = substr($list_weatherstation, 0, strlen($list_weatherstation) - 2);
        $this->name = $list_weatherstation;
    }

    public function executeAutoweatherstations($request) {
        $dato = strtolower($request->getParameter('term'));
        $QUERY01 = Doctrine_Query::create()
                        ->select("WS.*,WS.id_weatherstation AS id, (WS.wtstname||' - '||C.cntname) AS name")
                        ->from("TbWeatherstation WS")
                        ->leftJoin("WS.TbCountry C")
                        ->where("LOWER((WS.wtstname||' '||C.cntname)) LIKE '$dato%'")
                        ->orderBy("WS.wtstname,C.cntname")
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

    public function executeTrialsitespecifiedusers($request) {
        $this->setLayout(false);
    }

    public function executeSavetrialsitespecifiedusers(sfWebRequest $request) {
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

    public function executeChecktrialsite(sfWebRequest $request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_country');
    }

    public function executeViewtrialsite(sfWebRequest $request) {
        $this->setLayout(false);
        $id_trialsite = $request->getParameter('info');
        $TbTrialsite = Doctrine_Query::create()
                        ->select("TS.id_trialsite,I.insname AS institution,CN.cntname AS country,LC.lctname AS location")
                        ->from("TbTrialsite TS")
                        ->innerJoin("TS.TbInstitution I")
                        ->innerJoin("TS.TbCountry CN")
                        ->innerJoin("TS.TbLocation LC")
                        ->where("TS.id_trialsite = $id_trialsite")
                        ->execute();
        $this->TbTrialsite = $TbTrialsite;
    }

    public function executeAssigncountry($request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_country');
        $id_country = $request->getParameter('id_country');
        $user = sfContext::getInstance()->getUser();
        $user->setAttribute('id_country', $id_country);
        die();
    }

    public function executeSelectletter(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $id_country = $user->getAttribute('id_country');
        $Letter = $request->getParameter('letter');
        $HTML = "";
        if ($id_country == "") {
            $HTML = "Please Select Country!";
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY01 = "SELECT TS.id_trialsite,TS.trstname,LC.lctname,TS.trstlatitudedecimal,TS.trstlongitudedecimal FROM tb_trialsite TS INNER JOIN tb_location LC ON TS.id_location = LC.id_location WHERE TS.id_country = $id_country AND UPPER(TS.trstname) LIKE '$Letter%' ORDER BY TS.trstname";
            $st = $connection->execute($QUERY01);
            $Record = $st->fetchAll();
            $total = count($Record);
            $ListIdTrialSite = "";
            if ($total > 0) {
                $corte = round($total / 2);
                $flag = 1;
                $HTML = "<b>$total Results by '$Letter'</b> <br>";
                $HTML .= "<div id='Div1'>";
                foreach ($Record AS $Value) {
                    $id_trialsite = $Value['id_trialsite'];
                    $trstname = $Value['trstname'];
                    $lctname = $Value['lctname'];
                    $latitude = round($Value['trstlatitudedecimal'], 4);
                    $longitude = round($Value['trstlongitudedecimal'], 4);
                    $View = "<a href='#' title='View' onclick=\"window.open('/viewtrialsite/info/$id_trialsite','ViewTrialSite','height=700,width=900,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> View</a>";
                    $Data = "$id_trialsite -> $trstname ($latitude,$longitude) $View";


                    if ($flag <= $corte) {
                        $HTML .= "<span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)')>$Data</span> <br>";
                    } else {
                        if ($flag == $corte + 1)
                            $HTML .= "</div><div id='Div2'><span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)'>$Data</span> <br>";
                        else
                            $HTML .= "<span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)'>$Data</span> <br>";
                    }
                    $ListIdTrialSite .= $id_trialsite . ",";
                    $flag++;
                }
                $HTML .= "</div>";
            }else {
                $HTML = "<b>No results by '$Letter'</b>";
            }
        }
        die($HTML);
    }

    public function executeValidatetrialsite(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $id_country = $user->getAttribute('id_country');
        $listtrialsite = $request->getParameter('listtrialsite');
        $Arr_trialsite = explode(",", $listtrialsite);
        $ListTrialsite = "";
        $ListTrialsiteError = "";
        $ListIdTrialsite = "";
        $HTML = "";
        if ($id_country == "") {
            $HTML = "Please Select Country!";
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            foreach ($Arr_trialsite AS $trialsite) {
                $trialsite = mb_strtoupper(trim($trialsite), "UTF-8");
                $QUERY00 = "SELECT TS.id_trialsite,TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal FROM tb_trialsite TS WHERE TS.id_country = $id_country AND UPPER(REPLACE(TS.trstname,' ','')) LIKE '%'||UPPER(REPLACE('$trialsite',' ',''))||'%' ORDER BY TS.trstname";
                $st = $connection->execute($QUERY00);
                $Record = $st->fetchAll();
                $total = count($Record);
                if ($total > 0) {
                    foreach ($Record AS $Value) {
                        $Arr_Result[] = array($Value['id_trialsite'], $Value['trstname'], $Value['trstlatitudedecimal'], $Value['trstlongitudedecimal']);
                        $ListIdVariety .= $Value['id_trialsite'] . ",";
                    }
                } else {
                    $ListTrialsiteError .= ucfirst(strtolower($trialsite)) . ", ";
                }
            }

            $ListTrialsiteError = substr($ListTrialsiteError, 0, strlen($ListTrialsiteError) - 2);
            if ($ListTrialsiteError != "")
                $ListTrialsiteError = "<b>Trial site not found</b><br>" . $ListTrialsiteError;

            $total = count($Arr_Result);
            if ($total > 0) {
                $corte = round($total / 2);
                $flag = 1;
                $HTML = "<b>$total Results found</b> <br>";
                $HTML .= "<div id='Div1'>";
                foreach ($Arr_Result AS $Value) {
                    $id_trialsite = $Value[0];
                    $trstname = $Value[1];
                    $latitude = round($Value[2], 4);
                    $longitude = round($Value[3], 4);
                    $View = "<a href='#' title='View' onclick=\"window.open('/viewtrialsite/info/$id_trialsite','ViewTrialSite','height=700,width=900,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> View</a>";
                    $Data = "$id_trialsite -> $trstname ($latitude,$longitude) $View";

                    if ($flag <= $corte) {
                        $HTML .= "<span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)')>$Data</span> <br>";
                    } else {
                        if ($flag == $corte + 1)
                            $HTML .= "</div><div id='Div2'><span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)'>$Data</span> <br>";
                        else
                            $HTML .= "<span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)'>$Data</span> <br>";
                    }
                    $ListIdTrialSite .= $id_trialsite . ",";
                    $flag++;
                }
                $HTML .= "</div>";
            }else {
                $HTML = "<b>No results for '$listtrialsite'</b>";
            }
        }
        if ($ListIdTrialSite != '')
            $ListIdTrialSite = substr($ListIdTrialSite, 0, strlen($ListIdTrialSite) - 1);
        else
            $ListIdTrialSite = "";


        $ARRAY_HTML['info'] = $HTML;
        $ARRAY_HTML['error'] = $ListTrialsiteError;
        $ARRAY_HTML['codes'] = $ListIdTrialSite;
        $JSON_Data = json_encode($ARRAY_HTML);
        die($JSON_Data);
    }

    public function executeValidatecoordenates(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $id_country = $user->getAttribute('id_country');
        $Latitude1 = $request->getParameter('Latitude1');
        $Latitude2 = $request->getParameter('Latitude2');
        $Longitude1 = $request->getParameter('Longitude1');
        $Longitude2 = $request->getParameter('Longitude2');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY01 = "SELECT TS.id_trialsite,TS.trstname,LC.lctname,TS.trstlatitudedecimal,TS.trstlongitudedecimal FROM tb_trialsite TS INNER JOIN tb_location LC ON TS.id_location = LC.id_location WHERE TS.trstlatitudedecimal BETWEEN '$Latitude1' AND '$Latitude2' AND TS.trstlongitudedecimal BETWEEN '$Longitude1' AND '$Longitude2' ORDER BY TS.trstname";
        $st = $connection->execute($QUERY01);
        $Record = $st->fetchAll();
        $total = count($Record);
        $ListIdTrialSite = "";
        if ($total > 0) {
            $corte = round($total / 2);
            $flag = 1;
            $HTML = "<b>$total Results by 'Latitude Between:($Latitude1 and $Latitude1) Longitude Between:($Longitude1 and $Longitude2)'</b> <br>";
            $HTML .= "<div id='Div1'>";
            foreach ($Record AS $Value) {
                $id_trialsite = $Value['id_trialsite'];
                $trstname = $Value['trstname'];
                $lctname = $Value['lctname'];
                $latitude = round($Value['trstlatitudedecimal'], 4);
                $longitude = round($Value['trstlongitudedecimal'], 4);
                $View = "<a href='#' title='View' onclick=\"window.open('/viewtrialsite/info/$id_trialsite','ViewTrialSite','height=700,width=900,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> View</a>";
                $Data = "$id_trialsite -> $trstname ($latitude,$longitude) $View";


                if ($flag <= $corte) {
                    $HTML .= "<span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)')>$Data</span> <br>";
                } else {
                    if ($flag == $corte + 1)
                        $HTML .= "</div><div id='Div2'><span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)'>$Data</span> <br>";
                    else
                        $HTML .= "<span onmouseover='CambiaColorOver(this)' onmouseout='CambiaColorOut(this)'>$Data</span> <br>";
                }
                $ListIdTrialSite .= $id_trialsite . ",";
                $flag++;
            }
            $HTML .= "</div>";
        }else {
            $HTML = "<b>No results by 'Latitude Between:($Latitude1 and $Latitude1) Longitude Between:($Longitude1 and $Longitude2)'</b>";
        }

        die($HTML);
    }

    public function executeChecktrialsitebatch(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Trial Site";
        $Cols = 1;
        $MaxRecordsFile = 50000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB
        $GenerateFile = false;

        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadstrialsite = $UploadDir . "/tmp$id_user";
        if (!is_dir($uploadstrialsite)) {
            mkdir($uploadstrialsite, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filetrialsite');
        $FileSize = $File['size'];
        $FileType = $File['type'];
        $FileName = $File['name'];
        $FileTmpName = $File['tmp_name'];
        $FileSizeMB = round(($FileSize / 1048576), 2);

        //CREAMOS EL ARCHIVO DE SALIDA
        $PathFile = $UploadDir . "/tmp$id_user/ResultFileData.xls";
        if (file_exists($PathFile))
            unlink($PathFile);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("Result File Check Trial Site")
                ->setSubject("Result File Check Trial Site")
                ->setDescription("Result File Check Trial Site")
                ->setKeywords("Result File Check Trial Site")
                ->setCategory("Result File Check Trial Site");
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Code')
                ->setCellValue('B1', 'Correct Name');

        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet(0)->setTitle('Founds');
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Posibles');
        $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue('A1', 'Original Name')
                ->setCellValue('B1', 'Posibles Names');
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet(2)->setTitle('Not Founds');
        $objPHPExcel->setActiveSheetIndex(2)
                ->setCellValue('A1', 'Name');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        if ($FileName != '') {
            $GenerateFile = true;
            $id_country = $request->getParameter('id_country');
            $connection = Doctrine_Manager::getInstance()->connection();
            $extension = explode(".", $FileName);
            $FileExt = strtoupper($extension[1]);
            if ((!($FileExt == "XLS")) || ($FileSizeMB < 0) || ($FileSizeMB > 5) || ($DataFileSizeMB > 5)) {
                $Forma = "FileErrorCheckTemplates";
                die(include("../lib/html/HTML.php"));
            }

            move_uploaded_file($FileTmpName, "$uploadstrialsite/$FileName");
            $inputFileName = "$uploadstrialsite/$FileName";

            $ExcelFile = new Spreadsheet_Excel_Reader();
            $ExcelFile->setOutputEncoding('UTF-8');
            $ExcelFile->read($inputFileName);
            error_reporting(E_ALL ^ E_NOTICE);
            $NumRows = $ExcelFile->sheets[0]['numRows'];
            $NumCols = $ExcelFile->sheets[0]['numCols'];
            $TotalRecord = $NumRows - 1;

            if ($Cols != $NumCols) {
                $Forma = "FileErrorCheckTemplatesCols";
                die(include("../lib/html/HTML.php"));
            }

            if ($TotalRecord > $MaxRecordsFile) {
                $Forma = "FileErrorCheckTemplatesRecords";
                die(include("../lib/html/HTML.php"));
            }

            $Forma = "BodyCheck";
            include("../lib/html/HTML.php");
            $error_filas = "";
            $grabados = 0;
            $errores = 0;

            $i = 2;
            $a = 2;
            $x = 2;
            for ($row = 2; $row <= $NumRows; ++$row) {
                $trstname = trim($ExcelFile->sheets[0]['cells'][$row][1]);

                //AQUI REALIZAMOS LA VALIDACION Y/O BUSQUEDA DE POSIBLES VALORES
                if ($trstname != '') {
                    $QUERY00 = "SELECT id_trialsite,trstname FROM tb_trialsite WHERE id_country = $id_country AND UPPER(REPLACE(trstname,' ','')) = UPPER(REPLACE('$trstname',' ',''))";
                    $ResultQUERY00 = $connection->execute($QUERY00);
                    $DataResult00 = $ResultQUERY00->fetchAll();
                    if (count($DataResult00) > 0) {
                        foreach ($DataResult00 AS $Value) {
                            $id_trialsite = $Value[0];
                            $trstname = $Value[1];
                        }
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue("A$i", $id_trialsite)
                                ->setCellValue("B$i", $trstname);
                        $i++;
                    } else {
                        $QUERY01 = "SELECT trstname FROM tb_trialsite WHERE id_country = $id_country AND UPPER(REPLACE(trstname,' ','')) LIKE '%'||UPPER(REPLACE('$trstname',' ',''))||'%'";
                        $ResultQUERY01 = $connection->execute($QUERY01);
                        $DataResult01 = $ResultQUERY01->fetchAll();
                        $ListPosibles = "";
                        if (count($DataResult01) > 0) {
                            foreach ($DataResult01 AS $Value) {
                                $ListPosibles .= $Value[0] . ", ";
                            }
                            $ListPosibles = substr($ListPosibles, 0, strlen($ListPosibles) - 2);
                            $objPHPExcel->setActiveSheetIndex(1)
                                    ->setCellValue("A$a", $trstname)
                                    ->setCellValue("B$a", $ListPosibles);
                            $a++;
                        } else {
                            $objPHPExcel->setActiveSheetIndex(2)
                                    ->setCellValue("A$x", $trstname);
                            $x++;
                        }
                    }
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

            echo "<script>FinishedProcess();</script>";
            if ($errores > 0)
                echo "<script>errores('$error_filas');</script>";
        }

        if ($GenerateFile) {
            $ResultFileData = "ResultFileData.xls";
            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save("$uploadstrialsite/$ResultFileData");
            die();
        }
        $this->MaxRecordsFile = $MaxRecordsFile;
        $this->MaxSizeFile = $MaxSizeFile;
        $this->Cols = $Cols;
    }

    public function executeDownloadchecktrialsitetemplate(sfWebRequest $request) {
        $UploadDir = sfConfig::get("sf_upload_dir");
        $PathFileTemplate = $UploadDir . "/CheckTrialSiteTemplate.xls";
        if (file_exists($PathFileTemplate)) {
            header('Content-Disposition: attachment; filename="CheckTrialSiteTemplate.xls"');
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($PathFileTemplate));
            readfile($PathFileTemplate);
        }
        die();
    }

    public function executeResultfilechecktrialsite(sfWebRequest $request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        $UploadDir = sfConfig::get("sf_upload_dir");
        $PathFile = $UploadDir . "/tmp$id_user/ResultFileData.xls";
        if (file_exists($PathFile)) {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="ResultFileData.xls"');
            readfile($PathFile);
        }
        die();
    }


}

