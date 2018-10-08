<?php
  global $flex_idx_info, $flex_idx_lead;
  $custom_fields = get_post_custom(get_the_id());
  $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
  $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <title><?php wp_title('|', 1, 'right');?> <?php bloginfo('name');?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="keywords" content="<?php echo isset($dws_meta_key_da) ? $dws_meta_key_da : ''; ?>" />
    <meta name="description" content="<?php bloginfo('description');?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#4b4b4b">
    <meta name="theme-color" content="#4b4b4b">
    <meta name="msapplication-navbutton-color" content="#4b4b4b">
    <!-- FONT THEME -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,600" rel="stylesheet">
    <!-- FONT THEME -->
    <style type="text/css">.mobile_menu_div_100 { width: 100%; } </style>
    <?php wp_head();?>
  </head>
  <body class="lg-theme ib-wrap-full-width">
    <!--<header id="header" class="lg-header-active fixed-box <?php if (is_front_page())  echo "header-home";?>">-->
    <header id="header" class="lg-header-active fixed-box <?php if (is_front_page()){ echo "ib-home-header"; }else{ echo "ib-internal-header";}  ?>">
      <div class="lg-ct-header">
        <div class="lg-wrap-content">
          <div class="wrap-options">
            <div class="gwr">
              <a class="item-header" href="tel:<?php echo preg_replace('/[^\d+]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>" id="call-us"><?php echo __('CALL US', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?></a>
              <?php if ( !empty( get_theme_mod('idx_social_media' )['facebook'] ) || !empty(get_theme_mod('idx_social_media' )['twitter']  ) || !empty( get_theme_mod('idx_social_media' )['google'] ) || !empty( get_theme_mod('idx_social_media' )['instagram'] ) || !empty( get_theme_mod('idx_social_media' )['linkedin'] ) || !empty( get_theme_mod('idx_social_media' )['youtube'] ) || !empty( get_theme_mod('idx_social_media' )['pinterest'] ) ): ?>
              <ul class="idx_social_media_facebook item-header social-networks notranslate">
                <?php if (!empty( get_theme_mod('idx_social_media' )['facebook'] )): ?>
                <li class="clidxboost-icon-facebook"><a href="<?php echo esc_url(get_theme_mod('idx_social_media' )['facebook']); ?>" title="Facebook" target="_blank" rel="nofollow">Facebook</a></li>
                <?php endif; ?>
                <?php if (!empty(get_theme_mod('idx_social_media' )['twitter']  )): ?>
                <li class="clidxboost-icon-twitter"><a href="<?php echo esc_url(get_theme_mod('idx_social_media' )['twitter']); ?>" title="Twitter" target="_blank" rel="nofollow">Twitter</a></li>
                <?php endif; ?>
                <?php if (!empty( get_theme_mod('idx_social_media' )['google'] )): ?>
                <li class="clidxboost-icon-google-plus"><a href="<?php echo esc_url(get_theme_mod('idx_social_media' )['google']); ?>" title="Google+" target="_blank" rel="nofollow">Google+</a></li>
                <?php endif; ?>
                <?php if (!empty( get_theme_mod('idx_social_media' )['instagram'] )): ?>
                <li class="clidxboost-icon-instagram"><a href="<?php echo esc_url(get_theme_mod('idx_social_media' )['instagram']); ?>" title="Instagram" target="_blank" rel="nofollow">Instagram</a></li>
                <?php endif; ?>
                <?php if (!empty( get_theme_mod('idx_social_media' )['linkedin'] )): ?>
                <li class="clidxboost-icon-linkedin"><a href="<?php echo esc_url(get_theme_mod('idx_social_media' )['linkedin']); ?>" title="Linked In" target="_blank" rel="nofollow">Linked In</a></li>
                <?php endif; ?>
                <?php if (!empty( get_theme_mod('idx_social_media' )['youtube'] )): ?>
                <li class="clidxboost-icon-youtube"><a href="<?php echo esc_url(get_theme_mod('idx_social_media' )['youtube']); ?>" title="Youtube" target="_blank" rel="nofollow">YouTube</a></li>
                <?php endif; ?>
                <?php if (!empty( get_theme_mod('idx_social_media' )['pinterest'] )): ?>
                <li class="clidxboost-icon-pinterest"><a href="<?php echo get_theme_mod('idx_social_media' )['pinterest']; ?>" title="pinterest" target="_blank" rel="nofollow">Pinterest</a></li>
                <?php endif; ?>              
              </ul>
              <?php endif; ?>
              <?php if (!empty(get_theme_mod( 'idx_languages_list' ))) { ?>
              <div class="available-languages-content notranslate">
                <a href="javascript:void(0)" id="available-languages" rel="nofollow">
                <span class="languages-text notranslate">EN</span>
                <span class="flag-english" id="languages-map"></span>
                </a>
                <div class="languages-list">
                  <?php  } ?>
                  <?php if (empty( get_theme_mod( 'idx_languages_list' ) ))  $idx_languages_list  = []; else  $idx_languages_list  = get_theme_mod( 'idx_languages_list' );
                    foreach ($idx_languages_list as $key => $value) {
                    if ($key === 'English' && $value== 1 ) { ?>
                  <a href="javascript:void(0)" data-iso="us" class="active english flag-english item-languages notranslate" id="tr-en" rel="nofollow"><span>EN</span></a>
                  <?php }elseif ( $key === 'Russian' && $value== 1  ) { ?>
                  <a href="javascript:void(0)" data-iso="ru" class="flag-russian item-languages notranslate" id="tr-ru" rel="nofollow"><span>RU</span></a>
                  <?php  }elseif ( $key === 'Spanish' && $value== 1  ) { ?>
                  <a href="javascript:void(0)" data-iso="es" class="flag-spanish item-languages notranslate" id="tr-es" rel="nofollow"><span>ES</span></a>
                  <?php  }elseif ( $key === 'Portuguese' && $value== 1  ) { ?>
                  <a href="javascript:void(0)" data-iso="pt" class="flag-portuguese item-languages notranslate" id="tr-pt" rel="nofollow"><span>BR</span></a>
                  <?php  }elseif ( $key === 'French' && $value== 1  ) { ?>
                  <a href="javascript:void(0)" data-iso="fr" class="flag-french item-languages notranslate" id="tr-fr" rel="nofollow"><span>FR</span></a>
                  <?php  }elseif ( $key === 'Italian' && $value== 1  ) { ?>
                  <a href="javascript:void(0)" data-iso="it" class="flag-italy item-languages notranslate" id="tr-it" rel="nofollow"><span>IT</span></a>
                  <?php  }elseif ( $key === 'German' && $value== 1  ) { ?>
                  <a href="javascript:void(0)" data-iso="de" class="flag-german item-languages notranslate" id="tr-de" rel="nofollow"><span>DE</span></a>
                  <?php  }elseif ( $key === 'Chinese' && $value== 1  ) { ?>
                  <a href="javascript:void(0)" data-iso="zh-TW" class="flag-chinese item-languages notranslate" id="zh-TW" rel="nofollow"><span>ZH</span></a>
                  <?php  } } ?>            
                  <?php if (!empty(get_theme_mod( 'idx_languages_list' ))) { ?> 
                </div>
              </div>
              <?php } ?> 
              <?php if (false === $flex_idx_lead): ?>
              <ul class="item-no-hea item-header" id="user-options">
                <li class="login" data-modal="modal_login" data-tab="tabLogin">
                  <a href="#" class="lg-login" rel="nofollow"><?php echo __('Sign In', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                </li>
                <li class="register" data-modal="modal_login" data-tab="tabRegister">
                  <a href="#" class="lg-register" rel="nofollow"><?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                </li>
              </ul>
              <?php else: $my_flex_pages = flex_user_list_pages(); ?>
              <ul class="item-lo-hea item-header" id="user-options">
                <?php 
                  $lead_name_exp = explode(' ', esc_attr($flex_idx_lead['lead_info']['first_name']));
                  ?>
                <li class="login show_modal_login_active">
                  <a href="javascript:void(0)" rel="nofollow"><?php echo __('Welcome', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $lead_name_exp[0]; ?></a>
                  <div class="menu_login_active disable_login">
                    <?php if (!empty($my_flex_pages)): ?>
                    <ul>
                      <?php foreach ($my_flex_pages as $my_flex_page): ?>
                      <li><a href="<?php echo $my_flex_page['permalink']; ?>"><?php echo $my_flex_page['post_title']; ?></a></li>
                      <?php endforeach; ?>
                      <li><a href="#" class="flex-logout-link" id="flex-logout-link"><?php echo __('Logout', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                    </ul>
                    <?php endif; ?>
                  </div>
                </li>
              </ul>
              <?php endif; ?>
            </div>
          </div>
          <div class="wrap-menu">
            <div class="gwr">
              <?php idx_the_custom_logo_header_boots(); ?>
              <?php wp_nav_menu(array('theme_location' => 'primary','menu' => 'Primary Menu', 'menu_class' => '', 'menu_id' => '', 'container' => 'nav', 'container_class' => '', 'container_id' => 'menu-main')); ?>

              <!-- CONTACT BUTTON FORMAT 1 -->
              <div class="lg-btncta-text">
                <a href="javascript:void(0)" class="lg-btn-cta show-modal" data-modal="modal_contact_us" rel="nofollow">
                  <span class="lg-cta-wrapper">Connect with us</span>
                </a>
              </div>
              <!-- CONTACT BUTTON FORMAT 1 -->

              <div class="hamburger-content">
                <button id="hamburger">
                <span>Menu responsive</span>
                </button>
                <button id="show-filters">
                  <span>Filters</span>
                </button>
              </div>
              <div class="menu-responsive">
                <nav>
                  <div class="hamburger-content">
                    <button id="hamburger-r">
                    <span>Menu responsive</span>
                    </button>
                  </div>
                  <?php if (false === $flex_idx_lead): ?>
                  <ul class="lg-wrap-login">
                    <li>
                      <a href="javascript:void(0)" rel="nofollow" id="lg-login"><?php echo __('Sign In', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                    </li>
                    <li>
                      <a href="javascript:void(0)" rel="nofollow" id="lg-register"><?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                    </li>
                  </ul>
                  <?php else: $my_flex_pages = flex_user_list_pages(); ?>
                  <ul class="lg-wrap-login active">
                    <?php  $lead_name_exp = explode(' ', esc_attr($flex_idx_lead['lead_info']['first_name'])); ?>
                    <li>
                      <span><?php echo __('Welcome', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $lead_name_exp[0]; ?></span>
                      <?php if (!empty($my_flex_pages)): ?>
                      <ul class="sub-menu">
                        <?php foreach ($my_flex_pages as $my_flex_page): ?>
                        <li><a href="<?php echo $my_flex_page['permalink']; ?>"><?php echo $my_flex_page['post_title']; ?></a></li>
                        <?php endforeach; ?>
                        <li><a href="#" class="flex-logout-link" id="flex-logout-link"><?php echo __('Logout', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                      </ul>
                      <?php endif; ?>
                    </li>
                  </ul>
                  <?php endif; ?>
                  <?php wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu' => 'Primary Menu',
                    'menu_class' => 'menu-more-options',
                    'menu_id' => 'menu-main-resposnive',
                    'container_class' => 'mobile_menu_div_100'
                    ));?>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- CONTACT BUTTON FORMAT 2 -->
        <!-- CONTACT BUTTON FORMAT 2 -->
      </div>
      <div class="r-overlay"></div>
    </header>