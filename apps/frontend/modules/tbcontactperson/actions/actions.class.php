<?php

require_once dirname(__FILE__) . '/../lib/tbcontactpersonGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/tbcontactpersonGeneratorHelper.class.php';

/**
 * tbcontactperson actions.
 *
 * @package    trialsites
 * @subpackage tbcontactperson
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tbcontactpersonActions extends autoTbcontactpersonActions {

    public function executeFilter(sfWebRequest $request) {
        $user = sfContext::getInstance()->getUser();
        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@tbcontactperson');
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
                        $wherelist .= "AND CP.$Key = $Filters,";
                    } else {
                        $wherelist .= "AND UPPER(CP.$Key) LIKE '%" . strtoupper($Filters['text']) . "%',";
                    }
                }
            }
            $wherelist = substr($wherelist, 0, strlen($wherelist) - 1);
            $user->setAttribute('wherelist', $wherelist);
            $this->redirect('@tbcontactperson');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeNew(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbcontactperson = $this->form->getObject();
        $this->form = new tbcontactpersonForm(null, array('url' => 'tbcontactperson/'));
    }

    public function executeCreate(sfWebRequest $request) {
        $this->form = $this->configuration->getForm();
        $this->tbcontactperson = $this->form->getObject();
        $this->form = new tbcontactpersonForm(null, array('url' => 'tbcontactperson/tbcontactperson/'));
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeAutoinstitution($request) {
        $this->getResponse()->setContentType('application/json');

        $Institution = Doctrine::getTable('TbInstitution')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );

        return $this->renderText(json_encode($Institution));
    }

    public function executeAutocountry($request) {
        $this->getResponse()->setContentType('application/json');

        $countries = Doctrine::getTable('TbCountry')->retrieveForSelect(
                $request->getParameter('q'), $request->getParameter('limit')
        );

        return $this->renderText(json_encode($countries));
    }

    public function executeDownloadexcel(sfWebRequest $request) {
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
                ->setSubject("Contact Person List")
                ->setDescription("Contact Person List")
                ->setKeywords("Contact Person List")
                ->setCategory("Contact Person List");

        // Add some data

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id Contact Person')
                ->setCellValue('B1', 'Institution')
                ->setCellValue('C1', 'Country')
                ->setCellValue('D1', 'Contact person type')
                ->setCellValue('E1', 'First name')
                ->setCellValue('F1', 'Last name')
                ->setCellValue('G1', 'Address')
                ->setCellValue('H1', 'Phone')
                ->setCellValue('I1', 'Email');

        //APLICAMOS NEGRILLA AL TITULO
        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        //RENOMBRAMOS EL LIBO
        $objPHPExcel->getActiveSheet(0)->setTitle('Contact Person');

        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT CP.id_contactperson,INS.insname,CN.cntname,CPT.ctprtpname,CP.cnprfirstname,CP.cnprlastname,CP.cnpraddress,CP.cnprphone,CP.cnpremail ";
        $QUERY00 .= "FROM tb_contactperson CP ";
        $QUERY00 .= "INNER JOIN tb_institution INS ON CP.id_institution = INS.id_institution ";
        $QUERY00 .= "INNER JOIN tb_country CN ON CP.id_country = CN.id_country ";
        $QUERY00 .= "INNER JOIN tb_contactpersontype CPT ON CP.id_contactpersontype = CPT.id_contactpersontype ";
        $QUERY00 .= "WHERE true $wherelist ";
        $QUERY00 .= "ORDER BY CP.id_contactperson ";
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
            $i++;
        }

        //ACTIVAMOS EL PRIMER LIBRO
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a clientâ€™s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Contact Person List.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
