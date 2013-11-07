<?php

include("../lib/funtions/funtion.php");
include('../lib/funtions/connectionblog.php');

/**
 * home actions.
 *
 * @package    trialsites
 * @subpackage home
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeSitemap(sfWebRequest $request) {
        
    }
    public function executeIndex(sfWebRequest $request) {
        $conexion = connectionblog();
        $sql = @mysql_query("SELECT P.id,P.post_title,P.post_date,P.guid,P.post_parent,P.post_content,U.display_name FROM wp_posts P JOIN wp_users U ON P.post_author = U.id WHERE P.post_status = 'publish' AND P.post_type = 'post' ORDER BY P.post_date DESC LIMIT 2", $conexion);
        while ($row = @mysql_fetch_array($sql)) {
            $sql2 = @mysql_query("SELECT guid FROM wp_posts WHERE post_type = 'attachment' AND post_parent = {$row["id"]}", $conexion);
            $image = "";
            while ($row2 = @mysql_fetch_array($sql2)) {
                $image = $row2["guid"];
            }
            $lastpost[] = array("id" => $row["id"], "post_title" => $row["post_title"], "post_date" => $row["post_date"], "guid" => $row["guid"], "image" => $image, "post_content" => utf8_encode($row["post_content"]), "user" => $row["display_name"]);
        }

        @mysql_free_result($sql);
        @mysql_close($conexion);
        $this->lastpost = $lastpost;

        $QUERY00 = Doctrine_Query::create()
                        ->select("T.*,TG.trgrname AS trialgroup, (CP.cnprfirstname||' '||CP.cnprlastname) AS contactperson, CN.cntname AS country, TS.trstname AS trialsite, CR.crpname AS cropanimal, (TS.trstlatitudedecimal||' '||TS.trstlongitudedecimal) AS georsspoint, T.*")
                        ->from("TbTrial T")
                        ->innerJoin("T.TbTrialgroup TG")
                        ->innerJoin("T.TbContactperson CP")
                        ->innerJoin("T.TbCountry CN")
                        ->innerJoin("T.TbTrialsite TS")
                        ->innerJoin("T.TbCrop CR")
                        ->orderBy("T.created_at DESC")
                        ->limit(3);
        //die($QUERY00->getSqlQuery());
        $Resultado00 = $QUERY00->execute();
        $this->lasttrial = $Resultado00;

        $connection = Doctrine_Manager::getInstance()->connection();
        $st = $connection->execute("SELECT fc_alltrialgroup() AS trialgroups, fc_alltrials(), fc_allcrops() AS trials");
        $this->statistics = $st->fetchAll();

        $QUERY01 = Doctrine_Query::create()
                        ->from("TbVideo")
                        ->orderBy("id_video DESC")
                        ->limit(3);
        //die($QUERY01->getSqlQuery());
        $Resultado01 = $QUERY01->execute();
        $this->videos = $Resultado01;
    }

    public function executeAboutagtrials(sfWebRequest $request) {
        
    }

    public function executeAboutccafs(sfWebRequest $request) {
        
    }

    public function executeSearch(sfWebRequest $request) {
        
    }

    public function executeContactagtrials(sfWebRequest $request) {
        $firstname = sfContext::getInstance()->getRequest()->getParameterHolder()->get('firstname');
        $lastname = sfContext::getInstance()->getRequest()->getParameterHolder()->get('lastname');
        $emailaddress = sfContext::getInstance()->getRequest()->getParameterHolder()->get('emailaddress');
        $phonenumber = sfContext::getInstance()->getRequest()->getParameterHolder()->get('phonenumber');
        $country = sfContext::getInstance()->getRequest()->getParameterHolder()->get('country');
        $message = sfContext::getInstance()->getRequest()->getParameterHolder()->get('message');
        $code = sfContext::getInstance()->getRequest()->getParameterHolder()->get('code');

        if (isset($firstname) && isset($lastname) && isset($emailaddress) && isset($message)) {
            $emailaddress = strtolower($emailaddress);
            $sent = date("d-M-Y") . " " . date("h:i:s");
            //ENVIO DE CORREO
            $destinatario = trim("noreplyagtrials@gmail.com");
            $asunto = "New Contact - Trial Sites - Don't reply";
            $cuerpo = "<html>";
            $cuerpo .= "<head>";
            $cuerpo .= "<title>New Contact - Trial Sites - Don't reply</title>";
            $cuerpo .= "</head>";
            $cuerpo .= "<body>";
            $cuerpo .= "<h1>*** New Contact - Trial Sites - Don't reply ***</h1>";
            $cuerpo .= "<p>";
            $cuerpo .= "<b>First name: </b>$firstname<br>";
            $cuerpo .= "<b>Last name: </b>$lastname<br>";
            $cuerpo .= "<b>Email address: </b>$emailaddress<br>";
            $cuerpo .= "<b>Phone number: </b>$phonenumber<br>";
            $cuerpo .= "<b>Country: </b>$country<br>";
            $cuerpo .= "<b>Message: </b>$message<br>";
            $cuerpo .= "<b>Security Code: </b>$code<br><br>";
            $cuerpo .= "<b>Sent: </b>$sent<br>";
            $cuerpo .= "</p>";
            $cuerpo .= "</body>";
            $cuerpo .= "</html>";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
            //die("$destinatario <br><br> $asunto <br><br> $cuerpo <br><br> $headers");
            if (mail($destinatario, $asunto, $cuerpo, $headers)) {
                echo "<script language='JavaScript'>alert('Thank you for contacting Trial Sites. \\n\\n Your e-mail has been received and will be answered as soon as possible.');</script>";
            } else {
                echo "<script> alert('*** Email Error! ***'); window.history.back();</script>";
                die();
            }
        }
    }

    public function executeRegister(sfWebRequest $request) {
        $emailaddress = strtolower($request->getParameter('emailaddress'));
        $firstname = ucwords(strtolower($request->getParameter('firstname')));
        $lastname = ucwords(strtolower($request->getParameter('lastname')));
        $institution = $request->getParameter('institution');
        $country = $request->getParameter('country');
        $city = $request->getParameter('city');
        $state = $request->getParameter('state');
        $address = $request->getParameter('address');
        $telephone = $request->getParameter('telephone');
        $motivation = $request->getParameter('motivation');
        $code = $request->getParameter('code');
        $key = strtoupper(generatecode(15));

        $part_lastname = explode(" ", $lastname);
        $username = strtolower(substr($firstname, 0, 1) . $part_lastname[0]);

        if (($firstname != '') && ($lastname != '') && ($emailaddress != '') && ($username != '') && ($motivation != '') && ($code != '')) {
            $password = @generatecode(6);

            for ($a = 1; $a <= 20; $a++) {
                $GuardUser = Doctrine::getTable('sfGuardUser')->findOneByUsername($username);
                if (count($GuardUser) <= 1) {
                    break;
                }
                $username = $username . $a;
            }
            //die("$username *** $firstname *** $lastname *** $emailaddress *** $password");
            //INFORMACION BASICA
            $sfGuardUser = new sfGuardUser();
            $sfGuardUser->setFirstName($firstname);
            $sfGuardUser->setLastName($lastname);
            $sfGuardUser->setEmailAddress($emailaddress);
            $sfGuardUser->setUsername($username);
            $sfGuardUser->setIsActive(false);
            $sfGuardUser->save();
            //PERMISOS
            $iduser = $sfGuardUser->getId();
            $sfGuardUserPermission = new sfGuardUserPermission();
            $sfGuardUserPermission->setUserId($iduser);
            $sfGuardUserPermission->setPermissionId(2); // Permiso general
            $sfGuardUserPermission->save();

            //GRUPOS
            $sfGuardUserGroup = new sfGuardUserGroup();
            $sfGuardUserGroup->setUserId($iduser);
            $sfGuardUserGroup->setGroupId(1); // Grupo General
            $sfGuardUserGroup->save();

            //INFORMACION COMPLEMENTARIA
            $sfGuardUserInformation = new SfGuardUserInformation();
            $sfGuardUserInformation->setUserId($iduser);
            if ($institution != '')
                $sfGuardUserInformation->setIdInstitution($institution);
            $sfGuardUserInformation->setIdCountry($country);
            $sfGuardUserInformation->setCity($city);
            if ($state != '')
                $sfGuardUserInformation->setState($state);
            $sfGuardUserInformation->setAddress($address);
            $sfGuardUserInformation->setTelephone($telephone);
            $sfGuardUserInformation->setMotivation($motivation);
            $sfGuardUserInformation->setKey($key);
            $sfGuardUserInformation->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
            $sfGuardUserInformation->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
            $sfGuardUserInformation->setVisits(0);
            $sfGuardUserInformation->save();

            if ($institution != '') {
                $TbInstitution = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($institution);
                $NameInstitution = $TbInstitution->getInsname();
            }
            if ($country != '') {
                $TbCountry = Doctrine::getTable('TbCountry')->findOneByIdCountry($country);
                $NameCountry = $TbCountry->getCntname();
            }

            //ENVIO DE CORREO AL USUARIO QUE SE RESGISTRO
            $sent = date("d-M-Y") . " " . date("h:i:s");
            $destinatario = trim($emailaddress);
            $asunto = "Trial Sites Account Notification - User Created - Don't reply";
            $cuerpo = "<html>";
            $cuerpo .= "<head>";
            $cuerpo .= "<title>Account Notification - User Created - Don't reply </title>";
            $cuerpo .= "</head>";
            $cuerpo .= "<body>";
            $cuerpo .= "<h1>Welcome Trial Sites!</h1>";
            $cuerpo .= "<p>";
            $cuerpo .= "<br><b>Thank you for Register, Your account will be activated soon.</b><br><br>";
            $cuerpo .= "<a href='http://www.agtrials.org/login' target='blank'>www.agtrials.org</a><br><br>";
            $cuerpo .= "</p>";
            $cuerpo .= "<br><br><b>Sent:</b> $sent ";
            $cuerpo .= "</body>";
            $cuerpo .= "</html>";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
            if (mail($destinatario, $asunto, $cuerpo, $headers)) {
                echo "<script language='JavaScript'>alert('***Thank you for Register, Your account will be activated soon. Information sent at email: $destinatario ***');</script>";
            } else {
                echo "<script> alert('*** Email Error! ***'); window.history.back();</script>";
                die();
            }

            //ENVIA CORREO A LA PERSONA QUE HABILITA
            $sent = date("d-M-Y") . " " . date("h:i:s");
            $destinatario = trim("a.jarvis@cgiar.org;g.hyman@cgiar.org;andrewfarrow72@gmail.com;h.r.espinosa@cgiar.org");
            $asunto = "Trial Sites Account Notification - Activation New User";
            $cuerpo = "<html>";
            $cuerpo .= "<head>";
            $cuerpo .= "<title>Trial Sites Account Notification - Activation New User</title>";
            $cuerpo .= "</head>";
            $cuerpo .= "<body>";
            $cuerpo .= "<h1>Activation New User!</h1>";
            $cuerpo .= "<p>";
            $cuerpo .= "<b>Username: </b>$username<br>";
            $cuerpo .= "<b>Name: </b>$firstname $lastname<br>";
            $cuerpo .= "<b>Email address: </b>$emailaddress<br>";
            $cuerpo .= "<b>Institution: </b>$NameInstitution<br>";
            $cuerpo .= "<b>Country: </b>$NameCountry<br>";
            $cuerpo .= "<b>City: </b>$city<br>";
            $cuerpo .= "<b>State: </b>$state<br>";
            $cuerpo .= "<b>Address: </b>$address<br>";
            $cuerpo .= "<b>Telephone: </b>$telephone<br>";
            $cuerpo .= "<b>Motivation: </b>$motivation<br><br>";
            $cuerpo .= "<b>Security Code: </b>$code<br><br>";
            $cuerpo .= "<a href='http://www.agtrials.org/guard/users/" . $iduser . "/edit#sf_fieldset_permissions_and_groups' target='blank'><b>Go to activate</b></a><br><br>";
            $cuerpo .= "</p>";
            $cuerpo .= "<b>Sent:</b> $sent ";
            $cuerpo .= "</body>";
            $cuerpo .= "</html>";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
            if (!mail($destinatario, $asunto, $cuerpo, $headers)) {
                echo "<script> alert('*** Email Error! ***'); window.history.back();</script>";
                die();
            }
        }
    }

    public function executeValidacorreo(sfWebRequest $request) {
        $emailaddress = $request->getParameter('emailaddress');
        $emailaddress = strtolower(trim($emailaddress));
        $sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($emailaddress);
        if (count($sfGuardUser) > 1) {
            echo "Email address $emailaddress already exist!";
        } else {
            echo "";
        }
        die();
    }

    public function executeRefreshcode(sfWebRequest $request) {
        die(@generatecode(6));
    }

    public function executeMoreoptions(sfWebRequest $request) {
        
    }

    public function executeGeoRSS(sfWebRequest $request) {
        $view = $request->getParameter('view');
        $limit = 0;
        if ($view == 'all')
            $limit = 100000000;
        else if (intval($view))
            $limit = $view;
        else
            $limit = 100;

        $QUERY00 = Doctrine_Query::create()
                        ->select("TG.trgrname AS trialgroup, (CP.cnprfirstname||' '||CP.cnprlastname) AS contactperson, CN.cntname AS country, TS.trstname AS trialsite, CR.crpname AS cropanimal, (TS.trstlatitudedecimal||' '||TS.trstlongitudedecimal) AS georsspoint, T.*")
                        ->from("TbTrial T")
                        ->innerJoin("T.TbTrialgroup TG")
                        ->innerJoin("T.TbContactperson CP")
                        ->innerJoin("T.TbCountry CN")
                        ->innerJoin("T.TbTrialsite TS")
                        ->innerJoin("T.TbCrop CR")
                        ->orderBy("T.created_at DESC")
                        ->limit($limit);
        //die($QUERY00->getSqlQuery());
        $Resultado00 = $QUERY00->execute();
        $this->feed = $Resultado00;
        $this->setLayout(false);
    }

    public function executeBlog(sfWebRequest $request) {
        
    }

    public function executeAgTrialsBlogRSS(sfWebRequest $request) {
        $conexion = connectionblog();
        $sql = mysql_query("SELECT P.id,P.post_title,P.post_date,P.guid,P.post_parent,P.post_content,U.user_nicename FROM wp_posts P JOIN wp_users U ON P.post_author = U.id WHERE P.post_status = 'publish' AND P.post_type = 'post' ORDER BY P.post_date DESC LIMIT 10", $conexion);
        while ($row = mysql_fetch_array($sql)) {
            $sql2 = mysql_query("SELECT guid FROM wp_posts WHERE post_type = 'attachment' AND post_parent = {$row["id"]}", $conexion);
            $image = "";
            while ($row2 = mysql_fetch_array($sql2)) {
                $image = $row2["guid"];
            }
            $lastpost[] = array("id" => $row["id"], "post_title" => $row["post_title"], "post_date" => $row["post_date"], "guid" => $row["guid"], "image" => $image, "post_content" => utf8_encode($row["post_content"]), "user" => $row["user_nicename"]);
        }
        mysql_free_result($sql);
        mysql_close($conexion);
        $this->feedblog = $lastpost;
        $this->setLayout(false);
    }

    public function executeStatistics(sfWebRequest $request) {
        $connection = Doctrine_Manager::getInstance()->connection();
        $WebDir = sfConfig::get("sf_web_dir");

        //EJECUCION CONSULTA TRIALS BY CROP
        $QUERY01 = "SELECT cr.crpname, COUNT(T.id_trial) AS trials ";
        $QUERY01 .= "FROM tb_trial T ";
        $QUERY01 .= "INNER JOIN tb_crop cr ON T.id_crop = cr.id_crop ";
        $QUERY01 .= "GROUP BY cr.crpname ";
        $QUERY01 .= "ORDER BY COUNT(T.id_trial) DESC";
        $st = $connection->execute($QUERY01);
        $this->trialxtechnology = $st->fetchAll();

        //EJECUCION CONSULTA TRIALS BY COUNTRY
        $QUERY02 = "SELECT C.cntname, COUNT(T.id_trial) AS trials ";
        $QUERY02 .= "FROM tb_trial T ";
        $QUERY02 .= "INNER JOIN tb_country C ON T.id_country = C.id_country ";
        $QUERY02 .= "GROUP BY C.cntname ";
        $QUERY02 .= "ORDER BY COUNT(T.id_trial) DESC";
        $st = $connection->execute($QUERY02);
        $this->trialxcountry = $st->fetchAll();

        //EJECUCION CONSULTA TRIALS BY INSTITUTION
        $QUERY03 = "SELECT INS.insname, COUNT(T.id_trial) AS trials ";
        $QUERY03 .= "FROM tb_trial T ";
        $QUERY03 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
        $QUERY03 .= "INNER JOIN tb_institution INS ON TS.id_institution = INS.id_institution ";
        $QUERY03 .= "GROUP BY INS.insname ";
        $QUERY03 .= "ORDER BY COUNT(T.id_trial) DESC";
        $st = $connection->execute($QUERY03);
        $this->trialxinstitution = $st->fetchAll();

        //EJECUCION CONSULTA TRIALS BY TRIAL GROUP
        $QUERY04 = "SELECT TG.trgrname, COUNT(T.id_trial) ";
        $QUERY04 .= "FROM tb_trial T ";
        $QUERY04 .= "INNER JOIN tb_trialgroup TG ON T.id_trialgroup = TG.id_trialgroup ";
        $QUERY04 .= "GROUP BY TG.trgrname ";
        $QUERY04 .= "ORDER BY COUNT(T.id_trial) DESC";
        $st = $connection->execute($QUERY04);
        $this->trialxtrialgroup = $st->fetchAll();

        //EJECUCION CONSULTA TRIALS BY TRIAL SITES
        $QUERY05 = "SELECT (TS.trstname||'-'||CN.cntname) AS trstname, COUNT(T.id_trial) ";
        $QUERY05 .= "FROM tb_trial T ";
        $QUERY05 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
        $QUERY05 .= "INNER JOIN tb_country CN ON TS.id_country = CN.id_country ";
        $QUERY05 .= "GROUP BY TS.trstname, CN.cntname ";
        $QUERY05 .= "ORDER BY COUNT(T.id_trial) DESC ";
        $st = $connection->execute($QUERY05);
        $this->trialxtrialsite = $st->fetchAll();
    }

    public function executeTest(sfWebRequest $request) {
        $this->setLayout(FALSE);

//        $sent = date("d-M-Y") . " " . date("h:i:s");
//        $destinatario = trim("herlin25@gmail.com");
//        $asunto = "PRUEBAS";
//        $cuerpo = "<html>";
//        $cuerpo .= "<head>";
//        $cuerpo .= "<title>PRUEBAS</title>";
//        $cuerpo .= "<b>Sent:</b> $sent ";
//        $cuerpo .= "</body>";
//        $cuerpo .= "</html>";
//        $headers = "MIME-Version: 1.0\r\n";
//        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
//        $headers .= "From: Trial Sites - Don't reply <noreplyagtrials@gmail.com>\r\n";
//        mail("herlin25@gmail.com","asuntillo","Este es el cuerpo del mensaje") ;
//        //mail($destinatario, $asunto, $cuerpo, $headers);
//        die("Enviado....");
//
//
//
//
//
//        $conexion = pg_connect("host=localhost port=5432 dbname=trialsites user=app_agtrials password=65*Tri8*ALs68");
//        //$arr_crop = array(1 => 'Cassava', 2 => 'Chickpea', 4 => 'Cowpea', 9 => 'Groundnut', 11 => 'Maize', 47 => 'Musa', 5 => 'Potato', 14 => 'Rice', 8 => 'Sorghum', 12 => 'Wheat');
//        $arr_crop = array(11 => 'Maize');
//
//        foreach ($arr_crop as $key => $value) {
//            $traits = new traits($value);
//            $Arr_Datos = $traits->get();
//            echo "<br><b>Crop: $value </b><br>";
//            foreach ($Arr_Datos AS $Arr_Datos_Trait) {
//                if (count($Arr_Datos_Trait) > 0) {
//                    foreach ($Arr_Datos_Trait AS $Arr_Trait) {
//                        $ArrTraitName = json_decode($Arr_Trait->name);
//                        if (count($ArrTraitName) > 0)
//                            $TraitName = ucfirst(strtolower($ArrTraitName->english));
//                        else
//                            $TraitName = ucfirst(strtolower($Arr_Trait->name));
//                        $Trait_children = $Arr_Trait->children;
//                        echo "<br><br>******** Trait Class: $TraitName ********<br>";
//                        if (count($Trait_children) > 0) {
//                            foreach ($Trait_children AS $Children) {
//                                $idtrait = $Children->id;
//                                $nametrait = json_decode($Children->name);
//                                $NumNameTrait = count($nametrait);
//                                if ($NumNameTrait > 0)
//                                    $NameTrait = ucfirst(strtolower($nametrait->english));
//                                else
//                                    $NameTrait = ucfirst(strtolower($Children->name));
//                                $nametrait = str_replace("'", "''", $NameTrait);
//                                $resultado = pg_query($conexion, "SELECT id_variablesmeasured FROM tb_variablesmeasured WHERE id_crop = $key AND UPPER(vrmsname) = '$NameTrait'");
//                                if (pg_num_rows($resultado) == 0) {
//                                    $url = "http://www.cropontology.org/get-attributes/$idtrait";
//                                    $data = file_get_contents($url);
//                                    $data_array = json_decode($data);
//                                    $name = "";
//                                    $synonym = "";
//                                    $definition = "";
//                                    $method = "";
//                                    $unit = "";
//                                    foreach ($data_array AS $datas) {
//                                        if ($datas->key == 'name') {
//                                            $tmpname = $datas->value;
//                                            $ArrName = json_decode($tmpname);
//                                            if (count($ArrName) > 0)
//                                                $name = ucfirst(strtolower($ArrName->english));
//                                            else
//                                                $name = ucfirst(strtolower($tmpname));
//                                        }
//                                        if ($datas->key == 'synonym') {
//                                            $tmpsynonym = $datas->value;
//                                            $ArrSynonym = json_decode($tmpsynonym);
//                                            if (count($ArrSynonym) > 0)
//                                                $synonym = ucfirst(strtolower($ArrSynonym->english));
//                                            else
//                                                $synonym = ucfirst(strtolower($tmpsynonym));
//                                        }
//                                        if ($datas->key == 'def') {
//                                            $tmpdefinition = $datas->value;
//                                            $ArrDefinition = json_decode($tmpdefinition);
//                                            if (count($ArrDefinition) > 0)
//                                                $definition = ucfirst(strtolower($ArrDefinition->english));
//                                            else
//                                                $definition = ucfirst(strtolower($tmpdefinition));
//                                        }
//                                    }
//
//                                    //AQUI VERIFICAMOS LOS HIJO A VER SI TIENE METODO
//                                    $url = "http://www.cropontology.org/get-children/$idtrait";
//                                    $data = file_get_contents($url);
//                                    $ChildrenTrait = json_decode($data);
//                                    if (count($ChildrenTrait) > 0) {
//                                        $IdMethod = $ChildrenTrait[0]->id;
//                                        $url = "http://www.cropontology.org/get-attributes/$IdMethod";
//                                        $data = file_get_contents($url);
//                                        $MethodAttributes = json_decode($data);
//                                        if (count($MethodAttributes) > 0) {
//                                            foreach ($MethodAttributes AS $Method) {
//                                                if ($Method->key == 'Method') {
//                                                    $ArrMethod = json_decode($Method->value);
//                                                    if (count($ArrMethod) > 0)
//                                                        $method = ucfirst(strtolower($ArrMethod->english));
//                                                    else
//                                                        $method = ucfirst(strtolower($Method->value));
//                                                }
//                                            }
//
//                                            //AQUI VERIFICAMOS LOS HIJO A VER SI TIENE UNIDADES
//                                            $url = "http://www.cropontology.org/get-children/$IdMethod";
//                                            $data = file_get_contents($url);
//                                            $ChildrenTrait2 = json_decode($data);
//                                            if (count($ChildrenTrait2) > 0) {
//                                                $IdUnit = $ChildrenTrait2[0]->id;
//                                                $url = "http://www.cropontology.org/get-attributes/$IdUnit";
//                                                $data = file_get_contents($url);
//                                                $UnitAttributes = json_decode($data);
//                                                if (count($UnitAttributes) > 0) {
//                                                    foreach ($UnitAttributes AS $Unit) {
//                                                        if ($Unit->key == 'name') {
//                                                            $ArrUnit = json_decode($Unit->value);
//                                                            if (count($ArrUnit) > 0)
//                                                                $unit = ucfirst(strtolower($ArrUnit->english));
//                                                            else
//                                                                $unit = ucfirst(strtolower($Unit->value));
//                                                        }
//                                                    }
//                                                }
//                                            }
//                                        }
//                                    }
//
//                                    echo "ID: $idtrait <br>";
//                                    echo "NAM: $name <br>";
//                                    echo "SYN: $synonym <br>";
//                                    echo "DEF: $definition <br>";
//                                    echo "MET: $method <br>";
//                                    echo "UNI: $unit <br><br>";
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
//        die("Final");
    }

}

