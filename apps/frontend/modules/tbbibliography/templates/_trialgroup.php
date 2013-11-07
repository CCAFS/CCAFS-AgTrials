<?php
    if($tbbibliography->getIdTrialgroup()){
        $consulta = Doctrine::getTable('TbTrialgroup')->findOneByIdTrialgroup($tbbibliography->getIdTrialgroup());
        echo $consulta->getTrgrname();
    }
?>
