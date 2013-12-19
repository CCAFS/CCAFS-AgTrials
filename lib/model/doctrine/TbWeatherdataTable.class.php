<?php

class TbWeatherdataTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbWeatherdata');
    }

    public static function addWeatherdata($id_weatherstation, $wtdtdate, $id_meteorologicalfields, $wtdtvalue) {
        $TbWeatherdata = new TbWeatherdata();
        $TbWeatherdata->setIdWeatherstation($id_weatherstation);
        $TbWeatherdata->setWtdtdate($wtdtdate);
        $TbWeatherdata->setIdMeteorologicalfields($id_meteorologicalfields);
        $TbWeatherdata->setWtdtvalue($wtdtvalue);
        $TbWeatherdata->save();
    }

    public static function delWeatherdata($id_weatherdata) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbWeatherdata T')
                ->where('T.id_weatherdata = ?', $id_weatherdata);
        $q->execute();
    }

}