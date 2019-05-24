var $=jQuery,pag_fil=1,limit_fil=25,submit_fil=0; inifil_default=4;  tgmap='', web_page='', filurlneigh='', filurlcat='',filurlview='',totpag=0,eventchange='';
var temparray=[];


window.mobileAndTabletcheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};

function search_condos() {
if (eventchange !='scroll'){ jQuery('.result-search-item').html('');  $('.num_page').val('0'); $('.num_page').attr('pagnum',('0')); }
if (eventchange =='search') submit_fil=1;

jQuery('.idx-filter-item').removeClass('idxboost-active').addClass('idxboost-inactive');
var condos_select=0, responseHTML=[],neighborhood_select='all',type_search='all', htmlResponse='',search_building='';
web_page=jQuery('.web_page').val();

  search_building=$('.search_building').val();
  web_page +='?';
if (submit_fil!=2)  { temparray=[]; $('.num_page').val(''); filurlcat=''; filurlneigh=''; }


    if (idxboostConf.ItemSearchResult.success === true){
      pag_fil=0;
        if (submit_fil==2){
          pag_fil=parseInt($('.num_page').val())-1;
        }else if (submit_fil==1){
            if (search_building.length>0){
              var posi=idxboostConf.ItemSearchResult.result.map(function(e) { return e.post_title; }).indexOf(search_building);
              if (posi !=-1){
                temparray.push(idxboostConf.ItemSearchResult.result[posi]);
              }
            }else{
              temparray=idxboostConf.ItemSearchResult.result;
            }
        }else if (condos_select==0 && neighborhood_select=='all' && type_search=='all') {
          temparray=idxboostConf.ItemSearchResult.result;
          web_page=jQuery('.web_page').val();
          web_page +='?';
        }else if (type_search !='all' ) {
          //enpaginado
          idxboostConf.ItemSearchResult.result.forEach(function(item,index){
              temparray.push(item);
              filurlcat=item.type_category;
          });
        }

          temparray.slice((pag_fil*limit_fil),(pag_fil*limit_fil)+limit_fil).forEach(function(item,index){
              var vaneighborhood_id=0;
              if ( item.neighborhood_id.length != 0 ){
                vaneighborhood_id=item.neighborhood_id;
              }
                eval('neigh_list_'+vaneighborhood_id).push(item);
                responseHTML[vaneighborhood_id]='1';
          });

          var neig_actives=jQuery.unique(temparray.slice(0,(pag_fil*limit_fil)+limit_fil).map(function(item){return item.neighborhood_id}));

          neig_actives.forEach(function(item){
            jQuery('.idx-filter-item-'+item).removeClass('idxboost-inactive').addClass('idxboost-active');
            jQuery('.content-search-'+item).addClass('idxboost-active');
          });

              responseHTML.forEach(function(item,index){

              var dgt_extra_unit='';
              if(item.dgt_extra_unit != undefined ){
                if (item.dgt_extra_unit.length>0){
                  dgt_extra_unit=item.dgt_extra_unit;
                }
              }
                              
              eval('neigh_list_'+index).sort((a, b) => a['post_title'].localeCompare(b['post_title']));
              eval('neigh_list_'+index).forEach(function(item){
                var price_range=[];
                price_range=JSON.parse(item.tg_building_price);
                eval('neigh_'+index).push('<div class="idx-box-item"><ul class="idx-table-body"><li class="idx-name"><h2>'+item.post_title+'</h2></li><li class="idx-address"><h3>'+item.dgt_extra_address+'</h3></li><li data-text="From" class="idx-form">$'+_.formatShortPrice(price_range.min_price)+'</li><li data-text="To" class="idx-to">$'+_.formatShortPrice(price_range.max_price)+'</li><li data-text="Floors" class="idx-floors">'+item.tg_building_floor+'</li><li data-text="Built" class="idx-built">'+item.dgt_year_building+'</li><li data-text="For Sale" class="idx-sale">'+item.tg_building_sale+'</li><li data-text="PR Rank" class="idx-rank">0</li></ul><button class="idx-active">'+word_translate.show_more+'</button><a href="'+item.tgbuilding_url+'" class="idx-link-view">'+word_translate.show_more+'</a><div class="idx-thumb-content"><span class="idx-wrap-img"><img data-original="'+item.tgbuilding_image+'" class="blazy flex-lazy-image"></span></div><div class="idx-label-info">$'+_.formatShortPrice(price_range.min_price)+' to $'+_.formatShortPrice(price_range.max_price)+'</div></div>');
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
   }
 }

$(document).ready(function(){
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

  $('.type_search, .neighborhood_select, .condos_select').change(function(){
    search_condos();
  });


  $(".search_building").autocomplete({
    source: ItemSearch,
    appendTo: "#autocomplete-ui-build",
    open: function( event, ui ) {$("#autocomplete-ui-build").show()},
    close: function( event, ui ) {$("#autocomplete-ui-build").hide()}, 
    select: function( event, ui ) {
        submit_fil=1;
        eventchange='search';
        $(".search_building").val(ui.item.value);
       search_condos(); 
       return false; 
     } });

$(window).on('scroll', function(){
  eventchange='scroll';
  totpag=Math.round(temparray.length/20);
  if($(this).scrollTop() + $(this).innerHeight() >= $('body')[0].scrollHeight) {      
    var pageIte = jQuery('.num_page').val();
    if(pageIte == '') pageIte=1;         
    submit_fil=2;
    var pageItenum=parseInt(pageIte)+1;
    if (totpag>=pageItenum){
      console.log("scroll");
      $('.num_page').val(pageItenum);
      $('.num_page').attr('pagnum',(pageItenum));
      search_condos();
    }
  }
});

  $('.search_building').keyup(function(e){
      if(e.keyCode == 13){
        if ($(this).val().length>0){
          console.log(ItemSearch.indexOf($(this).val()));
          if(ItemSearch.indexOf($(this).val())!='-1'){
            $('.search_building').val($(this).val());
          }else{
            $('.search_building').val($('#autocomplete-ui-build ul li').eq(0).find('.ui-menu-item-wrapper').text());
          }
          $('.form_building_complete').submit();
        }else{
          submit_fil=1;       
          eventchange='search';
          search_condos();
        }
      }
  });

  $('.idx-btn-search').click(function(event){
    submit_fil=1;
    search_condos();
  });
  search_condos();
});
