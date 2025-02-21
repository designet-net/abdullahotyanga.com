<?php
function mo_openid_mailchimp_add_on()
{ ?>
    <script>
        //to set heading name
        jQuery('#mo_openid_page_heading').text('<?php echo mo_wc_sl("Mailchimp Add On");?>');
    </script>
    <div class="mo_openid_table_layout" id="customization_ins" style="display: block">
        <table>
            <tr>
                <td>
                    <h3><?php echo mo_wc_sl('MailChimp Add On');?>
                        <input type="button" value="<?php echo mo_wc_sl('Purchase');?>"
                               onclick="mosocial_addonform('wp_social_login_mailchimp_addon')"
                               id="mosocial_purchase_mail_addon"
                               class="button button-primary button-large"
                               style="float: right; margin-left: 10px;">
                        <input type="button" value="<?php echo mo_wc_sl('Verify Key');?>"
                               id="mosocial_purchase_mail_addon_verify"
                               class="button button-primary button-large"
                               style="float: right;">
                    </h3>
                    <b><?php echo mo_wc_sl('Mailchimp Add-On helps you to integrate details of new as well as existing users. Mailchimp helps to Engage your audience with beautiful, branded emails. Design landing pages that grow your audience and help you sell more stuff');?>.</b>
                </td>
            </tr>
        </table>
        <table class="mo_openid_display_table table" id="mo_openid_mailchimp_video"></table>
        <br>
        <hr>
        <form>
            <table><tr><td>
                        <p><b><?php echo mo_wc_sl("A user is added as a subscriber to a mailing list in MailChimp when that user registers using social login. First name, last name and email are also captured for that user in the Mailing List.</b></p>
                        (List ID in MailChimp : Lists -> Select your List -> Settings -> List Name and Defaults -> List ID) <br>
                        (API Key in MailChimp : Profile -> Extras -> API Keys -> Your API Key");?> )<br><br>
                                <b><?php echo mo_wc_sl("List Id");?>:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size="50" class="mo_openid_textfield_css" style="border: 1px solid ;border-color: #0867b2;width:43%" type="text" disabled="disabled" > <br><br>
                                <b><?php echo mo_wc_sl("API Key");?>: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size="50" class="mo_openid_textfield_css" style="border: 1px solid ;border-color: #0867b2;width:43%" type="text" disabled="disabled" ><br><br>
                                <label class="mo_openid_checkbox_container_disable"><strong><?php echo mo_wc_sl("User's Choice");?></strong>
                                    <input type="checkbox" />
                                    <span class="mo_openid_checkbox_checkmark"></span>
                                </label>
                                <strong><?php echo mo_wc_sl("Ask user for permission to be added in MailChimp Subscriber list");?> </strong>
                                <br><?php echo mo_wc_sl("(If unchecked, user will get subscribed during registration.)");?>
                                <br><h3 style="float: left">Edit MailChimp subscription form </h3>
                                <img src="<?php echo plugin_dir_url(dirname(__DIR__));?>includes/images/demo_mailchimp.png">
                                <br><br>
                                <b><?php echo mo_wc_sl("Click on Download button to get a list of emails of WordPress users registered on your site. You can import this file in MailChimp");?>.<br><br>
                                    <input type="submit" value="<?php echo mo_wc_sl("Save");?> " disabled="disabled"  class="button button-primary button-large" />
                                    <a style="width:190px;" disabled="disabled" class="button button-primary button-large" href="#">
                                        <?php echo mo_wc_sl("Download emails of users");?>
                                    </a><br>
                    </td></tr></table>
        </form>
    </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            jQuery("#mosocial_purchase_mail_addon_verify").on("click",function(){
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
                    plan_name: 'WP_SOCIAL_LOGIN_MAILCHIMP_ADDON',
                },
                crossDomain :!0, dataType:"html",
                success: function(data) {
                    var flag=0;
                    jQuery("input").each(function(){
                        if($(this).val()=="mo_openid_verify_license") flag=1;
                    });
                    if(!flag) {
                        jQuery(data).insertBefore("#mo_openid_mailchimp_video");
                        jQuery("#customization_ins").find(jQuery("#cust_supp")).css("display", "none");
                    }
                },
                error: function (data){}
            });
        }
    </script>
    <?php
}
