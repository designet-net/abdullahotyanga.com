<?php

//configure apps menu page
function mo_wc_openid_show_apps()
{
    if (sanitize_text_field(isset($_POST['update_tour_status']))){
        update_option('mo_openid_tour_new','1');
    }
    ?>
    <table>
        <tr id="mo_openid_free_avail_apps">
            <td>
                <?php
                $selected_applications=get_option('app_pos');
                $selected_applications=explode('#',$selected_applications);
                ?>
                <div class="mo-openid-sort-apps ui-sortable" id="sortable">
                    <?php
                    foreach ($selected_applications as $apps)
                    {
                        if(get_option('mo_openid_'.$apps.'_enable')==1)
                            $checked='checked';
                        else
                            $checked='';
                        $dir=dirname(dirname(dirname( __FILE__ )));
                        require($dir.'/social_apps/'.$apps.'.php');
                        $social_app = new $apps();
                        $blcolor=$social_app->color;
                        ?>
                        <div class="mo-openid-sort-apps-div mo-openid-hover-div-sett" data-provider="<?php echo $apps?>" id="<?php echo $apps?>" style="opacity: <?php if(get_option('mo_openid_'.$apps.'_enable')) echo '1'; else echo '0.6'?>">
                            <div class="mo-openid-sort-apps-i-div mo-openid-sort-apps-open-settings-div" title="Configure Settings" style="cursor: pointer; background-color:<?php echo $blcolor?>;">
                                <div style="position: absolute;right: 5px;top: 5px;<?php if($checked!='checked') { ?> display: none; <?php } ?>" id="mo_openid_<?php echo $apps?>_active_div">
                                    <span style="font-size: 10px;background: #FFA335;color: white;font-weight: 600;padding: 1px 4px;border-radius: 4px;font-family: monospace;"><?php echo mo_wc_sl('Active');?></span>
                                </div>
                                <img style="float: right" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__)));?>includes/images/icons/<?php echo $apps?>.png" height="60px" width="60px"
                                     alt="<?php echo $apps?>"/>
                            </div>
                            <div class="mo-openid-capp-sett" id="mo-openid-hover-app-sett-show">
                                <div style="display: inline-block; padding-left: 3%; text-align: left;width: 75%;position: absolute;font-size: 13px;"><span style="color:black"><?php echo strtoupper($apps)?></span></div>
                                <div style="text-align: left; width: 25%; float: right; display: inline-block">
                                    <label class='mo-openid-switch-app'>
                                        <input type='checkbox' <?php echo $checked?> value="1" onclick='enable_default_app("<?php echo $apps ?>")' id='mo_apps_<?php echo $apps?>'  >
                                        <div class='mo-openid-slider-app round' id='switch_checkbox' ></div>
                                    </label>
                                </div>
                            </div>
                            <div title="Change Position" id="mo_openid_move_<?php echo $apps?>" class="mo-openid-sort-apps-move"></div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <br/>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                $selected_applications_premium=get_option('app_pos_premium');
                $selected_applications_premium=explode('#',$selected_applications_premium);
                ?>
                <div class="mo_openid_highlight">
                    <h3 style="margin-left: 1%;line-height: 210%;color:white;"><?php echo mo_wc_sl('Premium Applications');?></h3>
                </div>
                <div class="mo-openid-sort-apps ui-sortable">
                    <?php
                    foreach ($selected_applications_premium as $apps)
                    {
                        $dir=dirname(dirname(dirname( __FILE__ )));
                        include_once($dir.'/social_apps/'.$apps.'.php');
                        $social_app = new $apps();
                        $blcolor=$social_app->color;
                        ?>
                        <div class="mo-openid-sort-apps-div mo-openid-hover-div-sett">
                            <div class="mo-openid-sort-apps-i-div" style="background-color:<?php echo $blcolor?>;">
                                <img style="float: right" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__)));?>includes/images/icons/<?php echo $apps?>.png" height="60px" width="60px"
                                     alt="<?php echo $apps?>"/>
                            </div>
                            <div id="mo-openid-hover-app-sett-show" style="display: block">
                                <div style="display: inline-block; text-align: center;width: 100%;position: absolute;font-size: 13px;"><span style="color:black"><?php if($apps == 'mailru') $apps='mail.ru'; echo strtoupper($apps)?></span></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>
    <div id="mo_openid_notice_snackbar"><label id="mo_openid_notice_message"></label></div>

    <script>
        //to set heading name
        jQuery('#mo_openid_page_heading').text('<?php echo mo_wc_sl('Configure Applications'); ?>');
        //to enable apps from outside toggle
        function enable_default_app(app_name) {
            var a = document.getElementById('mo_apps_'.concat(app_name));
            enable_app(a,app_name,'0');
        }

        //defination to enable app
        function enable_app(a,app_name,toggle) {
            var enable_app = 'mo_openid'.concat(app_name).concat('_enable');
            var active_button = document.getElementById('mo_openid_'.concat(app_name).concat('_active_div'));
            jQuery.ajax({
                url: "<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                method: "POST", //request type,
                dataType: 'json',
                data: {
                    action: 'mo_register_customer_toggle_update',
                },
                success: function (result) {
                   if (true) {
                        if (a.checked == true) {
                            if (app_name == 'facebook' || app_name == 'twitter' || app_name == 'instagram') {
                                jQuery.ajax({
                                    type: 'POST',
                                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                    data: {
                                        action: 'mo_openid_check_capp_enable',
                                        app_name: app_name,
                                    },
                                    success: function (result) {
                                        if (result.status) {
                                            document.getElementById(app_name).setAttribute("style", "opacity:1");
                                            active_button.style.display = "block";
                                            if(toggle=='1')
                                                jQuery("#mo_apps_".concat(app_name)).prop('checked', true);
                                            mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+' is activated sucessfully');
                                            var mo_openid_sso_enable_app_nonce = '<?php echo wp_create_nonce("mo-openid-sso-enable-app"); ?>';
                                            jQuery.ajax({
                                                type: 'POST',
                                                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                                data: {
                                                    'mo_openid_sso_enable_app_nonce': mo_openid_sso_enable_app_nonce,
                                                    action: 'mo_openid_app_enable',
                                                    app_name: app_name,
                                                    enabled: a.checked,
                                                },
                                                success: function (data) {
                                                },
                                                error: function (data) {
                                                }
                                            });
                                        } else {
                                            jQuery("#mo_apps_".concat(app_name)).prop('checked', false);
                                            mo_show_success_error_msg('success','Please set custom app for facebook');
                                            jQuery ("#mo_facebook_notice").show();
                                            jQuery( "#mo_register_customer_toggle").hide();
                                            getappsInLine(app_name);
                                        }
                                    },
                                    error: function (data) {}
                                });
                            }
                            else {
                                document.getElementById(app_name).setAttribute("style", "opacity:1");
                                active_button.style.display = "block";
                                if(toggle=='1') {
                                    jQuery("#mo_openid_enable_custom_app").prop('checked', true);
                                    jQuery("#mo_apps_".concat(app_name)).prop('checked', true);
                                }
                                mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+' is activated sucessfully');
                                enable_default_app_db(app_name,a.checked);
                            }
                        } else {
                            document.getElementById(app_name).setAttribute("style", "opacity:0.6");
                            active_button.style.display = "none";
                            if(toggle=='1') {
                                jQuery("#mo_openid_enable_custom_app").prop('checked', false);
                                jQuery("#mo_apps_".concat(app_name)).prop('checked', false);
                            }
                            mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+' is deactivated sucessfully');
                            enable_default_app_db(app_name,a.checked);
                        }

                    }
                    else {
                        if (a.checked == true) {
                            if (app_name == 'salesforce') {
                                jQuery("#mo_apps_salesforce").prop('checked', false);
                                handle_salesforce();
                            } else {
                                jQuery.ajax({
                                    type: 'POST',
                                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                    data: {
                                        action: 'mo_openid_check_capp_enable',
                                        app_name: app_name,
                                    },
                                    success: function (result) {
                                        if (result.status) {
                                            document.getElementById(app_name).setAttribute("style", "opacity:1");
                                            active_button.style.display = "block";
                                            if(toggle=='1')
                                                jQuery("#mo_apps_".concat(app_name)).prop('checked', true);
                                            mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+' is activated sucessfully');
                                            var mo_openid_sso_enable_app_nonce = '<?php echo wp_create_nonce("mo-openid-sso-enable-app"); ?>';
                                            jQuery.ajax({
                                                type: 'POST',
                                                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                                data: {
                                                    'mo_openid_sso_enable_app_nonce': mo_openid_sso_enable_app_nonce,
                                                    action: 'mo_openid_app_enable',
                                                    app_name: app_name,
                                                    enabled: a.checked,
                                                },
                                                success: function (data) {
                                                },
                                                error: function (data) {
                                                }
                                            });
                                        } else {
                                            jQuery("#mo_apps_".concat(app_name)).prop('checked', false);
                                            if(app_name=='facebook')
                                            {
                                                jQuery ("#mo_facebook_notice").show();
                                                jQuery( "#mo_register_customer_toggle").hide();
                                                mo_show_success_error_msg('success','Please set up custom app for Facebook');
                                            }
                                            else {
                                                jQuery ("#mo_facebook_notice").hide();
                                                jQuery.ajax({
                                                    url: "<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                                                    method: "POST", //request type,
                                                    dataType: 'json',
                                                    data: {
                                                        action: 'mo_register_customer_toggle_update',
                                                    },
                                                    success: function (result){
                                                        if (true){
                                                            jQuery( "#mo_register_customer_toggle").hide();
                                                        }
                                                        else
                                                            jQuery( "#mo_register_customer_toggle").show();
                                                    }
                                                });
                                                mo_show_success_error_msg('error','Please set up custom app');
                                            }
                                            getappsInLine(app_name);
                                        }
                                    },
                                    error: function (data) {
                                    }
                                });
                            }
                        }
                        else {
                            document.getElementById(app_name).setAttribute("style", "opacity:0.6");
                            active_button.style.display = "none";
                            var mo_openid_sso_enable_app_nonce = '<?php echo wp_create_nonce("mo-openid-sso-enable-app"); ?>';
                            if(toggle=='1')
                                jQuery("#mo_apps_".concat(app_name)).prop('checked', true);
                            mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+' is deactivated sucessfully');
                            jQuery.ajax({
                                type: 'POST',
                                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                                data: {
                                    'mo_openid_sso_enable_app_nonce': mo_openid_sso_enable_app_nonce,
                                    action: 'mo_openid_app_enable',
                                    app_name: app_name,
                                    enabled: a.checked,
                                },
                                success: function (data) {
                                },
                                error: function (data) {
                                }
                            });
                        }
                    }
                }
            });
        }

        //to enable/disable app
        function enable_default_app_db(app_name, checked){
            var mo_wc_openid_sso_enable_app_nonce = '<?php echo wp_create_nonce("mo-openid-sso-enable-app"); ?>';
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: {
                    'mo_openid_sso_enable_app_nonce': mo_wc_openid_sso_enable_app_nonce,
                    action: 'mo_openid_app_enable',
                    app_name: app_name,
                    enabled: checked,
                },
                success: function (data) {
                },
                error: function (data) {
                }
            });
        }

        function mo_show_success_error_msg(msg_type,message) {
            jQuery('#mo_openid_notice_message').text(message);
            if(msg_type=='error')
                jQuery('#mo_openid_notice_snackbar').css("background-color","#c02f2f");
            else
                jQuery('#mo_openid_notice_snackbar').css("background-color","#4CAF50");
            var x = document.getElementById("mo_openid_notice_snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
        }
        function mo_openid_shortcode() {
            window.location= base_url+'/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=shortcodes';

        }

        //for custom app pop-up
        jQuery(function() {
            var popup = '<div class="mo_openid_popup" popup-name="popup-1" border="1" id = "custom_app_div" style="display:none; float: left; width: 100%; overflow: hidden">' +
                        '<div id="mo_openid_ajax_wait_fade"></div>'+
                        '<div id="mo_openid_ajax_wait_img"><img id="loader" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__)));?>includes/images/wait.gif" /></div>'+
                        '<div class="mo_openid_popup-content">'+
                            '<div style="margin-bottom: 2px"><center><img style="margin-left:40%; border-radius:4px; display: inline; height:25px; width:28px" id="custom_app_name_image">&nbsp;<h1 style="display: inline" id="custom_app_name"></h1></center></div>'+
                                '<div style="width: 40%; float: left; display: inline">' +
                                    '<div id="mo_set_pre_config_app" style="overflow: auto; margin-left:20%; padding-top:2%">' +
                                        '<div style="width: 65%; float: left; display: inline"><i class="mofa mofa-info-circle mo_copytooltip" title="miniOrange take care of creating applications for you so that you don’t have to worry about creating applications in each social network."></i><label style="display: contents;"><b> Pre configured miniOrange App</b></label></div>' +
                                        '<div style="width: 35%; float: right; display: inline">' +
                                            '<label class="mo-openid-switch-app">' +
                                                '<input type="checkbox" id="mo_openid_enable_custom_app" value="1"/>' +
                                                '<div class="mo-openid-slider-app round" id="switch_checkbox" ></div>' +
                                            '</label>' +
                                        '</div>' +
                                    '</div>'+
                                    '<div id="mo_facebook_notice" style="overflow: auto; margin-left:25%; margin-right:3%; padding-top:2%"><label style="cursor:auto"><b>Please set custom app for Facebook</b></label></div><hr>'+
                                    '<div><center><h3 style="margin-bottom: 2%">App Settings</h3></center></div>'+
                                    '<div class="mo-openid-app-name" id="custom_app_name_rename" style="width: 100%">'+
                                        '<div id="mo_register_customer_toggle" style="overflow: auto; margin-left:10%; margin-right:3%; padding-top:2%;margin-bottom:2%;">' +
                                            '<a href="<?php echo add_query_arg( array('tab' => 'profile'), $_SERVER['REQUEST_URI'] ); ?>">If you don\'t want to set up your own app then register with us and use our pre-configured apps</a>' +
                                        '</div>'+
                                        '<div style="padding: 0% 5% 5% 5%;">'+
                                            '<div style="overflow: auto">' +
                                                '<div style="float: left; width: 20%"><b>App ID</b></div>'+
                                                '<div style="float: right; width: 80%"><input id="app_id_value" type="text" style="width: 98%"></div>'+
                                            '</div>'+
                                            '<div style="overflow: auto;margin-top: 10px;">'+
                                                '<div style="float: left; width: 20%"><b>App Secret</b></div>'+
                                                '<div style="float: right; width: 80%"><input id="app_secret_value" type="text" style="width: 98%"> </div>'+
                                            '</div>'+
                                            '<div style="overflow: auto;margin-top: 10px;">'+
                                            '<div style="float: left; width: 20%"><b>Scope</b></div>'+
                                            '<div style="float: right; width: 80%"><input id="app_scope_value" type="text" style="width: 98%"> </div>'+
                                            '</div>'+
                                            '<div style="margin-top: 10px;margin-left: 13%;">'+
                                                '<center>' +
                                                    '<input type="button" value="Save & Test Configuration" class="button button-primary button-large mo_openid_save_capp_settings">' +
                                                    '&nbsp;&nbsp;<input type="button" value="Clear Values" class="button button-primary button-large mo_openid_clear_capp_settings">'+
                                                '</center>'+
                                            '</div>'+
                                            '<div style="margin-top: 10px;">'+
                                            '<center>' +
                                            '<p style="margin-bottom:auto">Have any configuration issues? <a style="cursor: pointer" onclick="mo_openid_support_form(this.id)">Contact Us</a> for help.</p>' +
                                            '</center>'+
                                            '</div>'+
                '<div style="margin-top: 10px;">'+
                '<center>' +
                '<p style="margin-bottom:auto">Do you want to use social login icons on any particular theme? Go to <a style="cursor: pointer" onclick="mo_openid_shortcode();">Shortcode Tab</a> .</p>' +
                '</center>'+
                '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div style="width: 100%">'+
                                        '<iframe style="margin-right: 2px;" id="custom_app_video" width="98%" height="225" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'+
                                    '</div>'+
                                '</div>'+
                                '<div id="mo_openid_cust_app_instructions" style="width: 59%; background-color: #d2d4e542; float: right; display: block; height: auto; overflow-y: auto">'+
                                    '<div><center><h3 id="custom_app_instructions"></h3><h4 id="mo_ssl_notice" style="color:red;margin-top: 0px;margin-bottom: 0px;"></h4></center></div>'+
                                    '<ol id="custom_app_inst_steps"></ol><div style="padding: 0px 10px 10px 10px;" id="custom_app_perma_inst"><strong style=\'color: red;font-weight: bold\'><br>You have selected plain permalink and <label id="mo_perma_error_app_name" style="display:contents"></label> does not support it.</strong><br><br> Please change the permalink to continue further.Follow the steps given below:<br>1. Go to settings from the left panel and select the permalinks option.<br>2. Plain permalink is selected ,so please select any other permalink and click on save button.<br> <strong class=\'mo_openid_note_style\' style=\'color: red;font-weight: bold\'> When you will change the permalink ,then you have to re-configure the already set up custom apps because that will change the redirect URL.</strong></div>'+
                                '</div>'+
                                '<div id="mo_openid_register_new_user" style="width: 59%; background-color: #d2d4e542; float: right; display: none; height: auto; overflow-y: auto">'+
                                    '<div><center><h3 style="color:#FFA335">Register with miniOrange</h3></center></div>'+
                                    '<p style="font-size:14px;margin-left:1%"><b>Why should I register? </b></p>'+
                                    '<div id="help_register_desc" style="margin-left:1%; margin-right:1%;background: aliceblue; padding: 10px 10px 10px 10px; border-radius: 10px;">' +
                                    'By registering with miniOrange we take care of creating applications for you so that you don’t have to worry about creating applications in each social network.' +
                                    '<br/><b>Please Note:</b> We do not store any information except the email that you will use to register with us. You can go through our <a href="https://www.miniorange.com/usecases/miniOrange_Privacy_Policy.pdf" target="_blank">Privacy Policy</a> for how we use your information. We don’t sell your information to any third-party organization.' +
                                    '</div><br/>'+
                                    '<table class="mo_openid_settings_table" style="margin-left:1%; width:95%">' +
                                        '<tr>' +
                                            '<td><b><font color="#FF0000">*</font>Email:</b></td>' +
                                            '<td><input class="mo_openid_table_textbox" id="new_user_email" type="email" name="email" required placeholder="person@example.com" value="" /></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                            '<td><b><font color="#FF0000">*</font>Password:</b></td>' +
                                            '<td><input class="mo_openid_table_textbox" id="new_user_password" required type="password" name="password" placeholder="Choose your password (Min. length 6)" /></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                            '<td><b><font color="#FF0000">*</font>Confirm Password:</b></td>' +
                                            '<td><input class="mo_openid_table_textbox" id="new_user_confirmPassword" required type="password" name="confirmPassword" placeholder="Confirm your password" /></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                            '<td>&nbsp;</td>' +
                                            '<td><br /><input type="submit" value="Register" id="mo_register_user" style="width:auto;" class="button button-primary button-large" />' +
                                                '<input type="button" value="Already have an Account?" id="mo_openid_open_login_form" style="width:auto; margin-left: 2%" class="button button-primary button-large" />' +
                                            '</td>' +
                                        '</tr>' +
                                    '</table> '+
                                    '<br/>&nbsp;<a style="font-size: medium;" class="mo_do_not_register">Don\'t want to register and set up my own custom app.</a>'+
                                '</div>'+
                                '<div id="mo_openid_register_old_user" style="width: 59%; background-color: #d2d4e542; float: right; display: none; height: auto; overflow-y: auto">'+
                                '<div><center><h3 style="color:#FFA335">Login with miniOrange</h3></center></div>'+
                                '<p style="font-size:14px;margin-left:1%">It seems you already have an account with miniOrange. Please enter your miniOrange email and password. Click here if you forgot your password?</p>'+
                                '<div id="mo_msg_box" style="display:none"><center><label id="mo_msg_box_content"></label></center></div>'+
                                '<table class="mo_openid_settings_table" style="margin-left:1%; width:95%">' +
                                '<tr>' +
                                '<td><b><font color="#FF0000">*</font>Email:</b></td>' +
                                '<td><input class="mo_openid_table_textbox" id="old_user_email" type="email" name="email" required placeholder="person@example.com" value="" /></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td><b><font color="#FF0000">*</font>Password:</b></td>' +
                                '<td><input class="mo_openid_table_textbox" id="old_user_password" required type="password" name="password" placeholder="Choose your password (Min. length 6)" /></td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>&nbsp;</td>' +
                                '<td><br /><input type="submit" value="Login" id="mo_register_old_user" style="width:auto;" class="button button-primary button-large" />' +
                                '<input type="button" value="Registration Form" id="mo_openid_open_registration_form" style="width:auto; margin-left: 2%" class="button button-primary button-large" />' +
                                '</td>' +
                                '</tr>' +
                                '</table> '+
                                '<br/>&nbsp;<a style="font-size: medium;" class="mo_do_not_register">Don\'t want to register and set up my own custom app.</a>'+
                                '</div>'+
                                '<a class="mo_openid_close-button" popup-close="popup-1" href="javascript:void(0)">Close</a>'+
                            '</div>'+
                        '</div>';
            jQuery(popup).insertAfter("#mo-main-content-div");

            // Close Popup
            jQuery('[popup-close]').on('click', function() {
                var popup_name = jQuery(this).attr('popup-close');
                jQuery('[popup-name="' + popup_name + '"]').fadeOut(300);
                 jQuery( "#custom_app_video").attr('src', "");
            });

            // Close Popup When Click Outside
            jQuery(document).click(function(e){
                if(jQuery(e.target).attr("id") == 'custom_app_div') {
                    jQuery('#custom_app_div').fadeOut(300);
                    jQuery("#custom_app_video").attr('src', "");
                }
            });

            //show login form
            jQuery('#mo_openid_open_login_form').click(function () {
               jQuery('#mo_openid_register_new_user').hide();
               jQuery('#old_user_email').val("");
               jQuery('#old_user_password').val("");
                jQuery('#mo_openid_register_old_user').show();
            });

            //show registration form
            jQuery('#mo_openid_open_registration_form').click(function () {
                jQuery('#mo_openid_register_new_user').show();
                jQuery("#new_user_email").val("");
                jQuery("#new_user_password").val("");
                jQuery("#new_user_confirmPassword").val("");
                jQuery('#mo_openid_register_old_user').hide();
            });

            //create_new_user
            jQuery('#mo_register_user').click(function () {
                var email=jQuery('#new_user_email').val();
                var password=jQuery('#new_user_password').val();
                var confirmPassword=jQuery('#new_user_confirmPassword').val();
                if(email=='' || password=='' || confirmPassword==''){
                    mo_show_success_error_msg('error','All the fields are required. Please enter valid entries.');
                }
                else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))){
                    mo_show_success_error_msg('error','Please match the format of Email. No special characters are allowed.');
                }
                else if(password.length<6 || confirmPassword.length<6){
                    mo_show_success_error_msg('error','Choose a password with minimum length 6.');
                }
                else if(password != confirmPassword){
                    mo_show_success_error_msg('error','Passwords do not match.');
                }
                else {
                    mo_openid_ajax_wait_openModal();
                    jQuery.ajax({
                        url: "<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                        method: "POST", //request type,
                        dataType : 'json',
                        data: {
                            email: email,
                            password: password,
                            confirmPassword: confirmPassword,
                            action: 'mo_register_new_user',
                        },
                        success: function (result) {
                            mo_openid_ajax_wait_closeModal();
                            if(result.error){
                                mo_show_success_error_msg('error',result.error);
                            }
                            else if(result.success){
                                mo_show_success_error_msg('success',result.success);
                            }
                            if(result.success=='Registration complete!'){
                                jQuery('#mo_openid_register_new_user').hide();
                                jQuery('#mo_openid_cust_app_instructions').show();
                                jQuery("#mo_openid_enable_custom_app").prop('checked', true);
                                jQuery("#mo_register_customer_toggle").hide();
                                mo_show_success_error_msg('success','Registration completed & Pre configured app activated');
                                let app_name = jQuery(".mo-openid-app-name").attr("id");
                                var active_button=document.getElementById('mo_openid_'.concat(app_name).concat('_active_div'));
                                active_button.style.display = "block";
                                document.getElementById(app_name).setAttribute("style","opacity:1");
                                jQuery( "#mo_apps_"+app_name).prop('checked', true);
                                enable_default_app_db(app_name, 'true')
                            }
                        }
                    });
                }
            });

            function mo_openid_ajax_wait_openModal() {
                document.getElementById('mo_openid_ajax_wait_img').style.display = 'block';
                document.getElementById('mo_openid_ajax_wait_fade').style.display = 'block';
            }

            function mo_openid_ajax_wait_closeModal() {
                document.getElementById('mo_openid_ajax_wait_img').style.display = 'none';
                document.getElementById('mo_openid_ajax_wait_fade').style.display = 'none';
            }

            //register_old_user
            jQuery('#mo_register_old_user').click(function () {
                jQuery('#mo_msg_box').hide();
                var email=jQuery('#old_user_email').val();
                var password=jQuery('#old_user_password').val();
                if(email=='' || password=='' ){
                    jQuery('#mo_msg_box').show();
                    jQuery('#mo_msg_box_content').css('color','red');
                    jQuery('#mo_msg_box_content').text('All the fields are required. Please enter valid entries.');
                }
                else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))){
                    jQuery('#mo_msg_box').show();
                    jQuery('#mo_msg_box_content').css('color','red');
                    jQuery('#mo_msg_box_content').text('Please match the format of Email. No special characters are allowed.');
                }
                else {
                    mo_openid_ajax_wait_openModal();
                    jQuery.ajax({
                        url: "<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                        method: "POST", //request type,
                        dataType : 'json',
                        data: {
                            email: email,
                            password: password,
                            action: 'mo_register_old_user',
                        },
                        success: function (result) {
                            mo_openid_ajax_wait_closeModal();
                            if(result.error){
                                jQuery('#mo_msg_box_content').css('color','red');
                                jQuery('#mo_msg_box_content').text(result.error);
                            }
                            else if(result.success){
                                jQuery('#mo_msg_box_content').css('color','green');
                                jQuery('#mo_msg_box_content').text(result.success);
                            }
                            jQuery('#mo_msg_box').show();
                            if(result.success=='Your account has been retrieved successfully.'){
                                jQuery('#mo_openid_register_new_user').hide();
                                jQuery('#mo_openid_register_old_user').hide();
                                jQuery('#mo_openid_cust_app_instructions').show();
                                jQuery("#mo_openid_enable_custom_app").prop('checked', true);
                                jQuery("#mo_register_customer_toggle").hide();
                                mo_show_success_error_msg('success','Your account has been retrieved successfully & Pre configured app activated');
                                let app_name = jQuery(".mo-openid-app-name").attr("id");
                                var active_button=document.getElementById('mo_openid_'.concat(app_name).concat('_active_div'));
                                active_button.style.display = "block";
                                document.getElementById(app_name).setAttribute("style","opacity:1");
                                jQuery( "#mo_apps_"+app_name).prop('checked', true);
                                enable_default_app_db(app_name, 'true')
                            }
                        }
                    });
                }
            });

            //mo_openid_enable_custom_app
            jQuery('#mo_openid_enable_custom_app').click(function () {
                mo_openid_ajax_wait_openModal();
                let app_name = jQuery(".mo-openid-app-name").attr("id");
                let a=document.getElementById('mo_openid_enable_custom_app');
                let custom_app_enable_change;
                if(a.checked==true){
                    custom_app_enable_change=1;
                }
                else
                    custom_app_enable_change=0;
                jQuery.ajax({
                    url:"<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                    method: "POST", //request type,
                    dataType: 'json',
                    data: {
                        appname: app_name,
                        custom_app_enable_change : custom_app_enable_change,
                        action: 'custom_app_enable_change_update',
                    },
                    success:function(result){
                        mo_openid_ajax_wait_closeModal();
                        if(result.status=='true'){
                            jQuery("#mo_openid_enable_custom_app").prop('checked', true);
                            mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+(' pre configured app activated'));
                            var active_button=document.getElementById('mo_openid_'.concat(app_name).concat('_active_div'));
                            active_button.style.display = "block";
                            document.getElementById(app_name).setAttribute("style","opacity:1");
                            jQuery( "#mo_apps_"+app_name).prop('checked', true);
                        }
                        else if(result.status=='false')
                        {
                            jQuery( "#mo_openid_enable_custom_app").prop('checked', false);
                            jQuery('#mo_openid_cust_app_instructions').hide();
                            jQuery('#mo_openid_register_new_user').show();
                            jQuery("#new_user_email").val("");
                            jQuery("#new_user_password").val("");
                            jQuery("#new_user_confirmPassword").val("");
                            mo_show_success_error_msg('error','Please register with us to use miniOrange pre configured app');
                            jQuery("#mo_openid_register_new_user").effect("shake");
                        }
                        else if(result.status=="No_cust_app"){
                            mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+(' deactivated sucessfully'));
                            deactivate_app(app_name);
							jQuery( "#mo_openid_enable_custom_app").prop('checked', false);
                        }
                        else if(result.status=="Turned_Off"){
                            mo_show_success_error_msg('success',app_name.charAt(0).toUpperCase()+app_name.substr(1)+(' custom app activated'));
                            jQuery( "#mo_openid_enable_custom_app").prop('checked', false);
                        }
                    }
                });
            });

            // save app id and secret
            jQuery('.mo_openid_save_capp_settings').click(function () {
                save_and_test();
            });

            //clear values
            jQuery('.mo_openid_clear_capp_settings').on('click',function () {
                let app_name = jQuery(".mo-openid-app-name").attr("id");
                var mo_openid_capp_delete_nonce = '<?php echo wp_create_nonce("mo-openid-capp-delete"); ?>';
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        'mo_openid_capp_delete_nonce': mo_openid_capp_delete_nonce,
                        action: 'mo_openid_capp_delete',
                        app_name: app_name,
                    },
                    success: function (data) {
                        jQuery("#app_id_value").val('');
                        jQuery("#app_secret_value").val('');
                        jQuery("#app_scope_value").val('');
                        jQuery.ajax({
                            url:"<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                            method: "POST", //request type,
                            dataType: 'json',
                            data: {
                                action: 'mo_register_customer_toggle_update',
                                app_name: app_name,
                            },
                            success: function(result){
                                if(true){
                                    if (data.status=='1') {
                                        deactivate_app(app_name);
                                        mo_show_success_error_msg('success', 'App credentials has been removed and app is deactivated sucessfully.');
                                    }
                                    else
                                        mo_show_success_error_msg('success', 'App credentials has been removed sucessfully.');
                                }
                                else {
                                    deactivate_app(app_name);
                                    mo_show_success_error_msg('success', 'App credentials has been removed and app is deactivated sucessfully.');
                                }
                            }
                        });
                    },
                    error: function (data) {
                    }
                });
            });

            //show instructions form
            jQuery('.mo_do_not_register').on('click', function() {
                jQuery('#mo_openid_register_new_user').hide();
                jQuery('#mo_openid_register_old_user').hide();
                jQuery('#mo_openid_cust_app_instructions').show();
            });
        });

        function deactivate_app(app_name) {
            jQuery.ajax({
                url:"<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                method: "POST", //request type,
                dataType: 'json',
                data: {
                    app_name: app_name,
                    action: 'mo_disable_app',
                },
                success: function(result){
                    var active_button = document.getElementById('mo_openid_'.concat(app_name).concat('_active_div'));
                    document.getElementById(app_name).setAttribute("style", "opacity:0.6");
                    active_button.style.display = "none";
                    jQuery( "#mo_apps_".concat(app_name)).prop('checked', false);
                    // jQuery( "#mo_openid_enable_app").prop('checked', false);
                }
            });
        }

        function save_and_test() {
            let app_name = jQuery(".mo-openid-app-name").attr("id");
            let app_id = jQuery(".mo-openid-app-name").find("#app_id_value").val();
            let app_secret = jQuery(".mo-openid-app-name").find("#app_secret_value").val();
            let app_scope = jQuery(".mo-openid-app-name").find("#app_scope_value").val();
            if(app_id=="" || app_secret=="") {
                mo_show_success_error_msg('error','Please enter and save App Id and App secret');
            }
            else {
                var mo_openid_capp_details_nonce = '<?php echo wp_create_nonce("mo-openid-capp-details"); ?>';
                var a=document.getElementById('mo_apps_'.concat(app_name));
                var enable_app='mo_openid'.concat(app_name).concat('_enable');
                var active_button=document.getElementById('mo_openid_'.concat(app_name).concat('_active_div'));
                document.getElementById(app_name).setAttribute("style","opacity:1");
                active_button.style.display = "block";
                jQuery( "#mo_apps_"+app_name).prop('checked', true);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        'mo_openid_capp_details_nonce': mo_openid_capp_details_nonce,
                        action: 'mo_openid_capp_details',
                        app_name: app_name,
                        app_id: app_id,
                        app_secret: app_secret,
                        app_scope: app_scope,
                    },
                    success: function (data) {
                        mo_show_success_error_msg('success','App credentials has been saved sucessfully.');
                        mo_test_config();
                    },
                    error: function (data) {
                    }
                });
            }
        }
        function mo_test_config(){
            let app_name = jQuery(".mo-openid-app-name").attr("id");
            jQuery.ajax({
                url:"<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                method: "POST", //request type,
                dataType: 'text',
                data: {
                    appname: app_name,
                    test_configuration : true,
                    action: 'mo_openid_test_configuration_update',
                },
                success:function(result){
                    var myWindow = window.open('<?php echo mo_wc_attribute_url(); ?>' + '/?option=oauthredirect&app_name='+app_name+'&wp_nonce='+'<?php echo wp_create_nonce( 'mo-openid-oauth-app-nonce' ); ?>', "", "width=950, height=600");
                }
            });
        }

        jQuery(".mo-openid-sort-apps-open-settings-div").click(function () {
            let app_name = jQuery(this).parents(".mo-openid-sort-apps-div").attr("id");
            if(app_name=='facebook')
            {
                jQuery ("#mo_facebook_notice").show();
                jQuery( "#mo_register_customer_toggle").hide();

            }
            else {
                document.getElementById('mo_openid_ajax_wait_img').style.display = 'block';
                document.getElementById('mo_openid_ajax_wait_fade').style.display = 'block';
                jQuery ("#mo_facebook_notice").hide();
                jQuery.ajax({
                    url: "<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                    method: "POST", //request type,
                    dataType: 'json',
                    data: {
                        action: 'mo_register_customer_toggle_update',
                    },
                    success: function (result) {
                        if (true) {
                            jQuery("#mo_register_customer_toggle").hide();
                        } else
                            jQuery("#mo_register_customer_toggle").show();
                    }
                });
            }
            getappsInLine(app_name);
        });

        //set values for custom app
        function getappsInLine(application_name) {
            document.getElementById('mo_openid_ajax_wait_img').style.display = 'block';
            document.getElementById('mo_openid_ajax_wait_fade').style.display = 'block';
            jQuery( "#custom_app_name_image").attr('src','');
            jQuery('#app_id_value').val('');
            jQuery('#app_secret_value').val('');
            jQuery('#app_scope_value').val('');
            jQuery("#custom_app_inst_steps").text('');
            jQuery( "#custom_app_name").text('');
            jQuery("#custom_app_perma_inst").hide();
            jQuery( "#custom_app_instructions").text('');
            jQuery('#mo_openid_cust_app_instructions').show();
            jQuery('#mo_openid_register_new_user').hide();
            jQuery('#mo_openid_register_old_user').hide();
            if(application_name == 'facebook' || application_name == 'twitter' || application_name == 'instagram') {
                jQuery("#mo_set_pre_config_app").hide();
                if(application_name == 'facebook' ||  application_name == 'instagram') {

                    jQuery("#mo_ssl_notice").text("SSL certificate is required for " + application_name.charAt(0).toUpperCase() + application_name.substr(1) + " custom app");
                    jQuery("#mo_ssl_notice").show();
                }
            }
            else if(application_name == 'linkedin'){
                jQuery("#mo_ssl_notice").text("LinkedIn custom application needs to be verified for the scope permissions.You can also use our pre-configured application where you don't have to create custom application.")
            jQuery("#mo_ssl_notice").show();

            }
            else {
                jQuery("#mo_set_pre_config_app").show();
                jQuery("#mo_ssl_notice").hide();
            }
            if(application_name == 'salesforce'){
                document.getElementById('mo_openid_ajax_wait_img').style.display = 'none';
                document.getElementById('mo_openid_ajax_wait_fade').style.display = 'none';
                handle_salesforce();
            }
            else if(application_name != null) {
                jQuery( "#custom_app_name").text(application_name.charAt(0).toUpperCase()+application_name.substr(1));
                jQuery( ".mo-openid-app-name").attr('id',application_name);
                jQuery( "#custom_app_name_image").attr('alt',application_name);
                jQuery( "#custom_app_instructions").text("Instructions to configure "+application_name.charAt(0).toUpperCase()+application_name.substr(1)+":");
                var mo_openid_app_instructions_nonce = '<?php echo wp_create_nonce("mo-openid-app-instructions"); ?>';
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        'mo_openid_app_instructions_nonce': mo_openid_app_instructions_nonce,
                        action:'mo_openid_app_instructions',
                        app_name:application_name,
                    },
                    success: function(data) {
                        jQuery("#custom_app_inst_steps").text('');
                        var ins = data.split("##");
                        jQuery( "#custom_app_name_image").attr('src',ins[0]);
                        jQuery( "#app_id_value").val(ins[1]);
                        jQuery( "#app_secret_value").val(ins[2]);
                        if(ins[3]=="default")
                            jQuery( "#mo_openid_enable_custom_app").prop('checked', true);
                        else
                            jQuery( "#mo_openid_enable_custom_app").prop('checked', false);
                        jQuery( "#app_scope_value").val(ins[5]);
                        jQuery( "#custom_app_video").attr('src', ins[6]);
                        if(ins.length==7) {
                            jQuery("#custom_app_perma_inst").show();
                            jQuery("#mo_perma_error_app_name").text(application_name.charAt(0).toUpperCase()+application_name.substr(1));;
                        }
                        else {
                            jQuery("#custom_app_perma_inst").hide();
                            for (i = 7; i < ins.length; i++)
                                jQuery("#custom_app_inst_steps").append('<li>' + ins[i] + '</li>');
                            jQuery("#custom_app_inst_steps").append('<label class="mo_openid_note_style" style="cursor: auto">If you want to display Social Login icons on your login panel then use <code id=\'1\'>[miniorange_social_login]</code><i style= "width: 11px;height: 9px;padding-left:2px;padding-top:3px" class="mofa mofa-fw mofa-lg mofa-copy mo_copy mo_copytooltip" onclick="copyToClipboard(this, \'#1\', \'#shortcode_url_copy\')"><span id="shortcode_url_copy" class="mo_copytooltiptext">Copy to Clipboard</span></i> to display social icons or <a style="cursor: pointer" onclick="mo_openid_support_form(\'\')">Contact Us</a></label>');
                        }
                        document.getElementById('mo_openid_ajax_wait_img').style.display = 'none';
                        document.getElementById('mo_openid_ajax_wait_fade').style.display = 'none';
                    },
                    error: function (data){}
                });
                jQuery( "#custom_app_div" ).show();
            }
        }

        function handle_salesforce() {
            var a=document.getElementById('mo_apps_salesforce');
            var enable_app='mo_openidsalesforce_enable';
            var active_button=document.getElementById('mo_openid_salesforce_active_div');
            jQuery.ajax({
                url:"<?php echo admin_url("admin-ajax.php");?>", //the page containing php script
                method: "POST", //request type,
                dataType: 'json',
                data: {
                    action: 'mo_register_customer_toggle_update',
                },
                success: function(result){
                    if(true){
                        if(a.checked==false) {
                            document.getElementById('salesforce').setAttribute("style","opacity:1");
                            active_button.style.display = "block";
                            jQuery( "#mo_apps_salesforce").prop('checked', true);
                            mo_show_success_error_msg('success','Salesforce is activated sucessfully');
                        }
                        else {
                            document.getElementById('salesforce').setAttribute("style","opacity:0.6");
                            active_button.style.display = "none";
                            jQuery( "#mo_apps_salesforce").prop('checked', false);
                            mo_show_success_error_msg('success','Salesforce is deactivated sucessfully');
                        }
                        var mo_openid_sso_enable_app_nonce = '<?php echo wp_create_nonce("mo-openid-sso-enable-app"); ?>';
                        jQuery.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url("admin-ajax.php"); ?>',
                            data: {
                                'mo_openid_sso_enable_app_nonce': mo_openid_sso_enable_app_nonce,
                                action:'mo_openid_app_enable',
                                app_name:'salesforce',
                                enabled:a.checked,
                            },
                            success: function(data) {
                            },
                            error: function (data){}
                        });
                    }
                    else {
                        var r = confirm('Salesforce do not provide any custom application. Please register with us to use pre configured app. To register click on OK.');
                        if(r)
                            window.location.href="<?php echo site_url()?>".concat("/wp-admin/admin.php?page=mo_wc_openid_general_settings&tab=profile");
                    }
                }
            });
        }
        //to drag and save position of apps
        var mo_openid_sso_sort_nonce = '<?php echo wp_create_nonce("mo-openid-sso-sort"); ?>';
        jQuery( function() {
            jQuery( "#sortable" ).disableSelection();
            jQuery( ".mo-openid-sort-apps" ).sortable({
                handle: '.mo-openid-sort-apps-move',
                items: '.mo-openid-sort-apps-div',
                tolerance: "pointer",
                zIndex: 9999,
                stop: function (event, ui)
                {
                    ui.item.find('.mo-openid-sort-message').remove();
                    var $apps = jQuery('.mo-openid-sort-apps .mo-openid-sort-apps-div'),
                        appList = [];
                    for (var i = 0; i < $apps.length; i++) {
                        appList.push($apps.eq(i).data('provider'));
                    }
                    var $message_show = jQuery('<div class="mo-openid-sort-message">' + <?php echo wp_json_encode('Saving Order'); ?> + '</div>').appendTo(ui.item);
                    jQuery.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: ajaxurl,
                        data: {
                            'mo_openid_sso_sort_nonce': mo_openid_sso_sort_nonce,
                            'action': 'mo-openid-sso-sort-action',
                            'sequence': appList
                        },
                        error: function () {
                            mo_show_success_error_msg('error','Saving failed');
                            setTimeout(function () {
                                $message_show.fadeOut(200, function () {
                                    $message_show.remove();
                                });
                            }, 500);
                        },
                        success: function () {
                            mo_show_success_error_msg('success','Position Saved');
                            setTimeout(function () {
                                $message_show.fadeOut(200, function () {
                                    $message_show.remove();
                                });
                            }, 500);
                        }
                    });
                }
            });
        } );

    </script>
    <?php
}