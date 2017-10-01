<?php get_header(); ?>
<link href="<?php echo get_bloginfo('template_url'); ?>/css/single.css" rel="stylesheet">

<!-- Facebook API -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10&appId=976575375818675";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Twitter API -->
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>

<!-- Facebook comments -->
<!-- <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10&appId=976575375818675";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> -->

<?php

if ( have_posts() ) : while ( have_posts() ) : the_post();
// Track pageviews
wpb_set_post_views(get_the_ID());
$views = wpb_get_post_views(get_the_ID());

$post = get_post();
// print_r($post);


$main_post_id = $post->ID;
$categories = get_the_category();
$permalink = get_the_permalink();
$category = $categories[0];

$image_full = wp_get_attachment_image_src( get_post_thumbnail_id(),
'single-post-thumbnail' )[0];
$image_mobile = wp_get_attachment_image_src( get_post_thumbnail_id(),
'large' )[0];

$coauthors = coauthors_posts_links(', ', ' e ', null, null, false);

$title = $post->post_title;
$subtitle = "";
$title_class = "review-maintitle";
if ($pos = strpos($post->post_title, ':')) {
  $title = substr($post->post_title, 0, $pos+1);
  $title_class = "review-subtitle";
  $subtitle = substr($post->post_title, $pos+2);
  $subtitle_class = "review-maintitle";
} else if ($pos = strpos($post->post_title, '~')) {
  $title = substr($post->post_title, 0, $pos);
  $title_class = "review-subtitle";
  $subtitle = substr($post->post_title, $pos+2);
  $subtitle_class = "review-maintitle";
}  else if ($pos = strpos($post->post_title, '(')) {
  $title = substr($post->post_title, 0, $pos-1);
  $title_class = "review-maintitle";
  $subtitle = substr($post->post_title, $pos+1, strlen($post->post_title)-strlen($title)-3);
  $subtitle_class = "review-subtitle";
}

