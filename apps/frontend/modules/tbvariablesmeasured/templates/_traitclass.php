<?php
    $consulta = Doctrine::getTable('TbTraitclass')->findOneByIdTraitclass($tbvariablesmeasured->getIdTraitclass());
    echo $consulta->getTrclname();
?>