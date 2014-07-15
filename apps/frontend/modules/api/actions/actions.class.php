<?php

include("../lib/funtions/funtion.php");

/**
 * api actions.
 *
 * @package    trialsites
 * @subpackage api
 * @author     Herlin R. Espinosa G. - CIAT-DAPA
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        
    }

    public function executeApitrials(sfWebRequest $request) {
        $key = $request->getParameter('key');
        $trial = $request->getParameter('trial');
        $trialgroup = $request->getParameter('trialgroup');
        $contactperson = $request->getParameter('contactperson');
        $country = $request->getParameter('country');
        $trialsite = $request->getParameter('trialsite');
        $technology = $request->getParameter('technology');
        $latitude = $request->getParameter('latitude');
        $longitude = $request->getParameter('longitude');
        $varieties = $request->getParameter('varieties');
        $variablesmeasureds = $request->getParameter('variablesmeasureds');
        $latest = $request->getParameter('latest');

        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            $Limit = "";
            $Where = "";
            if ($latest != '')
                $Limit = "LIMIT $latest ";
            if ($trial != '')
                $Where .= "AND T.id_trial IN ($trial) ";
            if ($trialgroup != '')
                $Where .= "AND TG.id_trialgroup IN ($trialgroup) ";
            if ($contactperson != '')
                $Where .= "AND CP.id_contactperson IN ($contactperson) ";
            if ($country != '')
                $Where .= "AND CN.id_country IN ($country) ";
            if ($trialsite != '')
                $Where .= "AND TS.id_trialsite IN ($trialsite) ";
            if ($technology != '')
                $Where .= "AND C.id_crop IN ($technology) ";
            if ($latitude != '') {
                $ArrLatitude = explode("|", $latitude);
                if (is_numeric($ArrLatitude[0]))
                    $latitude1 = $ArrLatitude[0];
                if (is_numeric($ArrLatitude[1]))
                    $latitude2 = $ArrLatitude[1];
                if (($latitude1 != '') && ($latitude2 != ''))
                    $Where .= "AND TS.trstlatitudedecimal BETWEEN '$latitude1' AND '$latitude2' ";
            }
            if ($longitude != '') {
                $ArrLongitude = explode("|", $longitude);
                if (is_numeric($ArrLongitude[0]))
                    $longitude1 = $ArrLongitude[0];
                if (is_numeric($ArrLongitude[1]))
                    $longitude2 = $ArrLongitude[1];
                if (($longitude1 != '') && ($longitude2 != ''))
                    $Where .= "AND TS.trstlongitudedecimal BETWEEN '$longitude1' AND '$longitude2' ";
            }
            if ($varieties != '')
                $Where .= "AND TV.id_variety IN ($varieties) ";
            if ($variablesmeasureds != '')
                $Where .= "AND TVM.id_variablesmeasured IN ($variablesmeasureds) ";

            if ($Where != '' || $Limit != '') {
                $connection = Doctrine_Manager::getInstance()->connection();
                $QUERY00 = "SELECT T.id_trial AS id,TG.trgrname AS trialgroup,(CP.cnprfirstname||' '||CP.cnprlastname) AS contactperson,CN.cntname AS country,TS.trstname AS trialsite,TS.trstlatitudedecimal AS latitude,TS.trstlongitudedecimal AS longitude,C.crpname AS crop, ";
                $QUERY00 .= "T.trlname AS trialname,fc_listtrialvariety(T.id_trial) AS varieties,fc_listtrialvariablesmeasured(T.id_trial) AS variablesmeasured,T.trlsowdate AS sowdate,T.trlharvestdate AS harvestdate,T.trltrialtype AS trialtype,T.trlirrigation AS irrigation,'http://www.agtrials.org/tbtrial/'||T.id_trial AS url ";
                $QUERY00 .= "FROM tb_trial T ";
                $QUERY00 .= "INNER JOIN tb_trialgroup TG ON T.id_trialgroup = TG.id_trialgroup ";
                $QUERY00 .= "INNER JOIN tb_contactperson CP ON T.id_contactperson = CP.id_contactperson ";
                $QUERY00 .= "INNER JOIN tb_country CN ON T.id_country = CN.id_country ";
                $QUERY00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
                $QUERY00 .= "INNER JOIN tb_crop C ON T.id_crop = C.id_crop ";
                if ($variablesmeasureds != '')
                    $QUERY00 .= "LEFT JOIN tb_trialvariablesmeasured TVM ON T.id_trial = TVM.id_trial ";
                if ($varieties != '')
                    $QUERY00 .= "LEFT JOIN tb_trialvariety TV ON T.id_trial = TV.id_trial ";
                $QUERY00 .= "WHERE true $Where";
                $QUERY00 .= "ORDER BY T.id_trial $Limit";
                $st = $connection->execute($QUERY00);
                $Result = $st->fetchAll(PDO::FETCH_ASSOC);
                $JSON = json_encode($Result);
                header('Content-type: text/json');
                header('Content-type: application/json');
                die($JSON);
            } else {
                die("*** Error Options ***");
            }
        }
    }

    public function executeApitrialgroups(sfWebRequest $request) {
        $key = $request->getParameter('key');
        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT TG.id_trialgroup AS id,INS.insname AS institution,fc_trialgroupcontactperson(TG.id_trialgroup) AS contactpersons,O.objname AS objective,PD.prdsname AS primarydiscipline,TG.trgrname AS trialgroup, ";
            $QUERY00 .= "TG.trgrstartyear AS startyear,TG.trgrendyear AS endyear,TGT.trgptyname AS trialgrouptype ";
            $QUERY00 .= "FROM tb_trialgroup TG ";
            $QUERY00 .= "INNER JOIN tb_trial T ON TG.id_trialgroup = T.id_trialgroup ";
            $QUERY00 .= "INNER JOIN tb_institution INS ON TG.id_institution = INS.id_institution ";
            $QUERY00 .= "INNER JOIN tb_objective O ON TG.id_objective = O.id_objective ";
            $QUERY00 .= "INNER JOIN tb_primarydiscipline PD ON TG.id_primarydiscipline = PD.id_primarydiscipline ";
            $QUERY00 .= "INNER JOIN tb_trialgrouptype TGT ON TG.id_trialgrouptype = TGT.id_trialgrouptype ";
            $QUERY00 .= "GROUP BY TG.id_trialgroup,INS.insname,fc_trialgroupcontactperson(TG.id_trialgroup),O.objname,PD.prdsname,TG.trgrname,TG.trgrstartyear,TG.trgrendyear,TGT.trgptyname ";
            $QUERY00 .= "ORDER BY TG.trgrname ";
            $st = $connection->execute($QUERY00);
            $Result = $st->fetchAll(PDO::FETCH_ASSOC);
            $JSON = json_encode($Result);
            header('Content-type: text/json');
            header('Content-type: application/json');
            die($JSON);
        }
    }

    public function executeApicontactperson(sfWebRequest $request) {
        $key = $request->getParameter('key');
        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT CP.id_contactperson AS id,INS.insname AS institution,CN.cntname AS country,CPT.ctprtpname AS contactpersontype,CP.cnprfirstname AS firstname, ";
            $QUERY00 .= "CP.cnprlastname AS lastname,CP.cnpraddress AS address,CP.cnprphone AS phone,CP.cnpremail AS email ";
            $QUERY00 .= "FROM tb_contactperson CP ";
            $QUERY00 .= "INNER JOIN tb_trial T ON CP.id_contactperson = T.id_contactperson ";
            $QUERY00 .= "INNER JOIN tb_institution INS ON CP.id_institution = INS.id_institution ";
            $QUERY00 .= "INNER JOIN tb_country CN ON CP.id_country = CN.id_country ";
            $QUERY00 .= "INNER JOIN tb_contactpersontype CPT ON CP.id_contactpersontype = CPT.id_contactpersontype ";
            $QUERY00 .= "GROUP BY CP.id_contactperson,INS.insname,CN.cntname,CPT.ctprtpname,CP.cnprfirstname ";
            $QUERY00 .= "ORDER BY CP.cnprfirstname,CP.cnprlastname ";
            $st = $connection->execute($QUERY00);
            $Result = $st->fetchAll(PDO::FETCH_ASSOC);
            $JSON = json_encode($Result);
            header('Content-type: text/json');
            header('Content-type: application/json');
            die($JSON);
        }
    }

    public function executeApicountry(sfWebRequest $request) {
        $key = $request->getParameter('key');
        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT CN.id_country AS id,CN.cntname AS countryname,CN.cntiso AS iso,CN.cntiso3 AS iso3 ";
            $QUERY00 .= "FROM tb_country CN ";
            $QUERY00 .= "INNER JOIN tb_trial T ON CN.id_country = T.id_country ";
            $QUERY00 .= "GROUP BY CN.id_country,CN.cntname,CN.cntiso,CN.cntiso3 ";
            $QUERY00 .= "ORDER BY CN.cntname ";
            $st = $connection->execute($QUERY00);
            $Result = $st->fetchAll(PDO::FETCH_ASSOC);
            $JSON = json_encode($Result);
            header('Content-type: text/json');
            header('Content-type: application/json');
            die($JSON);
        }
    }

    public function executeApitrialsites(sfWebRequest $request) {
        $key = $request->getParameter('key');
        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT TS.id_trialsite AS id,fc_trialsite_contactperson(TS.id_trialsite) AS contactpersons,INS.insname AS institution,CN.cntname AS country,LC.lctname AS location, ";
            $QUERY00 .= "TS.trstname AS name,TS.trstlatitudedecimal AS latitude,TS.trstlongitudedecimal AS longitude,TS.trstaltitude AS altitude, ";
            $QUERY00 .= "TS.trstph AS ph,S.soiname AS soil,TX.txnname AS taxonomyfao,TS.trststatus AS status,TS.trststatereason AS statereason ";
            $QUERY00 .= "FROM tb_trialsite TS ";
            $QUERY00 .= "INNER JOIN tb_trial T ON TS.id_trialsite = T.id_trialsite ";
            $QUERY00 .= "INNER JOIN tb_location LC ON TS.id_location = LC.id_location  ";
            $QUERY00 .= "INNER JOIN tb_institution INS ON TS.id_institution = INS.id_institution  ";
            $QUERY00 .= "INNER JOIN tb_country CN ON TS.id_country = CN.id_country  ";
            $QUERY00 .= "LEFT JOIN tb_soil S ON TS.id_soil = S.id_soil ";
            $QUERY00 .= "LEFT JOIN tb_taxonomyfao TX ON TS.id_taxonomyfao = TX.id_taxonomyfao ";
            $QUERY00 .= "GROUP BY TS.id_trialsite,fc_trialsite_contactperson(TS.id_trialsite),INS.insname,CN.cntname,LC.lctname,TS.trstname,TS.trstlatitudedecimal,TS.trstlongitudedecimal,TS.trstaltitude,TS.trstph,S.soiname,TX.txnname,TS.trststatus,TS.trststatereason ";
            $QUERY00 .= "ORDER BY TS.trstname ";
            $st = $connection->execute($QUERY00);
            $Result = $st->fetchAll(PDO::FETCH_ASSOC);
            $JSON = json_encode($Result);
            header('Content-type: text/json');
            header('Content-type: application/json');
            die($JSON);
        }
    }

    public function executeApitechnology(sfWebRequest $request) {
        $key = $request->getParameter('key');
        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();
            $QUERY00 = "SELECT CRP.id_crop AS id,CRP.crpname AS technologyname,CRP.crpscientificname AS scientificname ";
            $QUERY00 .= "FROM tb_crop CRP ";
            $QUERY00 .= "INNER JOIN tb_trial T ON CRP.id_crop = T.id_crop ";
            $QUERY00 .= "GROUP BY CRP.id_crop,CRP.crpname,CRP.crpscientificname ";
            $QUERY00 .= "ORDER BY CRP.crpname ";
            $st = $connection->execute($QUERY00);
            $Result = $st->fetchAll(PDO::FETCH_ASSOC);
            $JSON = json_encode($Result);
            header('Content-type: text/json');
            header('Content-type: application/json');
            die($JSON);
        }
    }

    public function executeApivariety(sfWebRequest $request) {
        $key = $request->getParameter('key');
        $technology = $request->getParameter('technology');
        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            if ($technology != '') {
                $connection = Doctrine_Manager::getInstance()->connection();
                $QUERY00 = "SELECT V.id_variety AS id,C.crpname AS technology,O.orgname AS origin,V.vrtname AS varietyname,V.vrtsynonymous AS synonymous,V.vrtdescription AS description ";
                $QUERY00 .= "FROM tb_variety V ";
                $QUERY00 .= "INNER JOIN tb_trialvariety TV ON V.id_variety = TV.id_variety ";
                $QUERY00 .= "INNER JOIN tb_crop C ON V.id_crop = C.id_crop ";
                $QUERY00 .= "LEFT JOIN tb_origin O ON V.id_origin = O.id_origin ";
                $QUERY00 .= "WHERE V.id_crop IN($technology) ";
                $QUERY00 .= "GROUP BY V.id_variety,C.crpname,O.orgname,V.vrtname,V.vrtsynonymous,V.vrtdescription ";
                $QUERY00 .= "ORDER BY V.vrtname,C.crpname,O.orgname ";
                $st = $connection->execute($QUERY00);
                $Result = $st->fetchAll(PDO::FETCH_ASSOC);
                $JSON = json_encode($Result);
                header('Content-type: text/json');
                header('Content-type: application/json');
                die($JSON);
            } else {
                die("*** Error Options ***");
            }
        }
    }

    public function executeApivariablesmeasured(sfWebRequest $request) {
        $key = $request->getParameter('key');
        $technology = $request->getParameter('technology');
        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            if ($technology != '') {
                $connection = Doctrine_Manager::getInstance()->connection();
                $QUERY00 = "SELECT VM.id_variablesmeasured AS id,C.crpname AS technology,TC.trclname AS traitclass,VM.vrmsname AS variablesmeasuredname,VM.vrmsshortname AS shortname,VM.vrmsdefinition AS definition,VM.vrmsunit AS unit ";
                $QUERY00 .= "FROM tb_variablesmeasured VM ";
                $QUERY00 .= "INNER JOIN tb_trialvariablesmeasured TVM ON VM.id_variablesmeasured = TVM.id_variablesmeasured ";
                $QUERY00 .= "INNER JOIN tb_crop C ON VM.id_crop = C.id_crop ";
                $QUERY00 .= "INNER JOIN tb_traitclass TC ON VM.id_traitclass = TC.id_traitclass ";
                $QUERY00 .= "WHERE VM.id_crop IN($technology) ";
                $QUERY00 .= "GROUP BY VM.id_variablesmeasured,C.crpname,TC.trclname,VM.vrmsname,VM.vrmsshortname,VM.vrmsdefinition,VM.vrmsunit ";
                $QUERY00 .= "ORDER BY VM.vrmsname,C.crpname,TC.trclname ";
                $st = $connection->execute($QUERY00);
                $Result = $st->fetchAll(PDO::FETCH_ASSOC);
                $JSON = json_encode($Result);
                header('Content-type: text/json');
                header('Content-type: application/json');
                die($JSON);
            } else {
                die("*** Error Options ***");
            }
        }
    }

    public function executeApimap(sfWebRequest $request) {
        $key = $request->getParameter('key');
        $limit = $request->getParameter('cant');
        $crop = $request->getParameter('crop');


        if (!CheckAPI($key)) {
            die("*** Error Key ***");
        } else {
            $connection = Doctrine_Manager::getInstance()->connection();

            $QUERY00 = "SELECT T.id_trial, TS.trstname, TS.trstlatitudedecimal AS latitude, TS.trstlongitudedecimal AS longitude, INS.insname, trlvarieties, trlname, trlvariablesmeasured, CR.crpname ";
            $QUERY00 .= "FROM tb_trial T ";
            $QUERY00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
            $QUERY00 .= "INNER JOIN tb_institution INS ON TS.id_institution = INS.id_institution ";
            $QUERY00 .= "INNER JOIN tb_crop CR ON T.id_crop = CR.id_crop ";
            if ($crop != '')
                $QUERY00 .= "WHERE T.id_crop IN ($crop) ";
            if (is_numeric($limit))
                $QUERY00 .= "LIMIT $limit ";

            $st = $connection->execute($QUERY00);
            $Result = $st->fetchAll(PDO::FETCH_ASSOC);
			//$rows = count($Result);
			//die("rows: $rows");
            $JSON = json_encode($Result);
            $JSONApimap = "agtrialWS = " . $JSON . ";";
            header('Content-type: text/json');
            header('Content-type: application/json');
            die($JSONApimap);
        }
    }

}
