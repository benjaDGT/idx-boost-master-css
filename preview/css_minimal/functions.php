<?php
add_theme_support('post-thumbnails');
set_post_thumbnail_size(825, 510, true);

/*max_lenth_post*/
function the_excerpt_max_charlength($charlength)
{
    $excerpt = get_the_excerpt();
    $charlength++;

    if (mb_strlen($excerpt) > $charlength) {
        $subex   = mb_substr($excerpt, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut   = -(mb_strlen($exwords[count($exwords) - 1]));
        if ($excut < 0) {
            echo mb_substr($subex, 0, $excut);
        } else {
            echo $subex;
        }
    } else {
        echo $excerpt;
    }
}

//TITULO_PAGE
function func_change_title()
{
    add_meta_box('tit-meta-box', __('Sub Heading'), 'title_change_callback', 'page', 'side', 'high', array('arg' => 'value'));
}
function title_change_callback($post)
{
    wp_nonce_field('cyb_meta_box', 'cyb_meta_box_chan_title');
    $post_meta = get_post_custom($post->ID);
    global $wpdb;

    $current_value = '';
    if (isset($post_meta['txtsubtitle'][0])) {
        $current_value = $post_meta['txtsubtitle'][0];
    }
    ?>
       <input name="txtsubtitle" class="widefat" id="txtsubtitle" type="text" value="<?php echo esc_attr($current_value); ?>">
<?php
}
// add_action('add_meta_boxes', 'func_change_title');

function custom_save_chan_title($post_id, $post)
{

    //El select
    if (isset($_POST['txtsubtitle'])) {
        update_post_meta($post_id, 'txtsubtitle', sanitize_text_field($_POST['txtsubtitle']));
    } else {
        //$_POST['select_meta_field'] no tiene valor establecido
        if (isset($post_id)) {
            delete_post_meta($post_id, 'txtsubtitle');
        }
    }
}
add_action('save_post', 'custom_save_chan_title', 10, 2);
//FIN TITLE_PAGE

function dgt_shortcode_testimonial($atts)
{
    
    extract(shortcode_atts(array('post_type' => 'post', 'posts_per_page' => '3'), $atts));
    $args = array('post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => $posts_per_page, 'orderby' => 'field', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC');
    $loop = new WP_Query($args); ?>

    <?php if ( $loop->have_posts() ){ ?>
      <div class="gwr c-flex">
        <div id="testimonials">
          <h2>Testimonials</h2>
          <div class="gs-container-slider clidxboost-testimonial-slider">
            <?php  while ($loop->have_posts()): $loop->the_post();?>
            <p class="item-testimonial"><?php echo the_excerpt_max_charlength(250); ?></p>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    <?php } ?>
<?php return $salida;
}
add_shortcode('dgt_shortcode_testimonial_short', 'dgt_shortcode_testimonial');

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('cyb-theme-style');

    wp_register_script('flex-idx-contact', get_template_directory_uri() . '/js/dgt-contact.js', array('jquery', 'google-maps-api'));
    wp_localize_script('flex-idx-contact', 'flex_idx_contact', array(
        'ajaxUrl'        => admin_url('admin-ajax.php'),
        'ajaxUrlContact' => get_template_directory_uri() . '/inc/request-contact.php',
        'siteUrl'        => site_url(),
    ));
});

register_nav_menus(array(
    'primary' => __('Primary Menu', 'twentyfifteen'),
    'social'  => __('Social Links Menu', 'twentyfifteen'),
));

$argumento = array('post_type' => 'page', 'post__in' => array(isset($_GET['post']) ? $_GET['post'] : 0), 'post_status' => 'publish');

$wp_contact = new WP_Query($argumento);if ($wp_contact->have_posts()) {
    while ($wp_contact->have_posts()): $wp_contact->the_post();
        if (get_the_title() == 'Contact') {
            function func_contact_arr()
        {add_meta_box('contact-detailt-meta-box', __('Location Information'), 'func_contact_opera', 'page', 'side', 'high', array('arg' => 'value'));}
            function func_contact_opera($post)
        {
                wp_nonce_field('cyb_meta_box', 'idx_cyb_contact_detailt');
                $post_meta = get_post_custom($post->ID);
                global $wpdb;
                $idx_current_value_lat = '';
                $idx_current_value_lng = '';

                if (isset($post_meta['idx_contact_lat'][0])) {
                    $idx_current_value_lat = $post_meta['idx_contact_lat'][0];
                }

                if (isset($post_meta['idx_contact_lng'][0])) {
                    $idx_current_value_lng = $post_meta['idx_contact_lng'][0];
                }

                ?>
               <div class="idx_contact_detail"><label>Latitude</label><input name="idx_contact_lat" class="widefat" id="idx_contact_lat" type="text" value="<?php echo esc_attr($idx_current_value_lat); ?>"></div>
               <div class="idx_contact_detail"><label>Longitude</label><input name="idx_contact_lng" class="widefat" id="idx_contact_lng" type="text" value="<?php echo esc_attr($idx_current_value_lng); ?>"></div>

               <style type="text/css">.idx_contact_detail label{font-weight: bold;} .idx_contact_detail label, .idx_contact_detail input {display: block; } </style>
               <?php }
            // add_action('add_meta_boxes', 'func_contact_arr');
        }
    endwhile;
}

function func_contact_detail_save($post_id, $post)
{
    if (isset($_POST['idx_contact_lat'])) {update_post_meta($post_id, 'idx_contact_lat', sanitize_text_field($_POST['idx_contact_lat']));} else {
        if (isset($post_id)) {
            delete_post_meta($post_id, 'idx_contact_lat');
        }
    }
    if (isset($_POST['idx_contact_lng'])) {update_post_meta($post_id, 'idx_contact_lng', sanitize_text_field($_POST['idx_contact_lng']));} else {
        if (isset($post_id)) {
            delete_post_meta($post_id, 'idx_contact_lng');
        }
    }
}



