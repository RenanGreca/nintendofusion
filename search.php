<?php get_header();

// global $wp_query;
// $total_results = $wp_query->found_posts;

// echo $wp_query;
?>
<title>Busca - Nintendo Fusion</title>
<div class="archive-list">
  <?php
  if ($_GET['s'] == '') {
    ?>
    <h1>Acervo</h1>
    <?php
  } else {
    ?>
    <h1>Busca por "<?php echo $_GET['s'] ?>"</h1>
    <?php
  }
  ?>
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
  // $post = the_post();
  // echo 'hello'.$post->post_type;
  $categories = get_the_category();
  if (count($categories) != 0) {
    $category = $categories[0]->cat_name;
  }
  if ($post->post_type == 'podcast') {
    $category = "Podcast";
  }
  if ($post->post_type == 'page') {
    continue;
  }
  // echo the_post()->post_type;
  // if ($category == ''){
  // $category = get_the_type();
  // echo $category;
  // }
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
      <div class="list-news-date">
        em <?php the_time('j \d\e F \d\e Y'); ?>
      </div>
      <div class="list-news-excerpt">
        <p><?php echo $excerpt ?></p>
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
