<?php

function wpbootstrap_scripts_with_jquery()
{
    // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

add_theme_support( 'post-thumbnails' );

function new_excerpt_more( $more ) {
    return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

// Used to track number of views in each post
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}

function nf_score_to_word($score) {
  if ($score == 10) {
    return "Obra-prima";
  } else if ($score >= 9) {
    return "Excelente";
  } else if ($score >= 8) {
    return "Ótimo";
  } else if ($score >= 7) {
    return "Bom";
  } else if ($score >= 6) {
    return "Aceitável";
  } else if ($score >= 5) {
    return "Medíocre";
  } else if ($score >= 4) {
    return "Ruim";
  } else if ($score >= 3) {
    return "Muito ruim";
  } else if ($score >= 2) {
    return "Desagradável";
  } else if ($score >= 1) {
    return "Desastre";
  } else if ($score == 0) {
    return "Péssimo";
  }
}

?>
