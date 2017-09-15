<?php get_header();

if ( is_category() ) {

    $title = 'Categoria: '.single_cat_title('', false);

} elseif ( is_tag() ) {

    $title = 'Tag: '.single_tag_title('', false);

} elseif ( is_author() ) {

  $title = 'Autor: '.get_the_author();

} else {
  $title = 'Categoria: '.post_type_archive_title('', false);
}

?>
<title><?php echo $title; ?> - Nintendo Fusion</title>
<div class="archive-list">
  <h1><?php echo $title; ?></h1>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
    $categories = get_the_category();
    $category = $categories[0]->cat_name;
    $permalink = get_post_permalink($post->ID);
    $excerpt = get_the_excerpt($post->ID);
    $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
    $image = get_post_meta($post->ID, 'icone', true);
    if ($image == '') {
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
    }
    ?>
    <div class="list-news">
      <a href="<?php echo $permalink; ?>">
        <div class="list-news-image" style="background-image: url('<?php echo $image; ?>')">
        </div>
      </a>
        <div class="list-news-contents">
          <a href="<?php echo $permalink; ?>">
            <h4>
              <?php echo $category; ?>
            </h4>
            <div class="list-news-title">
              <?php echo $post->post_title; ?>
            </div>
          </a>

          <div class="authors">
            POR <?php echo $coauthors; ?>
          </div>
          <div class="list-news-excerpt">
            <p><?php echo $excerpt ?></p>
          </div>
          <?php the_time('j \d\e F \d\e Y'); ?>
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
