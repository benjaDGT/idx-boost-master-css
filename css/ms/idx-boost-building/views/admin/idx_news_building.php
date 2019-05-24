<div class="idx-building-wrap">
	<input type="text" class="idx_label_building" value="" size="52" data-id="random" placeholder="<?php echo __("Search content type", IDXBOOST_DOMAIN_THEME_LANG); ?>" />
	<input type="button" class="button idx-btn-building-add" value="Add">
</div>
<br class="clear">

<div class="idx_container_news idx_container_news_build"></div>
<input type="hidden" name="idx_news_building" class="idx_news_building" value="<?php echo htmlspecialchars(stripslashes(addslashes($value_news))); ?>" >
<input type="hidden"  class="idx_news_building_select">
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
</style>

<script type="text/javascript">
var idx_building_list = [];
var idx_news_building = [];

idx_building_list=<?php echo json_encode($list_pages_building,true); ?>;

(function($) {
$(function() {
<?php  if (!empty($value_news) ){ ?>
	jQuery(document).ready(function(){
		idx_news_building=JSON.parse(jQuery('.idx_news_building').val());
		fc_list_building();
	});
<?php } ?>

	$(".idx_label_building").autocomplete({
		source: idx_building_list,
		minLength: 0,
		select: function (event, ui) {
			var _id = ui.item.id;
			var _label = ui.item.label;
			$(".idx_news_building_select").val(_id);
		}
	});

	$('.idx_container_news').on('click','.idx_item_news .idx-close',function(){
	var id_item = $(this).parent('div').attr('id_item');
		jQuery(this).removeClass("active");
		var index = idx_news_building.indexOf(id_item);
		if (index > -1) {
		   idx_news_building.splice(index, 1);
		   $('.idx_news_building').val(JSON.stringify(idx_news_building));
		   fc_list_building();
		}

	});

	$('.idx-btn-building-add').on('click',function(){
		var idx_new_item='';
		idx_new_item=$(".idx_news_building_select").val();
		var index = idx_news_building.indexOf(idx_new_item);
		if (index == -1){
			idx_news_building.push(idx_new_item);
			$(".idx_news_building_select").val('');
			$(".idx_label_building ").val('');
			$('.idx_news_building').val(JSON.stringify(idx_news_building));
			fc_list_building();
		}else{
			alert("Existent item");
		}
	});

	function fc_list_building(){
		var htmlItem=[];
		idx_news_building.forEach(function(item_neig){
			var exist=idx_building_list.map(function(list_item){ return list_item.id;}).indexOf(item_neig);
			if (exist != -1){
				htmlItem.push('<div class="idx_item_news active" id_item="'+idx_building_list[exist].id+'"><span class="idx-close">x</span>'+idx_building_list[exist].label+'</div>');
			}
		});
		$('.idx_container_news_build').html(htmlItem.join(''));
	}

});

})(jQuery);

</script>
