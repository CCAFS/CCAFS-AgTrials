<?php

class TbTaxonomyfaoTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTaxonomyfao');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbTaxonomyfao')
                        ->andWhere('txnname like ?', '%' . $dato . '%')
                        ->addOrderBy('txnname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdTaxonomyfao()] = (string) $valor;
        }
        return $valores;
    }

}