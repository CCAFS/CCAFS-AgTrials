<?php
    $consulta = Doctrine::getTable('Tblanguage')->findOneByIdLanguage($tbbibliography->getIdLanguage());
    echo $consulta->getLngname();
?>