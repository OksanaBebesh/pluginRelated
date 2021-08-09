<?php
global $post;
$orig_post = $post;
function drawPost(){
    $str = '<div class="relatedposts"><h3>Related posts</h3>';
    $my_query = getDataPost();
    foreach ($my_query->have_posts() as $value)  {
        $value->the_post();
        $str .= '<div class="relatedthumb">';
        $str .= '<a rel="nofollow" target="_blank" href="'
            . the_permalink() . '>'
            . the_post_thumbnail(array(150, 100))
            . '<br />'
            . the_title()
            . '</a>
            </div>';
    }
        $str .= "</div>";
    return $str;
}

function getDataPost(){
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $individual_tag){
            $tag_ids[] = $individual_tag->term_id;
        }
            $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page' => 6, // Number of related posts to display.
            'caller_get_posts' => 1
            );
            $my_query = new wp_query($args);
            $post = $orig_post;
            wp_reset_query();
        return $my_query;
    }
}
