<?php
    if($tbbibliography->getIdCrop()){
        $consulta = Doctrine::getTable('Tbcrop')->findOneByIdCrop($tbbibliography->getIdCrop());
        echo $consulta->getCrpname();
    }
?>