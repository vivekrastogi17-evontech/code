<?php
/* Plugin Name: CE
  Description: Custom APIS
  Author: Vivek  
 */

function ur_theme_start_session()
{
    if (!session_id()){
        session_start();                     
    }
}
//add_action("init", "ur_theme_start_session", 1);

function getData($api, $access_token = "", $data = array()) {

    $curl = curl_init();
    $base_url = "http://52.1.96.77/apis/";    
    $headers = array("Content-Type:multipart/form-data"); 
    if(isset($data['prizes'])){
        if(!is_array($data['prizes'])){
            $data['prizes'] = (array)$data['prizes'];
        }
        $data['prizes'] = json_encode($data['prizes']); 
    }

    if(isset($data['access_token'])){
        $access_token = $data['access_token'];
        $filename = $data['raffle_image']['name'];
        $filedata = $data['raffle_image']['tmp_name'];
        $filesize = $data['raffle_image']['size'];
        $postfields = $data;
        $postfields['raffle_image'] = new CurlFile($filedata);
    }else{
        $postfields = $data;
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => $base_url . $api,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $access_token,
            "cache-control: no-cache",
            "content-type: multipart/form-data;",
        ),
    ));

    $response = curl_exec($curl);  
    //print_r($response); die;

    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return json_encode(array('status' => 'failure'));
    } else {
        return $response;
    }
}

