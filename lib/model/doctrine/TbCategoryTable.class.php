<?php

class TbCategoryTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbCategory');
    }

    public static function addCategory($ctgname, $ctgdescription, $id_user) {
        $TbCategory = new TbCategory();
        $TbCategory->setCtgname($ctgname);
        $TbCategory->setCtgdescription($ctgdescription);
        $TbCategory->setIdUser($id_user);
        $TbCategory->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $TbCategory->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $TbCategory->save();
        return $TbCategory->getIdCategory();
    }

}