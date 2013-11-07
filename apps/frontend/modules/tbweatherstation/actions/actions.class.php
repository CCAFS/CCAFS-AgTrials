<?php

require_once dirname(__FILE__) . '/../lib/tbweatherstationGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbweatherstationGeneratorHelper.class.php';
require_once '../lib/funtions/funtion.php';

/**
 * tbweatherstation actions.
 *
 * @package    trialsites
 * @subpackage tbweatherstation
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbweatherstationActions extends autoTbweatherstationActions {

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
        $this->hasFilters = $this->getUser()->getAttribute('tbweatherstation.filters', $this->configuration->getFilterDefaults(), 'admin_module');
    }

    public function executeFilter(sfWebRequest $request) {
        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@tbweatherstation');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid()) {
            $this->setFilters($this->filters->getValues());

            $this->redirect('@tbweatherstation');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbweatherstation = $this->form->getObject();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbweatherstation = $this->form->getObject();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->tbweatherstation = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->tbweatherstation);

        //VERIFICAMOS LOS PERMISOS DE MODIFICACION
        $id_weatherstation = $request->getParameter("id_weatherstation");
        $user = $this->getUser();
        $id_user = $this->getUser()->getGuardUser()->getId();
        $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($id_weatherstation);
        $id_user_registro = $TbWeatherstation->getIdUser();
        if (($id_user != $id_user_registro) && (!($user->hasCredential('Administrator')))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not permissions to EDIT!'); window.history.back();</script>";
            Die();
        }

        //INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_weatherstationuserpermission
        $TbWeatherstationuserpermission = Doctrine::getTable('TbWeatherstationuserpermission')->findByIdWeatherstation($id_weatherstation);
        for ($cont = 0; $cont < count($TbWeatherstationuserpermission); $cont++) {
            $SfGuardUser = Doctrine::getTable('SfGuardUser')->findOneById($TbWeatherstationuserpermission[$cont]->getIdUserpermission());
            $user_id_saved[] = $SfGuardUser->getId();
            $user_name_saved[] = $SfGuardUser->getFirstName() . " " . $SfGuardUser->getLastName();
        }
        $user->setAttribute('user_id', $user_id_saved);
        $user->setAttribute('user_name', $user_name_saved);
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->tbweatherstation = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->tbweatherstation);

        //VERIFICAMOS LOS PERMISOS DE ACTUALIZACION
        $id_weatherstation = $request->getParameter("id_weatherstation");
        $user = $this->getUser();
        $id_user = $this->getUser()->getGuardUser()->getId();
        $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($id_weatherstation);
        $id_user_registro = $TbWeatherstation->getIdUser();
        if (($id_user != $id_user_registro) && (!($user->hasCredential('Administrator')))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not permissions to UPDATE!'); window.history.back();</script>";
            Die();
        }

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        //VERIFICAMOS LOS PERMISOS DE ELIMINAR
        $id_weatherstation = $request->getParameter("id_weatherstation");
        $user = $this->getUser();
        $id_user = $this->getUser()->getGuardUser()->getId();
        $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($id_weatherstation);
        $id_user_registro = $TbWeatherstation->getIdUser();
        if (($id_user != $id_user_registro) && (!($user->hasCredential('Administrator')))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not permissions to DELETE!'); window.history.back();</script>";
            Die();
        }

        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
        $id_weatherstation = $request->getParameter("id_weatherstation");
        TbWeatherstationuserpermissionTable::delUser($id_weatherstation);
        $this->getRoute()->getObject()->delete();

        $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

        $this->redirect('@tbweatherstation');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

            $tbweatherstation = $form->save();
            $id_weatherstation = $tbweatherstation['id_weatherstation'];
            $user = sfContext::getInstance()->getUser();

            //INICIO: AQUI ASIGNAMOS LOS PERMISOS A LA TABLA tb_weatherstationuserpermission
            if ($tbweatherstation->getWtstrestricted() == 'NO') {
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
                TbWeatherstationuserpermissionTable::delUser($id_weatherstation);
            } else {
                $session_user = $user->getAttribute('user_id');
                $list_user = "";
                TbWeatherstationuserpermissionTable::delUser($id_weatherstation);
                for ($cont = 0; $cont < count($session_user); $cont++) {
                    $SfguardUser = Doctrine::getTable('SfguardUser')->findOneById($session_user[$cont]);
                    $list_user .= $SfguardUser->getFirstName() . " " . $SfguardUser->getLastName() . ", ";
                    TbWeatherstationuserpermissionTable::addUser($id_weatherstation, $session_user[$cont]);
                }
                $list_user = substr($list_user, 0, strlen($list_user) - 2);
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_id');
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('user_name');
            }

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $tbweatherstation)));

            if ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@tbweatherstation_new');
            } else {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'tbweatherstation_edit', 'sf_subject' => $tbweatherstation));
            }
        } else {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }

    public function executeBatchuploadmeteorology(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $form = false;
        if (!$request->getParameter("form")) {
            $form = true;
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_weatherstation');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('meteorologicalfields_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('meteorologicalfields_name');
        } else {
            $id_weatherstation = $request->getParameter("id_weatherstation");
            $user->setAttribute('id_weatherstation', $id_weatherstation);
        }

        //AQUI PORCESAMOS LA INFORMACION
        if ($request->getParameter("forma2")) {
            $filedata = $_FILES["FileInformation"]['name'];
            if ($filedata != '') {
                $uploadDir = sfConfig::get("sf_upload_dir");
                $tmp_uploads = $uploadDir . "/tmp$id_user";
                if (!is_dir($tmp_uploads)) {
                    mkdir($tmp_uploads, 0777);
                }
                move_uploaded_file($_FILES["FileInformation"]['tmp_name'], "$tmp_uploads/$filedata");
                $inputFileName = "$tmp_uploads/$filedata";
                SaveMeteorologicalFieldsData($inputFileName);
            }
            echo "<script> alert('*** Successfully completed ***'); window.history.back();</script>";
            $this->redirect('@batchuploadmeteorology');
        }

        $this->form = $form;
    }

    public function executeListmeteorologicalfields($request) {
        $this->setLayout(false);
    }

    public function executeSavelistmeteorologicalfields(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $list_meteorologicalfields = "";
        $session_meteorologicalfields_id = array();
        $session_meteorologicalfields_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('meteorologicalfields_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('meteorologicalfields_name');
        $Datos = $request->getParameter('datos');
        for ($i = 1; $i <= $Datos; $i++) {
            $Valor = $request->getParameter('meteorologicalfields' . $i);
            if ($Valor != '') {
                $session_meteorologicalfields_id[] = $Valor;
                $user->setAttribute('meteorologicalfields_id', $session_meteorologicalfields_id);
                $TbMeteorologicalfields = Doctrine::getTable('TbMeteorologicalfields')->findOneByIdMeteorologicalfields($Valor);
                $name = $TbMeteorologicalfields->getMtflname();
                $session_meteorologicalfields_name[] = $name[$key];
                $user->setAttribute('meteorologicalfields_name', $session_meteorologicalfields_name);
                $list_meteorologicalfields .= $name . ", ";
            }
        }
        $list_meteorologicalfields = substr($list_meteorologicalfields, 0, strlen($list_meteorologicalfields) - 2);
        $this->name = $list_meteorologicalfields;
    }

    public function executeWeatherstationuserpermission($request) {
        $this->setLayout(false);
    }

    public function executeSaveweatherstationuserpermission(sfWebRequest $request) {
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

    public function executeTemplatemeteorologicalfields(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        //AQUI CONSULTAMOS LA VARIEDADES SELECIONADAS Y GENERAMOS LA CADENA LA CREAR EL SELECT CON ESTOS DATOS
        $SS_id_weatherstation = $user->getAttribute('id_weatherstation');
        $SS_meteorologicalfields_id = $user->getAttribute('meteorologicalfields_id');

        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(600);
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("Template Meteorological Fields Data")
                ->setSubject("Template Meteorological Fields Data")
                ->setDescription("Template Meteorological Fields Data")
                ->setKeywords("Template Meteorological Fields Data")
                ->setCategory("Template Meteorological Fields Data");

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet(0)->setTitle('MeteorologicalFieldsData');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Weather Station');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Date(yyyy-mm-dd hh:mm:ss)');

        //AQUI GENERAMOS LAS FILA DE VARIABLES MEDIDAS
        $letter = "B";
        foreach ($SS_meteorologicalfields_id AS $meteorologicalfields_id) {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT MF.id_meteorologicalfields, MF.mtflname, MF.mtflunit ";
            $QUERY00 .= "FROM tb_meteorologicalfields MF ";
            $QUERY00 .= "WHERE MF.id_meteorologicalfields = $meteorologicalfields_id ";
            $st = $connection->execute($QUERY00);
            $Resultado02 = $st->fetchAll();
            foreach ($Resultado02 AS $fila) {
                $Name = $fila['mtflname'];
                $Unit = $fila['mtflunit']; //asqui
            }
            $NameMeteorologicalFields = "$meteorologicalfields_id - $Name - ($Unit)";
            $letter = NextLetter($letter);
            $objPHPExcel->getActiveSheet()->setCellValue($letter . '1', $NameMeteorologicalFields);
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($letter . '1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getStyle($letter . '1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        }

        //AQUI GENERAMOS LAS COLUMNAS
        $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($SS_id_weatherstation);
        $NameWeatherStation = $TbWeatherstation->getWtstname();
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "$SS_id_weatherstation - $NameWeatherStation");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', date("Y-m-d") . " " . date("H:i:s"));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);


        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $letter . '1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        //APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        //ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="TemplateMeteorologicalFieldsData.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeDownloadweatherinformation(sfWebRequest $request) {
        $id_weatherstation = $request->getParameter("id_weatherstation");
        $TbWeatherstation = Doctrine::getTable('TbWeatherstation')->findOneByIdWeatherstation($id_weatherstation);
        $WSName = $TbWeatherstation->getWtstname();
        $WSlatitude = $TbWeatherstation->getWtstlatitude();
        $WSlongitude = $TbWeatherstation->getWtstlongitude();
        $WSelevation = $TbWeatherstation->getWtstelevation();
        $WStemperatureamplitude = null;
        $WStemperatureaverage = null;
        $WSreferenceheightweather = null;
        $WSreferenceheightwindspeed = null;
        $startdate = changedate($request->getParameter("startdate")) . " 00:00:00";
        $enddate = changedate($request->getParameter("enddate")) . " 00:00:00";
        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT id_meteorologicalfields FROM tb_weatherdata WHERE id_weatherstation = $id_weatherstation AND wtdtdate BETWEEN '$startdate' AND '$enddate' GROUP BY id_meteorologicalfields";
        $st = $connection->execute($QUERY00);
        $Resultado00 = $st->fetchAll();
        $Arr_meteorologicalfields_id = null;
        foreach ($Resultado00 AS $fila) {
            $Arr_meteorologicalfields_id[] = $fila['id_meteorologicalfields'];
        }

        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        set_time_limit(1200);
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("Meteorology-$WSName")
                ->setSubject("Meteorology-$WSName")
                ->setDescription("Meteorology-$WSName")
                ->setKeywords("Meteorology-$WSName")
                ->setCategory("Meteorology-$WSName");

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet(0)->setTitle($WSName);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Name:');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $WSName);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Latitude:');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', $WSlatitude);

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Longitude:');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', $WSlongitude);

        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Elevation:');
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B4', $WSelevation);

        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Temperature amplitude:');
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B5')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', $WStemperatureamplitude);

        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Temperature average:');
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B6')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B6', $WStemperatureaverage);

        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Reference height weather:');
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B7')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B7', $WSreferenceheightweather);

        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Reference height wind speed:');
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B8')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B8', $WSreferenceheightwindspeed);

        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Range of Dates:');
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->setCellValue('B9', "From $startdate To $enddate");

        $letter = "A";
        $i = 11;
        $objPHPExcel->getActiveSheet()->setCellValue($letter . $i, 'Date(yyyy-mm-dd hh:mm:ss)');
        $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);

        //AQUI GENERAMOS LAS FILA DE VARIABLES MEDIDAS
        $Arr_meteorologicalfields_letter = null;
        foreach ($Arr_meteorologicalfields_id AS $meteorologicalfields_id) {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY01 = "SELECT MF.id_meteorologicalfields, MF.mtflname, MF.mtflunit ";
            $QUERY01 .= "FROM tb_meteorologicalfields MF ";
            $QUERY01 .= "WHERE MF.id_meteorologicalfields = $meteorologicalfields_id ";
            $st = $connection->execute($QUERY01);
            $Resultado01 = $st->fetchAll();
            foreach ($Resultado01 AS $fila) {
                $Name = $fila['mtflname'];
                $Unit = $fila['mtflunit']; //asqui
            }
            $NameMeteorologicalFields = "$meteorologicalfields_id - $Name - ($Unit)";
            $letter = NextLetter($letter);
            $objPHPExcel->getActiveSheet()->setCellValue($letter . $i, $NameMeteorologicalFields);
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($letter . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $Arr_meteorologicalfields_letter[$meteorologicalfields_id] = $letter;
        }

        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':' . $letter . $i)->getFont()->setBold(true);

        //AQUI VA EL CODIGO DE GENERACION DE LA INFORMACION
        $QUERY02 = "SELECT WD.wtdtdate,WD.id_meteorologicalfields,WD.wtdtvalue ";
        $QUERY02 .= "FROM tb_weatherdata WD ";
        $QUERY02 .= "WHERE WD.id_weatherstation = $id_weatherstation ";
        $QUERY02 .= "AND WD.wtdtdate BETWEEN '$startdate' AND '$enddate' ";
        $QUERY02 .= "ORDER BY WD.wtdtdate ASC";

        $st = $connection->execute($QUERY02);
        $Resultado02 = $st->fetchAll();
        $Arr_meteorologicalfields_id = null;
        $Date = null;
        foreach ($Resultado02 AS $fila02) {
            if ($fila02['wtdtdate'] != $Date)
                $i++;
            $id_meteorologicalfields = $fila02['id_meteorologicalfields'];
            $Value = $fila02['wtdtvalue'];
            if ($fila02['wtdtdate'] == $Date) {
                $letter = $Arr_meteorologicalfields_letter[$id_meteorologicalfields];
                $objPHPExcel->getActiveSheet()->setCellValue($letter . $i, $Value);
            } else {
                $Date = $fila02['wtdtdate'];
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $Date);
                $letter = $Arr_meteorologicalfields_letter[$id_meteorologicalfields];
                $objPHPExcel->getActiveSheet()->setCellValue($letter . $i, $Value);
            }
        }

        //ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Meteorology.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}

function SaveMeteorologicalFieldsData($UrlTemplate) {
    set_time_limit(1200);
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = PHPExcel_IOFactory::load($UrlTemplate);
    $connection = Doctrine_Manager::getInstance()->connection();
    foreach ($objPHPExcel->getWorksheetIterator(1) as $worksheet) {
        $worksheetTitle = $worksheet->getTitle();
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $error_filas = "";
        $grabados = 0;
        $errores = 0;
        $banderaerror = false;
        $trial = 1;

        //AQUI CAPTURAMOS LAS VARIABLES MEDIDAS
        $Arr_meteorologicalfields_id = null;
        for ($col = 2; $col < $highestColumnIndex; $col++) {
            $cell = $worksheet->getCellByColumnAndRow($col, 1);
            $value = explode("-", trim($cell->getValue()));
            $Arr_meteorologicalfields_id[$col] = $value[0];
        }

        //AQUI CUNSULTAMOS LAS FILAS QUE CONTIENE LAS REPLICACION-VARIEDAD-VALOR VARIABLE MEDIDA
        for ($row = 2; $row <= $highestRow; ++$row) {
            $id_weatherstation = "";
            $wtdtdate = "";
            $id_meteorologicalfields = "";
            $wtdtvalue = "";
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                if ($col == 0) {
                    $value = explode("-", trim($cell->getValue()));
                    $id_weatherstation = $value[0];
                } else if ($col == 1) {
                    if (!intval($cell->getValue()))
                        $wtdtdate = $cell->getValue();
                    else
                        $wtdtdate = date("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
                } else {
                    $id_meteorologicalfields = $Arr_meteorologicalfields_id[$col];
                    $wtdtvalue = trim($cell->getValue());
                }

                if (($id_weatherstation != '') && ($wtdtdate != '') && ($id_meteorologicalfields != '') && ($wtdtvalue != '')) {
                    flush();
                    ob_flush();
                    TbWeatherdataTable::addWeatherdata($id_weatherstation, $wtdtdate, $id_meteorologicalfields, $wtdtvalue);
                }
            }
        }
        break;
    }
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
