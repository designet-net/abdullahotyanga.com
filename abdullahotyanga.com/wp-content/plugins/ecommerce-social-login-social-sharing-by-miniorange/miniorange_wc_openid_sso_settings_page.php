<?php

include_once dirname(__FILE__) . '/mo_wc_openid_sso_encryption.php';

ob_start();

require('view/config_apps/mo_openid_config_apps.php');
require('view/customise_social_icons/mo_openid_cust_icons.php');
require('view/disp_options/mo_openid_dispopt.php');
require('view/email_settings/mo_openid_set_email.php');
require('view/faq/mo_openid_faq.php');
require('view/gdpr/mo_openid_gdpr.php');
require('view/integration/mo_openid_integrate.php');
require('view/licensing_plans/mo_openid_lic_plans.php');
require('view/reports/mo_openid_reports.php');
require('view/link_social_account/mo_openid_Acclink.php');
require('view/premium_features/mo_openid_prem_feat.php');
require('view/privacy_policy/mo_openid_priv_pol.php');
require('view/profile_completion/mo_openid_prof_comp.php');
require('view/redirect_options/mo_openid_redirect_op.php');
require('view/registration/mo_openid_registration.php');
require('view/mailchimp/mo_openid_mailchimp.php');
require('view/buddypress/mo_openid_buddypress.php');
require('view/restrict_domain/mo_openid_restrict_dom.php');
require('view/shrtco/mo_openid_shrtco.php');
require('MO_WC_CustomerOpenID.php');
require('view/soc_sha/soc_apps/mo_openid_sharing.php');
require('view/soc_sha/share_cnt/mo_openid_shrcnt.php');
require('view/soc_sha/cust_text/mo_openid_cust_shricon.php');
require('view/soc_sha/disp_shropt/mo_openid_disp_shropt.php');
require('view/soc_sha/shrt_co/mo_openid_shrtco.php');
require('view/soc_com/com_Cust/mo_openid_comm_cust.php');
require('view/soc_com/com_display_options/mo_openid_comm_disp_opt.php');
require('view/soc_com/com_select_app/mo_openid_comm_select_app.php');
require('view/soc_com/com_Enable/mo_openid_comm_enable.php');
require('view/soc_com/com_shrtco/comm_shrtco.php');
include('view/add_on/custom_registration_form.php');

require('view/add_on/mo_woocommerce_add_on.php');
require('view/add_on/mo_mailchimp_add_on.php');
require('view/add_on/mo_buddypress_add_on.php');
require('view/add_on/mo_hubspot_add_on.php');

