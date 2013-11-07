<?php

class TbTrialuserpermissionfilesTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialuserpermissionfiles');
    }

    public static function addUser($id_trial, $id_userpermission, $id_user) {
        $TbTrialuserpermissionfiles = new TbTrialuserpermissionfiles();
        $TbTrialuserpermissionfiles->setIdTrial($id_trial);
        $TbTrialuserpermissionfiles->setIdUserpermission($id_userpermission);
        $TbTrialuserpermissionfiles->setIdUser($id_user);
        $TbTrialuserpermissionfiles->setIdUserUpdate(null);
        $TbTrialuserpermissionfiles->save();
    }

    public static function delUsers($id_trial) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialuserpermissionfiles T')
                        ->where('T.id_trial = ?', $id_trial);
        $q->execute();
    }

    public static function delUser($id_trial, $id_user) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from("TbTrialuserpermissionfiles T")
                        ->where("T.id_trial = $id_trial AND id_userpermission = $id_user");
        $q->execute();
    }

}