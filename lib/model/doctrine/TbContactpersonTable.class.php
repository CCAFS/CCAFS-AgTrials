<?php

class TbContactpersonTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbContactperson');
    }

    public static function retrieveForSelect($dato, $where, $limit) {
        $dato = strtolower($dato);
        if($where != '')
            $where = " AND $where";
        $consulta = Doctrine_Query::create()
                        ->from("TbContactperson CP")
                        ->where("LOWER(CP.cnprfirstname) LIKE '$dato%' $where ")
                        ->orderBy("CP.cnprfirstname")
                        ->limit($limit);
        //echo $consulta->getSqlQuery();
        //die();
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdContactperson()] = (string) $valor;
        }
        return $valores;
    }

}