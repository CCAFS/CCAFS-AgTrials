<?php
    $consulta = Doctrine::getTable('TbCrop')->findOneByIdCrop($tbvariety->getIdCrop());
    echo $consulta->getCrpname();
?>
