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

function create_login_page() {
	$post_id = -1;

	// Setup custom vars
	$author_id = 1;
	$slug = 'login';
	$title = 'Login';

	// Check if page exists, if not create it
	if ( null == get_page_by_title( $title )) {

		$login_page = array(
						'comment_status'        => 'closed',
						'ping_status'           => 'closed',
						'post_author'           => $author_id,
						'post_name'             => $slug,
						'post_title'            => $title,
						'post_status'           => 'publish',
						'post_type'             => 'page'
		);
		$post_id = wp_insert_post( $login_page );

		if ( !$post_id ) {
				wp_die( 'Error creating template page' );
		} else {
				update_post_meta( $post_id, '_wp_page_template', 'custom-uploadr.php' );
		}
	} // end check if
}


function login_page_redirect( $template ) {
	$plugindir = dirname( __FILE__ );

	if ( !is_page_template( 'page-login.php' )) {
		$template = $plugindir . '/templates/page-login.php';
	}

	return $template;
}


function restrict_post_deletion($post_ID){
		$restricted_page = get_page_by_path('login');
		if($post_ID == $restricted_page->ID){
				echo "You are not authorized to delete this page.";
				exit;
		}
}

/* Main redirection of the default login page */
function redirect_login_page() {
	$login_page  = home_url('/login/');
	$page_viewed = basename($_SERVER['REQUEST_URI']);

	//check if user is logged in, if wp-admin page is viewed and if method is GET
	if(!is_user_logged_in() && $page_viewed == "wp-admin" && $_SERVER['REQUEST_METHOD'] == 'GET'){
		//if condition is met, redirect to login page
		wp_redirect($login_page);
		exit;
	}

	//check if wp-login page is viewed and method is GET
	if( ($page_viewed == "wp-login.php" || $page_viewed == "wp-login") && $_SERVER['REQUEST_METHOD'] == 'GET') {
		//if condition is met, redirect to login page
		wp_redirect($login_page);
		exit;
	}
}


/* Where to go if a login failed */
function custom_login_failed() {
	$login_page  = home_url('/login/');
	wp_redirect($login_page . '?login=failed');
	exit;
}


/* Where to go if any of the fields were empty */
function verify_user_pass($user, $username, $password) {
	$login_page  = home_url('/login/');
	if(($username == "" || $password == "") && $_SERVER['REQUEST_METHOD'] == 'POST') {
		wp_redirect($login_page . "?login=empty");
		exit;
	}
}


/* What to do on logout */
function logout_redirect() {
	$login_page  = home_url('/login/');
	wp_redirect($login_page . "?login=false");
	exit;
}

    register_activation_hook( __FILE__, 'create_login_page');
		add_action( 'template_include', 'login_page_redirect' );

		add_action('wp_trash_post', 'restrict_post_deletion', 10, 1);
		add_action('before_delete_post', 'restrict_post_deletion', 10, 1);

		add_action('init','redirect_login_page');
		add_action('wp_login_failed', 'custom_login_failed');
		add_filter('authenticate', 'verify_user_pass', 1, 3);
		add_action('wp_logout','logout_redirect');

?>
