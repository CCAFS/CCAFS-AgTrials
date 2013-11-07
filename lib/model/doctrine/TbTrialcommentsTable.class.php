<?php

class TbTrialcommentsTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialcomments');
    }

    public static function addTrialcomments($id_trial, $trcmcomment, $id_user) {
        $obj = new TbTrialcomments();
        $obj->setIdTrial($id_trial);
        $obj->setTrcmcomment($trcmcomment);
        $obj->setIdUser($id_user);
        $obj->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $obj->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $obj->save();
    }

    public static function delTrialcomments($id_trialcomments) {
        $DELETE = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialcomments TC')
                        ->where('TC.id_trialcomments = ?', $id_trialcomments);
        $DELETE->execute();
    }

    public static function delTrialcommentsbyidtrial($id_trial) {
        $DELETE = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialcomments TC')
                        ->where('TC.id_trial = ?', $id_trial);
        $DELETE->execute();
    }

}