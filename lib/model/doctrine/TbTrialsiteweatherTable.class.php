<?php

class TbTrialsiteweatherTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsiteweather');
    }

    public static function addTrialsiteweather($id_trialsite, $trstwtfileaccess, $trstwtfile, $trstwtstartdate, $trstwtenddate) {
        $TbTrialsiteweather = new TbTrialsiteweather();
        $TbTrialsiteweather->setIdTrialsite($id_trialsite);
        $TbTrialsiteweather->setTrstwtfileaccess($trstwtfileaccess);
        $TbTrialsiteweather->setTrstwtfile($trstwtfile);
        $TbTrialsiteweather->setTrstwtstartdate($trstwtstartdate);
        $TbTrialsiteweather->setTrstwtenddate($trstwtenddate);
        $TbTrialsiteweather->save();
        return $TbTrialsiteweather->getIdTrialsiteweather();
    }

    public static function delTrialsiteweather($id_trialsiteweather) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialsiteweather T')
                        ->where('T.id_trialsiteweather = ?', $id_trialsiteweather);
        $q->execute();
    }

}