<?php

class TbOriginTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbOrigin');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbOrigin')
                        ->andWhere('orgname like ?', '%' . $dato . '%')
                        ->addOrderBy('orgname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdOrigin()] = (string) $valor;
        }
        return $valores;
    }

}