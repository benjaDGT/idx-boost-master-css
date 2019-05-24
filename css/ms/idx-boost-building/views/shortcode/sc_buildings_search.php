<?php
$slug_category = array_map(function($slugitem) { return is_object($slugitem) ? $slugitem->slug : $slugitem['slug']; }, $categorys_loop);
$name_category = array_map(function($slugitem) { return is_object($slugitem) ? $slugitem->name : $slugitem['name']; }, $categorys_loop);

usort($neighborhood_loop,'order_by_title_neightboardhood_with_key');

$fil_search='';
if (isset($_GET)) {
  if (array_key_exists('new_developments', $_GET)) {
    $fil_search='New Developments';
  }else if (array_key_exists('luxury_condos', $_GET)) {
    $fil_search='Existings Buildings';
  }
}

if ($atts['category'] != 'all') { 
  $exist_get = array_search($atts['category'], $slug_category);
  if (!empty($exist_get) || $exist_get=='0') 
    $fil_search=$categorys_loop[$exist_get]->name;
}

if(isset($_GET['category'])){
  $exist_get_name = array_search($_GET['category'], $name_category);
  if (!empty($exist_get_name) || $exist_get_name=='0') 
    $fil_search=$categorys_loop[$exist_get_name]->name;
}

if (isset($_GET['view'])) 
  $atts['view']=$_GET['view'];

?>
<script type="text/javascript">
<?php if ($_GET['pag']){ echo "var inifil=4;";} ?>

(function($) {
  
  $(document).ready(function(){

    $("body").addClass('full-page-luxury view-list');

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      $('#filter-views select').change();
    }else{
      $('#filter-views ul li.active').click();
    }
  }); 


  $(document).on('click', '.ib-icon-grid', function(){
    $(".ib-btn-mp").removeClass("ib-active");
    $(this).addClass("ib-active");
    $("#filter-views .grid").trigger("click");
  });

  $(document).on('click', '.ib-icon-list', function(){
    $(".ib-btn-mp").removeClass("ib-active");
    $(this).addClass("ib-active");
    $("#filter-views .list").trigger("click");
  });

  $(document).on('click', '.ib-icon-map', function(){
    $(".ib-btn-mp").removeClass("ib-active");
    $(this).addClass("ib-active");
    $("#filter-views .map").trigger("click");
  });


  /*------------------------------------------------------------------------------------------*/
  /* Funcion que fixea los elementos
  /*------------------------------------------------------------------------------------------*/
  /*$(window).on('load', function () {
    $(".fixed-box-m").each(function () {
      var elemento = $(this);
      scrollFixedElementv(elemento);
    });
  });

  function scrollFixedElementv(elemento) {
    var boxTop = elemento.offset().top;
    var boxHeight = elemento.outerHeight();
    var originalPos = boxHeight;
    $(document).on("scroll", function (e) {
      if ($("body").hasClass("fixed-active-m")) {
        if ($(document).scrollTop() <= originalPos)
          $("body").removeClass("fixed-active-m");
        return;
      }
      if ((originalPos = $(document).scrollTop()) >= (boxTop + boxHeight)) {
        $("body").addClass("fixed-active-m");
      }
    });
  }*/

})(jQuery); 

  var ItemSearch=[];
  <?php foreach($result_feed_decode['result'] as $result_feed_decode_item) { ?>
    ItemSearch.push("<?php echo $result_feed_decode_item['post_title']; ?>");
    <?php } ?>

  <?php foreach($neighborhood_loop as $key_neigh => $value_neight) { 
    echo "var neigh_".$value_neight['id']."=[];";
    echo "var neigh_list_".$value_neight['id']."=[];";    
     } ?>
</script>

