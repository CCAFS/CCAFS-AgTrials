<?php

require_once dirname(__FILE__) . '/../lib/tbtrialgroupGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbtrialgroupGeneratorHelper.class.php';
require_once '../lib/funtions/funtion.php';
require_once '../lib/funtions/html.php';
require_once '../lib/excel/Classes/PHPExcel.php';
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/excel/reader.php';

/**
 * tbtrialgroup actions.
 *
 * @package    trialgroups
 * @subpackage tbtrialgroup
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbtrialgroupActions extends autoTbtrialgroupActions {

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbtrialgroup = $this->form->getObject();
        $this->form = new tbtrialgroupForm(null, array('url' => 'tbtrialgroup/'));
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_name');
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbtrialgroup = $this->form->getObject();
        $this->form = new tbtrialgroupForm(null, array('url' => 'tbtrialgroup/tbtrialgroup/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();
        $id_trialgroup = $request->getParameter("id_trialgroup");
        $id_user = $this->getUser()->getGuardUser()->getId();
        $Query00 = Doctrine::getTable('TbTrialgroup')->findOneByIdTrialgroup($id_trialgroup);
        $id_user_registro = $Query00->getIdUser();
        $user = $this->getUser();
        if ($id_user == $id_user_registro || (CheckUserPermission($id_user, "1")) || (PermissionChangeTrialGroup($id_user, $id_trialgroup))) {
            $TbTrial = Doctrine::getTable('TbTrial')->findByIdTrialgroup($id_trialgroup);
            $TbBibliography = Doctrine::getTable('TbBibliography')->findByIdTrialgroup($id_trialgroup);
            $tp_mensaje = "notice";
            $mjs_mensaje = "The item was deleted successfully.";
            if ((count($TbTrial) > 0) || (count($TbBibliography) > 0)) {
                $tp_mensaje = "error";
                $mjs_mensaje = "Trial Group cannot be deleted because it is associated with a Trial or Bibliographic reference.";
                $this->getUser()->setFlash($tp_mensaje, $mjs_mensaje);
                $this->redirect("/tbtrialgroup/$id_trialgroup/edit");
            } else {
                TbTrialgroupcontactpersonTable::delTrialgroupcontactpersons($id_trialgroup);
                $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
                $this->getRoute()->getObject()->delete();
                $this->getUser()->setFlash($tp_mensaje, $mjs_mensaje);
                $this->redirect('@tbtrialgroup');
            }
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions to delete!'); window.history.back();</script>";
            Die();
        }
    }

    public function executeEdit(sfWebRequest $request) {
        $this->tbtrialgroup = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->tbtrialgroup);

        //VERIFICAMOS LOS PERMISOS DE MODIFICACION
        $id_user = $this->getUser()->getGuardUser()->getId();
        $id_trialgroup = $request->getParameter("id_trialgroup");
        $Query00 = Doctrine::getTable('TbTrialgroup')->findOneByIdTrialgroup($id_trialgroup);
        $id_user_registro = $Query00->getIdUser();
        $user = $this->getUser();
        if ($id_user == $id_user_registro || (CheckUserPermission($id_user, "1")) || (PermissionChangeTrialGroup($id_user, $id_trialgroup))) {
            //INICIO: AQUI CONSUILTAMOS LOS REGISTROS DE LA TABLA tb_trialgroupcontactperson
            $list_contactperson = "";
            $Trialgroupcontactperson = Doctrine::getTable('TbTrialgroupcontactperson')->findByIdTrialgroup($id_trialgroup);
            for ($cont = 0; $cont < count($Trialgroupcontactperson); $cont++) {
                $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($Trialgroupcontactperson[$cont]->getIdContactperson());
                $contactperson_id_saved[] = $TbContactperson->getIdContactperson();
                $contactperson_name_saved[] = $TbContactperson->getCnprfirstname() . " " . $TbContactperson->getCnprlastname();
            }
            $user->setAttribute('contactperson_id', $contactperson_id_saved);
            $user->setAttribute('contactperson_name', $contactperson_name_saved);
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions edit!'); window.history.back();</script>";
            Die();
        }
    }

    public function executeList_AddTrial(sfWebRequest $request) {
        $id_trialgroup = $request->getParameter('id_trialgroup');
        $this->redirect('tbtrial/new?id_trialgroup=' . $id_trialgroup);
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
                        $request->getParameter('q'), null, $request->getParameter('limit')
        );
        return $this->renderText(json_encode($Contactperson));
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        $form_trialgroup = $request->getParameter('tb_trialgroup');

        //INICIO: VERIFICACION DEL FORMATO DOCUMENTO
        $FileValid = true;
        $error = "";
        for ($a = 1; $a <= 10; $a++) {
            $trgrflfile = $_FILES["trgrflfile" . $a]['name'];
            if ($trgrflfile != '') {
                $extension = "";
                $part_name = explode(".", $trgrflfile);
                $extension = strtoupper($part_name[count($part_name) - 1]);
                $extensiones = array('0' => 'JPG', '1' => 'JPEG', '2' => 'TIFF', '3' => 'PNG', '4' => 'BMP', '5' => 'PDF', '6' => 'GIF', '7' => 'DOC', '8' => 'DOCX', '9' => 'XLS', '10' => 'XLSX', '11' => 'ZIP', '12' => 'RAR');
                if (!in_array($extension, $extensiones)) {
                    $FileValid = false;
                    $error = " (Format error Documents (permitted format: 'JPG,JPEG,TIFF,PNG,BMP,PDF,GIF,DOC,DOCX,XLS,XLSX,ZIP,RAR')";
                }
            }
        }
        //FIN: VERIFICACION DEL FORMATO DOCUMENTO

        if ($form->isValid() && $FileValid) {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

            $tbtrialgroup = $form->save();
            $id_trialgroup = $tbtrialgroup['id_trialgroup'];
            $user = sfContext::getInstance()->getUser();

            //INICIO: AQUI AGREGAMOS LOS REGISTROS A LA TABLA tb_trialgroupcontactperson
            $session_contactperson = $user->getAttribute('contactperson_id');
            $list_contactperson = "";
            TbTrialgroupcontactpersonTable::delTrialgroupcontactpersons($id_trialgroup);
            for ($cont = 0; $cont < count($session_contactperson); $cont++) {
                $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($session_contactperson[$cont]);
                $list_contactperson .= $TbContactperson->getCnprfirstname() . " " . $TbContactperson->getCnprlastname() . ", ";
                TbTrialgroupcontactpersonTable::addTrialgroupcontactperson($id_trialgroup, $session_contactperson[$cont]);
            }
            $list_contactperson = substr($list_contactperson, 0, strlen($list_contactperson) - 2);
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_id');
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('contactperson_name');

            //VERIFICACION DE DOCUMENTOS
            $TrialGroupFile = "TrialGroupFile_$id_trialgroup";
            $uploadDir = sfConfig::get("sf_upload_dir");
            $dir_uploads = "$uploadDir/$TrialGroupFile";
            if (!is_dir($dir_uploads))
                mkdir($dir_uploads, 0777);

            for ($i = 1; $i <= 10; $i++) {
                $trgrflfile = $_FILES["trgrflfile" . $i]['name'];
                $trgrfldescription = $request->getParameter("trgrfldescription" . $i);
                if ($trgrfldescription == '')
                    $trgrfldescription = "N/A";
                if (($trgrflfile != '')) {
                    move_uploaded_file($_FILES["trgrflfile" . $i]['tmp_name'], "$dir_uploads/$trgrflfile");
                    TbTrialgroupfileTable::addTrialgroupfile($id_trialgroup, $trgrflfile, $trgrfldescription);
                }
            }

            $pop = sfContext::getInstance()->getRequest()->getParameterHolder()->get('pop');
            //die('Pop:'.$pop);
            if ($pop == 1) {
                $this->redirect('@closepopup_trialgroup?id_new=' . $tbtrialgroup->getIdTrialgroup());
            }

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $tbtrialgroup)));

            if ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@tbtrialgroup_new');
            } else {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'tbtrialgroup_edit', 'sf_subject' => $tbtrialgroup));
            }
        } else {
            $this->getUser()->setFlash('error', "The item has not been saved due to some errors $error.", false);
        }
    }

    public function executeClose(sfWebRequest $request) {
        $id_new = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_new');
        die('sssss');
        $new = Doctrine::getTable('Tbtrialgroup')->findOneByIdTrialgroup($id_new);
        $this->name = $new->getTrgrname();
        $this->id = $id_new;
    }

    public function executeList_ShowTrial(sfWebRequest $request) {
        $id_trialgroup = $request->getParameter('id_trialgroup');
        $this->redirect('tbtrial/index?id_trialgroup=' . $id_trialgroup);
    }

    public function executeList_Comments(sfWebRequest $request) {
        $id_trialgroup = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_trialgroup');
        $trialgroupcomment = sfContext::getInstance()->getRequest()->getParameterHolder()->get('trialgroupcomment');
        if (isset($id_trialgroup) && isset($trialgroupcomment)) {
            $id_user = $this->getUser()->getGuardUser()->getId();
            TbTrialgroupcommentsTable::addTrialgroupcomments($id_trialgroup, $trialgroupcomment, $id_user);
        }
    }

    public function executeBatchuploadtrialgroup(sfWebRequest $request) {
        //PARAMETROS
        $Modulo = "Trial Group";
        $Cols = 8;
        $MaxRecordsFile = 10000;
        $MaxSizeFile = 5; // ESTE VALOR ES EN MB

        $connection = Doctrine_Manager::getInstance()->connection();
        $id_user = $this->getUser()->getGuardUser()->getId();
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $UploadDir = sfConfig::get("sf_upload_dir");
        $uploadstrialgroup = $UploadDir . "/filetrialgroup";
        if (!is_dir($uploadstrialgroup)) {
            mkdir($uploadstrialgroup, 0777);
        }

        //ARCHIVO
        $File = $request->getFiles('filetrialgroup');
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

            move_uploaded_file($FileTmpName, "$uploadstrialgroup/$FileName");
            $inputFileName = "$uploadstrialgroup/$FileName";

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
                $id_institution = trim($ExcelFile->sheets[0]['cells'][$row][1]);
                $id_contactpersons = trim($ExcelFile->sheets[0]['cells'][$row][2]);
                $id_trialgrouptype = trim($ExcelFile->sheets[0]['cells'][$row][3]);
                $id_objective = trim($ExcelFile->sheets[0]['cells'][$row][4]);
                $id_primarydiscipline = trim($ExcelFile->sheets[0]['cells'][$row][5]);
                $trgrname = trim($ExcelFile->sheets[0]['cells'][$row][6]);
                $trgrstartyear = trim($ExcelFile->sheets[0]['cells'][$row][7]);
                $trgrendyear = trim($ExcelFile->sheets[0]['cells'][$row][8]);

                $Fields = '{"' . $id_institution . '","' . $id_contactpersons . '","' . $id_trialgrouptype . '","' . $id_objective . '","' . $id_primarydiscipline . '","' . $trgrname . '","' . $trgrstartyear . '","' . $trgrendyear . '"}';
                $Fields = str_replace("'", "''", $Fields);
                $Fields = utf8_encode($Fields);
                $QUERY = "SELECT fc_checkfieldsbatchtrialgroup('$Fields'::text[]) AS info;";
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
                    $trgrname = utf8_encode($trgrname);
                    $id_trialgroup = TbTrialgroupTable::addTrialgroup($id_institution, null, $id_trialgrouptype, $id_objective, $id_primarydiscipline, $trgrname, $trgrstartyear, $trgrendyear, date('Y-m-d'), 'Open', $id_user);
                    TbTrialgroupcontactpersonTable::delTrialgroupcontactpersons($id_trialgroup);
                    $ArrContactPerson = explode(",", $id_contactpersons);
                    foreach ($ArrContactPerson AS $id_contactperson) {
                        TbTrialgroupcontactpersonTable::addTrialgroupcontactperson($id_trialgroup, $id_contactperson);
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

    public function executeDownloadestruturetrialgroup(sfWebRequest $request) {
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Herlin R. Espinosa G")
                ->setLastModifiedBy("Herlin R. Espinosa G")
                ->setTitle("File Structure Trial Group")
                ->setSubject("File Structure Trial Group")
                ->setDescription("File Structure Trial Group")
                ->setKeywords("File Structure Trial Group")
                ->setCategory("File Structure File Group");

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Institution')
                ->setCellValue('B1', 'Id Contact person')
                ->setCellValue('C1', 'Id Trial group type')
                ->setCellValue('D1', 'Id Objective')
                ->setCellValue('E1', 'Id Primary discipline')
                ->setCellValue('F1', 'Name')
                ->setCellValue('G1', 'Start year (yyyy)')
                ->setCellValue('H1', 'End year (yyyy)');

        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        //APLICAMOS COLOR ROJO A COLUMNAS OBLIGATORIAS
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        //RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Batch Upload Information');

        //inicio: GENERAMOS EL LIBRO DE INSTITUCION
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet(1)->setTitle('Institution');
        $QUERY01 = Doctrine_Query::create()
                        ->select("I.id_institution,I.insname")
                        ->addSelect("CN.cntname AS country")
                        ->from("TbInstitution I")
                        ->innerJoin("I.TbCountry CN")
                        ->orderBy('CN.cntname, I.insname');
        $Resultado01 = $QUERY01->execute();
        $i = 2;
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Country');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Name');
        foreach ($Resultado01 AS $fila) {
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
        //inicio: GENERAMOS EL LIBRO DE CONTACT PERSON
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet(2)->setTitle('Contact Person');
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
        //inicio: GENERAMOS EL LIBRO DE TRIAL GROUP TYPE
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->getActiveSheet(3)->setTitle('Trial group type');
        $QUERY03 = Doctrine_Query::create()
                        ->select("TGT.id_trialgrouptype AS id, TGT.trgptyname AS name")
                        ->from("Tbtrialgrouptype TGT")
                        ->orderBy("TGT.trgptyname");
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
        //fin: GENERAMOS EL LIBRO DE TRIAL GROUP TYPE
        //inicio: GENERAMOS EL LIBRO DE OBJETIVE
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(4);
        $objPHPExcel->getActiveSheet(4)->setTitle('Objective');
        $QUERY04 = Doctrine_Query::create()
                        ->select("O.id_objective AS id, O.objname AS name")
                        ->from("Tbobjective O")
                        ->orderBy("O.objname");
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
        //fin: GENERAMOS EL LIBRO DE OBJETIVE
        //inicio: GENERAMOS EL LIBRO DE PRIMARY DISCIPLINE
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(5);
        $objPHPExcel->getActiveSheet(5)->setTitle('Primary discipline');
        $QUERY05 = Doctrine_Query::create()
                        ->select("PD.id_primarydiscipline AS id, PD.prdsname AS name")
                        ->from("Tbprimarydiscipline PD")
                        ->orderBy("PD.prdsname");
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
        //fin: GENERAMOS EL LIBRO DE PRIMARY DISCIPLINE
        //ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="TrialGroupTemplate.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function executeDownloadfile(sfWebRequest $request) {
        $id_trialgroupfile = $request->getParameter('id_trialgroupfile');
		if($id_trialgroupfile != ""){
			$TbTrialgroupfile = Doctrine::getTable('TbTrialgroupfile')->findOneByIdTrialgroupfile($id_trialgroupfile);
			$Trgrflfile = $TbTrialgroupfile->getTrgrflfile();
			$Trgrfldescription = $TbTrialgroupfile->getTrgrfldescription();
			$id_trialgroup = $TbTrialgroupfile->getIdTrialgroup();

			$TrialGroupFile = "TrialGroupFile_$id_trialgroup";
			$uploadDir = sfConfig::get("sf_upload_dir");
			$dir_file = "$uploadDir/$TrialGroupFile/$Trgrflfile";
			$dir_file = str_replace("/", "\\", $dir_file);
			$file = file($dir_file);
			$file2 = implode("", $file);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=" . str_replace(" ", "_", $Trgrflfile) . "\r\n\r\n");
			header("Content-Length: " . strlen($file2) . "\n\n");
			echo $file2;
		}
        die();
    }

    public function executeTrialgroups($request) {
        $this->setLayout(false);
    }

    public function executeSavetrialgroups(sfWebRequest $request) {
        $this->setLayout(false);
        $user = sfContext::getInstance()->getUser();
        $array_trialgroups = sfContext::getInstance()->getRequest()->getParameterHolder()->get('trialgroups');
        $trialgroup_id = $array_trialgroups['user']['id'];
        $trialgroup_name = $array_trialgroups['user']['title'];
        $list_trialgroup = "";
        $session_trialgroup_id = array();
        $session_trialgroup_name = array();
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('trialgroup_name');
        foreach ($trialgroup_id as $key => $id_trialgroup) {
            $session_trialgroup_id[] = $id_trialgroup;
            $user->setAttribute('trialgroup_id', $session_trialgroup_id);
            $session_trialgroup_name[] = $trialgroup_name[$key];
            $user->setAttribute('trialgroup_name', $session_trialgroup_name);
            $list_trialgroup .= $trialgroup_name[$key] . ", ";
        }
        $list_trialgroup = substr($list_trialgroup, 0, strlen($list_trialgroup) - 2);
        $this->name = $list_trialgroup;
    }

    public function executeAutotrialgroups($request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        $dato = strtolower($request->getParameter('term'));
        if ($this->getUser()->hasCredential('Administrator')) {
            $QUERY01 = Doctrine_Query::create()
                            ->select("T.*,T.id_trialgroup AS id, (T.trgrname) AS name")
                            ->from("TbTrialgroup T")
                            ->where("LOWER(T.trgrname) LIKE '$dato%'")
                            ->orderBy("T.trgrname")
                            ->limit(20);
        } else {
            $QUERY01 = Doctrine_Query::create()
                            ->select("T.*,T.id_trialgroup AS id, (T.trgrname) AS name")
                            ->from("TbTrialgroup T")
                            ->where("T.id_user = $id_user")
                            ->andWhere("LOWER(T.trgrname) LIKE '$dato%'")
                            ->orderBy("T.trgrname")
                            ->limit(20);
        }
        $Resultado01 = $QUERY01->execute();
        $rv = "";
        foreach ($Resultado01 AS $fila) {
            if ($rv != '')
                $rv .= ', ';
            $rv .= '{ title: "' . htmlspecialchars($fila['name'], ENT_QUOTES, 'UTF-8') . '"' . ', id: ' . $fila['id'] . ' } ';
        }
        return $this->renderText("[$rv]");
    }

    public function executeTrialgroupcontactperson($request) {
        $this->setLayout(false);
    }

    public function executeSavetrialgroupcontactperson(sfWebRequest $request) {
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

}
