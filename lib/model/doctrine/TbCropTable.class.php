<?php

class TbCropTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbCrop');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbCrop')
                        ->andWhere('crpname like ?', '%' . $dato . '%')
                        ->addOrderBy('crpname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdCrop()] = (string) $valor;
        }
        return $valores;
    }

}