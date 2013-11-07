<?php
    $consulta = Doctrine::getTable('TbCountry')->findOneByIdCountry($tblocation->getIdCountry());
    echo $consulta->getCntname();
?>
