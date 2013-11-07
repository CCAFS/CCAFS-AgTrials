<?php
    $consulta = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($tbtrialgroup->getIdContactperson());
    echo $consulta->getCnprfirstname()." ".$consulta->getCnprlastname();
?>
