<?php
    $consulta = Doctrine::getTable('Tbcrop')->findOneByIdCrop($tbvariablesmeasured->getIdCrop());
    echo $consulta->getCrpname();
?>