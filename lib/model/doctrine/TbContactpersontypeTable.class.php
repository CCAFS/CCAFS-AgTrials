<?php

class TbContactpersontypeTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbContactpersontype');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbContactpersontype')
                        ->andWhere('ctprtpname like ?', '%' . $dato . '%')
                        ->addOrderBy('ctprtpname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdContactpersontype()] = (string) $valor;
        }
        return $valores;
    }

}