<?php
if($tborigin->getIdInstitution()){
    $consulta = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($tborigin->getIdInstitution());
    echo $consulta->getInsname();
}
?>
