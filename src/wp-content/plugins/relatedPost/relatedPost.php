<?php
/*
Plugin Name: Related Post Plugin
Description: Plugin getting actual post
Version: 1.0
Author: Author
*/


add_action( 'wp_ajax_get_related_post', 'print_related_posts' );
add_action( 'wp_ajax_nopriv_get_related_post', 'print_related_posts' );
function print_related_posts(){
    $category_post = $_POST['category_post'];
    $queryRelatedPost =
        new WP_Query([
            'category__in' => $category_post,
            'post_status' => 'publish',
            'page' => 'post'
        ]);

    $relatedPost =$queryRelatedPost->get_posts();
    $strResult = '';

foreach($relatedPost as $post) {
    $strResult .=
        '<article id="post-13" class="post-13 post type-post status-publish format-standard hentry category-dress entry">
        <header class="entry-header alignwide">
            <h1 class="entry-title">'.$post->post_title.'</h1>
        </header>
        <div class="entry-content">
            <p>'.$post->post_content.'</p>
        </div>
        <footer class="entry-footer default-max-width">
            <div class="posted-by">
            <span class="posted-on">Published
                <time class="entry-date published updated" datetime="2021-08-08T20:06:54+00:00">'.$post->post_date.'</time>
            </span>
            <span class="byline">By <a href="http://wordpress.loc/author/pluginrelated/" rel="author">pluginRelated</a></span></div>
            <div class="post-taxonomies">
            <span class="cat-links">Categorized as <a href="http://wordpress.loc/category/dress/" rel="category tag">dress</a> </span></div>
        </footer>
        </article>';
    }
    echo json_encode($strResult,false) ;
    wp_reset_postdata();
    wp_die();
}


add_action( 'wp_enqueue_scripts', 'ajax_data_send', 99 );
function ajax_data_send(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('relatedpost',plugins_url('relatedPost').'/js/script.js');
    global $post;
    $PostCategories = wp_get_post_categories($post->ID);
    wp_localize_script( 'relatedpost', 'ajaxDataSend',
        array(
            'url' => admin_url('admin-ajax.php'),
            'category_post' => $PostCategories,
        )
    );
}