/*CUSTOMIZADOR_PLUGIN*/
function plugin_idx_customize_register($wp_customize)
{

    $wp_customize->add_setting('idx_plugin_custom[idx_color_primary]');
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_plugin_custom[idx_color_primary]', array(
        'label'    => __('Primary Color', 'idx_theme_customizer'),
        'section'  => 'idx_plugin_customizer_scheme',
        'settings' => 'idx_plugin_custom[idx_color_primary]',
    )));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_color_primary]', array(
        'selector'            => '.idx_color_primary',
        'render_callback'     => array($wp_customize, '_idx_color_primary'),
        'container_inclusive' => true,
    ));

    $wp_customize->add_setting('idx_plugin_custom[idx_color_second]');
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_plugin_custom[idx_color_second]', array(
        'label'    => __('Secondary Color', 'idx_theme_customizer'),
        'section'  => 'idx_plugin_customizer_scheme',
        'settings' => 'idx_plugin_custom[idx_color_second]',
    )));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_color_second]', array(
        'selector'            => '.idx_color_second',
        'render_callback'     => array($wp_customize, '_idx_color_second'),
        'container_inclusive' => true,
    ));

    $wp_customize->add_setting('idx_plugin_custom[idx_color_headlines]', array(
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',

    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_color_headlines', array(
        'label'    => __('Headlines Text Color', 'idx_theme_customizer'),
        'section'  => 'idx_plugin_customizer_scheme',
        'settings' => 'idx_plugin_custom[idx_color_headlines]',
    )));

    $wp_customize->add_setting('idx_plugin_custom[idx_color_body_text]', array(
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',

    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_color_body_text', array(
        'label'    => __('Body Text Color', 'idx_theme_customizer'),
        'section'  => 'idx_plugin_customizer_scheme',
        'settings' => 'idx_plugin_custom[idx_color_body_text]',
    )));

    $wp_customize->add_setting('idx_plugin_custom[idx_color_search_bar_text]', array(
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',

    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_color_search_bar_text', array(
        'label'    => __('Search Bar Text Color', 'idx_theme_customizer'),
        'section'  => 'idx_plugin_customizer_scheme',
        'settings' => 'idx_plugin_custom[idx_color_search_bar_text]',
    )));

    $wp_customize->add_setting('idx_plugin_custom[idx_color_search_bar_background]');
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_plugin_custom[idx_color_search_bar_background]', array(
        'label'    => __('Search Bar Background Color', 'idx_theme_customizer'),
        'section'  => 'idx_plugin_customizer_scheme',
        'settings' => 'idx_plugin_custom[idx_color_search_bar_background]',
    )));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_color_search_bar_background]', array(
        'selector'            => '.idx_color_search_bar_background',
        'render_callback'     => array($wp_customize, '_idx_color_search_bar_background'),
        'container_inclusive' => true,
    ));


    $wp_customize->add_setting('idx_plugin_custom[idx_text_sub_title_search_bar]', array('capability'        => 'edit_theme_options','default'           => '--------------','sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_plugin_custom[idx_text_sub_title_search_bar]', array('type'     => 'text','section'  => 'idx_plugin_customizer_scheme','label'    => __('Search Bar Title'),'settings' => 'idx_plugin_custom[idx_text_sub_title_search_bar]',));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_sub_title_search_bar]', array('selector'            => '.idx_text_sub_title_search_bar','render_callback'     => array($wp_customize, '_idx_text_sub_title_search_bar'),'container_inclusive' => true,));


    $wp_customize->add_setting('idx_plugin_custom[idx_text_search_bar]', array('capability'        => 'edit_theme_options','default'           => '--------------','sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_plugin_custom[idx_text_search_bar]', array('type'     => 'text','section'  => 'idx_plugin_customizer_scheme','label'    => __('Search Bar Text'),'settings' => 'idx_plugin_custom[idx_text_search_bar]',));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_search_bar]', array('selector'            => '.idx_text_search_bar','render_callback'     => array($wp_customize, '_idx_text_search_bar'),'container_inclusive' => true,));

    $wp_customize->add_setting('idx_plugin_custom[has_button]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_plugin_custom[has_button]', array('label' => __('Has button ?'), 'section' => 'idx_plugin_customizer_scheme', 'settings' => 'idx_plugin_custom[has_button]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[has_button]', array('selector' => '.idx_languages_english', 'render_callback' => array($wp_customize, '_idx_tesoro_english'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_plugin_custom[idx_text_button1_search_bar]', array('capability'        => 'edit_theme_options','default'           => "I'm looking to buy",'sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_plugin_custom[idx_text_button1_search_bar]', array('type'     => 'text','section'  => 'idx_plugin_customizer_scheme','label'    => __('Firts Button'),'settings' => 'idx_plugin_custom[idx_text_button1_search_bar]',));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_button1_search_bar]', array('selector'            => '.idx_text_button1_search_bar','render_callback'     => array($wp_customize, '_idx_text_button1_search_bar'),'container_inclusive' => true,));

    $wp_customize->add_setting('idx_plugin_custom[idx_text_button2_search_bar]', array('capability'        => 'edit_theme_options','default'           => "I'm looking to sell",'sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_plugin_custom[idx_text_button2_search_bar]', array('type'     => 'text','section'  => 'idx_plugin_customizer_scheme','label'    => __('Second Button'),'settings' => 'idx_plugin_custom[idx_text_button2_search_bar]',));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_text_button2_search_bar]', array('selector'=> '.idx_text_button2_search_bar','render_callback'     => array($wp_customize, '_idx_text_button2_search_bar'), 'container_inclusive' => true, ));


    $wp_customize->add_setting('idx_plugin_custom[idx_link_button1_search_bar]', array('capability'        => 'edit_theme_options','default'           => '#','sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_plugin_custom[idx_link_button1_search_bar]', array('type'     => 'text','section'  => 'idx_plugin_customizer_scheme','label'    => __('Firts link Button'),'settings' => 'idx_plugin_custom[idx_link_button1_search_bar]',));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_link_button1_search_bar]', array('selector'            => '.idx_link_button1_search_bar','render_callback'     => array($wp_customize, '_idx_link_button1_search_bar'),'container_inclusive' => true,));

    $wp_customize->add_setting('idx_plugin_custom[idx_link_button2_search_bar]', array('capability'        => 'edit_theme_options','default'           => '#','sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_plugin_custom[idx_link_button2_search_bar]', array('type'     => 'text','section'  => 'idx_plugin_customizer_scheme','label'    => __('Second Link Button'),'settings' => 'idx_plugin_custom[idx_link_button2_search_bar]',));
    $wp_customize->selective_refresh->add_partial('idx_plugin_custom[idx_link_button2_search_bar]', array('selector'            => '.idx_link_button2_search_bar','render_callback'     => array($wp_customize, '_idx_link_button2_search_bar'),'container_inclusive' => true,));



    $wp_customize->add_setting('idx_plugin_custom[idx_select_difuminacion]', array(
        'default'    => 'transparent',
        'capability' => 'edit_theme_options',
        'type'       => 'option',

    ));
    $wp_customize->add_control('idx_plugin_custom[idx_select_difuminacion]', array(
        'settings' => 'idx_plugin_custom[idx_select_difuminacion]',
        'label'    => 'Search Bar Opacity',
        'section'  => 'idx_plugin_customizer_scheme',
        'type'     => 'select',
        'choices'  => array(
            'transparent' => 'transparent',
            'fill'        => 'fill',
        ),
    ));

    $wp_customize->add_setting('idx_plugin_custom[idx_color_text_color]', array(
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',

    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_color_text_color', array(
        'label'    => __('Text Color', 'idx_theme_customizer'),
        'section'  => 'idx_plugin_customizer_scheme',
        'settings' => 'idx_plugin_custom[idx_color_text_color]',
    )));
}
add_action('customize_register', 'plugin_idx_customize_register');
/*CUSTOMIZADOR_PLUGIN*/

/*CUSTOMIZADOR_THEMES*/
function themename_idx_footer_customize_register($wp_customize)
{

    if (class_exists('WP_Customize_Control')):
        class wp_Customize_flexidx_button extends WP_Customize_Control
    {
            public $types     = 'button';
            public $link_flex = '';

            public function render_content()
        {
                ?>
                    <a class="link_flex_button" href="<?php echo $this->link_flex; ?>">
                        <div class="link_flex_content"> <?php echo $this->label; ?> </div>
                    </a>
                    <style type="text/css"> .link_flex_content { width: 100%; height: 32px; background-color: #0073aa; text-align: center; color: white; margin-top: 0px; top: 4px; position: relative; vertical-align: middle; padding-top: 11px; } .link_flex_button { width: 100%; height: 30px; } </style>
                <?php
    }
        }
/*SEPARADOR_HEADER*/
        class wp_Customize_idxboost_button_separator extends WP_Customize_Control{
            public $types     = 'button';
            public $link_flex = '';
            public function render_content()
        {
                ?><div class="button_separator"> <?php echo $this->label; ?> </div>
                <style type="text/css"> 
                .button_separator { width: 100%; height: 30px; text-align: center; color: #23282d; margin-top: 20px; top: 4px; position: relative; vertical-align: middle; padding-top: 10px; border-color: #2e6c8a; border: 1px solid; border-radius: 30px; }</style>
                <?php
    }
        }        
/*SEPARADOR_HEADER*/        

        class wp_Customize_flexidx_ini extends WP_Customize_Control
    {
            public $types = 'button';
            public function render_content()
        {
                ?>
                    <style type="text/css"> li#accordion-section-static_front_page { display: none !important; } li#customize-control-nav_menu_locations-social {display: none !important; }  </style>
                    <script type="text/javascript">
                        jQuery('.link_flex_button_slider').click(function(){
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-thumb .remove-button').click();
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-headline input').val('');
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-detail input').val('');
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-link input').val('');
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-thumb').hide();
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-detail').hide();
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-headline').hide();
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-link').hide();
                            jQuery('#customize-control-idx_image_slider-'+jQuery(this).attr('event')+'-event').hide();
                        });
                    </script>
                <?php
    }
        }

        class wp_Customize_flexidx_menu extends WP_Customize_Control
    {
            public $types = 'button';
            public function render_content()
        {
                ?>
                <script type="text/javascript">
                        jQuery('.link_flex_button_slider').click(function(){
                            jQuery('#customize-control-nav_menu_locations-primary .button-link').click();
                        });
                </script>
                <?php
    }
        }

        class WP_Customize_Teeny_Control extends WP_Customize_Control
    {
            function __construct($manager, $id, $options)
        {
                parent::__construct($manager, $id, $options);

                global $num_customizer_teenies_initiated;
                $num_customizer_teenies_initiated = empty($num_customizer_teenies_initiated)
                ? 1
                : $num_customizer_teenies_initiated + 1;
            }
            function render_content()
        {
                global $num_customizer_teenies_initiated, $num_customizer_teenies_rendered;
                $num_customizer_teenies_rendered = empty($num_customizer_teenies_rendered)
                ? 1
                : $num_customizer_teenies_rendered + 1;

                $value = $this->value();
                ?>
                <label>
                  <span class="customize-text_editor"><?php echo esc_html($this->label); ?></span>
                  <input id="<?php echo $this->id ?>-link" class="wp-editor-area" type="hidden" <?php $this->link();?> value="<?php echo esc_textarea($value); ?>">
                  <?php
    wp_editor($value, $this->id, [
                    'textarea_name'    => $this->id,
                    'media_buttons'    => false,
                    'drag_drop_upload' => false,
                    'teeny'            => true,
                    'quicktags'        => false,
                    'textarea_rows'    => 5,
                    // MAKE SURE TINYMCE CHANGES ARE LINKED TO CUSTOMIZER
                    'tinymce'          => [
                        'setup' => "function (editor) {
                          var cb = function () {
                            var linkInput = document.getElementById('$this->id-link')
                            linkInput.value = editor.getContent()
                            linkInput.dispatchEvent(new Event('change'))
                          }
                          editor.on('Change', cb)
                          editor.on('Undo', cb)
                          editor.on('Redo', cb)
                          editor.on('KeyUp', cb) // Remove this if it seems like an overkill
                        }",
                    ],
                ]);
                ?>
                </label>
              <?php
    // PRINT THEM ADMIN SCRIPTS AFTER LAST EDITOR
                if ($num_customizer_teenies_rendered == $num_customizer_teenies_initiated) {
                    do_action('admin_print_footer_scripts');
                }

            }
        }

        class wp_Customize_idx_select extends WP_Customize_Control
    {
            public $types = 'select';
            public function render_content()
        {
                ?>
                        <label>
                            <?php if (!empty($this->label)): ?>
                                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                            <?php endif;
            if (!empty($this->description)): ?>
                        <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <?php endif;?>

                    <select class="idx_select_home" <?php $this->link();?>>
                        <?php
foreach ($this->choices as $value => $label) {
                echo '<option value="' . esc_attr($value) . '"' . selected($this->value(), $value, false) . '>' . $label . '</option>';
            }

            ?>
                    </select>
                </label>
                <script type="text/javascript">
                jQuery(document).ready(function(){
                    var myVarMenu = setInterval(myMenuIdx, 1000);
                    function myMenuIdx(){
                        var open_menu=jQuery('#sub-accordion-section-menu_locations').hasClass('open');
                        if(open_menu==true) jQuery('#customize-control-nav_menu_locations-primary .button-link').click();
                    }

                jQuery('.idx_select_home').change(function(){
                    if( jQuery(this).val()=='image'){
                        jQuery('li#customize-control-idx_image_logo').show();
                        jQuery('li#customize-control-idx_site_text').hide();
                        jQuery('li#customize-control-idx_site_text_slogan').hide();
                        jQuery('li#customize-control-idx_site_text_size').hide();
                        jQuery('li#customize-control-idx_site_text_color').hide();
                    }else{
                        jQuery('li#customize-control-idx_site_text').show();
                        jQuery('li#customize-control-idx_site_text_size').show();
                        jQuery('li#customize-control-idx_site_text_slogan').show();
                        jQuery('li#customize-control-idx_site_text_color').show();
                        jQuery('li#customize-control-idx_image_logo').hide();
                    }
                });
                jQuery('.idx_select_home').change();
                });
                </script>
        <?php
}
    }
    endif;


    $wp_customize->add_setting('idx_button_especial_registration');
    $wp_customize->add_control(new wp_Customize_flexidx_button($wp_customize, 'idx_button_especial_registration', array(
        'label'     => __('Registration '),
        'section'   => 'idx_links_importants_customizer_scheme',
        'link_flex' => 'https://www.idxboost.com/signup',
        'priority'  => 1,
    )));

/*
    $wp_customize->add_setting('idx_button_especial_theme');
    $wp_customize->add_control(new wp_Customize_flexidx_button($wp_customize, 'idx_button_especial_theme', array(
        'label'     => __('Theme info '),
        'section'   => 'idx_links_importants_customizer_scheme',
        'link_flex' => 'http://google.com',
        'priority'  => 2,
    )));
    */

    $wp_customize->add_setting('idx_button_especial_support');
    $wp_customize->add_control(new wp_Customize_flexidx_button($wp_customize, 'idx_button_especial_support', array(
        'label'     => __('Support '),
        'section'   => 'idx_links_importants_customizer_scheme',
        'link_flex' => 'https://www.idxboost.com/support',
        'priority'  => 3,
    )));

    $wp_customize->add_setting('idx_button_especial_documentation');
    $wp_customize->add_control(new wp_Customize_flexidx_button($wp_customize, 'idx_button_especial_documentation', array(
        'label'     => __('Documentation '),
        'section'   => 'idx_links_importants_customizer_scheme',
        'link_flex' => admin_url('admin.php?page=flex-idx-settings'),
        'priority'  => 4,
    )));

/*
    $wp_customize->add_setting('idx_button_especial_view');
    $wp_customize->add_control(new wp_Customize_flexidx_button($wp_customize, 'idx_button_especial_view', array(
        'label'     => __('View Demo '),
        'section'   => 'idx_links_importants_customizer_scheme',
        'link_flex' => 'https://demo.idxboost.com',
        'priority'  => 5,
    )));

    $wp_customize->add_setting('idx_button_especial_rate');
    $wp_customize->add_control(new wp_Customize_flexidx_button($wp_customize, 'idx_button_especial_rate', array(
        'label'     => __('Rate this theme '),
        'section'   => 'idx_links_importants_customizer_scheme',
        'link_flex' => 'http://google.com',
        'priority'  => 6,
    )));
*/
    $wp_customize->add_section('idx_social_media_customizer_scheme', array(
        'title'    => __('Social Networks Setup', 'idx_social_media_customizer'),
        'priority' => 101,
    ));

    $wp_customize->add_section('idx_plugin_customizer_scheme', array(
        'title'    => __('Colors', 'idx_plugin_customizer'),
        'priority' => 102,
    ));

    $wp_customize->add_section('idx_languages_customizer_scheme', array(
        'title'    => __('Languages', 'idx_languages_customizer'),
        'priority' => 103,
    ));

    $wp_customize->add_section('idx_slider_customizer_scheme', array(
        'title'    => __('Sliders ', 'idx_slider_customizer'),
        'priority' => 104,
    ));

    $wp_customize->add_section('idx_links_importants_customizer_scheme', array(
        'title'    => __('IDX Boost Important Links', 'idx_links_importants_customizer'),
        'priority' => 105,
    ));

    $wp_customize->add_section('idx_customizer_view_scheme_theme', array(
        'title'    => __('Preview ', 'idx_slider_themes'),
        'priority' => 201,
    ));
    $wp_customize->add_setting('idx_button_view_myweb');
    $wp_customize->add_control(new wp_Customize_flexidx_button($wp_customize, 'idx_button_view_myweb', array(
        'label'     => __('My Website'),
        'section'   => 'idx_customizer_view_scheme_theme',
        'link_flex' => esc_url(home_url('/')),
    )));

#LANGUAGUES
    $wp_customize->add_setting('idx_languages_list[English]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[English]', array('label' => __('English'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[English]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[english]', array('selector' => '.idx_languages_english', 'render_callback' => array($wp_customize, '_idx_tesoro_english'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_languages_list[Russian]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[Russian]', array('label' => __('Russian'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[Russian]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[Russian]', array('selector' => '.idx_languages_russian', 'render_callback' => array($wp_customize, 'idx_tesoro_russian'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_languages_list[Spanish]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[Spanish]', array('label' => __('Spanish'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[Spanish]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[Spanish]', array('selector' => '.idx_languages_spanish', 'render_callback' => array($wp_customize, 'idx_tesoro_spanish'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_languages_list[Portuguese]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[Portuguese]', array('label' => __('Portuguese'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[Portuguese]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[Portuguese]', array('selector' => '.idx_languages_portuguese', 'render_callback' => array($wp_customize, 'idx_tesoro_portuguese'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_languages_list[French]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[French]', array('label' => __('French'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[French]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[French]', array('selector' => '.idx_languages_french', 'render_callback' => array($wp_customize, 'idx_tesoro_french'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_languages_list[Italian]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[Italian]', array('label' => __('Italian'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[Italian]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[Italian]', array('selector' => '.idx_languages_italian', 'render_callback' => array($wp_customize, 'idx_tesoro_italian'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_languages_list[German]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[German]', array('label' => __('German'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[German]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[German]', array('selector' => '.idx_languages_german', 'render_callback' => array($wp_customize, 'idx_tesoro_german'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_languages_list[Chinese]', array('capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_languages_list[Chinese]', array('label' => __('Chinese'), 'section' => 'idx_languages_customizer_scheme', 'settings' => 'idx_languages_list[Chinese]', 'type' => 'checkbox'));
    $wp_customize->selective_refresh->add_partial('idx_languages_list[Chinese]', array('selector' => '.idx_languages_chinese', 'render_callback' => array($wp_customize, 'idx_tesoro_chinese'), 'container_inclusive' => true));
#LANGUAGUES

    for ($i = 0; $i < 6; $i++) {

        $wp_customize->add_setting('idx_image_slider[' . $i . '][thumb]');
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'idx_image_slider[' . $i . '][thumb]', array(
            'label'    => __('Slider ' . ($i + 1) . ' '),
            'section'  => 'idx_slider_customizer_scheme',
            'settings' => 'idx_image_slider[' . $i . '][thumb]',
        )));

        $wp_customize->selective_refresh->add_partial('idx_image_slider[' . $i . '][thumb]', array(
            'selector'            => '.idx_image_slider_' . $i . '_thumb',
            'render_callback'     => array($wp_customize, '_idx_image_slider_' . $i . '_thumb'),
            'container_inclusive' => true,
        ));

        $wp_customize->add_setting('idx_image_slider[' . $i . '][headline]');
        $wp_customize->add_control('idx_image_slider[' . $i . '][headline]', array(
            'label'       => __(''),
            'section'     => 'idx_slider_customizer_scheme',
            'type'        => 'text',
            'input_attrs' => array(
                'placeholder' => __('Headline'),
            ),
        ));

        $wp_customize->add_setting('idx_image_slider[' . $i . '][detail]');
        $wp_customize->add_control('idx_image_slider[' . $i . '][detail]', array(
            'label'       => __(''),
            'section'     => 'idx_slider_customizer_scheme',
            'type'        => 'text',
            'input_attrs' => array(
                'placeholder' => __('Details'),
            ),
        ));

        $wp_customize->add_setting('idx_image_slider[' . $i . '][link]');
        $wp_customize->add_control('idx_image_slider[' . $i . '][link]', array(
            'label'       => __(''),
            'section'     => 'idx_slider_customizer_scheme',
            'type'        => 'url',
            'input_attrs' => array(
                'placeholder' => __('Link'),
            ),
        ));

    }

    $wp_customize->add_setting('idx_site_radio_sta', array('default' => 'image', 'type' => 'option'));
    $wp_customize->add_control(new wp_Customize_idx_select($wp_customize, 'idx_site_radio_sta', array(
        'type'    => 'select',
        'section' => 'title_tagline',
        'choices' => array(
            'text'  => 'Text',
            'image' => 'Image',
        ),
    )));

    $wp_customize->add_setting('idx_site_menu_primary');
    $wp_customize->add_control(new wp_Customize_flexidx_menu($wp_customize, 'idx_site_menu_primary', array('section' => 'title_tagline', 'settings' => 'idx_site_menu_primary')));
    $wp_customize->selective_refresh->add_partial('idx_site_menu_primary', array('selector' => '.idx_site_menu_primary', 'render_callback' => array($wp_customize, '_idx_site_menu_primary'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_site_text', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_site_text', array('type' => 'text', 'section' => 'title_tagline', 'label' => __('Text Site'), 'settings' => 'idx_site_text'));
    $wp_customize->selective_refresh->add_partial('idx_site_text', array('selector' => '.idx_site_text', 'render_callback' => array($wp_customize, '_idx_site_text'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_site_text_slogan', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_site_text_slogan', array('type' => 'text', 'section' => 'title_tagline', 'label' => __('Slogan Site'), 'settings' => 'idx_site_text_slogan'));
    $wp_customize->selective_refresh->add_partial('idx_site_text_slogan', array('selector' => '.idx_site_text_slogan', 'render_callback' => array($wp_customize, '_idx_site_text_slogan'), 'container_inclusive' => true));


    $wp_customize->add_setting('idx_site_text_color');
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idx_site_text_color', array('label' => __('Text site Color', 'idx_theme_customizer'), 'section' => 'title_tagline', 'settings' => 'idx_site_text_color')));
    $wp_customize->selective_refresh->add_partial('idx_site_text_color', array('selector' => '.idx_site_text_color', 'render_callback' => array($wp_customize, '_idx_site_text_color'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_ini_customizer');
    $wp_customize->add_control(new wp_Customize_flexidx_ini($wp_customize, 'idx_ini_customizer', array(
        'label'   => __(''),
        'section' => 'title_tagline',
    )));

    $wp_customize->add_setting('idx_site_text_size', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_site_text_size', array('type' => 'number', 'section' => 'title_tagline', 'label' => __('Text size Site'), 'settings' => 'idx_site_text_size'));
    $wp_customize->selective_refresh->add_partial('idx_site_text_size', array('selector' => '.idx_site_text_size', 'render_callback' => array($wp_customize, '_idx_site_text_size'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_image_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'idx_image_logo', array(
        'label'    => __('Logo', 'idx_theme_customizer_header'),
        'section'  => 'title_tagline',
        'settings' => 'idx_image_logo',
    )));

    $wp_customize->selective_refresh->add_partial('idx_image_logo', array(
        'selector'            => '.idx_image_logo',
        'render_callback'     => array($wp_customize, '_idx_image_logo'),
        'container_inclusive' => true,
    ));

}

//add_action('customize_register', 'themename_idx_header_customize_register');
add_action('customize_register', 'themename_idx_footer_customize_register');
/*CUSTOMIZADOR_THEMES*/

function idx_footer_customizaer()
{

    $idx_style_second_color_point                      = '';
    $style_texto_point                                 = '';
    $select_image_point                                = '';
    $style_boton_point                                 = '';
    $style_body_point_rgba_transparent                 = '';
    $style_search_bar_texto                            = '';
    $idx_style_texto_theme_point                       = '';
    $idx_style_body_text_theme_point                   = '';
    $idx_style_search_bar_bose_theme_transparent_point = '';
    $style_title_galery                                = '';
    $image_footer_firt                                 = '';
    $image_footer_second                               = '';
    $image_footer_third                                = '';
    $idx_style_plugin_sec_pri                          = '';
    $idx_difuminacion_home=''; $idx_difuminacion_inner_pages=''; $color_inner_pages=''; $color_home='';    

    if (empty(get_option('idxboost_themes_custom')['idx_difuminacion_home'])) $idx_difuminacion_home = 'transparent'; else $idx_difuminacion_home = get_option('idxboost_themes_custom')['idx_difuminacion_home'];
    if (empty(get_option('idxboost_themes_custom')['idx_difuminacion_inner_pages'])) $idx_difuminacion_inner_pages = 'transparent'; else $idx_difuminacion_inner_pages = get_option('idxboost_themes_custom')['idx_difuminacion_inner_pages'];
    if (empty(get_theme_mod('idxboost_themes_custom')['color_home'])) $color_home = ''; else  $color_home = get_theme_mod('idxboost_themes_custom')['color_home'];
    if (empty(get_theme_mod('idxboost_themes_custom')['color_inner_pages'])) $color_inner_pages = ''; else  $color_inner_pages = get_theme_mod('idxboost_themes_custom')['color_inner_pages'];

    if (empty(get_option('idx_plugin_custom')['idx_select_difuminacion'])) {
        $idx_style_search_bar_bose = 'transparent';
    } else {
        $idx_style_search_bar_bose = get_option('idx_plugin_custom')['idx_select_difuminacion'];
    }

    if (empty(get_theme_mod('idx_plugin_custom')['idx_color_search_bar_background'])) {
        $idx_style_search_bar_body = '';
    } else {
        $idx_style_search_bar_body = get_theme_mod('idx_plugin_custom')['idx_color_search_bar_background'];
    }

    if (empty(get_theme_mod('idx_plugin_custom')['idx_color_primary'])) {
        $idx_style_boton_point = '';
    } else {
        $idx_style_boton_point = get_theme_mod('idx_plugin_custom')['idx_color_primary'];
    }

    if (empty(get_theme_mod('idx_plugin_custom')['idx_color_second'])) {
        $idx_style_second_color = '';
    } else {
        $idx_style_second_color = get_theme_mod('idx_plugin_custom')['idx_color_second'];
    }

    if (empty(get_theme_mod('idx_site_text_size'))) {
        $idx_site_text_size = '';
    } else {
        $idx_site_text_size = get_theme_mod('idx_site_text_size');
    }

    if (empty(get_theme_mod('idx_site_text_color'))) {
        $idx_site_text_color = '';
    } else {
        $idx_site_text_color = get_theme_mod('idx_site_text_color');
    }

    if (empty(get_option('idx_plugin_custom')['idx_color_search_bar_text'])) {
        $idx_style_search_bar_texto = '';
    } else {
        $idx_style_search_bar_texto = get_option('idx_plugin_custom')['idx_color_search_bar_text'];
    }

    if (empty(get_option('idx_plugin_custom')['idx_color_text_color'])) {
        $idx_style_text_color = '';
    } else {
        $idx_style_text_color = get_option('idx_plugin_custom')['idx_color_text_color'];
    }

    if (empty(get_option('idx_plugin_custom')['idx_color_headlines'])) {
        $idx_style_texto_point = '';
    } else {
        $idx_style_texto_point = get_option('idx_plugin_custom')['idx_color_headlines'];
    }

    if (empty(get_option('idx_plugin_custom')['idx_color_body_text'])) {
        $idx_style_body_point = '';
    } else {
        $idx_style_body_point = get_option('idx_plugin_custom')['idx_color_body_text'];
    }

    if ($idx_style_search_bar_bose == 'transparent') {
        $idx_style_body_point_rgba_transparent = convert_rgba($idx_style_search_bar_body);
    } else {
        $idx_style_body_point_rgba_transparent = $idx_style_search_bar_body;
    }

    if (!empty($color_home)) {
        if ($idx_difuminacion_home == 'transparent')  $color_home = 'background-color:'.convert_rgba($color_home).';'; else  $color_home = 'background-color:'.$color_home.';';
    }
    
    if (!empty($color_inner_pages)) {
        if ($idx_difuminacion_inner_pages == 'transparent')  $color_inner_pages = 'background-color:'.convert_rgba($color_inner_pages).';'; else  $color_inner_pages = 'background-color:'.$color_inner_pages.';';
    }

    if (strlen(($idx_style_texto_point)) > 0) {$style_texto_point = 'h2.title-block.single, .title-conteiner .title-page, #flex-home-theme .flex-block-description .title-block, #flex-contact-theme .title-block, .flex-block-description .title-block, #flex-filters-theme .gwr.c-flex .flex-block-description .title-block, .widget .title, #flex-blog-detail-theme .gwr.c-flex .flex-block-description .flex-page-title { color: ' . $idx_style_texto_point . '; } ';}

    $color_second              = '';
    $color_primary             = '';
    $color_texto               = '';
    $color_idx_site_text_color = '#000000';
    $color_idx_site_text_size  = '12px';
    if (strlen($idx_style_second_color) > 0) {$color_second = $idx_style_second_color;}
    if (strlen(($idx_style_boton_point)) > 0) {$color_primary = $idx_style_boton_point;}
    if (strlen(($idx_style_text_color)) > 0) {$color_texto = $idx_style_text_color;}
    if (strlen(($idx_site_text_size)) > 0) {$color_idx_site_text_size = $idx_site_text_size . 'px';}
    if (strlen(($idx_site_text_color)) > 0) {$color_idx_site_text_color = $idx_site_text_color;}

    $idx_style_plugin_sec_pri = '

/*----------------------------------------------------------------------------------*/
/* HEADER
/*----------------------------------------------------------------------------------*/

/*Preloader*/
.wrap-preloader .preloader-icon:before{
	border-top-color:'.$color_primary.';
}

/*Redes sociales header*/
#header .wrap-options .gwr .social-networks li{
	background-color: '.$color_primary.';
}

#header .wrap-options .gwr .social-networks li:hover:before{
	color: '.$color_primary.';
}

/*menu responsive(Hamburguesa)*/
#header .wrap-menu .gwr .hamburger-content #hamburger span,
#header .wrap-menu .gwr .hamburger-content #hamburger span:before,
#header .wrap-menu .gwr .hamburger-content #hamburger span:after{
	background: '.$color_primary.';
}

/*menu lateral*/
#header .wrap-menu .gwr .menu-responsive{
	background-color: '.$color_primary.';
}

/*hover item nemu*/
#header .wrap-menu .gwr #menu-main>ul>li:after{
	background-color: '.$color_primary.';
}

/*sub menu*/
#header .wrap-menu .gwr #menu-main>ul>li .sub-menu{
	background-color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* SLIDER
/*----------------------------------------------------------------------------------*/

/*bullet activo*/
.clidxboost-gs-wrapper-bullets .gs-bullet.gs-bullet-active:before {
  background-color: '.$color_primary.';
}

/*Next y prev (slider propiedad)*/
.clidxboost-properties-slider .gs-wrapper-arrows .gs-next-arrow, 
.clidxboost-properties-slider .gs-wrapper-arrows .gs-prev-arrow{
	background-color: '.$color_primary.';
	border-color: '.$color_primary.';
}

.clidxboost-properties-slider .gs-wrapper-arrows .gs-next-arrow:hover, 
.clidxboost-properties-slider .gs-wrapper-arrows .gs-prev-arrow:hover{
	color: '.$color_primary.';
}

.ib-pvsinumber, .ib-pvsititle,
.ib-pvslider .gs-next-arrow, 
.ib-pvslider .gs-prev-arrow{
	background-color: '.$color_primary.'99 !important;
}

.ib-pvslider .gs-next-arrow:hover, 
.ib-pvslider .gs-prev-arrow:hover{
	background-color: '.$color_primary.' !important;
}

.gs-fs{
	background-color: '.$color_primary.' !important;
}


/*----------------------------------------------------------------------------------*/
/* FOOTER (NEWSLETTER)
/*----------------------------------------------------------------------------------*/

/*background seccion del formulario*/
.flex-newsletter-content{
	background-color: '.$color_primary.';
}

/*boton*/
.flex-newsletter-content .form-content .gform_footer .button{
	background-color: '.$color_primary.';
}

.flex-newsletter-content .form-content .gform_footer .button:hover{
	color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* BOTONES
/*----------------------------------------------------------------------------------*/

/*Home boton*/
#flex-home-theme .flex-block-description .clidxboost-btn-link span{
	color: '.$color_primary.';
	border-color: '.$color_primary.';
}

#flex-home-theme .flex-block-description .clidxboost-btn-link span:hover{
	background-color: '.$color_primary.';
}

#flex-bubble-search .flex-content-btn .flex-btn-link{
	background-color: '.$color_primary.';
	border-color: '.$color_primary.';
}

#flex-bubble-search .flex-content-btn .flex-btn-link:hover{
	color: '.$color_primary.';
}

/*About page*/
#flex-about-theme .clidxboost-btn-link span, 
#flex-about-theme .clidxboost-btn span {
	background-color: '.$color_primary.';
	border-color: '.$color_primary.';
}

#flex-about-theme .clidxboost-btn-link:hover span, 
#flex-about-theme .clidxboost-btn:hover span{
	background-color: #FFF;
	color: '.$color_primary.';
}

/*Detalle blog*/
#flex-blog-detail-theme .clidxboost-btn-link span, 
#flex-blog-detail-theme .clidxboost-btn span{
	background-color: '.$color_primary.';
	border-color: '.$color_primary.';
}

#flex-blog-detail-theme .clidxboost-btn-link:hover span, 
#flex-blog-detail-theme .clidxboost-btn:hover span{
	background-color: #FFF;
	color: '.$color_primary.';
}

.modal_cm .form_content .gform_footer .gform_button {
	background-color: '.$color_primary.';
	border-color: '.$color_primary.';
}

.modal_cm .form_content .gform_footer .gform_button:hover,
.ib-pscitem:hover .ib-psbtn .ib-pstxt {
	color: '.$color_primary.' !important;
}

.clidxboost-sc-filters .content-filters #wrap-filters .gwr #filters li.save button{
	background: '.$color_primary.' !important;
}

.ib-phbtn.ib-requestinfo, .ib-phbtn:hover {
	background-color: '.$color_primary.' !important;
	border-color: '.$color_primary.' !important;
}

.ib-pvitem{
	background-color: '.$color_primary.' !important;
}

.ib-pscitem:hover .ib-psbtn:before,
.ib-paititle:before{
	background-color: #FFF !important;
	color: '.$color_primary.' !important;
}

.ib-pvitem.ib-pvi-active{
	background-color: #FFF !important;
	color: '.$color_primary.' !important;
}

.ib-cfsubmit {
	background-color: '.$color_primary.' !important;
	border-color: '.$color_primary.' !important;
}

.ib-cfsubmit:hover {
	background-color: #FFF !important;
  color: '.$color_primary.' !important;
}

.ib-btnfs,
.gs-wrapper-arrows.gs-style-arrow .gs-next-arrow, 
.gs-wrapper-arrows.gs-style-arrow .gs-prev-arrow{
	background-color: '.$color_primary.' !important;
}

.ib-mgsubmit{
	background-color: '.$color_primary.' !important;
	border-color: '.$color_primary.' !important;
}

.ib-mgsubmit:hover{
	background-color: #FFF !important;
	color: '.$color_primary.' !important;
}

.modal_cm .form_content .btn_form,
.modal_cm #push-registration .pr-steps-container .pr-step .pr-next-step, 
.modal_cm #push-registration .pr-steps-container .pr-step .pr-redbtn{
	background-color: '.$color_primary.' !important;
	border-color: '.$color_primary.' !important;
}

.modal_cm .form_content .btn_form:hover,
.modal_cm #push-registration .pr-steps-container .pr-step .pr-next-step:hover, 
.modal_cm #push-registration .pr-steps-container .pr-step .pr-redbtn:hover{
	color: '.$color_primary.' !important;
	background-color: #FFF !important;
}


/*----------------------------------------------------------------------------------*/
/* GRILLA
/*----------------------------------------------------------------------------------*/

/*Color de borde en hover*/
#wrap-result.full-map #result-search>li:hover .view-detail, 
#wrap-result.full-map .result-search>li:hover .view-detail, 
#wrap-result.view-grid #result-search>li:hover .view-detail, 
#wrap-result.view-grid .result-search>li:hover .view-detail, 
.wrap-result.full-map #result-search>li:hover .view-detail, 
.wrap-result.full-map .result-search>li:hover .view-detail, 
.wrap-result.view-grid #result-search>li:hover .view-detail, 
.wrap-result.view-grid .result-search>li:hover .view-detail{
	border-color: '.$color_primary.';
}

/*Next y prev*/
#wrap-result.full-map #result-search>li .wrap-slider .next:hover, 
#wrap-result.full-map #result-search>li .wrap-slider .prev:hover, 
#wrap-result.full-map .result-search>li .wrap-slider .next:hover, 
#wrap-result.full-map .result-search>li .wrap-slider .prev:hover, 
#wrap-result.view-grid #result-search>li .wrap-slider .next:hover, 
#wrap-result.view-grid #result-search>li .wrap-slider .prev:hover, 
#wrap-result.view-grid .result-search>li .wrap-slider .next:hover, 
#wrap-result.view-grid .result-search>li .wrap-slider .prev:hover, 
.wrap-result.full-map #result-search>li .wrap-slider .next:hover, 
.wrap-result.full-map #result-search>li .wrap-slider .prev:hover, 
.wrap-result.full-map .result-search>li .wrap-slider .next:hover, 
.wrap-result.full-map .result-search>li .wrap-slider .prev:hover, 
.wrap-result.view-grid #result-search>li .wrap-slider .next:hover, 
.wrap-result.view-grid #result-search>li .wrap-slider .prev:hover, 
.wrap-result.view-grid .result-search>li .wrap-slider .next:hover, 
.wrap-result.view-grid .result-search>li .wrap-slider .prev:hover{
	background-color: '.$color_primary.';
}

#wrap-result.full-map #result-search>li .wrap-slider .next, 
#wrap-result.full-map #result-search>li .wrap-slider .prev, 
#wrap-result.full-map .result-search>li .wrap-slider .next, 
#wrap-result.full-map .result-search>li .wrap-slider .prev, 
#wrap-result.view-grid #result-search>li .wrap-slider .next, 
#wrap-result.view-grid #result-search>li .wrap-slider .prev, 
#wrap-result.view-grid .result-search>li .wrap-slider .next, 
#wrap-result.view-grid .result-search>li .wrap-slider .prev, 
.wrap-result.full-map #result-search>li .wrap-slider .next, 
.wrap-result.full-map #result-search>li .wrap-slider .prev, 
.wrap-result.full-map .result-search>li .wrap-slider .next, 
.wrap-result.full-map .result-search>li .wrap-slider .prev, 
.wrap-result.view-grid #result-search>li .wrap-slider .next, 
.wrap-result.view-grid #result-search>li .wrap-slider .prev, 
.wrap-result.view-grid .result-search>li .wrap-slider .next, 
.wrap-result.view-grid .result-search>li .wrap-slider .prev{
	background-color: '.$color_primary.'99;
}

#wrap-result.full-map #result-search>li .flex-property-new-listing, 
#wrap-result.full-map .result-search>li .flex-property-new-listing, 
#wrap-result.view-grid #result-search>li .flex-property-new-listing, 
#wrap-result.view-grid .result-search>li .flex-property-new-listing, 
.wrap-result.full-map #result-search>li .flex-property-new-listing, 
.wrap-result.full-map .result-search>li .flex-property-new-listing,
.wrap-result.view-grid #result-search>li .flex-property-new-listing, 
.wrap-result.view-grid .result-search>li .flex-property-new-listing,
body:not(.clidxboost-nmap) #wrap-result.view-map #result-search>li .flex-property-new-listing, 
body:not(.clidxboost-nmap) #wrap-result.view-map .result-search>li .flex-property-new-listing, 
body:not(.clidxboost-nmap) .wrap-result.view-map #result-search>li .flex-property-new-listing, 
body:not(.clidxboost-nmap) .wrap-result.view-map .result-search>li .flex-property-new-listing{
	background-color: '.$color_primary.'99;
}

#wrap-result.full-map #result-search>li .wrap-slider>ul>li:before, 
#wrap-result.full-map .result-search>li .wrap-slider>ul>li:before, 
#wrap-result.view-grid #result-search>li .wrap-slider>ul>li:before, 
#wrap-result.view-grid .result-search>li .wrap-slider>ul>li:before, 
.wrap-result.full-map #result-search>li .wrap-slider>ul>li:before, 
.wrap-result.full-map .result-search>li .wrap-slider>ul>li:before, 
.wrap-result.view-grid #result-search>li .wrap-slider>ul>li:before, 
.wrap-result.view-grid .result-search>li .wrap-slider>ul>li:before{
	border-top-color: '.$color_primary.';
}

#wrap-result.view-map .view-map-detail:before, 
.wrap-result.view-map .view-map-detail:before{
	color: '.$color_primary.';
}

body:not(.clidxboost-nmap) #wrap-result.view-map #wrap-list-result::-webkit-scrollbar-thumb, 
body:not(.clidxboost-nmap) .wrap-result.view-map #wrap-list-result::-webkit-scrollbar-thumb{
	background-color: '.$color_primary.';
}

body:not(.clidxboost-nmap) #wrap-result.view-map #wrap-map #map-actions button, 
body:not(.clidxboost-nmap) .wrap-result.view-map #wrap-map #map-actions button{
	background-color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* AUTOCOMPLETADORES
/*----------------------------------------------------------------------------------*/

#cities-list ul, 
.cities-list ul{
	border-top-color: '.$color_primary.';
}

#cities-list ul li:hover, 
.cities-list ul li:hover {
  background-color: '.$color_primary.';
  border-bottom-color: '.$color_primary.'!important;
  color: #FFF;
}

#cities-list ul::-webkit-scrollbar-thumb, 
.cities-list ul::-webkit-scrollbar-thumb{
	background-color: '.$color_primary.'!important;
}

/*----------------------------------------------------------------------------------*/
/* FILTRES
/*----------------------------------------------------------------------------------*/

#wrap-subfilters .gwr #sub-filters>li#filter-views>ul li.grid.active, 
#wrap-subfilters .gwr #sub-filters>li#filter-views>ul li.list.active, 
#wrap-subfilters .gwr #sub-filters>li#filter-views>ul li.map.active,
#wrap-subfilters .gwr #sub-filters>li#filter-views>ul li:hover{
	color: '.$color_primary.';
}

#wrap-result.view-list #result-search>li .view-detail:hover, 
#wrap-result.view-list .result-search>li .view-detail:hover, 
.wrap-result.view-list #result-search>li .view-detail:hover, 
.wrap-result.view-list .result-search>li .view-detail:hover{
	border-color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* PAGINADOR
/*----------------------------------------------------------------------------------*/

#paginator-cnt #nav-results #principal-nav li.active a,
#paginator-cnt #nav-results #principal-nav li a:hover,
#paginator-cnt #nav-results #firstp:hover, 
#paginator-cnt #nav-results #lastp:hover, 
#paginator-cnt #nav-results #nextn:hover, 
#paginator-cnt #nav-results #prevn:hover{
	background-color: '.$color_primary.';
	border-color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* BLOG
/*----------------------------------------------------------------------------------*/

#blog-collection #articles-blog li:hover{
	border-color: '.$color_primary.';
}
#blog-collection #articles-blog li .content-article time{
	background-color: '.$color_primary.';
}

.widget.search .searchArea-container .input-search:focus{
	border-bottom-color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* CONTACT
/*----------------------------------------------------------------------------------*/

#flex-contact-theme .flex-block-share.standar .social-networks li:before,
.flex-contact-list li a:before{
	color: '.$color_primary.';
}

.flex-content-form .opt-list .chk-item label:after{
	color: '.$color_primary.';
	background-color: transparent;
}

.flex-content-form .opt-list .radio-item input[type=checkbox]:checked+label:after, 
.flex-content-form .opt-list .radio-item input[type=radio]:checked+label:after{
	background-color: '.$color_primary.';
}

.flex-content-form .form-item .clidxboost-btn-link span{
	color: '.$color_primary.';
	border-color: '.$color_primary.';
}

.flex-content-form .form-item .clidxboost-btn-link:hover span{
	background-color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* SEARCH FILTER
/*----------------------------------------------------------------------------------*/
.ib-filter-container .ib-fmsubmit{
	background-color: '.$color_primary.';
}

.ui-autocomplete .ui-menu-item .ui-menu-item-wrapper.ui-state-active, 
.ui-autocomplete .ui-menu-item .ui-menu-item-wrapper:hover{
	background-color: '.$color_primary.';
}

.ui-autocomplete::-webkit-scrollbar-thumb{
	background-color: '.$color_primary.';
}

.ib-oiwrapper:before{
	color: '.$color_primary.';
}

.ib-fimini:before{
	border-bottom-color: '.$color_primary.' !important;
}

.ib-fimini{
	border-top-color: '.$color_primary.' !important;
}

.ib-range .ui-slider-range{
	background-color: '.$color_primary.' !important;
}

.ib-icheck:checked+label:before{
	border-color: '.$color_primary.' !important;	
}

.ib-fdesktop::-webkit-scrollbar-thumb,
.ib-clabel:after,
.ib-fdmatching{
	background-color: '.$color_primary.' !important;		
}

.ib-fifor.ib-fifor-active, 
.ib-fifor:hover{
	background-color: '.$color_primary.' !important;
	border-color: '.$color_primary.' !important;
}

.ib-dbitem:hover{
	background-color: '.$color_primary.' !important;
	color: #FFF;
}

.ib-pstatus,
.ib-pislider .gs-next-arrow, 
.ib-pislider .gs-prev-arrow{
	background-color: '.$color_primary.'99 !important;	
}

.ib-pitem:hover{
	border-color: '.$color_primary.' !important;	 
}

.ib-plitem.ib-plitem-active, .ib-plitem:hover,
.ib-pagfirst:hover, .ib-paglast:hover,
.ib-pagnext:hover, .ib-pagprev:hover {
  background-color: '.$color_primary.' !important;	
  border-top-color: '.$color_primary.' !important;	
  border-bottom-color: '.$color_primary.' !important;	
}

.ib-fdesktop{
	border-top-color: '.$color_primary.' !important;
}

.ib-oitem.ib-oadbanced .ib-oiwrapper:after{
  border-bottom-color: '.$color_primary.' !important;	
}

.ib-wgrid::-webkit-scrollbar-thumb {
  background-color: '.$color_primary.' !important;	
}

.gs-item-loading:after, 
.gs-resize:after {
  border-top-color: '.$color_primary.' !important;	
}

/*----------------------------------------------------------------------------------*/
/* FILTROS REGULARES
/*----------------------------------------------------------------------------------*/

.content-filters #wrap-filters .gwr #all-filters #mini-filters>li.filter-box .list-type-sold-rent>li button.active,
.content-filters #wrap-filters .gwr #all-filters #mini-filters>li.filter-box .list-type-sold-rent>li button:hover,
.content-filters .wrap-filters .gwr #all-filters #mini-filters>li.filter-box .list-type-sold-rent>li button.active,
.content-filters .wrap-filters .gwr #all-filters #mini-filters>li.filter-box .list-type-sold-rent>li button:hover {
	background-color: '.$color_primary.';
	border-color: '.$color_primary.';
}

.content-filters #wrap-filters .gwr #all-filters #mini-filters>li .gwr .wrap-item .wrap-range .range-slide .ui-slider-range,
.content-filters .wrap-filters .gwr #all-filters #mini-filters>li .gwr .wrap-item .wrap-range .range-slide .ui-slider-range,
.content-filters #wrap-filters .gwr #all-filters #mini-filters>li.action-filter #apply-filters-min, 
.content-filters .wrap-filters .gwr #all-filters #mini-filters>li.action-filter #apply-filters-min{
	background-color: '.$color_primary.';
}

.content-filters #wrap-filters .gwr #all-filters #mini-filters>li .gwr .wrap-item .wrap-checks>ul li input:checked+label:before,
.content-filters .wrap-filters .gwr #all-filters #mini-filters>li .gwr .wrap-item .wrap-checks>ul li input:checked+label:before{
	border-color: '.$color_primary.';
}

.content-filters #wrap-filters .gwr #all-filters #mini-filters>li .gwr .wrap-item .wrap-checks>ul li label:after,
.content-filters .wrap-filters .gwr #all-filters #mini-filters>li .gwr .wrap-item .wrap-checks>ul li label:after{
	background-color: '.$color_primary.';
}

.content-filters #wrap-filters .gwr #filters li.mini-search .clidxboost-icon-search{
	background-color: '.$color_primary.';
}

.content-filters #wrap-filters .gwr #filters li.content_select:after, 
.content-filters #wrap-filters .gwr .filters li.content_select:after, 
.content-filters .wrap-filters .gwr #filters li.content_select:after, 
.content-filters .wrap-filters .gwr .filters li.content_select:after{
	color: '.$color_primary.';
}

/*----------------------------------------------------------------------------------*/
/* DETALLE DE PROPIEDAD
/*----------------------------------------------------------------------------------*/

#full-main .moptions .slider-option .option-switch{
  background-color: '.$color_primary.';	
}

#full-main .moptions .full-screen{
	background-color: '.$color_primary.'99 !important;
}

#full-main .moptions .full-screen:hover{
	background-color: '.$color_primary.' !important;
}

#full-slider .clidxboost-full-slider .gs-next-arrow, 
#full-slider .clidxboost-full-slider .gs-prev-arrow{
	background-color: '.$color_primary.'99 !important;
	transition: all .3s;
}

#full-slider .clidxboost-full-slider .gs-next-arrow:hover, 
#full-slider .clidxboost-full-slider .gs-prev-arrow:hover{
	background-color: '.$color_primary.' !important;
}

#full-main .form-content .gform_footer .gform_button {
  background-color: '.$color_primary.';	
  border-color: '.$color_primary.';	
}

