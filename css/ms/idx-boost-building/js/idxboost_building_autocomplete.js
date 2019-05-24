$=jQuery;
var filurlneigh='', filurlcat='',filurlview='',Itemauto=[]; 
var pag_fil=1,limit_fil=20,submit_fil=0; inifil_default=4;  tgmap='', boundspolyn = '',temoara=[],polygonDrawOld=[], eventchange=''; 
var temparray=[];
var show_homepage = false;

    $.widget( "custom.catcomplete", $.ui.autocomplete, {
      _create: function() {
        this._super();
        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
      },
      _renderMenu: function( ul, items ) {
        var that = this,
          currentCategory = "";
        $.each( items, function( index, item ) {
          var li;
          if ( item.category != currentCategory ) {
            ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
            currentCategory = item.category;
          }
          li = that._renderItemData( ul, item );
          if ( item.category ) {
            li.attr( "aria-label", item.category + " : " + item.label );
          }
        });
      }
    });

Array.prototype.unique = function() {
  return this.filter(function (value, index, self) { 
    return self.indexOf(value) === index;
  });
}
function fc_building_autocomplete() {
var search_building='';
  search_building=$('.search_building').val();
    if (building_complete.item.success === true){
      if (search_building.length>0){
        var posi=building_complete.item.result.map(function(e) { return e.post_title; }).indexOf(search_building);
        if (posi !=-1){
          temparray.push(building_complete.item.result[posi]);
          location.href=temparray[0].tgbuilding_url;
        }
      }
    }
  }

$(".search_building").catcomplete({
  source: ItemSearch,
  appendTo: "#autocomplete-ui-build",
  open: function( event, ui ) {$("#autocomplete-ui-build").show()},
  close: function( event, ui ) {$("#autocomplete-ui-build").hide()}, 
  select: function( event, ui ) {
      $(".search_building").val(ui.item.value);
     fc_building_autocomplete(); 
     return false; 
   } });

$('.clidxboost-icon-search').on('click',function(){
  fc_building_autocomplete(); 
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
        fc_building_autocomplete();
      }
    }
    /*
    else if(e.keyCode == 8){
      if ($(".search_building").val() =='')
        if (Itemauto.length>0)
          $(".search_building").catcomplete( "destroy" );
    }*/
    else{
      fc_orderAutocomplete($(".search_building").val());
    }
});

function fc_orderAutocomplete(filtro){
  if (filtro != ''){
    var expresion = new RegExp('^'+filtro+'.*$','i');
    var expresionall = new RegExp('^.*'+filtro+'.*$','i');
    ItemSearch.sort(function (a, b) {
      if($.isNumeric(a.label)){
      return 1;
      }

      if (a.label.match(expresion) > b.label.match(expresion)) {
        return 1;
      }

      if (b.label.match(expresion) > a.label.match(expresion)) {
        return -1;
      }

      if (a.label.match(expresion)) {
        return -1;
      }

      if (b.label.match(expresion)) {
        return 1;
      }

      if (a.label.match(expresionall) > b.label.match(expresionall)) {
        return 1;
      }

      if (b.label.match(expresionall) > a.label.match(expresionall)) {
        return -1;
      }

      if (a.label.match(expresionall)) {
        return -1;
      }

      if (b.label.match(expresionall)) {
        return 1;
      }


      if (a.label < b.label) {
        return -1;
      }
      return 0;
    });
      Itemauto= ItemSearch.slice()
      Itemauto=Itemauto.splice(0,18);  
      $(".search_building").catcomplete({ source: Itemauto });
  }
}

$('.clidxboost_search_complete').change(function(){
  $('.form_building_complete').submit();
});

$('.form_building_complete').submit(function(event){
  event.preventDefault();
  fc_building_autocomplete();
  });
