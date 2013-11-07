<?php

class TbNetworkTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbNetwork');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbNetwork')
                        ->andWhere('ntwname like ?', '%' . $dato . '%')
                        ->addOrderBy('ntwname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdNetwork()] = (string) $valor;
        }
        return $valores;
    }

}