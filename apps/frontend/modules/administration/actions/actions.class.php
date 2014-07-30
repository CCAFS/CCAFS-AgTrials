<?php

require_once '../lib/funtions/funtion.php';

/**
 * administration actions.
 *
 * @package    trialsites
 * @subpackage administration
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class administrationActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->setLayout(false);
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (!(CheckUserPermission($id_user, 1))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions!'); window.history.back();</script>";
            die();
        }
    }

    public function executeClearcache(sfWebRequest $request) {
        $this->setLayout(false);
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (!(CheckUserPermission($id_user, 1))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions!'); window.history.back();</script>";
            die();
        }
        $IPSERVER = $_SERVER["HTTP_HOST"];
        $IP = substr($IPSERVER, 0, 3);
        if ($IP == '172') {
            $out = array();
            exec("C:\\xampp\\htdocs\\trialsites\\localclearcache.bat", $out);
            $this->out = $out;
        } else {
            $out = array();
            exec("D:\\xampp\\htdocs\\trialsites\\serverclearcache.bat", $out);
            $this->out = $out;
        }
    }

    public function executeSchema(sfWebRequest $request) {
        $this->setLayout(false);
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (!(CheckUserPermission($id_user, 1))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions!'); window.history.back();</script>";
            die();
        }
        $IPSERVER = $_SERVER["HTTP_HOST"];
        $IP = substr($IPSERVER, 0, 3);
        if ($IP == '172') {
            $out = array();
            exec("C:\\xampp\\htdocs\\trialsites\\localschema.bat", $out);
            $this->out = $out;
        } else {
            $out = array();
            exec("D:\\xampp\\htdocs\\trialsites\\serverschema.bat", $out);
            $this->out = $out;
        }
    }

    public function executeLogtransaction(sfWebRequest $request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (!(CheckUserPermission($id_user, 1))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions!'); window.history.back();</script>";
            die();
        }
        $modulelog = $request->getParameter('modulelog');
        $idrecord = $request->getParameter('idrecord');
        $where = '';
        if ($idrecord != '' && is_numeric($idrecord)) {
            $campoid = str_replace("tb", "id", $modulelog);
            $where = " WHERE $campoid = $idrecord";
        } else {
            $idrecord = '';
        }
        if ($modulelog != '') {
            $conexion = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $modulelog . "_log'";
            $st = $conexion->execute($QUERY00);
            if ($st->rowCount() > 0) {
                $QUERY01 = "SELECT column_name FROM information_schema.columns WHERE table_name = '$modulelog' ORDER BY ordinal_position";
                $st1 = $conexion->execute($QUERY01);
                $fields = $st1->fetchAll();
                $modulelogg = "audit." . $modulelog . "_log";
                $QUERY02 = "SELECT * FROM $modulelogg $where ORDER BY 3,2";
                $st2 = $conexion->execute($QUERY02);
                $records = $st2->fetchAll();
            }
        }
        $this->fields = $fields;
        $this->records = $records;
        $this->modulelog = $modulelog;
        $this->idrecord = $idrecord;
    }

    public function executeCommunications(sfWebRequest $request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        if (!$this->getUser()->isAuthenticated()) {
            return $this->forward('sfGuardAuth', 'signin');
        }
        $forma = sfContext::getInstance()->getRequest()->getParameterHolder()->get('forma');
        $userssystemall = sfContext::getInstance()->getRequest()->getParameterHolder()->get('userssystemall');
        $array_users = sfContext::getInstance()->getRequest()->getParameterHolder()->get('users');
        $user_id = $array_users['user']['id'];
        $subject = sfContext::getInstance()->getRequest()->getParameterHolder()->get('subject');
        $message = sfContext::getInstance()->getRequest()->getParameterHolder()->get('message');
        $sent = date("d-M-Y") . " " . date("h:i:s");
        if (isset($forma)) {
            if (count($user_id) == 0 && $userssystemall == '') {
                echo "<script> alert('Write the Contact Persons or Check Contact Persons All'); window.history.back();</script>";
                die();
            } elseif ($subject == "") {
                echo "<script> alert('Write your subject'); window.history.back();</script>";
                die();
            } elseif ($message == "") {
                echo "<script> alert('Write your message'); window.history.back();</script>";
                die();
            } else {
                $To = "";
                if ($userssystemall != '') {
                    $QUERY00 = Doctrine_Query::create()
                            ->select("email_address")
                            ->from("SfGuardUser")
                            ->orderBy("first_name");
                    $Resultado00 = $QUERY00->execute();
                    $count = 0;
                    foreach ($Resultado00 AS $SfGuardUser) {
                        $To = $SfGuardUser->email_address;
                        $Sentby = $this->getUser()->getGuardUser()->getFirst_name() . " " . $this->getUser()->getGuardUser()->getLast_name() . " - " . $this->getUser()->getGuardUser()->getEmail_address() . " - " . $sent;
                        //ENVIO DE CORREO
                        $destinatario = $To;
                        $asunto = $subject;
                        $cuerpo = "<html>";
                        $cuerpo .= "<head>";
                        $cuerpo .= "<title>Communications - Trial Sites - Don't reply</title>";
                        $cuerpo .= "</head>";
                        $cuerpo .= "<body>";
                        $cuerpo .= "<h1>*** Communications - Trial Sites - Don't reply ***</h1>";
                        $cuerpo .= $message;
                        $cuerpo .= "<br><br><b>Sent by:</b> $Sentby ";
                        $cuerpo .= "</body>";
                        $cuerpo .= "</html>";
                        $headers = "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                        $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
                        mail($destinatario, $asunto, $cuerpo, $headers);
                    }
//                    $Sentby = $this->getUser()->getGuardUser()->getFirst_name() . " " . $this->getUser()->getGuardUser()->getLast_name() . " - " . $this->getUser()->getGuardUser()->getEmail_address() . " - " . $sent;
//                    $To = substr($To, 0, (strlen($To) - 1));
//                    //ENVIO DE CORREO
//                    $destinatario = "noreplyagtrials@gmail.com";
//                    $asunto = $subject;
//                    $cuerpo = "<html>";
//                    $cuerpo .= "<head>";
//                    $cuerpo .= "<title>Communications - Trial Sites - Don't reply</title>";
//                    $cuerpo .= "</head>";
//                    $cuerpo .= "<body>";
//                    $cuerpo .= "<h1>*** Communications - Trial Sites - Don't reply ***</h1>";
//                    $cuerpo .= $message;
//                    $cuerpo .= "<br><br><b>Sent by:</b> $Sentby ";
//                    $cuerpo .= "</body>";
//                    $cuerpo .= "</html>";
//                    $headers = "MIME-Version: 1.0\r\n";
//                    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
//                    $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
//                    $headers .= "Bcc: $To\r\n";
//                    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
//                        echo "<script language='JavaScript'>alert('Sent Message!');</script>";
//                    } else {
//                        echo "<script> alert('*** Email Error! ***'); window.history.back();</script>";
//                        die();
//                    }
                } else {
                    foreach ($user_id as $key => $id_user) {
                        $SfGuardUser = Doctrine::getTable('SfGuardUser')->findOneById($id_user);
                        $To .= $SfGuardUser->email_address . ";";
                    }
                    $Sentby = $this->getUser()->getGuardUser()->getFirst_name() . " " . $this->getUser()->getGuardUser()->getLast_name() . " - " . $this->getUser()->getGuardUser()->getEmail_address() . " - " . $sent;
                    $To = substr($To, 0, (strlen($To) - 1));
                    //ENVIO DE CORREO
                    $destinatario = $To;
                    $asunto = $subject;
                    $cuerpo = "<html>";
                    $cuerpo .= "<head>";
                    $cuerpo .= "<title>Communications - Trial Sites - Don't reply</title>";
                    $cuerpo .= "</head>";
                    $cuerpo .= "<body>";
                    $cuerpo .= "<h1>*** Communications - Trial Sites - Don't reply ***</h1>";
                    $cuerpo .= $message;
                    $cuerpo .= "<br><br><b>Sent by:</b> $Sentby ";
                    $cuerpo .= "</body>";
                    $cuerpo .= "</html>";
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                    $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
                    //$headers .= "Cc: herlin25@gmail.com;mi_ger83@hotmail.com\r\n";
                    //$headers .= "Bcc: mi_ger83@hotmail.com\r\n";
                    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
                        echo "<script language='JavaScript'>alert('Sent Message!');</script>";
                    } else {
                        echo "<script> alert('*** Email Error! ***'); window.history.back();</script>";
                        die();
                    }
                }
            }
        }
    }

    public function executeUpdatevariablemeasured($request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $id_crop = $request->getParameter("id_crop");
        if ($id_crop != '') {
            $connection = Doctrine_Manager::getInstance()->connection();

            //EJECUCION CONSULTA VARIABLE MEASURE BY CROP
            $QUERY01 = "SELECT VM.id_variablesmeasured,C.crpname,VM.vrmsname ";
            $QUERY01 .= "FROM tb_variablesmeasured VM ";
            $QUERY01 .= "INNER JOIN tb_crop C ON  VM.id_crop = C.id_crop ";
            $QUERY01 .= "WHERE C.id_crop = $id_crop AND VM.id_ontology IS NULL";
            $st = $connection->execute($QUERY01);
            $updated = 0;
            $all = 0;
            foreach ($st->fetchAll() AS $dato) {
                $all++;
                $C_id_variablesmeasured = trim($dato[0]);
                $C_crop = trim($dato[1]);
                $C_variablesmeasured = trim($dato[2]);
                $Search = str_replace(" ", "%20", $C_variablesmeasured);
                //echo "Crop:$C_crop *** Variablesmeasured:$C_variablesmeasured<br>";
                $url = "http://www.cropontology-curationtool.org/search?q=$Search";
                set_time_limit(120);
                $data = file_get_contents($url);
                $data_array = json_decode($data);
                foreach ($data_array AS $data) {
                    $id = $data->id;
                    $name = trim($data->name);
                    $tmp = $data->ontology_name;
                    $tmp = $tmp . " tmp";
                    $arrcrop = explode(" ", $tmp);
                    $crop = trim($arrcrop[0]);
                    //echo "($crop == $C_crop && $name== $C_variablesmeasured <br>";
                    if ((strtoupper($crop) == strtoupper($C_crop)) && (strtoupper($name) == strtoupper($C_variablesmeasured))) {
                        $TbVariablesmeasured = Doctrine::getTable('TbVariablesmeasured')->find($C_id_variablesmeasured);
                        $TbVariablesmeasured->setIdOntology($id);
                        $TbVariablesmeasured->save();
                        $updated++;
                        break;
                    }
                }
            }
            $Unupdated = $all - $updated;
            echo "  <table align='center'>
                    <tr>
                        <td><font color='#0000A0' face='Verdana' size='2'><B align='center'>*** Sumary Information ***</B></font></td>
                    </tr>
                    <br>
                    <tr>
                        <td><li><font color='#000000' face='Verdana' size='2'>Variables Measured Updated: <b>" . $updated . "</b></td>
                    </tr>
                    <tr>
                        <td><li><font color='#000000' face='Verdana' size='2'>Variables Measured Un-updated: <b>" . $Unupdated . "</b></td>
                    </tr>
                    <tr align='center'>
                        <td align='center'><input type='button' value='Done' OnClick='window.location = \"updatevariablemeasured\"'></td>
                     </tr>
                    </table>";
            die();
        }
    }

    public function executeVideo(sfWebRequest $request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (!(CheckUserPermission($id_user, 1))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions!'); window.history.back();</script>";
            die();
        }
        $vdename = sfContext::getInstance()->getRequest()->getParameterHolder()->get('vdename');
        $vdedescription = sfContext::getInstance()->getRequest()->getParameterHolder()->get('vdedescription');
        $vdeurl = sfContext::getInstance()->getRequest()->getParameterHolder()->get('vdeurl');
        if (($vdename != '') && ($vdedescription != '') && ($vdeurl != '')) {
            $TbVideo = new TbVideo();
            $TbVideo->setVdename($vdename);
            $TbVideo->setVdedescription($vdedescription);
            $TbVideo->setVdeurl($vdeurl);
            $TbVideo->setVdedate(date("Y-m-d") . " " . date("H:i:s"));
            $TbVideo->save();
            $this->redirect("/video");
        }
    }

    public function executeViewvideo(sfWebRequest $request) {
        $this->id_video = $request->getParameter('id_video');
    }

    public function executeCropOntology(sfWebRequest $request) {
        ini_set("memory_limit", "2048M");
        set_time_limit(900000000000);
        $CropName = $request->getParameter('CropName');
        $notice = "Remember: These processes run automatically on weekends.";
        if ($CropName != '') {
            //$notice = "Process successfully completed.";
            $out = array();
            $Command = "E:\\xampp\\php\\ScriptCropOntology\\CropOntology" . $CropName;
            exec($Command, $out);
            $this->out = $out;
        }
        $this->notice = $notice;
    }

    public function executeFieldmodulehelp(sfWebRequest $request) {
        $id_user = $this->getUser()->getGuardUser()->getId();
        if (!(CheckUserPermission($id_user, 1))) {
            echo "<script> alert('*** ERROR *** \\n\\n Not have permissions!'); window.history.back();</script>";
            die();
        }
        $flmdhlmodule = trim($request->getParameter('flmdhlmodule'));
        $Fields = trim($request->getParameter('Fields'));

        if ($flmdhlmodule != '') {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY = "SELECT id_fieldmodulehelp,flmdhlmodule,flmdhlfield,flmdhlname,trgrflhelp FROM tb_fieldmodulehelp WHERE flmdhlmodule = '$flmdhlmodule' ORDER BY id_fieldmodulehelp";
            $st = $connection->execute($QUERY);
            $R_FieldModuleHelp = $st->fetchAll();
            $this->R_FieldModuleHelp = $R_FieldModuleHelp;
        }
        if ($Fields > 0) {
            for ($i = 1; $i <= $Fields; $i++) {
                $connection = Doctrine_Manager::getInstance()->connection();
                $id_fieldmodulehelp = trim($request->getParameter('id_fieldmodulehelp' . $i));
                $trgrflhelp = trim($request->getParameter('trgrflhelp' . $i));
                $UPDATE = "UPDATE tb_fieldmodulehelp SET trgrflhelp = '$trgrflhelp' WHERE id_fieldmodulehelp = $id_fieldmodulehelp";
                $connection->execute($UPDATE);
            }
            $this->notice = "The module was updated successfully.";
        }
    }

    public function executeBatchprocesses(sfWebRequest $request) {
        
    }

    public function executeAgmip(sfWebRequest $request) {
        
    }

}
