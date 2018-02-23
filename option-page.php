<?php
/*
Name: Option Page
Version: 1.0
Author: Trayche Roshkoski
*/

//Register a custom menu page.
function register_plugin_menu_page() {
    add_menu_page(
        __( 'My Custom Login', 'my-custom-login' ),
        'My Custom Login',
        'manage_options',
        'my-custom-login',
        'my_custom_login_menu_page',
        plugins_url( 'my-custom-login/assets/images/icon.png' )
    );
}
add_action( 'admin_menu', 'register_plugin_menu_page' );

/**
 * Display the menu page
 */
function my_custom_login_menu_page(){
  //print the title
  print_r ('<h2>My Custom Login</h2>');
}

 ?>
