<?php

class TbTrialsiteuserpermissionfilesTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsiteuserpermissionfiles');
    }

    public static function addUser($id_trialsite, $id_userpermission, $id_user) {
        $TbTrialsiteuserpermissionfiles = new TbTrialsiteuserpermissionfiles();
        $TbTrialsiteuserpermissionfiles->setIdTrialsite($id_trialsite);
        $TbTrialsiteuserpermissionfiles->setIdUserpermission($id_userpermission);
        $TbTrialsiteuserpermissionfiles->setIdUser($id_user);
        $TbTrialsiteuserpermissionfiles->setIdUserUpdate(null);
        $TbTrialsiteuserpermissionfiles->save();
    }

    public static function delUser($id_trialsite) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialsiteuserpermissionfiles T')
                ->where('T.id_trialsite = ?', $id_trialsite);
        $q->execute();
    }

}