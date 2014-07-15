<?php
$connection = Doctrine_Manager::getInstance()->connection();
$QUERY00 = "SELECT T.id_trial,CR.crpname,TS.trstlatitudedecimal,TS.trstlongitudedecimal ";
$QUERY00 .= "FROM tb_trial T INNER JOIN tb_crop CR ON T.id_crop = CR.id_crop ";
$QUERY00 .= "INNER JOIN tb_trialsite TS ON T.id_trialsite = TS.id_trialsite ";
$QUERY00 .= "WHERE TS.trstlatitudedecimal IS NOT NULL AND TS.trstlongitudedecimal IS NOT NULL "; 
$st = $connection->execute($QUERY00);
$Resultado00 = $st->fetchAll();
$a = 0;
$puntos = "";
foreach ($Resultado00 AS $fila) {
    $id_trial = $fila['id_trial'];
    $Crop = $fila['crpname'];
    $latitud = $fila['trstlatitudedecimal'];
    $longitud = $fila['trstlongitudedecimal'];

    $Desc_punto = "<b>Crop:</b> $Crop<br>";
    $Desc_punto .= "<br><img width='16' height='16' src='/images/lens-icon.png'><A HREF=\"#\" onClick=\"wopen({$id_trial})\"> More information</A>";
    if (($latitud != '') && ($longitud != '')) {
        $puntos['info'][$a] = array('title' => "$Crop", 'context' => $Desc_punto, 'lat' => $latitud, 'log' => $longitud);
        $a++;
    }
}
$maps = json_encode($puntos);
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="/js/GoogleMapsV3/GoogleMapsV3Index.js"></script>
<script type="text/javascript" src="/js/GoogleMapsV3/GoogleMapsV3-MarkerClusterer.js"></script>
<script type="text/javascript" src="/js/GoogleMapsV3/GoogleMapsV3-MarkerManager.js"></script>
<script type="text/javascript" src="/js/tbtrial.js"></script>
<script type="text/javascript" >var markers = <?php echo $maps; ?></script>

<div class="Mapa">
    <input type="hidden" id="mgr-cb" name="mgr-cb" />
    <input type="hidden" id="mc-cb" name="mc-cb" checked/>
    <div id="map" style="width:460px; height:320px">Loading Map...</div>
</div>                        
