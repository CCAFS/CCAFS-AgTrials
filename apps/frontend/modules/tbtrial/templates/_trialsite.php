<?php
    $consulta = Doctrine::getTable('Tbtrialsite')->findOneByIdTrialsite($tbtrial->getIdTrialsite());
    echo $consulta->getTrstname();
?>
