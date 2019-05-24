     <nav class="clidxboost-menu-ng">
            <?php
             foreach ($list_pages_neighnorhood as $value_neighnorhood) { ?>
                <h3 class="idx_acordeon_mobile clidxboost-menu-ng-title clidxboost-child" char_text="<?php echo $value_neighnorhood; ?>"><a href="javascript:void(0)"><?php echo $value_neighnorhood; ?></a></h3>
            <?php } ?>
          <button id="clidxboost-close-menu-ng">
          <span>Close</span>
          </button>
        </nav>
<script type="text/javascript">
  var idx_setting_mobile =[];
  $=jQuery;
  jQuery('.idx_acordeon_mobile').on('click',function(event){
    var char_text=jQuery(this).attr('char_text');
    if(idx_setting_mobile.indexOf(char_text) ==-1 ){
      var temp_array=items_relation_neig_building.filter(tit_neigh => tit_neigh.neighnorhood==char_text);
      var idxhtml=[],id_neigh='0';

      if (temp_array.length>0){
        idxhtml.push('<ul class="clidxboost-ng-sub-menu">');
        temp_array.forEach(function(item){
          id_neigh=item.id_neigh;
          idxhtml.push('<li><a href="'+item.link+'">'+item.post_title+'</a></li>');
        });    
        idxhtml.push('</ul>');
        $(this).after(idxhtml.join(''));
      }
      idx_setting_mobile.push(char_text);
    }

  });
</script>