<?php

class TbTrialdataTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialdata');
    }

    public static function addData($id_trial, $trdtreplication, $id_variety, $id_variablesmeasured, $trvmvalue) {
        $connection = Doctrine_Manager::getInstance()->connection();
        if ($trdtreplication == '')
            $trdtreplication = 1;
        $QUERY00 = "SELECT check_trialdata($id_trial, $trdtreplication, $id_variety, $id_variablesmeasured);";
        $CheckTrialData = $connection->execute($QUERY00);
        $R_CheckTrialData = $CheckTrialData->fetchAll();
        if (!($R_CheckTrialData[0][0])) {
            $TbTrialdata = new TbTrialdata();
            $TbTrialdata->setIdTrial($id_trial);
            $TbTrialdata->setTrdtreplication($trdtreplication);
            $TbTrialdata->setIdVariety($id_variety);
            $TbTrialdata->setIdVariablesmeasured($id_variablesmeasured);
            $TbTrialdata->setTrdtvalue($trvmvalue);
            $TbTrialdata->save();
        }
    }

    public static function delData($id_trial) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialdata T')
                ->where('T.id_trial = ?', $id_trial);
        $q->execute();
    }

}