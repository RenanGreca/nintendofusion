  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,
minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- <meta name="HandheldFriendly" content="true"> -->

    <!-- Le styles -->
    <link href="<?php echo get_bloginfo('template_url'); ?>/style.css" rel="stylesheet">

    <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet"> -->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-48758010-3', 'auto');
      ga('send', 'pageview');
    </script>

    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>
  </head>
  <body>

  <div class="navbar navbar-inverse navbar-fixed-top">

    <div class="navbar-inner">

      <div class="header-container">

        <div class="brand">
          <a href="<?php echo site_url(); ?>">
            <img class="logo" src="<?php echo get_bloginfo('template_url') ?>/img/logo-neon.png" />
            <img class="logo-text" src="<?php echo get_bloginfo('template_url') ?>/img/logo-neon.png" />
          </a>
          <!-- <p class="logo-text">Nintendo FUSION</p> -->
          <form id="search" method="get" action="<?php echo home_url(); ?>" role="search">
            <input type="text" class="input-search" placeholder="Pesquisar" name="s" value="<?php echo $_GET['s']; ?>"/>
            <button type="submit" role="button" style="display:none;"/>
          </form>
        </div>
        <!-- <ul class="social nav">

        </ul> -->

        <div class="nav-collapse collapse">
          <ul class="nav">
              <li><a href="https://facebook.com/nintendofusion" class="social-icon social-fb" target="_blank">
                <!-- <img class="social-icon" src="<?php echo get_bloginfo('template_url') ?>/img/icons/facebook-red.png"> -->
              </a></li>
              <li><a href="https://twitter.com/NinFusionBR" class="social-icon social-tw" target="_blank">
                <!-- <img  src="<?php echo get_bloginfo('template_url') ?>/img/icons/twitter-red.png"> -->
              </a></li>
              <li><a href="https://www.youtube.com/channel/UCU74wc5ncqwjjoXhdw53DSA" class="social-icon social-yt" target="_blank">
                <!-- <img class="social-icon" src="<?php echo get_bloginfo('template_url') ?>/img/icons/youtube-red.png"> -->
              </a></li>

              <!-- <li class="active"><a href="#">Home</a></li> -->
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/noticia">NOTÍCIAS</a></li>
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/materia">MATÉRIAS</a></li>
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/video">VÍDEOS</a></li>
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/podcast">PODCAST</a></li>
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/ebook">eBOOKS</a></li>
              <!-- <?php wp_list_pages(array('title_li' => '', 'exclude' => 4)); ?> -->

          </ul>
          <!--  -->
        </div><!--/.nav-collapse -->

        <div class="ad-header">
          <!-- header AdSense ad -->
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- Header ad -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:728px;height:90px"
               data-ad-client="ca-pub-8943805401802569"
               data-ad-slot="9703492990"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div>
      </div>
    </div>
  </div>

  <div class="ad-mobile">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Mobile header ad -->
    <ins class="adsbygoogle"
    style="display:inline-block;width:320px;height:100px"
    data-ad-client="ca-pub-8943805401802569"
    data-ad-slot="8933282906"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>



  <div class="container">
