<?php

class TbTrialgroupTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialgroup');
    }

    public static function retrieveForSelect($dato, $limit) {
        $dato = ucfirst(strtolower($dato));
        $consulta = Doctrine_Query::create()
                        ->from('TbTrialgroup')
                        ->andWhere('trgrname like ?', '%' . $dato . '%')
                        ->addOrderBy('trgrname')
                        ->limit($limit);
        $valores = array();
        foreach ($consulta->execute() as $valor) {
            $valores[$valor->getIdTrialgroup()] = (string) $valor;
        }
        return $valores;
    }

    public static function addTrialgroup($id_institution, $id_contactperson, $id_trialgrouptype, $id_objective, $id_primarydiscipline, $trgrname, $trgrstartyear, $trgrendyear, $trgrtrialgrouprecorddate, $trgrtrialgrouprecordstatus, $id_user) {
        $Trialgroup = new TbTrialgroup();
        $Trialgroup->setIdInstitution($id_institution);
        $Trialgroup->setIdContactperson($id_contactperson);
        $Trialgroup->setIdTrialgrouptype($id_trialgrouptype);
        $Trialgroup->setIdObjective($id_objective);
        $Trialgroup->setIdPrimarydiscipline($id_primarydiscipline);
        $Trialgroup->setTrgrname($trgrname);
        $Trialgroup->setTrgrstartyear($trgrstartyear);
        $Trialgroup->setTrgrendyear($trgrendyear);
        $Trialgroup->setTrgrtrialgrouprecorddate($trgrtrialgrouprecorddate);
        $Trialgroup->setTrgrtrialgrouprecordstatus($trgrtrialgrouprecordstatus);
        $Trialgroup->setIdUser($id_user);
        $Trialgroup->save();
        return $Trialgroup->getIdTrialgroup();
    }

}