<?php

class TbCountryTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbCountry');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbCountry')
                        ->andWhere('cntname like ?', '%'.$dato.'%')
                        ->addOrderBy('cntname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdCountry()] = (string)$valor;
        }
        return $valores;
    }

}