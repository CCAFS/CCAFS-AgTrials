<?php

function select_from_table($name, $table, $idfield, $namefield, $wheretable = '', $value = null, $properties = null) {
    if ($wheretable == '')
        $wheretable = 'true';
    $QUERY00 = Doctrine_Query::create()
            ->select("$idfield AS id, ($namefield) AS name")
            ->from("$table")
            ->where("$wheretable")
            ->orderBy("$namefield");
//echo $QUERY00->getSqlQuery();
    $Resultado00 = $QUERY00->execute();
    $OPTION = "<OPTION VALUE=''>Choose...</OPTION>";
    foreach ($Resultado00 AS $fila) {
        $titulo = $fila['name'];
        $valor = $fila['name'];
        if (strlen($valor) > 35)
            $valor = substr($valor, 0, 35) . "...";
        $selected = "";
        if ($fila['id'] == $value)
            $selected = "selected";
        $OPTION .= "<OPTION TITLE='$titulo' VALUE='{$fila['id']}' $selected>$valor</OPTION>";
    }
    $HTML = "<SELECT NAME='$name' id='$name' SIZE='1' $properties>";
    $HTML .= $OPTION;
    $HTML .= "</SELECT>";
    return $HTML;
}

function select_from_table_trial($name, $table, $idfield, $namefield, $wheretable = '', $value = null, $properties = null) {
    $WhereList = sfContext::getInstance()->getUser()->getAttribute('WhereList');
    $WhereVariety = sfContext::getInstance()->getUser()->getAttribute('WhereVariety');
    $WhereListVariablesMeasured = sfContext::getInstance()->getUser()->getAttribute('WhereListVariablesMeasured');
    $WhereList .= $WhereVariety . $WhereListVariablesMeasured;

    if ($wheretable == '')
        $wheretable = 'true';

    $connection = Doctrine_Manager::getInstance()->connection();

    $QUERY = "SELECT T1.$idfield AS id,$namefield AS name ";
    $QUERY .= "FROM $table T1 ";
    $QUERY .= "INNER JOIN tb_trial T2 ON T1.$idfield = T2.$idfield ";
    if (strpos($WhereList, "AND TV.id_variety IN"))
        $QUERY .= "INNER JOIN tb_trialvariety TV ON T2.id_trial = TV.id_trial ";
    if (strpos($WhereList, "AND TVM.id_variablesmeasured IN"))
        $QUERY .= "INNER JOIN tb_trialvariablesmeasured TVM ON T2.id_trial = TVM.id_trial ";
    $QUERY .= "WHERE TRUE $WhereList ";
    $QUERY .= "GROUP BY T1.$idfield,$namefield ";
    $QUERY .= "ORDER BY $namefield";
    $st = $connection->execute($QUERY);
    $R_datos = $st->fetchAll();
    $OPTION = "<OPTION VALUE=''>Choose...</OPTION>";
    foreach ($R_datos AS $fila) {
        $titulo = $fila['name'];
        $valor = $fila['name'];
        if (strlen($valor) > 50)
            $valor = substr($valor, 0, 50) . "...";
        $selected = "";
        if ($fila['id'] == $value)
            $selected = "selected";
        $OPTION .= "<OPTION TITLE='$titulo' VALUE='{$fila['id']}' $selected>$valor</OPTION>";
    }

    $HTML = "<SELECT NAME='$name' id='$name' SIZE='1' $properties>";
    $HTML .= $OPTION;
    $HTML .= "</SELECT>";
    return $HTML;
}

