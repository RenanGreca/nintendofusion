<?php get_header();?>
<link href="<?php echo get_bloginfo('template_url'); ?>/css/single.css" rel="stylesheet">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10&appId=976575375818675";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
// Track pageviews
wpb_set_post_views(get_the_ID());
$views = wpb_get_post_views(get_the_ID());

$post = get_post();
$categories = get_the_category();
$category = $categories[0];

$image_full = wp_get_attachment_image_src( get_post_thumbnail_id(),
'single-post-thumbnail' )[0];
$image_mobile = wp_get_attachment_image_src( get_post_thumbnail_id(),
'large' )[0];

// if ( function_exists( 'coauthors_posts_links' ) ) {
$coauthors = coauthors_posts_links(', ', ' e ', null, null, false);
$posttags = get_the_tags();
// } else {
//     the_author_posts_link();
// }

$title = $post->post_title;
$subtitle = "";
$title_class = "review-maintitle";
if ($pos = strpos($post->post_title, ':')) {
  $title = substr($post->post_title, 0, $pos+1);
  $title_class = "review-subtitle";
  $subtitle = substr($post->post_title, $pos+2);
  $subtitle_class = "review-maintitle";
} else if ($pos = strpos($post->post_title, '(')) {
  $title = substr($post->post_title, 0, $pos-1);
  $title_class = "review-maintitle";
  $subtitle = substr($post->post_title, $pos+1, strlen($post->post_title)-2);
  $subtitle_class = "review-subtitle";
}

$meta_fields = get_post_custom();

$disclaimer = $meta_fields['disclaimer'][0];


// print_r($post);
$args = array(
'posts_per_page'   => 3,
'exclude'          => $post->ID,
'orderby'          => 'meta_value_num',
'meta_key'         => 'wpb_post_views_count',
'order'            => 'DESC',
'post_type'        => 'post',
'post_status'      => 'publish',
'suppress_filters' => true,
'date_query' => array(
  'after' => date('Y-m-d', strtotime('-14 days'))
  )
);
$most_seen = get_posts( $args );

?>

<style>
  .review-image {
    background-image: url('<?php echo $image_full; ?>');
  }

  @media (max-width: 900px) {
      .review-image {
        background-image: url('<?php echo $image_mobile; ?>');
      }
  }
</style>

<title><?php echo $category->cat_name; ?>: <?php echo $post->post_title; ?> - Nintendo Fusion</title>

<?php
if ($category->parent == 2) {
  ?>
  <div class="review-image" style="">
    <!-- <div class="review-bg"> -->
    <div class="gradient-map">
    </div>
    <div class="gradient">
    </div>
    <div class="gradient-black">
    </div>

    <div class="review-header">


      <div class="review-tag">
        <?php echo $category->cat_name; ?>
      </div>

      <div class="review-title">
        <div class="<?php echo $title_class; ?>">
          <?php echo $title; ?>
        </div>
        <div class="<?php echo $subtitle_class; ?>">
          <?php echo $subtitle; ?>
        </div>
      </div>

    </div>
  </div>

<!-- <div class="review-space">
</div> -->
<div class="review-content">
  <div class="review-date">
    <?php the_time('j \d\e F \d\e Y'); ?>
  </div>

  <div class="review-author">
    POR
    <?php
    echo $coauthors;
    ?>
  </div>

  <div class="review-disclaimer">
    <?php
    echo $meta_fields['disclaimer'][0];
    ?>
  </div>
</div>

<div class="review-content">
  <?php the_content();
  $icone = $meta_fields['icone'][0];
  ?>

  <div class="review-summary">
    <?php // print_r($meta_fields);
    echo $meta_fields['resumo'][0];
    ?>
  </div>
</div>

<?php
if ($category->category_nicename == 'analise') {
  ?>
  <div class="review-footer">
    <div class="review-footer-left">
      <div class="review-boxart" style="background-image: url('<?php echo $icone; ?>')">
        <div class="review-score">
          <?php // print_r($meta_fields);
          echo $meta_fields['nota'][0];
          ?>
        </div>
      </div>
    </div>
    <div class="review-footer-right">
      <div class="review-footer-details">
        <div class="review-footer-word"><?php echo nf_score_to_word($meta_fields['nota'][0]); ?></div>
        <div class="review-footer-title"><?php the_title(); ?></div>
        <span class="review-footer-detail">Publicadora</span> <?php echo $meta_fields['publisher'][0]; ?><br />
        <span class="review-footer-detail">Desenvolvedora</span> <?php echo $meta_fields['developer'][0]; ?><br />
        <span class="review-footer-detail">Equipe</span> <?php echo $meta_fields['equipe'][0]; ?><br />
        <span class="review-footer-detail">Plataformas</span> <?php echo $meta_fields['plataformas'][0]; ?> <br />
        <span class="review-footer-detail">Lançamento</span> <?php echo $meta_fields['data'][0]; ?><br />
      </div>
    </div>

  </div>
  <div class="ad-footer">
    <!-- footer AdSense ad -->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Footer ad -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-8943805401802569"
         data-ad-slot="9703492990"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

  <div class="more-content">
    <h1>Leia também</h1>
    <div class="mosaic-row-4">


      <div class="mosaic-column-3">
        <?php
        $post = $most_seen[0];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          if ($cat->parent == 2) {
            $category = $cat->cat_name;
          }
        }
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = get_post_meta($post->ID, 'icone', true);
        if ($image == '') {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        }
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title">
                <?php echo $post->post_title; ?>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>

      <div class="mosaic-column-3">
        <?php
        $post = $most_seen[1];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          if ($cat->parent == 2) {
            $category = $cat->cat_name;
          }
        }
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = get_post_meta($post->ID, 'icone', true);
        if ($image == '') {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        }
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title">
                <?php echo $post->post_title; ?>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>

      <div class="mosaic-column-3">
        <?php
        $post = $most_seen[2];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          if ($cat->parent == 2) {
            $category = $cat->cat_name;
          }
        }
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = get_post_meta($post->ID, 'icone', true);
        if ($image == '') {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        }
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title">
                <?php echo $post->post_title; ?>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php
}
?>
<!-- <div class="review-footer">


