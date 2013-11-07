<?php

class TbLocationTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbLocation');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbLocation')
                        ->andWhere('lctname like ?', '%' . $dato . '%')
                        ->addOrderBy('lctname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdLocation()] = (string) $valor;
        }
        return $valores;
    }

        public static function addLocation($id_country, $lctname, $id_user) {
        $Location = new TbLocation();
        $Location->setIdCountry($id_country);
        $Location->setLctname($lctname);
        $Location->setIdUser($id_user);
        $Location->save();
    }
}