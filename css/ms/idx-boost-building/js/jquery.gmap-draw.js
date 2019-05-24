var testgeo='';
var array_extra_kml=[];
/**
 * Author:  Jhon Hinojosa Portuguez
 * email:   <jhon@dgtalliance.com>, <jhon.soco@gmail.com>
 * Date:    25/05/14
 * v.3.0
 */
var map;
var DataJson;
var markers = [];
var gZoom = 13;
var gCluster = 1;

var drawingManager;
var DrawMap = true;
var polygonArray = [];
var myField;
var tmp_params;
var ib2 = {};
var reset_click = false;

(function($) {
  $dgt = {
    isEmpty: function(a) {
      return "undefined" === typeof a || "" === a || null === a || 0 === a.length || /^\s+$/.test(a)
    },
    formatPrice: function(a) {
      "undefined" !== typeof a && !1 !== a && null !== a && !isNaN(a) && 0 <= a && !$dgt.isEmpty(a) || (a = 0);
      if (!(1E3 > a))
        if (1E6 <= a) {
          if (1E9 <= a)
            return "Any Price";
          a = (a / 1E6).toFixed(1) + "M"
        } else
          a = (a / 1E3).toFixed(1) + "K";
      return "$" + a.toString().replace(".0", "")
    },
    getPositionCity: function(needle, obj) {
      for (i = 0; i <= obj.length; i++) {
        if (obj[i].id == needle) {
          if (parseInt(obj[i].zoom) <= 10) {
            gZoom = 15;
          } else {
            gZoom = parseInt(obj[i].zoom);
          }
          gCluster = parseInt(obj[i].cluster);
          return obj[i];
        }
      }
      return false;
    },
    getPositionElement: function(needle, obj) {
      for (i = 0; i <= obj.length; i++) {
        if (obj[i].code == needle) {
          return obj[i];
        }
      }
      return false;
    },
    getGenerateCenterCoordinates: function(data) {
      var glat = [];
      var glng = [];
      var point = [];

      var list_lat = list_lng = [];
      $.each(data, function(k, point) {
        var xlat = number_format(point.lat, 1);
        var xlng = number_format(point.lng, 1);
        if (typeof list_lat[xlat] === 'undefined') {
          list_lat[xlat] = [];
        }

        if (typeof list_lng[xlng] === 'undefined') {
          list_lng[xlng] = [];
        }

        list_lat[xlat].push(point.lat);
        list_lng[xlng].push(point.lng);
      });
      var gLat = gLng = [];
      $.each(list_lat, function(k, geoLat) {
        if (gLat.length <= geoLat.length) {
          gLat = geoLat;
        }
      });
      $.each(list_lng, function(k, geoLng) {
        if (gLng.length <= geoLng.length) {
          gLng = geoLng;
        }
      });

      $.each(data, function(k, point) {
        glat.push(point.lat);
        glng.push(point.lng);
      });

      var min_lat = Math.min.apply(Math, glat);
      var max_lat = Math.max.apply(Math, glat);
      var min_lng = Math.min.apply(Math, glng);
      var max_lng = Math.max.apply(Math, glng);
      point['lng'] = (min_lng + max_lng) / 2;
      point['lat'] = (min_lat + max_lat) / 2;

      return point;

    },
    setDataJson: function(data) {
      DataJson = data;
    },
    loadMap: function(lat, lng, settingsMap) {
      if (settingsMap) {
        var mapOptions = {
          zoom: settingsMap.zoom,
          center: settingsMap.center,
          mapTypeControl: true,
          mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_RIGHT
          },
          //        disableDoubleClickZoom: true,
          panControl: false,
          panControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT
          },
          zoomControl: false,
          zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.TOP_LEFT
          },
          scaleControl: true,
          streetViewControl: false,
          streetViewControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT
          }
        };
      } else {
        var mapOptions = {
          zoom: gZoom,
          center: new google.maps.LatLng(lat, lng),
          mapTypeControl: true,
          fullscreenControl: true,
          mapTypeId: google.maps.MapTypeId.HYBRID,
          mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_RIGHT
          },
//          disableDoubleClickZoom: true,
          scrollwheel: false,
          panControl: false,
          panControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT
          },
          zoomControl: true,
          zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.RIGHT_CENTER
          },
          scaleControl: true,
          streetViewControl: false,
          streetViewControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT
          }
        };
      }

      map = new google.maps.Map(document.getElementById('gmap'), mapOptions);

      // ******************************
      if (DrawMap) {
        drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: null,
          drawingControl: true,
          drawingControlOptions: {
            position: google.maps.ControlPosition.RIGHT_TOP,
            drawingModes: [
              google.maps.drawing.OverlayType.POLYGON
            ]
          },
          polygonOptions: {
            strokeColor: "#0074a2",
            strokeOpacity: 0.80,
            strokeWeight: 3,
            fillColor: "#fff",
            fillOpacity: 0.20,
            editable: true,
            clickable: false,
            draggable: false,
            details: {
              type: google.maps.drawing.OverlayType.POLYGON
            }
          },
        });
        drawingManager.setMap(map);
