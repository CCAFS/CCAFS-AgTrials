<?php

class TbTrialgroupcommentsTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialgroupcomments');
    }

    public static function addTrialgroupcomments($id_trialgroup, $trgpcmcomment, $id_user) {
        $obj = new TbTrialgroupcomments();
        $obj->setIdTrialgroup($id_trialgroup);
        $obj->setTrgpcmcomment($trgpcmcomment);
        $obj->setIdUser($id_user);
        $obj->setCreatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $obj->setUpdatedAt(date("Y-m-d") . " " . date("H:i:s"));
        $obj->save();
    }

    public static function delTrialgroupcomments($id_trialgroupcomments) {
        $DELETE = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialgroupcomments TGC')
                        ->where('TGC.id_trialgroupcomments = ?', $id_trialgroupcomments);
        $DELETE->execute();
    }

}