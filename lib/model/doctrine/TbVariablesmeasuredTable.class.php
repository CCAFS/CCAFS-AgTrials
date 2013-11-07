<?php

class TbVariablesmeasuredTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbVariablesmeasured');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbVariablesmeasured')
                        ->andWhere('vrmsname like ?', '%' . $dato . '%')
                        ->addOrderBy('vrmsname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdVariablesmeasured()] = (string) $valor;
        }
        return $valores;
    }

    public static function addVariablesmeasured($id_crop, $id_traitclass, $vrmsname, $vrmsshortname, $vrmsdefinition, $vrmsunit, $id_user) {
        $Variablesmeasured = new TbVariablesmeasured();
        $Variablesmeasured->setIdCrop($id_crop);
        $Variablesmeasured->setIdTraitclass($id_traitclass);
        $Variablesmeasured->setVrmsname($vrmsname);
        $Variablesmeasured->setVrmsshortname($vrmsshortname);
        $Variablesmeasured->setVrmsdefinition($vrmsdefinition);
        $Variablesmeasured->setVrmsunit($vrmsunit);
        $Variablesmeasured->setIdUser($id_user);
        $Variablesmeasured->save();
    }

}