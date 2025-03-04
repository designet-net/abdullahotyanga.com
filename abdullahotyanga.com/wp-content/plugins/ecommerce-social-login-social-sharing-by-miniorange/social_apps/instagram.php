<?php


class instagram
{
    public $color="#517FA6";
    public $scope="user_profile,user_media";
    public $instructions;
    public function __construct()
    {
        if (get_option('permalink_structure') !== "") {
            $this->site_url = get_option('siteurl');
            $this->instructions = "Go to <a href=\"https://developers.facebook.com/products/instagram/\" target=\"_blank\">https://developers.facebook.com/products/instagram/</a> , click My Apps, and create a new app. ##Once you have created the app and are in the App Dashboard, navigate to<b> Settings > Basic</b>, scroll the bottom of page, and click <b>Add Platform</b>.##Choose Website, add your website’s URL, enter the <b><code id='9'>" . get_option('siteurl') . "</code><i style= \"width: 11px;height: 9px;padding-left:2px;padding-top:3px\" class=\"mofa mofa-fw mofa-lg mofa-copy mo_copy mo_copytooltip\" onclick=\"copyToClipboard(this, '#9', '#shortcode_url_copy')\"><span id=\"shortcode_url_copy\" class=\"mo_copytooltiptext\">Copy to Clipboard</span></i></b> as <strong>website URL and save your changes.</strong>##Enter your privacy policy URL in Privacy Policy URL and select Category of your website and then click on Save Changes.##Click on <b>Products</b>, locate the Instagram product, and click Set Up to add it to your app.##Click <b>Basic Display</b>, scroll to the bottom of the page, then click <b>Create New App</b>.

 ##And fill the details of the app properly.##Enter the redirect URL <b><code id='10'>" . mo_wc_get_permalink('instagram') . "</code><i style= \"width: 11px;height: 9px;padding-left:2px;padding-top:3px\" class=\"mofa mofa-fw mofa-lg mofa-copy mo_copy mo_copytooltip\" onclick=\"copyToClipboard(this, '#10', '#shortcode_url1_copy')\"><span id=\"shortcode_url1_copy\" class=\"mo_copytooltiptext\">Copy to Clipboard</span></i></b> as <strong>valid redirect URI.</strong>##Navigate to <b>Roles</b> > Roles and scroll down to the <b>Instagram Testers</b> section. Click <b>Add Instagram Testers</b> and enter your Instagram account’s username and send the invitation.

##Change your app status from In Development to Live by clicking on OFF (sliding button) beside Status option of the top right corner.##Open a new web browser and go to www.instagram.com and sign into your Instagram account that you just invited. Navigate to <b>(Profile Icon) > Edit Profile > Apps and Websites > Tester Invites </b>and accept the invitation.##Click on Instagram from the left menu and then click on 'Basic Display' option, copy the <b>instagram app ID </b> and <b>instagram app secret</b> from there. ## Click on the Save settings button to Click on the Save and Test Configuration button. ##Let us know if you require any help in configuring <strong>miniOrnage Pre Configured App,</strong><br>Please Contact us at <a href=\'mailto:socialloginfeedback@xecurify.com'>socialloginfeedback@xecurify.com</a>";
        } else{
            $this->instructions= "<strong style='color: red;font-weight: bold'><br>You have selected plain permalink and instagram doesnot support it.</strong><br><br> Please change the permalink to continue further.Follow the steps given below:<br>1. Go to settings from the left panel and select the permalinks option.<br>2. Plain permalink is selected ,so please select any other permalink and click on save button.<br> <strong class='mo_openid_note_style' style='color: red;font-weight: bold'> When you will change the permalink ,then you have to re-configure the already set up custom apps because that will change the redirect URL.</strong>";
        }
    }

    function mo_wc_openid_get_app_code()
    {
        $appslist = maybe_unserialize(get_option('mo_openid_apps_list'));
        $social_app_redirect_uri= wc_get_social_app_redirect_uri('instagram');
        mo_wc_openid_start_session();
        $_SESSION["appname"] = 'instagram';
        $client_id = $appslist['instagram']['clientid'];
        $scope = $appslist['instagram']['scope'];
        $login_dialog_url = 'https://api.instagram.com/oauth/authorize/?client_id=' . $client_id . '&redirect_uri=' . $social_app_redirect_uri . '&scope='.$scope.'&response_type=code';
        header('Location:'. $login_dialog_url);
        exit;
    }

    function mo_wc_openid_get_access_token()
    {
        $code = mo_wc_openid_validate_code();
        $social_app_redirect_uri = wc_get_social_app_redirect_uri('instagram');

        $appslist = maybe_unserialize(get_option('mo_openid_apps_list'));
        $client_id = $appslist['instagram']['clientid'];
        $client_secret = $appslist['instagram']['clientsecret'];
        $access_token_uri = 'https://api.instagram.com/oauth/access_token';
        $postData = 'client_id='. $client_id .'&client_secret=' . $client_secret . '&grant_type=authorization_code&redirect_uri=' . $social_app_redirect_uri.'&code=' . $code;
        $access_token_json_output = mo_wc_openid_get_access_token($postData, $access_token_uri,'instagram');
        $access_token = isset($access_token_json_output['access_token']) ? $access_token_json_output['access_token'] : '';
        mo_wc_openid_start_session();
        $profile_url = 'https://graph.instagram.com/me?fields=id,username&access_token='.$access_token;
        $profile_json_output = mo_wc_openid_get_social_app_data($access_token, $profile_url,'amazon');
        mo_wc_openid_start_session();

        //Test Configuration
        if (is_user_logged_in() && get_option('mo_openid_test_configuration') == 1) {
            mo_wc_openid_app_test_config($profile_json_output);
        }
        //set all profile details
        //Set User current app
        $first_name = $last_name = $email = $user_name = $user_url = $user_picture = $social_user_id = '';
        $location_city = $location_country = $about_me = $company_name = $age = $gender = $friend_nos = '';

        $user_name = isset( $profile_json_output['username']) ?  $profile_json_output['username'] : '';
        $social_user_id = isset( $profile_json_output['id']) ?  $profile_json_output['id'] : '';

        $appuserdetails = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'user_name' => $user_name,
            'user_url' => $user_url,
            'user_picture' => $user_picture,
            'social_user_id' => $social_user_id,
            'location_city' => $location_city,
            'location_country' => $location_country,
            'about_me' => $about_me,
            'company_name' => $company_name,
            'friend_nos' => $friend_nos,
            'gender' => $gender,
            'age' => $age,
        );
        return $appuserdetails;
    }
}