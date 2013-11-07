<?php

class TbLanguageTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbLanguage');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbLanguage')
                        ->andWhere('lngname like ?', '%' . $dato . '%')
                        ->addOrderBy('lngname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdLanguage()] = (string) $valor;
        }
        return $valores;
    }

}