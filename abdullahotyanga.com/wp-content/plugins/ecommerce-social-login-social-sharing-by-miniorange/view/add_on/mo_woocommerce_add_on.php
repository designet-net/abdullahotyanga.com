<?php

function mo_openid_woocommerce_add_on()
{?>
    <div class="mo_openid_table_layout" id="wca_adv_disp" style="display: block">
        <table>
            <tr>
                <td >
                    <h3><?php echo mo_wc_sl('Woocommerce Add On');?>
                        <input type="button" value="<?php echo mo_wc_sl('Purchase');?>"
                               onclick="mosocial_addonform('wp_social_login_woocommerce_addon')"
                               id="mosocial_purchase_wca"
                               class="button button-primary button-large"
                               style="float: right; margin-left: 10px;">
                        <input type="button" value="<?php echo mo_wc_sl('Verify Key');?>"
                               id="mosocial_purchase_wca_verify"
                               class="button button-primary button-large"
                               style="float: right;">
                    </h3>
                    <b><?php echo mo_wc_sl('Woocommerce Add-On gives you Woocommerce Display Options and Woocommerce Integration. 
                    Using Woocommerce Display Options you can display Social Login buttons on Woocommerce pages. 
                    Woocommerce Integration prefills details of a user in the billing and checkout fields.');?>.</b>
                </td>
            </tr>
        </table>

        <table class="mo_openid_display_table table" id="mo_openid_wca_video">
            <tr>
                <td colspan="2">
                    <hr>
                    <p>
                        <br><center>
                        <iframe width="450" height="250" src="https://www.youtube.com/embed/M20AR-wbKNI"
                                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen
                                style=""></iframe></center>
                    </p>
                </td>
            </tr>
        </table>


        <br>
        <div class="mo_openid_highlight">
            <h3 style="margin-left: 2%;line-height: 210%;color: white;"><?php echo mo_wc_sl('Woocommerce Display Options');?></h3>
        </div>
        <br>

        <form id="wa_display" name="wa_display" method="post" action="">
            <div class="mo_openid_wca_table_layout_fake" style="height: 1450px"><br/>
                <div style="width:40%; background:white; float:left; border: 1px transparent;">
                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <input type="checkbox" id="woocommerce_before_login_form" name="mo_openid_woocommerce_before_login_form" <?php checked( get_option('mo_openid_woocommerce_before_login_form') == 1 );?> />
                        <div style="padding-left: 7%">
                            <?php echo mo_wc_sl("Before WooCommerce Login Form");?>
                        </div>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <br>
                            <img class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/1_before_login.png'; ?>">
                        </div>
                    </label>
                    <br>
                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <input type="checkbox" id="woocommerce_center_login_form" name="mo_openid_woocommerce_center_login_form" <?php checked( get_option('mo_openid_woocommerce_center_login_form') == 1 );?> />
                        <div style="padding-left: 7%">
                            <?php echo mo_wc_sl("Before 'Remember Me' of WooCommerce Login Form");?>
                        </div>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <br>
                            <img class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/2_login.png';?>">
                        </div>
                    </label>
                    <br>
                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <div style="padding-left: 7%">
                        <?php echo mo_wc_sl('After WooCommerce Login Form');?>
                        </div>
                        <input type="checkbox"  /><br>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <br>
                            <img class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/3_after_login.png';?>">
                        </div>
                    </label>

                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <div style="padding-left: 7%">
                        <?php echo mo_wc_sl('Before WooCommerce Registration Form');?>
                        </div>

                        <input type="checkbox"  /><br>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <br>
                            <img class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/4_before_reg.png';?>">
                        </div>
                    </label>
                </div>
                <div style="width:50%; background:white; float:right; border: 1px transparent;">
                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <div style="padding-left: 7%">
                        <?php echo mo_wc_sl("Before 'Register button' of WooCommerce Registration Form");?>
                        </div>
                        <input type="checkbox"  /><br>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <img class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/5_in_reg.png';?>">
                        </div>
                    </label>

                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <div style="padding-left: 7%">
                        <?php echo mo_wc_sl('After WooCommerce Registration Form');?>
                        </div>
                        <input type="checkbox"  /><br>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <img class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/6_after_reg.png';?>">
                        </div>
                    </label>

                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <div style="padding-left: 7%">
                        <?php echo mo_wc_sl('Before WooCommerce Checkout Form');?>
                        </div>
                        <input type="checkbox"  /><br>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <br>
                            <img  class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/7_before_checkout.png';?>">
                        </div>
                    </label>

                    <label style="padding-left: 0px;" class="mo_openid_checkbox_container_disable">
                        <div style="padding-left: 7%">
                        <?php echo mo_wc_sl('After WooCommerce Checkout Form');?>
                        </div>
                        <input type="checkbox"  /><br>
                        <span class="mo_openid_checkbox_checkmark_disable"></span>
                        <div class="mo_openid_wca_box">
                            <br>
                            <img class="mo_openid_wca_images" src="<?php echo plugin_dir_url(dirname(__DIR__)) . 'includes/images/wca/8_after_checkout.png';?>">
                        </div>
                    </label>
                </div>
            </div>
            <br>
            <input style="width: 126px;margin-left: 2%" disabled type="button" value="<?php echo mo_wc_sl('Save');?> "  class="button button-primary button-large" />
            <br>
        </form>

        <br><br><br>

        <form>
            <br>
            <div class="mo_openid_highlight">
                <h3 style="margin-left: 2%;line-height: 210%;color: white;"><?php echo mo_wc_sl('Woocommerce Integration');?></h3>
            </div>
            <table id="woocommerce_integration"><tr><td>
                        <p><b><?php echo mo_wc_sl('WooCommerce Integration pre-fills the first name, last name and email in Billing Details on the WooCommerce Checkout Page.');?></b></p>
                        <label class="mo_openid_checkbox_container_disable"><strong><?php echo mo_wc_sl('Sync Woocommerce checkout fields');?></strong>
                            <input  type="checkbox"/>
                            <span class="mo_openid_checkbox_checkmark_disable"></span>
                        </label>

                        <br>
                        <img class="mo_openid_wcai_images" src="<?php echo plugin_dir_url(dirname(__DIR__))  . 'includes/images/wca/wcai.png';?>">
                        <br>

                        <input style="width: 126px;" disabled type="button" value="<?php echo mo_wc_sl('Save');?>" class="button button-primary button-large" />
                        <br>

                        <label class="mo_openid_note_style" style="cursor: auto">For more information please refer to the <a href="https://plugins.miniorange.com/guide-to-configure-woocommerce-with-wordpress-social-login" target="_blank">WooCommerce Guide</a>  /  <a href="https://youtu.be/M20AR-wbKNI" target="_blank">WooCommerce Video</a></label>


                    </td></tr></table>
        </form>

    </div>
    <td>
        <form style="display:none;" id="mosocial_loginform" action="<?php echo get_option( 'mo_openid_host_name' ) . '/moas/login'; ?>"
              target="_blank" method="post" >
            <input type="email" name="username" value="<?php echo esc_attr(get_option('mo_openid_admin_email')); ?>" />
            <input type="text" name="redirectUrl" value="<?php echo esc_attr(get_option( 'mo_openid_host_name')).'/moas/initializepayment'; ?>" />
            <input type="text" name="requestOrigin" id="requestOrigin"/>
        </form>
        <script>
            function mosocial_addonform(planType) {
                jQuery('#requestOrigin').val(planType);
                jQuery('#mosocial_loginform').submit();
            }
        </script>
    </td>
    <td>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script type="text/javascript">
            //to set heading name
            jQuery('#mo_openid_page_heading').text('<?php echo mo_wc_sl('Woocommerce Add On'); ?>');
            jQuery(document).ready(function($){
                jQuery("#mosocial_purchase_wca_verify").on("click",function(){
                    jQuery.ajax({
                        url: "<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                        method: "POST", //request type,
                        dataType: 'json',
                        data: {
                            action: 'mo_register_customer_toggle_update',
                        },
                        success: function (result){
                            if (result.status){
                                mo_verify_add_on_license_key();
                            }
                            else{
                                alert("Please register/login with miniOrange to verify key and use the Custom Registration Form Add on");
                                window.location.href="<?php echo site_url()?>".concat("/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=profile");
                            }
                        }
                    });
                });
            });

            function mo_verify_add_on_license_key() {
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        action:'verify_addon_licience',
                        plan_name: 'WP_SOCIAL_LOGIN_WOOCOMMERCE_ADDON',
                    },
                    crossDomain :!0, dataType:"html",
                    success: function(data) {
                        var flag=0;
                        jQuery("input").each(function(){
                            if(jQuery(this).val()=="mo_openid_verify_license") flag=1;
                        });
                        if(!flag) {
                            jQuery(data).insertBefore("#mo_openid_wca_video");
                            jQuery("#customization_ins").find(jQuery("#cust_supp")).css("display", "none");
                        }
                    },
                    error: function (data){}
                });
            }
        </script>
    </td>
    <?php
}