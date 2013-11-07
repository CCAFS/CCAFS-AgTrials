<?php

class TbSoilTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbSoil');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbSoil')
                        ->andWhere('soiname like ?', '%' . $dato . '%')
                        ->addOrderBy('soiname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdSoil()] = (string) $valor;
        }
        return $valores;
    }

}