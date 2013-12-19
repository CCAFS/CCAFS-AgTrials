<?php

class TbTrialgrouptypeTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialgrouptype');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbTrialgrouptype')
                        ->andWhere('trgptyname like ?', '%' . $dato . '%')
                        ->addOrderBy('trgptyname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdTrialgrouptype()] = (string) $valor;
        }
        return $valores;
    }

}