function mo_wc_register_openid() {
    if(!strpos($_SERVER['REQUEST_URI'], "mo_wc_openid_general_settings&tab=licensing_plans")) {
    ?>
    <div id="upgrade_notice" class="mo_wc_openid_notice mo_wc_openid_notice-warning" >
        <p style="font-size: larger"><b>Facebook Data Use Checkup:</b> If you are facing any sudden issues in your facebook application then kindly verify your app as per the latest Facebook policy
            <a href="https://plugins.miniorange.com/data-use-checkup-process-in-facebook-app-wordpress-social-login" target="_blank">here</a>.
        </p>
        <p><b>New SOCIAL SHARING PLUGIN </b>is available with attractive features.
            <a id="pricing" style="background: #FFA335;border-color: #FFA335;color: white;" class="button" href="<?php echo site_url().'/wp-admin/admin.php?page=mo_wc_openid_social_sharing_settings&tab=licensing_plans'; ?>"><?php echo mo_wc_sl('Upgrade Now');?></a>
        </p>
    </div>
    <?php
}
    if( sanitize_text_field(isset( $_GET[ 'tab' ])) && sanitize_text_field($_GET[ 'tab' ]) !== 'register' ) {
        $active_tab = sanitize_text_field($_GET[ 'tab' ]);
    } else {
        $active_tab = 'config_apps';
    }

    $start= strtotime(get_option('mo_openid_user_activation_date'));
    $end = strtotime(date('Y-m-d'));
    $days_between = ceil(abs($end - $start) / 86400 );
    if( $days_between > 3 && get_option('mo_wc_check_notice') =='1' ) {
            update_option('mo_wc_openid_rateus_activate', '1');
            update_option('mo_wc_check_notice','0');
    }
    if(get_option("mo_wc_openid_rateus_activate")=='1')
    {
    ?>
    <div class="notice notice-success" id="mo-wc-notice" style="min-height:120px">
        <a class="mo-wc-notice-close" href="javascript:" aria-label="Dismiss this Notice">
            <span class="dashicons dashicons-dismiss"></span> Dismiss
        </a>
        <img src="<?php echo plugin_dir_url(__FILE__);?>includes/images/miniOrange_logo.png" style="float:left; margin:10px 20px 10px 10px" width="100" /><p style="font-size:16px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We are glad you like the <strong>Ecommerce Social Login</strong>  plugin and have been using it.
            Will you like to rate us ?</p>
        <form>
            <fieldset class="mo-openid-star-back-rateus"  id="mo_openid_fieldset">
                   <span class="mo_openid_star-cb-group">
                        <input type="radio" id="mo_openid_rating-5" name="mo_openid_rating" value="5" onclick="window.open('https://wordpress.org/support/plugin/ecommerce-social-login-social-sharing-by-miniorange/reviews/?filter=5','_blank')";/><label for="mo_openid_rating-5">5</label>
                        <input type="radio" id="mo_openid_rating-4" name="mo_openid_rating" value="4" onclick="form_popup(4); " /><label for="mo_openid_rating-4">4</label>
                        <input type="radio" id="mo_openid_rating-3" name="mo_openid_rating" value="3" onclick="form_popup(3); " /><label for="mo_openid_rating-3">3</label>
                        <input type="radio" id="mo_openid_rating-2" name="mo_openid_rating" value="2" onclick="form_popup(2); " /><label for="mo_openid_rating-2">2</label>
                        <input type="radio" id="mo_openid_rating-1" name="mo_openid_rating" value="1" onclick="form_popup(1); " /><label for="mo_openid_rating-1">1</label>
                        <input type="radio" id="mo_openid_rating-0" name="mo_openid_rating" value="0" class="mo_openid_star-cb-clear" /><label for="mo_openid_rating-0">0</label>
                    </span>
            </fieldset>

        </form>
    </div>
    <div id="mo_openid_rateus_myModal" class="mo-wc-modal">
        <div class="mo-wc-modal-content" id="color_change" style="background-color: #FFFFFF">
            <div id="mo_openid_support_form_feedback" class="mo-support-form" style="display: none;" >
                <table style="width: 100%"><tr style="background-color: #0867b2"><td>
                            <span style="margin-top: 2%;margin-right: 2% color: #aaaaaa;float: right;font-size: 28px;font-weight: bold;" class="mo-wc-close">&times;</span>

                            <center><h2 style="color: #FFFFFF"><strong>RATING FORM</strong></h2></center></td></tr>
                </table>
                <div><br>
                    <form id="mo_openid_rateus_submit_form" method="post" action="">
                        <input type="hidden" name="option" value="mo_openid_rateus_query_option" />
                        <input type="hidden" name="mo_wc_openid_rateus_nonce" value="<?php echo wp_create_nonce('mo-wc-openid-rateus-nonce'); ?>"/>
                        <label style="margin-left: 4%">&nbsp;&nbsp; We would be glad to hear what you think : </label><br>
                        <input class="mo_openid_modal_rateus_style" type="email" style=" margin-left: 6%;width: 88%; border-bottom: 1px solid; border-bottom-color:#0867b2 " required placeholder="Enter your Email" name="mo_openid_rateus_email" value="<?php echo get_option("admin_email"); ?>">
                        <br>
                        <table style="margin-left: 5%; width: 91%;height: 30%">
                            <tr style="width: 50%">
                                <td>
                                    <textarea class="mo_openid_modal_rateus_style" id="subject" required name="mo_openid_rateus_query" onkeypress="mo_openid_valid_query(this)" onkeyup="mo_openid_valid_query(this)" onblur="mo_openid_valid_query(this)"  placeholder="Write something.." style="height:100%;width: 100%;border-bottom: 1px solid; border-bottom-color:#0867b2 "></textarea>
                                </td>
                            </tr>
                            <tr>
                                <br>
                            </tr>
                            <tr>
                                <td>
                                    <input class="button button-primary button-large" style="width: 35%" type="submit" name="submit" value="submit">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <script>
        jQuery(document).ready( function(event) {
            (function($) {
                $("#mo-wc-notice .mo-wc-notice-close").click(function(){
                    <?php update_option('mo_wc_openid_rateus_activate', '0');?>
                    jQuery("#mo-wc-notice").hide();
                });
                $(".mo-wc-close").click(function(){
                    jQuery("#mo_openid_rateus_myModal").hide();
                });
            })(jQuery);
        });

        function five_star() {
            jQuery("#mo_openid_rateus_myModal").hide();
            jQuery("#mo_openid_rating-5").prop('checked',false);

        }
        function form_popup(rating){
            jQuery.ajax({
                url: "<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                method: "POST", //request type,
                dataType: 'json',
                data: {
                    action: 'mo_openid_rating_given',
                    rating: rating,
                },
                success: function (result) {
                    jQuery("#mo_openid_support_form_feedback").show();
                    jQuery("#moOpenIdRateUs").hide();
                }
            });
            var modal = document.getElementById("mo_openid_support_form_feedback");
            var btn1 = document.getElementById("mo_openid_rating-1");
            var btn2 = document.getElementById("mo_openid_rating-2");
            var btn3 = document.getElementById("mo_openid_rating-3");
            var btn4 = document.getElementById("mo_openid_rating-4");
            //var btn= document.querySelectorAll("#mo_openid_rating-1, #mo_openid_rating-2, #mo_openid_rating-3, #mo_openid_rating-4");
            btn1.onclick = function() {
                modal.style.display ="block";
                jQuery("#mo_openid_rateus_myModal").show();
            }
            btn2.onclick = function() {
                modal.style.display ="block";
                jQuery("#mo_openid_rateus_myModal").show();
            }
            btn3.onclick = function() {
                modal.style.display ="block";
                jQuery("#mo_openid_rateus_myModal").show();
            }
            btn4.onclick = function() {
                modal.style.display ="block";
                jQuery("#mo_openid_rateus_myModal").show();
            }
            // jQuery("#mo_openid_support_form_feedback").show();
            //         jQuery("#moOpenIdRateUs").hide();
        }

        function asdf(asdf1) {
            var modal = document.getElementById("mo_openid_rateus_myModal");
            var btn = document.getElementById("mo_openid_rateus_modal");
            btn.onclick = function() {
                jQuery("#mo_openid_support_form_feedback").hide();
                jQuery("#mo_openid_rating-4").prop('checked',false);
                jQuery("#mo_openid_rating-3").prop('checked',false);
                jQuery("#mo_openid_rating-2").prop('checked',false);
                jQuery("#mo_openid_rating-1").prop('checked',false);
                jQuery("#mo_openid_rating-0").prop('checked',false);
                modal.style.display ="block";
                jQuery("#moOpenIdRateUs").show();

                var mo_openid_span = document.getElementsByClassName("mo-wc-close")[0];
                mo_openid_span.onclick = function() {
                    modal.style.display = "none";
                    window.onclick = function(event){
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                }
            }
        }
    </script>
    <?php
    if($active_tab == 'reports' )
    {
        ?>
        <br>
        <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" onclick="window.location='<?php echo site_url();?>'+'/wp-admin/admin.php?page=mo_wc_openid_general_settings'"><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
        <br>
        <div style="text-align:center; margin-top: 3%;"><h1>Login Reports</h1><h4>This feature is only available in the All-Inclusive Plan</h4></div>

        <?php
    }
    else if($active_tab == 'mo_openid_licensing_plans_tab' || $active_tab == 'licensing_plans'|| $active_tab == 'licensing_plans_add_on')
    {
    ?>
    <div style="text-align:center;"><h1>Social Login Plugin</h1></div>
    <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" onclick="window.location='<?php echo site_url();?>'+'/wp-admin/admin.php?page=mo_wc_openid_general_settings'" ><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
    <div style="text-align:center; color: rgb(233, 125, 104); margin-top: 55px; font-size: 23px"> You are currently on the premium version of the plugin <br> <br><span style="font-size: 20px; ">
                    <li style="color: dimgray; margin-top: 0px;list-style-type: none;">
                        <div class="mo_openid-quote">
                           <p>
                               <span onclick="void(0);" class="mo_openid-check-tooltip" style="font-size: 15px">Why should I upgrade?
                                <span class="mo_openid-info">
                                    <span class="mo_openid-pronounce">Why should I upgrade to All-Inclusive plugin?</span>
                                    <span class="mo_openid-text">Upgrading lets you access all of features such as Report (Basic User Analysis), Custom registration add-on and all Social Sharing Feature.</span>
                                </span>
                            </span> </p>
                       </div>
                        <br><br>
                    </li>
    </div>
    <?php
}
else
{
    ?>
    <div>
        <table>
            <tr>
                <td><img id="logo" style="margin-top: 25px" src="<?php echo plugin_dir_url(__FILE__);?>includes/images/logo.png"></td>
                <td>&nbsp;<a style="text-decoration:none" href="https://plugins.miniorange.com/" target="_blank"><h1 style="color: #c9302c"><?php echo mo_wc_sl('Ecommerce Social Login');?>&nbsp;</h1></a></td>
                <td> <a id="privacy" style="margin-top: 23px" class="button" <?php echo $active_tab == 'privacy_policy' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'privacy_policy'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Privacy Policy');?></a></td>
                <td> <a id="faq" style="margin-top: 23px" class="button" <?php echo $active_tab == 'faq' ? 'nav-tab-active' : ''; ?> href="<?php echo add_query_arg( array('tab' => 'faq'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('FAQs');?></a></td>
                <td> <a id="addon" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button" <?php echo $active_tab == 'add_on' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Add On');?></a></td>
                <td> <a id="pricing" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'licensing_plans' ? 'nav-tab-active' : ''; ?>" onclick="my_cde()" href="<?php echo add_query_arg( array('tab' => 'licensing_plans'), $_SERVER['REQUEST_URI'] ); ?>" ><?php echo mo_wc_sl('Upgrade Now');?></a></td>
                <td> <a id="reports" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'reports' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'reports'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl("Reports");?></a></td>

                <td>
                    <button id="mo_openid_restart_gtour" style="margin-top: 23px;background: #0867B2;border-color: #0867B2;color: white; float: right" class="button" onclick="window.location= base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=config_apps';restart_tour()" value="Restart Tour"><?php echo mo_wc_sl('Restart Tour');?></button>
                </td>
            </tr>
        </table>
    </div>

    <div style="width: 100%" id="mo-main-content-div">
        <div id="mo_openid_menu_height" style="width: 15%; float: left; background-color: #32373C; border-radius: 15px 0px 0px 15px;">
            <div style="margin-top: 9px;border-bottom: 0px;text-align:center;">
                <div><img style="float:left;margin-left:8px;padding-top: 5px;" src="<?php echo plugins_url( 'includes/images/logo.png"', __FILE__ ); ?>"></div>
                <br>
                <span style="font-size:20px;color:white;float:left;"><?php echo mo_wc_sl('miniOrange');?></span>
            </div>
            <div class="mo_openid_tab" style="width:100%; border-radius: 0px 0px 0px 15px;">
                <a id="config_apps" class="tablinks<?php if($active_tab=="config_apps") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'config_apps'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Configure Apps');?></a>
                <a id="customise_social_icons" class="tablinks<?php if($active_tab=="customise_social_icons") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'customise_social_icons'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Customise Social Login Icons')?></a>
                <a id="disp_opt" class="tablinks<?php if($active_tab=="disp_opt") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'disp_opt'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Display Options');?></a>
                <a id="redirect_opt" class="tablinks<?php if($active_tab=="redirect_opt") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'redirect_opt'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Redirect Options');?></a>
                <a id="registration" class="tablinks<?php if($active_tab=="registration") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'registration'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Registration');?></a>
                <a id="woocommerce" class="tablinks<?php if($active_tab=="woocommerce") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'woocommerce'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Woocommerce');?></a>
                <a id="mailchimp" class="tablinks<?php if($active_tab=="mailchimp") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'mailchimp'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Mailchimp');?> <span class="mo-openid-premium"><?php echo mo_wc_sl('PRO');?></span></a>
                <a id="buddypress" class="tablinks<?php if($active_tab=="buddypress") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'buddypress'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Buddypress');?> <span class="mo-openid-premium"><?php echo mo_wc_sl('PRO');?></span></a>
                <a id="gdpr" class="tablinks<?php if($active_tab=="gdpr") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'gdpr'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('GDPR & Recaptcha');?> <span class="mo-openid-premium"><?php echo mo_wc_sl('PRO');?></span></a>
                <a id="domain_restriction" class="tablinks<?php if($active_tab=="domain_restriction") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'domain_restriction'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Domain Restriction');?><span class="mo-openid-premium"><?php echo mo_wc_sl('PRO');?></span></a>
                <a id="link_social_acc" class="tablinks<?php if($active_tab=="link_social_acc") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'link_social_acc'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Link Social Account');?><span class="mo-openid-premium"><?php echo mo_wc_sl('PRO');?></span></a>
                <a id="profile_completion" class="tablinks<?php if($active_tab=="profile_completion") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'profile_completion'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Profile Completion');?></a>
                <a id="email_settings" class="tablinks<?php if($active_tab=="email_settings") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'email_settings'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Email Notification');?><span class="mo-openid-premium"><?php echo mo_wc_sl('PRO');?></span></a>
                <a id="premium_features" class="tablinks<?php if($active_tab=="premium_features") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'premium_features'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Premium Features');?><span class="mo-openid-premium"><?php echo mo_wc_sl('PRO');?></span></a>
                <a id="shortcodes" class="tablinks<?php if($active_tab=="shortcodes") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'shortcodes'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Shortcodes');?></a>
                <a id="add_on" class="tablinks<?php if($active_tab=="add_on") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Add On');?></a>
                <a id="profile" class="tablinks<?php if($active_tab=="profile") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'profile'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('User Profile');?></a>
            </div>
        </div>
        <style>
            body {font-family: Arial, Helvetica, sans-serif;}
        </style>
        <div id="mo_openid_settings" style="width: 85%; float: right;">
            <div style="background-color: #FFFFFF;width: 90%;border-radius: 0px 15px 15px 0px;">
                <div class="mo_container">
                    <h3 id="mo_openid_page_heading" class="mo_openid_highlight" style="color: white;margin: 0;padding: 23px;border-radius: 0px 15px 0px 0px;">&nbsp</h3>
                    <div id="mo_openid_msgs"></div>
                    <table style="width:100%;">
                        <?php }
                        ?>
                        <tr>
                            <td style="vertical-align:top;">
                                <?php
                                switch ($active_tab){
                                    case 'licensing_plans':
                                        mo_wc_openid_licensing_plans();
                                        break;
                                    case 'reports':
                                        mo_openid_reports();
                                        break;
                                    case 'mailchimp':
                                        mo_wc_mailchimp_int();
                                        break;
                                    case 'buddypress':
                                        mo_wc_buddypress_int();
                                        break;
                                    case 'config_apps':
                                        mo_wc_openid_show_apps();
                                        break;
                                    case 'customise_social_icons':
                                        mo_wc_openid_customise_social_icons();
                                        break;
                                    case 'disp_opt':
                                        mo_wc_openid_disp_opt();
                                        break;
                                    case 'redirect_opt':
                                        mo_wc_openid_redirect_opt();
                                        break;
                                    case 'registration':
                                        mo_wc_openid_registration();
                                        break;
                                    case 'domain_restriction':
                                        mo_wc_openid_restrict_domain();
                                        break;
                                    case 'faq':
                                        mo_wc_openid_faq();
                                        break;
                                    case 'gdpr':
                                        mo_wc_openid_gdpr();
                                        break;
                                    case 'link_social_acc':
                                        mo_wc_openid_linkSocialAcc();
                                        break;
                                    case 'profile_completion':
                                        mo_wc_openid_profile_completion();
                                        break;
                                    case 'email_settings':
                                        mo_wc_openid_email_notification();
                                        break;
                                    case 'premium_features':
                                        mo_wc_openid_premium_features();
                                        break;
                                    case 'privacy_policy':
                                        mo_wc_openid_privacy_policy();
                                        break;
                                    case 'woocommerce':
                                        mo_wc_openid_integrations();
                                        break;
                                    case 'shortcodes':
                                        mo_wc_openid_login_shortcodes();
                                        break;
                                    case 'add_on':
                                        header('Location: '.site_url().'/wp-admin/admin.php?page=mo_wc_openid_settings_addOn');
                                        break;
                                    case  'profile':
                                        mo_wc_openid_profile();
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <input type="button" id="myBtn" class="support-help-button" data-show="false" onclick="mo_openid_support_form('')" value="<?php echo mo_wc_sl('NEED HELP'); ?>">
    </div>
    <?php include('view/support_form/miniorange_openid_support_form.php');?>
    <script>
        function my_cde(){
            <?php update_option('mo_openid_extension_tab',0); ?>
        }
        jQuery("#contact_us_phone").intlTelInput();
            function mo_openid_support_form(abc) {
                
                var def = "It seems that you have shown interest. Please elaborate more on your requirements.";
                if (abc == '' || abc == "undefined")
                    def = "Write your query here";

                //jQuery("#contact_us_phone").intlTelInput();
                var modal = document.getElementById("myModal");
                modal.style.display = "block";
                var btn = document.getElementById("myBtn");
                btn.style.display = "none";
                var span = document.getElementsByClassName("mo_support_close")[0];

                document.getElementById('mo_openid_support_msg').placeholder = def;
                document.getElementById("feature_plan").value= abc;
                span.onclick = function () {
                    modal.style.display = "none";
                    btn.style.display = "block";
                }
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        btn.style.display = "block";
                    }
                }
            }

        function wordpress_support() {
            window.open("https://wordpress.org/support/plugin/ecommerce-social-login-social-sharing-by-miniorange","_blank");
        }
        function faq_support(){
            window.open("https://faq.miniorange.com/kb/social-login", "_blank");
        }

        function mo_openid_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;

        }
    </script>
    <script>

        var base_url = '<?php echo site_url();?>';

        var new_tour1 = new Tour({
            name: "new_tour1",
            steps: [
                {
                    element: "#mo_openid_free_avail_apps",
                    title: "Available apps",
                    content: "Available social login apps.",
                    backdrop:'body',
                    backdropPadding:'6',
                },
                {
                    element: "#google",
                    title: "Enable social login apps",
                    content: "Configure your own custom apps for social login applications by clicking on any of the application box.",
                    backdrop:'body',
                    backdropPadding:'6',
                    onNext: function() {
                        getappsInLine('google');
                    }
                },
                {
                    element: "#mo_set_pre_config_app",
                    title: "Enable pre-configure app",
                    content: "If you don't want to set up your own app then enable pre configured app from here.",
                    backdrop:'body',
                    backdropPadding:'6',
                },
                {
                    element: "#mo_openid_cust_app_instructions",
                    title: "Configure your app",
                    content: "If you want to set up your own app then follow these instrutions.",
                    backdrop:'body',
                    backdropPadding:'6',
                },

                {
                    element: ".mo--openidapp-name",
                    title: "Set up custom app",
                    content: "Enter your App ID and Secret here.",
                    backdrop:'body',
                    backdropPadding:'6',
                    onNext: function() {
                        jQuery('#custom_app_div').hide();
                        jQuery(".mo-openid-sort-apps-move").css("background", "url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAAiCAYAAACuoaIwAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA+tpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTExIDc5LjE1ODMyNSwgMjAxNS8wOS8xMC0wMToxMDoyMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxNSAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDE4LTAxLTE3VDE1OjE4OjM5KzAxOjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAxOC0wMS0xN1QxNjoxMTo0MSswMTowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxOC0wMS0xN1QxNjoxMTo0MSswMTowMCIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjhCNkM3MkZGQjk4MTFFN0E4RDJBRUZBQTI4OUVBNzIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjhCNkM3MzBGQjk4MTFFN0E4RDJBRUZBQTI4OUVBNzIiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCOEI2QzcyREZCOTgxMUU3QThEMkFFRkFBMjg5RUE3MiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCOEI2QzcyRUZCOTgxMUU3QThEMkFFRkFBMjg5RUE3MiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Po8u91EAAABlSURBVHjaYvz//z8DvQATAx3BqGWjlg0ey1iIUKMDxHFQ9iIgvkKkHFk+AxnGD8VxJMhRHIyMZMoRbRkoeD4B8QcgXkiCHKZrRsvG0aQ/mvRHk/5o0h9N+qNJf9SyUcuoCAACDABr5TA7L7qpSQAAAABJRU5ErkJggg==')");
                    }
                },
                {
                    element: "#mo_openid_move_google",
                    title: "Change positions of login icons",
                    content: "You can change positions of social login icons by holding and dragging these 4 dots.",
                    backdrop:'body',
                    backdropPadding:'6',
                    onNext: function(){
                        window.location= base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=disp_opt';
                    }
                },
                {
                    element: "#mo_openid_disp_opt_tour",
                    // element: ".mo_openid_table_layout",
                    title: "Display options.",
                    content: "Select options where you want to display social login icons.",
                    backdrop:'body',
                    delay: 300,
                    backdropPadding:'6',
                    onNext: function() {
                        // e.preventDefault();
                        window.location = base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=licensing_plans'
                    }
                },{
                    element: "#pricing",
                    title: "Licensing Plans",
                    content: "Check out more features to choose the best plan for you.",
                    backdrop:'body',
                    delay:300,
                    backdropPadding:'6',
                }
            ],
            template: function () {
                var return_value;
                if(new_tour1.getCurrentStep()===7)
                    return_value="<div style='margin-top:2%;font-size: unset !important' class=\"mo_openid_popover\" role=\"tooltip\"> <div class=\"mo_openid_arrow\" ></div> <h3 class=\"mo_openid_popover-header\" style='margin-top: 0px'></h3> <div class=\"mo_openid_popover-body\"></div> <div class=\"mo_openid_popover-navigation\"> <div class=\"mo_openid_tour_btn-group\"><div style=\"width:47%;margin-top: -7%;\"><h4  style=\"float:left;margin-top:30%;margin-left:30%;\">"+ (new_tour1.getCurrentStep()+1)+"/8</h4></div></div>&nbsp;&nbsp; <button class=\"button button-primary button-large\" data-role=\"end\" onclick=\"end_new_tour1();\">Done</button> </div> </div>";
                else {
                    if(new_tour1.getCurrentStep()===6){
                        return_value = "" +
                            "<div style='width:13% !important;font-size: unset !important' class=\"mo_openid_popover\" role=\"tooltip\"> " +
                            "<div class=\"mo_openid_arrow\" ></div> " +
                            "<h3 class=\"mo_openid_popover-header\" style=\"margin-top:0px;\"></h3> " +
                            "<div class=\"mo_openid_popover-body\"></div> " +
                            "<div class=\"mo_openid_popover-navigation\"> " +
                            "<div class=\"mo_openid_tour_btn-group\" style=\"width: 100%;\"> " +
                            "<button class=\"mo_openid_tour_btn mo_openid_tour_btn-sm mo_openid_tour_btn-secondary mo_openid_tour_btn_next-success\" style=\"width: 54%;height: 0%;\" data-role=\"next\">Next &raquo;</button>&nbsp;&nbsp;" +
                            "<button class=\"mo_openid_tour_btn mo_openid_tour_btn-sm mo_openid_tour_btn-secondary mo_openid_tour_btn_next-success\" style=\"width: 54%;height: 0%;\" data-role=\"end\" onclick=\"end_new_tour1();\">Skip</button>" +
                            "<div style=\"width:47%;margin-top: -7%;\">" +
                            "<h4  style=\"float:right;margin-left: 53%;\">" + (new_tour1.getCurrentStep() + 1) + "/8</h4>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    }
                    else {
                        return_value = "" +
                            "<div style='font-size: unset !important' class=\"mo_openid_popover\" role=\"tooltip\"> " +
                            "<div class=\"mo_openid_arrow\" ></div> " +
                            "<h3 class=\"mo_openid_popover-header\" style=\"margin-top:0px;\"></h3> " +
                            "<div class=\"mo_openid_popover-body\"></div> " +
                            "<div class=\"mo_openid_popover-navigation\"> " +
                            "<div class=\"mo_openid_tour_btn-group\" style=\"width: 100%;\"> " +
                            "<button class=\"mo_openid_tour_btn mo_openid_tour_btn-sm mo_openid_tour_btn-secondary mo_openid_tour_btn_next-success\" style=\"width: 54%;height: 0%;\" data-role=\"next\">Next &raquo;</button>&nbsp;&nbsp;" +
                            "<button class=\"mo_openid_tour_btn mo_openid_tour_btn-sm mo_openid_tour_btn-secondary mo_openid_tour_btn_next-success\" style=\"width: 54%;height: 0%;\" data-role=\"end\" onclick=\"end_new_tour1();\">Skip</button>" +
                            "<div style=\"width:47%;margin-top: -7%;\">" +
                            "<h4  style=\"float:right;margin-left: 53%;\">" + (new_tour1.getCurrentStep() + 1) + "/8</h4>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    }
                }
                return (return_value);
            }
        });

        var temp = "<?php echo get_option('mo_openid_tour_new'); ?>";
        temp =0;
        if(temp=="0") { // Initialize the tour
            new_tour1.init();
            new_tour1.start();
        }
        function restart_tour() {
            window.location= base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=config_apps';
            new_tour1.restart();
        }

        function end_new_tour2(){

            var tour_variable = "plugin_tour";
            jQuery.ajax({
                url:base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=config_apps', //the page containing php script
                method: "POST", //request type,
                data: {update_tour_status: tour_variable},
                dataType: 'text',
                success:function(result){
                    window.location= base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=config_apps';
                }
            });
        }
        function end_new_tour1() {
            window.location= base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=config_apps';
        }



        var new_tour2 = new Tour({
            name: "new_tour2",
            steps: [
                {
                    element: "#mo_support_form",
                    title: "miniOrange Support",
                    content: "Feel free to reach out to us in case of any assistance.",
                    backdrop:'body',
                    backdropPadding:'6',
                    onshow: function() {
                        mo_openid_support_form('');
                    }
                },
            ],
            template: function () {
                return ("<div class=\"mo_openid_popover\" role=\"tooltip\"> <div class=\"mo_openid_arrow\" ></div> <h3 class=\"mo_openid_popover-header\" style=\"margin-top:0px;\"></h3> <div class=\"mo_openid_popover-body\"></div> <div class=\"mo_openid_popover-navigation\"> <div class=\"mo_openid_tour_btn-group\" style=\"width: 100%;\"><button class=\"button button-primary button-large\" data-role=\"end\"onclick='end_new_tour2();'>OK Got It</button></div></div></div>");
            }
        });
        var temp = "<?php echo get_option('mo_openid_tour_new'); ?>";
        if(temp=="0"&&new_tour1.ended()) {
            new_tour2.init();
            if(!new_tour2.ended()) {
				mo_openid_support_form('');
			}
            new_tour2.start();
        }


    </script>
    <?php

}

function mo_wc_register_sharing_openid()
{
    if (sanitize_text_field(isset($_GET['tab'])) && sanitize_text_field($_GET['tab']) !== 'register') {
        $active_tab = sanitize_text_field($_GET['tab']);
    } else {
        $active_tab = 'soc_apps';
    }
if($active_tab == 'reports' )
{
    ?>
    <br>
    <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" onclick="window.location='<?php echo site_url();?>'+'/wp-admin/admin.php?page=mo_wc_openid_general_settings'"><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
    <br>
    <div style="text-align:center; margin-top: 3%;"><h1>Login Reports</h1><h4>This feature is only available in the All-Inclusive Plan</h4></div>

    <?php
}
else if($active_tab == 'mo_openid_licensing_plans_tab' || $active_tab == 'licensing_plans'|| $active_tab == 'licensing_plans_add_on')
    {
        ?>
        <div style="text-align:center;"><h1>Social Login Plugin</h1></div>
        <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" href= <?php echo (isset($_COOKIE['extension_current_url']) ? $_COOKIE['extension_current_url']:site_url());?> ><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
        <div style="text-align:center; color: rgb(233, 125, 104); margin-top: 55px; font-size: 23px"> You are currently on the premium version of the plugin <br> <br><span style="font-size: 20px; ">
                    <li style="color: dimgray; margin-top: 0px;list-style-type: none;">
                        <div class="mo_openid-quote">
                           <p>
                               <span onclick="void(0);" class="mo_openid-check-tooltip" style="font-size: 15px">Why should I upgrade?
                                <span class="mo_openid-info">
                                    <span class="mo_openid-pronounce">Why should I upgrade to All-Inclusive plugin?</span>
                                    <span class="mo_openid-text">Upgrading lets you access all of features such as Report (Basic User Analysis), Custom registration add-on and all Social Sharing Feature.</span>
                                </span>
                            </span> </p>
                       </div>
                        <br><br>
                    </li>
        </div>
        <?php
    }
    else
    {
        ?>

    <div>
        <table>
            <tr>
                <td><img id="logo" style="margin-top: 25px"
                         src="<?php echo plugin_dir_url(__FILE__); ?>includes/images/logo.png"></td>
                <td>&nbsp;<a style="text-decoration:none" href="https://plugins.miniorange.com/"
                             target="_blank"><h1 style="color: #c9302c"><?php echo mo_wc_sl('miniOrange Social Login');?></h1></a></td>
                <td> <a id="privacy" style="margin-top: 23px" class="button" <?php echo $active_tab == 'privacy_policy' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'privacy_policy'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Privacy Policy');?></a></td>
                <td> <a id="faq" style="margin-top: 23px" class="button" <?php echo $active_tab == 'faq' ? 'nav-tab-active' : ''; ?> href="<?php echo add_query_arg( array('tab' => 'faq'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('FAQs');?></a></td>
                <td> <a id="addon" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button" <?php echo $active_tab == 'add_on' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Add On');?></a></td>
                <td> <a id="pricing" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'licensing_plans' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'licensing_plans'), $_SERVER['REQUEST_URI'] ); ?>" onclick="mo_openid_extension_switch()"><?php echo mo_wc_sl('Upgrade Now');?></a></td>
                <td> <a id="reports" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'reports' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'reports'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl("Reports");?></a></td>

                <td>
            </tr>
        </table>
    </div>
    <div style="width: 100%">

        <div style="width: 15%; float: left; background-color: #32373C; border-radius: 15px 0px 0px 15px;">
            <div style="height:54px;margin-top: 9px;border-bottom: 0px;text-align:center;">
                <div><img style="float:left;margin-left:8px;width: 43px;height: 45px;padding-top: 5px;"
                          src="<?php echo plugins_url('includes/images/logo.png"', __FILE__); ?>"></div>
                <br>
                <span style="font-size:20px;color:white;float:left;"><?php echo mo_wc_sl('miniOrange');?></span>
            </div>

            <div class="mo_openid_tab" style="min-height:395px;width:100%; height: 445px;border-radius: 0px 0px 0px 15px;">
                <a id="social_apps" class="tablinks<?php if ($active_tab == "soc_apps") echo '_active'; ?>"
                   href="<?php echo add_query_arg(array('tab' => 'soc_apps'), $_SERVER['REQUEST_URI']); ?>"><?php echo mo_wc_sl('Select
                    Social Apps');?></a>
                <a id="customization"
                   class="tablinks<?php if ($active_tab == "customization") echo '_active'; ?>"
                   href="<?php echo add_query_arg(array('tab' => 'customization'), $_SERVER['REQUEST_URI']); ?>"><?php echo mo_wc_sl('Customization');?>
                </a>
                <a id="share_cnt" class="tablinks<?php if ($active_tab == "share_cnt") echo '_active'; ?>"
                   href="<?php echo add_query_arg(array('tab' => 'share_cnt'), $_SERVER['REQUEST_URI']); ?>"><?php echo mo_wc_sl('Social
                    Share Counts');?></a>

                <a id="display_opt" class="tablinks<?php if ($active_tab == "display_opt") echo '_active'; ?>"
                   href="<?php echo add_query_arg(array('tab' => 'display_opt'), $_SERVER['REQUEST_URI']); ?>"><?php echo mo_wc_sl('Display
                    Option');?></a>
                <a id="short_code" class="tablinks<?php if ($active_tab == "short_code") echo '_active'; ?>"
                   href="<?php echo add_query_arg(array('tab' => 'short_code'), $_SERVER['REQUEST_URI']); ?>"><?php echo mo_wc_sl('Shortcodes');?></a>

            </div>
        </div>

        <div id="mo_openid_settings" style="width: 85%; float: right;">
            <div style="background-color: #FFFFFF;width: 90%;border-radius: 0px 15px 15px 0px;">
                <div class="mo_container">
                    <h3 id="mo_openid_page_heading" class="mo_openid_highlight" style="color: white;margin: 0;padding: 23px;border-radius: 0px 15px 0px 0px;">&nbsp</h3>
                    <div id="mo_openid_msgs"></div>
                    <table style="width:100%;">
                        <?php }
                    ?>
                        <tr>
                            <td style="vertical-align:top;">
                                <?php
                                switch ($active_tab) {
                                    case 'soc_apps':
                                        mo_wc_openid_share_apps();
                                        break;
                                    case 'share_cnt':
                                        mo_wc_openid_share_cnt();
                                        break;
                                    case 'customization':
                                        mo_wc_openid_customize_icons();
                                        break;
                                    case 'display_opt':
                                        mo_wc_openid_display_share_opt();
                                        break;
                                    case 'short_code':
                                        mo_wc_openid_short_code();
                                        break;
                                    case 'licensing_plans':
                                        mo_wc_openid_licensing_plans();
                                        break;
                                    case 'reports':
                                        mo_openid_reports();
                                        break;
                                    case 'faq':
                                        mo_wc_openid_faq();
                                        break;
                                    case 'privacy_policy':
                                        mo_wc_openid_privacy_policy();
                                        break;
                                    case 'add_on':
                                        header('Location: '.site_url().'/wp-admin/admin.php?page=mo_wc_openid_settings_addOn');
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <input type="button" id="myBtn" class="support-help-button" data-show="false" onclick="mo_openid_support_form('')" value="<?php echo mo_wc_sl('NEED HELP');?>">

    </div>
    <?php include('view/support_form/miniorange_openid_support_form.php');?>
    <script>
        function mo_openid_extension_switch(){
            var extension_url = window.location.href;
            var cookie_names = "extension_current_url";
            var d = new Date();
            d.setTime(d.getTime() + (2 * 24 * 60 * 60 * 1000));
            var expired = "expires="+d.toUTCString();
            document.cookie = cookie_names + "=" + extension_url + ";" + expired + ";path=/";
            <?php update_option('mo_openid_extension_tab','0');?>
        }
        jQuery("#contact_us_phone").intlTelInput();
        function mo_openid_support_form(abc) {
            jQuery("#contact_us_phone").intlTelInput();
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            var btn=document.getElementById("myBtn");
            btn.style.display="none";
            var span = document.getElementsByClassName("mo_support_close")[0];
            span.onclick = function () {
                modal.style.display = "none";
                btn.style.display="block";
            }
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    btn.style.display="block";
                }
            }
        }
        function wordpress_support() {
            window.open("https://wordpress.org/support/plugin/ecommerce-social-login-social-sharing-by-miniorange","_blank");

        }
        function faq_support(){
            window.open("https://faq.miniorange.com/kb/social-login", "_blank");
        }

        function mo_openid_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;

        }
    </script>
    <?php

}

function mo_wc_comment_openid() {
    if( sanitize_text_field(isset( $_GET[ 'tab' ])) && sanitize_text_field($_GET[ 'tab' ]) !== 'register' ) {
        $active_tab = sanitize_text_field($_GET[ 'tab' ]);
    } else {
        $active_tab = 'select_applications';
    }

if($active_tab == 'reports' )
{
    ?>
    <br>
    <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" onclick="window.location='<?php echo site_url();?>'+'/wp-admin/admin.php?page=mo_wc_openid_general_settings'"><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
    <br>
    <div style="text-align:center; margin-top: 3%;"><h1>Login Reports</h1><h4>This feature is only available in the All-Inclusive Plan</h4></div>

    <?php
}
else if($active_tab == 'mo_openid_licensing_plans_tab' || $active_tab == 'licensing_plans'|| $active_tab == 'licensing_plans_add_on')
    {
        ?>
        <div style="text-align:center;"><h1>Social Login Plugin</h1></div>
        <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" href= <?php echo (isset($_COOKIE['extension_current_url']) ? $_COOKIE['extension_current_url']:site_url());?> ><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
        <div style="text-align:center; color: rgb(233, 125, 104); margin-top: 55px; font-size: 23px"> You are currently on the premium version of the plugin <br> <br><span style="font-size: 20px; ">
                    <li style="color: dimgray; margin-top: 0px;list-style-type: none;">
                        <div class="mo_openid-quote">
                           <p>
                               <span onclick="void(0);" class="mo_openid-check-tooltip" style="font-size: 15px">Why should I upgrade?
                                <span class="mo_openid-info">
                                    <span class="mo_openid-pronounce">Why should I upgrade to All-Inclusive plugin?</span>
                                    <span class="mo_openid-text">Upgrading lets you access all of features such as Report (Basic User Analysis), Custom registration add-on and all Social Sharing Feature.</span>
                                </span>
                            </span> </p>
                       </div>
                        <br><br>
                    </li>
        </div>
        <?php
    }
    else
    {

    ?>
    <div>

            <table>
                <tr>
                    <td><img id="logo" style="margin-top: 25px"
                             src="<?php echo plugin_dir_url(__FILE__); ?>includes/images/logo.png"></td>
                    <td>&nbsp;<a style="text-decoration:none" href="https://plugins.miniorange.com/"
                                 target="_blank"><h1 style="color: #c9302c"><?php echo mo_wc_sl('miniOrange Social Login');?></h1></a></td>
                    <td> <a id="privacy" style="margin-top: 23px" class="button" <?php echo $active_tab == 'privacy_policy' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'privacy_policy'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Privacy Policy');?></a></td>
                    <td> <a id="faq" style="margin-top: 23px" class="button" <?php echo $active_tab == 'faq' ? 'nav-tab-active' : ''; ?> href="<?php echo add_query_arg( array('tab' => 'faq'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('FAQs');?></a></td>
                    <td> <a id="addon" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button" <?php echo $active_tab == 'add_on' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Add On');?></a></td>
                    <td> <a id="pricing" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'licensing_plans' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'licensing_plans'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Upgrade Now');?></a></td>
                    <td> <a id="reports" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'reports' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'reports'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl("Reports");?></a></td>

                    <td>
                </tr>
            </table>

    </div>
    <div style="width: 100%">

        <div style="width: 15%; float: left; background-color: #32373C; border-radius: 15px 0px 0px 15px;">
            <div style="height:54px;margin-top: 9px;border-bottom: 0px;text-align:center;">
                <div><img style="float:left;margin-left:8px;width: 43px;height: 45px;padding-top: 5px;" src="<?php echo plugins_url( 'includes/images/logo.png"', __FILE__ ); ?>"></div>
                <br>
                <span style="font-size:20px;color:white;float:left;"><?php echo mo_wc_sl('miniOrange');?></span>
            </div>
            <div class="mo_openid_tab" style="min-height:395px;width:100%; height: 445px;border-radius: 0px 0px 0px 15px;">
                <a id="select_applications" class="tablinks<?php if($active_tab=="select_applications") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'select_applications'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Select Applications');?></a>
                <a id="display_options" class="tablinks<?php if($active_tab=="display_options") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'display_options'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Display options');?></a>
                <a id="customize_text" class="tablinks<?php if($active_tab=="customize_text") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'customize_text'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Customization');?></a>
                <a id="enable_comment" class="tablinks<?php if($active_tab=="enable_comment") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'enable_comment'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Enable and Add Social Comments');?></a>
                <a id="comment_shortcode" class="tablinks<?php if($active_tab=="comment_shortcode") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'comment_shortcode'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Shortcodes');?></a>



            </div>
        </div>

        <div id="mo_openid_settings" style="width: 85%; float: right;">
            <div style="background-color: #FFFFFF;width: 90%;border-radius: 0px 15px 15px 0px;">
                <div class="mo_container">
                    <h3 id="mo_openid_page_heading" class="mo_openid_highlight" style="color: white;margin: 0;padding: 23px;border-radius: 0px 15px 0px 0px;">&nbsp</h3>
                    <div id="mo_openid_msgs"></div>
                    <table style="width:100%;">
                        <?php }
                        ?>
                        <tr>
                            <td style="vertical-align:top;">
                                <?php
                                switch ($active_tab) {
                                    case 'select_applications':
                                        mo_wc_select_comment_app();
                                        break;
                                    case 'display_options':
                                        mo_wc_select_comment_disp();
                                        break;
                                    case 'customize_text':
                                        mo_wc_select_comment_customize();
                                        break;
                                    case 'enable_comment':
                                        mo_wc_select_comment_enable();
                                        break;
                                    case 'comment_shortcode':
                                        mo_wc_select_comment_shortcode();
                                        break;
                                    case 'licensing_plans':
                                        mo_wc_openid_licensing_plans();
                                        break;
                                    case 'reports':
                                        mo_openid_reports();
                                        break;
                                    case 'faq':
                                        mo_wc_openid_faq();
                                        break;
                                    case 'privacy_policy':
                                        mo_wc_openid_privacy_policy();
                                        break;
                                    case 'add_on':
                                        header('Location: '.site_url().'/wp-admin/admin.php?page=mo_wc_openid_settings_addOn');
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


        </div></div>
    <input type="button" id="myBtn" class="support-help-button" data-show="false" onclick="mo_openid_support_form('')" value="<?php echo mo_wc_sl('NEED HELP');?>">

    <?php include('view/support_form/miniorange_openid_support_form.php');?>
    <script>
        function moSharingSizeValidate(e){
            var t=parseInt(e.value.trim());t>60?e.value=60:10>t&&(e.value=10)
        }
        function moSharingSpaceValidate(e){
            var t=parseInt(e.value.trim());t>50?e.value=50:0>t&&(e.value=0)
        }
        function moLoginSizeValidate(e){
            var t=parseInt(e.value.trim());t>60?e.value=60:20>t&&(e.value=20)
        }
        function moLoginSpaceValidate(e){
            var t=parseInt(e.value.trim());t>60?e.value=60:0>t&&(e.value=0)
        }
        function moLoginWidthValidate(e){
            var t=parseInt(e.value.trim());t>1000?e.value=1000:140>t&&(e.value=140)
        }
        function moLoginHeightValidate(e){
            var t=parseInt(e.value.trim());t>50?e.value=50:35>t&&(e.value=35)
        }
        jQuery(document).ready(function(){
            sel = jQuery(".mo_support_input_container");
            sel.each(function(){
                if(jQuery(this).find(".mo_support_input").val() !== "")
                    jQuery(this).addClass("mo_has_value");
            });
            sel.focusout( function(){
                if(jQuery(this).find(".mo_support_input").val() !== "")
                    jQuery(this).addClass("mo_has_value");
                else jQuery(this).removeClass("mo_has_value");
            });
        });
    </script>

    <script>
        jQuery("#contact_us_phone").intlTelInput();
        function mo_openid_support_form(abc) {
            jQuery("#contact_us_phone").intlTelInput();
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            var btn=document.getElementById("myBtn");
            btn.style.display="none";
            var span = document.getElementsByClassName("mo_support_close")[0];
            span.onclick = function () {
                modal.style.display = "none";
                btn.style.display="block";
            }
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    btn.style.display="block";
                }
            }
        }
        function wordpress_support() {
            window.open("https://wordpress.org/support/plugin/ecommerce-social-login-social-sharing-by-miniorange","_blank");

        }
        function faq_support(){
            window.open("https://faq.miniorange.com/kb/social-login", "_blank");
        }

        function mo_openid_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;

        }
    </script>

    <?php

}

