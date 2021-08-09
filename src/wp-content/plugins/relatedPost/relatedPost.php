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


//    $queryRelatedPost =
//        get_posts([
//            'category__in' => $category_post,
//            'post_status' => 'publish',
//            'page' => 'post'
//        ]);
//$strResult = '';
//foreach($queryRelatedPost as $post) {
//
//$strResult .=
//    '<article id="post-13" class="post-13 post type-post status-publish format-standard hentry category-dress entry">
//	<header class="entry-header alignwide">
//		<h1 class="entry-title">'.$post.'</h1>
//	</header>
//	<div class="entry-content">
//        <p>'.$post.'</p>
//	</div>
//	<footer class="entry-footer default-max-width">
//		<div class="posted-by">
//		<span class="posted-on">Published
//		    <time class="entry-date published updated" datetime="2021-08-08T20:06:54+00:00">August 8, 2021</time>
//		</span>
//		<span class="byline">By <a href="http://wordpress.loc/author/pluginrelated/" rel="author">pluginRelated</a></span></div>
//		<div class="post-taxonomies">
//		<span class="cat-links">Categorized as <a href="http://wordpress.loc/category/dress/" rel="category tag">dress</a> </span></div>
//	</footer>
//    </article>';
//
//}
//echo $strResult ;
//    wp_reset_postdata();
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
