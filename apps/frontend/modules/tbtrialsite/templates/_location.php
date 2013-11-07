<?php
    $consulta = Doctrine::getTable('TbLocation')->findOneByIdLocation($tbtrialsite->getIdLocation());
    echo $consulta->getLctname();
?>
