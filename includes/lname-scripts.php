<?php 
// Add Scripts
function lastname_add_scripts() {
    // main css
    wp_enqueue_style('lastname-css', plugins_url() . 'lastname-loop/css/style.css');
}

add_action('wp_enqueue_scripts', 'lastname_add_scripts');
?>