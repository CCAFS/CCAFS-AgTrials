<?php

class TbTrialsitephotographTable extends Doctrine_Table {

    public static function getInstance() {
        return Doctrine_Core::getTable('TbTrialsitephotograph');
    }

    public static function addTrialsitephotograph($id_trialsite, $trstphfileaccess, $trstphfile, $trstphpersonphotograph) {
        $TbTrialsitephotograph = new TbTrialsitephotograph();
        $TbTrialsitephotograph->setIdTrialsite($id_trialsite);
        $TbTrialsitephotograph->setTrstphfileaccess($trstphfileaccess);
        $TbTrialsitephotograph->setTrstphfile($trstphfile);
        if ($trstphpersonphotograph != '')
            $TbTrialsitephotograph->setTrstphpersonphotograph($trstphpersonphotograph);
        $TbTrialsitephotograph->save();
    }

    public static function delTrialsitephotograph($id_trialsitephotograph) {
        $q = Doctrine_Query::create()
                        ->delete()
                        ->from('TbTrialsitephotograph T')
                        ->where('T.id_trialsitephotograph = ?', $id_trialsitephotograph);
        $q->execute();
    }

}