#full-main .form-content .gform_footer .gform_button:hover{
	color: '.$color_primary.';
	background-color: #FFF;
}

.clidxboost-niche-tab-filters .clidxboost-niche-tab button span:before{
  background-color: '.$color_primary.';	
}

#full-main .panel-options .options-list .action-list li a:hover{
  color: '.$color_primary.';	
}

#full-main .title-conteiner .content-fixed .content-fixed-title .breadcrumb-options .btn-request {
  background-color: '.$color_primary.';	
  border-color: '.$color_primary.';	
}

#full-main .title-conteiner .content-fixed .content-fixed-title .breadcrumb-options .btn-request:hover{
	color: '.$color_primary.';
}


#full-main .title-conteiner .content-fixed .content-fixed-title .breadcrumb-options .link-back:hover, 
#full-main .title-conteiner .content-fixed .content-fixed-title .breadcrumb-options .link-search:hover,
.fixed-active #full-main .title-conteiner .content-fixed .content-fixed-title .breadcrumb-options .link-back:hover{
	color: '.$color_primary.' !important;
}

.aside .property-information li.rent.active-fbc, 
.aside .property-information li.sale.active-fbc, 
.aside .property-information li.sold.active-fbc,
.aside .property-information li.sale:hover,
.aside .property-information li.rent:hover,
.aside .property-information li.sold:hover{
	background-color: '.$color_primary.';
}

