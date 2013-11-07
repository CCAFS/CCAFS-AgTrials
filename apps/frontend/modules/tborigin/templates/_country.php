<?php
    $consulta = Doctrine::getTable('TbCountry')->findOneByIdCountry($tborigin->getIdCountry());
    echo $consulta->getCntname();
?>
