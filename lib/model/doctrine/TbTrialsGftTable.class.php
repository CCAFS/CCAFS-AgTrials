<?php

class TbTrialsGftTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsGft');
    }

    public static function addTrialsGft($id_trial, $googlefusiontable) {
        $googlefusiontable = strtoupper($googlefusiontable);
        $TbTrialsGft = new TbTrialsGft();
        $TbTrialsGft->setIdTrial($id_trial);
        $TbTrialsGft->setGooglefusiontable($googlefusiontable);
        $TbTrialsGft->save();
    }

    public static function delTrialsGft($id_trial) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialsGft T')
                ->where('T.id_trial = ?', $id_trial);
        $q->execute();
    }

}