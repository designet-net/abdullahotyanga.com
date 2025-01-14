<?php

function mo_openid_hubspot_add_on_display()
{?>
    <div id="hub_adv_disp" style="display: block">
        <table>
            <tr>
                <td >
                    <h3><?php echo mo_wc_sl('Hubspot Add On');?>
                        <input type="button" value="<?php echo mo_wc_sl('Purchase');?>"
                               onclick="mosocial_addonform('wp_social_login_hubspot_addon')"
                               id="mosocial_purchase_hub"
                               class="button button-primary button-large"
                               style="float: right; margin-left: 10px;">
                        <input type="button" value="<?php echo mo_wc_sl('Verify Key');?>"
                               id="mosocial_purchase_hub_verify"
                               class="button button-primary button-large"
                               style="float: right;">
                    </h3>
                    <br>
                    <b><?php echo mo_wc_sl('Hubspot Addon provide hubspot integration where user contact will be automatically added to hubspot contact list on successful registration via social login applications.');?>.</b>
                </td>
            </tr>
        </table>
        <table class="mo_openid_display_table table" id="mo_openid_hub_video"></table>

    </div>
    <br>
    <div class="mo_openid_highlight">
        <h3 style="margin-left: 2%;line-height: 210%;color: white;"><?php echo mo_wc_sl('Hubspot Integration');?></h3>
    </div>
    <p style="font-weight: bold; font-size: 17px; display: inline-block; margin-left: 1.5%">Please enter the Key</p>
    <input class="mo_openid_table_textbox" required type="text" style="margin-left:40px;width:300px;"
           name="mo_openid_hubs_int_key" placeholder="Enter your App key" disabled />
    <hr>
    <div class="mo_openid_table_layout">
        <table style="width: 100%;">
            <tr id="sel_apps">
                <td><h3 ><?php echo mo_wc_sl('Select Social Apps');?> </h3>
                    <table style="width: 100%">
                        <p style="font-size: 17px;"><?php echo mo_wc_sl('Select Social Login Application for Hubspot Integration');?></p>

                        <tr>
                            <td style="width:25%">
                                <label class="mo_openid_checkbox_container"><b><?php echo mo_wc_sl('Click Here To Enable All Apps');?></b>
                                    <input type="checkbox" class="app_enable" disabled/>
                                    <span class="mo_openid_checkbox_checkmark_disable"></span>
                                </label>
                            </td>
                        </tr>
                        <?php
                        function check_enable_apps($app_name)
                        {
                            $all_apps_check = get_option('mo_hubspot_apps');
                            $all_apps_check = explode('#', $all_apps_check);
                            foreach ($all_apps_check as $apps_enable) {
                                if($app_name==$apps_enable)
                                    return true;
                            }
                            return false;
                        }
                        $all_apps='facebook#google#vkontakte#twitter#linkedin#instagram#amazon#paypal#salesforce#windowslive#yahoo#apple#hubspot#wordpress#disqus#pinterest#yandex#spotify#twitch#vimeo#kakao#discord#dribbble#flickr#line#meetup#stackexchange#snapchat#reddit#odnoklassniki#foursquare#naver#teamsnap#livejournal#github#tumblr#wiebo#wechat#renren#baidu#mailru#qq';
                        $all_apps=explode('#',$all_apps);
                        $count=0;
                        foreach ($all_apps as $apps)
                        {
                            if($count==0)
                            {
                                ?>
                                <tr>
                                <?php
                            }
                            $count++;
                            ?>
                            <td style="width:20%">
                                <label class="mo_openid_checkbox_container"><?php echo mo_wc_sl($apps);?>
                                    <input type="checkbox" disabled id="mo_openid_hubs_<?php echo $apps;?>_enable" class="app_enable"/>
                                    <span class="mo_openid_checkbox_checkmark_disable"></span>
                                </label>
                            </td>
                            <?php
                            if($count==5){
                                $count=0;
                                ?>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        <center>
            <input type="submit" name="submit" value="<?php echo mo_wc_sl('Save');?>" style="width:150px;background-color:#0867b2;color:white;box-shadow:none;text-shadow: none;"  class="button button-primary button-large" disabled />
        </center>
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
            jQuery('#mo_openid_page_heading').text('<?php echo mo_wc_sl('HubSpot Add On'); ?>');
            jQuery(document).ready(function($){
                jQuery("#mosocial_purchase_hub_verify").on("click",function(){
                    mo_verify_add_on_license_key();
                });
            });

            function mo_verify_add_on_license_key() {
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        action:'verify_addon_licience',
                        plan_name: 'WP_SOCIAL_LOGIN_HUBSPOT_ADDON',
                    },
                    crossDomain :!0, dataType:"html",
                    success: function(data) {
                        var flag=0;
                        jQuery("input").each(function(){
                            if(jQuery(this).val()=="mo_openid_verify_license") flag=1;
                        });
                        if(!flag) {
                            jQuery(data).insertBefore("#mo_openid_hub_video");
                            jQuery("#hub_adv_disp").find(jQuery("#cust_supp")).css("display", "none");
                        }
                    },
                    error: function (data){}
                });
            }
        </script>
    </td>
    <?php
}