.group-flex li.active a, 
.group-flex li.active button,
.group-flex li:hover a, 
.group-flex li:hover button{
	border-color: '.$color_primary.';
  background-color: '.$color_primary.';	
}

#full-main .panel-options .options-list .shared-content:hover #show-shared{
  color: '.$color_primary.';	
}


/*----------------------------------------------------------------------------------*/
/* LUXURY CONDOS
/*----------------------------------------------------------------------------------*/

#luxury-condo-page .view-grid #result-search .propertie .features .name, 
#luxury-condo-page .view-grid .result-search .propertie .features .name{
  background-color: '.$color_primary.';
}

#luxury-condo-page .ib-group-btn .ib-btn-mp.ib-active, 
#luxury-condo-page .ib-group-btn .ib-btn-mp:hover {
  color: '.$color_primary.';
}

#luxury-condo-page .content-filters #wrap-filters .gwr #filters li.all button, 
#luxury-condo-page .content-filters #wrap-filters .gwr .filters li.all button, 
#luxury-condo-page .content-filters .wrap-filters .gwr #filters li.all button, 
#luxury-condo-page .content-filters .wrap-filters .gwr .filters li.all button {
	border-color: '.$color_primary.';
  background-color: '.$color_primary.';	
}

#wrap-subfilters .gwr #sub-filters>li#filter-views.grid:before, 
#wrap-subfilters .gwr #sub-filters>li#filter-views.list:before, 
#wrap-subfilters .gwr #sub-filters>li#filter-views.map:before{
	color: '.$color_primary.';
}

