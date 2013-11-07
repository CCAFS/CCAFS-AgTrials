<?php
    $consulta = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($tbcontactperson->getIdInstitution());
    echo $consulta->getInsname();
?>
