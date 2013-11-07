<?php

class TbTrialvarietyTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialvariety');
    }

    public static function addVariety($id_trial, $id_variety, $id_user) {
        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT check_trialvariety($id_trial, $id_variety);";
        $CheckTrialVariety = $connection->execute($QUERY00);
        $R_CheckTrialVariety = $CheckTrialVariety->fetchAll();
        if (!($R_CheckTrialVariety[0][0])) {
            $TbTrialvariety = new TbTrialvariety();
            $TbTrialvariety->setIdTrial($id_trial);
            $TbTrialvariety->setIdVariety($id_variety);
            $TbTrialvariety->setIdUser($id_user);
            $TbTrialvariety->setIdUserUpdate(null);
            $TbTrialvariety->save();
        }
    }

    public static function delVariety($id_trial) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialvariety t')
                ->where('t.id_trial = ?', $id_trial);
        $q->execute();
    }

}