function select_from_table_ReloadField($name, $table, $idfield, $namefield, $wheretable = '', $value = null, $properties = null) {
    $connection = Doctrine_Manager::getInstance()->connection();
    $QUERY = "SELECT T1.$idfield AS id,$namefield AS name ";
    $QUERY .= "FROM $table T1 ";
    $QUERY .= "INNER JOIN tb_trial T2 ON T1.$idfield = T2.$idfield ";
    if (strpos($wheretable, "AND TV.id_variety IN"))
        $QUERY .= "INNER JOIN tb_trialvariety TV ON T2.id_trial = TV.id_trial ";
    if (strpos($wheretable, "AND TVM.id_variablesmeasured IN"))
        $QUERY .= "INNER JOIN tb_trialvariablesmeasured TVM ON T2.id_trial = TVM.id_trial ";
    $QUERY .= "WHERE TRUE $wheretable ";
    $QUERY .= "GROUP BY T1.$idfield,$namefield ";
    $QUERY .= "ORDER BY $namefield";
    $st = $connection->execute($QUERY);
    $R_datos = $st->fetchAll();
    $HTML = "";
    $OPTION = "<OPTION VALUE=''>Choose...</OPTION>";
    foreach ($R_datos AS $fila) {
        $titulo = $fila['name'];
        $valor = $fila['name'];
        if (strlen($valor) > 50)
            $valor = substr($valor, 0, 50) . "...";
        $selected = "";
        if ($fila['id'] == $value)
            $selected = "selected";
        $OPTION .= "<OPTION TITLE='$titulo' VALUE='{$fila['id']}' $selected>$valor</OPTION>";
    }
    $HTML = $OPTION;
    return $HTML;
}

function select_from_table_TrialSite($name, $wheretable = '', $value = null, $properties = null) {
    if ($wheretable == '')
        $wheretable = 'true';
    $connection = Doctrine_Manager::getInstance()->connection();
    $QUERY = "SELECT TS.id_trialsite AS id, (TS.trstname||' - '||CN.cntname||' ('||fc_counttrials_trialsite(TS.id_trialsite)||')') AS name ";
    $QUERY .= "FROM tb_trialsite TS ";
    $QUERY .= "LEFT JOIN tb_country CN ON TS.id_country = CN.id_country ";
    $QUERY .= "WHERE fc_counttrials_trialsite(TS.id_trialsite) > 0 ";
    $QUERY .= "AND trstactive = 'TRUE'";
    $QUERY .= "ORDER BY TS.trstname,CN.cntname";
    $st = $connection->execute($QUERY);
    $R_datos = $st->fetchAll();
    $OPTION = "<OPTION VALUE=''>Choose...</OPTION>";
    foreach ($R_datos AS $fila) {
        $titulo = $fila['name'];
        $valor = $fila['name'];
        if (strlen($valor) > 50)
            $valor = substr($valor, 0, 50) . "...";
        $selected = "";
        if ($fila['id'] == $value)
            $selected = "selected";
        $OPTION .= "<OPTION TITLE='$titulo' VALUE='{$fila['id']}' $selected>$valor</OPTION>";
    }

    $HTML = "<SELECT NAME='$name' id='$name' SIZE='1' $properties>";
    $HTML .= $OPTION;
    $HTML .= "</SELECT>";
    return $HTML;
}

function select_from_table_module() {
    $connection = Doctrine_Manager::getInstance()->connection();
    $QUERY = "SELECT flmdhlmodule AS name FROM tb_fieldmodulehelp GROUP BY flmdhlmodule ORDER BY flmdhlmodule";
    $st = $connection->execute($QUERY);
    $R_datos = $st->fetchAll();
    $OPTION = "<OPTION VALUE=''>Choose...</OPTION>";
    foreach ($R_datos AS $fila) {
        $OPTION .= "<OPTION TITLE='{$fila['name']}' VALUE='{$fila['name']}'>{$fila['name']}</OPTION>";
    }

    $HTML = "<SELECT NAME='flmdhlmodule' id='flmdhlmodule' SIZE='1' $properties>";
    $HTML .= $OPTION;
    $HTML .= "</SELECT>";
    return $HTML;
}

function YearsYeatherstation($id_weatherstation) {
    $connection = Doctrine_Manager::getInstance()->connection();
    $QUERY = "SELECT fc_years_weatherstation($id_weatherstation) AS data; ";
    $st = $connection->execute($QUERY);
    $R_datos = $st->fetchAll();
    $return = "";
    if (count($R_datos) > 0) {
        foreach ($R_datos AS $fila) {
            $return = $fila['data'];
        }
    }
    return $return;
}