$post_title = str_replace('~', '', $post->post_title);

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
  $ids = array();
  array_push($ids, $most_seen[0]->ID);

  if (count($most_seen) < 3) {
    $ids = array();
    for ($i=0; $i<count($most_seen); $i++) {
      array_push($ids, $most_seen[$i]->ID);
    }
    array_push($ids, $post->ID);

    $args = array(
      'posts_per_page'   => 3-count($most_seen),
      'exclude'          => $ids,
      'category_name'    => 'materia',
      'exclude'          => $ids,
      'orderby'          => 'date',
      'order'            => 'DESC',
      'post_type'        => 'post',
      'post_status'      => 'publish',
      'suppress_filters' => true
    );
    $most_seen_extras = get_posts( $args );

    for ($i=0; $i<count($most_seen_extras); $i++) {
      array_push($most_seen, $most_seen_extras[$i]->ID);
    }
  }

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

  <title><?php echo $category->cat_name; ?>: <?php echo $post_title; ?> - Nintendo Fusion</title>

  <?php
  $parent = get_the_category_by_ID($category->parent);
  if ($parent == "Matéria") {
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
  <div class="content review-content">
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

  <div class="content review-content">
    <?php the_content();
    $icone = $meta_fields['icone'][0];
    ?>

    <?php
    if ($category->category_nicename == 'analise') {
      ?>
      <div class="review-summary">
        <?php // print_r($meta_fields);
        echo $meta_fields['resumo'][0];
        ?>
      </div>
      <?php
    }
    ?>
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
    <?php
  }
  ?>

  <div class="more-content">

    <div class="social-share-buttons">
      <!-- Facebook share button -->
      <div class="fb-share-button"
        data-href="<?php echo $permalink ?>"
        data-layout="button"
        data-size="large">
      </div>

      <!-- Twitter tweet button -->
      <a class="twitter-share-button"
        href="https://twitter.com/intent/tweet?via=ninfusionbr"
        data-size="large">
      Tweet</a>
    </div>

    <h1>Leia também</h1>
    <div class="mosaic-row-4">


      <div class="mosaic-column-3">
        <?php
        $post = $most_seen[0];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          $parent = get_the_category_by_ID($cat->parent);
          if ($parent == "Matéria") {
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

        $title = get_the_title($post->ID);
        $post_title = get_the_title($post->ID);
        $subtitle = "";
        $title_class = "mosaic-news-title-1";
        if ($pos = strpos($post_title, ':')) {
          $title = substr($post_title, 0, $pos+1);
          $title_class = "mosaic-news-subtitle-1";
          $subtitle = substr($post_title, $pos+2);
          $subtitle_class = "mosaic-news-title-1";
        } else if ($pos = strpos($post_title, '~')) {
          $title = substr($post_title, 0, $pos);
          $title_class = "mosaic-news-subtitle-1";
          $subtitle = substr($post_title, $pos+2);
          $subtitle_class = "mosaic-news-title-1";
        } else if ($pos = strpos($post_title, '(')) {
          $title = substr($post_title, 0, $pos-1);
          $title_class = "mosaic-news-title-1";
          $subtitle = substr($post_title, $pos+1, strlen($post_title)-strlen($title)-3);
          $subtitle_class = "mosaic-news-subtitle-1";
        }
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-gradient-black">
                </div>
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title">
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
          $parent = get_the_category_by_ID($cat->parent);
          if ($parent == "Matéria") {
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

        $title = get_the_title($post->ID);
        $post_title = get_the_title($post->ID);
        $subtitle = "";
        $title_class = "mosaic-news-title-1";
        if ($pos = strpos($post_title, ':')) {
          $title = substr($post_title, 0, $pos+1);
          $title_class = "mosaic-news-subtitle-1";
          $subtitle = substr($post_title, $pos+2);
          $subtitle_class = "mosaic-news-title-1";
        } else if ($pos = strpos($post_title, '~')) {
          $title = substr($post_title, 0, $pos);
          $title_class = "mosaic-news-subtitle-1";
          $subtitle = substr($post_title, $pos+2);
          $subtitle_class = "mosaic-news-title-1";
        } else if ($pos = strpos($post_title, '(')) {
          $title = substr($post_title, 0, $pos-1);
          $title_class = "mosaic-news-title-1";
          $subtitle = substr($post_title, $pos+1, strlen($post_title)-strlen($title)-3);
          $subtitle_class = "mosaic-news-subtitle-1";
        }
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-gradient-black">
                </div>
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title">
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
          $parent = get_the_category_by_ID($cat->parent);
          if ($parent == "Matéria") {
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

        $title = get_the_title($post->ID);
        $post_title = get_the_title($post->ID);
        $subtitle = "";
        $title_class = "mosaic-news-title-1";
        if ($pos = strpos($post_title, ':')) {
          $title = substr($post_title, 0, $pos+1);
          $title_class = "mosaic-news-subtitle-1";
          $subtitle = substr($post_title, $pos+2);
          $subtitle_class = "mosaic-news-title-1";
        } else if ($pos = strpos($post_title, '~')) {
          $title = substr($post_title, 0, $pos);
          $title_class = "mosaic-news-subtitle-1";
          $subtitle = substr($post_title, $pos+2);
          $subtitle_class = "mosaic-news-title-1";
        } else if ($pos = strpos($post_title, '(')) {
          $title = substr($post_title, 0, $pos-1);
          $title_class = "mosaic-news-title-1";
          $subtitle = substr($post_title, $pos+1, strlen($post_title)-strlen($title)-3);
          $subtitle_class = "mosaic-news-subtitle-1";
        }
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-gradient-black">
                </div>
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title">
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
            <?php echo $time; ?>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="comments-wrapper">
    <h3>Comentários</h3>
    <?php
    $post = get_post($main_post_id);
    comments_template(); ?>
    </div>
  </div>

<?php } else if (($category->category_nicename == 'noticia') || ($post->post_type == "podcast") || ($post->post_type == "video")) {
  ?>


  <div class="post-wrapper">
    <div class="span8">

      <h1><?php echo $post->post_title; ?></h1>
      <?php
      // print_r($others_array);

      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      $permalink = get_post_permalink($post->ID);
      $excerpt = get_the_excerpt($post->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
      'single-post-thumbnail' )[0];
      $meta_fields = get_post_custom();
      ?>

      <!-- <a href="<?php echo $permalink; ?>"> -->

      <div class="cover-wrapper">
      <?php
      if ($meta_fields['video'][0]) {
        ?>

          <iframe src="https://www.youtube.com/embed/<?php echo $meta_fields['video'][0]; ?>" frameborder="0" allowfullscreen>
          </iframe>

        <?php
      } else {
        ?>
        <div class="news-image" style="background-image: url('<?php echo $image; ?>')">
        </div>
        <?php
      }
      ?>
      </div>
      <!-- <div class="news-title">

    </div> -->
    <div class="news-date">
      <?php the_time('j \d\e F \d\e Y'); ?>
    </div>
    <div class="news-author">
      Por
      <?php
      echo $coauthors;
      ?>
    </div>
    <div class="content news-content">
      <p><?php the_content(); ?></p>
    </div>

    <!-- </a> -->

    <div class="social-share-buttons">
      <!-- Facebook share button -->
      <div class="fb-share-button"
        data-href="<?php echo $permalink ?>"
        data-layout="button"
        data-size="large">
      </div>

      <!-- Twitter tweet button -->
      <a class="twitter-share-button"
        href="https://twitter.com/intent/tweet?via=ninfusionbr"
        data-size="large">
      Tweet</a>
    </div>

    <div class="comments-wrapper">
      <h3>Comentários</h3>
      <?php comments_template(); ?>
    </div>
  </div>

  <div class="span4">

    <?php get_sidebar(); ?>

  </div>

</div>

<?php } else {
  //  if (($post->post_type == "podcast") || ($post->post_type == "video")) {
  ?>

  <!-- <link href="<?php echo get_bloginfo('template_url'); ?>/css/player.css" rel="stylesheet"> -->
  <div class="list">
    <div class="span8">
      <?php
        if ($post->post_type == "podcast") {
          $header = "Podcast";
        } else if ($post->post_type == "video") {
          $header = "Vídeo";
        }
      ?>
      <h1><?php echo $header; ?></h1>
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
      <div class="content news-content">
        <p><?php the_content(); ?></p>
      </div>


      <div class="comments-wrapper">
        <h3>Comentários</h3>
        <?php comments_template(); ?>
      </div>
    </div>
    <!-- </a> -->
    <div class="span4">

      <?php get_sidebar(); ?>

    </div>
  </div>

<?php } ?>


<!-- <div class="comments-mobile">
<h3>Comentários</h3>
<div class="fb-comments"
data-href="http://192.168.1.110"
data-numposts="5"
colorscheme="dark"
data-mobile="true"></div>
</div> -->

<?php endwhile; else: ?>
  <p><?php _e('Sorry, this page does not exist.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
