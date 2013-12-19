<?php

class TbTrialsitecontactpersonTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsitecontactperson');
    }

    public static function addTrialsitecontactperson($id_trialsite, $id_contactperson) {
        $TbTrialsitecontactperson = new TbTrialsitecontactperson();
        $TbTrialsitecontactperson->setIdTrialsite($id_trialsite);
        $TbTrialsitecontactperson->setIdContactperson($id_contactperson);
        $TbTrialsitecontactperson->save();
    }

    public static function delTrialsitecontactperson($id_trialsite) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialsitecontactperson T')
                ->where('T.id_trialsite = ?', $id_trialsite);
        $q->execute();
    }

}