#luxury-condo-page .view-list #result-search .propertie .features .name, 
#luxury-condo-page .view-list .result-search .propertie .features .name{
  background-color: '.$color_primary.';	
}

.full-page-luxury.view-map #luxury-condo-page .mbt-active:before{
	color: '.$color_primary.';
}

body:not(.clidxboost-nmap) #wrap-result.view-map #wrap-list-result::-webkit-scrollbar-thumb, 
body:not(.clidxboost-nmap) .wrap-result.view-map #wrap-list-result::-webkit-scrollbar-thumb{
  background-color: '.$color_primary.' !important;
}

.wrap-neighborhood-list .wrap-neighborhood-item .wrap-neighborhood-description:hover{
	border-color: '.$color_primary.';
}

.wrap-neighborhood-list .wrap-neighborhood-item .wrap-neighborhood-image:before{
	border-top-color: '.$color_primary.';	
}

.nav-aside .form-search:before{
  background-color: '.$color_primary.';
}

.basic-theme .clidxboost-btn-link span, 
.basic-theme .clidxboost-btn span{
	border-color: '.$color_primary.';
  background-color: '.$color_primary.';
}

.basic-theme .clidxboost-btn-link:hover span, 
.basic-theme .clidxboost-btn:hover span{
	color: '.$color_primary.';
  background-color: #FFF;
}

