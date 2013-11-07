<?php
    $consulta = Doctrine::getTable('TbCountry')->findOneByIdCountry($tbtrial->getIdCountry());
    echo $consulta->getCntname();
?>
