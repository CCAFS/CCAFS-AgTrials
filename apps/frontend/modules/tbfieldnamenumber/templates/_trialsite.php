<?php
    $consulta = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($tbfieldnamenumber->getIdTrialsite());
    echo $consulta->getTrstname();
?>
