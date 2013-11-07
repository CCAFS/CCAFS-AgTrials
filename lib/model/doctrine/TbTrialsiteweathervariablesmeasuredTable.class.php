<?php

class TbTrialsiteweathervariablesmeasuredTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsiteweathervariablesmeasured');
    }

    public static function addTrialsiteweathervariablesmeasured($id_trialsiteweather,$id_weathervariablesmeasured) {
        $TbTrialsiteweathervariablesmeasured = new TbTrialsiteweathervariablesmeasured();
        $TbTrialsiteweathervariablesmeasured->setIdTrialsiteweather($id_trialsiteweather);
        $TbTrialsiteweathervariablesmeasured->setIdWeathervariablesmeasured($id_weathervariablesmeasured);
        $TbTrialsiteweathervariablesmeasured->save();
    }

    public static function delTrialsiteweathervariablesmeasured($id_trialsiteweather) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialsiteweathervariablesmeasured T')
                        ->where('T.id_trialsiteweather = ?', $id_trialsiteweather);
        $q->execute();
    }

}