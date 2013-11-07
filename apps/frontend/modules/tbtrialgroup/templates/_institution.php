<?php
$consulta = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($tbtrialgroup->getIdInstitution());
echo $consulta->getInsname();

?>
