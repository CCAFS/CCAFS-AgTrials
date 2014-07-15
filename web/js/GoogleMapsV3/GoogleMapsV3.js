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


/**
 * Initializes the map and listeners.
 */
function initialize() {
    
    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(0, 0),
        zoom: 2,
        mapTypeId: google.maps.MapTypeId.TERRAIN
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
                    flat: true,
                    icon: '/images/GoogleMap/m0.png'
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
}

google.maps.event.addDomListener(window, 'load', initialize);
