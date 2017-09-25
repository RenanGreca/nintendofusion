<?php

add_action( 'init', 'set_theme_cookie' );
// Dark and light theme cookie
function set_theme_cookie() {
  $theme_id = 'dark';
  // If there already is a cookie, set current theme to it.
  if (isset($_COOKIE['theme']) &&
      (($_COOKIE['theme'] == 'dark') || ($_COOKIE['theme'] == 'light'))) {

      $theme_id = $_COOKIE['theme'];
  }
  // If there is a theme on the GET parameters, create or update the cookie.
  if (isset($_GET['theme']) &&
      (($_GET['theme'] == 'dark') || ($_GET['theme'] == 'light'))) {

      $theme_id = $_GET['theme'];
      setcookie('theme', $theme_id, time() + (86400 * 30), "/");
  }

  $GLOBALS['theme'] = $theme_id;
}

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info
function insert_fb_in_head() {
    global $post;
    if ( !is_singular()) //if it is not a post or a page
        return;
        echo '<meta property="fb:admins" content="1001692808"/>
        ';
        echo '<meta property="fb:admins" content="100000307065898"/>
        ';
        echo '<meta property="og:title" content="' . str_replace('~', '', get_the_title()) . '"/>
        ';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>
        ';
        echo '<meta property="og:description" content="' . get_the_excerpt() . '"/>
        ';
        echo '<meta property="og:site_name" content="Nintendo Fusion"/>
        ';
        echo '<meta property="fb:app_id" content="976575375818675"/>
        ';
        if (!has_post_thumbnail( $post->ID )) {
            //the post does not have featured image, use a default image
            $image = get_bloginfo('template_url')."/img/wallpaper-small.png";
        } else {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
        }
        $image_size = getimagesize($image);
        echo '<meta property="og:image" content="' . $image . '"/>
        ';
        echo '<meta property="og:image:width" content="' . $image_size[0] . '"/>
        ';
        echo '<meta property="og:image:height" content="' . $image_size[1] . '"/>
        ';
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

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
