<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var map, layer;

function initialize() {
  var map = new google.maps.LatLng(30, 0);

  map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: map,
    zoom: 1
  });

  layer = new google.maps.FusionTablesLayer({
    query: {
      select: '',
      from: '1znIQBkEQHjvbDJwwdyn9rmsgld90R132VUiKXQ4'
    }
  });
  layer.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
<div class="Mapa">
    <div id="map-canvas" style="width:460px; height:320px">Loading Map...</div>
</div>                        
