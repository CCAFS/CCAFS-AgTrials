<?php

class TbThemeTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTheme');
    }

    public static function addTheme($thmname, $id_category, $id_user) {
        $TbTheme = new TbTheme();
        $TbTheme->setThmname($thmname);
        $TbTheme->setIdCategory($id_category);
        $TbTheme->setIdUser($id_user);
        $TbTheme->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $TbTheme->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $TbTheme->save();
        return $TbTheme->getIdTheme();
    }

}