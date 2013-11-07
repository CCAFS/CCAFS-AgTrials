<?php use_helper('Thickbox') ?>
<div class="sf_admin_list ui-grid-table ui-widget ui-corner-all ui-helper-reset ui-helper-clearfix">
    <?php if (!$pager->getNbResults()): ?>
        <table>
            <caption class="fg-toolbar ui-widget-header ui-corner-top">
                <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default">
                    <a href="#sf_admin_filter" id="sf_admin_filter_button" class="fg-button ui-state-default fg-button-icon-left ui-corner-left"><?php echo UIHelper::addIconByConf('filters') . __('Filters', array(), 'sf_admin') ?></a>
                    <?php echo link_to(UIHelper::addIconByConf('reset') . __('Reset', array(), 'sf_admin'), 'tbtrial_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'fg-button ui-state-default fg-button-icon-left ui-corner-right')) ?>
                    <a href="/tbtrial/new" class="fg-button ui-state-default fg-button-icon-left ui-corner-all" tabindex="-1"><span class="ui-icon ui-icon-plus"></span>New</a>
                    <a href="/batchupload" class="fg-button-mini fg-button ui-state-default fg-button-icon-left"><img src="/images/upload-file-icon.png">Batch upload</a>
                </div>
                <h1><span class="ui-icon ui-icon-triangle-1-s"></span> <?php echo __('List Trial', array(), 'messages') ?></h1>
            </caption>
            <tbody>
                <tr class="sf_admin_row ui-widget-content">
                    <td align="center" height="30">
                        <p align="center"><?php echo __('No result', array(), 'sf_admin') ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <table>
            <caption class="fg-toolbar ui-widget-header ui-corner-top">
                <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default">
                    <a href="#sf_admin_filter" id="sf_admin_filter_button" class="fg-button ui-state-default fg-button-icon-left ui-corner-left"><?php echo UIHelper::addIconByConf('filters') . __('Filters', array(), 'sf_admin') ?></a>
                    <?php $isDisabledResetButton = ($hasFilters->getRawValue()) ? '' : ' ui-state-disabled' ?>
                    <?php echo link_to(UIHelper::addIconByConf('reset') . __('Reset', array(), 'sf_admin'), 'tbtrial_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'fg-button ui-state-default fg-button-icon-left ui-corner-right' . $isDisabledResetButton)) ?>
                    <a href="/tbtrial/new" class="fg-button ui-state-default fg-button-icon-left ui-corner-all" tabindex="-1"><span class="ui-icon ui-icon-plus"></span>New</a>
                    <a href="/batchupload" class="fg-button-mini fg-button ui-state-default fg-button-icon-left"><img src="/images/upload-file-icon.png">Batch upload</a>
                </div>
                <h1><span class="ui-icon ui-icon-triangle-1-s"></span> <?php echo __('List Trial', array(), 'messages') ?></h1>
            </caption>

            <thead class="ui-widget-header">
                <tr>
                    <?php include_partial('tbtrial/list_th_tabular', array('sort' => $sort)) ?>
                    <th id="sf_admin_list_th_actions" class="ui-state-default ui-th-column"><?php echo __('Actions', array(), 'sf_admin') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $datosmap = array();
                foreach ($pager->getResults() as $i => $tbtrial): $odd = fmod(++$i, 2) ? ' odd' : '';
                    $datosmap[$i] = array('id_trial' => $tbtrial->getIdTrial(), 'id_contactperson' => $tbtrial->getIdContactperson(), 'id_trialsite' => $tbtrial->getIdTrial(), 'trlname' => $tbtrial->getTrlname());
                    ?>
                    <tr class="sf_admin_row ui-widget-content <?php echo $odd ?>">
                        <?php include_partial('tbtrial/list_td_tabular', array('tbtrial' => $tbtrial)) ?>
                        <?php include_partial('tbtrial/list_td_actions', array('tbtrial' => $tbtrial, 'helper' => $helper)) ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<!--  AQUI VA EL CODIGO PARA LA PAGINACION-->
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <table>
        <div class="ui-state-default ui-th-column ui-corner-bottom">
            <?php include_partial('tbtrial/pagination', array('pager' => $pager)) ?>
        </div>
    </table>
</div>

<!--  AQUI VA EL CODIGO PARA EL MAPA-->
<?php
$a = 0;
foreach ($datosmap AS $dato) {
    $idtrial = $dato['id_trial'];
    $idcontactperson = $dato['id_contactperson'];
    $idtrialsite = $dato['id_trialsite'];
    $trlname = $dato['trlname'];
    $Tbcontactperson = Doctrine::getTable('Tbcontactperson')->findOneByIdContactperson($idcontactperson);
    $Tbtrialsite = Doctrine::getTable('Tbtrialsite')->findOneByIdTrialsite($idtrialsite);
    $Desc_punto = "<b>{$Tbcontactperson->getCnprfirstname()} {$Tbcontactperson->getCnprlastname()}</b> <br>";
    $Desc_punto .= "{$Tbtrialsite->getTrstname()} <br>";
    $Desc_punto .= "$trlname <br>";
    $Desc_punto .= "<A HREF=\"#\" onClick=\"wopen({$idtrial})\">Go Trial</A>";
    if (($Tbtrialsite->getTrstlatitudedecimal() != '') && ($Tbtrialsite->getTrstlongitudedecimal() != '')) {
        $puntos[$a] = array('lat' => $Tbtrialsite->getTrstlatitudedecimal(), 'lng' => $Tbtrialsite->getTrstlongitudedecimal(), 'point' => $Desc_punto);
        $a++;
    }
}
$centro = array('lat' => '0', 'lng' => '0', 'zoom' => '2');
?>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <table>
        <div class="fg-toolbar ui-widget-header ui-corner-all">
            <h1>Maps</h1>
        </div>
        <div id="sf_admin_content">
            <div class="sf_admin_form">
                <html>
                    <head>
                        <script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAlNwt71Py2RQkcI82jed3KxQFlZUvLyeYL88snyFz3kp3E9SLERRfXtCPYH-FXKlFJh1pqJEBDVrMYQ" type="text/javascript"></script>
                    </head>
                    <body onunload="GUnload()">
                        <div id="map" style="width: 1025px; height: 500px"></div>
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
    </table>
</div>
<script type="text/javascript">
    function checkAll(){
        var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
    }

    function wopen(trial){
        window.open("/tbtrial/"+trial,"Trial","width=800,height=800,scrollbars=1")
        //alert(trial);
    }
</script>
