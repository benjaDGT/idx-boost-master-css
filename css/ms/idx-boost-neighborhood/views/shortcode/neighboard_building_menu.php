<?php if (count($list_pages_neighboardhood)>0) { ?>
    <div class="menu_right sideac">
        <div class="close_menu">x</div>
        <?php foreach ($list_pages_neighboardhood as $value_neigh) {
            $text_fea_relation_building ="SELECT ID,post_title,post_name,wp_postmeta_link.meta_value as link_building FROM {$wpdb->posts} inner join {$wpdb->postmeta} as dgt_tgid_neighnorhood on dgt_tgid_neighnorhood.post_id={$wpdb->posts}.ID and dgt_tgid_neighnorhood.meta_key='dgt_tgid_neighnorhood' and dgt_tgid_neighnorhood.meta_value='".$value_neigh['ID']."' 
            LEFT JOIN {$wpdb->postmeta} as wp_postmeta_link on wp_postmeta_link.meta_key='tgbuilding_url' and wp_postmeta_link.post_id={$wpdb->posts}.ID 
            WHERE {$wpdb->posts}.post_type in('tgbuilding') and post_status='publish' order by post_title asc  ;";
            $result_relation_building = $wpdb->get_results($text_fea_relation_building, ARRAY_A);
            ?>
            <h3 class="fontd icon_open"><?php echo $value_neigh['post_title'];?></h3>
            <div class="conte" style="display: none;">
                <ul class="info">
                    <?php foreach ($result_relation_building as $value_building) { ?>
                        <li><a href="<?php echo $value_building['link_building']; ?>"><?php echo $value_building['post_title']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
<?php } ?>