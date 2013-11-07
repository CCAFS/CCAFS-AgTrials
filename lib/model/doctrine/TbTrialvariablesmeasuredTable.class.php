<?php

class TbTrialvariablesmeasuredTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialvariablesmeasured');
    }

    public static function addVariablesmeasured($id_trial, $id_variablesmeasured, $id_user) {
        $TbTrialvariablesmeasured = new TbTrialvariablesmeasured();
        $TbTrialvariablesmeasured->setIdTrial($id_trial);
        $TbTrialvariablesmeasured->setIdVariablesmeasured($id_variablesmeasured);
        $TbTrialvariablesmeasured->setIdUser($id_user);
        $TbTrialvariablesmeasured->setIdUserUpdate(null);
        $TbTrialvariablesmeasured->save();
    }

    public static function delVariablesmeasured($id_trial) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialvariablesmeasured T')
                        ->where('T.id_trial = ?', $id_trial);
        $q->execute();
    }

}