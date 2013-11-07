<?php
    if($tbvariety->getIdOrigin()){
        $consulta = Doctrine::getTable('TbOrigin')->findOneByIdOrigin($tbvariety->getIdOrigin());
        echo $consulta->getOrgname();
    }
?>
