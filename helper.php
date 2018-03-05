<?php

class Helper {
    public function login_page_redirect( $template ) {
    	$plugindir = dirname( __FILE__ );

    	if ( !is_page_template( 'page-login.php' )) {
    		$template = $plugindir . '/templates/page-login.php';
    	}

    	return $template;
    }

    public function restrict_post_deletion($post_ID){
    		$restricted_page = get_page_by_path('login');
    		if($post_ID == $restricted_page->ID){
    				echo "You are not authorized to delete this page.";
    				exit;
    		}
    }

    /* Main redirection of the default login page */
    public function redirect_login_page() {
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
    public function custom_login_failed() {
    	$login_page  = home_url('/login/');
    	wp_redirect($login_page . '?login=failed');
    	exit;
    }


    /* Where to go if any of the fields were empty */
    public function verify_user_pass($user, $username, $password) {
    	$login_page  = home_url('/login/');
    	if(($username == "" || $password == "") && $_SERVER['REQUEST_METHOD'] == 'POST') {
    		wp_redirect($login_page . "?login=empty");
    		exit;
    	}
    }


    /* What to do on logout */
    public function logout_redirect() {
    	$login_page  = home_url('/login/');
    	wp_redirect($login_page . "?login=false");
    	exit;
    }
}

?>
