<?php
    $consulta = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($tbtrial->getIdContactperson());
    echo $consulta->getCnprfirstname() . " " . $consulta->getCnprlastname();
?>
