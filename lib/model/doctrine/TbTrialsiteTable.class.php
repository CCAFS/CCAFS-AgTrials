<?php

class TbTrialsiteTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsite');
    }

    public static function retrieveForSelect($dato, $limit) {
        $consulta = Doctrine_Query::create()
                ->from('TbTrialsite')
                ->andWhere("UPPER(trstname) LIKE UPPER('$dato%')")
                ->andWhere("trstactive = 'TRUE'")
                ->addOrderBy('trstname')
                ->limit($limit);
		//echo $consulta->getSqlQuery(); die();
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdTrialsite()] = (string) $valor;
        }
        return $valores;
    }

    public static function addTrialsite($id_contactperson, $id_location, $id_institution, $id_country, $trstname, $trstlatitude, $trstlatitudedecimal, $trstlongitude, $trstlongitudedecimal, $trstaltitude, $trstph, $id_soil, $id_taxonomyfao, $trststatus, $trststatereason, $id_user) {
        $Trialsite = new TbTrialsite();
        $Trialsite->setIdContactperson($id_contactperson);
        $Trialsite->setIdLocation($id_location);
        $Trialsite->setIdInstitution($id_institution);
        $Trialsite->setIdCountry($id_country);
        $Trialsite->setTrstname($trstname);
        $Trialsite->setTrstlatitude($trstlatitude);
        $Trialsite->setTrstlatitudedecimal($trstlatitudedecimal);
        $Trialsite->setTrstlongitude($trstlongitude);
        $Trialsite->setTrstlongitudedecimal($trstlongitudedecimal);
        $Trialsite->setTrstaltitude($trstaltitude);
        $Trialsite->setTrstph($trstph);
        $Trialsite->setIdSoil($id_soil);
        $Trialsite->setIdTaxonomyfao($id_taxonomyfao);
        $Trialsite->setTrstsupplementalinformationfileaccess('None');
        $Trialsite->setTrststatus($trststatus);
        $Trialsite->setTrststatereason($trststatereason);
        $Trialsite->setIdUser($id_user);
        $Trialsite->save();
        return $Trialsite->getIdTrialsite();
    }

}