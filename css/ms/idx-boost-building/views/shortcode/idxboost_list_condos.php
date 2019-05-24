<script type="text/javascript">
<?php if ($_GET['pag']){ echo "var inifil=4;";} ?>

(function($) {
  
  $(document).ready(function(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      $('#filter-views select').change();
    }else{
      $('#filter-views ul li.active').click();
    }
  }); 
})(jQuery); 
  var ItemSearch=[];
  <?php foreach($result_feed_decode['result'] as $result_feed_decode_item) { ?>
    ItemSearch.push("<?php echo $result_feed_decode_item['post_title']; ?>");
    <?php } ?>

  <?php foreach($neighborhood_loop as $key_neigh => $value_neight) { 
    echo "var neigh_".$key_neigh."=[];";
    echo "var neigh_list_".$key_neigh."=[];";
     } ?>
</script>

         <div class="idx-ft-content">
            <div class="idx-filter-content">
               <div class="idx-search-input"><input type="search" placeholder="<?php echo __("Search (web site name) Condos", IDXBOOST_DOMAIN_THEME_LANG); ?>" class="search_building"><button class="idx-btn-search"><?php echo __("search", IDXBOOST_DOMAIN_THEME_LANG); ?></button></div>
               <div class="idx-btn-action"><button class="idx-icon-grid"><span><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button><button class="idx-icon-list active"><span><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></div>
            </div>
         </div>


         <div class="idx-list-n-condo view-list">
         <?php foreach($neighborhood_loop as $key_neigh => $value_neight) {  ?>
         <section class="idx-filter-item idx-filter-item-<?php echo $key_neigh;?> idxboost-active">
               <h3 class="idx-title"><?php echo $value_neight; ?></h3>
                <div class="idx-wrap-item">
                 <ul class="idx-table-header"><li class="idx-name"><?php echo __("Development", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="idx-address"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="idx-form"><?php echo __("From", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="idx-to"><?php echo __("To", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="idx-floors"><?php echo __("Floors", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="idx-built"><?php echo __("Built", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="idx-sale"><?php echo __("For Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="idx-rank"><?php echo __("Pr Rank", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                </ul>
                 <div class="result-search-item result-search-<?php echo $key_neigh;?>"></div>
              </div>
               
            </section>
         <?php } ?>
</div>
<input type="hidden" name="num_page" pagnum="0" class="num_page" value="0">
<style type="text/css">
.idxboost-inactive{
   display: none;
}
</style>