<div class="review-footer-left">

<div class="review-boxart" style="background-image: url('<?php echo $icone; ?>')">

</div>

<div class="review-meta">
<div class="review-score">
<?php // print_r($meta_fields);
echo $meta_fields['nota'][0];
?>
</div>

<div class="review-platforms">
<?php
foreach($posttags as $tag) {
?>
<div class="review-platform">
<?php echo $tag->name; ?>
</div>
<?php
}
?>
</div>
</div>

</div>

<div class="review-footer-right">
<?php // print_r($meta_fields);
echo $meta_fields['resumo'][0];
?>
</div>

</div> -->

<?php } else if ($category->category_nicename == 'noticia') {
  ?>

  <div class="list">
    <div class="span8">

      <h1>Notícia</h1>

      <?php
      // print_r($others_array);

      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      $permalink = get_post_permalink($post->ID);
      $excerpt = get_the_excerpt($post->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
      'single-post-thumbnail' )[0];
      ?>

      <!-- <a href="<?php echo $permalink; ?>"> -->
      <div class="news-image" style="background-image: url('<?php echo $image; ?>')">

      </div>
      <div class="news-title">
        <?php echo $post->post_title; ?>
      </div>
      <div class="news-date">
        <?php the_time('j \d\e F \d\e Y'); ?>
      </div>
      <div class="news-author">
        Por
        <?php
        echo $coauthors;
        ?>
      </div>
      <div class="news-content">
        <p><?php the_content(); ?></p>
      </div>

      <!-- </a> -->

    </div>
    <div class="span4">

      <?php get_sidebar(); ?>

    </div>
  </div>

<?php } else if ($post->post_type == "podcast") {
  ?>

  <!-- <link href="<?php echo get_bloginfo('template_url'); ?>/css/player.css" rel="stylesheet"> -->
  <div class="list">
    <div class="span8">

      <h1>Podcast</h1>
      <!-- Visualizado <?php echo $views; ?> vezes. -->

      <?php
      // print_r($others_array);

      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      $permalink = get_post_permalink($post->ID);
      $excerpt = get_the_excerpt($post->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
      'single-post-thumbnail' )[0];
      ?>

      <!-- <a href="<?php echo $permalink; ?>"> -->
      <div class="news-image" style="background-image: url('<?php echo $image; ?>')">

      </div>
      <div class="news-title">
        <?php echo $post->post_title; ?>
      </div>
      <div class="news-date">
        <?php the_time('j \d\e F \d\e Y'); ?>
      </div>
      <div class="news-author">
        Por
        <?php
        echo $coauthors;
        ?>
      </div>
      <div class="news-content">
        <p><?php the_content(); ?></p>
      </div>

      <!-- </a> -->

    </div>
    <div class="span4">

      <?php get_sidebar(); ?>

    </div>
  </div>

<?php } ?>


<div class="comments-wrapper">
  <h3>Comentários</h3>
  <div class="fb-comments"
       data-href="<?php echo get_permalink(); ?>"
       data-width="800"
       data-numposts="5"
       data-colorscheme="dark"></div>
</div>

<!-- <div class="comments-mobile">
  <h3>Comentários</h3>
  <div class="fb-comments"
       data-href="http://192.168.1.110"
       data-width="800"
       data-numposts="5"
       colorscheme="dark"
       data-mobile="true"></div>
</div> -->

<?php endwhile; else: ?>
  <p><?php _e('Sorry, this page does not exist.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
