<?php

class TbObjectiveTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbObjective');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbObjective')
                        ->andWhere('objname like ?', '%' . $dato . '%')
                        ->addOrderBy('objname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdObjective()] = (string) $valor;
        }
        return $valores;
    }

}