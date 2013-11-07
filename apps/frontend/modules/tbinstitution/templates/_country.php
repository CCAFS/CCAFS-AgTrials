<?php
    $consulta = Doctrine::getTable('TbCountry')->findOneByIdCountry($tbinstitution->getIdCountry());
    echo $consulta->getCntname();
?>
