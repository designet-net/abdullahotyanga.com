<?php
function mo_wc_openid_registration()
{
    ?>
    <form id="registration" name="registration" method="post" action="">
        <input type="hidden" name="option" value="mo_openid_enable_registration" />
        <input type="hidden" name="mo_openid_enable_registration_nonce" value="<?php echo wp_create_nonce( 'mo-openid-enable-registration-nonce' ); ?>"/>
        <div class="mo_openid_table_layout">
            <h3><?php echo mo_wc_sl('Auto Registration');?></h3>
            <div>
                <label class="mo_openid_checkbox_container"><?php echo mo_wc_sl('Auto-register users');?>.
                    <input style="font-size: 16px;" type="checkbox" id="auto_register_enable" name="mo_openid_auto_register_enable" value="1"
                        <?php checked( get_option('mo_openid_auto_register_enable') == 1 );?> /><b style="font-size: 15px;"></b>                    <span class="mo_openid_checkbox_checkmark"></span>
                </label>
                <?php echo mo_wc_sl('Registration disabled message');?>:
                <input type="text" class="mo_openid_textfield_css" style="border: 1px solid ;border-color: #0867b2;width: 80%" id="auto_register_disabled_message" name="mo_openid_register_disabled_message" value="<?php echo esc_textarea(get_option('mo_openid_register_disabled_message'))?>" />
                <label style="cursor: auto" class="mo_openid_note_style"><?php echo mo_wc_sl('If Auto-register users is unchecked, users will not be able to register using Social Login. The users who already have an account will be able to login.  This setting stands true only when users are registering using Social Login. This will not interfere with users registering through the regular WordPress registration form.');?></label>
            </div>
            <br><hr>
            <h3><?php echo mo_wc_sl('Role Mapping');?></h3>
            <div>
                <?php echo mo_wc_sl('Universal Role');?>:
                <select name="mapping_value_default" style="margin-left: 2%; color: #000000;width:20%;font-size: 15px; background-color: #d4d7ee" id="default_group_mapping">                    <?php
                    if(get_option('mo_openid_login_role_mapping'))
                        $default_role = get_option('mo_openid_login_role_mapping');
                    else
                        $default_role = get_option('default_role');
                    wp_dropdown_roles($default_role); ?>
                </select>
                <label style="cursor: auto" class="mo_openid_note_style"> <?php echo mo_wc_sl('Use Role Mapping to assign this role to the all users registering through Social Login. According to the role mapped user will be granted role on the website.');?></label>
            </div><br><hr>
            <h3><?php echo mo_wc_sl('Enable Email Notification to Admin');?></h3>
            <div>
                <label class="mo_openid_checkbox_container"><?php echo mo_wc_sl('Enable Email Notification to Admin - on User Registration');?>
                    <input style="font-size: 16px;" type="checkbox" id="mo_openid_email_enable" name="mo_openid_email_enable" value="1"
                        <?php checked( get_option('mo_openid_email_enable') == 1 );?> /><b style="font-size: 15px;"></b><span class="mo_openid_checkbox_checkmark"></span>
                </label>
                <label style="cursor: auto" class="mo_openid_note_style"><?php echo mo_wc_sl('This feature requires SMTP to be configured');?>.</label>
            </div>
            <br/><hr>
            <h3><?php echo mo_wc_sl('Set Display Picture for User');?></h3>
            <div>
                <label class="mo_openid_checkbox_container"><?php echo mo_wc_sl('Set Display Picture for User - on User Registration');?>
                    <input style="font-size: 16px;" type="checkbox" id="moopenid_social_login_avatar" name="moopenid_social_login_avatar" value="1"
                        <?php checked( get_option('moopenid_social_login_avatar') == 1 );?> /><b style="font-size: 15px;"></b><span class="mo_openid_checkbox_checkmark"></span>
                </label>
            </div>


            <br/><hr>
            <h3><?php echo mo_wc_sl('Send user activation link over email');?><a style="left: 1%; position: relative; text-decoration: none" class="mo-openid-premium" href="<?php echo add_query_arg( array('tab' => 'licensing_plans'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('PRO');?></a></h3>
            <div>
                <label class="mo_openid_checkbox_container_disable"><?php echo mo_wc_sl('Send user activation link over email - on User Registration');?>
                    <input type="checkbox"  /><br>
                    <span class="mo_openid_checkbox_checkmark_disable"></span>
                </label>
                <?php
                $editor_height = array("editor_height"=>100);
                $content = 'Please click on link to activate your account  ##link##';
                $editor_id = 'mo_openid_registration_email_content';
                wp_editor( $content, $editor_id,$editor_height);
                ?>
            </div>
            <br/><hr>
            <h3><?php echo mo_wc_sl('Enable Registration For Pages');?><a style="left: 1%; position: relative; text-decoration: none" class="mo-openid-premium" href="<?php echo add_query_arg( array('tab' => 'licensing_plans'), $_SERVER['REQUEST_URI'] ); ?>"><?php echo mo_wc_sl('PRO');?></a></h3>
            <div>
                <label class="mo_openid_checkbox_container_disable"><?php echo mo_wc_sl('Enable registration for specific pages');?>
                    <input type="checkbox"  /><br>
                    <span class="mo_openid_checkbox_checkmark_disable"></span>
                    <br/>
                    <label style="cursor: auto"><?php echo mo_wc_sl('Enter Page URLs to Enable Registration:');?></label>
                    <textarea rows="4" cols="50" class="mo_openid_textfield_css" style="border: 1px solid ;border-color: #0867b2;width: 100%" disabled placeholder="Please enter URLs seperated by semicolon(;)"/></textarea>
                        <br/><label style="cursor: auto"><?php echo mo_wc_sl('Enter Page URL to Redeirect if user is not allowed to register:');?></label>
                        <textarea rows="4" cols="50" class="mo_openid_textfield_css" disabled style="border: 1px solid ;border-color: #0867b2;width: 100%"/></textarea>
                </label>

            </div>
            <br/><b><input type="submit" name="submit" value="<?php echo mo_wc_sl('Save');?>" style="width:150px;text-shadow: none;background-color:#0867b2;color:white;box-shadow:none;" class="button button-primary button-large" /></b>
        </div>
    </form>
    <script>
        //to set heading name
        jQuery('#mo_openid_page_heading').text('<?php echo mo_wc_sl('Registration Options');?>');
    </script>
    <?php
}
