<?php
    $consulta = Doctrine::getTable('TbCountry')->findOneByIdCountry($tbtrialsite->getIdCountry());
    echo $consulta->getCntname();
?>
