<?php
/*
   Plugin Name: My Custom Login
   Plugin URI: http://trajcheroshkoski.com/
   description: a plugin to create custom login page
   Version: 1.0
   Author: Trayche Roshkoski
   Author URI: http://trajcheroshkoski.com/
   License: GPL2
*/
require_once 'helper.php';
require_once('templates/theme-page.php');
require_once('option-page.php');

class MyCustomLogin {
     static function install() {
			 add_action( 'template_include', array( 'Helper', 'login_page_redirect' ) );

			 add_action('wp_trash_post', array( 'Helper', 'restrict_post_deletion' ), 10, 1);
			 add_action('before_delete_post', array( 'Helper', 'restrict_post_deletion' ), 10, 1);

			 add_action('init', array( 'Helper', 'redirect_login_page' ));
			 add_action('wp_login_failed', array( 'Helper', 'custom_login_failed' ));
			 add_filter('authenticate', array( 'Helper', 'verify_user_pass' ), 1, 3);
			 add_action('wp_logout', array( 'Helper', 'logout_redirect' ));
     }

		 function deactivate(){
			 //add code
		 }

		 function uninstall(){
			 //add code
		 }

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
}
register_activation_hook( __FILE__, array( 'MyCustomLogin', 'install' ) );
register_activation_hook( __FILE__, array( 'MyCustomLogin', 'create_login_page' ) );

register_deactivation_hook( __FILE__, array( 'MyCustomLogin', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'MyCustomLogin', 'uninstall' ) );

?>
