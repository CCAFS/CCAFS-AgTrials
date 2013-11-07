<?php
    $consulta = Doctrine::getTable('TbCountry')->findOneByIdCountry($tbcontactperson->getIdCountry());
    echo $consulta->getCntname();
?>
