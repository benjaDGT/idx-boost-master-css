<div class="idx-neighborhood-wrap">
	<input type="text" class="idx_label_neighborhood" value="" size="52" data-id="random" placeholder="<?php echo __("Search content type", IDXBOOST_DOMAIN_THEME_LANG); ?>" />
	<input type="button" class="button idx-btn-neigh-add" value="Add">
</div>
<br class="clear">

<div class="idx_container_news idx_container_news_neigh">
</div>
<input type="hidden" name="idx_news_neighborhood" class="idx_news_neighborhood" value="<?php echo htmlspecialchars(stripslashes(addslashes($value_news))); ?>" >

<input type="hidden" name="idx_news_neighborhood" class="idx_news_neighborhood" value="<?php echo htmlspecialchars(stripslashes(addslashes($value_news))); ?>" >
<input type="hidden" name="<?php echo $idx_news_neighborhood_trend; ?>" class="<?php echo $idx_news_neighborhood_trend; ?>" value="<?php echo htmlspecialchars(stripslashes(addslashes($value_news_trend))); ?>" >
<input type="hidden" name="<?php echo $idx_news_neighborhood_market; ?>" class="<?php echo $idx_news_neighborhood_market; ?>" value="<?php echo htmlspecialchars(stripslashes(addslashes($value_news_market))); ?>" >

<input type="hidden"  class="idx_news_neighborhood_select">
<style type="text/css">
.idx_container_news .idx_item_news {
    display: inline-block;
    padding: 10px;
    background-color: gray;
    color: white;
    cursor: pointer;
    margin-right: 6px;
    position: relative;    
}	

.idx_container_news .idx_item_news .idx-close {
    position: absolute;
    padding: 1px 4px;
    background-color: red;
    cursor: pointer;
    top: 0px;
    left: 0px;
}

.idx_container_news .idx_item_news.active {
	background-color: #25649f;
}

.idx_neih_top_trend, .idx_neih_top_market {
    border: 1px solid #ccc;
}
</style>

<script type="text/javascript">
var idx_neighboardhood_list = [];
var idx_news_neighboardhood = [];

var idx_news_neighboardhood_trend = [];
var idx_news_neighboardhood_market = [];

idx_neighboardhood_list=<?php echo json_encode($list_pages_neighborhood,true); ?>;

(function($) {
$(function() {
	jQuery(document).ready(function(){
		<?php  if (!empty($value_news) ){ ?>
			idx_news_neighboardhood=JSON.parse(jQuery('.idx_news_neighborhood').val());
		<?php } ?>
		
		<?php  if (!empty($value_news_trend) ){ ?>
			idx_news_neighboardhood_trend=JSON.parse(jQuery('.idx_news_neighborhood_trend').val());
		<?php } ?>

		<?php  if (!empty($value_news_market) ){ ?>
			idx_news_neighboardhood_market=JSON.parse(jQuery('.idx_news_neighborhood_market').val());
		<?php } ?>

		fc_list_neighborhood();
	});


	$(".idx_label_neighborhood").autocomplete({
		source: idx_neighboardhood_list,
		minLength: 0,
		select: function (event, ui) {
			var _id = ui.item.id;
			var _label = ui.item.label;
			$(".idx_news_neighborhood_select").val(_id);
		}
	});

	$('.idx_container_news').on('click','.idx_item_news .idx-close',function(){
	var id_item = $(this).parent('div').attr('id_item');
		jQuery(this).removeClass("active");
		var index = idx_news_neighboardhood.indexOf(id_item);
		if (index > -1) {
		   idx_news_neighboardhood.splice(index, 1);
		   $('.idx_news_neighborhood').val(JSON.stringify(idx_news_neighboardhood));
		   fc_list_neighborhood();
		}

	});

	$('.idx_container_news_neigh').on('click','.idx_neih_checkbox_trend',function(event){
		var id_item=$(this).parent('div').parent('div').attr('id_item');
		var index = idx_news_neighboardhood_trend.indexOf(id_item);
		if (index == -1){
			idx_news_neighboardhood_trend.push(id_item);
		}else{
			idx_news_neighboardhood_trend.splice(index, 1);
		}
		$('.idx_news_neighborhood_trend').val(JSON.stringify(idx_news_neighboardhood_trend));
	});

	$('.idx_container_news_neigh').on('click','.idx_neih_checkbox_market',function(event){
		var id_item=$(this).parent('div').parent('div').attr('id_item');
		var index = idx_news_neighboardhood_market.indexOf(id_item);
		if (index == -1){
			idx_news_neighboardhood_market.push(id_item);
		}else{
			idx_news_neighboardhood_market.splice(index, 1);
		}
		$('.idx_news_neighborhood_market').val(JSON.stringify(idx_news_neighboardhood_market));
	});	

	$('.idx-btn-neigh-add').on('click',function(){
		var idx_new_item='';
		idx_new_item=$(".idx_news_neighborhood_select").val();
		var index = idx_news_neighboardhood.indexOf(idx_new_item);
		if (index == -1){
			idx_news_neighboardhood.push(idx_new_item);
			$(".idx_news_neighborhood_select").val('');
			$(".idx_label_neighborhood ").val('');
			$('.idx_news_neighborhood').val(JSON.stringify(idx_news_neighboardhood));
			fc_list_neighborhood();
		}else{
			alert("Existent item");
		}
	});

	function fc_list_neighborhood(){
		var htmlItem=[];
		
		idx_news_neighboardhood.forEach(function(item_neig){
			var exist=idx_neighboardhood_list.map(function(list_item){ return list_item.id;}).indexOf(item_neig);
			if (exist != -1){
				var exist_trend=idx_news_neighboardhood_trend.indexOf(item_neig);
				var exist_market=idx_news_neighboardhood_market.indexOf(item_neig);
				var checked_trend='',checked_market='';
				if (exist_trend != -1)
					checked_trend='checked';

				if (exist_market != -1)
					checked_market='checked';

				htmlItem.push('<div class="idx_item_news active" id_item="'+idx_neighboardhood_list[exist].id+'"><span class="idx-close">x</span>'+idx_neighboardhood_list[exist].label+'<div class="idx_neih_top_trend"><label>Top Trending</label><input class="idx_neih_checkbox_trend" type="checkbox" '+checked_trend+'></div><div class="idx_neih_top_market"><label>Market report</label><input class="idx_neih_checkbox_market" type="checkbox" '+checked_market+' ></div></div>');
			}
		});
		$('.idx_container_news_neigh').html(htmlItem.join(''));
	}

});

})(jQuery);

</script>
