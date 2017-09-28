<?php get_header();

if ( is_category() ) {

    $title = 'Categoria: '.single_cat_title('', false);

} elseif ( is_tag() ) {

    $title = 'Tag: '.single_tag_title('', false);

} elseif ( is_author() ) {

  $uri = explode('/', $_SERVER['REQUEST_URI']);
  $title = 'Autor: '.get_user_by('slug', $uri[count($uri)-2])->display_name;

} else {
  $title = 'Categoria: '.post_type_archive_title('', false);
}

?>
<title><?php echo $title; ?> - Nintendo Fusion</title>
<div class="archive-list">
  <h1><?php echo $title; ?></h1>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
  $categories = get_the_category();
  if (count($categories) != 0) {
    $category = $categories[0]->cat_name;
  }
  if ($post->post_type == 'podcast') {
    $category = "Podcast";
  }

  $permalink = get_post_permalink($post->ID);
  $excerpt = get_the_excerpt($post->ID);
  $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
  $image = get_post_meta($post->ID, 'icone', true);
  if ($image == '') {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
    $image_mobile = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
  } else {
    $image_mobile = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME).'-150x150.jpg';
  }

  $title = $post->post_title;
  $subtitle = "";
  $title_class = "list-news-title-1";
  if ($pos = strpos($post->post_title, ':')) {
    $title = substr($post->post_title, 0, $pos+1);
    $title_class = "list-news-subtitle-1";
    $subtitle = substr($post->post_title, $pos+2);
    $subtitle_class = "list-news-title-1";
  } else if ($pos = strpos($post->post_title, '~')) {
    $title = substr($post->post_title, 0, $pos);
    $title_class = "list-news-subtitle-1";
    $subtitle = substr($post->post_title, $pos+2);
    $subtitle_class = "list-news-title-1";
  } else if ($pos = strpos($post->post_title, '(')) {
    $title = substr($post->post_title, 0, $pos-1);
    $title_class = "list-news-title-1";
    $subtitle = substr($post->post_title, $pos+1, strlen($post->post_title)-strlen($title)-3);
    $subtitle_class = "list-news-subtitle-1";
  }
  ?>


  <style>
  #list-news-image-<?php echo $post->ID; ?> {
    background-image: url('<?php echo $image; ?>');
  }

  @media (max-width: 600px) {
    #list-news-image-<?php echo $post->ID; ?> {
      background-image: url('<?php echo $image_mobile; ?>');
    }
  }
  </style>

  <div class="list-news">
    <a href="<?php echo $permalink; ?>">
      <div class="list-news-image" id="list-news-image-<?php echo $post->ID; ?>">
      </div>
    </a>
      <div class="list-news-contents">
        <div class="list-news-mobile-contents">
          <a href="<?php echo $permalink; ?>">
            <h4>
              <?php echo $category; ?>
            </h4>
            <div class="list-news-title">
              <div class="<?php echo $title_class; ?>">
                <?php echo $title; ?>
              </div>
              <div class="<?php echo $subtitle_class; ?>">
                <?php echo $subtitle; ?>
              </div>
            </div>
          </a>

          <div class="authors">
            POR <?php echo $coauthors; ?>
          </div>
          <div class="list-news-excerpt">
            <?php echo $excerpt ?>
          </div>
          <!-- <?php the_time('j \d\e F \d\e Y'); ?> -->
        </div>
      </div>
  </div>

    <?php endwhile; else: ?>
      <p><?php _e('Nenhum post encontrado.'); ?></p>
    <?php endif; ?>

    <div class="all">
      <?php posts_nav_link('<span class="spacing"> </span>','Anterior','Próxima'); ?>
    </div>
</div>

<?php get_footer(); ?>
