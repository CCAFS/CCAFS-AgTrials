<?php

class TbPrimarydisciplineTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbPrimarydiscipline');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbPrimarydiscipline')
                        ->andWhere('prdsname like ?', '%' . $dato . '%')
                        ->addOrderBy('prdsname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdPrimarydiscipline()] = (string) $valor;
        }
        return $valores;
    }

}