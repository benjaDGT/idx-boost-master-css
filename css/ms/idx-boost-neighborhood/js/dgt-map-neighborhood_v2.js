var tgmap='', itemneight='', tglat=[], tglng=[], tglatsu=0, tglngsu=0 , totitem=0; methodView=2;
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
            //tmpArr.push(new google.maps.LatLng(lat, lng)); //comment for setea wrong
            tmpArr.push({lat:lat,lng:lng } );
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
    }else{
      if (dgtCredential.map_style!='no'){
        style_map=[
            {"featureType": "administrative","elementType": "labels.text", "stylers": [ { "visibility": "off" } ] },
            {"featureType": "administrative","elementType": "labels.text.fill","stylers": [ { "color": "#444444" } ] },
            {"featureType": "administrative.country", "elementType": "labels.text", "stylers": [ { "visibility": "off" } ] },
            {"featureType": "administrative.province","elementType": "geometry","stylers": [ {"visibility": "off" } ] },
            {"featureType": "administrative.province","elementType": "labels.text","stylers": [{"visibility": "off"}]},
            {"featureType": "administrative.locality","elementType": "labels.text","stylers": [{"visibility": "off"}]},
            {"featureType": "administrative.neighborhood","elementType": "labels.text","stylers": [{"visibility": "off"}]},
            {"featureType": "administrative.land_parcel","elementType": "labels.text","stylers": [{"visibility": "off"}]},
            {"featureType": "landscape","elementType": "all","stylers": [{"color": "#f2f2f2"}]},
            {"featureType": "landscape.man_made","elementType": "labels.text","stylers": [{"visibility": "on"}]},
            {"featureType": "landscape.natural","elementType": "labels.text","stylers": [{"visibility": "on"}]},
            {"featureType": "landscape.natural.terrain","elementType": "geometry.fill","stylers": [{"visibility": "on"},{"color": "#e6e6e6"}]},
            {"featureType": "poi","elementType": "all","stylers": [{"visibility": "off"}]},
            {"featureType": "poi.park","elementType": "geometry.fill","stylers": [{"visibility": "on"},{"color": "#c8e7ba"}]},
            {"featureType": "poi.park","elementType": "labels.text","stylers": [{"visibility": "off"}]},
            {"featureType": "road","elementType": "all","stylers": [{"saturation": -100},{"lightness": 45}]},
            {"featureType": "road.highway","elementType": "all","stylers": [{"visibility": "off"}]},
            {"featureType": "road.arterial","elementType": "labels.icon","stylers": [{"visibility": "off"}]},
            {"featureType": "transit","elementType": "all","stylers": [{"visibility": "off"}]},
            {"featureType": "water","elementType": "all","stylers": [{"color": "#9dd7ee"},{"visibility": "on"}]}
        ];      
      }
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
        if (jQuery('#code-map-neighboardhood').length>0){
          map = document.getElementById('code-map-neighboardhood');
        }else{
          map = document.getElementById('code-map');
        }   
        if (map !== null) {
          map = new google.maps.Map(map, mapOptions);
          tgmap=map;
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


          google.maps.event.addListener(map, 'dragend', function () {
              var c = map.getCenter();
              console.log('*********************');
              console.log(c.lat() + ', ' + c.lng() + ' + Z_' + map.getZoom());

          });


      },
      handleMarkerClick: function(map, item, infoWindow, index) {
        return function() {
          html.push('<div class="mapview-container ng-detail">');
          html.push('<div class="mapviwe-header">');
          html.push('<h2>'+item.name+'</h2>');
          html.push('</div>');
          html.push('<div class="mapviwe-body">');
          html.push('<div class="mapviwe-item">');
          html.push('<li class="properties-ng">');
          html.push('<ul class="nav-list">');
          $.each( item.silos, function( silo, permalink) {
            html.push('<li><a href="' + permalink + '" title="' + silo + '">' + silo + '</a></li>');
          });
          html.push('</ul>');
          html.push('<div class="wrap-image">');
          html.push('<img src="'+item.image+'" title="#" alt="#">');
          html.push('</div>');
          html.push('</li>');
          html.push('</div>');
          html.push('</div>');
          html.push('</div>');

          if (html.length) {
            infoWindow.setContent(html.join(''));
            infoWindow.open(map, this);
            html.length = 0;
          }

          console.log($(this.content).html());
          $('.dgt-richmarker-single').removeClass('active');
          $(this.content).addClass('active');
          this.setContent('<div class="'+$(this.content).attr('class')+' active">'+$(this.content).html()+'</div>');
          this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
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

  var polyOptions = { strokeColor: dgtCredential.map_fillcolor,
    strokeOpacity: 0.5,
    strokeWeight: 2,
    fillColor: dgtCredential.map_fillcolor,
    fillOpacity: 0.20,
    zIndex: 1,
  };

var polygonDrawArea='';
var bound_neighborhood = [];

$( ".idx_item_neigh_mobile" ).change(function() {
  var value=$(this).val();
  var exist_id=dgtCredential.item_neighboardhood.map(function(item){ return item.ID}).indexOf(value);

  if (value=='0'){
    var boundNew = new google.maps.LatLngBounds();
    $('.idx_link_detailt_neig').attr('href','');  

    bound_neighborhood.forEach(function(item){
      item.klm.setMap(tgmap);

      google.maps.event.addListener(item.klm, 'click', function (event) {
        window.location.href = dgtCredential.item_neighboardhood[exist_id].url;
      });      

    });

    
    tgmap.fitBounds(bound_neighborhood[(bound_neighborhood.length-1)].bound); //centrar
    tgmap.panToBounds(bound_neighborhood[(bound_neighborhood.length-1)].bound); //zoom    

  }else{
    $('.idx_link_detailt_neig').attr('href', dgtCredential.item_neighboardhood[exist_id].url);  
    var klm_select_exist = bound_neighborhood.map(function(item){ return item.id; }).indexOf(value);
    bound_neighborhood.forEach(function(item){
      item.klm.setMap(null);
    });

    bound_neighborhood[klm_select_exist].klm.setMap(map);
    tgmap.fitBounds(bound_neighborhood[klm_select_exist].bound); //centrar
    tgmap.panToBounds(bound_neighborhood[klm_select_exist].bound); //zoom
  }


});


  $(document).ready(function() {
    setTimeout(function(){
      var boundspolyn = new google.maps.LatLngBounds();
          map = dgt.map.getInstance();
          dgt.map.setupMarkers(dgtCredential.item_neighboardhood, true);
            var marker = [];
          $.each( dgtCredential.item_neighboardhood, function( index, community ) {
            var locpolyn;

            if(typeof  community.geometry  != "undefined"){
              console.log(community.geometry);
              if( community.geometry != null ){
                  var latLngBounds = parsePolygonString(community.geometry);
                  var latLngBoundsFigure = latLngBounds[0];
                  var latLngBoundRaw = [];
                  for (var i = 0, l = latLngBoundsFigure.length; i < l; i++) {
                    /* //comment old library
                    latLngBoundRaw.push({ lat: latLngBoundsFigure[i].lng(), lng: latLngBoundsFigure[i].lat() });
                    boundspolyn.extend(new google.maps.LatLng( latLngBoundsFigure[i].lng(), latLngBoundsFigure[i].lat() ));
                    */
                    latLngBoundRaw.push({ lat: latLngBoundsFigure[i].lng, lng: latLngBoundsFigure[i].lat });
                    boundspolyn.extend(new google.maps.LatLng( latLngBoundsFigure[i].lng, latLngBoundsFigure[i].lat ));                    
                  }
                  

                  // start draw area
                  var _polyOptions = polyOptions;
                  _polyOptions['paths'] = latLngBoundRaw;
                  

                  var polygonDrawArea = new google.maps.Polygon(_polyOptions);
                  
                  bound_neighborhood.push({ id:community.ID, klm: polygonDrawArea, bound: boundspolyn });

                  polygonDrawArea.setMap(map);

                  var markerHTML =' <div class="dgt-richmarker-single" style="top:-20px!important;"><strong>'+community.name+'</strong></div>';
                  marker[community.ID] = new RichMarker({
                      position: new google.maps.LatLng((community.lat), (community.lng)),
                      map: map,
                      flat: true,
                      content: markerHTML,
                      anchor: RichMarkerPosition.TOP
                  });

                  marker[community.ID].setVisible(false);
                  google.maps.event.addListener(polygonDrawArea, 'mousemove', function (event) {
                      marker[community.ID].setVisible(true);
                      marker[community.ID].setPosition(event.latLng);
                      polygonDrawArea.setOptions({ fillColor: dgtCredential.map_color, fillOpacity: 0.5});
                  });

                  google.maps.event.addListener(polygonDrawArea, 'mouseout', function (event) {
                      marker[community.ID].setVisible(false);
                    polygonDrawArea.setOptions({ fillColor: dgtCredential.map_fillcolor, fillOpacity: 0.1 });
                  });

                  google.maps.event.addListener(polygonDrawArea, 'click', function (event) {
                    window.location.href = community.url;
                  });
                }
              }
              
          });
          if (methodView==2) {
            if (dgtCredential.map_lat != 'default' && dgtCredential.map_lng != 'default')
              tgmap.setCenter(new google.maps.LatLng( parseFloat(dgtCredential.map_lat) , parseFloat(dgtCredential.map_lng) ));
            else
              tgmap.fitBounds(boundspolyn);

            if (dgtCredential.map_zoom != 'default')
              tgmap.setZoom(parseInt(dgtCredential.map_zoom));
            else
              tgmap.panToBounds(boundspolyn);            
          }           
      //
    }, 150);
  });

})(window, document, jQuery);