';

if (strlen($idx_style_second_color) > 0) {
$idx_style_second_color_point = '
defs radialGradient:nth-child(1) stop{ 
	stop-color: ' . $idx_style_second_color . ' !important; 
} 

.dgt-richmarker-group:after, 
.dgt-richmarker-single:after{ 
	border-top: 5px solid ' . $idx_style_second_color . ' !important; 
} 

.ib-ibcount,
.mapview-container .mapviwe-header, 
.dgt-richmarker-group, 
.dgt-richmarker-single, 
.mapview-container .mapviwe-header .closeInfo, 
#wrap-result #nav-results #principal-nav li:hover,  
#wrap-result #nav-results .ad:hover,
.mapview-container .mapviwe-header .build, 
.mapview-container .mapviwe-body::-webkit-scrollbar-thumb, 
.mapview-container .mapviwe-body::-webkit-scrollbar, 
.dgt-richmarker-group:before, .cir-sta.sale, .ib-ibwtitle{
	background-color: ' . $idx_style_second_color . ' !important; 
}';
/*
#paginator-cnt #nav-results #firstp:hover, 
#paginator-cnt #nav-results #lastp:hover, 
#paginator-cnt #nav-results #nextn:hover, 
#paginator-cnt #nav-results #prevn:hover, 
#paginator-cnt #nav-results #principal-nav li a:hover, 
#paginator-cnt #nav-results #principal-nav li.active a , 
#full-main .title-conteiner .content-fixed .content-fixed-title .breadcrumb-options .btn-request:hover, 
#header-filters .text-wrapper .allf-ss:hover, .modal_cm .form_content .btn_form:hover, 
#modal_login .modal_cm #push-registration .pr-steps-container .pr-step .pr-next-step:hover, 
#modal_login .modal_cm #push-registration .pr-steps-container .pr-step .pr-redbtn:hover, 
.page-deployed .clidxboost-btn-link:hover span {
	background-color: '.$idx_style_second_color.'; border-color: '.$idx_style_second_color.'}';*/

}

    if (strlen(($idx_style_boton_point)) > 0) {
        $style_boton_point = '
        .cir-sta.rent{ background-color: '.$idx_style_boton_point.'; }
        #wrap-result.view-grid #result-search .propertie .wrap-slider .prev, #wrap-result.view-grid #result-search .propertie .wrap-slider .next  { background-color: '.$idx_style_boton_point.' !important; }
        defs radialGradient:nth-child(2) stop{ stop-color:'.$idx_style_boton_point.' !important; } #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-checks ul li input:checked+label:after, #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-range .range-slide .ui-slider-range, #wrap-filters #all-filters #mini-filters>li.cities #cities-list li.active, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item .list-type-sr li button.active, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item .list-type-sr li button:hover, .property-details.theme-3 .property-information.ltd li.rent:hover, .property-details.theme-3 .property-information.ltd li.sale:hover, .property-details.theme-3 .property-information.ltd li.sold:hover, .property-details.theme-3 .property-information.ltd li.sale:hover, .property-details.theme-3 .property-information.ltd li.active-fbc.rent, .property-details.theme-3 .property-information.ltd li.active-fbc.sale, .property-details.theme-3 .property-information.ltd li.active-fbc.sold, .tabs-btn li.active, .tabs-btn li:hover, #result-search .propertie .wrap-slider .next span, #result-search .propertie .wrap-slider .prev span, .wrap-result.view-grid #result-search .propertie .wrap-slider .next span, .wrap-result.view-grid #result-search .propertie .wrap-slider .prev, #wrap-filters #filters>li.mini-search form #submit-ms input[type=submit], #slider-properties .nav .bullets button.active span:before, #slider-testimonial .nav .bullets button.active span:before, #wrap-result .nav-results .ad:hover, .wrap-result #nav-results .ad:hover, .wrap-result .nav-results .ad:hover, #wrap-filters #filters li button>span.clidxboost-icon-arrow-select:before, #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-select:before, .main-content .list-details.active .title-amenities:before, .main-content .list-details.active .title-details:before, .main-content .list-details .title-amenities:before, .main-content .list-details .title-details:before { color: ' . $idx_style_boton_point . '; } #wrap-filters #filters li.active:after{border-bottom-color: ' . $idx_style_boton_point . ' !important; } #wrap-filters #all-filters #mini-filters{ border-top-color: ' . $idx_style_boton_point . '!important; }';
    }

    if (strlen(($idx_style_body_point_rgba_transparent)) > 0) {
        $style_body_point_rgba_transparent = ' #flex-bubble-search{ background-color: ' . $idx_style_body_point_rgba_transparent . ';}';
    }

    if (strlen(($idx_style_search_bar_texto)) > 0) {
        $style_search_bar_texto = '#flex-bubble-search input{ color: ' . $idx_style_search_bar_texto . '; } ';
    }

    echo '<style type="text/css"> ' .
        'h1.idx_site_text_tit {
    opacity: 1 !important;
    visibility: initial !important;
    font-size: ' . $color_idx_site_text_size . ' !important;
    color: ' . $color_idx_site_text_color . ';
}
.customize-partial-edit-shortcut, .widget .customize-partial-edit-shortcut{ z-index: 14 !important; }
.customize-partial-edit-shortcut button, .widget .customize-partial-edit-shortcut button{ left: 30px !important; }
.idx_image_logo.logo-content span{
 position: relative;
 width: 100%;
}
.idx_languages_spanish span.customize-partial-edit-shortcut {
    top: 0px;
}
.idx_image_logo.logo-content span button{
    right: -37px;
    left: auto !important;
}

