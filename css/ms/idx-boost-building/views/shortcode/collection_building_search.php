hola
<?php
$fil_search='';
if (isset($_GET)) {
  if (array_key_exists('new_developments', $_GET)) {
    $fil_search='New Developments';
  }else if (array_key_exists('luxury_condos', $_GET)) {
    $fil_search='Luxury Condos';
  }
}
?>
<script type="text/javascript">
  $(document).ready(function(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      $('#filter-views select').change();
    }else{
      $('#filter-views ul li.active').click();
    }
  });  
  var ItemSearch=[];
  <?php foreach($result_feed_decode['result'] as $result_feed_decode_item) { ?>
    ItemSearch.push("<?php echo $result_feed_decode_item['post_title']; ?>");
    <?php } ?>
</script>
<div class="r-overlay"></div>
<main class="collection" id="new-construction">
  <div class="animated fixed-box" id="wrap-filters">
    <div class="gwr">
      <ul id="filters">
        <li class="item-bubble">
          <button id="bubble-filter"><span class="clidxboost-icon-arrow-select"> <span><?php echo __("Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
          <ul class="bubble-filter">
            <li class="type-rt clidxboost-icon-arrow-select">
              <select class="condos_select" name="condos_select">
                <option value="0" selected="selected"><?php echo __("Luxury Condos by Name", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <?php  foreach($result_feed_decode['result'] as $result_feed_decode_item) { ?>
                <option value="<?php echo $result_feed_decode_item['ID']; ?>"><?php echo $result_feed_decode_item['post_title']; ?></option>
                <?php } ?>
              </select>
            </li>
            <li class="type-rt clidxboost-icon-arrow-select">
              <select class="neighborhood_select" name="neighborhood_select">
                <option value="all"><?php echo __("Show all", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                <?php foreach($neighborhood_loop as $value_neight) { 
                echo '<option value="'.$value_neight['ID'].'"> '.$value_neight['post_title'].' </option>';
                 } ?>                
              </select>
            </li>
            <li class="type-rt clidxboost-icon-arrow-select">
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
          </ul>
        </li>
        <li class="mini-search">
          <form action="#" name="form_building_complete" class="form_building_complete" >
            <input type="search" placeholder="<?php echo __('Search Condos', IDXBOOST_DOMAIN_THEME_LANG); ?>" id="autocomplete-ajax" name="search_building" class="search_building">
            <input type="hidden" name="action" value="dgt_search_buildings_autocomplete">
            <div class="clidxboost-icon-search clidxboost_search_complete" id="submit-ms">
              <input type="submit" value="Submit">
            </div>
          </form>
          <div id="autocomplete-ui-build"></div>
          <!-- <div id="search-suggestions">
            <ul>
              <li data-slug="Aventura|city">Aventura</li>
              <li data-slug="Bal Harbour|city">Bal Harbour</li>
              <li data-slug="Bay Harbor Islands|city">Bay Harbor Islands</li>
              <li data-slug="Brickell|city">Brickell</li>
              <li data-slug="Brickell Key|city">Brickell Key</li>
              <li data-slug="Coconut Grove|city">Coconut Grove</li>
              <li data-slug="Coral Gables|city">Coral Gables</li>
              <li data-slug="Fisher Island|city">Fisher Island</li>
              <li data-slug="Hollywood|city">Hollywood</li>
              <li data-slug="Indian Creek|city">Indian Creek</li>
              <li data-slug="Key Biscayne|city">Key Biscayne</li>
              <li data-slug="Miami|city">Miami</li>
              <li data-slug="Miami Beach|city">Miami Beach</li>
              <li data-slug="Miami Shores|city">Miami Shores</li>
              <li data-slug="North Miami|city">North Miami</li>
              <li data-slug="North Miami Beach|city">North Miami Beach</li>
              <li data-slug="Pembroke Pines|city">Pembroke Pines</li>
              <li data-slug="Sunny Isles Beach|city">Sunny Isles Beach</li>
              <li data-slug="Surfside|city">Surfside</li>
            </ul>
          </div>
          <div id="autocomplete-matches">
            <ul>
              <li data-slug="Aventura|city">Aventura</li>
              <li data-slug="Bal Harbour|city">Bal Harbour</li>
              <li data-slug="Bay Harbor Islands|city">Bay Harbor Islands</li>
              <li data-slug="Brickell|city">Brickell</li>
              <li data-slug="Brickell Key|city">Brickell Key</li>
              <li data-slug="Coconut Grove|city">Coconut Grove</li>
              <li data-slug="Coral Gables|city">Coral Gables</li>
              <li data-slug="Fisher Island|city">Fisher Island</li>
              <li data-slug="Hollywood|city">Hollywood</li>
              <li data-slug="Indian Creek|city">Indian Creek</li>
              <li data-slug="Key Biscayne|city">Key Biscayne</li>
              <li data-slug="Miami|city">Miami</li>
              <li data-slug="Miami Beach|city">Miami Beach</li>
              <li data-slug="Miami Shores|city">Miami Shores</li>
              <li data-slug="North Miami|city">North Miami</li>
              <li data-slug="North Miami Beach|city">North Miami Beach</li>
              <li data-slug="Pembroke Pines|city">Pembroke Pines</li>
              <li data-slug="Sunny Isles Beach|city">Sunny Isles Beach</li>
              <li data-slug="Surfside|city">Surfside</li>
            </ul>
          </div> -->
        </li>
        <!-- <li class="end-item"><a class="btn btn-green" href="#" title="Looking to Buy or Sell a Condo?" rel="nofollow">Looking to Buy or Sell a Condo?</a></li> -->
      </ul>
      <div id="all-filters">
        <ul class="hidden-sr" id="mini-filters">
          <li class="filter-box">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Property search", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <ul class="list-type-sr">
                  <li>
                    <button class="active" id="for-sale"> <span><?php echo __("For sale", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                  </li>
                  <li>
                    <button id="for-rent"> <span><?php echo __("For Rent", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                  </li>
                </ul>
                <input type="search" placeholder="<?php echo __("Select Area or Enter City, Zip, Condo Name or Keyword", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="autocomplete-ajax-min">
                <div class="clidxboost-icon-search" id="submit-ms-min">
                  <input type="submit" value="Submit">
                </div>
              </div>
            </div>
          </li>
          <li class="cities">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Choose cities<span>Aventura</span></h4>
              <div class="wrap-item">
                <div id="cities-list">
                  <ul>
                    <li data-slug="Aventura|city">Aventura</li>
                    <li class="active" data-slug="Bal Harbour|city">Bal Harbour</li>
                    <li data-slug="Bay Harbor Islands|city">Bay Harbor Islands</li>
                    <li data-slug="Biscayne Park|city">Biscayne Park</li>
                    <li data-slug="Brickell|city">Brickell</li>
                    <li data-slug="Brickell Key|city">Brickell Key</li>
                    <li data-slug="Coconut Grove|city">Coconut Grove</li>
                    <li data-slug="Coral Gables|city">Coral Gables</li>
                    <li data-slug="Cutler Bay|city">Cutler Bay</li>
                    <li data-slug="Doral|city">Doral</li>
                    <li data-slug="Eastern Shores|city">Eastern Shores</li>
                    <li data-slug="El Portal|city">El Portal</li>
                    <li data-slug="Fisher Island|city">Fisher Island</li>
                    <li data-slug="Florida City|city">Florida City</li>
                    <li data-slug="Fort Lauderdale|city">Fort Lauderdale</li>
                    <li data-slug="Golden Beach|city">Golden Beach</li>
                    <li data-slug="Goulds|city">Goulds</li>
                    <li data-slug="Hialeah Gardens|city">Hialeah Gardens</li>
                    <li data-slug="Hollywood|city">Hollywood</li>
                    <li data-slug="Homestead|city">Homestead</li>
                    <li data-slug="Indian Creek|city">Indian Creek</li>
                    <li data-slug="Kendall|city">Kendall</li>
                    <li data-slug="Key Biscayne|city">Key Biscayne</li>
                    <li data-slug="Medley|city">Medley</li>
                    <li data-slug="Miami|city">Miami</li>
                    <li data-slug="Miami Beach|city">Miami Beach</li>
                    <li data-slug="Miami Gardens|city">Miami Gardens</li>
                    <li data-slug="Miami Lakes|city">Miami Lakes</li>
                    <li data-slug="Miami Shores|city">Miami Shores</li>
                    <li data-slug="Miami Springs|city">Miami Springs</li>
                    <li data-slug="North Bay Village|city">North Bay Village</li>
                    <li data-slug="North Miami|city">North Miami</li>
                    <li data-slug="North Miami Beach|city">North Miami Beach</li>
                    <li data-slug="Opa-Locka|city">Opa-Locka</li>
                    <li data-slug="Palmetto Bay|city">Palmetto Bay</li>
                    <li data-slug="Pembroke Pines|city">Pembroke Pines</li>
                    <li data-slug="Pinecrest|city">Pinecrest</li>
                    <li data-slug="South Miami|city">South Miami</li>
                    <li data-slug="Sunny Isles Beach|city">Sunny Isles Beach</li>
                    <li data-slug="Surfside|city">Surfside</li>
                    <li data-slug="Sweetwater|city">Sweetwater</li>
                    <li data-slug="Virginia Gardens|city">Virginia Gardens</li>
                    <li data-slug="West Miami|city">West Miami</li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="price">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Price Range</h4>
              <div class="wrap-item">         
                <div class="wrap-inputs">
                  <input id="price_from" type="text" name="" value="$0"><span>to</span>
                  <input id="price_to" type="text" name="" value="$50,000,000">
                </div>
                <div class="wrap-range">
                  <div class="range-slide" id="range-price"></div>
                </div><span class="direct-results"> 
                  <label>4,109 </label>Properties</span>
              </div>
            </div>
          </li>
          <li class="baths">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Bathrooms</h4>
              <div class="wrap-item">
                <div class="wrap-range">
                  <div class="range-slide" id="range-baths"></div>
                </div>
                <ul class="markers-range">
                  <li>Any</li>
                  <li>1</li>
                  <li>1.5</li>
                  <li>2</li>
                  <li>2.5</li>
                  <li>3</li>
                  <li>3.5</li>
                  <li>4</li>
                  <li>4.5</li>
                  <li>5</li>
                  <li>+</li>
                </ul><span class="direct-results"> 
                  <label>4,109 </label>Properties</span>
              </div>
            </div>
          </li>
          <li class="beds">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Bedrooms</h4>
              <div class="wrap-item">
                <div class="wrap-range">
                  <div class="range-slide" id="range-beds"></div>
                </div>
                <ul class="markers-range">
                  <li>Any</li>
                  <li>Studio</li>
                  <li>1</li>
                  <li>2</li>
                  <li>3</li>
                  <li>4</li>
                  <li>5</li>
                  <li>+</li>
                </ul><span class="direct-results"> 
                  <label>4,109 </label>Properties  </span>
              </div>
            </div>
          </li>
          <li class="type">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Property type</h4>
              <div class="wrap-item">
                <div class="wrap-checks">
                  <ul>
                    <li>
                      <input type="checkbox" value="" id="first">
                      <label for="first">Single Family Home</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="second">
                      <label for="second">Condo / Townhome</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="third">
                      <label for="third">Vacant Land</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="living">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Living size</h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <input id="living_from" type="text" name="" value="0 SF"><span>to</span>
                  <input id="living_to" type="text" name="" value="9,000 SF">
                </div>
                <div class="wrap-range">
                  <div class="range-slide" id="range-living"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="year">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Year Built</h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <input id="year_from" type="text" name="" value="1961"><span>to</span>
                  <input id="year_to" type="text" name="" value="2021">
                </div>
                <div class="wrap-range">
                  <div class="range-slide" id="range-year"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="waterfront">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Waterfront description</h4>
              <div class="wrap-item">
                <div class="wrap-select clidxboost-icon-arrow-select">
                  <select>
                    <option value="">Any</option>
                    <option value="">Bay Front</option>
                    <option value="">Canal</option>
                    <option value="">Fixed Bridge</option>
                    <option value="">Intracoastal</option>
                    <option value="">Lake front</option>
                    <option value="">Ocean acces</option>
                    <option value="">Ocean Front</option>
                    <option value="">Point lot</option>
                    <option value="">River front</option>
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li class="parking">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Parking spaces</h4>
              <div class="wrap-item">
                <div class="wrap-select clidxboost-icon-arrow-select">
                  <select>
                    <option value="0">Any</option>
                    <option value="#{p}">1</option>
                    <option value="#{p}">2</option>
                    <option value="#{p}">3</option>
                    <option value="+">4+</option>
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li class="land">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">Land size</h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <input id="land_from" type="text" name="" value="0 SF"><span>to</span>
                  <input id="land_to" type="text" name="" value="9,000 SF">
                </div>
                <div class="wrap-range">
                  <div class="range-slide" id="range-land"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="features">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"> 
                <label>Features</label>
                <label>Lifestyle</label>
              </h4>
              <div class="wrap-item">
                <div class="wrap-checks">
                  <ul>
                    <li>
                      <input type="checkbox" value="" id="check1">
                      <label for="check1">Waterfront</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check2">
                      <label for="check2">Ocean Acces</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check3">
                      <label for="check3">Ocean Views</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check4">
                      <label for="check4">Tennis Courts</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check5">
                      <label for="check5">Swimming Poll</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check6">
                      <label for="check6">Golf Course</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check7">
                      <label for="check7">Guest House</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check8">
                      <label for="check8">Boat Dock</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check9">
                      <label for="check9">Covered Parking</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check10">
                      <label for="check10">Bated Community</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check11">
                      <label for="check11">Bated Lorem</label>
                    </li>
                    <li>
                      <input type="checkbox" value="" id="check12">
                      <label for="check12">Ipsum Community</label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="action-filter">
            <button id="apply-filters-min">Matching <span>29K </span>Listings</button>
          </li>
          <button id="apply-filters"><span>Apply Filters</span></button>
        </ul>
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
  <section class="view-<?php echo $atts['view']; ?>" id="wrap-result">
    <h1 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h1>
    <div class="gwr">
      <div class="special-list new-construction" id="wrap-list-result">
        <ul class="temp head-list">
          <li class="n-name md-1"><?php echo __("Building Name", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="n-addres md-2"><?php echo __("Addres", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="n-unit"><?php echo __("Units", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="n-year"><?php echo __("Year", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="n-stattus"><?php echo __("New construsction", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="n-neighborhood"><?php echo __("Neighborhood", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        </ul>


        <ul class="temp result-search slider-generator">
        <?php foreach($result_feed_decode['result'] as $result_feed_decode_item) { ?>
            <li class="propertie" data-id="343278191" data-mls="A10172834" data-counter="10">
              <h2 class="n-name" title="<?php echo $result_feed_decode_item['post_title']; ?>"><span class="blue-color"><?php echo $result_feed_decode_item['post_title']; ?></span></h2>
              <ul class="features">
                <li class="n-address md-2"> <span><?php echo $result_feed_decode_item['dgt_extra_address']; ?></span></li>
                <li class="n-unit">421</li>
                <li class="n-year"><?php echo $result_feed_decode_item['dgt_year_building']; ?></li>
                <li class="n-stattus"><?php  echo $result_feed_decode_item['type_category']; ?></li>
                <li class="n-neighborhood"><span><?php echo $result_feed_decode_item['neighborhood']; ?></span></li>
              </ul>
              <div class="wrap-slider">
                <ul>
                  <li><a href="<?php echo $result_feed_decode_item['tgbuilding_url']; ?>"><img src="<?php echo $result_feed_decode_item['tgbuilding_image']; ?>" title="<?php echo $result_feed_decode_item['post_title']; ?>" alt="#"></a></li>
                </ul>
              </div>
              <a href="<?php echo $result_feed_decode_item['tgbuilding_url']; ?>" class="linkbuilding">&nbsp;</a>
              <button class="clidxboost-btn-check"><span class="clidxboost-icon-check"></span></button>
            </li>
          <?php } ?>
        </ul>        
      </div>

    <div id="wrap-map">
      <div id="code-map"></div>
      <div id="map-actions">
        <button class="open-map"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        <button class="close-map hide"><?php echo __("Open", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      </div>
    </div>
    </div>

  </section>
  <button class="show-modal" data-modal="modal_save_search" id="save-button-responsive"><span><?php echo __("Save search", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
</main>