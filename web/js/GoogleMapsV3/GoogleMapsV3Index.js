/**
 * The markers array.
 * @type {Object}
 */




/**
 * The MarkerClusterer object.
 * @type {MarkerCluster}
 */
var mc = null;

/**
 * The Map object.
 * @type {google.maps.Map}
 */
var map = null;

/**
 * The MarkerManager object.
 * @type {MarkerManager}
 */
var mgr = null;


/**
 * Marker Clusterer display/hide flag.
 * @type {boolean}
 */
var showMarketClusterer = false;

/**
 * Marker Manager display/hide flag.
 * @type {boolean}
 */
var showMarketManager = false;



//Toggles Marker Manager visibility.
function toggleMarkerManager() {
    showMarketManager = !showMarketManager;
    if (mgr) {
        if (showMarketManager) {
            mgr.addMarkers(markers.info, 0, 5);
            mgr.refresh();
        } else {
            mgr.clearMarkers();
            mgr.refresh();
        }
    } else {
        mgr = new MarkerManager(map, {
            trackMarkers: true,
            maxZoom: 15
        });
        google.maps.event.addListener(mgr, 'loaded', function() {
            mgr.addMarkers(markers.info, 0, 5);
            mgr.refresh();
        });
    }
}

//Toggles Marker Clusterer visibility.
function toggleMarkerClusterer() {
    showMarketClusterer = !showMarketClusterer;
    if (showMarketClusterer) {

        if (mc) {
            mc.addMarkers(markers.info);
        } else {
            mc = new MarkerClusterer(map, markers.info, {
                maxZoom: 5
            });
        }
    } else {
        mc.clearMarkers();
    }
}

function Legend(controlDiv, map) {
    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map
    controlDiv.style.padding = '3px';

    // Set CSS for the control border
    var controlUI = document.createElement('DIV');
    controlUI.style.backgroundColor = '#EBE8D9';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '1px';
    controlUI.title = 'Leyenda';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control text
    var controlText = document.createElement('DIV');
    controlText.style.fontFamily = 'Arial';
    controlText.style.fontSize = '9px';
    controlText.style.paddingLeft = '2px';
    controlText.style.paddingRight = '2px';

    // Add the text
    controlText.innerHTML = '<b>Agrupación puntos</b><br />' +
            '<span title="Punto"><img width="12" height="12" src="/js/GoogleMapsV3/images/m0.png"/> 1<br />' +
            '<span title="De 2 a 10 Puntos"><img width="16" height="16" src="/js/GoogleMapsV3/images/m1.png"/> 2 - 10<br />' +
            '<span title="De 11 a 100 Puntos"><img width="16" height="16" src="/js/GoogleMapsV3/images/m2.png"/> 11 - 100<br />' +
            '<span title="De 101 a 1000 Puntos"><img width="16" height="16" src="/js/GoogleMapsV3/images/m3.png"/> 101 - 1000<br />' +
            '<span title="De 1001 a 10000 Puntos"><img width="16" height="16" src="/js/GoogleMapsV3/images/m4.png"/> 1001 - 10000<br />' +
            '<span title="Mayor a 10000 Puntos"><img width="16" height="16" src="/js/GoogleMapsV3/images/m5.png"/> > 100000<br />';
    //controlUI.appendChild(controlText);
}

/**
 * Initializes the map and listeners.
 */
function initialize() {

    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(30, 0),
        zoom: 1,
        mapTypeId: google.maps.MapTypeId.TERRAIN
                //mapTypeId: google.maps.MapTypeId.HYBRID  
    });

    google.maps.event.addDomListener(document.getElementById('mc-cb'), 'click', toggleMarkerClusterer);
    google.maps.event.addDomListener(document.getElementById('mgr-cb'), 'click', toggleMarkerManager);

    var infowindow = new google.maps.InfoWindow();

    if (markers) {
        for (var level in markers) {
            for (var i = 0; i < markers[level].length; i++) {
                var details = markers[level][i];
                var Lat = details.lat;
                var Log = details.log;
                var Title = details.title;
                var Context = details.context;

                markers[level][i] = new google.maps.Marker({
                    title: Title,
                    context: Context,
                    position: new google.maps.LatLng(Lat, Log),
                    clickable: true,
                    draggable: false,
                    flat: true
                });
                google.maps.event.addListener(markers[level][i], 'click', (function(marker, i) {
                    return function() {
                        var details = markers[level][i];
                        infowindow.setContent(details.context);
                        infowindow.open(map, markers[level][i]);
                    }
                })(markers[level][i], i));

            }
        }
    }
    mc = new MarkerClusterer(map, markers.info, {
        maxZoom: 5
    });

    // Create the legend and display on the map
    var legendDiv = document.createElement('DIV');
    var legend = new Legend(legendDiv, map);
    legendDiv.index = 1;
    map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legendDiv);
}
google.maps.event.addDomListener(window, 'load', initialize);
