<?php

class TbWeatherstationuserpermissionTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbWeatherstationuserpermission');
    }

    public static function addUser($id_weatherstation, $id_userpermission) {
        $TbWeatherstationuserpermission = new TbWeatherstationuserpermission();
        $TbWeatherstationuserpermission->setIdWeatherstation($id_weatherstation);
        $TbWeatherstationuserpermission->setIdUserpermission($id_userpermission);
        $TbWeatherstationuserpermission->save();
    }

    public static function delUser($id_weatherstation) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbWeatherstationuserpermission T')
                ->where('T.id_weatherstation = ?', $id_weatherstation);
        $q->execute();
    }

}