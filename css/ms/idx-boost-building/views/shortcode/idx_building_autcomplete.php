<?php
$slug_category = array_map(function($slugitem) { return is_object($slugitem) ? $slugitem->slug : $slugitem['slug']; }, $categorys_loop);
$name_category = array_map(function($slugitem) { return is_object($slugitem) ? $slugitem->name : $slugitem['name']; }, $categorys_loop);

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

?>
<script type="text/javascript">
  var ItemSearch=[];
  <?php foreach($result_feed_decode['result'] as $result_feed_decode_item) { ?>
    ItemSearch.push({label:"<?php echo $result_feed_decode_item['post_title']; ?>",category:"<?php echo $result_feed_decode_item['neighborhood']; ?>"});
    <?php } ?>

  <?php foreach($neighborhood_loop as $key_neigh => $value_neight) { 
    echo "var neigh_".$key_neigh."=[];";
    echo "var neigh_list_".$key_neigh."=[];";
     } ?>
</script>
<div class="r-overlay"></div>

<div class="wrap-page-idx" id="luxury-condo-page">
  
  <div class="content-filters">
    <div id="wrap-filters" class="animated fixed-box search-page-ft">
      <div class="gwr">
               <ul id="filters" class="active-select">
          <li class="mini-search" id="autocomplete-dropdown-ct">
            <form action="#" name="form_building_complete" class="form_building_complete">
            <input type="search" placeholder="Search Condos" id="autocomplete-ajax" name="search_building" class="search_building">
            <input type="hidden" name="action" value="dgt_search_buildings_autocomplete">
            <label class="line-form"></label>
            <div id="submit-ms" class="clidxboost-icon-search">
              <input id="flex_search_keyword_form_submit" type="submit" value="Submit">
            </div>
            </form>
            <div id="autocomplete-ui-build"></div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
 .ui-autocomplete-category {
    font-weight: bold;
    padding: .2em .4em;
    margin: .8em 0 .2em;
    line-height: 1.5;
  }
</style>