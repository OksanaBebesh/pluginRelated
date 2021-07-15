<?php
/*
Plugin Name: Related Post Plugin
Description: Плагин получения актуальных постов
Version: 1.0
Author: Имя автора
*/
require_once (__DIR__.'/functions.php');

add_action( 'wp_ajax_test_action', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_test_action', 'my_action_callback' );
function my_action_callback(){
    $whatever = $_POST['whatever'];
    $whatever += 10;
    echo 1111;
    wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}

wp_enqueue_script('jquery');
add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){

    //todo check !!!
    wp_localize_script( 'relatedpost', 'ajaxurl123',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );
}

add_action( 'wp_footer', 'my_action_javascript', 99 );
function my_action_javascript() {
    ?>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var myajax = {"url":"http://wordpress.loc/wp-admin/admin-ajax.php"};
        /* ]]> */
    </script>
    <script>
        jQuery(document).ready( function( $ ){
            // console.log(ajaxurl123)
            var data = {
                action: 'test_action',
                whatever: 1234
            };
            // с версии 2.8 'ajaxurl' всегда определен в админке
            jQuery.post( myajax.url , data, function( response ){

                alert( 'Получено с сервера: ' + response );
            } );
        } );
    </script>
    <?php
}