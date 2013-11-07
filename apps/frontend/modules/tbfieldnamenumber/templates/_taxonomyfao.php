<?php
if ($tbfieldnamenumber->getIdTaxonomyfao() != null) {
    $consulta = Doctrine::getTable('TbTaxonomyfao')->findOneByIdTaxonomyfao($tbfieldnamenumber->getIdTaxonomyfao());
    echo $consulta->getTxnname();
}
?>
