<?php if (count($result_post)>0) { ?>
    <section class="team">
        <?php 
        $image_agent='';
        $post_type_object=get_post_type_object('agent');
        foreach ($result_post as $key_agent => $value_agent) {
            $image_agent=$value_agent['image'];
            $link_agent=   get_site_url().'/'.$post_type_object->rewrite['slug'].'/'.$value_agent['post_name'];
        ?>
            <a class="col" href="<?php echo $link_agent; ?>"><img src="<?php echo $image_agent; ?>" alt=""></a>
        <?php } ?>
        

        <a class="col cbtn" href="<?php echo $atts['button_link']; ?>">
            <img class="swm" src="<?php echo get_template_directory_uri(); ?>/images/home-wm.png" alt="">
            <div class="middled">
                <h3><?php echo $atts['title']; ?></h3>
                <p><?php echo $atts['sub_title']; ?></p>
            </div>
        </a>
    </section>
<?php } ?>