<?php

class TbFieldnamenumberTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbFieldnamenumber');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbFieldnamenumber')
                        ->andWhere('finanucode like ?', '%' . $dato . '%')
                        ->addOrderBy('finanucode')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdFieldnamenumber()] = (string) $valor;
        }
        return $valores;
    }

}