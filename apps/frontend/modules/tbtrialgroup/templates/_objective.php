<?php
    $consulta = Doctrine::getTable('TbObjective')->findOneByIdObjective($tbtrialgroup->getIdObjective());
    echo $consulta->getObjname();
?>
