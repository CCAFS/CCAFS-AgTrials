<?php
if ($tbfieldnamenumber->getIdSoil() != null) {
    $consulta = Doctrine::getTable('TbSoil')->findOneByIdSoil($tbfieldnamenumber->getIdSoil());
    echo $consulta->getSoiname();
}
?>
