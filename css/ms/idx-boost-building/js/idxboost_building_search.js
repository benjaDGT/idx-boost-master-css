var web_page='', filurlneigh='', filurlcat='',filurlview='' ,textFilterHash=''; 
var pag_fil=1,limit_fil=20,submit_fil=0; inifil_default=4;  tgmap='', boundspolyn = '',temoara=[],polygonDrawOld=[], eventchange=''; 
var temparray=[],temparraymap=[],list_item_show=[];
var ar_cate_list=[];
var list_neighborhood=[];

/*KLM*/
  var polyOptions = { strokeColor: '#0072ac',
    strokeOpacity: 0.5,
    strokeWeight: 2,
    fillColor: '#0072ac',
    fillOpacity: 0.20,
    zIndex: 1,
  };
/*KLM*/

window.mobileAndTabletcheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};

  function parsePolygonStringklm(ps) {
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

(function(window, document, $, undefined) {
  var dgt_center_lat = 25.8171645;
  var dgt_center_lng = -80.2085178;
  var dgt_zoom = 12;
  
  var dgt = (function() {
    return {};
  })();

function func_hide_map(){
  var neighborhood_select=$('.neighborhood_select').val();
  var regis_option=$('#filter-views').find('option');
    if (submit_fil != '1'){
      if (neighborhood_select == 'all'){
        if (regis_option.length != 0){
          /*
          for (i = 0; i < regis_option.length; i++) {
              if(regis_option.eq(i).val()=='map')
                regis_option.eq(i).css({display:'none'});
            }
            $('#filter-views select').val('list');
            */
            $('#filter-views select').change();    
        }else{
          /*
          regis_option=$('#filter-views ul li');  
          for (i = 0; i < regis_option.length; i++) {
              if (regis_option.eq(i).attr('class').match(/^.*map.*$/))
                  regis_option.eq(i).css({display:'none'});
          }
          $('#filter-views li.list').click();        
          */
        }
      }else{
        //if (regis_option.length == 0) regis_option=$('#filter-views ul li');  
        regis_option.css({display:'inherit'});
      } 
    }    
}

function reset_object_filters(no_include = ''){
  
  if (no_include != 'condos_select') {
    $('.condos_select').prop('selectedIndex',0);
    textFilterHash='';
    history.replaceState(null, null, ' ');
  }

  if(no_include !='neighborhood_select') {
    $('.neighborhood_select').prop('selectedIndex',0);
  }

  if(no_include !='search_building') {
    $('.search_building').val('');
    textFilterHash='';
    history.replaceState(null, null, ' ');
  }

}


function search_condos() {
if (eventchange !='scroll' && inifil_default ==5){ jQuery('.result-search-result').html('');  $('.num_page').val('0'); $('.num_page').attr('pagnum',('0')); $('.content-search-building').removeClass('idxboost-active'); }
var condos_select=0, responseHTML=[],neighborhood_select='all',type_search='all', htmlResponse='',search_building='';
var urlFilter=[];
  func_hide_map();
  search_building=$('.search_building').val();
  type_search=$('.type_search').val();
  neighborhood_select=$('.neighborhood_select').val();
  condos_select=$('.condos_select').val();

if (submit_fil!=2)  { temparray=[]; list_item_show=[]; temparraymap=[]; $('.num_page').val(''); filurlcat=''; filurlneigh=''; }

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      filurlview=$('#filter-views select').val();
    }else{
      filurlview=$('#filter-views ul li.active').text().toLowerCase();
    }

    if (idxboostConf.ItemSearchResult.success === true){
      pag_fil=0;

        if (submit_fil==2){
          pag_fil=parseInt($('.num_page').val())-1;
        }else if (submit_fil==1){
            if (search_building.length>0){
              temparray=idxboostConf.ItemSearchResult.result.filter(function(item){
                return item.post_title==search_building
              });
            }else{
              temparray=idxboostConf.ItemSearchResult.result.slice();
            }
        
        }else if (condos_select !='0') {
          temparray=idxboostConf.ItemSearchResult.result.filter(function(item){
            return item.ID==condos_select
          });
        }else{

              temparray=idxboostConf.ItemSearchResult.result.filter(function(item){
                var query_cat=[];
                var arquery=[];

                if (type_search !='all'){

                    ar_cate_list.forEach(function(catlist){
                        if (eval('item.ctId_'+catlist) != undefined){
                            query_cat.push('item.ctId_'+catlist+'=='+type_search);
                        }
                    });

                  if (query_cat.length>0){
                    arquery.push(query_cat.join(' || '));
                  }

                  filurlcat= $(".type_search option:selected").text();
                }

                if ( mobileAndTabletcheck() && neighborhood_select !='all' ){
                  arquery.push('item.neighborhood_id=='+ neighborhood_select);
                }
                if (neighborhood_select !='all') {
                    textFilterHash=encodeURIComponent($(".neighborhood_select option:selected").text()).replace(/%20/g,'-').toLowerCase();
                }
                

                if (arquery.length>0) {
                  return eval(arquery.join(' && '));
                }else{
                  return item;
                }
              });

            //for at map in desktop
            if ( mobileAndTabletcheck()===false && neighborhood_select !='all' ){
              temparraymap=temparray.filter(function(item){
                return item.neighborhood_id==$('.neighborhood_select').val()
              });
            }           
        }

        var num_page= $('.num_page').attr('pagnum');
        if( num_page != '' && num_page!= '0' &&  inifil==4 ){
          pag_fil=parseInt($('.num_page').attr('pagnum'))-1;          
          $('.num_page').val($('.num_page').attr('pagnum'));
        }

          temparray.sort(orderbybuilding);

          //show data for hash and search to find neighborhood
          var limitnew=0;
          if (textFilterHash != '' && mobileAndTabletcheck()===false) {
            limitnew=find_neighbordhood_for_hash(pag_fil,limit_fil,textFilterHash.replace(/[^a-zA-Z ]/g, " ") );
            limit_fil=limitnew;
          }

          temparray.slice((pag_fil*limit_fil),(pag_fil*limit_fil)+limit_fil).forEach(function(item,index){
            list_item_show.push(item);

              var vaneighborhood_id=0;
              if ( item.neighborhood_id.length != 0 ){
                vaneighborhood_id=item.neighborhood_id;
              }
                eval('neigh_list_'+vaneighborhood_id).push(item);
                responseHTML[vaneighborhood_id]='1';
          });

          if (textFilterHash !=''){
            if (mobileAndTabletcheck()) {
              urlFilter.push('area='+textFilterHash);
            }
          }
          
          if (filurlcat !='') {
            urlFilter.push('category='+filurlcat);
          }
         
          if ($('.num_page').val() != ''){
            pag_fil=$('.num_page').val();
          }

          var map = dgt.map.getInstance();

          if(inifil_default !=4){           
            if (urlFilter.length>0) {
              var web_pages='';
              web_pages=$('.web_page').val()+'?'+urlFilter.join('&');
              history.pushState(null, '', web_pages );       
            }

          }
              
            var  listbuild=[];
            if (eventchange == 'collection'){
                  var post_neig=idxboostConf.idxboost_neigboardhood.map(function(item){ return item.ID;}).indexOf(neighborhood_select);

                  if ( mobileAndTabletcheck()===false && temparraymap.length>0 ){
                    dgt.map.setupMarkers(temparraymap, true);
                  }else{
                    dgt.map.setupMarkers(temparray, true);
                  }

                  if (post_neig != '-1' && neighborhood_select !='all' ){
                      
                        if (idxboostConf.idxboost_lat != 'default' && idxboostConf.idxboost_lng != 'default'){
                          tgmap.setCenter(new google.maps.LatLng( parseFloat(idxboostConf.idxboost_lat) , parseFloat( idxboostConf.idxboost_lng ) ));
                        }else{
                          tgmap.setCenter(new google.maps.LatLng( parseFloat(idxboostConf.idxboost_neigboardhood[post_neig].geometry_lat) , parseFloat( idxboostConf.idxboost_neigboardhood[post_neig].geometry_lng ) ));
                        }           

                        if (idxboostConf.idxboost_zoom !='default'){
                          tgmap.setZoom(parseInt(idxboostConf.idxboost_zoom));
                        }else{
                          tgmap.setZoom(parseInt(idxboostConf.idxboost_neigboardhood[post_neig].zoom));                      
                        }
                  }

              fc_position_map();

            }else if (eventchange=='search'){
              dgt.map.setupMarkers(temparray, true);
              fc_position_map();
            }

          }

              //$('.content-search-building').hide();
              responseHTML.forEach(function(item,index){

              var dgt_extra_unit='';
              if(item.dgt_extra_unit != undefined ){
                if (item.dgt_extra_unit.length>0){
                  dgt_extra_unit=item.dgt_extra_unit;
                }
              }
                              
              eval('neigh_list_'+index).sort((a, b) => a['post_title'].localeCompare(b['post_title']));
              
              eval('neigh_list_'+index).forEach(function(item){
                var class_property='propertie',li_year='';
                if (idxboostConf.idxboost_labels=='year'){
                  class_property='propertie ib-grid-full';
                }
                var build_floor='0',build_unit='0',build_year='';
                if (item.floor!= null && item.floor != undefined && item.floor != "")
                  build_floor=item.floor;

                if(item.dgt_extra_unit != null && item.dgt_extra_unit != undefined)
                  build_unit=item.dgt_extra_unit;

                if (item.dgt_year_building != null && item.dgt_year_building != undefined)
                  build_year=item.dgt_year_building;

                eval('neigh_'+index).push('<li class="'+class_property+'" data-geocode="'+item.lat+':'+item.lng+'"> <h2 title="'+item.post_title+'"><span>'+item.post_title+'</span></h2> <ul class="features"> <li class="name"><span>'+item.post_title+'</span></li> <li class="address" data-text="Address:"><span>'+item.dgt_extra_address+'</span></li> <li class="unit" data-text="Unit:">'+build_unit+'</li> <li class="floors" data-text="Floors:"><span>'+build_floor+'</span></li> <li class="year" data-text="Year:"><span>'+build_year+'</span></li> <li class="city" data-text="City:"><span>'+item.neighborhood+'</span></li> </ul> <div class="wrap-slider"> <ul> <li class="flex-slider-current"><img data-original="'+item.tgbuilding_image+'" alt="'+item.post_title+'" class="flex-lazy-image loaded"></li> </ul> <button class="clidxboost-btn-check"><span class="clidxboost-icon-check"></span></button> </div> <a href="'+item.tgbuilding_url+'" class="view-detail">&nbsp;</a> <button class="ib-btn-show"><span></span></button> <div class="tg-building-links"><a class="view-map-detail view_inmap mbt-active" data-geocode="'+item.lat+':'+item.lng+'">View Map</a></div></li>');
              });

                $('.result-search-'+index).append(eval('neigh_'+index).join(""));
                eval('neigh_'+index).splice(0);
                eval('neigh_list_'+index).splice(0);
                jQuery('.idx-filter-item-'+index).removeClass('idxboost-inactive').addClass('idxboost-active');
                $('.content-search-'+index).addClass('idxboost-active');

            });

            if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
            submit_fil=0;
            inifil=5;
            inifil_default=5;
            if (mobileAndTabletcheck()===false && neighborhood_select !='all' ) {
              textFilterHash=encodeURIComponent(textFilterHash).replace(/%20/g,'-').toLowerCase();
              document.location.hash=textFilterHash;
            }
   }

function find_neighbordhood_for_hash(vpag_fil,vlimit_fil,textFilter){
var responseFilter=[];
var limitnew=0;
    responseFilter=temparray.slice((vpag_fil*vlimit_fil),(vpag_fil*vlimit_fil)+vlimit_fil).filter(function(item){
        return item.neighborhood.toLowerCase()==textFilter
    });
  
    if(responseFilter.length==0){
    limitnew=vlimit_fil+20;
        vlimit_fil=find_neighbordhood_for_hash(pag_fil,limitnew,textFilter);
     }
  return vlimit_fil;
}


function orderbybuilding(a,b) {
  if (a.neighborhood =="")  return 1;   
  if (b.neighborhood=="")  return -1;

  if (a.neighborhood < b.neighborhood) return -1;
  if (a.neighborhood > b.neighborhood) return 1;

  if  (a.post_title < b.post_title) return -1;
  if  (a.post_title > b.post_title) return 1;
  if  (a.post_title == b.post_title) return 0;
}


function fc_position_map(method = 'default'){ 
  if (tgmap != null && tgmap != '' ){
    if (method=='change_view'){

      //if(tgmap.getZoom() >0 && tgmap.getZoom()<5 )
        tgmap.fitBounds(boundspolyn);
      
    }else{
      if (inifil_default=='4' && idxboostConf.idxboost_lat != 'default' && idxboostConf.idxboost_lng != 'default' ){
        tgmap.setCenter(new google.maps.LatLng( parseFloat(idxboostConf.idxboost_lat) , parseFloat( idxboostConf.idxboost_lng ) ));
      }else{
        tgmap.fitBounds(boundspolyn);
      }

      if (inifil_default=='4' && idxboostConf.idxboost_zoom !='default'){
        tgmap.setZoom(parseInt(idxboostConf.idxboost_zoom));              
      }else{
        tgmap.panToBounds(boundspolyn);
      }
    }


    google.maps.event.trigger(tgmap, 'resize');
  }
}

var $cuerpo = $('body');
    var $ventana = $(window);
    var $widthVentana = $ventana.width();
    var $htmlcuerpo = $('html, body');
    //alert('Ancho: ' + $ventana.width() + 'px - Alto: ' + $ventana.height() + 'px');
    $ventana.on('load', function() {
        $cuerpo.removeClass('loading');
    });
    // Seleccionador de clases en los filtros.
    var $viewFilter = $('#filter-views');
    if ($viewFilter.length) {
        var $wrapResult = $('#wrap-result');
        // Cambio de vista por SELECT NATIVO
        $viewFilter.on('change', 'select', function() {
            switch ($(this).find('option:selected').val()) {
                case 'grid':
                    $viewFilter.removeClass('list map').addClass('grid');
                    $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                    $cuerpo.removeClass('view-list view-map');
                    break
                case 'list':
                    $viewFilter.removeClass('grid map').addClass('list');
                    $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                    $cuerpo.addClass('view-list').removeClass('view-map');
                    break
                case 'map':
                    $viewFilter.removeClass('list grid').addClass('map');
                    $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                    $cuerpo.removeClass('view-list').addClass('view-map');
                    //$(dgt.map.refresh);
                    fc_position_map('change_view');
                    break
            }
          web_page=jQuery('.web_page').val();
          web_page +='?';
          filurlview=$('#filter-views select').val();
          if (filurlneigh !='')
            web_page +='area='+filurlneigh+'&';         
          if (filurlcat !='') 
            web_page +='category='+filurlcat+'&';
          if (filurlview !='') 
              web_page +='view='+filurlview+'&';            
          if ($('.num_page').val() != ''){
            //web_page +='pag='+$('.num_page').val();
            pag_fil=$('.num_page').val();
          }
          if(inifil_default !=4) 
              history.pushState(null, '', web_page );

        });
        // Cambio de estado por select combertido a lista
        $viewFilter.on('click', 'li', function() {
            $(this).addClass('active').siblings().removeClass('active');
            switch ($(this).attr('class').split(' ')[0]) {
                case 'grid':
                    $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                    $cuerpo.removeClass('view-list view-map');
                    break
                case 'list':
                    $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                    $cuerpo.addClass('view-list').removeClass('view-map');
                    break
                case 'map':
                    $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                    $cuerpo.removeClass('view-list').addClass('view-map');
                    //$(dgt.map.refresh);
                    fc_position_map('change_view');
                    //scrollResultados(true);
                    break
            }
          web_page=jQuery('.web_page').val();
          web_page +='?';
          filurlview=$('#filter-views ul li.active').text().toLowerCase();
          if (filurlneigh !='')
            web_page +='area='+filurlneigh+'&';         
          if (filurlcat !='') 
            web_page +='category='+filurlcat+'&';
          if (filurlview !='') 
              web_page +='view='+filurlview+'&';            
          if ($('.num_page').val() != ''){
            //web_page +='pag='+$('.num_page').val();
            pag_fil=$('.num_page').val();
          }
          if(inifil_default !=4) 
            history.pushState(null, '', web_page );

        });

        if ($ventana.width() >= 768) {
            mutaSelectViews(true); //,por defecto que mute
        }

        $ventana.on('resize', function() {
            var $widthVentana = $ventana.width();
            if ($widthVentana >= 768) {
                mutaSelectViews(true)
            } else if ($widthVentana < 768) {
                mutaSelectViews(false);
            }
        });

        function mutaSelectViews(estado) {
            if (estado) {
                if (!$viewFilter.find('ul').length) {
                    var $optionActive = $viewFilter.find('option:selected').val();
                    $viewFilter.find('option').each(function() {
                        $(this).replaceWith('<li class="' + $(this).val() + '">' + $(this).text() + '</li>');
                    });
                    var $theSelect = $viewFilter.find('select');
                    $theSelect.replaceWith('<ul>' + $theSelect.html() + '</ul>');
                    $viewFilter.find('.' + $optionActive).addClass('active');
                    $viewFilter.removeClass($optionActive);
                }
            } else {
                if (!$viewFilter.find('select').length) {
                    var $indexLiActive = $viewFilter.find('.active').index();
                    var $classLiActive = $viewFilter.find('.active').attr('class').split(' ')[0];
                    $viewFilter.find('li').each(function() {
                        $(this).replaceWith('<option value="' + $(this).attr('class').split(' ')[0] + '">' + $(this).text() + '</option>');
                    });
                    var $theUl = $viewFilter.find('ul');
                    $theUl.replaceWith('<select>' + $theUl.html() + '</select>');
                    $viewFilter.find('option').eq($indexLiActive).prop('selected', true).siblings().prop('selected', false);
                    $viewFilter.addClass($classLiActive);
                }
            }
        }
    }

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
      zoom: dgt_zoom,
      center: new google.maps.LatLng(dgt_center_lat,dgt_center_lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDoubleClickZoom: true,
      mapTypeControl: true,
      mapTypeControlOptions: {
        position: google.maps.ControlPosition.TOP_RIGHT
      },
      styles: style_map,
      gestureHandling: mobileAndTabletcheck() ? 'greedy' : 'cooperative',
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

      },
      handleMarkerClick: function(map, item, infoWindow, index) {
      if ( item.lat != '' && item.lng !='' && item.lat != null && item.lng != null ){
        var html=[];
                return function() {

                        html.push('<div class="mapview-container">');
                        html.push('<div class="mapviwe-header">');
                        html.push('<h2>' + item.neighborhood + '</h2>');
                        html.push('<button class="closeInfo"><span>'+word_translate.close+'</span></button>');
                        html.push('</div>');
                        html.push('<div class="mapviwe-body">');
                        html.push('<div class="mapviwe-item">');
                        html.push('<h2 title="' + item.post_title + '"><span>' + item.post_title + '</span></h2>');
                        html.push('<ul>');
                        html.push('<li class="address"><span>' + item.dgt_extra_address.replace(/ , /, ', ') + '</span></li>');
                        html.push('<li class="baths"><span> '+word_translate.units+':&nbsp' + item.dgt_extra_unit + '</span></li>');
                        html.push('<li class="beds"><span> '+word_translate.year+':&nbsp' + item.dgt_year_building + '</span></li>');
                        html.push('</ul>');
                        html.push('<div class="mapviwe-img">');
                        html.push('<img title="' + item.post_title + '" src="' + item.tgbuilding_image + '">');
                        html.push('</div>');
                        html.push('<a href="' + item.tgbuilding_url + '" title="' + item.post_title + '"></a>');
                        html.push('</div>');
                        html.push('</div>');
                        html.push('</div>');

                  if (html.length) {
                    infoWindow.setContent(html.join(''));
                    infoWindow.open(map, this);
                    html.length = 0;
                  }
                  $('.dgt-richmarker-single').removeClass('active');
                  $(this.content).addClass('active');
                  
                  if (__flex_g_settings.is_mobile != '1'){
                    this.setContent('<div class="'+$(this.content).attr('class')+' active">'+$(this.content).html()+'</div>');
                  }

                  this.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
                  //location.href = item.url;
                };
        
      }
              
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
          dgt.map.removeMarkers();
        if ((arguments.length == 1 && typeof arguments[0] === "boolean") || ((arguments.length == 2) && items.length && store == true)) {
          var items = (tmp_items.length > 0) ? tmp_items : ((items.length > 0) ? items : []);
          dgt.map.removeMarkers();
          bounds = new google.maps.LatLngBounds();
        infoWindow = new InfoBubble({
            map: map,
            disableAutoPan: false,
            shadowStyle: 0,
            padding: 0,
            borderRadius: 0,
            borderWidth: 0,
            disableAnimation: true,
            maxWidth: 380
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
            if ( item.lat != '' && item.lng !='' && item.lat != null && item.lng != null ){
//comentado temporalmente
/*
            
            if(__flex_g_settings.is_mobile == '1'){
              var marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(item.lat), parseFloat(item.lng)),
                map: map,
                title: item.post_title
              });

            }else{
*/
                markerHTML.push(' <div class="dgt-richmarker-single"><strong>'+item.post_title+'</strong></div>');
                  marker = new RichMarker({
                    position: new google.maps.LatLng(parseFloat(item.lat), parseFloat(item.lng)),
                    map: map,
                    flat: true,
                    content: markerHTML.join(""),
                    anchor: RichMarkerPosition.TOP
                  });
            //}

            
              
              
                
              
              marker.geocode = item.lat + ':' + item.lng;
              markers.push(marker);
              bounds.extend(marker.position);
              boundspolyn = bounds;
              /*COMENTADO PARA QUE LA FUNCION PRINCIPAL REALIZE EL EVENTO DE CENTRADO*/
              //map.fitBounds(bounds);
              //map.panToBounds(bounds);
              /*COMENTADO PARA QUE LA FUNCION PRINCIPAL REALIZE EL EVENTO DE CENTRADO*/
              
              //google.maps.event.addListener(marker, "click", handleMarkerClick(map, item, infoWindow, i));
              marker.addListener("click", dgt.map.handleMarkerClick(map, item, infoWindow, i));
              marker.addListener("mouseover", dgt.map.handleMouseOver(map, item, infoWindow, i));
              marker.addListener("mouseout", dgt.map.handleMouseOut(map, item, infoWindow, i));
              if (markerHTML.length) {
                markerHTML.length = 0;
              }
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

  var polyOptions = { strokeColor: "#0072ac",
    strokeOpacity: 0.5,
    strokeWeight: 2,
    fillColor: "#0072ac",
    fillOpacity: 0.20,
    zIndex: 1,
  };


  var show_homepage = false;
$(document).ready(function(){
  
  textFilterHash=decodeURIComponent(window.location.hash.substring(1)).replace(/[^a-zA-Z ]/g, " ");

  if (mobileAndTabletcheck()===false) {
    $('.neighborhood_select option').each(function(){
      if( encodeURIComponent(jQuery(this).text()).replace(/%20/g,' ').toLowerCase() ==textFilterHash){
        $(this).attr('selected','selected');
      }
    });
  }

  /*
  if (list_neighborhood.length === 0) {
    if ( 
        typeof(idxboostConf.ItemSearchResult.result) === "object" && 
        idxboostConf.ItemSearchResult.success === true
      ){
      list_neighborhood=idxboostConf.ItemSearchResult.result.map(function(item){
        return {id:item.neighborhood_id,name:item.neighborhood}
      }).filter(function(value, index, self){
        return self.map(function(itema){ return itema.id}).indexOf(value.id)===index
      });

    }
  }
  */
  $(dgt.map.init);
  
  $('.type_search option').each(function(item){
    if (jQuery(this).attr('value') != 'all'){
      ar_cate_list.push(jQuery(this).attr('value'));
    }
  });

  myLazyLoad = new LazyLoad({
    elements_selector: ".flex-lazy-image",
    callback_load: function(element){
      $(element).parent('span').addClass('loaded');
    },
    callback_error: function(element){
      $(element).parent('span').addClass('loaded');
      $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
      $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
    }
  }); 

if ($('body').hasClass( "clidxboost-ngrid")) {
  $('body').removeClass( "clidxboost-ngrid");
}
  $('body').addClass('clidxboost-ngrid').removeClass('clidxboost-gridv2');

  $('.neighborhood_select').change(function(){

    var neighborhood_select=$(".neighborhood_select option:selected").text();
    var neighborhood_select_value=$(this).val();
    get_neighborhood_show=[];

    if (list_item_show.length>0) {
      get_neighborhood_show=list_item_show.map(function(item){
        return {id:item.neighborhood_id,name:item.neighborhood}
      }).filter(function(value){
        return value.name==neighborhood_select
      });
    }

    if ( ( get_neighborhood_show.length==0 || mobileAndTabletcheck() ) || neighborhood_select_value=='all' ) {
      submit_fil=3; limit_fil=20;
      if (neighborhood_select_value=='all') {
        history.replaceState(null, null, ' ');
      }

      if ($(this).attr('name')=='neighborhood_select')    $('.condos_select').val(0);  
      eventchange='collection';
      reset_object_filters("neighborhood_select");
      search_condos();

    }else{
      var hash_neig='';
      hash_neig=encodeURIComponent( neighborhood_select ).replace(/%20/g,'-').toLowerCase();
      if (hash_neig != '') {

        if (!$("body").hasClass("view-map")) {
          history.pushState(null, '', jQuery('.web_page').val()+'#'+hash_neig );
          var offsetIdPosition = 0;
          var sectionId = $("#"+hash_neig);
          var offsetId = sectionId.offset();
          offsetIdPosition = offsetId.top - 220;
          $("html, body").animate({ scrollTop: offsetIdPosition }, 900);
        }else{
          document.location.hash=hash_neig;
        }

        //document.location.hash=hash_neig;
        //history.pushState(null, '', jQuery('.web_page').val()+'#'+hash_neig );

        /*var offsetIdPosition = 0;

        var sectionId = $("#"+hash_neig);
        var offsetId = sectionId.offset();
        offsetIdPosition = offsetId.top - 220;
        $("html, body").animate({ scrollTop: offsetIdPosition }, 900);*/

        //process to get the map
        if ( mobileAndTabletcheck()===false && neighborhood_select_value !='all' ){
          temparraymap=[];
          temparraymap=temparray.filter(function(item){
            return item.neighborhood_id==neighborhood_select_value
          });
        }

        if ( mobileAndTabletcheck()===false && temparraymap.length>0 ){
          dgt.map.setupMarkers(temparraymap, true);
        }
        fc_position_map();
        //process to get the map


      }
      
    }

  });

  $('.condos_select').change(function(){
      reset_object_filters("condos_select");
  });

$('.type_search, .condos_select').change(function(){
  submit_fil=3;
  eventchange='collection';
  search_condos();
});

$('.type_search').change(function(){
var FilShow=[], tem_buil=[],tem_buil_order=[], FilShowNeig=[];
FilShow.push('<option value="0">'+$(this).find('option:selected').text()+' '+word_translate.by_Name+'</option>');
var list_to_order=idxboostConf.ItemSearchResult.result.slice();
tem_buil_order=list_to_order.sort((a, b) => a['post_title'].localeCompare(b['post_title']));
tem_buil_order.reduce( (dataresponse, itempost) => { 
  if($(this).val()=='all'){ 
    FilShow.push('<option value="'+itempost.ID+'">'+itempost.post_title+'</option>');
    tem_buil.push({neighborhood_id:itempost.neighborhood_id,neighborhood:itempost.neighborhood});
  } else if ( itempost.type_category_id==  $(this).val()){
    FilShow.push('<option value="'+itempost.ID+'">'+itempost.post_title+'</option>');
    tem_buil.push({neighborhood_id:itempost.neighborhood_id,neighborhood:itempost.neighborhood});
  }
  return dataresponse; } , {});
  
  if (tem_buil.length > 0){
    tem_buil.sort((a, b) => a['neighborhood'].localeCompare(b['neighborhood']));
    FilShowNeig.push('<option value="all">'+word_translate.all_neighborhoods+'</option>');
    tem_buil.forEach(function(itemneig){
      if (itemneig.neighborhood_id != '' && itemneig.neighborhood != '') 
        FilShowNeig.push('<option value="'+itemneig.neighborhood_id+'">'+itemneig.neighborhood+'</option>');
    });
    $('.neighborhood_select').html(FilShowNeig.unique().join(""));
  }

  $('.condos_select').html(FilShow.join("")).ready(function(){ $('.condos_select').change(); });
});

Array.prototype.unique = function() {
  return this.filter(function (value, index, self) { 
    return self.indexOf(value) === index;
  });
}

$(".search_building").autocomplete({
  source: ItemSearch,
  appendTo: "#autocomplete-ui-build",
  open: function( event, ui ) {$("#autocomplete-ui-build").show()},
  close: function( event, ui ) {$("#autocomplete-ui-build").hide()}, 
  select: function( event, ui ) {
      submit_fil=1;       
      eventchange='search';
      $(".search_building").val(ui.item.value);
      reset_object_filters("search_building");
     search_condos(); 
     return false; 
   } });

$('.clidxboost-icon-search').on('click',function(){
  search_condos(); 
});


$('.search_building').keyup(function(e){
    if(e.keyCode == 13){
      if ($(this).val().length>0){
        if(ItemSearch.indexOf($(this).val())!='-1'){
          $('.search_building').val($(this).val());
        }else{
          $('.search_building').val($('#autocomplete-ui-build ul li').eq(0).find('.ui-menu-item-wrapper').text());
        }
        $('.form_building_complete').submit();
      }else{
        submit_fil=1;       
        eventchange='search';
        reset_object_filters("search_building");
        search_condos();
      }
    }
});

$(document).on('click', '#bubble-filter', function() {
  $('.item-bubble').toggleClass('active');
});

$(".result-search-result").on("click", ".ib-btn-show", function(event) {
  $(this).parents('.propertie').toggleClass('active-list');
})

$('#code-map div').on('click','.dgt-richmarker-single',function(){
  console.log($(this));
});

$('.clidxboost_search_complete').change(function(){
  $('.form_building_complete').submit();
});

$("#map-actions").on("click", "button", function() {
  var map = dgt.map.getInstance();
  $('#wrap-list-result').toggleClass('closed');
  $(this).addClass('hide').siblings().removeClass('hide');
    setTimeout(function () {
        google.maps.event.trigger(map, 'resize');
        setTimeout(function () {
            google.maps.event.trigger(map, 'resize');
        }, 200);
    }, 100);
});


$("#wrap-list-result").on( 'scroll', function(){
eventchange='scroll';
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      filurlview=$('#filter-views select').val();
    }else{
      filurlview=$('#filter-views ul li.active').text().toLowerCase();
    }

    if (filurlview=='map'){
      totpag=(temparray.length/20);
      if (totpag % 1 == 0) { totpag=totpag; } else { totpag=totpag+1; }

      myLazyLoad.update();
      if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
        
        var pageIte = jQuery('.num_page').val();
        if(pageIte == '') pageIte=1;         
        submit_fil=2;
        var pageItenum=parseInt(pageIte)+1;
        if (totpag>=pageItenum){
          //jQuery("#wrap-list-result").scrollTop(0);
          $('.num_page').val(pageItenum);
          $('.num_page').attr('pagnum',(pageItenum));
          search_condos();
        }
      }
    }
});

$(window).on('scroll', function(){
  eventchange='scroll';
  totpag=(temparray.length/20);
  if (totpag % 1 == 0) { totpag=totpag; } else { totpag=totpag+1; }

  var scrollHeight=$("#wrap-list-result")[0].scrollHeight;
  var maxScrollTop=$(document).height() - $(window).height();
  var scrolling=0;
  if (scrollHeight>=maxScrollTop)
    scrolling=maxScrollTop-(maxScrollTop/7);
  else
    scrolling=scrollHeight-(scrollHeight/7);  
  
  if($(this).scrollTop()  >= scrolling ) {
    var pageIte = jQuery('.num_page').val();
    if(pageIte == '') pageIte=1;         
    submit_fil=2;
    var pageItenum=parseInt(pageIte)+1;
    if (totpag>=pageItenum){
      $('.num_page').val(pageItenum);
      $('.num_page').attr('pagnum',(pageItenum));
      search_condos();
    }
  }
});


$(".result-search-result").on("click", ".view_inmap", function(event) {
  if ( $(this).data("geocode").match(/^.*null.*$/) == null  ){
    var geocode = $(this).data("geocode"),i,marker,markers;
    markers=dgt.map.returnMarkers();
    for (i = 0; i < markers.length; i++) {
      if (markers[i].geocode === geocode) {
        marker = markers[i];
        break;
      }
    }
    if (typeof marker !== 'undefined') {
      var map = dgt.map.getInstance();
      map.setCenter(marker.position);
      map.setZoom(18);
      google.maps.event.trigger(marker, "mouseover");
      google.maps.event.trigger(marker, "click");
    }
  }
});

$('.form_building_complete').submit(function(event){
  event.preventDefault();
  submit_fil=1;
  eventchange='search';
  search_condos();
  });

  //search_condos();
  $(document).ready(function(){
    $('.neighborhood_select').change();
  });

});

})(window, document, jQuery);
