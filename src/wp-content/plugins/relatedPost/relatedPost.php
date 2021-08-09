<?php
/*
Plugin Name: Related Post Plugin
Description: Плагин получения актуальных постов
Version: 1.0
Author: Имя автора
*/
require_once (__DIR__.'/functions.php');

add_action( 'wp_ajax_get_related_post', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_get_related_post', 'my_action_callback' );
function my_action_callback(){
    $category_post = $_POST['category_post'];
    $termIds = [];
    foreach ($category_post as $value) {
        $termIds[] = $value['term_id'];
    }

    $queryRelatedPost =
        new WP_Query([
            'category__in' => $category_post,
            'post_status' => 'publish',
            'page' => 'post'
        ]);
    echo json_encode($queryRelatedPost->get_posts());
    wp_die();
}


add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('relatedpost','/wp-content/plugins/relatedPost/js/script.js');
    global $post;
    $PostCategories = wp_get_post_categories($post->ID);
    //TODO  wp_get_object_terms - function - the best of wp_get_post_categories()
    //$taxonomies = wp_get_object_terms( $post->ID, 'category', ['fields' => 'All'] );

    //TODO check !!!
    wp_localize_script( 'relatedpost', 'myajaxData',
        array(
            'url' => admin_url('admin-ajax.php'),
            'category_post' => $PostCategories,
        )
    );
}
