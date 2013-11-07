<?php

require_once dirname(__FILE__) . '/../lib/sfGuardUserGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/sfGuardUserGeneratorHelper.class.php';
require_once dirname(__FILE__) . '/../../../../../lib/funtions/connectionblog.php';
require_once dirname(__FILE__) . '/../../../../../lib/funtions/funtion.php';

/**
 * sfGuardUser actions.
 *
 * @package    sfGuardPlugin
 * @subpackage sfGuardUser
 * @author     Fabien Potencier
 * @version    SVN: $Id: actions.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardUserActions extends autoSfGuardUserActions {

    public function executeIndex(sfWebRequest $request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (CheckUserPermission($id_user, 1)) {
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
            $this->hasFilters = $this->getUser()->getAttribute('sfGuardUser.filters', $this->configuration->getFilterDefaults(), 'admin_module');
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permission!!'); window.history.back();</script>";
            Die();
        }
    }

    public function executeFilter(sfWebRequest $request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (CheckUserPermission($id_user, 1)) {
            $this->setPage(1);

            if ($request->hasParameter('_reset')) {
                sfContext::getInstance()->getUser()->getAttributeHolder()->remove('whereusers');
                $this->setFilters($this->configuration->getFilterDefaults());
                $this->redirect('@sf_guard_user');
            }

            $this->filters = $this->configuration->getFilterForm($this->getFilters());

            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid()) {
                $this->setFilters($this->filters->getValues());

                //PARTE ADICIONAL
                $Arr_Filters = $this->getFilters();
                $whereusers = "";
                foreach ($Arr_Filters AS $Key => $Filters) {
                    if ($Filters['text'] != '') {
                        if (intval($Filters['text'])) {
                            $whereusers .= "AND U.$Key = $Filters,";
                        } else {
                            if ($Key == 'is_active')
                                $whereusers .= "AND U.$Key = '" . strtoupper($Filters['text']) . "',";
                            else
                                $whereusers .= "AND UPPER(U.$Key) LIKE '%" . strtoupper($Filters['text']) . "%',";
                        }
                    }
                }
                $whereusers = substr($whereusers, 0, strlen($whereusers) - 1);
                sfContext::getInstance()->getUser()->setAttribute('whereusers', $whereusers);

                $this->redirect('@sf_guard_user');
            }

            $this->pager = $this->getPager();
            $this->sort = $this->getSort();

            $this->setTemplate('index');
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permission!!'); window.history.back();</script>";
            Die();
        }
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (CheckUserPermission($id_user, 1)) {
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
            if ($form->isValid()) {
                $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

                $sf_guard_user = $form->save();
                $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_user)));

                if ($request->hasParameter('_save_and_add')) {
                    $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');
                    $this->redirect('@sf_guard_user_new');
                } else {
                    $this->getUser()->setFlash('notice', $notice);
                    $this->redirect(array('sf_route' => 'sf_guard_user_edit', 'sf_subject' => $sf_guard_user));
                }
            } else {
                $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
            }
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permission!!'); window.history.back();</script>";
            Die();
        }
    }

    public function executeChangepassword(sfWebRequest $request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        $username = sfContext::getInstance()->getUser()->getUsername();
        $newpassword = sfContext::getInstance()->getRequest()->getParameterHolder()->get('newpassword');
        $confirmnewpassword = sfContext::getInstance()->getRequest()->getParameterHolder()->get('confirmnewpassword');
        if (isset($newpassword) && isset($confirmnewpassword)) {
            $sf_guard_user = Doctrine::getTable('sfGuardUser')->find($this->getUser()->getGuardUser()->getId());
            $sf_guard_user->setPassword($newpassword);
            $sf_guard_user->save();

            //VERIFICAMOS SI EXISTE LA CUANTA DEL BLOG SINO LA CREAMOS
            $username = $username;
            $password = $newpassword;
            $email = $sf_guard_user->getEmailAddress();
            $firstname = $sf_guard_user->getFirstName();
            $lastname = $sf_guard_user->getLastName();
            $user_id = wp_username_exists($username);
            if ($user_id == null) {
                wp_create_user($username, $password, $email, $firstname, $lastname);
            } else {
                wp_update_password($user_id, $password);
            }

            $this->notice = "Your password has changed successful (AgTrials y AgTrials Blog).";
        }
    }

    public function executeUser(sfWebRequest $request) {
        $user_id = $request->getParameter('user_id');
        $email_address = $request->getParameter('email_address');
        $first_name = $request->getParameter('first_name');
        $last_name = $request->getParameter('last_name');
        $institution = $request->getParameter('institution');
        $country = $request->getParameter('country');
        $city = ucwords(strtolower($request->getParameter('city')));
        $state = ucwords(strtolower($request->getParameter('state')));
        $address = ucwords(strtolower($request->getParameter('address')));
        $telephone = $request->getParameter('telephone');
        $key = $request->getParameter('key');

        if (isset($user_id) && isset($first_name) && isset($last_name) && isset($email_address)) {
            $email_address = strtolower(trim($email_address));
            $sf_guard_user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($email_address);
            $id_user_consulta = $sf_guard_user->id;
            if ((count($sf_guard_user) > 1) && ($user_id != $id_user_consulta)) {
                echo "<script> alert('*** Error Email *** \\n\\n An user with the same email_address: $email_address already exist!'); window.history.back();</script>";
                die();
            }

            $sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneById($user_id);
            $OLDEmail = $sfGuardUser->getEmailAddress();
            $sfGuardUser->setFirstName($first_name);
            $sfGuardUser->setLastName($last_name);
            $sfGuardUser->setEmailAddress($email_address);
            $sfGuardUser->save();

            //ACTUALIZAMOS tb_contactperson
            $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByCnpremail($OLDEmail);
            if (count($TbContactperson) <= 1) {
                $TbContactperson = new TbContactperson();
                $TbContactperson->setIdInstitution($institution);
                $TbContactperson->setIdCountry($country);
                $TbContactperson->setIdContactpersontype(1);
                $TbContactperson->setCnprfirstname($first_name);
                $TbContactperson->setCnprlastname($last_name);
                $TbContactperson->setCnpraddress($address);
                $TbContactperson->setCnprphone($telephone);
                $TbContactperson->setCnpremail($email_address);
                $TbContactperson->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
                $TbContactperson->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
                $TbContactperson->save();
            } else {
                $TbContactperson->setCnprfirstname($first_name);
                $TbContactperson->setCnprlastname($last_name);
                $TbContactperson->setCnpraddress($address);
                $TbContactperson->setCnprphone($telephone);
                $TbContactperson->setCnpremail($email_address);
                $TbContactperson->save();
            }

            $UserInformation = Doctrine::getTable('sfGuardUserInformation')->findOneByUserId($user_id);
            if (count($UserInformation) <= 1) {
                $sfGuardUserInformation = new SfGuardUserInformation();
                $sfGuardUserInformation->setUserId($user_id);
                if ($institution != '')
                    $sfGuardUserInformation->setIdInstitution($institution);
                else
                    $sfGuardUserInformation->setIdInstitution(null);
                $sfGuardUserInformation->setIdCountry($country);
                $sfGuardUserInformation->setCity($city);
                if ($state != '')
                    $sfGuardUserInformation->setState($state);
                else
                    $sfGuardUserInformation->setState(null);
                $sfGuardUserInformation->setAddress($address);
                $sfGuardUserInformation->setTelephone($telephone);
                $sfGuardUserInformation->setMotivation($motivation);
                $sfGuardUserInformation->setKey($key);
                $sfGuardUserInformation->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
                $sfGuardUserInformation->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
                $sfGuardUserInformation->save();
            }else {
                if ($institution != '')
                    $UserInformation->setIdInstitution($institution);
                else
                    $UserInformation->setIdInstitution(null);
                $UserInformation->setIdCountry($country);
                $UserInformation->setCity($city);
                if ($state != '')
                    $UserInformation->setState($state);
                else
                    $UserInformation->setState(null);
                $UserInformation->setAddress($address);
                $UserInformation->setTelephone($telephone);
                $UserInformation->setMotivation($motivation);
                $UserInformation->setKey($key);
                $UserInformation->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
                $UserInformation->save();
            }
            echo "<script language='JavaScript'>alert('*** Your Information has changed! ***');</script>";
        }
    }

    public function executeDownloadusers(sfWebRequest $request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (CheckUserPermission($id_user, 1)) {
            $user = sfContext::getInstance()->getUser();
            $whereusers = $user->getAttribute('whereusers');
            error_reporting(E_ALL);
            date_default_timezone_set('Europe/London');
            set_time_limit(600);
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

            // Set properties
            $objPHPExcel->getProperties()->setCreator("AgTrials")
                    ->setLastModifiedBy("AgTrials")
                    ->setTitle("")
                    ->setSubject("Users List")
                    ->setDescription("Users List")
                    ->setKeywords("Users List")
                    ->setCategory("Users List");

            // Add some data

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Id')
                    ->setCellValue('B1', 'Username')
                    ->setCellValue('C1', 'First name')
                    ->setCellValue('D1', 'Last name')
                    ->setCellValue('E1', 'Email address')
                    ->setCellValue('F1', 'Country')
                    ->setCellValue('G1', 'City')
                    ->setCellValue('H1', 'Institution or Affiliation');

            //APLICAMOS NEGRILLA AL TITULO
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

            //RENOMBRAMOS EL LIBO
            $objPHPExcel->getActiveSheet(0)->setTitle('Users');

            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT U.id,U.username,U.first_name,U.last_name,U.email_address,C.cntname,UI.city,I.insname ";
            $QUERY00 .= "FROM sf_guard_user U ";
            $QUERY00 .= "LEFT JOIN sf_guard_user_information UI ON U.id = UI.user_id ";
            $QUERY00 .= "LEFT JOIN tb_country C ON UI.id_country = C.id_country ";
            $QUERY00 .= "LEFT JOIN tb_institution I ON UI.id_institution = I.id_institution ";
            $QUERY00 .= "WHERE true $whereusers ";
            $QUERY00 .= "ORDER BY username ";
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

            //ACTIVAMOS EL PRIMER LIBRO
            $objPHPExcel->setActiveSheetIndex(0);

            // Redirect output to a clientâ€™s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Users_List.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permission!!'); window.history.back();</script>";
            Die();
        }
    }

    //VALIDACIONES AJAX
    public function executeValidacorreo(sfWebRequest $request) {
        $userid = $request->getParameter('userid');
        $emailaddress = $request->getParameter('emailaddress');
        $emailaddress = strtolower(trim($emailaddress));
        $sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($emailaddress);
        $id_user_consulta = $sfGuardUser->id;
        if ((count($sfGuardUser) > 1) && ($userid != $id_user_consulta)) {
            echo "Email address $emailaddress already exist";
        } else {
            echo "";
        }
        die();
    }

}
