<?php

class TbTrialvariablesmeasuredsTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialvariablesmeasureds');
    }

    public static function addVariablesmeasureds($id_trial, $id_variety, $id_variablesmeasured, $trvmvalue, $id_user) {
        $connection = Doctrine_Manager::getInstance()->connection();
        $QUERY00 = "SELECT check_trialvariablesmeasureds($id_trial, $id_variety, $id_variablesmeasured);";
        $CheckTrialVariablesMeasureds = $connection->execute($QUERY00);
        $R_CheckTrialVariablesMeasureds = $CheckTrialVariablesMeasureds->fetchAll();
        if (!($R_CheckTrialVariablesMeasureds[0][0])) {
            $TbTrialvariablesmeasureds = new TbTrialvariablesmeasureds();
            $TbTrialvariablesmeasureds->setIdTrial($id_trial);
            $TbTrialvariablesmeasureds->setIdVariety($id_variety);
            $TbTrialvariablesmeasureds->setIdVariablesmeasured($id_variablesmeasured);
            $TbTrialvariablesmeasureds->setTrvmvalue($trvmvalue);
            $TbTrialvariablesmeasureds->setIdUser($id_user);
            $TbTrialvariablesmeasureds->setIdUserUpdate(null);
            $TbTrialvariablesmeasureds->save();
        }
    }

    public static function delVariablesmeasureds($id_trial) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialvariablesmeasureds T')
                ->where('T.id_trial = ?', $id_trial);
        $q->execute();
    }

}