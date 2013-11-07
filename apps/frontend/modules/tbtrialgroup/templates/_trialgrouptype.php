<?php
    $consulta = Doctrine::getTable('TbTrialgrouptype')->findOneByIdTrialgrouptype($tbtrialgroup->getIdTrialgrouptype());
    echo $consulta->gettrgptyname();
?>