function getDataSir($api, $access_token = "", $data = array()) {
    $curl = curl_init();
    $base_url = "http://stage.charitableevolution.com/apis/";
    curl_setopt_array($curl, array(
        CURLOPT_URL => $base_url . $api,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "Authorization: ".$access_token,
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
/**
*/
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://stage.jackraffit.com/apis/create_contest",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"raffle_ctgry\"\r\n\r\n1\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"organization_name\"\r\n\r\nSdfsdfsf\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"benefit_title\"\r\n\r\ntesting\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"start_date\"\r\n\r\n2017-01-16 08:00:00\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"end_date\"\r\n\r\n2017-01-22 08:00:00\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"prizes\"\r\n\r\n[{\"prize\":\"first\"},{\"prize\":\"second\"}]\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
  CURLOPT_HTTPHEADER => array(
    "authorization: cda854b15a19028c8a816c8066bc3de46283dec3fb958809d7d3e8b276fcaf5a13f48cb1",
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    "postman-token: 92f531e9-eeba-eb53-d741-ac83703124a4"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
/**/
    if ($err) {
        return json_encode(array('status' => 'failure'));
    } else {
        return $response;
    }
}

function CEForm() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $image = wp_get_attachment_image_src($custom_logo_id, 'full');
    if (has_custom_logo()) {
        $link = $image[0];
    } else {
        $link = get_template_directory_uri() . '/images/logo.png';
    }
    ?>
    <script>
        // This is called with the results from from FB.getLoginStatus().
        function statusChangeCallback(response) {
            console.log('statusChangeCallback');
            console.log(response);
            if (response.status === 'connected') {
                testAPI();
            } else if (response.status === 'not_authorized') {
                document.getElementById('status').innerHTML = 'Please log ' +
                        'into this app.';
            } else {
                document.getElementById('status').innerHTML = 'Please log ' +
                        'into Facebook.';
            }
        }
        function checkLoginState() {
            FB.getLoginStatus(function (response) {
                statusChangeCallback(response);
            });
        }
        window.fbAsyncInit = function () {
            FB.init({
                appId: '1700782566683429',
                cookie: true, // enable cookies to allow the server to access 
                // the session
                xfbml: true, // parse social plugins on this page
                version: 'v2.8' // use graph api version 2.8
            });
            FB.getLoginStatus(function (response) {
                statusChangeCallback(response);
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // Here we run a very simple test of the Graph API after login is
        // successful.  See statusChangeCallback() for when this call is made.
        function testAPI() {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function (response) {
                console.log('Successful login for: ' + response.name);
                document.getElementById('status').innerHTML =
                        'Thanks for logging in, ' + response.name + '!';
            });
        }
    </script>
    <?php
    $response = getData('get_campaign_profile', '', array('organizer_campaign_id' => '8'));
    $data = json_decode($response, true);
    print_R($data['data']);
    ?>
    <div class="modal fade" id="donate_pop1" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="border-radius:0 !important">
                <div class="modal-body" style="padding: 0px 15px;">
                    <div class="inner">
                        <div class="row">

                            <div class="col-xs-12" style="background: #00BAE7;height: 120px;text-align: center;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" position: absolute; right: 0;background: rgb(0, 186, 231) none repeat scroll 0 0; border: medium none rgb(0, 186, 231); color: rgb(255, 255, 255);font-size: 20px;"><span aria-hidden="true">x</span></button>
                                <img src="<?php echo $data['data']['Organizer']['organization_profile_pic']; ?>" width="30%" style="margin-top: 20px;">
                            </div>
                            <div class="col-xs-12" style="">
                                <p class="text-center" style="padding:20px 0;"><?php echo $data['data']['Organizer']['full_name']; ?></p>
                            </div>
                            <div class="col-xs-12" style="">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" name="donation_amount" id="donation_amount" class="required form-control"  placeholder="Enter amount (e.g. - $100)" />
                                </div>
                                <div class="form-group">
                                    <input autocomplete="off" type="checkbox" name="wpopal_" id="wpopal_" class="required "  /> Provide as a cash donation
                                </div>
                                <div class="form-group">
                                    <input autocomplete="off" type="checkbox" name="wpopal_" id="wpopal_1" class="required "  /> <span style="font-size: 11px;">Convert amount into top needed products</span>
                                </div>
                                <div class="form-group">
                                    <input type="button" id="provide_donate" class="btn btn-primary" value="Provide" style="background-color: rgb(0, 186, 231);border-color: rgb(0, 186, 231);border-radius:0;width: 100%">
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin: 20px 0;">
                                <p class="text-center"><a href="#" style="color: #00BAE7">Or pick out a product to donate</a></p>
                            </div>
                        </div>


                        <div id="" class="form-wrapper"> 

                        </div>
                    </div>                        
                </div>                    
            </div>
        </div>
    </div>
    <div class="modal fade" id="donate_pop2" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="border-radius:0 !important">
                <div class="modal-body" style="padding: 0px 15px;">
                    <div class="inner">
                        <div class="row">

                            <div class="col-xs-12" style="background: url('<?php echo $data['data']['OrganizerCampaign']['campaign_cover_pic']; ?>');background-size:cover;height: 120px;text-align: center;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" position: absolute; right: 0;background: rgb(0, 186, 231) none repeat scroll 0 0; border: medium none rgb(0, 186, 231); color: rgb(255, 255, 255);font-size: 20px;"><span aria-hidden="true">x</span></button>
                                <img src="<?php echo $data['data']['Organizer']['organization_profile_pic']; ?>" width="30%" style="margin-top: 20px;">
                            </div>
                            <form id="payment-form">
                                <div class="col-xs-12" style="margin:10px 0 0 0">
                                    <input type="hidden" id="campaign_id" value="<?php echo $data['data']['OrganizerCampaign']['id']; ?>">
                                    <input type="hidden" id="organizer_id" value="<?php echo $data['data']['Organizer']['id']; ?>">
                                    <input type="hidden" id="anonymous_donor" value="0">
                                    <div class="form-group">
                                        <input autocomplete="off" type="text" name="donor_email" id="donor_email" class="required form-control"  placeholder="Email Address"  value="<?php echo (isset($_SESSION['CE']['email'])) ? $_SESSION['CE']['email'] : $_SESSION['CE']['email']; ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <input autocomplete="off" type="text" name="card_holderName" id="card_holderName" class="required form-control"  placeholder="Card holder name" />
                                    </div>
                                    <div class="form-group">
                                        <input size="20" id="number" value="4242 4242 4242 4242" data-stripe="number" type="text" class="card-number form-control" placeholder="Number">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" size="2" data-stripe="exp_month" class="card-expiry-month form-control" style="width:25%; float: left" placeholder="MM">
                                        <span  style="width:20px; float: left;margin-top: 14px; padding-left: 5px;"> / </span>
                                        <input type="text" size="2" data-stripe="exp_year"  class="card-expiry-year form-control" style="width:66%;float: left" placeholder="YYYY">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group">
                                        <input size="4" id="cvc" value="123" data-stripe="cvc" type="text" class="card-cvc  form-control" placeholder="CVC">
                                    </div>
                                    <div class="form-group">
                                        <input size="4" id="donation_amount_new"   type="text" class="card-cvc  form-control" placeholder="Amount">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="donate_submit" class="btn btn-primary" value="Donate" style="background-color: rgb(0, 186, 231);border-color: rgb(0, 186, 231);border-radius:0;width: 100%">
                                    </div>
                                </div>
                            </form>
                            <div class="col-xs-12" style="margin: 0px 0;">
                                <p class="text-center"><a href="#" style="color: #00BAE7">Back</a></p>
                            </div>
                        </div>


                        <div id="" class="form-wrapper"> 

                        </div>
                    </div>                        
                </div>                    
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCELoginForm" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="inner">
                        <button type="button" class="close btn btn-sm btn-primary pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <a href="<?php echo esc_url(get_site_url()); ?>">
                            <img class="img-responsive center-image" src="<?php echo esc_url($link); ?>" alt="" >
                        </a>
                        <div id="opalceloginform" class="form-wrapper"> 
                            <form class="login-formce" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
                                <div class="alert alert-warning" style="display: none"></div>
                                <div class="alert alert-success" style="display: none"></div>
                                <p class="lead"><?php echo esc_html__("Hello, Welcome Back!", 'wpopal-themer'); ?></p>
                                <div class="form-group">
                                    <input autocomplete="off" type="text" name="wpopal_email" id="wpopal_email" class="required form-control"  placeholder="<?php echo esc_html__("Email", 'wpopal-themer'); ?>" />
                                </div>
                                <div class="form-group">
                                    <input autocomplete="off" type="password" class="password required form-control" placeholder="<?php echo esc_html__("Password", 'wpopal-themer'); ?>" name="wpopal_password" id="wpopal_password">
                                </div>
                                <div class="form-group">
                                    <label for="opal-user-remember" ><input type="checkbox" name="remember" id="opal-user-remember" value="true"> <?php echo esc_html__("Remember Me", 'wpopal-themer'); ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="<?php echo esc_html__("Log In", 'wpopal-themer'); ?>"/>
                                    <input type="button" class="btn btn-default btn-cancel" name="cancel" value="<?php echo esc_html__("Cancel", 'wpopal-themer'); ?>"/>
                                </div>

                                <p><a href="#opalCElostpasswordform" class="toggle-links" title="<?php echo esc_html__("Forgot Password", 'wpopal-themer'); ?>"><?php echo esc_html__("Lost Your Password?", 'wpopal-themer'); ?></a></p>

                                <p><?php echo esc_html__('Dont not have an account?', 'wpopal-themer'); ?> <a  href="javascript:void(0);" id="signup_link" title='<?php echo esc_html__('Sign Up', 'wpopal-themer'); ?>'><?php echo esc_html__('Sign Up', 'wpopal-themer'); ?></a></p>
                                <p>
                                <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                                </fb:login-button>

                                <div id="status">
                                </div>
                                </p>
                            </form></div>
                        <!-- reset form -->
                        <div id="opalCElostpasswordform" class="form-wrapper" style="display: none">
                            <form name="lostpasswordform" id="lostpasswordform" class="lostpassword-form" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post'); ?>" method="post">

                                <p class="lead"><?php echo esc_html__('Reset Password', 'wpopal-themer'); ?></p>
                                <div class="lostpassword-fields">
                                    <p class="form-group">
                                        <label> <?php echo esc_html__('Username or E-mail:', 'wpopal-themer'); ?><br />
                                            <input type="text" name="user_login" class="user_login form-control" value="" size="20" tabindex="10" /></label>
                                    </p>
                                    <p class="submit">
                                        <input type="submit" class="btn btn-primary" name="wp-submit" value="<?php echo esc_html__('Get New Password', 'wpopal-themer'); ?>" tabindex="100" />
                                        <input type="button" class="btn btn-default btn-cancel" value="<?php echo esc_html__('Cancel', 'wpopal-themer'); ?>" tabindex="101" />
                                    </p>
                                    <p class="nav">

                                    </p>
                                </div>
                                <div class="lostpassword-link"><a href="#opalceloginform" class="toggle-links"><?php echo esc_html__('Back To Login', 'wpopal-themer'); ?></a></div>
                            </form>
                        </div>
                    </div></div></div>
        </div>
    </div>

    <div class="modal fade" id="modalCERegisterForm" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <div id="opalregisterform1" class="form-wrapper">
                        <div class="container-form">
                            <form name="opalrgtRegisterForm" id="opalrgtRegisterFormCE" method="post">

                                <button type="button" class="close btn btn-sm btn-primary pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                                <a href="<?php echo esc_url(get_site_url()); ?>">
                                    <img class="img-responsive center-image" src="<?php echo esc_url($link); ?>" alt="" >
                                </a>
                                <div class="alert alert-warning" style="display: none"></div>
                                <div class="alert alert-success" style="display: none"></div>
                                <p class="lead"><?php echo esc_html__("Join Charitable Evolution", 'wpopal-themer'); ?></p>
                                <div id="opalrgt-reg-loader-info" class="opalrgt-loader" style="display:none;">
                                    <span><?php esc_html_e('Please wait ...', 'wpopal-themer'); ?></span>
                                </div>
                                <div id="opalrgt-register-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
                                <div id="opalrgt-mail-alert" class="alert alert-danger" role="alert" style="display:none;"></div>


                                <div class="form-group">                                    

                                    <input type="text" class="form-control" name="opalrgt_email" id="ceopalrgt_email" placeholder="<?php esc_html_e('Email', 'wpopal-themer'); ?>">
                                </div>
                                <div class="form-group">


                                    <input type="password" class="form-control" name="opalrgt_password" id="ceopalrgt_password" placeholder="<?php esc_html_e('Password', 'wpopal-themer'); ?>" >
                                </div>
                                <div class="form-group">

                                    <input type="password" class="form-control" name="opalrgt_password2" id="ceopalrgt_password2" placeholder="<?php esc_html_e('Confirm Password', 'wpopal-themer'); ?>" >
                                </div>

                                <input type="hidden" name="opalrgt_current_url" id="opalrgt_current_url" value="<?php echo esc_attr(get_permalink()); ?>" />
                                <input type="hidden" name="redirection_url" id="redirection_url" value="<?php echo esc_attr(get_permalink()); ?>" />

                                <?php
                                // this prevent automated script for unwanted spam
                                if (function_exists('wp_nonce_field'))
                                    wp_nonce_field('opalrgt_register_action', 'opalrgt_register_nonce');
                                ?>
                                <button type="submit" class="btn btn-primary">
                                    <?php
                                    $submit_button_text = empty($opalrgt_settings['opalrgt_signup_button_text']) ? esc_html__('Register', 'wpopal-themer') : $opalrgt_settings['opalrgt_signup_button_text'];
                                    echo trim($submit_button_text);
                                    ?></button>
                            </form>
                        </div>
                    </div>

                </div></div>
        </div>
    </div>
    <?php
}

add_filter('wp_footer', 'footer');

function footer() {
    //CEForm();
    ?>
    <style>.loadingoverlay{z-index:9999999999999999;}</style>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.loadingoverlay/latest/loadingoverlay_progress.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#signup_link').on('click', function () {
                jQuery('#modalCELoginForm').modal('hide')
                jQuery('#modalCERegisterForm').modal('show')
            })
            jQuery('#donate').on('click', function () {
                jQuery('#donate_pop1').modal('show')

            })
            jQuery('#provide_donate').on('click', function () {
                if (jQuery('#donation_amount').val() == '') {
                    alert('Please enter donation amount.');
                    return false;
                }
                if (jQuery('#wpopal_:checked').length == 0) {
                    alert('Please select mode of donation.');
                    return false;
                }
                jQuery('#donation_amount_new').val(jQuery('#donation_amount').val())
                jQuery('#donate_pop1').modal('hide')
                jQuery('#donate_pop2').modal('show')

            })
            jQuery('.login-formce').on('submit', function (event) {
                event.preventDefault();
                jQuery('.login-formce .alert.alert-warning').hide();
                jQuery('.login-formce .alert.alert-success').hide();
                var pass = jQuery('#wpopal_password').val();
                var email = jQuery('#wpopal_email').val();
                if (email == '') {
                    jQuery('.login-formce .alert.alert-warning').show();
                    jQuery('.login-formce .alert.alert-warning').html('Please enter email address.')
                    return false;
                } else if (pass == '') {
                    jQuery('.login-formce .alert.alert-warning').show();
                    jQuery('.login-formce .alert.alert-warning').html('Please enter password.')
                    return false;
                } else {
                    jQuery('.login-formce .alert.alert-warning').hide();
                }
                jQuery.LoadingOverlay("show", {zIndex: 99999999999});
                jQuery.ajax({
                    url: "<?php echo plugins_url('CE/ajax.php', dirname(__FILE__)) ?>",
                    data: {
                        type: 'login',
                        email: email,
                        password: pass,
                        device_type: 'ios',
                        device_token: '23423'
                    },
                    type: 'POST',
                    success: function (result) {
                        jQuery.LoadingOverlay("hide");
                        var obj = jQuery.parseJSON(result);
                        console.info(obj);
                        if (obj.status == 'success') {
                            jQuery('.login-formce .alert.alert-success').show();
                            jQuery('.login-formce .alert.alert-warning').hide();
                            jQuery('.login-formce .alert.alert-success').html(obj.message)
                            setTimeout(function () {
                                window.location.href = ''
                            }, 1000);

                        } else {
                            jQuery('.login-formce .alert.alert-success').hide();
                            jQuery('.login-formce .alert.alert-warning').show();
                            jQuery('.login-formce .alert.alert-warning').html(obj.message)
                        }

                    }});

            });

            jQuery('#opalrgtRegisterFormCE').on('submit', function (event) {
                event.preventDefault();
                jQuery('#opalrgtRegisterFormCE .alert.alert-warning').hide();
                jQuery('#opalrgtRegisterFormCE .alert.alert-success').hide();
                var cpass = jQuery('#ceopalrgt_password2').val();
                var pass = jQuery('#ceopalrgt_password').val();
                var email = jQuery('#ceopalrgt_email').val();
                if (email == '') {
                    jQuery('#opalrgtRegisterFormCE .alert.alert-warning').show();
                    jQuery('#opalrgtRegisterFormCE .alert.alert-warning').html('Please enter email address.')
                    return false;
                } else if (pass == '') {
                    jQuery('#opalrgtRegisterFormCE .alert.alert-warning').show();
                    jQuery('#opalrgtRegisterFormCE .alert.alert-warning').html('Please enter password.')
                    return false;
                } else if (pass != cpass) {
                    jQuery('#opalrgtRegisterFormCE .alert.alert-warning').show();
                    jQuery('#opalrgtRegisterFormCE .alert.alert-warning').html('Please enter correct confirm password.')
                    return false;
                } else {
                    jQuery('#opalrgtRegisterFormCE .alert.alert-warning').hide();
                }
                jQuery.LoadingOverlay("show", {zIndex: 99999999999});
                jQuery.ajax({
                    url: "<?php echo plugins_url('CE/ajax.php', dirname(__FILE__)) ?>",
                    data: {
                        type: 'signup',
                        email: email,
                        password: pass,
                        device_type: 'ios',
                        device_token: '23423'
                    },
                    type: 'POST',
                    success: function (result) {
                        jQuery.LoadingOverlay("hide");
                        var obj = jQuery.parseJSON(result);
                        console.info(obj);
                        if (obj.status == 'success') {
                            jQuery('#opalrgtRegisterFormCE .alert.alert-success').show();
                            jQuery('#opalrgtRegisterFormCE .alert.alert-warning').hide();
                            jQuery('#opalrgtRegisterFormCE .alert.alert-success').html(obj.message)
                            setTimeout(function () {
                                window.location.href = ''
                            }, 1000);

                        } else {
                            jQuery('#opalrgtRegisterFormCE .alert.alert-success').hide();
                            jQuery('#opalrgtRegisterFormCE .alert.alert-warning').show();
                            jQuery('#opalrgtRegisterFormCE .alert.alert-warning').html(obj.message)
                        }

                    }});

            });



        });


        Stripe.setPublishableKey('pk_test_biq6MQQbCCtIWE3VZd5qslkA');
        var $form = jQuery('#payment-form');
        var $result = jQuery('#payment-result');
        jQuery(function () {
            $form.submit(function (event) {
                if (jQuery('#donor_email').val() == '') {
                    alert('Please enter email');
                    return false;
                }
                if (jQuery('#card_holderName').val() == '') {
                    alert('Please enter card holder name');
                    return false;
                }
                if (jQuery('#donation_amount_new').val() == '') {
                    alert('Please enter donation amount');
                    return false;
                }
                $form.find('.errors').text('');
                $form.find('.submit').prop('disabled', true);

                if (Stripe.card.validateCardNumber(jQuery('#number').val())
                        && Stripe.card.validateCVC(jQuery('#cvc').val())) {
                    Stripe.card.createToken({
                        number: jQuery('.card-number').val(),
                        cvc: jQuery('.card-cvc').val(),
                        exp_month: jQuery('.card-expiry-month').val(),
                        exp_year: jQuery('.card-expiry-year').val()
                    }, stripeResponseHandler);
                } else {
                    $form.find('.errors').text('Please enter valid test credit card information.');
                    jQuery('#payment-result').text('');
                    $form.find('.submit').prop('disabled', false);
                }
                return false;
            });
        });
        function stripeResponseHandler(status, response) {
            if (response.error) {
                //$form.find('.errors').text(response.error.message);
                alert(response.error.message);
                jQuery('#payment-result').text('');
                $form.find('.submit').prop('disabled', false);
            } else {
                jQuery('.errors').text('');
                //Your Stripe token is: <strong>' + response.id + '</strong><br>This would then automatically be submitted to your server. 
                $result.html('Please wait...');
                jQuery.LoadingOverlay("show", {zIndex: 99999999999});
                jQuery.ajax({
                    url: '<?php echo plugins_url('CE/ajax.php', dirname(__FILE__)) ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        type: 'send_campaign_donation',
                        campaign_id: jQuery('#campaign_id').val(),
                        organizer_id: jQuery('#organizer_id').val(),
                        donation_amount: jQuery('#donation_amount_new').val(),
                        stripe_tokenId: response.id,
                        donor_email: jQuery('#donor_email').val(),
                        card_holderName: jQuery('#card_holderName').val(),
                        anonymous_donor: jQuery('#anonymous_donor').val()

                    },
                    success: function (data) {
                        jQuery.LoadingOverlay("hide");
                        if (data.status == 'success') {
                            alert(data.message);
                            window.location.href = "";
                        } else {
                            alert(data.message);
                        }
                    }
                });
            }
        }
    </script>
    <?php
}
?>

