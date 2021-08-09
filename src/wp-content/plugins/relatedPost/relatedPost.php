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
    echo "$category_post: = ";
    echo $category_post;
    wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}


add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('relatedpost','/wp-content/plugins/relatedPost/js/script.js');
    global $post;
    $postСategories = wp_get_post_categories($post->ID);

    $taxonomies = wp_get_object_terms( $post->ID, 'category', ['fields' => 'All'] );
    $queryWithPost = new WP_Query([
        'category__in' => $postСategories,
        'post_status' => "publish",
        'posts_per_page' => 6,
    ]);
    $result = [];
   foreach($queryWithPost as $postInfo){
       if ($postInfo->post_title !=null){

           $result [] = [
               'post-title' => $postInfo->post_title,
               'post-content' => $postInfo->post_content
           ];

       }

    }
    //todo check !!!
    wp_localize_script( 'relatedpost', 'myajaxData',
        array(
            'url' => admin_url('admin-ajax.php'),
            'category_post_boby' => $queryWithPost,
            'category_post' => $postСategories,
            'taxonomies' => $taxonomies,
            'result' => $result,
        )
    );
}