//debugger;
        // EVENTOS PARA EL POLIGONO
        google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
          var gglePolyArray = polygon.getPath();

          $dgt.ShowDrawingTools(false);
          drawingManager.setDrawingMode(null);
          myField = polygon;
          polygonArray.push(gglePolyArray);
          $dgt.createControl(polygon);
          $dgt.onPolygonComplete(polygon);
          google.maps.event.addListener(gglePolyArray, 'insert_at', function() {
            return $dgt.onPolygonComplete(polygon);
          });
          google.maps.event.addListener(gglePolyArray, 'remove_at', function() {
            return $dgt.onPolygonComplete(polygon);
          });
          google.maps.event.addListener(gglePolyArray, 'set_at', function() {
            return $dgt.onPolygonComplete(polygon);
          });
        });

        google.maps.event.addDomListener(map,'zoom_changed', function() {
          $dgt.setPosition();
          if(typeof(polygonArray) === 'object') {
            return $dgt.onPolygonComplete(polygonArray);
          }
        });

        google.maps.event.addDomListener(map,'dragend', function() {
          $dgt.setPosition();
          if(typeof(polygonArray) === 'object') {
            return $dgt.onPolygonComplete(polygonArray);
          }
        });
      }
    },
    setPosition: function(){
      var z = map.getZoom();
      var c = map.getCenter();
      var position = 'z_'+z+','+c.lat()+','+c.lng();
      $('#idx_position').val(position);
    },
    addPolygon: function(polygon) {
      var newCoordPolygon = [];
      $.each(polygon, function(k, bound) {
        newCoordPolygon.push(new google.maps.LatLng(bound[1], bound[0]));
      });

      var polygonGeocode = new google.maps.Polygon({
        path: newCoordPolygon,
        strokeColor: "#0074a2",
        strokeOpacity: 0.80,
        strokeWeight: 3,
        fillColor: "#fff",
        fillOpacity: 0.20,
        editable: true,
        clickable: false,
        draggable: false,
        details: {
          type: google.maps.drawing.OverlayType.POLYGON
        }
      });
      polygonArray = polygonGeocode;
      polygonGeocode.setMap(map);
      polygonGeocode['details'] = {};
      polygonGeocode['details']['type'] = google.maps.drawing.OverlayType.POLYGON;
      myField = polygonGeocode;

      $dgt.ShowDrawingTools(false);
      $dgt.createControl(polygonGeocode);
      google.maps.event.addListener(polygonGeocode.getPath(), 'insert_at', function() {
        return $dgt.onPolygonComplete(polygonGeocode);
      });
      google.maps.event.addListener(polygonGeocode.getPath(), 'remove_at', function() {
        return $dgt.onPolygonComplete(polygonGeocode);
      });
      google.maps.event.addListener(polygonGeocode.getPath(), 'set_at', function() {
        return $dgt.onPolygonComplete(polygonGeocode);
      });

    },
    createControl: function(OverlayType) {
      var homeControl, homeControlDiv, that;
      that = this;
      homeControlDiv = document.createElement('div');
      homeControl = new $dgt.HomeControl(homeControlDiv, map, OverlayType);
      homeControlDiv.index = 1;
      return map.controls[google.maps.ControlPosition.RIGHT_TOP].push(homeControlDiv);
    },
    HomeControl: function(controlDiv, map, OverlayType) {
      var btn, label, that;
      that = $.DgtSearchMap;
      controlDiv.style.padding = '7px';
      btn = document.createElement('button');
      label = document.createTextNode("REMOVE DRAW");
      btn.className = 'btn-remove-draw';
      btn.appendChild(label);
      controlDiv.appendChild(btn);
      return google.maps.event.addDomListener(btn, 'click', $dgt.onOverlayControlRemove);
    },
    onOverlayControlRemove: function() {
      $dgt.ShowDrawingTools(true);
      $(this).parent().remove();
    },
    ShowDrawingTools: function(val) {
      if (val) {
        reset_click = false;
        $dgt.removeOverlays();
        myField.setMap(null);
      }
      drawingManager.setOptions({
        drawingMode: null,
        drawingControl: val
      });
    },
    onPolygonComplete: function(polygon) {
      if(polygon.details  === undefined){
        return false;
      }
      var type = polygon.details.type;
      // **********************
      var tmp_idx = {};
      var xparams = {};
      // **********************
      switch (type) {
        case google.maps.drawing.OverlayType.POLYGON:
          var gglePolyArray = polygon.getPath();
          geocoor = [];
          var bounds = new google.maps.LatLngBounds();
          gglePolyArray.forEach(function(item, index) {
            bounds.extend(new google.maps.LatLng( item.lat(), item.lng() ));
            geocoor.push(item.lng() + ' ' + item.lat() );
          });
          if (gglePolyArray.getArray().length) {
            geocoor.push(gglePolyArray.getAt(0).lng() + ' ' +  gglePolyArray.getAt(0).lat() );
          }
          xparams['geom'] = 'POLYGON ((' + geocoor.join(', ') + '))';
          array_extra_kml=[];
          geocoor.forEach(function(item,index){
            latlong=item.split(' ');
            array_extra_kml.push(latlong);
          });

          var center_polygon = bounds.getCenter();
          xparams['center_lat'] = center_polygon.lat();
          xparams['center_lng']  = center_polygon.lng();

          break;
        case google.maps.drawing.OverlayType.RECTANGLE:
        case google.maps.drawing.OverlayType.CIRCLE:
          bounds = polygon.getBounds();
          var ne = bounds.getNorthEast();
          var sw = bounds.getSouthWest();
          var center_polygon = bounds.getCenter();
          xparams['center_lat'] = center_polygon.lat();
          xparams['center_lng']  = center_polygon.lng();
          var wktStr = sw.lng()  + ',' + sw.lat() +',' +  ne.lng() + ',' + ne.lat()  ;
          xparams['bounds'] = wktStr;
          if (type === google.maps.drawing.OverlayType.CIRCLE) {
            xparams['radius'] = polygon.getRadius();
          }
          break;
      }

      var cmap = map.getCenter();
      var setMapParams = {};
      setMapParams['lat'] = cmap.lat();
      setMapParams['lng'] = cmap.lng();
      setMapParams['zoom'] = map.getZoom();
      setMapParams['geometry'] = xparams.geom;
      $('#dgt_map_geometry').val($.param(setMapParams));
      $('#dgt_extra_kml').val(JSON.stringify(array_extra_kml));
    },
    OptimizationPolygon: function() {
      myField.setMap(null);
      var path = polygonArray.getPath();
      var theArrayOfLatLng = path.getArray();
      var arrayForPolygonSearch = [];
      var arrayForPolygonToUse = GDouglasPeucker(theArrayOfLatLng, 50);

      var polyOptions = {
        map: map,
        path: arrayForPolygonToUse,
        strokeColor: "#0074a2",
        strokeOpacity: 0.80,
        strokeWeight: 3,
        fillColor: "#fff",
        fillOpacity: 0.20,
        editable: true,
        clickable: false,
        draggable: false,
        details: { type: google.maps.drawing.OverlayType.POLYGON }
      };


      //$dgt.onPolygonComplete(arrayForPolygonToUse);

      [].forEach.call(arrayForPolygonToUse, function(item) {
        arrayForPolygonSearch.push(item.lng() + " " + item.lat());
      });
      if (path.getArray().length) {
        arrayForPolygonSearch.push(path.getAt(0).lng() + ' ' + path.getAt(0).lat());
      }
      if (arrayForPolygonSearch.length) {
        var geometry = 'POLYGON ((' + arrayForPolygonSearch.join(", ") + '))';
      }

      //****************************
      myField = new google.maps.Polygon(polyOptions);
      myField.setMap(map);

      var cmap = map.getCenter();
      var setMapParams = {};
      setMapParams['lat'] = cmap.lat();
      setMapParams['lng'] = cmap.lng();
      setMapParams['zoom'] = map.getZoom();
      setMapParams['geometry'] = geometry;
      $('#dgt_map_geometry').val($.param(setMapParams));
      $('#dgt_extra_kml').val(JSON.stringify(array_extra_kml));

    },
    removeOverlays: function() {
      polygonArray = [];
      if (markers.length > 0) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
      }
      $('#dgt_map_geometry').val("");
    },
  }
})(jQuery);

;(function($, window, undefined){
  $(document).on('click', 'a.regetate-kml', function(e) {
    $dgt.OptimizationPolygon();
    e.preventDefault();
  });

})(jQuery, window);


function strstr(haystack, needle, bool) {
  var pos = 0;
  haystack += '';
  pos = haystack.indexOf(needle);
  if (pos == -1) {
    return false;
  }
  else {
    if (bool) {
      return haystack.substr(0, pos);
    } else {
      return haystack.slice(pos);
    }
  }
}

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
          .toFixed(prec);
    };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function getFormatPrice(number) {
  return '$' + number_format(number, 0);
}

function dgt_open_lightbox(link, i, width) {
  var $ = jQuery;
  var $this = $(link);
  var urllightbox = $this.attr('rel');
  $.lightbox(urllightbox, {
    iframe: true,
    width: width,
    height: ($(window).height() - 50)
  });
  ib2[i].close();
}
