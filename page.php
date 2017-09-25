<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
// Track pageviews
wpb_set_post_views(get_the_ID());
$views = wpb_get_post_views(get_the_ID());

$post = get_post();

$title = $post->post_title;

?>


<?php
if ($title == "Podcast") {

  $page = explode('/', $_SERVER['REQUEST_URI'])[2];
  if ($page == '') {
    $page = 1;
  }

  $total = wp_count_posts('podcast')->publish;
  $page_size = 10;
  $offset = $page_size*($page-1);
  $more = ($page_size*$page < $total);

  $args = array(
    'posts_per_page'   => $page_size,
    'offset'           => $offset,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => 'podcast',
    'post_status'      => 'publish',
    'suppress_filters' => true
  );
  $podcasts = get_posts( $args );
  // echo count($podcasts);
  // print_r($podcasts);
  ?>
  <div class="archive-list">
    <title><?php echo $title ?> - Nintendo Fusion</title>
    <h1>Categoria: <?php echo $title ?></h1>

    <?php

    foreach($podcasts as $post) {
      ?>

      <!-- <h2>Vídeos &<br/> Podcast</h2> -->
      <?php
      // print_r($others_array);
      // echo $post;
      $cat = $post->post_type;
      if ($cat == "podcast") {
        $category = "Podcast";
      } else {
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          $parent = get_the_category_by_ID($cat->parent);
          if ($parent == "Matéria") {
            $category = $cat->cat_name;
          }
        }
      }

      $permalink = get_post_permalink($post->ID);
      $time = get_the_time('j \d\e F \d\e Y', $post->ID);
      $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
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



      <?php
    } ?>
    <div class="all">
      <?php if ($page > 1) { ?>
        <a href="<?php echo site_url(); ?>/podcast/<?php echo $page-1; ?>">
          Página anterior
        </a>
        <?php
      }
      ?>
      <?php if (($page > 1) && $more) { ?>
        <span class="spacing"> </span>
        <?php
      }
      ?>
      <?php if ($more) { ?>
        <a href="<?php echo site_url(); ?>/podcast/<?php echo $page+1; ?>">
          Próxima página
        </a>
        <?php
      }
      ?>
    </div>
  </div>

  <?php
} else {

  $coauthors = coauthors_posts_links(', ', ' e ', null, null, false);
  ?>

  <link href="<?php echo get_bloginfo('template_url'); ?>/css/single.css" rel="stylesheet">

  <title><?php echo $title; ?> - Nintendo Fusion</title>
  <div class="content review-content">
    <h1><?php echo $title; ?></h1>

    <!-- <div class="review-date">
      <?php the_time('j \d\e F \d\e Y'); ?>
    </div>

    <div class="review-author">
      POR
      <?php
      echo $coauthors;
      ?>
    </div> -->

    <?php the_content();  ?>
  </div>

  <?php
}
?>



<?php endwhile; else: ?>
  <p><?php _e('Sorry, this page does not exist.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
