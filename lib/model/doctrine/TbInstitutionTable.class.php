<?php

class TbInstitutionTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbInstitution');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = strtoupper($dato);
        $consulta = Doctrine_Query::create()
                        ->from('TbInstitution')
                        ->andWhere('insname like ?', '%' . $dato . '%')
                        ->addOrderBy('insname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdInstitution()] = (string) $valor;
        }
        return $valores;
    }

}