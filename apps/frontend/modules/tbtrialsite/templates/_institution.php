<?php
    $consulta = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($tbtrialsite->getIdInstitution());
    echo $consulta->getInsname();
?>
