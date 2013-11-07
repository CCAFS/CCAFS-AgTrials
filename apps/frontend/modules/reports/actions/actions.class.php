<?php

require_once ('/../../../../../zip/lib/pclzip.lib.php');
require_once '../lib/excel/Classes/PHPExcel.php';
require_once '../lib/excel/Classes/PHPExcel/IOFactory.php';

/**
 * reports actions.
 *
 * @package    trialsites
 * @subpackage reports
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportsActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        if (!$this->getUser()->isAuthenticated()) {
            return $this->forward('sfGuardAuth', 'signin');
        }
    }

    public function executeTrialssitesbycrop(sfWebRequest $request) {
        if (!$this->getUser()->isAuthenticated()) {
            return $this->forward('sfGuardAuth', 'signin');
        }
        $forma = sfContext::getInstance()->getRequest()->getParameterHolder()->get('forma');
        $id_trialgroup = sfContext::getInstance()->getRequest()->getParameterHolder()->get('trialgroup');
        $id_contactperson = sfContext::getInstance()->getRequest()->getParameterHolder()->get('contactperson');
        $id_country = sfContext::getInstance()->getRequest()->getParameterHolder()->get('country');
        $id_trialsite = sfContext::getInstance()->getRequest()->getParameterHolder()->get('trialsite');
        $id_crop = sfContext::getInstance()->getRequest()->getParameterHolder()->get('crop');
        if (isset($forma)) {
            $crops = "";
            $where = "";
            $arr_crops[] = "Trial_Site";
            $arr_crops[] = "Trial_Site_Point";
            if ($id_trialgroup != '')
                $where .= " AND T.id_trialgroup = $id_trialgroup";
            if ($id_contactperson != '')
                $where .= " AND T.id_contactperson = $id_contactperson";
            if ($id_country != '')
                $where .= " AND T.id_country = $id_country";
            if ($id_trialsite != '')
                $where .= " AND T.id_trialsite = $id_trialsite";
            if ($id_crop != '') {
                $where .= " AND T.id_crop = $id_crop";
                $TbCrop = Doctrine::getTable('TbCrop')->findOneByIdCrop($id_crop);
                $label = $TbCrop->getCrpname();
                $C_name = str_replace(" ", "_", $label);
                $C_name = str_replace("/", "_", $C_name);
                $C_name = str_replace("(", "", $C_name);
                $C_name = str_replace(")", "", $C_name);
                $C_name = str_replace(",", "_", $C_name);
                $crops = ",fc_trialscropbysites(TS.id_trialsite,$id_crop) AS $C_name";
                $arr_crops[] = $C_name;
            } else {
                $QUERY00 = Doctrine_Query::create()
                        ->select("C.id_crop AS id, C.crpname AS name")
                        ->from("TbCrop C")
                        ->orderBy("C.crpname");
                $Resultado00 = $QUERY00->execute();
                foreach ($Resultado00 AS $fila00) {
                    $C_name = str_replace(" ", "_", $fila00['name']);
                    $C_name = str_replace("/", "_", $C_name);
                    $C_name = str_replace("(", "", $C_name);
                    $C_name = str_replace(")", "", $C_name);
                    $C_name = str_replace(",", "_", $C_name);
                    $crops .= ",fc_trialscropbysites(TS.id_trialsite,{$fila00['id']}) AS $C_name";
                    $arr_crops[] = $C_name;
                }
            }
            $QUERY01 = "SELECT (TS.trstname||' - '||CN.cntname) AS Trial_Site, (TS.trstlatitudedecimal||' '||TS.trstlongitudedecimal) AS Trial_Site_Point $crops ";
            $QUERY01 .= "FROM tb_trial T ";
            $QUERY01 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
            $QUERY01 .= "INNER JOIN tb_country CN ON TS.id_country = CN.id_country ";
            $QUERY01 .= "WHERE TRUE $where ";
            $QUERY01 .= "GROUP BY TS.trstname, CN.cntname, TS.trstlatitudedecimal, TS.trstlongitudedecimal, TS.id_trialsite ";
            $QUERY01 .= "ORDER BY TS.trstname,CN.cntname";
            //die($QUERY01);
            $connection = Doctrine_Manager::getInstance()->connection();
            $st = $connection->execute($QUERY01);
            $Resultado01 = $st->fetchAll();
            $array_ABC = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ');

            //GENERACION ARCHIVO EXCELL
            error_reporting(E_ALL);
            date_default_timezone_set('Europe/London');

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

            // Set properties
            $objPHPExcel->getProperties()->setCreator("Herlin R. Espinosa G")
                    ->setLastModifiedBy("Herlin R. Espinosa G")
                    ->setTitle("File Structure Trial")
                    ->setSubject("File Structure Trial")
                    ->setDescription("File Structure Trial")
                    ->setKeywords("File Structure Trial")
                    ->setCategory("File Structure File");

            // Add some data
            $a = 0;
            foreach ($arr_crops AS $L_cam) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($array_ABC[$a] . '1', $L_cam);
                $a++;
            }
            $a--;
            $end_leter = $array_ABC[$a] . "1";
            //APLICAMOS NEGRITA
            $objPHPExcel->getActiveSheet()->getStyle("A1:$end_leter")->getFont()->setBold(true);
            //AUTO AJUSTAMOS LA COLUMNA
            $a = 0;
            foreach ($arr_crops AS $L_cam) {
                $objPHPExcel->getActiveSheet()->getColumnDimension("$array_ABC[$a]")->setAutoSize(true);
                $a++;
            }
            //RENOMBRAMOS EL LIBO
            $objPHPExcel->getActiveSheet(0)->setTitle('Trials sites by crop-animal');

            //LLENAMOS LA INFORMACION
            $i = 2;
            foreach ($Resultado01 AS $fila01) {
                $a = 0;
                foreach ($arr_crops AS $L_cam) {
                    $objPHPExcel->getActiveSheet()->setCellValue($array_ABC[$a] . $i, $fila01[$a]);
                    $a++;
                }
                $i++;
            }


            $objPHPExcel->setActiveSheetIndex(0);

            // Redirect output to a clientâ€™s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Reports - Trials sites by crop-animal.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

}
