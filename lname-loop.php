<?php 
/*
Plugin Name:       Last Name Loop
Plugin URI:        https://github.com/clemmerwis
Description:       Loop a category of posts alphabetically by last name
Version:           1.0.0
Author:            Christopher John Lemmer
Author URI:        https://github.com/clemmerwis
*/

// Exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}


// Load scripts
require_once(plugin_dir_path(__FILE__) . '/includes/lname-scripts.php');

// Load php functions
require_once(plugin_dir_path(__FILE__) . '/includes/lname-funcs.php');

// Load Class
require_once(plugin_dir_path(__FILE__) . '/includes/lname-class.php');

// Register Widget
function register_lname() {
    register_widget('lname_Widget');
}
add_action('widgets_init', 'register_lname');