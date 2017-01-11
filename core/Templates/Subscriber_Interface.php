<?php
/**
 * A Subscriber knows what specific WordPress plugin API hooks it wants to register to.
 * 
 * When an EventManager adds a Subscriber, it gets all the hooks that it wants to 
 * register to. It then registers the subscriber as a callback with the WordPress 
 * plugin API for each of them.
 *
 * @author Carl Alexander <contact@carlalexander.ca>
 */

namespace ItalyStrap\Core\Templates;

if ( ! defined( 'ABSPATH' ) or ! ABSPATH ) {
	die();
}

interface Subscriber_Interface {
    /**
     * Returns an array of hooks that this subscriber wants to register with
     * the WordPress plugin API.
     *
     * The array key is the name of the hook. The value can be:
     *
     *  * The method name
     *  * An array with the method name and priority
     *  * An array with the method name, priority and number of accepted arguments
     *
     * For instance:
     *
     *  * array('hook_name' => 'method_name')
     *  * array('hook_name' => array('method_name', $priority))
     *  * array('hook_name' => array('method_name', $priority, $accepted_args))
     *
     * @return array
     */
    public static function get_subscribed_hooks();
}