function mo_wc_openid_addon_desc_page() {
    if( isset( $_GET[ 'tab' ]) && $_GET[ 'tab' ] !== 'register' ) {
        $active_tab = $_GET[ 'tab' ];
    }
    elseif (isset($_REQUEST) && $_REQUEST['page'] == 'mo_openid_settings_addOn')
        $active_tab = 'custom_registration_form';
    elseif (isset($_REQUEST) && $_REQUEST['page'] == 'mo_openid_woocommerce_add_on')
        $active_tab = 'mo_woocommerce_add_on';
    elseif (isset($_REQUEST) && $_REQUEST['page'] == 'mo_openid_mailchimp_add_on')
        $active_tab = 'mo_mailchimp_add_on';
    elseif (isset($_REQUEST) && $_REQUEST['page'] == 'mo_openid_buddypress_add_on')
        $active_tab = 'mo_buddypress_add_on';
    elseif (isset($_REQUEST) && $_REQUEST['page'] == 'mo_openid_hubspot_add_on')
        $active_tab = 'mo_hubspot_add_on';
    else {
        $active_tab = 'custom_registration_form';
    }
if($active_tab == 'reports' )
{
    ?>
    <br>
    <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" onclick="window.location='<?php echo site_url();?>'+'/wp-admin/admin.php?page=mo_wc_openid_general_settings'"><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
    <br>
    <div style="text-align:center; margin-top: 3%;"><h1>Login Reports</h1><h4>This feature is only available in the All-Inclusive Plan</h4></div>

    <?php
}
else if($active_tab == 'mo_openid_licensing_plans_tab' || $active_tab == 'licensing_plans'|| $active_tab == 'licensing_plans_add_on')
    {
        ?>
        <div style="text-align:center;"><h1>Social Login Plugin</h1></div>
        <div><a style="margin-top: 0px;background: #d0d0d0;border-color: #1162b5;color: #151515; float: left" class="button" href= <?php echo (isset($_COOKIE['extension_current_url']) ? $_COOKIE['extension_current_url']:site_url());?> ><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: middle;"></span><b style="font-size: 15px;"> &nbsp;&nbsp;Back To Plugin Configuration</b></a></div>
        <div style="text-align:center; color: rgb(233, 125, 104); margin-top: 55px; font-size: 23px"> You are currently on the premium version of the plugin <br> <br><span style="font-size: 20px; ">
                    <li style="color: dimgray; margin-top: 0px;list-style-type: none;">
                        <div class="mo_openid-quote">
                           <p>
                               <span onclick="void(0);" class="mo_openid-check-tooltip" style="font-size: 15px">Why should I upgrade?
                                <span class="mo_openid-info">
                                    <span class="mo_openid-pronounce">Why should I upgrade to All-Inclusive plugin?</span>
                                    <span class="mo_openid-text">Upgrading lets you access all of features such as Report (Basic User Analysis), Custom registration add-on and all Social Sharing Feature.</span>
                                </span>
                            </span> </p>
                       </div>
                        <br><br>
                    </li>
        </div>
        <?php
    }
    else
    {

    ?>
    <div>
        <table>
            <tr>
                <td><img id="logo" style="margin-top: 25px" src="<?php echo plugin_dir_url(__FILE__);?>includes/images/logo.png"></td>
                <td>&nbsp;<a style="text-decoration:none" href="https://plugins.miniorange.com/" target="_blank"><h1 style="color: #c9302c"><?php echo mo_wc_sl('miniOrange Social Login');?> &nbsp;</h1></a></td>
                <td> <a id="privacy" style="margin-top: 23px" class="button" <?php echo $active_tab == 'privacy_policy' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'privacy_policy'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Privacy Policy');?></a></td>
                <td> <a id="faq" style="margin-top: 23px" class="button" <?php echo $active_tab == 'faq' ? 'nav-tab-active' : ''; ?> href="<?php echo add_query_arg( array('tab' => 'faq'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('FAQs');?></a></td>
                <td> <a id="mo_openid_go_back" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'mo_openid_go_back' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'mo_openid_go_back'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Social Login');?></a></td>
                <td> <a id="pricing" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'licensing_plans' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'licensing_plans'), $_SERVER['REQUEST_URI'] ); ?>" onclick="mo_openid_extension_switch()"><?php echo mo_wc_sl('Upgrade Now');?></a></td>
                <td> <a id="reports" style="margin-top: 23px;background: #FFA335;border-color: #FFA335;color: white;" class="button"<?php echo $active_tab == 'reports' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'reports'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl("Reports");?></a></td>

            </tr>
        </table>
    </div>
    <div style="width: 100%">

        <div style="width: 15%; float: left; background-color: #32373C; border-radius: 15px 0px 0px 15px;">
            <div style="height:54px;margin-top: 9px;border-bottom: 0px;text-align:center;">
                <div><img style="float:left;margin-left:8px;width: 43px;height: 45px;padding-top: 5px;" src="<?php echo plugin_dir_url(__FILE__);?>includes/images/logo.png"></div>
                <br>
                <span style="font-size:20px;color:white;float:left;"><?php echo mo_wc_sl('miniOrange');?></span>
            </div>
            <div class="mo_openid_tab" style="min-height:395px;width:100%; height: 445px;border-radius: 0px 0px 0px 15px;">
                <a id="custom_registration_form" class="tablinks<?php if($active_tab=="custom_registration_form") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'custom_registration_form'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Custom Registration Form');?></a>
                <a id="mo_woocommerce_add_on" class="tablinks<?php if($active_tab=="mo_woocommerce_add_on") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'mo_woocommerce_add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('WooCommerce Add on');?></a>
                <a id="mo_buddypress_add_on" class="tablinks<?php if($active_tab=="mo_buddypress_add_on") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'mo_buddypress_add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('BuddyPress Add on');?></a>
                <a id="mo_mailchimp_add_on" class="tablinks<?php if($active_tab=="mo_mailchimp_add_on") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'mo_mailchimp_add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('MailChimp Add on');?></a>
                <a id="mo_hubspot_add_on" class="tablinks<?php if($active_tab=="mo_hubspot_add_on") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'mo_hubspot_add_on'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('HubSpot Add on');?></a>

                <a id="mo_openid_go_back" class="tablinks<?php if($active_tab=="mo_openid_go_back") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'mo_openid_go_back'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Go to Social Login');?></a>
                <a id="mo_openid_licensing_plans_tab" class="tablinks<?php if($active_tab=="mo_openid_licensing_plans_tab") echo '_active';?>" href="<?php echo add_query_arg( array('tab' => 'mo_openid_licensing_plans_tab'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('Licensing Plans');?></a>
            </div>
        </div>
        <div id="mo_openid_settings" style="width: 85%; float: right;">
            <div style="background-color: #FFFFFF;width: 90%;border-radius: 0px 15px 15px 0px;">
                <div class="mo_container">
                    <h3 id="mo_openid_page_heading" class="mo_openid_highlight" style="color: white;margin: 0;padding: 23px;border-radius: 0px 15px 0px 0px;">&nbsp</h3>
                    <div id="mo_openid_msgs"></div>
                    <table style="width:100%;">
                        <?php }
    ?>
                        <tr>
                            <td style="vertical-align:top;">
                                <?php
                                switch ($active_tab){
                                    case 'mo_openid_licensing_plans_tab':
                                    case 'licensing_plans':
                                        mo_wc_openid_licensing_plans();
                                        break;
                                    case 'privacy_policy':
                                        mo_wc_openid_privacy_policy();
                                        break;
                                    case 'reports':
                                        mo_openid_reports();
                                        break;
                                    case 'faq':
                                        mo_wc_openid_faq();
                                        break;
                                    case 'custom_registration_form':
                                        if(mo_wc_openid_is_customer_addon_license_key_verified()) {
                                            if(is_plugin_active('miniorange-login-openid-extra-attributes-addon/miniorange_openid_sso_customization_addon.php'))
                                                do_action('customization_addon');
                                            else {
                                                $addon_message_type = 'Extra Attribute Addon';
                                                mo_wc_openid_show_addon_message_page($addon_message_type);
                                            }
                                        }
                                        else
                                            mo_wc_openid_custom_registration_form();
                                        break;
                                    case 'mo_woocommerce_add_on':
                                        if(mo_wc_openid_is_wca_license_key_verified()) {
                                            if (is_plugin_active('miniorange-login-openid-woocommerce-addon/miniorange_openid_woocommerce_integration_addon.php')) {
                                                do_action('mo_wc_addon');
                                            }
                                            else {
                                                $addon_message_type = 'WooCommerce Addon';
                                                mo_wc_openid_show_addon_message_page($addon_message_type);
                                            }
                                        }
                                        else
                                            mo_openid_woocommerce_add_on();
                                        break;
                                    case 'mo_mailchimp_add_on':
                                        if(mo_wc_openid_is_mailc_license_key_verified()) {
                                            if (is_plugin_active('miniorange-login-openid-mailchimp-addon/miniorange_openid_mailchimp_addon.php')) {
                                                do_action('mo_mailchimp_addon');
                                            }
                                            else {
                                                $addon_message_type = 'MailChimp Addon';
                                                mo_wc_openid_show_addon_message_page($addon_message_type);
                                            }
                                        }
                                        else
                                            mo_openid_mailchimp_add_on();
                                        break;
                                    case 'mo_buddypress_add_on':
                                        if(mo_wc_openid_is_bpp_license_key_verified()) {
                                            if (is_plugin_active('miniorange-login-openid-buddypress-addon/mo_openid_buddypress_display_addon.php')) {
                                                do_action('buddypress_integration_addon');
                                            }
                                            else {
                                                $addon_message_type = 'BuddyPress Addon';
                                                mo_wc_openid_show_addon_message_page($addon_message_type);
                                            }
                                        }
                                        else
                                            mo_openid_buddypress_addon_display();
                                        break;
                                    case 'mo_hubspot_add_on':
                                        if(mo_wc_openid_is_hub_license_key_verified()) {
                                            if (is_plugin_active('miniorange-login-openid-hubspot-addon/mo_openid_hubspot_integration.php')) {
                                                do_action('hubspot_integration_addon');
                                            }
                                            else {
                                                $addon_message_type = 'HubSpot Addon';
                                                mo_wc_openid_show_addon_message_page($addon_message_type);
                                            }
                                        }
                                        else
                                            mo_openid_hubspot_add_on_display();
                                        break;
                                        case 'mo_openid_go_back':
                                        header('Location: '.site_url().'/wp-admin/admin.php?page=mo_wc_openid_general_settings');
                                        break;

                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <input type="button" id="myBtn" class="support-help-button" data-show="false" onclick="mo_openid_support_form('')" value="<?php echo mo_wc_sl('NEED HELP');?>">
    </div>
    <?php include('view/support_form/miniorange_openid_support_form.php');?>
    <script>
        function mo_openid_extension_switch(){
            var extension_url = window.location.href;
            var cookie_names = "extension_current_url";
            var d = new Date();
            d.setTime(d.getTime() + (2 * 24 * 60 * 60 * 1000));
            var expired = "expires="+d.toUTCString();
            document.cookie = cookie_names + "=" + extension_url + ";" + expired + ";path=/";

            <?php update_option('mo_openid_extension_tab','1');?>
        }
        jQuery("#contact_us_phone").intlTelInput();
        function mo_openid_support_form(abc) {
            jQuery("#contact_us_phone").intlTelInput();
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            var btn=document.getElementById("myBtn");
            btn.style.display="none";
            var span = document.getElementsByClassName("mo_support_close")[0];
            span.onclick = function () {
                modal.style.display = "none";
                btn.style.display="block";
            }
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    btn.style.display="block";
                }
            }
        }
        function wordpress_support() {
            window.open("https://wordpress.org/support/plugin/ecommerce-social-login-social-sharing-by-miniorange","_blank");

        }
        function faq_support(){
            window.open("https://faq.miniorange.com/kb/social-login", "_blank");
        }

        function mo_openid_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;

        }
    </script>
    <?php

}

