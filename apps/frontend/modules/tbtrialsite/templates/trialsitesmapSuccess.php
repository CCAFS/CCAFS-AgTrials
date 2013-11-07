<?php
use_stylesheet('/sfAdminThemejRollerPlugin/css/reset.css', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery.min.js', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js', 'first');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jroller.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.menu.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.buttons.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/ui.selectmenu.css');
use_javascript('/sfAdminThemejRollerPlugin/js/fg.menu.js');
use_javascript('/sfAdminThemejRollerPlugin/js/jroller.js');
use_javascript('/sfAdminThemejRollerPlugin/js/ui.selectmenu.js');
?>
<script>
    function wopen(trialsite){
        window.open("/tbtrialsite/"+trialsite,"Trial_site","width=800,height=800,scrollbars=1")
    }
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Trial sites map</h1>
    </div>
    <?php
    $a = 0;
    $QUERY00 = Doctrine_Query::create()
                    ->select("TS.id_trialsite,IN.insname AS institution, CN.cntname AS country, LC.lctname AS location, TS.trstname AS name, TS.trstlatitudedecimal AS latitude, TS.trstlongitudedecimal AS longitude, TS.trststatus AS status")
                    ->from("TbTrialsite TS")
                    ->innerJoin("TS.TbInstitution IN")
                    ->innerJoin("TS.TbCountry CN")
                    ->innerJoin("TS.TbLocation LC");
    //echo $QUERY00->getSqlQuery(); die();
    $Resultado00 = $QUERY00->execute();
    foreach ($Resultado00 AS $fila) {
        $idtrialsite = $fila['id_trialsite'];
        $institution = $fila['institution'];
        $country = $fila['country'];
        $location = $fila['location'];
        $name = $fila['name'];
        $latitude = $fila['latitude'];
        $longitude = $fila['longitude'];
        $status = $fila['status'];
        $Desc_punto = "<b>$name</b> <br>";
        $Desc_punto .= "$country - $location<br>";
        $Desc_punto .= "$status <br>";
        $Desc_punto .= "<A HREF=\"#\" onClick=\"wopen({$idtrialsite})\">Go to Trial Site</A>";
        if (($latitude != '') && ($longitude != '')) {
            $puntos[$a] = array('lat' => $latitude, 'lng' => $longitude, 'point' => $Desc_punto);
            $a++;
        }
    }
//    print_r("<pre>");
//    print_r($puntos);
//    print_r("<pre>");
//    die();
    $centro = array('lat' => '0', 'lng' => '0', 'zoom' => '2');
    ?>
    <br>
    <div id="tbtrial_map">
        <html>
            <head>
                <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAlNwt71Py2RQkcI82jed3KxQw9B1d9i7y34jNA5Ys2NOE2xB5_BQbh_grgnF6m_h8MiTrj2wjhhgwmA" type="text/javascript"></script>
            </head>
            <body onunload="GUnload()">
                <div id="map" style="width: 1000px; height: 750px"></div>
                <script type="text/javascript">
                    function createMarker(point,html) {
                        var marker = new GMarker(point);
                        GEvent.addListener(marker, "click", function() {
                            marker.openInfoWindowHtml(html);
                        });
                        GEvent.addListener(marker,"mouseover", function() {
                            marker.openInfoWindowHtml(html);
                        });
                        return marker;
                    }
                    var map = new GMap2(document.getElementById("map"));
                    map.addControl(new GLargeMapControl());
                    map.addControl(new GMapTypeControl());
                    map.setMapType(G_HYBRID_MAP);
                    map.setCenter(new GLatLng(<?php echo $centro['lat']; ?>, <?php echo $centro['lng']; ?>), <?php echo $centro['zoom']; ?>);

<?php foreach ($puntos as $punto) { ?>
        var point = new GLatLng(<?php echo $punto['lat']; ?>,<?php echo $punto['lng']; ?>);
        var marker = createMarker(point,'<?php echo $punto['point']; ?>')
        map.addOverlay(marker);
<?php } ?>
                </script>
            </body>
        </html>
    </div>
</div>