<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT" />
<meta name="description" content="The Global Agricultural Trial Repository" />
<meta name="keywords" content="Trial, Site, Bibliography, CGIAR, CCAFS, CIAT, Crop, Technology, Variety/Race, Variables measured" />
<meta name="language" content="en" />
<meta name="robots" content="index, follow" />
<title>The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT</title>
<link href="/sfAdminThemejRollerPlugin/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<script src="/js/tbtrialsite.js" type="text/javascript"></script>
<style type="text/css">
    .Field{
        background-color:#C0C0C0;
        width:12%;
        height: 25px;
        font-size:14px;
        font-weight:bold;
    }

    .Data{
        width:88%;
        font-size:12px;
    }
</style>

<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>View Trial site</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <table width="100%">
                <tr>
                    <td class="Field">&ensp;Id:</td>
                    <td class="Data"><?php echo $TbTrialsite[0]->id_trialsite; ?>&ensp;&ensp;<a title="View more information" href="/tbtrialsite/<?php echo $TbTrialsite[0]->id_trialsite; ?>">View more information</a> </td>
                </tr>
                <tr>
                    <td class="Field">&ensp;Institution:</td>
                    <td class="Data"><?php echo $TbTrialsite[0]->institution; ?></td>
                </tr>
                <tr>
                    <td class="Field">&ensp;Country :</td>
                    <td class="Data"><?php echo $TbTrialsite[0]->country; ?></td>
                </tr>
                <tr>
                    <td class="Field">&ensp;Location:</td>
                    <td class="Data"><?php echo $TbTrialsite[0]->location; ?></td>
                </tr>
                <tr>
                    <td class="Field">&ensp;Name:</td>
                    <td class="Data"><?php echo $TbTrialsite[0]->trstname; ?></td>
                </tr>
                <tr>
                    <td class="Field">&ensp;Latitude:</td>
                    <td class="Data"><?php echo round($TbTrialsite[0]->trstlatitudedecimal, 4); ?></td>
                </tr>
                <tr>
                    <td class="Field">&ensp;Longitude:</td>
                    <td class="Data"><?php echo round($TbTrialsite[0]->trstlongitudedecimal, 4); ?></td>
                </tr>
                <tr>
                    <td class="Field">&ensp;Altitude:</td>
                    <td class="Data"><?php echo $TbTrialsite[0]->trstaltitude; ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div>
                            <html>
                                <head>
                                    <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
                                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
                                </head>
                                <body onunload="GUnload()">
                                    <div id="map" style="width: 875px; height: 450px"></div>
                                    <script type="text/javascript">

                                        var i_lat = <?php echo round($TbTrialsite[0]->trstlatitudedecimal, 4); ?>;
                                        var i_lon = <?php echo round($TbTrialsite[0]->trstlongitudedecimal, 4); ?>;

                                        var map = null;
                                        var infoWindow = null;

                                        function openInfoWindow(marker) {
                                            var markerLatLng = marker.getPosition();
                                            infoWindow.setContent(["<div>Latitud: " + markerLatLng.lat() + "<br>Longitud: " + markerLatLng.lng()].join(''));
                                            infoWindow.open(map, marker);
                                        }

                                        function initialize() {
                                            var myLatlng = new google.maps.LatLng(i_lat,i_lon);
                                            var myOptions = {
                                                zoom: 14,
                                                center: myLatlng,
                                                mapTypeId: google.maps.MapTypeId.HYBRID
                                            }

                                            map = new google.maps.Map($("#map").get(0), myOptions);

                                            infoWindow = new google.maps.InfoWindow();

                                            var marker = new google.maps.Marker({
                                                position: myLatlng,
                                                draggable: true,
                                                map: map,
                                                title:"Info"
                                            });

                                            google.maps.event.addListener(marker, 'click', function(){
                                                openInfoWindow(marker);
                                            });
                                        }


                                        $(document).ready(function() {
                                            initialize();
                                        });
                                    </script>
                                </body>
                            </html>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
