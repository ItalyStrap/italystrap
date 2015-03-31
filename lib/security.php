<?php
/**
 * Modify WordPress login for security
 * @since 2.0
 */
function italystrap_login_errors( $error ){
    return __('<strong>Login Failed</strong>: please check your username and password.', 'ItalyStrap');
}

add_filter( 'login_errors', 'italystrap_login_errors' );