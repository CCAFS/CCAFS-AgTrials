<?php
if ($tbweatherstation->getIdCountry() != "") {
    $consulta = Doctrine::getTable('TbCountry')->findOneByIdCountry($tbweatherstation->getIdCountry());
    echo $consulta->getCntname();
}
?>