/** icono editar background**/
.idx_color_search_bar_background span{
 bottom: 37px;
 left: -22px;
}
#menu-main .customize-partial-edit-shortcut button{
 margin-top: -10px;
}
/* icono editar texto */
.idx_text_search_bar span {
    left: 350px;
    top: 1px;
    margin-top: 15px;
}
.wrap-slider.idx_color_primary .customize-partial-edit-shortcut,
.wrap-slider.idx_color_second .customize-partial-edit-shortcut{
 z-index: 41;
 left: -10px;
 top: 61px;
}

.wrap-slider.idx_color_primary .flex-slider-prev,
.wrap-slider.idx_color_second .flex-slider-prev{
 opacity: 1;
 background-color: #333 !important;
}

.clidxboost-btn-link .customize-partial-edit-shortcut{
 display: block;
 width: auto;
 height: auto;
 border: none;
 margin-top: 24px;
 right: 324px;
}

.clidxboost-btn-link{
 position: relative;
}
#slider-main>ul>li .customize-partial-edit-shortcut{
 top: 20px;
 left: 0;
}
li#customize-control-idx_txt_description_front textarea {
    min-height: 250px;
}
' .
        $idx_style_second_color_point .
        $style_texto_point .
        $style_boton_point .
        $style_body_point_rgba_transparent .
        $style_search_bar_texto .
        $idx_style_texto_theme_point .
        $idx_style_body_text_theme_point .
        $idx_style_search_bar_bose_theme_transparent_point .
        $style_title_galery .
        $image_footer_firt .
        $image_footer_second .
        $image_footer_third .
        $idx_style_plugin_sec_pri .
        ' </style>';
}

add_action('wp_footer', 'idx_footer_customizaer');

function get_custom_logo_footer($nameFooter = 0)
{
    $html = '';

    if (empty(get_theme_mod($nameFooter))) {
        $idx_theme_broker = '';
    } else {
        $idx_theme_broker = get_theme_mod($nameFooter);
    }

    if ($idx_theme_broker) {
        $html = sprintf('<a class="' . $nameFooter . '" rel="home" itemprop="url">%1$s</a>', '<img src="' . $idx_theme_broker . '">');
    } elseif (is_customize_preview()) {
        $html = sprintf('<a href="%1$s" class="' . $nameFooter . '" style="display:none;"><img /></a>',
            esc_url(home_url('/'))
        );
    }
    return apply_filters('get_custom_logo_footer', $html);
}

function get_custom_logo_footer_realtor($nameFooter = 0)
{
    $html = '';

    if (empty(get_theme_mod($nameFooter))) {
        $idx_theme_broker = '';
    } else {
        $idx_theme_broker = get_theme_mod($nameFooter);
    }

    if ($idx_theme_broker) {
        $html = sprintf('<a class="' . $nameFooter . '" rel="home" itemprop="url">%1$s</a>', '<img src="' . $idx_theme_broker . '">');
    } else {
        $html = sprintf('<a class="' . $nameFooter . '" rel="home" itemprop="url">%1$s</a>', '<img src="' . get_template_directory_uri().'/images/realtore.png' . '">');
    }
    return apply_filters('get_custom_logo_footer', $html);
}


function idx_the_custom_logo($NumberBroker = 0)
{
    echo get_custom_logo_footer($NumberBroker);
}


function idx_the_custom_logo_realtor($NumberBroker = 0)
{
    echo get_custom_logo_footer_realtor($NumberBroker);
}


function get_custom_logo_header()
{
    $html = '';

    if (get_option('idx_site_radio_sta') == 'text') {
        if (empty(get_theme_mod('idx_site_text'))) {
            $idx_site_text = '';
        } else {
            $idx_site_text = get_theme_mod('idx_site_text');
        }

        if (empty(get_theme_mod('idx_site_text_slogan'))) $idx_site_text_slogan = ''; else  $idx_site_text_slogan = get_theme_mod('idx_site_text_slogan');


        if ($idx_site_text) {
            $html = sprintf('<a href="%1$s" class="' . 'idx_site_text logo-broker' . '" rel="home" itemprop="url">%2$s</a>', esc_url(home_url('/')), '<div class="text-logo"><h1 class="idx_site_text_tit" title="' . get_bloginfo('name') . '" > ' . $idx_site_text . '</h1><span>'.$idx_site_text_slogan.'</span></div>');
        } elseif (is_customize_preview()) {
            $html = sprintf('<a href="%1$s" class="idx_image_logo logo-content" style="display:none;"></a>',
                esc_url(home_url('/'))
            );
        }

    } else {

        if (empty(get_theme_mod('idx_image_logo'))) {
            $idx_theme_broker = '';
        } else {
            $idx_theme_broker = get_theme_mod('idx_image_logo');
        }

        if ($idx_theme_broker) {
            $html = sprintf('<a href="%1$s" class="' . 'idx_image_logo' . ' logo-content" rel="home" itemprop="url">%2$s</a>', esc_url(home_url('/')), '<img alt="' . get_bloginfo('name') . '" src="' . $idx_theme_broker . '" >');
        } elseif (is_customize_preview()) {
            $html = sprintf('<a href="%1$s" class="' . 'idx_image_logo' . ' logo-content" style="display:none;"><img /></a>',
                esc_url(home_url('/'))
            );
        }

    }

    return apply_filters('get_custom_logo_header', $html);
}

function idx_the_custom_logo_header()
{
    echo get_custom_logo_header();
}

