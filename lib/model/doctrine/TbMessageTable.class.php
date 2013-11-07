<?php

class TbMessageTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbMessage');
    }

    public static function addMessage($mnsmessage, $id_category, $id_theme, $id_user) {
        $TbMessage = new TbMessage();
        $TbMessage->setMnsmessage($mnsmessage);
        $TbMessage->setIdCategory($id_category);
        $TbMessage->setIdTheme($id_theme);
        $TbMessage->setIdUser($id_user);
        $TbMessage->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $TbMessage->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $TbMessage->save();
    }

}