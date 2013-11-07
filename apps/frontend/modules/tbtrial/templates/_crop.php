<?php
    $consulta = Doctrine::getTable('Tbcrop')->findOneByIdCrop($tbtrial->getIdCrop());
    echo $consulta->getCrpname();
?>