function MeteorologicalfieldsWeatherstation($id_weatherstation) {
    $connection = Doctrine_Manager::getInstance()->connection();
    $QUERY = "SELECT fc_meteorologicalfields_weatherstation($id_weatherstation) AS data; ";
    $st = $connection->execute($QUERY);
    $R_datos = $st->fetchAll();
    $return = "";
    if (count($R_datos) > 0) {
        foreach ($R_datos AS $fila) {
            $return = $fila['data'];
        }
    }
    return $return;
}

function MoveFile($UploadDir, $TmpUploadDir, $File) {
    $arr_extension = array('xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'zip', 'rar');

    $FileOrig = "";
    $ReturnFile = "";
    foreach ($arr_extension AS $extension) {
        $TmpFile = $TmpUploadDir . '/' . $File . '.' . $extension;
        if (is_file($TmpFile)) {
            $FileOrig = $File . '.' . $extension;
            $ReturnFile = encryptfile($FileOrig);
            copy($TmpUploadDir . "/" . $FileOrig, $UploadDir . "/" . $ReturnFile);
            break;
        }
    }
    return $ReturnFile;
}

function getTable($table, $fieldname, $fieldid, $value) {
    $QUERY00 = Doctrine_Query::create()
            ->select("$fieldname AS value")
            ->from("$table")
            ->where("$fieldid = $value");
    $Resultado00 = $QUERY00->execute();
    foreach ($Resultado00 AS $fila) {
        $value = $fila['value'];
    }
    return $value;
}

function generatecode($lenght = 6) {
    $cadena = "[^A-Z0-9]";
    $code = substr(@eregi_replace($cadena, "", md5(rand())) . @eregi_replace($cadena, "", md5(rand())) . @eregi_replace($cadena, "", md5(rand())), 0, $lenght);
    return $code;
}

function LatitudeSexagesimal($trstlatitudedecimal) {
    $trstlatitude = null;
    if (is_numeric($trstlatitudedecimal)) {
        $cardinal = 'N';
        if ($trstlatitudedecimal < 0) {
            $cardinal = 'S';
            $latitudedecimal = $trstlatitudedecimal * -1;
        } else {
            $latitudedecimal = $trstlatitudedecimal;
        }
        $degree = intval($latitudedecimal);
        $temp = ($latitudedecimal - $degree);
        $temp = ($temp * 60);
        $minutes = intval($temp);
        $temp = ($temp - $minutes);
        $seconds = intval(($temp * 60));

        $degree = $degree . "";
        if (strlen($degree) == 1)
            $degree = "0" . $degree;
        $minutes = $minutes . "";
        if (strlen($minutes) == 1)
            $minutes = "0" . $minutes;
        $seconds = $seconds . "";
        if (strlen($seconds) == 1)
            $seconds = "0" . $seconds;

        $trstlatitude = $degree . $minutes . $seconds . $cardinal;
    }
    return $trstlatitude;
}

function LongitudeSexagesimal($trstlongitudedecimal) {
    $trstlongitude = null;
    if (is_numeric($trstlongitudedecimal)) {
        $cardinal = 'W';
        if ($trstlongitudedecimal < 0) {
            $cardinal = 'E';
            $longitudedecimal = $trstlongitudedecimal * -1;
        } else {
            $longitudedecimal = $trstlongitudedecimal;
        }
        $degree = intval($longitudedecimal);
        $temp = ($longitudedecimal - $degree);
        $temp = ($temp * 60);
        $minutes = intval($temp);
        $temp = ($temp - $minutes);
        $seconds = intval(($temp * 60));

        $degree = $degree . "";
        if (strlen($degree) == 1)
            $degree = "00" . $degree;
        if (strlen($degree) == 2)
            $degree = "0" . $degree;
        $minutes = $minutes . "";
        if (strlen($minutes) == 1)
            $minutes = "0" . $minutes;
        $seconds = $seconds . "";
        if (strlen($seconds) == 1)
            $seconds = "0" . $seconds;

        $trstlongitude = $degree . $minutes . $seconds . $cardinal;
    }
    return $trstlongitude;
}

function datecheck($input, $format = "") {
    $separator_type = array(
        "/",
        "-",
        "."
    );
    foreach ($separator_type as $separator) {
        $find = stripos($input, $separator);
        if ($find <> false) {
            $separator_used = $separator;
        }
    }
    $input_array = explode($separator_used, $input);
    if ($format == "mdy") {
        return checkdate($input_array[0], $input_array[1], $input_array[2]); //mmddyyy
    } elseif ($format == "ymd") {
        return checkdate($input_array[1], $input_array[2], $input_array[0]);
    } else {
        return checkdate($input_array[1], $input_array[0], $input_array[2]);
    }
    $input_array = array();
}

function PermissionChangeTrial($id_user, $id_trial) {
    $Return = false;
    $TbTrial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
    $id_trialgroup = $TbTrial->getIdTrialgroup();
    $sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneById($id_user);
    $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByCnpremail($sfGuardUser->getEmailAddress());
    $id_contactperson = $TbContactperson->getIdContactperson();

    $QUERY00 = Doctrine_Query::create()
            ->select("T.*")
            ->from("TbTrialgroupcontactperson T")
            ->where("T.id_trialgroup = $id_trialgroup")
            ->andWhere("T.id_contactperson = $id_contactperson");
    $Resultado00 = $QUERY00->execute();
    if (count($Resultado00) > 0) {
        $Return = true;
    }
    return $Return;
}

function PermissionChangeTrialGroup($id_user, $id_trialgroup) {
    $Return = false;
    $sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneById($id_user);
    $TbContactperson = Doctrine::getTable('TbContactperson')->findOneByCnpremail($sfGuardUser->getEmailAddress());
    $id_contactperson = $TbContactperson->getIdContactperson();

    $QUERY00 = Doctrine_Query::create()
            ->select("T.*")
            ->from("TbTrialgroupcontactperson T")
            ->where("T.id_trialgroup = $id_trialgroup")
            ->andWhere("T.id_contactperson = $id_contactperson");
    $Resultado00 = $QUERY00->execute();
    if (count($Resultado00) > 0) {
        $Return = true;
    }
    return $Return;
}

function CheckUserPermission($id_user, $permissions) {
    $Return = false;
    $Arr_Permission = explode(",", $permissions);
    $SfGuardUserPermission = Doctrine::getTable('SfGuardUserPermission')->findByUserId($id_user);
    foreach ($SfGuardUserPermission AS $Permission) {
        foreach ($Arr_Permission AS $id_permission) {
            if ($Permission->permission_id == $id_permission) {
                $Return = true;
                break;
            }
        }
    }
    return $Return;
}

function array_sort($array, $on, $order = SORT_ASC) {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

class traits {

    var $url = 'http://www.cropontology.org';

    function get_children($parent_id) {
        $parent_id = trim($parent_id);
        $get_children = file_get_contents($this->url . '/get-children/' . $parent_id);
        $children = json_decode($get_children);
        if (count($children) > 0) {
            foreach ($children as $child) {
                if ($child->has_children > 0) {
                    $child->children = $this->get_children($child->id);
                }
            }
        }
        return $children;
    }

    function traits($crop) {
        $this->crop = $crop;
    }

    function get() {
        $ontology_id = file_get_contents($this->url . '/get-ontology-id?ontology_name=' . $this->crop);
        $ontology_roots = file_get_contents($this->url . '/get-ontology-roots/' . trim($ontology_id));
        $onto_roots = json_decode($ontology_roots);
        $arr = array();
        foreach ($onto_roots as $onto) {
            $arr[$onto->name] = $this->get_children($onto->id);
        }
        return $arr;
    }

}

function DeleteFusionTable($id_trial) {
    /* $ft = new FusionTable();
      $Rowid = null;
      $Resultado = $ft->query("SELECT ROWID  FROM 1596286 WHERE id_trial = $id_trial");
      $count = count($Resultado);
      if ($count > 0) {
      $Rowid = $Resultado[0]['rowid'];
      if ($Rowid != '') {
      $ft->query("DELETE FROM 1596286 WHERE ROWID = '$Rowid'");
      }
      } */
}

function SaveFusionTable($id_trial) {
    /* $connection = Doctrine_Manager::getInstance()->connection();
      $Query00 = "SELECT T.id_trialsite,CP.id_contactperson,NULL,INS.id_institution,CN.id_country,TS.trstname,";
      $Query00 .= "TS.trstlatitudedecimal,TS.trstlongitudedecimal,TS.trstaltitude,TS.trstph,TS.trststatus,CN.cntname,CN.cntiso,CN.cntiso3,NULL,INS.insname,";
      $Query00 .= "INS.insaddress,INS.insphone,CP.cnprfirstname,CP.cnprlastname,CP.cnpraddress,CP.cnprphone,CP.cnpremail,CP.cnprfirstname||''||CP.cnprlastname,";
      $Query00 .= "T.id_trial,T.id_trialgroup,T.id_crop,NULL,T.trlname,T.trlsowdate,T.trlharvestdate,T.trltrialresultsfileaccess,";
      $Query00 .= "NULL,T.trltrialrecorddate,T.trltrialtype,TG.trgrname,TG.trgrstartyear,TG.trgrendyear,CR.crpname,CR.crpscientificname ";
      $Query00 .= "FROM tb_trial T ";
      $Query00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
      $Query00 .= "INNER JOIN tb_contactperson CP ON T.id_contactperson = CP.id_contactperson ";
      $Query00 .= "INNER JOIN tb_institution INS ON CP.id_institution = INS.id_institution ";
      $Query00 .= "INNER JOIN tb_country CN ON T.id_country = CN.id_country ";
      $Query00 .= "INNER JOIN tb_crop CR ON T.id_crop = CR.id_crop ";
      $Query00 .= "INNER JOIN tb_trialgroup TG ON T.id_trialgroup = TG.id_trialgroup ";
      $Query00 .= "WHERE T.id_trial = $id_trial";
      $st = $connection->execute($Query00);
      $R_datos = $st->fetchAll();
      $NumDatos = count($R_datos);
      if ($NumDatos > 0) {

      //VERIFICAMOS SI YA EXISTE; SI ES ASI LO BORRAMOS
      DeleteFusionTable($id_trial);

      //ASIGNACION DE VALORES
      $V_id_trialsite = $R_datos[0][0];
      $V_id_contactperson = $R_datos[0][1];
      $V_id_location = $R_datos[0][2];
      $V_id_institution = $R_datos[0][3];
      $V_id_country = $R_datos[0][4];
      $V_trstname = $R_datos[0][5];
      $V_lat = $R_datos[0][6];
      $V_long = $R_datos[0][7];
      $V_trstaltitude = $R_datos[0][8];
      $V_trstph = $R_datos[0][9];
      $V_trststatus = $R_datos[0][10];
      $V_cntname = $R_datos[0][11];
      $V_cntiso = $R_datos[0][12];
      $V_cntiso3 = $R_datos[0][13];
      $V_lctname = $R_datos[0][14];
      $V_insname = $R_datos[0][15];
      $V_insaddress = $R_datos[0][16];
      $V_insphone = $R_datos[0][17];
      $V_cnprfirstname = $R_datos[0][18];
      $V_cnprlastname = $R_datos[0][19];
      $V_cnpraddress = $R_datos[0][20];
      $V_cnprphone = $R_datos[0][21];
      $V_cnpremail = $R_datos[0][22];
      $V_ctprtpname = $R_datos[0][23];
      $V_id_trial = $R_datos[0][24];
      $V_id_trialgroup = $R_datos[0][25];
      $V_id_crop = $R_datos[0][26];
      $V_trlvarieties = $R_datos[0][27];
      $V_trlname = $R_datos[0][28];
      $V_trlsowdate = $R_datos[0][29];
      $V_trlharvestdate = $R_datos[0][30];
      $V_trltrialresultsfileaccess = $R_datos[0][31];
      $V_trlvariablesmeasured = $R_datos[0][32];
      $V_trltrialrecorddate = $R_datos[0][33];
      $V_trltrialtype = $R_datos[0][34];
      $V_trgrname = $R_datos[0][35];
      $V_trgrstartyear = $R_datos[0][36];
      $V_trgrendyear = $R_datos[0][37];
      $V_crpname = $R_datos[0][38];
      $V_crpscientificname = $R_datos[0][39];

      $V_insaddress = str_replace(",", "-", $V_insaddress);
      $V_cnpraddress = str_replace(",", "-", $V_cnpraddress);
      $V_crpname = str_replace(",", "-", $V_crpname);
      $V_crpscientificname = str_replace(",", "-", $V_crpscientificname);

      $ft = new FusionTable();
      $Tabla = 1596286;
      $Campos = "id_trialsite,id_contactperson,id_location,id_institution,id_country,trstname,lat,long,trstaltitude,trstph,trststatus,cntname,cntiso,cntiso3,lctname,insname,insaddress,insphone,cnprfirstname,cnprlastname,cnpraddress,cnprphone,cnpremail,ctprtpname,id_trial,id_trialgroup,id_crop,trlvarieties,trlname,trlsowdate,trlharvestdate,trltrialresultsfileaccess,trlvariablesmeasured,trltrialrecorddate,trltrialtype,trgrname,trgrstartyear,trgrendyear,crpname,crpscientificname";
      $Valores = "'$V_id_trialsite','$V_id_contactperson','$V_id_location','$V_id_institution','$V_id_country','$V_trstname','$V_lat','$V_long','$V_trstaltitude','$V_trstph','$V_trststatus','$V_cntname','$V_cntiso','$V_cntiso3','$V_lctname','$V_insname','$V_insaddress','$V_insphone','$V_cnprfirstname','$V_cnprlastname','$V_cnpraddress','$V_cnprphone','$V_cnpremail','$V_ctprtpname','$V_id_trial','$V_id_trialgroup','$V_id_crop','$V_trlvarieties','$V_trlname','$V_trlsowdate','$V_trlharvestdate','$V_trltrialresultsfileaccess','$V_trlvariablesmeasured','$V_trltrialrecorddate','$V_trltrialtype','$V_trgrname','$V_trgrstartyear','$V_trgrendyear','$V_crpname','$V_crpscientificname'";
      $Query = "INSERT INTO $Tabla ($Campos) VALUES ($Valores)";
      $ft->query($Query);
      } */
}

function GetPermissionsUser($id_user) {
    $Permissions = "";
    $SfGuardUserPermission = Doctrine::getTable('SfGuardUserPermission')->findByUserId($id_user);
    foreach ($SfGuardUserPermission AS $Permission) {
        $SfGuardPermission = Doctrine::getTable('SfGuardPermission')->findOneById($Permission->permission_id);
        $Permissions .= $SfGuardPermission->getName() . " - ";
    }
    $Permissions = substr($Permissions, 0, strlen($Permissions) - 2);
    return $Permissions;
}

function GetGroupsUser($id_user) {
    $Groups = "";
    $SfGuardUserGroup = Doctrine::getTable('SfGuardUserGroup')->findByUserId($id_user);
    foreach ($SfGuardUserGroup AS $Group) {
        $SfGuardGroup = Doctrine::getTable('SfGuardGroup')->findOneById($Group->group_id);
        $Groups .= $SfGuardGroup->getName() . " - ";
    }
    $Groups = substr($Groups, 0, strlen($Groups) - 2);
    return $Groups;
}

function NotInArray($array1, $array2) {
    $list = "";
    foreach ($array1 AS $data) {
        $data = trim($data);
        if (!in_array($data, $array2))
            $list .= ucfirst(strtolower($data)) . ", ";
    }
    if (strlen($list) > 2)
        $list = substr($list, 0, strlen($list) - 2);
    return $list;
}

//CLASES

class FusionTable {

    function FusionTable() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = array('accountType' => 'GOOGLE',
            'Email' => "noreplyagtrials@gmail.com",
            'Passwd' => "application2011",
            'source' => 'TheDataStewards-DataSyncr-1.05',
            'service' => "fusiontables");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $token = preg_replace("/[\s\S]*Auth=/", "", $response);
        if (!$token) {
            throw new Exception("You must provide a token when creating a new FusionTable.");
        }
        $this->token = $token;
    }

    function query($query) {
        if (!$query) {
            throw new Exception("query method requires a query.");
        }
// Check to see if we have a query that will retrieve data
        if (preg_match("/^select|^show tables|^describe/i", $query)) {
            $request_url = "http://tables.googlelabs.com/api/query?sql=" . urlencode($query);
            $c = curl_init($request_url);
            curl_setopt($c, CURLOPT_HTTPHEADER, array("Authorization:GoogleLogin auth=" . $this->token));
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

// Place the lines of the output into an array
            $results = preg_split("/\n/", curl_exec($c));

// If we got an error, raise it
            if (curl_getinfo($c, CURLINFO_HTTP_CODE) != 200) {
                return $this->output_error($results);
            }

// Drop the last (empty) array value
            array_pop($results);

// Parse the output
            return $this->parse_output($results);
        }
// Otherwise we are going to be updating the table, so we need to the POST method 
        else if (preg_match("/^update|^delete|^insert/i", $query)) {
// Set up the cURL
            $body = "sql=" . urlencode($query);
            $c = curl_init("http://tables.googlelabs.com/api/query");
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_HTTPHEADER, array(
                "Content-length: " . strlen($body),
                "Content-type: application/x-www-form-urlencoded",
                "Authorization: GoogleLogin auth=" . $this->token . " "));
            curl_setopt($c, CURLOPT_POSTFIELDS, $body);

// Place the lines of the output into an array
            $results = preg_split("/\n/", curl_exec($c));

// If we got an error, raise it
            if (curl_getinfo($c, CURLINFO_HTTP_CODE) != 200) {
                return $this->output_error($results);
            }

// Drop the last (empty) array value
            array_pop($results);

            return $this->parse_output($results);
        } else {
            throw new Exception("Unknown SQL query submitted.");
        }
    }

    private function parse_output($results) {
        $headers = false;
        $output = array();
        foreach ($results as $row) {
// Get the headers
            if (!$headers) {
                $headers = $this->parse_row($row);
            } else {
// Create a new row for the array
                $newrow = array();
                $values = $this->parse_row($row);

// Build an associative array, using the headers for the association
                foreach ($headers as $index => $header) {
                    $newrow[$header] = $values[$index];
                }

// Add the new array to the output array
                array_push($output, $newrow);
            }
        }

// Return the output
        return $output;
    }

    private function parse_row($row) {
// Split the comma delimted row
        $cells = preg_split("/,/", $row);

// Go through each cell and see if we encounter a double quote
        foreach ($cells as $index => $value) {
// When we encounter a double quote at the start of a cell, we've got a quoted string
            if (preg_match("/^\"/", $value)) {
// Concatenate the value with the next cell and remove the double quotes
                $cells[$index] = preg_replace("/^\"|\"$/", "", $cells[$index] .
                        $cells[$index + 1]);

// Drop the next cell from the array
                array_splice($cells, $index + 1, 1);
            }
        }
        return $cells;
    }

    private function output_error($err) {
        $err = implode("", $err);

// Remove everything outside of the H1 tag
        $err = preg_replace("/[\s\S]*<H1>|<\/H1>[\s\S]*/i", "", $err);

// Return the error
        return $err;

// Eventually we'll just throw the error rather than return the error output
        throw new Exception($err);
    }

}

