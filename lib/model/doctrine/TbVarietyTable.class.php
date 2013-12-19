<?php

class TbVarietyTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbVariety');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbVariety')
                        ->andWhere('vrtname like ?', '%' . $dato . '%')
                        ->addOrderBy('vrtname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdVariety()] = (string) $valor;
        }
        return $valores;
    }

    public static function addVariety($id_crop, $id_origin, $vrtname, $vrtsynonymous, $id_user) {
        $Variety = new TbVariety();
        $Variety->setIdCrop($id_crop);
        $Variety->setIdOrigin($id_origin);
        $Variety->setVrtname($vrtname);
        $Variety->setVrtsynonymous($vrtsynonymous);
        $Variety->setIdUser($id_user);
        $Variety->save();
    }

}