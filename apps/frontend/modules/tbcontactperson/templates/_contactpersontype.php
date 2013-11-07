<?php
    $consulta = Doctrine::getTable('TbContactpersontype')->findOneByIdContactpersontype($tbcontactperson->getIdContactpersontype());
    echo $consulta->getCtprtpname();
?>
