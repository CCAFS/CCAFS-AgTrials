<?php

class TbTrialgrouppermissionTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialgrouppermission');
    }

    public static function addTrialgrouppermission($id_trial, $id_group, $id_user) {
        $TbTrialgrouppermission = new TbTrialgrouppermission();
        $TbTrialgrouppermission->setIdTrial($id_trial);
        $TbTrialgrouppermission->setIdGroup($id_group);
        $TbTrialgrouppermission->setIdUser($id_user);
        $TbTrialgrouppermission->setIdUserUpdate(null);
        $TbTrialgrouppermission->save();
    }

    public static function delTrialgrouppermission($id_trial) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialgrouppermission T')
                        ->where('T.id_trial = ?', $id_trial);
        $q->execute();
    }

}