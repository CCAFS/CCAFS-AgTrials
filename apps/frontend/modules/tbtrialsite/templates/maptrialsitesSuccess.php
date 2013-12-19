<link href="/sfAdminThemejRollerPlugin/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<script src="/js/tbtrialsite.js" type="text/javascript"></script>

<script type="text/javascript">
    getcoordenadas();
    function getcoordenadas(){
        var inilatitudedecimal = parent.document.getElementById('tb_trialsite_trstlatitudedecimal').value;
        var inilongitudedecimal = parent.document.getElementById('tb_trialsite_trstlongitudedecimal').value;
        if(inilatitudedecimal == '' || inilongitudedecimal == ''){
            alert('*** IMPORTANT *** \n\n Before specify coordinates near!');
            //parent.document.getElementById('autocomplete_tb_trial_id_crop').focus();
            self.parent.tb_remove();
        }
    }
    function enviar(lat,lon){
        lat = Math.round(lat*1000000)/1000000;
        lon = Math.round(lon*1000000)/1000000;
        var latitudedecimal = '';
        var longitudedecimal = '';
        var latitude = '';
        var degree = '';
        var minutes  = '';
        var seconds  = '';
        var cardinal  = 'N';
        var error  = '';
        var temp = 0;
        if(lat < 0){
            cardinal  = 'S';
            latitudedecimal = lat * -1;
        }else{
            latitudedecimal = lat;
        }
        degree = parseInt(latitudedecimal);
        temp = (latitudedecimal - degree);
        temp = (temp * 60);
        minutes = parseInt(temp);
        temp = (temp - minutes);
        seconds = parseInt((temp * 60));

        degree = degree+"";
        if (degree.length == 1)
            degree = "0"+degree;
        minutes = minutes+"";
        if (minutes.length == 1)
            minutes = "0"+minutes;
        seconds = seconds+"";
        if (seconds.length == 1)
            seconds = "0"+seconds;

        latitude = degree+''+minutes+''+seconds+''+cardinal;
        parent.document.getElementById("tb_trialsite_trstlatitude").value = latitude;
        parent.document.getElementById("tb_trialsite_trstlatitudedecimal").value = lat;

        var longitude = '';
        degree = '';
        minutes  = '';
        seconds  = '';
        cardinal  = 'E';
        error  = '';
        temp = 0;
        if(lon < 0){
            cardinal  = 'W';
            longitudedecimal = lon * -1;
        }else{
            longitudedecimal = lon;
        }
        degree = parseInt(longitudedecimal);
        temp = (longitudedecimal - degree);
        temp = (temp * 60);
        minutes = parseInt(temp);
        temp = (temp - minutes);
        seconds = parseInt((temp * 60));

        degree = degree+"";
        if (degree.length == 1)
            degree = "00"+degree;
        if (degree.length == 2)
            degree = "0"+degree;
        minutes = minutes+"";
        if (minutes.length == 1)
            minutes = "0"+minutes;
        seconds = seconds+"";
        if (seconds.length == 1)
            seconds = "0"+seconds;

        longitude = degree+''+minutes+''+seconds+''+cardinal;
        parent.document.getElementById("tb_trialsite_trstlongitude").value = longitude;
        parent.document.getElementById("tb_trialsite_trstlongitudedecimal").value = lon;
        self.parent.tb_remove();
    }
</script>

<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Coordinates map</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <div id="tbtrialsite_map">
                <html>
                    <head>
                        <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
                        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
                    </head>
                    <body onunload="GUnload()">
                        <div id="map" style="width: 800px; height: 530px"></div>
                        <script type="text/javascript">
                            
                            var i_lat = parseFloat(parent.document.getElementById('tb_trialsite_trstlatitudedecimal').value);
                            var i_lon = parseFloat(parent.document.getElementById('tb_trialsite_trstlongitudedecimal').value);
                            
                            var map = null;
                            var infoWindow = null;
	
                            function openInfoWindow(marker) {
                                var markerLatLng = marker.getPosition();
                                infoWindow.setContent(["<div>Latitud: " + markerLatLng.lat() + "<br>Longitud: " + markerLatLng.lng() + "</div> <br> <input type='button' onclick='enviar("+markerLatLng.lat()+","+markerLatLng.lng()+")' value='Send & Close'>"].join(''));
                                infoWindow.open(map, marker);
                            }

                            function initialize() {
                                var myLatlng = new google.maps.LatLng(i_lat,i_lon);
                                var myOptions = {
                                    zoom: 16,
                                    center: myLatlng,
                                    mapTypeId: google.maps.MapTypeId.HYBRID
                                }
		
                                map = new google.maps.Map($("#map").get(0), myOptions);
		
                                infoWindow = new google.maps.InfoWindow();
		
                                var marker = new google.maps.Marker({
                                    position: myLatlng,
                                    draggable: true,
                                    map: map,
                                    title:"Choose your Trial sites"
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
        </div>
    </div>

</div>