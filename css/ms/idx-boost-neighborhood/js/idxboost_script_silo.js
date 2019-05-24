var tgmap='', itemneight='', tglat=[], tglng=[], tglatsu=0, tglngsu=0 , totitem=0; methodView=2;
var temp=[];
(function(window, document, $, undefined) {
  var dgt = (function() {
    return {};
  })();

  function parsePolygonString(ps) {
    var i, j, lat, lng, tmp, tmpArr,
      arr = [],
      m = ps.match(/\([^\(\)]+\)/g);
    if (m !== null) {
      for (i = 0; i < m.length; i++) {
        tmp = m[i].match(/-?\d+\.?\d*/g);
        if (tmp !== null) {
          for (j = 0, tmpArr = []; j < tmp.length; j+=2) {
            lat = parseFloat(tmp[j]);
            lng = parseFloat(tmp[j + 1]);
            tmpArr.push(new google.maps.LatLng(lat, lng));
          }
          arr.push(tmpArr);
        }
      }
    }
    return arr;
  }

  dgt.map = (function() {
    var map;
    var mapControlsDiv;
    var mapControl;
    var minZoomLevel = 12;
    var maxZoomLevel = 18;
    var drawFreeHandButton;
    var userIsDrawing = false;
    var userHasMapFigure = false;
    var poly;
    var move;
    var controlWrapper;
    var zoomInButton;
    var zoomOutButton;
    var style_map=[];

    if(style_map_idxboost != undefined && style_map_idxboost != '') {
      style_map=JSON.parse(style_map_idxboost);
    }   

    var mapOptions = {
      zoom: 13,
      center: new google.maps.LatLng(25.7866338553873, -80.16239007607419),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDoubleClickZoom: false,
      mapTypeControl: true,
      mapTypeControlOptions: {
        position: google.maps.ControlPosition.TOP_RIGHT
      },
      styles: style_map,
      gestureHandling: 'greedy',
      scrollwheel: false,
      panControl: false,
      streetViewControl: false,
      disableDefaultUI: true,
      clickableIcons: false
    };


    var marker;
    var markers = [];
    var markerHTML = [];
    var items;
    var tmp_items = [];
    var item;
    var bounds;
    var infoWindow;
    var html = [];
    var hashed_properties = [];
    var filtered_properties = [];
    var unique_properties = [];
    var geocode;
    var row;
    var inner;

    return {
      init: function() {
          map = document.getElementById('idx_map_silo_neighboardhood');  
        if (map !== null) {
          map = new google.maps.Map(map, mapOptions);
          tgmap=map;

          mapControlsDiv = document.createElement('div');
          mapControl = new dgt.map.setupMapControls(mapControlsDiv, map);
          mapControlsDiv.index = 1;
          map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapControlsDiv);
        }
      },
      refresh: function() {
        google.maps.event.trigger(map, 'resize');
      },
      getInstance: function() {
        return map;
      },      
      setupMapControls: function(controlDiv, map) {
        controlDiv.classList.add("map-controls-ct");
        // setup control wrapper
        controlWrapper = document.createElement("div");
        controlWrapper.classList.add("dgt-map-controls-ct");
        controlDiv.appendChild(controlWrapper);
        // setup zoomIn control
        zoomInButton = document.createElement("div");
        zoomInButton.classList.add("dgt-map-zoomIn");
        controlWrapper.appendChild(zoomInButton);
        // setup zoomIut control
        zoomOutButton = document.createElement("div");
        zoomOutButton.classList.add("dgt-map-zoomOut");
        controlWrapper.appendChild(zoomOutButton);

        // setup events for controls
        google.maps.event.addDomListener(zoomInButton, "click", function(event) {
          event.stopPropagation();
          event.preventDefault();

          var currentZoomLevel = map.getZoom();
          map.setZoom(currentZoomLevel + 1);
        });
        google.maps.event.addDomListener(zoomOutButton, "click", function(event) {
          event.stopPropagation();
          event.preventDefault();

          var currentZoomLevel = map.getZoom();
          map.setZoom(currentZoomLevel - 1);
        });


          google.maps.event.addListener(map, 'dragend', function () {
              var c = map.getCenter();
              console.log('*********************');
              console.log(c.lat() + ', ' + c.lng() + ' + Z_' + map.getZoom());

          });
      },
    };
  })();

  $(dgt.map.init);

  var polyOptions = { strokeColor: '#0072ac',
    strokeOpacity: 0.5,
    strokeWeight: 2,
    fillColor: '#0072ac',
    fillOpacity: 0.20,
    zIndex: 1,
  };

  $(document).ready(function() {
    setTimeout(function(){
      var boundspolyn = new google.maps.LatLngBounds();
          map = dgt.map.getInstance();
            var marker = [];
            if (idx_neighboardhood.method_map=='only_communities'){

                if (typeof idx_neighboardhood.item_community != undefined){
                  
                  idx_neighboardhood.item_community.forEach(function(item){
                    if( item.geometry != null ){                      
                        var latLngBounds = parsePolygonString(item.geometry);
                        var latLngBoundsFigure = latLngBounds[0];
                        var latLngBoundRaw = [];
                        for (var i = 0, l = latLngBoundsFigure.length; i < l; i++) {
                          latLngBoundRaw.push({ lat: latLngBoundsFigure[i].lng(), lng: latLngBoundsFigure[i].lat() });
                          boundspolyn.extend(new google.maps.LatLng( latLngBoundsFigure[i].lng(), latLngBoundsFigure[i].lat() ));
                        }
                        // start draw area
                        var _polyOptions = polyOptions;
                        _polyOptions['paths'] = latLngBoundRaw;
                        var polygonDrawArea = new google.maps.Polygon(_polyOptions);
                        console.log(polygonDrawArea);
                        temp.push(polygonDrawArea);
                        polygonDrawArea.setMap(map);

                        var markerHTML =' <div class="dgt-richmarker-single" style="top:-20px!important;"><strong>'+item.name+'</strong></div>';
                        marker[item.ID] = new RichMarker({
                            position: new google.maps.LatLng((item.geometry_lat), (item.geometry_lng)),
                            map: map,
                            flat: true,
                            content: markerHTML,
                            anchor: RichMarkerPosition.TOP
                        });

                        marker[item.ID].setVisible(false);
                        google.maps.event.addListener(polygonDrawArea, 'mousemove', function (event) {
                            marker[item.ID].setVisible(true);
                            marker[item.ID].setPosition(event.latLng);
                            polygonDrawArea.setOptions({ fillColor: '#ff334b', fillOpacity: 0.5});
                        });

                        google.maps.event.addListener(polygonDrawArea, 'mouseout', function (event) {
                            marker[item.ID].setVisible(false);
                          polygonDrawArea.setOptions({ fillColor: '#0072ac', fillOpacity: 0.1 });
                        });

                        google.maps.event.addListener(polygonDrawArea, 'click', function (event) {
                          window.location.href = item.url;
                        });

                      }
                  });
                }
                map.fitBounds(boundspolyn); /*centrar*/
                map.panToBounds(boundspolyn); /*zoom*/

            } else{
              if (typeof idx_neighboardhood.item_neighboardhood != undefined){

                if( idx_neighboardhood.item_neighboardhood.geometry != null ){
                    var latLngBounds = parsePolygonString(idx_neighboardhood.item_neighboardhood.geometry);
                    var latLngBoundsFigure = latLngBounds[0];
                    var latLngBoundRaw = [];
                    for (var i = 0, l = latLngBoundsFigure.length; i < l; i++) {
                      latLngBoundRaw.push({ lat: latLngBoundsFigure[i].lng(), lng: latLngBoundsFigure[i].lat() });
                    }
                    
                    locpolyn = new google.maps.LatLng(parseFloat(idx_neighboardhood.item_neighboardhood.geometry_lat), parseFloat(idx_neighboardhood.item_neighboardhood.geometry_lng));
                    boundspolyn.extend(locpolyn);

                    // start draw area
                    var _polyOptions = polyOptions;
                    _polyOptions['paths'] = latLngBoundRaw;

                    var polygonDrawArea = new google.maps.Polygon(_polyOptions);
                    polygonDrawArea.setMap(map);
                  }
              }

              if (tgmap!= undefined && tgmap != ''){
                tgmap.setCenter(new google.maps.LatLng( parseFloat(idx_neighboardhood.item_neighboardhood.geometry_lat) , parseFloat(idx_neighboardhood.item_neighboardhood.geometry_lng) ));
                tgmap.setZoom(parseInt(idx_neighboardhood.item_neighboardhood.geometry_zoom));
              }
            }        
            
    }, 150);
  });

})(window, document, jQuery);