<?php
    $consulta = Doctrine::getTable('Tbtrialsite')->findOneByIdTrialsite($tbtrial->getIdTrialsite());
    echo "LAT: {$consulta->getTrstlatitudedecimal()} - LON:{$consulta->getTrstlongitudedecimal()}";
?>