<div class="wrap-page-idx" id="luxury-condo-page">
  <div class="content-filters">
    <div id="wrap-filters" class="animated fixed-box search-page-ft">
      <div class="gwr">
        
        <div id="header-filters">
          <div class="idx_logo_web">
            <?php if (function_exists('idx_the_custom_logo_header')): ?>
              <?php idx_the_custom_logo_header(); ?>
            <?php endif; ?>
          </div>
          <div class="text-wrapper">
            <div class="allf-callus"><?php echo __("Call us:", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="telf:<?php echo preg_replace('/[^\d+]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>"><?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?></a></div>
            <button class="allf-ss"><?php echo __("Save this Search", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
            <button class="resp-btn" id="show-mobile-menu"><span></span></button>
          </div>
        </div>

        <ul id="filters" class="active-select">

          <li class="mini-search" id="autocomplete-dropdown-ct">
            <form action="#" name="form_building_complete" class="form_building_complete">
            <input type="search" placeholder="<?php echo __("Search Condos", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="autocomplete-ajax" name="search_building" class="search_building">
            <input type="hidden" name="action" value="dgt_search_buildings_autocomplete">
            <label class="line-form"></label>
            <div id="submit-ms" class="clidxboost-icon-search">
              <input id="flex_search_keyword_form_submit" type="submit" value="Submit">
            </div>
            </form>
            <div id="autocomplete-ui-build"></div>
          </li>

          <li class="content_select">
            <select class="condos_select" name="condos_select">
              <option value="0" selected="selected"><?php echo __("Condos by Name", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <?php  usort($result_feed_decode['result'], "order_by_title_building");
            foreach($result_feed_decode['result'] as $result_feed_decode_item) { ?>
              <option value="<?php echo $result_feed_decode_item['ID']; ?>"><?php echo $result_feed_decode_item['post_title']; ?></option>
              <?php } ?>
            </select>
          </li>
          <li class="content_select">
            <select class="neighborhood_select" name="neighborhood_select">
              <option value="all"><?php echo __("All Neighborhoods", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <?php 
              foreach($neighborhood_loop as $value_neight) { 
               $selected_neigh='';

              if ($atts['area'] !='all')  {
                if (is_numeric($atts['area'])) {
                  if($atts['area']== $value_neight['id']) $selected_neigh='selected';
                }else{
                    if( $value_neight['name'] == $atts['area'] )   $selected_neigh='selected';
                }                
              }else if(isset($_GET['area'])){
                if(preg_replace('/[^-a-z0-9_]+/', '-', strtolower($value_neight['name']) ) == $_GET['area'] )   $selected_neigh='selected';
              }
              if ($value_neight['id'] != 0)
                echo '<option value="'.$value_neight['id'].'"  '.$selected_neigh.'>'.$value_neight['name'].'</option>';
               } ?>                               
            </select>
          </li>
          <li class="content_select" <?php echo $display_cat; ?> >
            <select name="type_search" class="type_search">
              <option value="all"><?php echo __("All Buildings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <?php 
              foreach ($categorys_loop as $value_category) {
                $selected_type='';
                if (!empty($fil_search)) {
                  if ($fil_search==$value_category->name) {
                    $selected_type='selected';
                  }
                }
                echo '<option value="'.$value_category->term_id.'" '.$selected_type.'>'.$value_category->name.'</option>';
              }
              ?>
            </select>
          </li>

          <li class="ib-group-btn">
            <button class="ib-btn-mp ib-icon-grid <?php if ($atts['view']=='grid') echo "ib-active";?>"><span><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
            <button class="ib-btn-mp ib-icon-list <?php if ($atts['view']=='list') echo "ib-active";?>"><span><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
            <button class="ib-btn-mp ib-icon-map <?php if ($atts['view']=='map') echo "ib-active";?>"><span><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
          </li>

          <li class="all">
            <button id="btn-active-filters">
              <label class="ib-dt"><?php echo __("Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <label class="ib-ct"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            </button>
          </li>
        </ul>

        <div id="all-filters">
        </div>

      </div>
    </div>
  </div>

  <div id="wrap-subfilters">
    <div class="gwr">
      <ul id="sub-filters">
        <li id="link-favorites"><a class="clidxboost-icon-favorite" href="#" title="Save Favorites" rel="nofollow"><span><span>0</span>Favorites</span></a></li>
        <li class="clidxboost-icon-arrow-select <?php echo $atts['view']; ?>" id="filter-views">
          <select>
            <option value="grid" <?php if ($atts['view']=='grid') echo "selected";?> ><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="list" <?php if ($atts['view']=='list') echo "selected";?>><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="map" <?php if ($atts['view']=='map') echo "selected";?>><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
      </ul>
    </div>
  </div>

  <section class="view-list" id="wrap-result">
    <h2 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <div class="gwr">
      <div id="wrap-list-result">
        <?php foreach($neighborhood_loop as $key_neigh => $value_neight) {  ?>
        <div class="content-search-building content-search-<?php echo $value_neight['id'];?> idxboost-inactive" id="<?php echo preg_replace('/[^-a-z0-9_]+/', '-', strtolower($value_neight['name']) ); ?>">
          <h2 class="luxury-condo-title"><?php echo $value_neight['name']; ?></h2>
          <ul id="head-list">
            <li class="name"><?php echo __("Building Name", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
            <li class="addres"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
            <li class="unit"><?php echo __("Units", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
            <li class="floor"><?php echo __("Floor", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
            <li class="year"><?php echo __("Year", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          </ul>
          <ul id="result-search" class="temp slider-generator result-search-result result-search-<?php echo $value_neight['id'];?>"></ul>
        </div>
        <?php } ?>
      </div>

      <div id="wrap-map">
        <div id="code-map"></div>
        <div id="map-actions">
          <button class="open-map"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          <button class="close-map hide"><?php echo __("Open", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </div>
      </div>
    </div>

    <div class="gwr" id="paginator-cnt">
      <nav id="nav-results" class="nav_results_pag idx_color_second">

      </nav>
    </div>  
  </section>

</div>

<input type="hidden" name="web_page" class="web_page" value="<?php echo get_permalink(); ?>">
<input type="hidden" name="num_page" pagnum="<?php echo $_GET['pag']; ?>" class="num_page" value="<?php echo $_GET['pag']; ?>">
<style type="text/css">
  .idxboost-inactive{
    display: none;
  }
  .idxboost-active{
    display: block;
  }
</style>