<?php
    $consulta = Doctrine::getTable('TbPrimarydiscipline')->findOneByIdPrimarydiscipline($tbtrialgroup->getIdPrimarydiscipline());
    echo $consulta->getPrdsname();
?>
