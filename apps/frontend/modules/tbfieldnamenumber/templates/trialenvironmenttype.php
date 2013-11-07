<?php
    $consulta = Doctrine::getTable('TbTrialenvironmenttype')->findOneByIdTrialenvironmenttype($tbfieldnamenumber->getIdTrialenvironmenttype());
    echo $consulta->getTrnvtyname();
?>