function themename_idx_footer_customize($wp_customize){
/*HOME CUSTOMIZER*/
    $wp_customize->add_section('idx_customizer_scheme_theme', array('title'=> __('Homepage ', 'idx_slider_themes'),'priority' => 21,));

    $wp_customize->add_setting('idx_txt_title_front', array('capability' => 'edit_theme_options','default' => 'THE DIFFERENCE IS IN SERVICE','sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_txt_title_front', array('type'=> 'text','section'  => 'idx_customizer_scheme_theme','label'=> __('Welcome Title'),'settings' => 'idx_txt_title_front',));
    $wp_customize->selective_refresh->add_partial('idx_txt_title_front', array('selector'=> '.idx_txt_title_front','render_callback'     => array($wp_customize, '_idx_txt_title_front'),'container_inclusive' => true,));
/*
    $wp_customize->add_setting('idx_txt_description_front', ['type' => 'option']);
    $wp_customize->add_control(new WP_Customize_Teeny_Control($wp_customize, 'idx_txt_description_front', ['label'   => 'Welcome Description','section' => 'idx_customizer_scheme_theme',]));
    $wp_customize->selective_refresh->add_partial('idx_txt_description_front', array('selector'=> '.idx_txt_description_front','render_callback' => array($wp_customize, '_idx_txt_description_front'),'container_inclusive' => true,));
*/
    $wp_customize->add_setting('idx_txt_description_front', array('capability' => 'edit_theme_options','sanitize_callback' => 'sanitize_text_field',));
    $wp_customize->add_control('idx_txt_description_front', array('type'=> 'textarea','section'  => 'idx_customizer_scheme_theme','label'=> __('Welcome Description'),'settings' => 'idx_txt_description_front',));
    $wp_customize->selective_refresh->add_partial('idx_txt_description_front', array('selector'=> '.idx_txt_description_front','render_callback'     => array($wp_customize, '_idx_txt_description_front'),'container_inclusive' => true,));


    $wp_customize->add_setting('idx_txt_text_welcome_front', array('capability' => 'edit_theme_options', 'default' => 'ABOUT US', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_txt_text_welcome_front', array('type' => 'text', 'section' => 'idx_customizer_scheme_theme', 'label' => __('Welcome Button Text'), 'settings' => 'idx_txt_text_welcome_front'));
    $wp_customize->selective_refresh->add_partial('idx_txt_text_welcome_front', array('selector' => '.idx_txt_text_welcome_front', 'render_callback' => array($wp_customize, '_idx_txt_text_welcome_front'), 'container_inclusive' => true));
    $wp_customize->add_setting('idx_txt_link_welcome_front');
    $wp_customize->add_control('idx_txt_link_welcome_front', array('label' => __('Welcome Button Link'), 'section' => 'idx_customizer_scheme_theme', 'type' => 'url', 'input_attrs' => array('placeholder' => __('Link'))));
    $wp_customize->add_setting('idx_txt_text_tit_property_front', array('capability' => 'edit_theme_options', 'default' => 'FEATURED PROPERTIES', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_txt_text_tit_property_front', array('type' => 'text', 'section' => 'idx_customizer_scheme_theme', 'label' => __('Carrousel Title Text'), 'settings' => 'idx_txt_text_tit_property_front'));
    $wp_customize->selective_refresh->add_partial('idx_txt_text_tit_property_front', array('selector' => '.idx_txt_text_tit_property_front', 'render_callback' => array($wp_customize, '_idx_txt_text_tit_property_front'), 'container_inclusive' => true));
    $wp_customize->add_setting('idx_txt_text_property_front', array('capability' => 'edit_theme_options', 'default' => 'VIEW MORE PROPERTIES', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_txt_text_property_front', array('type' => 'text', 'section' => 'idx_customizer_scheme_theme', 'label' => __('Carrousel Button Text'), 'settings' => 'idx_txt_text_property_front'));
    $wp_customize->selective_refresh->add_partial('idx_txt_text_property_front', array('selector' => '.idx_txt_text_property_front', 'render_callback' => array($wp_customize, '_idx_txt_text_property_front'), 'container_inclusive' => true));
/*HOME CUSTOMIZER*/
/*ABOUT CUSTOMIZER*/
    $wp_customize->add_section('idx_customizer_scheme_theme_about', array('title'    => __('About ', 'idx_slider_themes'),'priority' => 107,));
    $wp_customize->add_setting('idx_txt_text_welcome_about_first', array('capability' => 'edit_theme_options', 'default' => '--', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_txt_text_welcome_about_first', array('type' => 'text', 'section' => 'idx_customizer_scheme_theme_about', 'label' => __('First Button Text'), 'settings' => 'idx_txt_text_welcome_about_first'));
    $wp_customize->selective_refresh->add_partial('idx_txt_text_welcome_about_first', array('selector' => '.idx_txt_text_welcome_about_first', 'render_callback' => array($wp_customize, '_idx_txt_text_welcome_about_first'), 'container_inclusive' => true));
    $wp_customize->add_setting('idx_txt_link_welcome_about_firts');
    $wp_customize->add_control('idx_txt_link_welcome_about_firts', array('label' => __('First Button Link'), 'section' => 'idx_customizer_scheme_theme_about', 'type' => 'url', 'input_attrs' => array('placeholder' => __('Link'))));
    $wp_customize->add_setting('idx_txt_text_welcome_about_second', array('capability' => 'edit_theme_options', 'default' => '--', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_txt_text_welcome_about_second', array('type' => 'text', 'section' => 'idx_customizer_scheme_theme_about', 'label' => __('First Button Text'), 'settings' => 'idx_txt_text_welcome_about_second'));
    $wp_customize->selective_refresh->add_partial('idx_txt_text_welcome_about_second', array('selector' => '.idx_txt_text_welcome_about_second', 'render_callback' => array($wp_customize, '_idx_txt_text_welcome_about_second'), 'container_inclusive' => true));
    $wp_customize->add_setting('idx_txt_link_welcome_about_second');
    $wp_customize->add_control('idx_txt_link_welcome_about_second', array('label' => __('Second Button Link'), 'section' => 'idx_customizer_scheme_theme_about', 'type' => 'url', 'input_attrs' => array('placeholder' => __('Link'))));
/*ABOUT CUSTOMIZER*/
/*FOOTER CUSTOMIZER*/
    $wp_customize->add_section('idx_theme_footer_customizer_scheme', array('title'=> __('Footer', 'idx_theme_customizer'),'priority' => 106,));
    $wp_customize->add_setting('idx_image_logo_footer');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'idx_image_logo_footer', array('label'=> __('Agent Logo', 'idx_theme_customizer_header'),'section'  => 'idx_theme_footer_customizer_scheme','settings' => 'idx_image_logo_footer',)));
    $wp_customize->selective_refresh->add_partial('idx_image_logo_footer', array('selector' => '.idx_image_logo_footer','render_callback' => array($wp_customize, '_idx_image_logo_footer'),'container_inclusive' => true,));

    $wp_customize->add_setting('idx_image_broker_1_footer_theme');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'idx_image_broker_1_footer_theme', array('label'=> __('Broker Logo', 'idx_theme_customizer_header'),'section' => 'idx_theme_footer_customizer_scheme','settings' => 'idx_image_broker_1_footer_theme',)));
    $wp_customize->selective_refresh->add_partial('idx_image_broker_1_footer_theme', array('selector' => '.idx_image_broker_1_footer_theme','render_callback' => array($wp_customize, '_idx_image_broker_1_footer_theme'),'container_inclusive' => true,));

    $wp_customize->add_setting('idx_image_broker_2_footer_theme');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'idx_image_broker_2_footer_theme', array('label'=> __('Affiliations Logo', 'idx_theme_customizer_header'),'section'  => 'idx_theme_footer_customizer_scheme','settings' => 'idx_image_broker_2_footer_theme',)));

    $wp_customize->selective_refresh->add_partial('idx_image_broker_2_footer_theme', array('selector' => '.idx_image_broker_2_footer_theme','render_callback' => array($wp_customize, 'idx_image_broker_2_footer_theme'),'container_inclusive' => true,));

    $wp_customize->add_setting('idx_footer_link[term_service]', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_footer_link[term_service]', array('type' => 'text', 'section' => 'idx_theme_footer_customizer_scheme', 'label' => __('Link Term of Service'), 'settings' => 'idx_footer_link[term_service]'));
    $wp_customize->selective_refresh->add_partial('idx_footer_link[term_service]', array('selector' => '.idx_footer_link_term_service', 'render_callback' => array($wp_customize, '_idx_footer_link_term_service'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_footer_link[privacy_polity]', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_footer_link[privacy_polity]', array('type' => 'text', 'section' => 'idx_theme_footer_customizer_scheme', 'label' => __('Link Privacity Policy'), 'settings' => 'idx_footer_link[privacy_polity]'));
    $wp_customize->selective_refresh->add_partial('idx_footer_link[privacy_polity]', array('selector' => '.idx_footer_link_privacy_polity', 'render_callback' => array($wp_customize, '_idx_footer_link_privacy_polity'), 'container_inclusive' => true));

    $wp_customize->add_setting('idx_footer_link[sitemap]', array('capability' => 'edit_theme_options', 'default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('idx_footer_link[sitemap]', array('type' => 'text', 'section' => 'idx_theme_footer_customizer_scheme', 'label' => __('Link Sitemap'), 'settings' => 'idx_footer_link[sitemap]'));
    $wp_customize->selective_refresh->add_partial('idx_footer_link[sitemap]', array('selector' => '.idx_footer_link_sitemap', 'render_callback' => array($wp_customize, '_idx_footer_link_sitemap'), 'container_inclusive' => true));
/*FOOTER CUSTOMIZER*/

/*HEADER CUSTOMIZER*/
    $wp_customize->add_section('idx_theme_header_customizer_scheme', array('title'=> __('Header', 'idx_theme_customizer_header_main'),'priority' => 50,));   

    $wp_customize->add_setting('separator_header_home');
    $wp_customize->add_control(new wp_Customize_idxboost_button_separator($wp_customize, 'separator_header_home', array('label' => __('Header home page'),'section' => 'idx_theme_header_customizer_scheme','priority' => 1, )));
    $wp_customize->add_setting('idxboost_themes_custom[idx_difuminacion_home]', array('default'=>'transparent','capability'=>'edit_theme_options', 'type'=> 'option', ));
    $wp_customize->add_control('idxboost_themes_custom[idx_difuminacion_home]', array('settings' => 'idxboost_themes_custom[idx_difuminacion_home]','label'=> 'Search Opacity','section'=>'idx_theme_header_customizer_scheme','priority'=> 2,'type'=> 'select','choices'  => array('transparent' => 'transparent','fill' => 'fill', ), ));
    $wp_customize->add_setting('idxboost_themes_custom[color_home]');
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idxboost_themes_custom[color_home]', array('label'    => __('Container Background color', 'idx_theme_customizer_header_main'),
        'priority'  => 3,'section'  => 'idx_theme_header_customizer_scheme','settings' => 'idxboost_themes_custom[color_home]',)));
    //SEPARATOR
    $wp_customize->add_setting('separator_header_inner_page');
    $wp_customize->add_control(new wp_Customize_idxboost_button_separator($wp_customize, 'separator_header_inner_page', array( 'label'=> __('Header inner pages'), 'section'=> 'idx_theme_header_customizer_scheme', 'priority' => 4, )));       
    $wp_customize->add_setting('idxboost_themes_custom[idx_difuminacion_inner_pages]', array('default'=> 'transparent','capability' => 'edit_theme_options','type'=> 'option',));
    $wp_customize->add_control('idxboost_themes_custom[idx_difuminacion_inner_pages]', array('settings' => 'idxboost_themes_custom[idx_difuminacion_inner_pages]','label'=> 'Search Opacity','section' =>'idx_theme_header_customizer_scheme','type'=> 'select','priority'=> 5,'choices'=> array('transparent' =>'transparent','fill'=> 'fill',), ));   

    $wp_customize->add_setting('idxboost_themes_custom[color_inner_pages]');
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'idxboost_themes_custom[color_inner_pages]', array('label'=> __('Container Background color', 'idx_theme_customizer_header_main'),'section'  => 'idx_theme_header_customizer_scheme','priority'  => 6,'settings' => 'idxboost_themes_custom[color_inner_pages]',)));
/*HEADER CUSTOMIZER*/
}

add_action('customize_register', 'themename_idx_footer_customize');


// add_action('save_post', 'func_contact_detail_save', 10, 2);

if (!function_exists('flex_theme_load_initial_css')) {
    function flex_theme_load_initial_css()
    {
        wp_register_style('flex_initial_css_main', get_template_directory_uri() . '/css/main-project.css');

        wp_enqueue_style('flex_initial_css_main');
    }

    add_action('wp_enqueue_scripts', 'flex_theme_load_initial_css');
}
