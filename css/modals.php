<?php
global $flex_idx_info, $flex_idx_lead;
?>
<script type="text/javascript">
  var SIGNUP_EXTENDS_QUIZZ = '<?php echo (isset($flex_idx_info["agent"]["user_show_quizz"]) && ("1" == $flex_idx_info["agent"]["user_show_quizz"])) ? '1' : '0'; ?>';
</script>

<!--MODAL GALLERY-->
<div id="content-modals">

  <!-- FULL SLIDER -->
  <div class="overlay_modal" id="modal_img_propertie">
    <div class="content-modal-full-slider">
      <div class="modal-full-slider">
        <h4 class="title worked"></h4>
        <div class="wrapper-img">
          <ul class="actions-buttons">
            <li class="close-modal"><button><span class="icon-close"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
          </ul>
          <span class="numeration"><span>2</span> <?php echo __('of', IDXBOOST_DOMAIN_THEME_LANG); ?> <span>14</span></span>
          <img src="" class="img">
          <button class="prev nav"><span class="icon-arrow-select"></span></button>
          <button class="next nav"><span class="icon-arrow-select"> </span></button>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_img_propertie"></div>
  </div> 

  <!-- REGISTER LOGIN registration_forced-->
  <div class="overlay_modal" id="modal_login">
    <div class="modal_cm">

      <button data-id="modal_login" class="close close-modal" data-frame="modal_mobile"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?><span> </span></button>
      <div class="content_md">
        <div class="heder_md">
          <h2 class="ms-title-modal">
            <?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>
          </h2>
        </div>

        <div class="body_md">
          <ul class="header-tab">
            <li>
              <a href="javascript:void(0)" data-tab="tabLogin" class="ib-tabLogin active" data-text="<?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>" data-text-force="<?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                <?php echo __('Log in', IDXBOOST_DOMAIN_THEME_LANG); ?>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" data-tab="tabRegister" data-text="<span class='ms-samll'><?php echo __('Want details of this property?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>" data-text-force="<span class='ms-samll'><?php echo __('Want details of this property?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>">
                <?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" data-tab="tabReset" data-text="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>" data-text-force="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                <?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>
              </a>
            </li>
          </ul>

          <div id="tabLogin" class="item_tab active">
            <div class="ms-text">
              <?php echo __('Not registered yet?', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="javascript:void(0)" class="ms-strong ms-tab" data-tab="tabRegister"><?php echo __('Register now', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
            </div>
            <div class="form_content">
              <form id="formLogin" method="post">
                <input type="hidden" name="window_width" class="formRegister_windowWidth" value="">
                <input type="hidden" name="logon_type" value="email">
                <input name="action" type="hidden" value="flex_idx_lead_signin">
                <ul class="form_md" id="cntLoginForm">
                  <li class="form_input">
                    <input id="txt_user" autocomplete="disabled" autocorrect="off" autocapitalize="off" spellcheck="false" name="user_name" placeholder="<?php echo __('Enter email', IDXBOOST_DOMAIN_THEME_LANG); ?>" required type="email" value="">
                  </li>
                  <li class="form_input">
                    <input id="txt_pwd" name="user_pass" autocomplete="new-password" placeholder="<?php echo __('Enter password', IDXBOOST_DOMAIN_THEME_LANG); ?>" required type="password" value="">
                    <span action="hide" class="showpassord"></span>
                  </li>
                </ul>
                <button class="btn_form" id="clidxboost-btn-user-login" type="submit"><?php echo __('Continue with email', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
              </form>
            </div>
          </div>

          <div id="tabRegister" class="item_tab">
            <div class="ms-back">
              <button class="ms-icon-back">
                <span></span>
              </button>
            </div>

            <div class="form_content">
              <div id="push-registration">

                <form id="formRegister" method="post">
                  <input type="hidden" name="logon_type" id="formRegister_logonType" value="email">
                  <input type="hidden" name="register_password" id="formRegister_password" value="">
                  <input type="hidden" name="window_width" class="formRegister_windowWidth" value="">
                  <input type="hidden" name="action" value="flex_idx_lead_signup">

                  <ul class="pr-steps-container">
                    <li class="pr-step active">
                      <span class="ms-sub-text"><?php echo __('Register with your email address', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <div class="wrapper-input">
                        <input id="agilefield-9" name="register_email" type="email" class="agile-height-default" placeholder="Email" required value="">
                      </div>
                      <button class="pr-redbtn pr-next-step" type="button"><?php echo __('Continue With Email', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    </li>

                    <li class="pr-step email-registration">
                      <div class="ms-header-md">
                        <h4 class="ms-title-modal ms-no-mb"><?php echo __('Enter name and password', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                        <span class="pr-dgray"><?php echo __('Just a few more details so we can help you.', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      </div>
                      
                      <div class="name-input-content">
                        <div class="wrapper-input item-name">
                            <label class="agile-label" for="agilefield-6"><?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input id="agilefield-6" name="register_name" type="text" class="agile-height-default" placeholder="First Name" required value="">
                        </div>
                        <div class="wrapper-input item-name">
                            <label class="agile-label" for="agilefield-6"><?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input id="agilefield-7" name="register_last_name" type="text" class="agile-height-default" placeholder="Last Name" required value="">
                        </div>
                      </div>

                      <div class="wrapper-input">
                        <label class="agile-label ms-strong" for="agilefield-8"><?php echo __('Use phone number as password', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input id="agilefield-8" name="register_phone" type="text" placeholder="Phone number" class="agile-height-default" required value="">
                      </div>
                      <button class="pr-redbtn pr-registering" type="button"><?php echo __("I'm finished", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    </li>

                    <?php if (isset($flex_idx_info["agent"]["user_show_quizz"]) && ("1" == $flex_idx_info["agent"]["user_show_quizz"])): ?>
                    <li class="pr-step pr-radio">
                      <div class="ms-header-md">
                        <h4 class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                        <div class="ms-text">
                          <p>Just a few more details so we can help you.</p>
                          <p>(All fields are required)</p>
                        </div>
                        <div class="ms-icon ms-time"></div>
                        <h5 class="ms-sub-title ms-no-mb"><?php echo __('When are you looking to purchase?', IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
                      </div>
                      <ul class="pr-radio-list">
                        <li>
                          <input class="ibregister-btn" type="radio" name="timeline_for_purchase" id="inline_radios_1513789754550-0" value="1 - 3 Months">
                          <label for="inline_radios_1513789754550-0" class="i-checks"><?php echo __("Within 1-3 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                        <li>
                          <input class="ibregister-btn" type="radio" name="timeline_for_purchase" id="inline_radios_1513789754550-1" value="3 - 6 Months">
                          <label for="inline_radios_1513789754550-1" class="i-checks"><?php echo __("Within 3-6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                        <li>
                          <input class="ibregister-btn" type="radio" name="timeline_for_purchase" id="inline_radios_1513789754550-2" value="6+ Moths">
                          <label for="inline_radios_1513789754550-2" class="i-checks"><?php echo __("More than 6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                      </ul>
                    </li>
                    <li class="pr-step pr-radio">
                      <div class="ms-header-md">
                        <h4 class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                        <div class="ms-text">
                          <p>Just a few more details so we can help you.</p>
                          <p>(All fields are required)</p>
                        </div>
                        <div class="ms-icon ms-financing"></div>
                        <h5 class="ms-sub-title ms-no-mb"><?php echo __('Need assistance with financing?', IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
                      </div>
                      <ul class="pr-radio-list">
                        <li>
                          <input class="ibregister-btn" type="radio" name="mortgage_approved" id="inline_radios_1513789825341-0" value="Yes">
                          <label for="inline_radios_1513789825341-0" class="i-checks"><?php echo __("I am pre-approved", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                        <li>
                          <input class="ibregister-btn" type="radio" name="mortgage_approved" id="inline_radios_1513789825341-1" value="No">
                          <label for="inline_radios_1513789825341-1" class="i-checks"><?php echo __("Not pre-approved yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                        <li>
                          <input class="ibregister-btn" type="radio" name="mortgage_approved" id="inline_radios_1513789825341-2" value="I'm buying with Cash">
                          <label for="inline_radios_1513789825341-2" class="i-checks"><?php echo __("I prefer to buy with cash", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                      </ul>
                    </li>
                    <li class="pr-step pr-radio">
                      <div class="ms-header-md">
                        <h4 class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                        <div class="ms-text">
                          <p>Just a few more details so we can help you.</p>
                          <p>(All fields are required)</p>
                        </div>
                        <div class="ms-icon ms-sale"></div>
                        <h5 class="ms-sub-title ms-no-mb"><?php echo __('Need to also sell your property?', IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
                      </div>
                      <ul class="pr-radio-list">
                        <li>
                          <input type="radio" name="sell_a_home" id="inline_radios_15137898580630-0" value="Yes">
                          <label class="ibregister-tg-submit" for="inline_radios_15137898580630-0"><?php echo __("Looking to sell too", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                        <li>
                          <input type="radio" name="sell_a_home" id="inline_radios_15137898580631-1" value="No">
                          <label class="ibregister-tg-submit" for="inline_radios_15137898580631-1"><?php echo __("Not looking to sell", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                        <li>
                          <input type="radio" name="sell_a_home" id="inline_radios_15137898580632-2" value="I'm undecided">
                          <label class="ibregister-tg-submit" for="inline_radios_15137898580632-2"><?php echo __("Not sure yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        </li>
                      </ul>
                      <!--<button class="ms-link close-modal" data-id="modal_login" data-frame="modal_mobile">Skip this step</button>-->
                    </li>
                    <?php endif; ?>

                    <!-- inicio nuevo item de facebook -->
                    <li class="pr-step facebook-registration" style="display: none">
                      <div class="ms-header-md">
                        <h4 class="ms-title-modal ms-no-mb"><?php echo __('Thank you for registering!', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                        <h5 class="ms-sub-title"><?php echo __('Use Phone Number For Password', IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
                      </div>
                      
                      <div class="name-input-content">
                        <div class="wrapper-input">
                          <label class="agile-label" for="agilefield-6">
                            <?php echo __('Phone number', IDXBOOST_DOMAIN_THEME_LANG); ?>
                            <span class="txtgray">(<?php echo __('Used as password', IDXBOOST_DOMAIN_THEME_LANG); ?>)</span> 
                          </label>
                          <input id="" name="register_phone_facebook" type="text" class="agile-height-default" placeholder="Phone number" required value="">
                        </div>
                      </div>

                      <button class="pr-redbtn pr-registering" type="button"><?php echo __("I'm finished", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    </li>
                    <!-- final nuevo item de facebook -->

                  </ul>
                  <span id="agile-error-msg"></span>
                </form>
              </div>
            </div>
          </div>

          <div id="tabReset" class="item_tab">
            
            <div class="ms-back">
              <button class="ms-icon-back">
                <span></span>
              </button>
            </div>

            <div class="form_content">
              <form  id="formReset" method="post" name="formReset">
                <p>
                  <?php echo __("Enter your email address and we'll send you a link to be able to change your password", IDXBOOST_DOMAIN_THEME_LANG); ?>
                </p>

                <ul class="form_md" id="cntResetForm">
                  <li class="form_input">
                    <label class="agile-label" for="agilefield-9">Email Address</label>
                    <input id="reset_email" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" name="reset_email" placeholder="<?php echo __("Enter E-mail", IDXBOOST_DOMAIN_THEME_LANG); ?>" required type="email"/>
                  </li>
                </ul>
                <button class="btn_form" id="clidxboost-btn-user-reset" type="submit">
                <?php echo __("Send email", IDXBOOST_DOMAIN_THEME_LANG); ?>
                </button>
                <input name="action" class="action" type="hidden" value="flex_idx_lead_resetpass">
                <input name="tokepa" class="tokepa" type="hidden" value="">
              </form>
            </div>
          </div>
          
          <?php if ((isset($flex_idx_info["agent"]["google_login_enabled"]) && "1" == $flex_idx_info["agent"]["google_login_enabled"]) ||
          (isset($flex_idx_info["agent"]["facebook_login_enabled"]) && "1" == $flex_idx_info["agent"]["facebook_login_enabled"])): ?>
          <div class="line_or"><span><?php echo __('or', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
          <ul class="social_login">
            <?php if (isset($flex_idx_info["agent"]["facebook_login_enabled"]) && "1" == $flex_idx_info["agent"]["facebook_login_enabled"]): ?>
            <li>
                <a class="ico-facebook flex-social-login-fb" href="#" onclick="fb_login();" title="Continue with Facebook">
                    <?php echo __('Continue with Facebook', IDXBOOST_DOMAIN_THEME_LANG); ?>
                </a>
                <span class="ms-label">Forgot your password? <a href="javascript:void(0)" class="ms-tab" data-tab="tabReset">Reset now</a></span>
            </li>
            <?php endif; ?>
          </ul>
          <?php endif; ?>
        </div>

        <div class="footer_md terms-md">
          <p><?php echo __("In agreement with our", IDXBOOST_DOMAIN_THEME_LANG); ?> <a target="_blank" href="<?php echo $flex_idx_info["website_url"]; ?>/terms-and-conditions/"><?php echo __("Terms of Use", IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __("and", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="<?php echo $flex_idx_info["website_url"]; ?>/terms-and-conditions/"><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_login"></div>
  </div>

  <!-- ADD SEARCH MODAL -->
  <div class="overlay_modal" id="modal_save_search">
    <div class="modal_cm">
      <button data-id="modal_save_search" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?><span> </span></button>
      <div class="content_md">
        <div class="heder_md">
          <h2>
            <?php echo __("Save This Search", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </h2>
        </div>
        <div class="body_md">
          <div class="form_content">
            <form id="form-save" method="POST">
              <div class="gform_body">
                <ul class="gform_fields">
                  <!--<li class="gfield field_sublabel_below">
                    Search Name(*)
                  </li>-->
                  <li class="gfield">
                    <label class="gfield_label">
                    <?php echo __("Search Name(*)", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container">
                      <input class="medium" id="input_sname_search" name="input_sname" placeholder="<?php echo __("Search Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" required type="text" value="">
                      </input>
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">
                    Email Updates
                  </li>-->
                  <li class="gfield">
                    <label class="gfield_label">
                    <?php echo __("Email Updates", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container">
                      <select class="iboost-alert-change-interval notification_day_class medium">
                        <option value="--">
                          <?php echo __("No Alert", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                        <option value="1" selected>
                          <?php echo __("Daily", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                        <option value="7">
                          <?php echo __("Weekly", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                        <option value="30">
                          <?php echo __("Monthly", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                      </select>
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">
                    Only Update Me On
                  </li>-->
                  <li class="gfield">
                    <label class="gfield_label">
                    <?php echo __("Only Update Me On", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container">
                      <ul class="list-check">
                        <li>
                          <input  class="flex-save-type-options" id="new-listing" name="notification_type[]" type="checkbox" value="new_listing" checked>
                          <label for="new-listing">
                          <?php echo __("New Listing (Always)", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                          </input>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="price-change" name="notification_type[]" type="checkbox" value="price_change" checked>
                          <label for="price-change">
                          <?php echo __("Price Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                          </input>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="status-change" name="notification_type[]" type="checkbox" value="status_change" checked>
                          <label for="status-change">
                          <?php echo __("Status Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                          </input>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <div class="gform_footer">
                  <input class="form_submit_button_search gform_button button gform_submit_button_5" type="submit" value="<?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  </input>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_save_search"></div>
  </div>

  <!-- UPDATE SEARCH MODAL -->
  <div class="overlay_modal" id="modal_update_search">
    <div class="modal_cm">
      <button data-id="modal_update_search" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?><span> </span></button>
      <div class="content_md">
        <div class="heder_md">
          <h2><?php echo __("Saved Search", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
        </div>
        <div class="body_md">
          <div class="form_content">
            <form id="form-update-alert" method="POST">
              <div class="gform_body">
                <ul class="gform_fields">
                  <!--<li class="gfield field_sublabel_below">Saved Search Name(*)</li>-->
                  <li class="gfield">
                    <label class="gfield_label"><?php echo __("Search Name(*)", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container">
                      <input class="medium" id="input_update_name_search" name="input_sname" placeholder="<?php echo __("Search Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" required type="text" value=""></input>
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">Email Updates</li>-->
                  <li class="gfield">
                    <label class="gfield_label"><?php echo __("Email Updates", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container">
                      <select class="iboost-alert-change-interval notification_day_class_update medium">
                        <option value="0"><?php echo __("No Alert", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        <option value="1"><?php echo __("Daily", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        <option value="7"><?php echo __("Weekly", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        <option value="30"><?php echo __("Monthly", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      </select>
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">Only Update Me On</li>-->
                  <li class="gfield">
                    <label class="gfield_label"><?php echo __("Only Update Me On", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container">
                      <ul class="list-check">
                        <li>
                          <input  class="flex-save-type-options" id="update-listing-alert" name="notification_type_update[]" type="checkbox" value="new_listing">
                          <label for="update-listing-alert">
                          <?php echo __("New Listing (Always)", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                          </input>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="update-price-change-alert" name="notification_type_update[]" type="checkbox" value="price_change">
                          <label for="update-price-change-alert">
                          <?php echo __("Price Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                          </input>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="update-status-change-alert" name="notification_type_update[]" type="checkbox" value="status_change">
                          <label for="update-status-change-alert">
                          <?php echo __("Status Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                          </input>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <div class="gform_footer">
                  <input class="form_submit_button_search gform_button button gform_submit_button_5" type="submit" value="<?php echo __("Update Saved Search", IDXBOOST_DOMAIN_THEME_LANG); ?>"></input>
                </div>
              </div>
              <input type="hidden" name="token_alert" class="token_alert">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_update_search"></div>
  </div>

  <!-- ADD FAVORITES -->
  <div class="overlay_modal" id="modal_add_favorities">
    <div class="modal_cm">
      <button data-id="modal_add_favorities" class="close close-modal" data-frame="modal_mobile">Close <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <h2><?php echo __("Property added to favorites", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
            <p><?php echo __("You can see your saved properties", IDXBOOST_DOMAIN_THEME_LANG); ?> <br><?php echo __("under your account", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_add_favorities" data-frame="modal_mobile"></div>
  </div>

  <!-- ADD FAVORITES -->
  <div class="overlay_modal" id="modal_update_favorities">
    <div class="modal_cm">
      <button data-id="modal_update_favorities" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <p><?php echo __("Your changes have been saved successfully", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_update_favorities" data-frame="modal_mobile"></div>
  </div>

  <!-- REQUEST A SHOWING -->
  <div class="overlay_modal" id="modal_schedule">
    <div class="modal_cm">
      <button data-id="modal_schedule" class="close close-modal" data-frame="modal_mobile">
        <?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?><span></span>
      </button>
      <div class="content_md">
        <div class="heder_md">
          <h2><?php echo __("Schedule a Consultation", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
        </div>
        <div class="body_md">
          <p>
            <?php echo __("Please provide your contact information and one of our real estate professionals will be in touch.", IDXBOOST_DOMAIN_THEME_LANG); ?>
            <br>
            <?php if (isset($flex_idx_info['agent']['agent_contact_phone_number'])): ?>
            <?php echo __('CALL US', IDXBOOST_DOMAIN_THEME_LANG); ?> 
            <a href="tel:<?php echo preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>"><?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?></a>
            <?php endif ?>
          </p>
          <div class="form_content">
            <form id="form-scheduled" method="post">
              <input type="hidden" name="action" value="lead_submission_showing">
              <div class="gform_body">
                <ul class="gform_fields">
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" class="medium" name="first_name" placeholder='<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])): ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" class="medium" name="last_name" placeholder='<?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])): ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" class="medium" name="email_address" placeholder='<?php echo __("Email Address", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])): ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" class="medium" name="phone_number" placeholder='<?php echo __("Phone Number", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="text" value="<?php if (isset($flex_idx_lead['lead_info']['phone_number'])): ?><?php echo $flex_idx_lead['lead_info']['phone_number']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield comments">
                    <div class="ginput_container">
                      <textarea autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" class="medium textarea" cols="50" name="comments" placeholder='<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>' rows="10"></textarea>
                    </div>
                  </li>
                  <li class="gfield field_sublabel_below"><?php echo __("Prefered Time and Date", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="gfield time">
                    <div class="ginput_container ginput_container_time">
                        <select name="preferred_time" class="medium" id="ss_preferred_time">
                          <option selected value="Morning" selected="selected"><?php echo __("Morning", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="Afternoon"><?php echo __("Afternoon", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="Evening"><?php echo __("Evening", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        </select>
                    </div>
                  </li>
                  <li class="gfield date">
                    <div class="ginput_container ginput_container_date">
                      <input type="text" name="preferred_date" id="ss_preferred_date" value="" placeholder='<?php echo __("Choose Date", IDXBOOST_DOMAIN_THEME_LANG); ?>' class="medium">
                    </div>
                  </li>
                </ul>
                <div class="gform_footer">
                  <input class="gform_button button gform_submit_button_6" type="submit" value="<?php echo __('Submit', IDXBOOST_DOMAIN_THEME_LANG); ?>"/>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_schedule">
    </div>
  </div>

  <!-- SHARE TO FRIEND -->
  <div class="overlay_modal" id="modal_email_to_friend">
    <div class="modal_cm">
      <button data-id="modal_email_to_friend" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="heder_md">
          <h2>
            <?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </h2>
        </div>
        <div class="body_md">
          <p>
            <?php echo __("Recomend this to a friend, just enter their email below", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </p>
          <div class="form_content">
            <form id="form-email-friend" method="post">
              <?php
                global $wp, $post;
                $wp_request = $wp->request;
                $wp_request_exp = explode('/', $wp_request);
                ?>
              <input type="hidden" name="share_permalink" value="<?php echo $flex_idx_info["website_url"]; ?>/<?php echo $wp_request; ?>">
              <?php if (isset($wp_request_exp[0]) && $wp_request_exp[0] === 'building'): ?>
              <input type="hidden" name="share_type" value="building">
              <input type="hidden" name="building_ID" value="<?php echo get_post_meta(get_the_ID(), '_flex_building_page_id', true); ?>">
              <?php elseif(isset($wp_request_exp[0]) && $wp_request_exp[0] === 'property'):
                list($page, $slug) = $wp_request_exp;
                
                if (strstr($slug, '-rx-')) {
                    $exp_slug = explode('-', $slug);
                    $mls_num  = 'rx-' . end($exp_slug);
                } else {
                    $exp_slug = explode('-', $slug);
                    $mls_num  = end($exp_slug);
                }
                
                $type_lookup = 'active';
                
                if (preg_match('/^[sold\-(.*)]+/', $slug)) {
                    $type_lookup = 'sold';
                } else if (preg_match('/^[rent\-(.*)]+/', $slug)) {
                    $type_lookup = 'rent';
                } else if (preg_match('/^[pending\-(.*)]+/', $slug)) {
                    $type_lookup = 'pending';
                } else {
                    $type_lookup = 'active';
                }
                
                ?>
              <input type="hidden" name="share_type" value="property">
              <input type="hidden" name="mls_num" value="<?php echo $mls_num; ?>">
              <input type="hidden" name="type_property" value="<?php echo $type_lookup; ?>">
              <?php endif; ?>
              <input type="hidden" name="action" value="flex_share_with_friend">
              <div class="gform_body">
                <ul class="gform_fields">
                  <li class="gfield field_sublabel_below">
                    <?php echo __("Friend&#039s Information", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label"><?php echo __("Friend&#039s email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="friend_email" placeholder="<?php echo __("Friend&#039s Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="email" value="" />
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label"><?php echo __("Friend name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="friend_name" placeholder="<?php echo __("Friend&#039s Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="text" value="">
                    </div>
                  </li>
                  <li class="gfield field_sublabel_below"><?php echo __("Your Information", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="gfield">
                    <label class="gfield_label"><?php echo __("Your Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="your_name" placeholder="<?php echo __("Your Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="text" value="">
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label"><?php echo __("Your Email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container ginput_container_email">
                      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="your_email" placeholder="<?php echo __("Your Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="email" value="">
                    </div>
                  </li>
                  <li class="gfield comments">
                    <label class="gfield_label"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container">
                      <textarea autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium textarea" cols="50" name="comments" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" rows="10" type="text"></textarea>
                    </div>
                  </li>
                  <li class="gfield requiredFields">* <?php echo __("Required Fields", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                </ul>
                <div class="gform_footer">
                  <input class="gform_button button gform_submit_button_6" type="submit" value="<?php echo __("Submit", IDXBOOST_DOMAIN_THEME_LANG); ?>">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_email_to_friend">
    </div>
  </div>

  <!-- MORTGAGE CALCULATOR -->
  <div class="overlay_modal" id="modal_calculator">
    <div class="modal_cm">
      <button data-id="modal_calculator" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="heder_md">
          <h2>
            <?php echo __("Mortgage calculator", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </h2>
        </div>
        <div class="body_md">
          <p>
            <?php echo __("Let’s us know the best time for showing.", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </p>
          <ul class="contact-opt">
            <li>
              <a href="tel:<?php echo preg_replace('/[^\d]+/', '', $flex_idx_info['agent']['agent_contact_phone_number']) ?>">
              <?php echo $flex_idx_info['agent']['agent_contact_phone_number']; ?>
              </a>
            </li>
            <?php if (false !== $flex_idx_lead) {?>
            <li>
              <a href="mailto:<?php echo isset($flex_idx_lead['lead_info']['agent_contact_email_address']) ? esc_attr($flex_idx_lead['lead_info']['agent_contact_email_address']) : ""; ?>" class="mail_login">
              <?php echo isset($flex_idx_lead['lead_info']['agent_contact_email_address']) ? esc_attr($flex_idx_lead['lead_info']['agent_contact_email_address']) : ""; ?>
              </a>
            </li>
            <?php } ?>
          </ul>
          <div class="form_content">
            <form id="form-calculator">
              <div class="gform_body">
                <ul class="gform_fields">
                  <li class="gfield">
                    <label class="gfield_label">
                    <?php echo __("Purchase Price", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container ginput_container_email">
                      <input class="medium purchase_price_txt" name="input_1" readonly="" type="text" value="<?php echo isset($property['price']) ? '$' . number_format($property['price']) : ''; ?>">
                      </input>
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label">
                    % <?php echo __("Down Payment", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container ginput_container_payment">
                      <input class="medium down_payment_txt" max="95" min="0" name="input_2 down_payment_txt" step="any" type="number" value="30">
                      </input>
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label">
                    <?php echo __("Term", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container ginput_container_years">
                      <select class="medium term_txt">
                        <option value="30">
                          30 <?php echo __("Years", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                        <option value="15">
                          15 <?php echo __("Years", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                      </select>
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label">
                    <?php echo __("Interest Rate", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container ginput_container_rate">
                      <input class="medium interest_rate_txt" id="" max="95" min="0" name="input_3" step="any" type="number" value="4">
                      </input>
                    </div>
                  </li>
                </ul>
                <div class="gform_footer">
                  <input class="buton_calculator gform_button button gform_submit_button_5" type="submit" value="<?php echo __("Calculate", IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  </input>
                </div>
              </div>
              <input class="input_ura" type="hidden" value="<?php echo FLEX_IDX_URI.'/inc/post_response.php'; ?>">
              </input>
            </form>
          </div>
          <div class="detail-mortgage">
            <h3><?php echo __("Mortgage breakdown", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
            <ul>
              <li><span><?php echo __("Mortgage Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span id="mortgage-amount" class="text-bold mortgage_mount_txt"></span></li>
              <li><span><?php echo __("Down Payment Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span id="down-payment" class="text-bold down_paymentamount_txt"></span></li>
              <li class="line-top"><span><?php echo __("Monthly Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span id="monthly-amount" class="text-bold mtotal mortgage_amount_txt"></span></li>
              <li class="line-top"><span><?php echo __("Total Monthly Amount", IDXBOOST_DOMAIN_THEME_LANG); ?> <strong> <?php echo __("(Principal & Interest, and PMI)", IDXBOOST_DOMAIN_THEME_LANG); ?></strong></span><span id="total-monthly" class="text-bold mtotal mortgage_amount_txt"></span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_calculator"></div>
  </div>

  <!-- ADD FAVORITIES -->
  <div class="overlay_modal" id="modal_remove_favorities">
    <div class="modal_cm">
      <button data-id="modal_remove_favorities" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <p><?php echo __("Information has been updated!", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_remove_favorities" data-frame="modal_mobile"></div>
  </div>

  <!-- SEARCH SAVED -->
  <div class="overlay_modal" id="modal_properties_send">
    <div class="modal_cm">
      <button data-id="modal_properties_send" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <h2><?php echo __("Email Sent!", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
            <p><?php echo __("Your email was sent succesfully", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_properties_send" data-frame="modal_mobile"></div>
  </div>

  <!-- SEARCH SAVED -->
  <div class="overlay_modal" id="modal_search_saved">
    <div class="modal_cm">
      <button data-id="modal_search_saved" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <h2><?php echo __("Search Saved", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
            <p><?php echo __("Your search has been saved successfuly.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_search_saved" data-frame="modal_mobile"></div>
  </div>

  <!-- MODAL PROPERTIES -->
  <div class="overlay_modal modal_property_detail" id="modal_property_detail">
    <div id="md-body" class="modal_cm detail-modal"></div>
    <div class="overlay_modal_closer_pt" data-id="modal_property_detail"></div>
  </div>

  <!-- ALERTS -->
  <div class="overlay_modal" id="modal_subscribe">
    <div class="modal_cm">
      <button data-id="modal_subscribe" class="close close-modal" data-frame="modal_mobile">Close <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message alt-ss">
            <h3 class="alt-ss-title">Subscribe Alert</h3>
            <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum.</p>
            <a href="#" class="btn-link">Continue searching for homes</a>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_subscribe" data-frame="modal_mobile"></div>
  </div>

</div>

<script>
<?php
$ib_track_signup = (isset($_GET["ibtrack_signup"]) && ("1" == $_GET["ibtrack_signup"])) ? true : false;
?>
(function($) {
  function validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email.toLowerCase());
  }

$(function() {
  <?php if (true === $ib_track_signup): ?>
  $(".login-modal .close").css("visibility", "hidden");
  if ("yes" === __flex_g_settings.anonymous) {
    $("#modal_login").addClass("active_modal");
  }
  <?php endif; ?>
  $(".ib-switch-login-tab").on("click", function(event) {
    event.stopPropagation();
    event.preventDefault();

    $(".ib-tabLogin:eq(0)").click();
    $("#txt_user").focus();
  });

  $(".pr-next-step").on("click", function() {
    var _self = $(this);

    var emailField = $("#agilefield-9").val().trim();

    if (!validateEmail(emailField)) {
      alert("invalid email address");
      return;
    }

    _self.parent().removeClass("active");
    _self.parent().next().addClass("active");

    /*HIDDEN HEADERS*/
    $('#modal_login .content_md').addClass('ms-hidden-extras');
  });

  $(".pr-registering").on("click", function() {
    var _self = $(this);

    var firstNameField = $("#agilefield-6").val().trim();
    var lastNameField = $("#agilefield-7").val().trim();
    var phoneNumberField = $("#agilefield-8").val().trim();

    if (("" === firstNameField) || ("" === phoneNumberField) || ("" === lastNameField)) {
      alert("Please fill the fields");
      return;
    }

    if ( (typeof SIGNUP_EXTENDS_QUIZZ !== "undefined") && ("1" == SIGNUP_EXTENDS_QUIZZ) ) {
      console.log("show the quizz before submit the form");

      _self.parent().removeClass("active");
      _self.parent().next().addClass("active");

    } else {
      console.log("submit the form");
      $("#formRegister").submit();
    }

    // if (typeof SIGNUP_EXTENDS_QUIZZ === "undefined" || ((typeof SIGNUP_EXTENDS_QUIZZ !== "undefined") && ("0" === SIGNUP_EXTENDS_QUIZZ))) {
    //   $("#modal_login .close").click();
    //   $("#formRegister").submit();
    //   alert("dont do this!");
    // }
  });

  $(".i-checks").on("click", function() {
    var _self = $(this);
    _self.parent().parent().parent().removeClass('active');
    _self.parent().parent().parent().next().addClass('active');
  });

  $(".ibregister-tg-submit").on("click", function() {
    var _self = $(this);

    _self.prev().prop("checked", true);

    $("#formRegister").submit();
  });

  $("#agilefield-8").on("change", function () {
    var _value = $(this).val().trim();
    $("#formRegister_password").val(_value);
  });



    $("#form-email-friend").on("submit", function(event) {
        event.preventDefault();

        var _self = $(this);
        var serializedData = _self.serialize();

        $.ajax({
            url: __flex_g_settings.ajaxUrl,
            method: "POST",
            data: serializedData,
            dataType: "json",
            success: function(data) {

            }
        });

        $(this).trigger("reset");
        $('.close').click();

        swal(word_translate.good_job, word_translate.your_message_has_been_sent, "success");
    });

    $(".property-detail-share-fb").on("click", function(event) {
        event.preventDefault();

        console.log('sharing fb url');

        var og_url = $(this).data('share-url');
        var og_title = $(this).data('share-title');
        var og_description = $(this).data('share-description');
        var og_image = $(this).data('share-image');

        FB.ui({
            method: 'share_open_graph',
            action_type: 'og.shares',
            action_properties: JSON.stringify({
                object : {
                   'og:url': og_url, // your url to share
                   'og:title': og_title,
                   'og:description': og_description,
                   'og:image': og_image
                }
            })
        });
    });
});

})(jQuery);
</script>

<?php if (isset($flex_idx_info["agent"]["google_login_enabled"]) && "1" == $flex_idx_info["agent"]["google_login_enabled"]): ?>
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: "<?php echo $flex_idx_info["agent"]["google_client_id"]; ?>",
        cookiepolicy: 'none',
        ux_mode: 'popup'
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });

      attachSignin(document.getElementById('gSignIn'));
    });
  };

  function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
          var profile = googleUser.getBasicProfile();

          console.log('Fetching data from google...');
          console.dir({
            id: profile.getId(),
            name: profile.getName(),
            givenName: profile.getGivenName(),
            familyName: profile.getFamilyName(),
            imageUrl: profile.getImageUrl() + "?sz=100",
            email: profile.getEmail()
          });

          // return;

          var google_user_info = {
            'name': profile.getName(),
            'first_name': profile.getGivenName(),
            'last_name': profile.getFamilyName(),
            'email': profile.getEmail(),
            'id': profile.getId()
          };

          // hide registration form
          jQuery("#modal_login").removeClass("active_modal");

          swal({
            title: word_translate.your_account_is_being_created,
            text: word_translate.this_might_take_a_while_do_not_reload_thepage,
            type: "info",
            showConfirmButton: false,
            closeOnClickOutside: false,
            closeOnEsc: false
          });

          console.dir(google_user_info);

            jQuery.ajax({
                url: __flex_g_settings.ajaxUrl,
                method: "POST",
                data: {
                    window_width: window.innerWidth,
                    user_info: google_user_info,
                    logon_type: "google",
                    action: "flex_idx_lead_signin"
                },
                dataType: "json",
                success: function(response) {
                    var ib_log_message = response.message;
                    if (response.message=='Logged in succesfully.'){
                        ib_log_message=word_translate.logged_in_succesfully;
                    }else if(response.message=='Your account has been created successfully.'){
                        ib_log_message=word_translate.your_account_has_been_created_successfully;
                    }else if(response.message=='Invalid credentials, try again.'){
                        ib_log_message=word_translate.invalid_credentials_try_again;
                    }

                    if (response.success === true) {
                        Cookies.set('ib_lead_token', response.lead_token, { expires: 30 });

                        // socket.subscribe(__flex_g_settings.pusher.presence_channel);
                        if ("undefined" !== typeof socket) {
                            socket.disconnect();

                            socket = new Pusher(__flex_g_settings.pusher.app_key, {
                              cluster: __flex_g_settings.pusher.app_cluster,
                              encrypted: true,
                              authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
                            });
                            
                            socket.subscribe(__flex_g_settings.pusher.presence_channel);
                          }

                        // jQuery(".close").click();

                        // updates lead list menu HTML
                        jQuery("#user-options").html(response.output);
                        jQuery(".lg-wrap-login:eq(0)").html(response.output);
                        jQuery(".lg-wrap-login:eq(0)").addClass("active");

                        // // reset registration form
                        // _self.trigger('reset');

                        // save last logged in username
                        Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

                        // store first name
                        Cookies.set("_ib_user_firstname", response.first_name);

                        // store last name
                        Cookies.set("_ib_user_lastname", response.last_name);

                        // store phone
                        Cookies.set("_ib_user_phone", response.phone);

                        // store email
                        Cookies.set("_ib_user_email", response.email);

                        jQuery("#_ib_fn_inq").val(response.first_name);
                        jQuery("#_ib_ln_inq").val(response.last_name);
                        jQuery("#_ib_em_inq").val(response.email);
                        jQuery("#_ib_ph_inq").val(response.phone);

                        jQuery("._ib_fn_inq").val(response.first_name);
                        jQuery("._ib_ln_inq").val(response.last_name);
                        jQuery("._ib_em_inq").val(response.email);
                        jQuery("._ib_ph_inq").val(response.phone);

                        jQuery('html').removeClass('modal_mobile');

                        // overwrite lead status globally
                        __flex_g_settings.anonymous = "no";

                        // track listing view
                        jQuery.ajax({
                          type: "POST",
                          url: __flex_g_settings.ajaxUrl,
                          data: {
                            action: "track_property_view",
                            board_id: __flex_g_settings.boardId,
                            mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty
                          },
                          success: function(response) {
                            console.log("track done for property #" + lastOpenedProperty);
                          }
                        });

                        // notify user with success message

                        swal({
                          title: word_translate.congratulations,
                          text: ib_log_message,
                          type: "success",
                          showConfirmButton: false,
                          closeOnClickOutside: true,
                          closeOnEsc: true,
                          timer: 3000
                        });

                        if ( ("undefined" !== typeof IB_IS_SEARCH_FILTER_PAGE) && (true === IB_IS_SEARCH_FILTER_PAGE) ||
                             ("undefined" !== typeof IB_IS_REGULAR_FILTER_PAGE) && (true === IB_IS_REGULAR_FILTER_PAGE) ) {
                          // save filter for lead is it doesnt exists
                          saveFilterSearchForLead();
                        }

                        //to generate the google tag conversion of sigened in user
                        if (typeof gtagfucntion == 'function') {
                          gtagfucntion();
                        }

                        setTimeout(function () {
                          if ( ("1" == __flex_g_settings.user_show_quizz) && ("signup" == response.logon_type) ) {
                            jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
                          }
                        }, 3000);
                    } else {
                        sweetAlert("Oops...", ib_log_message, "error");
                    }
                }
            });

        }, function(error) {
          console.error(error);
          // alert(JSON.stringify(error, undefined, 2));
        });
  }

  startApp();
  </script>
<?php endif; ?>

<?php if (isset($flex_idx_info["agent"]["facebook_login_enabled"]) && "1" == $flex_idx_info["agent"]["facebook_login_enabled"]): ?>
<script>
window.fbAsyncInit = function() {
  FB.init({
      appId: "<?php echo $flex_idx_info["agent"]["facebook_app_id"]; ?>",
      cookie: true,
      xfbml: true,
      version: 'v2.8'
  });

  FB.AppEvents.logPageView();
};

function fb_login() {
  FB.login(function(response) {
      if (response.status === "connected") {
          var userID = response.authResponse.userID;

          FB.api('/me?fields=name,first_name,last_name,email,picture.width(100).height(100)', function(response) {
              console.log("Fetching data from facebook...");
              console.dir(response);

              // return;

              // hide registration form
              jQuery("#modal_login").removeClass("active_modal");

              swal({
                title: word_translate.your_account_is_being_created,
                text: word_translate.this_might_take_a_while_do_not_reload_thepage,
                type: "info",
                showConfirmButton: false,
                closeOnClickOutside: false,
                closeOnEsc: false
              });

                jQuery.ajax({
                    url: __flex_g_settings.ajaxUrl,
                    method: "POST",
                    data: {
                        window_width: window.innerWidth,
                        user_info: response,
                        logon_type: "facebook",
                        action: "flex_idx_lead_signin"
                    },
                    dataType: "json",
                    success: function(response) {

                    var ib_log_message = response.message;
                    if (response.message=='Logged in succesfully.'){
                        ib_log_message=word_translate.logged_in_succesfully;
                    }else if(response.message=='Your account has been created successfully.'){
                        ib_log_message=word_translate.your_account_has_been_created_successfully;
                    }else if(response.message=='Invalid credentials, try again.'){
                        ib_log_message=word_translate.invalid_credentials_try_again;
                    }

                        if (response.success === true) {
                            Cookies.set('ib_lead_token', response.lead_token, {
                              expires: 30
                            });

                            //socket.subscribe(__flex_g_settings.pusher.presence_channel);
                            if ("undefined" !== typeof socket) {
                              socket.disconnect();

                              socket = new Pusher(__flex_g_settings.pusher.app_key, {
                                cluster: __flex_g_settings.pusher.app_cluster,
                                encrypted: true,
                                authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
                              });
                              
                              socket.subscribe(__flex_g_settings.pusher.presence_channel);
                            }
                        
                            // updates lead list menu HTML
                            jQuery("#user-options").html(response.output);
                            jQuery(".lg-wrap-login:eq(0)").html(response.output);
                            jQuery(".lg-wrap-login:eq(0)").addClass("active");

                            // // reset registration form
                            // _self.trigger('reset');

                            // save last logged in username
                            Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

                            // store first name
                            Cookies.set("_ib_user_firstname", response.first_name);

                            // store last name
                            Cookies.set("_ib_user_lastname", response.last_name);

                            // store phone
                            Cookies.set("_ib_user_phone", response.phone);

                            // store email
                            Cookies.set("_ib_user_email", response.email);

                            jQuery("#_ib_fn_inq").val(response.first_name);
                            jQuery("#_ib_ln_inq").val(response.last_name);
                            jQuery("#_ib_em_inq").val(response.email);
                            jQuery("#_ib_ph_inq").val(response.phone);

                            jQuery("._ib_fn_inq").val(response.first_name);
                            jQuery("._ib_ln_inq").val(response.last_name);
                            jQuery("._ib_em_inq").val(response.email);
                            jQuery("._ib_ph_inq").val(response.phone);

                            jQuery('html').removeClass('modal_mobile');

                            // overwrite lead status globally
                            __flex_g_settings.anonymous = "no";

                            // track listing view
                            jQuery.ajax({
                              type: "POST",
                              url: __flex_g_settings.ajaxUrl,
                              data: {
                                action: "track_property_view",
                                board_id: __flex_g_settings.boardId,
                                mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty
                              },
                              success: function(response) {
                                console.log("track done for property #" + lastOpenedProperty);
                              }
                            });

                              // notify user with success message
                            swal({
                              title: word_translate.congratulations,
                              text: ib_log_message,
                              type: "success",
                              showConfirmButton: false,
                              closeOnClickOutside: true,
                              closeOnEsc: true,
                              timer: 3000
                            });

                        if ( ("undefined" !== typeof IB_IS_SEARCH_FILTER_PAGE) && (true === IB_IS_SEARCH_FILTER_PAGE) ||
                             ("undefined" !== typeof IB_IS_REGULAR_FILTER_PAGE) && (true === IB_IS_REGULAR_FILTER_PAGE) ) {
                              // save filter for lead is it doesnt exists
                              saveFilterSearchForLead();
                            }
                           
                            //to generate the google tag conversion of sigened in user
							              if (typeof gtagfucntion == 'function') {
                              gtagfucntion();
                            }

                          setTimeout(function () {
                            if ( ("1" == __flex_g_settings.user_show_quizz) && ("signup" == response.logon_type) ) {
                              jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
                            }
                          }, 3000);
                        } else {
                          var textmessage='';
                          if (response.message=='Invalid credentials, try again.') 
                            textmessage=word_translate.invalid_credentials_try_again;
                          else if (response.message=='Logged in succesfully.')
                            textmessage=word_translate.logged_in_succesfully;
                            sweetAlert(word_translate.oops, textmessage, "error");
                        }
                    }
                });
          });
      }
  }, { scope:"public_profile,email" });
}

function fb_logout() {
  FB.logout(function(response) {
      window.location.reload(false);
  });
}

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {
      return;
  }
  js = d.createElement(s);
  js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php endif; ?>

<div class="ib-modal-master" data-id="push-registration" id="ib-push-registration-quizz-ct">
  <div class="ib-mmcontent">
    <div class="ib-mwrapper ib-mgeneric">
      <div class="ib-mgcontent"> 
        <div id="ib-push-registration">
          <form id="ib-register-form-quizz" method="post">
            <input type="hidden" name="action" value="ib_register_quizz_save">
            <ul class="ib-pr-steps-container">
              <li class="ib-pr-step ib-pr-radio ib-active"><span class="ib-pr-ico ib-timeline-icon"></span>
                <h4 class="ib-pr-title-radio"><?php echo __("When are you looking to purchase?", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <ul class="ib-pr-radio-list">
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789754550-0" type="radio" name="timeline_for_purchase" value="1 - 3 Months">
                    <label class="i-checks ib-rquizz-step2" for="inline_quizz_radios_1513789754550-0"><?php echo __("Within 1-3 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789754550-1" type="radio" name="timeline_for_purchase" value="3 - 6 Months">
                    <label class="i-checks ib-rquizz-step2" for="inline_quizz_radios_1513789754550-1"><?php echo __("Within 3-6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789754550-2" type="radio" name="timeline_for_purchase" value="6+ Moths">
                    <label class="i-checks ib-rquizz-step2" for="inline_quizz_radios_1513789754550-2"><?php echo __("More than 6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                </ul>
              </li>
              <li class="ib-pr-step ib-pr-radio"><span class="ib-pr-ico ib-pre_approved-icon"></span>
                <h4 class="ib-pr-title-radio"><?php echo __("Already pre-approved for financing?", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <ul class="ib-pr-radio-list">
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789825341-0" type="radio" name="mortgage_approved" value="Yes">
                    <label class="i-checks ib-rquizz-step3" for="inline_quizz_radios_1513789825341-0"><?php echo __("I am pre-approved", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789825341-1" type="radio" name="mortgage_approved" value="No">
                    <label class="i-checks ib-rquizz-step3" for="inline_quizz_radios_1513789825341-1"><?php echo __("Not pre-approved yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789825341-2" type="radio" name="mortgage_approved" value="I'm buying with Cash">
                    <label class="i-checks ib-rquizz-step3" for="inline_quizz_radios_1513789825341-2"><?php echo __("I prefer to buy with cash", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                </ul>
              </li>
              <li class="ib-pr-step ib-pr-radio"><span class="ib-pr-ico ib-sell-icon"></span>
                <h4 class="ib-pr-title-radio"><?php echo __("Are you also looking to sell your home?", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <ul class="ib-pr-radio-list">
                  <li>
                    <input id="inline_quizz_radios_15137898580630-0" type="radio" name="sell_a_home" value="Yes">
                    <label class="ibregister-tg-submit-quizz" for="inline_quizz_radios_15137898580630-0"><?php echo __("Looking to sell too", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input id="inline_quizz_radios_15137898580631-1" type="radio" name="sell_a_home" value="No">
                    <label class="ibregister-tg-submit-quizz" for="inline_quizz_radios_15137898580631-1"><?php echo __("Not looking to sell", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input id="inline_quizz_radios_15137898580632-2" type="radio" name="sell_a_home" value="I'm undecided">
                    <label class="ibregister-tg-submit-quizz" for="inline_quizz_radios_15137898580632-2"><?php echo __("Not sure yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                </ul>
              </li>
            </ul>
            <span id="agile-error-msg"></span>
          </form>
        </div>
      </div>
    </div>
    <?php /*<div class="ib-mmclose"><span class="ib-mmctxt">Close</span></div>*/ ?>
  </div>
  <div class="ib-mmbg"></div>
</div>

<script>
(function ($) {
var ib_register_form_quizz;

$(function() {
  
  ib_register_form_quizz = $("#ib-register-form-quizz");

  if (ib_register_form_quizz.length) {
    ib_register_form_quizz.on("submit", function(event) {
      event.preventDefault();

      var dataForm = $(this).serialize();
      console.log(dataForm);

      $.ajax({
        url: __flex_g_settings.ajaxUrl,
        method: "POST",
        data: dataForm,
        dataType: "json",
        success: function(data) {
          //$("#modal_login .content_md").removeClass('ms-hidden-extras');
        }
      });

    });

    ib_register_form_quizz.on("click", "label", function() {
      if ($(this).hasClass("ib-rquizz-step2")) {
        // show step 2
        ib_register_form_quizz.find(".ib-pr-step").removeClass("ib-active");
        ib_register_form_quizz.find(".ib-pr-step:eq(1)").addClass("ib-active");
      }

      if ($(this).hasClass("ib-rquizz-step3")) {
        // show step 3
        ib_register_form_quizz.find(".ib-pr-step").removeClass("ib-active");
        ib_register_form_quizz.find(".ib-pr-step:eq(2)").addClass("ib-active");
      }

      if ($(this).hasClass("ibregister-tg-submit-quizz")) {
        // submit the form
        setTimeout(function () {
          ib_register_form_quizz.trigger("submit");
          $("#ib-push-registration-quizz-ct").removeClass("ib-md-pa ib-md-active");
          swal(word_translate.thank_you, word_translate.your_info_has_been_saved, "success");

          //$("#modal_login .content_md").removeClass('ms-hidden-extras');

        }, 100);
      }
    });
  }

  $(document).on('click', '.ms-tab', function () {
    var dataTab = $(this).attr('data-tab');
    $(".header-tab a[data-tab='"+dataTab+"']").trigger("click");
  });

  $(document).on('click', '.ms-icon-back', function () {
    $(".header-tab a[data-tab='tabLogin']").trigger("click");
  });

})
})(jQuery);
</script>

<script>
(function ($) {

$(function() {
  $(".formRegister_windowWidth").val(window.innerWidth);
});

})(jQuery);
</script>

<script>
(function ($) {

var schedule_form;

$(function() {
  // datepicker for schedule form
  var dateToday = new Date();
  $("#ss_preferred_date").datepicker({
    minDate: dateToday,
    beforeShow:function(){
      $("#ss_preferred_date").parent().append($('#ui-datepicker-div'));
    }
  });
  
  // handle submission for schedule form
  schedule_form = $("#form-scheduled");

  if (schedule_form.length) {
    schedule_form.on("submit", function(event) {
      event.preventDefault();

      var _self = $(this);
      var form_data = _self.serialize();

      $.ajax({
        url: __flex_g_settings.ajaxUrl,
        method: "POST",
        data: form_data,
        dataType: "json",
        success: function (data) {
          _self.trigger("reset");
          $('.close-modal').click();

          active_modal($("#modal_properties_send"));
          setTimeout(function () {
            $('.close-modal').click();
          }, 1000);
        }
      });
    });
  }
});

})(jQuery);
</script>