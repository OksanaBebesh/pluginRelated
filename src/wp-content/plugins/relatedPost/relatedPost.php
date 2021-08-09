<?php
/*
Plugin Name: Related Post Plugin
Description: Плагин получения актуальных постов
Version: 1.0
Author: Имя автора
*/

if( wp_doing_ajax() ) {
    add_action('wp_ajax_my_action', 'my_action_callback');
    add_action('wp_ajax_nopriv_my_action', 'my_action_callback');
}

add_action('wp_enqueue_scripts', 'include_custom_jquery');
function include_custom_jquery(){
    wp_enqueue_script('jquery');
}

require_once (__DIR__.'/functions.php');
function my_action_callback(){

    $category = $_POST['postSlug'];

    $termIds = [];
    foreach ($category as $value) {
        $termIds[] = $value['term_id'];
    }

    $arg = array(
        'post_type' => 'post',
    );

    $query = new WP_Query(array($arg));
    echo json_encode($query->get_posts());

    wp_die();
}

//todo add js file /js/script.js  "handler" = "relatedpost"

add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){
    global $post;

    $categorayIds = wp_get_post_categories($post->ID);
    $termIds = wp_get_post_terms($post->ID);

    wp_enqueue_script('relatedpost', '/wp-content/plugins/relatedPost/js/script.js');
    wp_localize_script( 'relatedpost', 'myajax',
        [
            'post' => $post,
            'postCategory' => $categorayIds,
            'postTerms' => $termIds,
            'url' => admin_url('admin-ajax.php')
        ]
    );

}
