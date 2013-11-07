<?php

require_once dirname(__FILE__) . '/../lib/tblocationGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tblocationGeneratorHelper.class.php';
require_once '../lib/funtions/funtion.php';
require_once '../lib/funtions/html.php';
require_once '../lib/excel/Classes/PHPExcel.php';
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/excel/reader.php';

/**
 * tblocation actions.
 *
 * @package    trialsites
 * @subpackage tblocation
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tblocationActions extends autoTblocationActions {

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tblocation = $this->form->getObject();
        $this->form = new tblocationForm(null, array('url' => 'tblocation/'));
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tblocation = $this->form->getObject();
        $this->form = new tblocationForm(null, array('url' => 'tblocation/tblocation/'));
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

    public function executeBatchuploadlocation(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Location";
        $Cols = 2;
        $MaxRecordsFile = 50000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB

        $connection = Doctrine_Manager::getInstance()->connection();
        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadslocation = $UploadDir . "/filelocation";
        if (!is_dir($uploadslocation)) {
            mkdir($uploadslocation, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filelocation');
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

            move_uploaded_file($FileTmpName, "$uploadslocation/$FileName");
            $inputFileName = "$uploadslocation/$FileName";

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
                $id_country = trim($ExcelFile->sheets[0]['cells'][$row][1]);
                $lctname = trim($ExcelFile->sheets[0]['cells'][$row][2]);

                $Fields = '{"' . $id_country . '","' . $lctname . '"}';
                $Fields = str_replace("'", "''", $Fields);
                $Fields = utf8_encode($Fields);
                $QUERY = "SELECT fc_checkfieldsbatchlocation('$Fields'::text[]) AS info;";
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
                    $lctname = utf8_encode($lctname);
                    TblocationTable::addlocation($id_country, $lctname, $id_user);
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

    public function executeDownloadestruturelocation(sfWebRequest $request) {
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Herlin R. Espinosa G")
                ->setLastModifiedBy("Herlin R. Espinosa G")
                ->setTitle("File Structure Location")
                ->setSubject("File Structure Location")
                ->setDescription("File Structure Location")
                ->setKeywords("File Structure Location")
                ->setCategory("File Structure Location");

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Country')
                ->setCellValue('B1', 'Name');

        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        //APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        //RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Batch Upload Information');

        //inicio: GENERAMOS EL LIBRO DE COUNTRY
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Country');
        $QUERY01 = Doctrine_Query::create()
                        ->select("C.id_country AS id, C.cntname AS name")
                        ->from("TbCountry C")
                        ->orderBy("C.cntname");
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
        //fin: GENERAMOS EL LIBRO DE CROP
        //ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="LocationTemplate.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