function CheckAPI($key) {
    $key = trim($key);
    $QUERY00 = Doctrine_Query::create()
            ->from("SfGuardUserInformation UI")
            ->where("UI.key = '$key'");
    $Resultado00 = $QUERY00->execute();
    if (count($Resultado00) == 0)
        return false;
    else
        return true;
}

function HelpModule($module, $field) {
    $connection = Doctrine_Manager::getInstance()->connection();
    $TextHelp = "";
    $HTML = "";
    $QUERY = "SELECT trgrflhelp AS name FROM tb_fieldmodulehelp WHERE flmdhlmodule = '$module' AND flmdhlfield = '$field'";
    $st = $connection->execute($QUERY);
    $R_Help = $st->fetch(PDO::FETCH_BOTH);
    $TextHelp = $R_Help['name'];
    if ($TextHelp != '')
        $HTML = "<div class='help'><span class='ui-icon ui-icon-info floatleft'></span>$TextHelp</div>";
    return $HTML;
}

function CheckVarietyGenebank($variety) {
    $variety = trim($variety);
    $name = ucfirst(strtolower($variety));
    $variety = strtoupper($variety);
    $C_variety = $variety;
    $variety = str_replace(" ", "%20", $variety);
    $S_variety = $variety;
    $E_variety = $variety . "z";
    $request_url = "http://seeds.iriscouch.com/api/_design/app/_view/search?startkey=\"$S_variety\"&endkey=\"$E_variety\"";
    $results = json_decode(file_get_contents($request_url));
    foreach ($results AS $Genebank) {
        if (strtoupper($Genebank[0]->key) == $C_variety) {
            $IdGenebank = $Genebank[0]->id;
            break;
        }
    }
    if ($IdGenebank != '')
        $retorno = "<a href=\"\" onClick=\"window.open('http://seeds.iriscouch.com/#/accessions/$IdGenebank','Genebank','height=800,width=900,scrollbars=1')\"><span style=\"color: #FF0000;\"><img src='" . dirname($_SERVER['SCRIPT_NAME']) . "/images/lens-icon.png' width='12' height='12'>$name</span></a>";
    else
        $retorno = $name;

    return $retorno;
}

