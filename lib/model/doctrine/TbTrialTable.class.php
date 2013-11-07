<?php

class TbTrialTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrial');
    }

    public static function addTrial($id_trialgroup, $id_contactperson, $id_country, $id_trialsite, $id_fieldnamenumber, $id_crop, $trlvarieties, $trlvariablesmeasured, $trlname, $trlsowdate, $trlharvestdate, $trltrialresultsfile, $trlsupplementalinformationfile, $trlweatherduringtrialfile, $trlsoiltypeconditionsduringtrialfile, $trllicense, $trlfileaccess, $trltrialtype, $id_user) {
        $TbTrial = new TbTrial();
        $TbTrial->setIdTrialgroup($id_trialgroup);
        $TbTrial->setIdContactperson($id_contactperson);
        $TbTrial->setIdCountry($id_country);
        $TbTrial->setIdTrialsite($id_trialsite);
        $TbTrial->setIdFieldnamenumber($id_fieldnamenumber);
        $TbTrial->setIdCrop($id_crop);
        $TbTrial->setTrlvarieties($trlvarieties);
        $TbTrial->setTrlvariablesmeasured($trlvariablesmeasured);
        $TbTrial->setTrlname($trlname);
        $TbTrial->setTrlsowdate($trlsowdate);
        $TbTrial->setTrlharvestdate($trlharvestdate);
        $TbTrial->setTrltrialresultsfile($trltrialresultsfile);
        $TbTrial->setTrlsupplementalinformationfile($trlsupplementalinformationfile);
        $TbTrial->setTrlweatherduringtrialfile($trlweatherduringtrialfile);
        $TbTrial->setTrlsoiltypeconditionsduringtrialfile($trlsoiltypeconditionsduringtrialfile);
        $TbTrial->setTrllicense($trllicense);
        $TbTrial->setTrlfileaccess($trlfileaccess);
        $TbTrial->setTrltrialtype($trltrialtype);
        $TbTrial->setTrltrialrecorddate(date('Y-m-d'));
        $TbTrial->setIdUser($id_user);
        $TbTrial->setIdUserUpdate(null);
        $TbTrial->save();
        return $TbTrial->getIdTrial();
    }

}