<?php
// This function should be put in functions.php until code is refactored to send argument to the add_filter callback
function posts_orderby_lastname($orderby_statement, $order = 'ASC') 
{
    $orderby_statement = "RIGHT(post_title, LOCATE(' ', REVERSE(post_title)) - 1)" . $order;
    return $orderby_statement;
}
add_filter( 'posts_orderby' , 'posts_orderby_lastname' );

function lnamequery($posts_per_page, $category_slug) {
    if ($category_slug != 'all' || $category_slug != '') {
        $args = array (
            'post_type' => 'post',
            'orderby' => 'title',
            'posts_per_page' => $posts_per_page, //1 to -1
            'category_name' => $category_slug
        ); 
    }
    else {
        $args = array (
            'post_type' => 'post',
            'orderby' => 'title',
            'posts_per_page' => $posts_per_page, //1 to -1
        );
    }
    $lnamequery = new WP_Query( $args );
    return $lnamequery;
}

?>