<?php

class TbWeatherstationTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbWeatherstation');
    }

    public static function retrieveForSelect($dato, $where, $limit) {
        $dato = strtolower($dato);
        if ($where != '')
            $where = " AND $where";
        $consulta = Doctrine_Query::create()
                ->from("TbWeatherstation WS")
                ->where("LOWER(WS.wtstname) LIKE '$dato%' $where ")
                ->orderBy("WS.wtstname")
                ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdWeatherstation()] = (string) $valor;
        }
        return $valores;
    }

}