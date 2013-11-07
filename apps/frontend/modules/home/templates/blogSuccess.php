<?php
$id = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id');
$ruta = "";
if($id != '')
    $ruta = "?p=$id";
?>
<iframe width="1015" height="600" frameborder="0" scrolling="yes" marginheight="0" marginwidth="0" src="http://gisweb.ciat.cgiar.org/trialsitesblog/<?php echo $ruta; ?>"></iframe>