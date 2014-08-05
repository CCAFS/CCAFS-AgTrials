<?php

require_once dirname(__FILE__) . '/../lib/tbvarietyGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbvarietyGeneratorHelper.class.php';
require_once '../lib/funtions/funtion.php';
require_once '../lib/funtions/html.php';
require_once '../lib/excel/Classes/PHPExcel.php';
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/excel/reader.php';

/**
 * tbvariety actions.
 *
 * @package    trialsites
 * @subpackage tbvariety
 * @author     AgTrials. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbvarietyActions extends autoTbvarietyActions {

    public function executeFilter(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $this->setPage(1);
        if ($request->hasParameter('_reset')) {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('wherelist');
            $this->setFilters($this->configuration->getFilterDefaults());
            $this->redirect('@tbvariety');
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
                        $wherelist .= "AND V.$Key = $Filters ";
                    } else {
                        $wherelist .= "AND UPPER(V.$Key) LIKE '%" . strtoupper($Filters['text']) . "%' ";
                    }
                }
            }
            $wherelist = substr($wherelist, 0, strlen($wherelist) - 1);
            $user->setAttribute('wherelist', $wherelist);
            $this->redirect('@tbvariety');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeNew(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();

        $this->form = $this->configuration->getForm();
        $this->tbvariety = $this->form->getObject();
        $this->form = new tbvarietyForm(null, array('url' => 'tbvariety/'));
    }

    public function executeCreate(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();

        $this->form = $this->configuration->getForm();
        $this->tbvariety = $this->form->getObject();
        $this->form = new tbvarietyForm(null, array('url' => 'tbvariety/tbvariety/'));
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

    public function executeAutoorigin($request) {
        $this->getResponse()->setContentType('application/json');
        $Origin = Doctrine::getTable('TbOrigin')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Origin));
    }

    public function executeGetid($request) {
        
    }

    public function executeFilterpop($request) {
        $id_crop = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_crop');

        $user = sfContext::getInstance()->getUser();

        $id_crop_act = $user->getAttribute('id_crop');
        if ($id_crop != $id_crop_act) {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variety');
        }
        $user->setAttribute('id_crop', $id_crop);
        $this->redirect('@filter_variety');
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
        $session_vari = $user->getAttribute('variety');
        $user->setAttribute('variety', null);
        $this->redirect('@filter_variety');
    }

    public function executeSaveClose($request) {
        $user = sfContext::getInstance()->getUser();
        $session_vari = $user->getAttribute('variety');
        $list_variety = "";
        for ($cont = 0; $cont < count($session_vari); $cont++) {
            $Variety = Doctrine::getTable('TbVariety')->findOneByIdVariety($session_vari[$cont]);
            $list_variety .= $Variety->getVrtname() . ", ";
        }
        $list_variety = substr($list_variety, 0, strlen($list_variety) - 2);
        $this->name = $list_variety;
    }

    public function executeBatchuploadvariety(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Variety";
        $Cols = 4;
        $MaxRecordsFile = 50000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB

        $connection = Doctrine_Manager::getInstance()->connection();
        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadsvariety = $UploadDir . "/filevariety";
        if (!is_dir($uploadsvariety)) {
            mkdir($uploadsvariety, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filevariety');
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

            move_uploaded_file($FileTmpName, "$uploadsvariety/$FileName");
            $inputFileName = "$uploadsvariety/$FileName";

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
                $id_origin = trim($ExcelFile->sheets[0]['cells'][$row][2]);
                $vrtname = trim($ExcelFile->sheets[0]['cells'][$row][3]);
                $vrtsynonymous = trim($ExcelFile->sheets[0]['cells'][$row][4]);

                if ($id_origin == '')
                    $id_origin = null;

                $Fields = '{"' . $id_crop . '","' . $id_origin . '","' . $vrtname . '","' . $vrtsynonymous . '"}';
                $Fields = str_replace("'", "''", $Fields);
                $Fields = preg_replace("~(\\\\)+~", "*quot*", $Fields);
                $Fields = utf8_encode($Fields);
                $QUERY = "SELECT fc_checkfieldsbatchvariety('$Fields'::text[]) AS info;";
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
                    $vrtname = utf8_encode($vrtname);
                    $vrtsynonymous = utf8_encode($vrtsynonymous);
                    TbVarietyTable::addVariety($id_crop, $id_origin, $vrtname, $vrtsynonymous, $id_user);
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

    public function executeDownloadestruturevariety(sfWebRequest $request) {
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("File Structure Variety")
                ->setSubject("File Structure Variety")
                ->setDescription("File Structure Variety")
                ->setKeywords("File Structure Variety")
                ->setCategory("File Structure Variety");

// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Technology')
                ->setCellValue('B1', 'Id Origin')
                ->setCellValue('C1', 'Name')
                ->setCellValue('D1', 'Synonymous ');

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
//APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
//RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Batch Upload Information');

//inicio: GENERAMOS EL LIBRO DE CROP
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Technology');
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
//inicio: GENERAMOS EL LIBRO DE ORIGIN
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet(2)->setTitle('Origin');
        $QUERY02 = Doctrine_Query::create()
                ->select("O.id_origin, O.orgname")
                ->addSelect("CN.cntname AS country")
                ->addSelect("I.insname AS institution")
                ->from("TbOrigin O")
                ->innerJoin("O.TbCountry CN")
                ->leftJoin("O.TbInstitution I")
                ->orderBy('CN.cntname, I.insname, O.orgname');
        $Resultado02 = $QUERY02->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Country');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Institution');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Name');
        foreach ($Resultado02 AS $fila) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $fila->id_origin);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $fila->country);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $fila->institution);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $fila->orgname);
            $i++;
        }

//APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
//fin: GENERAMOS EL LIBRO DE ORIGIN
//ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="VarietyTemplate.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeCheckvariety(sfWebRequest $request) {
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
            $QUERY01 = "SELECT V.vrtname,V.id_genebank,V.id_variety FROM tb_variety V WHERE V.id_crop = $id_crop AND UPPER(V.vrtname) LIKE '$Letter%' ORDER BY V.vrtname";
            $st = $connection->execute($QUERY01);
            $Record = $st->fetchAll();
            $total = count($Record);
            $ListIdVariety = "";
            if ($total > 0) {
                $corte = round($total / 2);
                $flag = 1;
                $HTML = "<b>$total Results by '$Letter'</b> <br>";
                $HTML .= "<div id='Div1'>";
                foreach ($Record AS $Value) {
                    $vrtname = $Value['vrtname'];
                    $id_genebank = $Value['id_genebank'];
                    $id_variety = $Value['id_variety'];
                    $view = "";
                    if ($id_genebank != "")
                        $view = "-> <a href='#' title='View $vrtname' onclick=\"window.open('http://seeds.iriscouch.com/#/accessions/$id_genebank','Genebank','height=800,width=900,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> View</a>";

                    if ($flag <= $corte) {
                        $HTML .= "<span>$id_variety -> $vrtname $view</span> <br>";
                    } else {
                        if ($flag == $corte + 1)
                            $HTML .= "</div><div id='Div2'><span>$id_variety -> $vrtname $view</span> <br>";
                        else
                            $HTML .= "<span>$id_variety -> $vrtname $view</span> <br>";
                    }
                    $ListIdVariety .= $id_variety . ",";
                    $flag++;
                }
                $HTML .= "</div>";
            }else {
                $HTML = "<b>No results by '$Letter'</b>";
            }
        }
        die($HTML);
    }

    public function executeValidatevarieties(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $id_crop = $user->getAttribute('id_crop');
        $listvarieties = $request->getParameter('listvarieties');
        $Arr_varieties = explode(",", $listvarieties);
        $ListVarieties = "";
        $ListVarietiesError = "";
        $ListIdVariety = "";
        $HTML = "";
        if ($id_crop == "") {
            $HTML = "Please Select Technology!";
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            foreach ($Arr_varieties AS $variety) {
                $variety = mb_strtoupper(trim($variety), "UTF-8");
                $QUERY02 = "SELECT V.vrtname,V.id_genebank,V.id_variety FROM tb_variety V WHERE V.id_crop = $id_crop AND UPPER(REPLACE(V.vrtname,' ','')) LIKE '%'||UPPER(REPLACE('$variety',' ',''))||'%' ORDER BY V.vrtname";
                $st = $connection->execute($QUERY02);
                $Record = $st->fetchAll();
                $total = count($Record);
                if ($total > 0) {
                    foreach ($Record AS $Value) {
                        $Arr_Result[] = array($Value['vrtname'], $Value['id_genebank'], $Value['id_variety']);
                        $ListIdVariety .= $Value['id_variety'] . ",";
                    }
                } else {
                    $ListVarietiesError .= ucfirst(strtolower($variety)) . ", ";
                }
            }

            $ListVarietiesError = substr($ListVarietiesError, 0, strlen($ListVarietiesError) - 2);
            $ListVarietiesError = "<b>Varieties not found</b><br>" . $ListVarietiesError;

            $total = count($Arr_Result);
            if ($total > 0) {
                $corte = round($total / 2);
                $flag = 1;
                $HTML = "<b>$total Results found</b> <br>";
                $HTML .= "<div id='Div1'>";
                foreach ($Arr_Result AS $Value) {
                    $vrtname = $Value[0];
                    $id_genebank = $Value[1];
                    $id_variety = $Value[2];
                    $view = "";
                    if ($id_genebank != "")
                        $view = "-> <a href='#' title='View $vrtname' onclick=\"window.open('http://seeds.iriscouch.com/#/accessions/$id_genebank','Genebank','height=800,width=900,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> View</a>";

                    if ($flag <= $corte) {
                        $HTML .= "<span>$id_variety -> $vrtname $view</span> <br>";
                    } else {
                        if ($flag == $corte + 1)
                            $HTML .= "</div><div id='Div2'><span>$id_variety -> $vrtname $view</span> <br>";
                        else
                            $HTML .= "<span>$id_variety -> $vrtname $view</span> <br>";
                    }
                    $flag++;
                }
                $HTML .= "</div>";
            }else {
                $HTML = "<b>No results for '$listvarieties'</b>";
            }
        }
        if ($ListIdVariety != '')
            $ListIdVariety = substr($ListIdVariety, 0, strlen($ListIdVariety) - 1);

        $ARRAY_HTML['info'] = $HTML;
        $ARRAY_HTML['error'] = $ListVarietiesError;
        $ARRAY_HTML['codes'] = $ListIdVariety;
        $JSON_Data = json_encode($ARRAY_HTML);
        die($JSON_Data);
    }

    public function executeViewVarieties($request) {
        $this->setLayout(false);
        $id_varieties = $request->getParameter("id");
        $QUERY00 = Doctrine_Query::create()
                ->select("T1.*,T2.orgname AS orgname")
                ->from("TbVariety T1")
                ->leftJoin("T1.TbOrigin T2")
                ->where("T1.id_variety = $id_varieties");
        $TbVariety = $QUERY00->execute();
        $this->Variety = $TbVariety;
    }

    public function executeCheckvarietybatch(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Variety";
        $Cols = 1;
        $MaxRecordsFile = 50000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB
        $GenerateFile = false;

        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadsvariety = $UploadDir . "/tmp$id_user";
        if (!is_dir($uploadsvariety)) {
            mkdir($uploadsvariety, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filevariety');
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
                ->setTitle("Result File Check Variety")
                ->setSubject("Result File Check Variety")
                ->setDescription("Result File Check Variety")
                ->setKeywords("Result File Check Variety")
                ->setCategory("Result File Check Variety");
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

            move_uploaded_file($FileTmpName, "$uploadsvariety/$FileName");
            $inputFileName = "$uploadsvariety/$FileName";

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
                $vrtname = trim($ExcelFile->sheets[0]['cells'][$row][1]);

                //AQUI REALIZAMOS LA VALIDACION Y/O BUSQUEDA DE POSIBLES VALORES
                if ($vrtname != '') {
                    $QUERY00 = "SELECT id_variety,vrtname FROM tb_variety WHERE id_crop = $id_crop AND UPPER(REPLACE(vrtname,' ','')) = UPPER(REPLACE('$vrtname',' ',''))";
                    $ResultQUERY00 = $connection->execute($QUERY00);
                    $DataResult00 = $ResultQUERY00->fetchAll();
                    if (count($DataResult00) > 0) {
                        foreach ($DataResult00 AS $Value) {
                            $id_variety = $Value[0];
                            $vrtname = $Value[1];
                        }
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue("A$i", $id_variety)
                                ->setCellValue("B$i", $vrtname);
                        $i++;
                    } else {
                        $QUERY01 = "SELECT vrtname FROM tb_variety WHERE id_crop = $id_crop AND UPPER(REPLACE(vrtname,' ','')) LIKE '%'||UPPER(REPLACE('$vrtname',' ',''))||'%'";
                        $ResultQUERY01 = $connection->execute($QUERY01);
                        $DataResult01 = $ResultQUERY01->fetchAll();
                        $ListPosibles = "";
                        if (count($DataResult01) > 0) {
                            foreach ($DataResult01 AS $Value) {
                                $ListPosibles .= $Value[0] . ", ";
                            }
                            $ListPosibles = substr($ListPosibles, 0, strlen($ListPosibles) - 2);
                            $objPHPExcel->setActiveSheetIndex(1)
                                    ->setCellValue("A$a", $vrtname)
                                    ->setCellValue("B$a", $ListPosibles);
                            $a++;
                        } else {
                            $objPHPExcel->setActiveSheetIndex(2)
                                    ->setCellValue("A$x", $vrtname);
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
            $objWriter->save("$uploadsvariety/$ResultFileData");
            die();
        }
        $this->MaxRecordsFile = $MaxRecordsFile;
        $this->MaxSizeFile = $MaxSizeFile;
        $this->Cols = $Cols;
    }

    public function executeDownloadcheckvarietytemplate(sfWebRequest $request) {
        $UploadDir = sfConfig::get("sf_upload_dir");
        $PathFileTemplate = $UploadDir . "/CheckVarietyTemplate.xls";
        if (file_exists($PathFileTemplate)) {
            header('Content-Disposition: attachment; filename="CheckVarietyTemplate.xls"');
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($PathFileTemplate));
            readfile($PathFileTemplate);
        }
        die();
    }

    public function executeResultfilecheckvariety(sfWebRequest $request) {
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

    public function executeDownloadlistvariety(sfWebRequest $request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(90000000000000);
        $user = sfContext::getInstance()->getUser();
        $wherelist = $user->getAttribute('wherelist');
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("AgTrials")
                ->setLastModifiedBy("AgTrials")
                ->setTitle("Variety/Race List")
                ->setSubject("VarietyRace List")
                ->setDescription("VarietyRace List")
                ->setKeywords("VarietyRace List")
                ->setCategory("VarietyRace List");

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Variety/Race')
                ->setCellValue('B1', 'Technology')
                ->setCellValue('C1', 'Origin')
                ->setCellValue('D1', 'Name')
                ->setCellValue('E1', 'Synonym')
                ->setCellValue('F1', 'Description');

        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $objPHPExcel->getActiveSheet(0)->setTitle('VarietyRace');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT V.id_variety, C.crpname, O.orgname, V.vrtname, V.vrtsynonymous, V.vrtdescription ";
        $QUERY00 .= "FROM tb_variety V ";
        $QUERY00 .= "INNER JOIN tb_crop C ON V.id_crop = C.id_crop  ";
        $QUERY00 .= "LEFT JOIN tb_origin O ON V.id_origin = O.id_origin ";
        $QUERY00 .= "WHERE true $wherelist ";
        $QUERY00 .= "ORDER BY C.crpname, V.vrtname ";
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
            $i++;
        }


        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="VarietyRaceList.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
