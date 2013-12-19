<?php

class TbTrialsiteweatherstationTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsiteweatherstation');
    }

    public static function addWeatherstation($id_trialsite, $id_weatherstation) {
        $TbTrialsiteweatherstation = new TbTrialsiteweatherstation();
        $TbTrialsiteweatherstation->setIdTrialsite($id_trialsite);
        $TbTrialsiteweatherstation->setIdWeatherstation($id_weatherstation);
        $TbTrialsiteweatherstation->save();
    }

    public static function delWeatherstation($id_trialsite) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialsiteweatherstation T')
                ->where('T.id_trialsite = ?', $id_trialsite);
        $q->execute();
    }
}