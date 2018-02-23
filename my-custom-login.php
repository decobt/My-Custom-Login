<?php
/*
   Plugin Name: My Custom Login
   Plugin URI: http://my-awesomeness-emporium.com
   description: a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: Mr. Awesome
   Author URI: http://mrtotallyawesome.com
   License: GPL2
*/

require_once('templates/theme-page.php');
require_once('option-page.php');

/* Main redirection of the default login page*/
function redirect_login_page() {
 $login_page  = home_url('/login/');
 $page_viewed = basename($_SERVER['REQUEST_URI']);

 if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
   wp_redirect($login_page);
   exit;
 }
}
add_action('init','redirect_login_page');

/* Where to go if a login failed*/
function custom_login_failed() {
 $login_page  = home_url('/login/');
 wp_redirect($login_page . '?login=failed');
 exit;
}
add_action('wp_login_failed', 'custom_login_failed');

/* Where to go if any of the fields were empty*/
function verify_user_pass($user, $username, $password) {
 $login_page  = home_url('/login/');
 if($username == "" || $password == "") {
   wp_redirect($login_page . "?login=empty");
   exit;
 }
}
add_filter('authenticate', 'verify_user_pass', 1, 3);

/* What to do on logout*/
function logout_redirect() {
 $login_page  = home_url('/login/');
 wp_redirect($login_page . "?login=false");
 exit;
}
add_action('wp_logout','logout_redirect');

?>