function NextLetter($present = null) {
    $letter = "A";
    if ($present != null) {
        $present = strtoupper($present);
        $Len_present = strlen($present);
        $present2 = substr($present, $Len_present - 1, $Len_present);
        $Arr_Abecedario = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $pos = array_search($present2, $Arr_Abecedario) + 1;
        $letter_tmp = $Arr_Abecedario[$pos];
        if ($letter_tmp != '') {
            if ($Len_present == 1) {
                $letter = $letter_tmp;
            } else {
                $letter = substr($present, 0, $Len_present - 1) . $letter_tmp;
            }
        } else {
            if ($Len_present == 1) {
                $letter = "AA" . $letter_tmp;
            } else if ($Len_present == 2) {
                die("PRS: $present");
                $letter = Letter(substr($present, 0, $Len_present - 1)) . "A";
                die("ET: $letter");
            } else if ($Len_present == 3) {
                $letter = "AAA" . $letter_tmp;
            } else {
                $letter = Letter(substr($present, 0, $Len_present - 1)) . "A";
            }
        }
    }
    return $letter;
}

function Weatherstationuserpermission($id_weatherstation, $id_user) {
    $QUERY00 = Doctrine_Query::create()
            ->from("TbWeatherstationuserpermission WSUP")
            ->where("WSUP.id_weatherstation = $id_weatherstation")
            ->andWhere("WSUP.id_userpermission = $id_user");
    $Resultado00 = $QUERY00->execute();

    if (count($Resultado00) == 0)
        return false;
    else
        return true;
}

function PointDistance($lat1, $long1, $lat2, $long2) {
    $R = 6371; //Grados decimales a Km

    $lat1 = deg2rad($lat1);
    $long1 = deg2rad($long1);

    $lat2 = deg2rad($lat2);
    $long2 = deg2rad($long2);

    $dlong = $long2 - $long1;
    $dlat = $lat2 - $lat1;

    $sinlat = sin($dlat / 2);
    $sinlong = sin($dlong / 2);

    $a = $sinlat * $sinlat + $sinlong * $sinlong * cos($lat1) * cos($lat2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//PASAMOS LOS KM A MTS
    $d = round(($R * $c) * 1000);

    return $d;
}

function rrmdir($dir) {
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
//rmdir($dir);
}

?>