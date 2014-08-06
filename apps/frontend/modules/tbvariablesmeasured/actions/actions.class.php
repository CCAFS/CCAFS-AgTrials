<?php

require_once dirname(__FILE__) . '/../lib/tbvariablesmeasuredGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbvariablesmeasuredGeneratorHelper.class.php';
require_once '../lib/funtions/funtion.php';
require_once '../lib/funtions/html.php';
require_once '../lib/excel/Classes/PHPExcel.php';
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/excel/reader.php';

/**
 * tbvariablesmeasured actions.
 *
 * @package    trialsites
 * @subpackage tbvariablesmeasured
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbvariablesmeasuredActions extends autoTbvariablesmeasuredActions {

    public function executeFilter(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $this->setPage(1);
        if ($request->hasParameter('_reset')) {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('wherelistvariablesmeasured');
            $this->setFilters($this->configuration->getFilterDefaults());
            $this->redirect('@tbvariablesmeasured');
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
                        $wherelist .= "AND VM.$Key = $Filters ";
                    } else {
                        $wherelist .= "AND UPPER(VM.$Key) LIKE '%" . strtoupper($Filters['text']) . "%' ";
                    }
                }
            }
            $wherelist = substr($wherelist, 0, strlen($wherelist) - 1);
            $user->setAttribute('wherelistvariablesmeasured', $wherelist);
            $this->redirect('@tbvariablesmeasured');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeNew(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();

        $this->form = $this->configuration->getForm();
        $this->tbvariablesmeasured = $this->form->getObject();
        $this->form = new tbvariablesmeasuredForm(null, array('url' => 'tbvariablesmeasured/'));
    }

    public function executeCreate(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();

        $this->form = $this->configuration->getForm();
        $this->tbvariablesmeasured = $this->form->getObject();
        $this->form = new tbvariablesmeasuredForm(null, array('url' => 'tbvariablesmeasured/tbvariablesmeasured/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeAutocrop($request) {
        $this->getResponse()->setContentType('application/json');
        $Crop = Doctrine::getTable('TbCrop')->retrieveForSelect(
                        $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Crop));
    }

    public function executeGetidcrop($request) {
        
    }

    public function executeFilterpop($request) {
        $id_crop = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_crop');

        $user = sfContext::getInstance()->getUser();

        $id_crop_act = $user->getAttribute('id_crop');
        if ($id_crop != $id_crop_act) {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured');
        }
        $user->setAttribute('id_crop', $id_crop);
        $this->redirect('@filter_variablesmeasured');
    }

    protected function buildQuery() {
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        if (!empty($id_crop)) {
            return parent::buildQuery()->andWhere('id_crop = ?', $id_crop);
        } else {
            return parent::buildQuery();
        }
    }

    public function executeListClear($request) {
        $user = sfContext::getInstance()->getUser();
        $session_variablesmeasured = $user->getAttribute('variablesmeasured');
        $user->setAttribute('variablesmeasured', null);
        $this->redirect('@filter_variablesmeasured');
    }

    public function executeSaveClose($request) {
        $user = sfContext::getInstance()->getUser();
        $session_variablesmeasured = $user->getAttribute('variablesmeasured');
        $list_variablesmeasured = "";
        for ($cont = 0; $cont < count($session_variablesmeasured); $cont++) {
            $Variablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($session_variablesmeasured[$cont]);
            $list_variablesmeasured .= $Variablesmeasured->getVrmsname() . ", ";
        }
        $list_variablesmeasured = substr($list_variablesmeasured, 0, strlen($list_variablesmeasured) - 2);
        $this->name = $list_variablesmeasured;
    }

    public function executeBatchuploadvariablesmeasured(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Variables Measured";
        $Cols = 6;
        $MaxRecordsFile = 50000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB

        $connection = Doctrine_Manager::getInstance()->connection();
        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadsvariablesmeasured = $UploadDir . "/filevariablesmeasured";
        if (!is_dir($uploadsvariablesmeasured)) {
            mkdir($uploadsvariablesmeasured, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filevariablesmeasured');
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

            move_uploaded_file($FileTmpName, "$uploadsvariablesmeasured/$FileName");
            $inputFileName = "$uploadsvariablesmeasured/$FileName";

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
                $id_crop = trim($ExcelFile->sheets[0]['cells'][$row][1]);
                $id_traitclass = trim($ExcelFile->sheets[0]['cells'][$row][2]);
                $vrmsname = trim($ExcelFile->sheets[0]['cells'][$row][3]);
                $vrmsshortname = trim($ExcelFile->sheets[0]['cells'][$row][4]);
                $vrmsdefinition = trim($ExcelFile->sheets[0]['cells'][$row][5]);
                $vrmsunit = trim($ExcelFile->sheets[0]['cells'][$row][6]);

                $Fields = '{"' . $id_crop . '","' . $id_traitclass . '","' . $vrmsname . '","' . $vrmsshortname . '","' . $vrmsdefinition . '","' . $vrmsunit . '"}';
                $Fields = str_replace("'", "''", $Fields);
                $Fields = preg_replace("~(\\\\)+~", "*quot*", $Fields);
                $Fields = utf8_encode($Fields);
                $QUERY = "SELECT fc_checkfieldsbatchvariablesmeasured('$Fields'::text[]) AS info;";
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
                    $vrmsname = utf8_encode($vrmsname);
                    $vrmsshortname = utf8_encode($vrmsshortname);
                    $vrmsdefinition = utf8_encode($vrmsdefinition);
                    $vrmsunit = utf8_encode($vrmsunit);
                    TbVariablesmeasuredTable::addVariablesmeasured($id_crop, $id_traitclass, $vrmsname, $vrmsshortname, $vrmsdefinition, $vrmsunit, $id_user);
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

    public function executeDownloadestruturevariablesmeasured(sfWebRequest $request) {
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Herlin R. Espinosa G")
                ->setLastModifiedBy("Herlin R. Espinosa G")
                ->setTitle("File Structure Variables Measured")
                ->setSubject("File Structure Variables Measured")
                ->setDescription("File Structure Variables Measuredy")
                ->setKeywords("File Structure Variables Measured")
                ->setCategory("File Structure Variables Measured");

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Crop')
                ->setCellValue('B1', 'Id Trait Class')
                ->setCellValue('C1', 'Name')
                ->setCellValue('D1', 'Short Name')
                ->setCellValue('E1', 'Definition')
                ->setCellValue('F1', 'Unit ');

        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        //APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        //RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Batch Upload Information');

        //inicio: GENERAMOS EL LIBRO DE CROP
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Crop');
        $QUERY01 = Doctrine_Query::create()
                        ->select("C.id_crop AS id, C.crpname AS name, C.crpscientificname AS scientificname")
                        ->from("TbCrop C")
                        ->orderBy("C.crpname");
        $Resultado01 = $QUERY01->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Scientific Name');
        foreach ($Resultado01 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila['scientificname']);
            $i++;
        }
        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        //fin: GENERAMOS EL LIBRO DE CROP
        //inicio: GENERAMOS EL LIBRO DE TRAIT CLASS
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet(2)->setTitle('Trait Class');
        $QUERY02 = Doctrine_Query::create()
                        ->select("TC.id_traitclass, TC.trclname")
                        ->from("TbTraitclass TC")
                        ->orderBy("TC.trclname");
        $Resultado02 = $QUERY02->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
        foreach ($Resultado02 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id_traitclass);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->trclname);
            $i++;
        }

        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        //fin: GENERAMOS EL LIBRO DE TRAIT CLASS
        //ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="VariablesMeasuredTemplate.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeCheckvariablesmeasured(sfWebRequest $request) {
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('id_crop');
    }

    public function executeSelectletter(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $Letter = $request->getParameter('letter');
        $HTML = "";
        if ($id_crop == "") {
            $HTML = "Please Select Technology!";
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY01 = "SELECT V.vrmsname,V.id_ontology,V.id_variablesmeasured FROM tb_variablesmeasured V WHERE V.id_crop = $id_crop AND UPPER(V.vrmsname) LIKE '$Letter%' ORDER BY V.vrmsname";
            $st = $connection->execute($QUERY01);
            $Record = $st->fetchAll();
            $total = count($Record);
            if ($total > 0) {
                $corte = round($total / 2);
                $flag = 1;
                $HTML = "<b>$total Results by '$Letter'</b> <br>";
                $HTML .= "<div id='Div1'>";
                foreach ($Record AS $Value) {
                    $vrmsname = $Value['vrmsname'];
                    $id_ontology = $Value['id_ontology'];
                    $id_variablesmeasured = $Value['id_variablesmeasured'];
                    $view = "";
                    if ($id_ontology != "")
                        $view = "-> <a href='#' title='View $vrmsname' onclick=\"window.open('http://www.cropontology-curationtool.org/terms/$id_ontology/Stem%20rust/static-html','cropontology-curationtool','height=800,width=900,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> View</a>";

                    if ($flag <= $corte) {
                        $HTML .= "<span>$id_variablesmeasured -> $vrmsname $view</span> <br>";
                    } else {
                        if ($flag == $corte + 1)
                            $HTML .= "</div><div id='Div2'><span>$id_variablesmeasured -> $vrmsname $view</span> <br>";
                        else
                            $HTML .= "<span>$id_variablesmeasured -> $vrmsname $view</span> <br>";
                    }
                    $flag++;
                }
                $HTML .= "</div>";
            }else {
                $HTML = "<b>No results by '$Letter'</b>";
            }
        }
        die($HTML);
    }

    public function executeValidatevariablesmeasured(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $listvariablesmeasureds = $request->getParameter('ListVariablesmeasureds');
        $Arr_variablesmeasureds = explode(",", $listvariablesmeasureds);
        $ListVariablesmeasureds = "";
        $ListVariablesmeasuredsError = "";
        $ListIdVariablesmeasureds = "";
        $HTML = "";
        if ($id_crop == "") {
            $HTML = "Please Select Technology!";
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            foreach ($Arr_variablesmeasureds AS $variablesmeasured) {
                $variablesmeasured = mb_strtoupper(trim($variablesmeasured), "UTF-8");
                $QUERY02 = "SELECT V.vrmsname,V.id_ontology,V.id_variablesmeasured FROM tb_variablesmeasured V WHERE V.id_crop = $id_crop AND UPPER(REPLACE(V.vrmsname,' ','')) LIKE '%'||UPPER(REPLACE('$variablesmeasured',' ',''))||'%' ORDER BY V.vrmsname";
                $st = $connection->execute($QUERY02);
                $Record = $st->fetchAll();
                $total = count($Record);
                if ($total > 0) {
                    foreach ($Record AS $Value) {
                        $Arr_Result[] = array($Value['vrmsname'], $Value['id_ontology'], $Value['id_variablesmeasured']);
                        $ListIdVariablesmeasureds .= $Value['id_variablesmeasured'] . ",";
                    }
                } else {
                    $ListVariablesmeasuredsError .= ucfirst(mb_strtolower($variablesmeasured, "UTF-8")) . ", ";
                }
            }

            $ListVariablesmeasuredsError = substr($ListVariablesmeasuredsError, 0, strlen($ListVariablesmeasuredsError) - 2);
            $ListVariablesmeasuredsError = "<b>Variables measureds not found</b><br>" . $ListVariablesmeasuredsError;

            $total = count($Arr_Result);
            if ($total > 0) {
                $corte = round($total / 2);
                $flag = 1;
                $HTML = "<b>$total Results found</b> <br>";
                $HTML .= "<div id='Div1'>";
                foreach ($Arr_Result AS $Value) {
                    $vrmsname = $Value[0];
                    $id_ontology = $Value[1];
                    $id_variablesmeasured = $Value[2];
                    $view = "";
                    if ($id_ontology != "")
                        $view = "-> <a href='#' title='View $vrmsname' onclick=\"window.open('http://www.cropontology-curationtool.org/terms/$id_ontology/Stem%20rust/static-html','cropontology-curationtool','height=800,width=900,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> View</a>";

                    if ($flag <= $corte) {
                        $HTML .= "<span>$id_variablesmeasured -> $vrmsname $view</span> <br>";
                    } else {
                        if ($flag == $corte + 1)
                            $HTML .= "</div><div id='Div2'><span>$id_variablesmeasured -> $vrmsname $view</span> <br>";
                        else
                            $HTML .= "<span>$id_variablesmeasured -> $vrmsname $view</span> <br>";
                    }
                    $flag++;
                }
                $HTML .= "</div>";
            }else {
                $HTML = "<b>No results for '$listvariablesmeasureds'</b>";
            }
        }
        if ($ListIdVariablesmeasureds != '')
            $ListIdVariablesmeasureds = substr($ListIdVariablesmeasureds, 0, strlen($ListIdVariablesmeasureds) - 1);

        $ARRAY_HTML['info'] = $HTML;
        $ARRAY_HTML['error'] = utf8_encode($ListVariablesmeasuredsError);
        $ARRAY_HTML['codes'] = $ListIdVariablesmeasureds;
        $JSON_Data = json_encode($ARRAY_HTML);
        die($JSON_Data);
    }

    public function executeViewVariablesMeasured($request) {
        $this->setLayout(false);
        $id_variablesmeasured = $request->getParameter("id");
        $QUERY00 = Doctrine_Query::create()
                        ->select("T1.*,T2.trclname AS trclname")
                        ->from("TbVariablesmeasured T1")
                        ->innerJoin("T1.TbTraitclass T2")
                        ->where("T1.id_variablesmeasured = $id_variablesmeasured");
        $TbVariablesmeasured = $QUERY00->execute();
        $this->Variablesmeasured = $TbVariablesmeasured;
    }

    public function executeDownloadlistvariablesmeasured(sfWebRequest $request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(90000000000000);
        $user = sfContext::getInstance()->getUser();
        $wherelist = $user->getAttribute('wherelistvariablesmeasured');
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("VariablesMeasured List")
                ->setSubject("VariablesMeasured List")
                ->setDescription("VariablesMeasured List")
                ->setKeywords("VariablesMeasured List")
                ->setCategory("VariablesMeasured List");

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Variables Measured')
                ->setCellValue('B1', 'Technology')
                ->setCellValue('C1', 'Trait Class ')
                ->setCellValue('D1', 'Name')
                ->setCellValue('E1', 'Short name')
                ->setCellValue('F1', 'Definition')
                ->setCellValue('G1', 'Method')
                ->setCellValue('H1', 'Unit');

        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        $objPHPExcel->getActiveSheet(0)->setTitle('VariablesMeasured');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT VM.id_variablesmeasured, C.crpname, TC.trclname, VM.vrmsname, VM.vrmsshortname, VM.vrmsdefinition, VM.vrmnmethod, VM.vrmsunit ";
        $QUERY00 .= "FROM tb_variablesmeasured VM ";
        $QUERY00 .= "INNER JOIN tb_crop C ON VM.id_crop = C.id_crop  ";
        $QUERY00 .= "INNER JOIN tb_traitclass TC ON VM.id_traitclass = TC.id_traitclass  ";
        $QUERY00 .= "WHERE true $wherelist ";
        $QUERY00 .= "ORDER BY C.crpname, TC.trclname, VM.vrmsname ";
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
            $i++;
        }


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="VariablesMeasuredList.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeCheckvariablesmeasuredbatch(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Variables Measured";
        $Cols = 1;
        $MaxRecordsFile = 50000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB
        $GenerateFile = false;

        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadsvariablesmeasured = $UploadDir . "/tmp$id_user";
        if (!is_dir($uploadsvariablesmeasured)) {
            mkdir($uploadsvariablesmeasured, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filevariablesmeasured');
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
                ->setTitle("Result File Check Variables Measured")
                ->setSubject("Result File Check Variables Measured")
                ->setDescription("Result File Check Variables Measured")
                ->setKeywords("Result File Check Variables Measured")
                ->setCategory("Result File Check Variables Measured");
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
            $id_crop = $request->getParameter('id_crop');
            $connection = Doctrine_Manager::getInstance()->connection();
            $extension = explode(".", $FileName);
            $FileExt = strtoupper($extension[1]);
            if ((!($FileExt == "XLS")) || ($FileSizeMB < 0) || ($FileSizeMB > 5) || ($DataFileSizeMB > 5)) {
                $Forma = "FileErrorCheckTemplates";
                die(include("../lib/html/HTML.php"));
            }

            move_uploaded_file($FileTmpName, "$uploadsvariablesmeasured/$FileName");
            $inputFileName = "$uploadsvariablesmeasured/$FileName";

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
                $vrmsname = trim($ExcelFile->sheets[0]['cells'][$row][1]);

                //AQUI REALIZAMOS LA VALIDACION Y/O BUSQUEDA DE POSIBLES VALORES
                if ($vrmsname != '') {
                    $QUERY00 = "SELECT id_variablesmeasured,vrmsname FROM tb_variablesmeasured WHERE id_crop = $id_crop AND UPPER(REPLACE(vrmsname,' ','')) = UPPER(REPLACE('$vrmsname',' ',''))";
                    $ResultQUERY00 = $connection->execute($QUERY00);
                    $DataResult00 = $ResultQUERY00->fetchAll();
                    if (count($DataResult00) > 0) {
                        foreach ($DataResult00 AS $Value) {
                            $id_variablesmeasured = $Value[0];
                            $vrmsname = $Value[1];
                        }
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue("A$i", $id_variablesmeasured)
                                ->setCellValue("B$i", $vrmsname);
                        $i++;
                    } else {
                        $QUERY01 = "SELECT vrmsname FROM tb_variablesmeasured WHERE id_crop = $id_crop AND UPPER(REPLACE(vrmsname,' ','')) LIKE '%'||UPPER(REPLACE('$vrmsname',' ',''))||'%'";
                        $ResultQUERY01 = $connection->execute($QUERY01);
                        $DataResult01 = $ResultQUERY01->fetchAll();
                        $ListPosibles = "";
                        if (count($DataResult01) > 0) {
                            foreach ($DataResult01 AS $Value) {
                                $ListPosibles .= $Value[0] . ", ";
                            }
                            $ListPosibles = substr($ListPosibles, 0, strlen($ListPosibles) - 2);
                            $objPHPExcel->setActiveSheetIndex(1)
                                    ->setCellValue("A$a", $vrmsname)
                                    ->setCellValue("B$a", $ListPosibles);
                            $a++;
                        } else {
                            $objPHPExcel->setActiveSheetIndex(2)
                                    ->setCellValue("A$x", $vrmsname);
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
            $objWriter->save("$uploadsvariablesmeasured/$ResultFileData");
            die();
        }
        $this->MaxRecordsFile = $MaxRecordsFile;
        $this->MaxSizeFile = $MaxSizeFile;
        $this->Cols = $Cols;
    }

    public function executeDownloadcheckvariablesmeasuredtemplate(sfWebRequest $request) {
        $UploadDir = sfConfig::get("sf_upload_dir");
        $PathFileTemplate = $UploadDir . "/CheckVariablesMeasuredTemplate.xls";
        if (file_exists($PathFileTemplate)) {
            header('Content-Disposition: attachment; filename="CheckVariablesMeasuredTemplate.xls"');
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($PathFileTemplate));
            readfile($PathFileTemplate);
        }
        die();
    }

    public function executeResultfilecheckvariablesmeasured(sfWebRequest $request) {
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
