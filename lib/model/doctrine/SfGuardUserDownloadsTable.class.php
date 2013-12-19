<?php

class SfGuardUserDownloadsTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('SfGuardUserDownloads');
    }

    public static function delSfGuardUserDownloads($id_trial) {
        $DELETE = Doctrine_Query::create()
                        ->delete()
                        ->from('SfGuardUserDownloads T')
                        ->where('T.id_trial = ?', $id_trial);
        $DELETE->execute();
    }

}