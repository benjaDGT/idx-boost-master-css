(function(window, document, $, undefined) {
  var dgt_center_lat = 25.8171645;
  var dgt_center_lng = -80.2085178;
  var dgt_zoom = 12;
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

    var mapOptions = {
      zoom: dgt_zoom,
      center: new google.maps.LatLng(dgt_center_lat,dgt_center_lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDoubleClickZoom: false,
      mapTypeControl: true,
      mapTypeControlOptions: {
        position: google.maps.ControlPosition.TOP_RIGHT
      },
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
        map = document.getElementById('code-map');
        if (map !== null) {
          map = new google.maps.Map(map, mapOptions);
        }
        mapControlsDiv = document.createElement('div');
        mapControl = new dgt.map.setupMapControls(mapControlsDiv, map);
        mapControlsDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapControlsDiv);
      },
      refresh: function() {
        google.maps.event.trigger(map, 'resize');
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

      },
      handleMarkerClick: function(map, item, infoWindow, index) {
        return function() {
          location.href = item.url;
        };
      },
      handleMouseOver: function(map, item, infoWindow, index) {
        return function() {
          this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
        };
      },
      handleMouseOut: function(map, item, infoWindow, index) {
        return function() {
          this.setZIndex(google.maps.Marker.MAX_ZINDEX - 1);
        };
      },
      getInstance: function() {
        return map;
      },
      returnUniqueProperties: function () {
        return unique_properties;
      },
      returnMarkers: function() {
        return markers;
      },
      setupMarkers: function(items, store) {
        map =  dgt.map.getInstance();
        if ((arguments.length == 1 && typeof arguments[0] === "boolean") || ((arguments.length == 2) && items.length && store == true)) {
          var items = (tmp_items.length > 0) ? tmp_items : ((items.length > 0) ? items : []);
          dgt.map.removeMarkers();
          bounds = new google.maps.LatLngBounds();
          infoWindow = new google.maps.InfoWindow({
            maxWidth: 350
          });
          // custom customization for infowindow
          google.maps.event.addListener(infoWindow, 'domready', function() {
            // Reference to the DIV that wraps the bottom of infowindow
            var iwOuter = $('.gm-style-iw');
            var iwBackground = iwOuter.prev();
            iwBackground.parent().addClass('infobox ng-info');
            iwBackground.addClass('iwpoint');
            // Reference to the div that groups the close button elements.
            var iwCloseBtn = iwOuter.next();
            iwCloseBtn.addClass('close-item-map');
          });

          for (var i = 0, l = items.length; i < l; i++) {
            row = items[i];
            geocode = row.lat + ':' + row.lng;
            if (_.indexOf(hashed_properties, geocode) === -1) {
              hashed_properties.push(geocode);
              filtered_properties.push(row);
            }
          }
          // reduce markers [second step]
          for (var i = 0, l = filtered_properties.length; i < l; i++) {
            row = filtered_properties[i];
            geocode = [row.lat, row.lng];
            // reset array
            var related_properties = [];
            for (var k = 0, m = items.length; k < m; k++) {
              inner = items[k];
              if ((inner.lat == geocode[0]) && (inner.lng == geocode[1])) {
                related_properties.push(inner);
              }
            }
            unique_properties.push({
              item: row,
              group: related_properties
            });
          }

          for (var i = 0, l = unique_properties.length; i < l; i++) {
            item = unique_properties[i].item;
            markerHTML.push(' <div class="dgt-richmarker-single"><strong>'+item.name+'</strong></div>');

            marker = new RichMarker({
              position: new google.maps.LatLng(parseFloat(item.lat), parseFloat(item.lng)),
              map: map,
              flat: true,
              content: markerHTML.join(""),
              anchor: RichMarkerPosition.TOP
            });

            marker.geocode = item.lat + ':' + item.lng;
            markers.push(marker);
            bounds.extend(marker.position);

            marker.addListener("click", dgt.map.handleMarkerClick(map, item, infoWindow, i));
            marker.addListener("mouseover", dgt.map.handleMouseOver(map, item, infoWindow, i));
            marker.addListener("mouseout", dgt.map.handleMouseOut(map, item, infoWindow, i));
            if (markerHTML.length) {
              markerHTML.length = 0;
            }
          }
          tmp_items.length = 0;
        } else {
          tmp_items = items;
        }

      },
      removeMarkers: function() {
        if (hashed_properties.length) {
          hashed_properties.length = 0;
        }
        if (filtered_properties.length) {
          filtered_properties.length = 0;
        }
        if (unique_properties.length) {
          unique_properties.length = 0;
        }
        if (markers.length) {
          for (var i = 0, l = markers.length; i < l; i++) {
            markers[i].setMap(null);
          }
          markers.length = 0;
        }
      },

      setPosition: function(){
        var z = map.getZoom();
        var c = map.getCenter();
        var position = 'z_'+z+','+c.lat()+','+c.lng();
        console.log(position);
        $('#idx_position').val(position);
      },
      hideMarkers: function(){
        if (markers.length) {
          for (var i = 0, l = markers.length; i < l; i++) {
            markers[i].setMap(null);
          }
        }
      },
      showMarkers: function(){
        map =  dgt.map.getInstance();
        if (markers.length) {
          for (var i = 0, l = markers.length; i < l; i++) {
            markers[i].setMap(map);
          }
        }
      },
    };
  })();

  $(dgt.map.init);

  var polyOptions = { strokeColor: "#0072ac",
    strokeOpacity: 0.5,
    strokeWeight: 2,
    fillColor: "#0072ac",
    fillOpacity: 0.20,
    zIndex: 1,
  };

  
  var show_homepage = false;
  $.loadMapNeighrborhoods = function(){
    $.ajax({
      url: dgtCredential.ajaxUrl,
      type: "POST",
      data: {action: 'dgt_load_buildings', only_special: dgtCredential.only_special, counter: dgtCredential.counter},
      dataType: "json",
      /*beforeSend: function () {
        NProgress.start();
      },*/
      success: function(response) {
        var map = dgt.map.getInstance();
        dgt.map.setupMarkers(response.items, true);
        $.each( response.items, function( index, community ) {
          if(typeof community.geometry != "undefined" && community.geometry != null){
            var latLngBounds = parsePolygonString(community.geometry);
            var latLngBoundsFigure = latLngBounds[0];
            var latLngBoundRaw = [];
            for (var i = 0, l = latLngBoundsFigure.length; i < l; i++) {
              latLngBoundRaw.push({ lat: latLngBoundsFigure[i].lng(), lng: latLngBoundsFigure[i].lat() });
            }

            // start draw area
            var _polyOptions = polyOptions;
            _polyOptions['paths'] = latLngBoundRaw;

            var polygonDrawArea = new google.maps.Polygon(_polyOptions);
            polygonDrawArea.setMap(map);
            
            google.maps.event.addListener(polygonDrawArea, 'mousemove', function (event) {
              polygonDrawArea.setOptions({ fillColor: '#0072ac', fillOpacity: 0.5});
            });

            google.maps.event.addListener(polygonDrawArea, 'mouseout', function (event) {
              polygonDrawArea.setOptions({ fillColor: '#0072ac', fillOpacity: 0.1 });
            });    

            google.maps.event.addListener(polygonDrawArea, 'click', function (event) {
              location.href = community.url;
            });        
          }
        });
      },
      error: function (request, error) {
        console.log(arguments);
        console.log(" Can't do because: " + error);
      },
    })/*.done(function(response){
      NProgress.done();
    })*/;
  }

  $(window).on('load', function() {
    setTimeout(function(){
      if(!$('body').hasClass('home')) $.loadMapNeighrborhoods();
    }, 1500);
  });

})(window, document, jQuery);