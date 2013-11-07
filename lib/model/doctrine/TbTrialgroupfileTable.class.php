<?php

class TbTrialgroupfileTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialgroupfile');
    }

    public static function addTrialgroupfile($id_trialgroup, $trgrflfile, $trgrfldescription) {
        $TbTrialgroupfile = new TbTrialgroupfile();
        $TbTrialgroupfile->setIdTrialgroup($id_trialgroup);
        $TbTrialgroupfile->setTrgrflfile($trgrflfile);
        $TbTrialgroupfile->setTrgrfldescription($trgrfldescription);
        $TbTrialgroupfile->save();
    }

    public static function delTrialgroupfile($id_trialgroupfile) {
        $q = Doctrine_Query::create()
                ->delete()
                ->from('TbTrialgroupfile T')
                ->where('T.id_trialgroupfile = ?', $id_trialgroupfile);
        $q->execute();
    }

}