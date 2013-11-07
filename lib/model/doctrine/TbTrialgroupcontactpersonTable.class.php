<?php

class TbTrialgroupcontactpersonTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialgroupcontactperson');
    }

    public static function addTrialgroupcontactperson($id_trialgroup, $id_contactperson) {
        $TbTrialgroupcontactperson = new TbTrialgroupcontactperson();
        $TbTrialgroupcontactperson->setIdTrialgroup($id_trialgroup);
        $TbTrialgroupcontactperson->setIdContactperson($id_contactperson);
        $TbTrialgroupcontactperson->save();
    }

    public static function delTrialgroupcontactperson($id_trialgroup, $id_contactperson) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from("TbTrialgroupcontactperson T")
                        ->where("T.id_trialgroup = $id_trialgroup AND T.id_contactperson = $id_contactperson");
        $q->execute();
    }

    public static function delTrialgroupcontactpersons($id_trialgroup) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialgroupcontactperson T')
                        ->where('T.id_trialgroup = ?', $id_trialgroup);
        $q->execute();
    }

}