<?php
global $flex_idx_info;
global $dgtForms;
?>

    <?php 
      if(get_the_ID() != '5'){
        $class = "";
        ?>

        <div class="overlay_modal ppc-contact" id="modal_contact_us">
          <div class="modal_cm">
            <button data-id="modal_contact_us" class="close close-modal" data-frame="modal_mobile">Close <span></span></button>
            <div class="content_md">
              <div class="heder_md">
                <h2>Connect with Us</h2>
              </div>
              <div class="body_md">
                <?php echo do_shortcode('[flex_idx_contact_form id_form="contact_modal_usp"]'); ?>
                <input type="hidden" name="idx_contact_email_temp" class="idx_contact_email_temp" value="<?php echo $idx_contact_email; ?>">
              </div>
            </div>
          </div>
          <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_contact_us"></div>
        </div>

    <?php }else{

        $class = "class='idx-hidden'";

      }
    ?>


    <footer id="footer" <?php echo $class; ?>>
      <div class="flex-footer-content">
        <div class="gwr">
           <div class="flex-idx-box-a">
              <?php if (empty( get_option( 'idx_plugin_custom' )['idx_image_logo_footer_theme'] ))  $idx_image_logo_footer_theme  = ''; else  $idx_image_logo_footer_theme  = get_option( 'idx_plugin_custom' )['idx_image_logo_footer_theme']; ?>            
              <div class="logo-footer">
                <a href="<?php echo site_url(); ?>"><?php  idx_the_custom_logo('idx_image_logo_footer'); ?></a>
              </div>
              <ul class="flex-site-description">
                  <li class="name-site"><?php echo $flex_idx_info['website_name']; ?> | <a target="_blank" href="http://cpanel.idxboost.com" rel="nofollow">Agent Login</a></li>
                  <li class="number-site">Office: <?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?>  | <?php echo $flex_idx_info['agent']['agent_contact_email_address']; ?></li>
              </ul>
           </div>
           <div class="flex-idx-box-b">
              <ul class="flex-company-site">
                 <li class="copyright-site">All rights reserved <?php echo date('Y'); ?> © Copyright <?php echo bloginfo(); ?></li>
              </ul>
              <div class="company-parnet">
                <?php  idx_the_custom_logo_realtor('idx_image_broker_1_footer_theme'); ?>                    
                <?php  idx_the_custom_logo_realtor('idx_image_broker_2_footer_theme'); ?>                    
              </div>
           </div>
        </div>
      </div>
    </footer>

    <div class="cta-container">
      <ul class="cta-wrapper">
        <li class="cta-item"><a class="cta-ilink cta-icon-celular" href="tel:<?php echo preg_replace('/[^\d+]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>">Call Us</a></li>
        <li class="cta-item"><a class="cta-ilink cta-icon-correo" href="mailto:<?php echo $idx_contact_email; ?>">Email US</a></li>
        <li class="cta-item"><a class="cta-ilink cta-icon-chat" href="#">Chat</a></li>
      </ul>
    </div>
    
    <div id="google_translate_element"></div>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dgt/dgt-project-master.js"></script> 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateInit"></script>
    <script type="text/javascript">
    function googleTranslateInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,ru,es,pt,fr,it,de,zh-TW',
        multilanguagePage: true,
        autoDisplay: true,
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }
    </script>
    <?php wp_footer(); ?>
    <script type="text/javascript">
      var $element = jQuery(".header-home");
      var $offset = $element.offset();
      if(typeof($offset) != 'undefined'){
        var $positionYelement = $offset.top + 100;
        jQuery(window).scroll(function(){
          var $scrollSize = jQuery(window).scrollTop();
          if ($scrollSize >  $positionYelement) {
            $element.addClass('active-header-fixed');
          } else {
            $element.removeClass('active-header-fixed');
          }
        })
      }

      jQuery('.cta-ilink.cta-icon-chat').on('click', function(e) {
        e.preventDefault();
        jQuery('#drift-widget-container').toggleClass('active');
      });
    </script>


    <!-- CHAT -->
    <!-- Start of Async Drift Code -->
    <script>
    "use strict";

    !function() {
      var t = window.driftt = window.drift = window.driftt || [];
      if (!t.init) {
        if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
        t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
        t.factory = function(e) {
          return function() {
            var n = Array.prototype.slice.call(arguments);
            return n.unshift(e), t.push(n), t;
          };
        }, t.methods.forEach(function(e) {
          t[e] = t.factory(e);
        }), t.load = function(t) {
          var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
          o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
          var i = document.getElementsByTagName("script")[0];
          i.parentNode.insertBefore(o, i);
        };
      }
    }();
    drift.SNIPPET_VERSION = '0.3.1';
    drift.load('grfguv3ppcpy');
    </script>
    <!-- End of Async Drift Code -->
  </body>
</html>