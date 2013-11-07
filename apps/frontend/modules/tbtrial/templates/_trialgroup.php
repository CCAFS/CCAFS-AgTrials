<?php
    $consulta = Doctrine::getTable('TbTrialgroup')->findOneByIdTrialgroup($tbtrial->getIdTrialgroup());
    echo $consulta->getTrgrname();
?>
