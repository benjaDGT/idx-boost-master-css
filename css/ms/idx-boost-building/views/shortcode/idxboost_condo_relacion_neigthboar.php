<section class="condos">
    <div class="content">
        <div class="text-center">
            <h2><?php echo __("condo directory", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
        </div>
        <div id="accordion">
            <?php
            $post_type_building =get_post_type_object('flex-idx-building');
            $post_type_building_slug=$post_type_building->rewrite['slug'];
             foreach ($list_pages_neighnorhood as $value_neighnorhood) { ?>
            <h3><?php echo $value_neighnorhood; ?> </h3>
            <div>
                <ul>
                    <?php foreach ($list_pages_buildings as $value_buildings) { 
                        if ($value_buildings['neighnorhood']== $value_neighnorhood) { ?>
                        <li><a href="<?php echo $value_buildings['link']; ?>"><?php echo $value_buildings['post_title']; ?></a></li>
                    <?php } } ?>
                </ul>
            </div>               
            <?php } ?>         
        </div>
    </div>
</section>
