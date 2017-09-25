
    </div> <!-- /container -->

      <footer>

        <?php
        if ($GLOBALS['theme'] == 'light') {
          $theme_url = 'http://'.$_SERVER['HTTP_HOST'].strtok($_SERVER["REQUEST_URI"],'?').'?theme=dark';
          $theme = 'escuro';
        } else {
          $theme_url = 'http://'.$_SERVER['HTTP_HOST'].strtok($_SERVER["REQUEST_URI"],'?').'?theme=light';
          $theme = 'claro';
        }
        ?>

        <div class="footer-line">
        </div>
        <!-- <img class="logo" src="<?php echo get_bloginfo('template_url') ?>/img/logo.png" /> -->
        <div class="links">
          <a href="#Sobre">Sobre</a>
          <a href="#Equipe">Equipe</a>
          <a href="/politicas">Políticas</a>
          <a href="#Contato">Contato</a>
          <a href="#Mídia">Mídia</a>
          <a href="<?php echo $theme_url; ?>">Ativar tema <?php echo $theme; ?></a>
        </div>

        <div class="copyright">
            <div class="year">© <?php echo date('Y'); ?> Nintendo Fusion</div>
            O Nintendo Fusion não é associado com Nintendo Co. Ltd. nem nenhuma de suas subsidiárias.
        </div>

      </footer>



    <?php wp_footer(); ?>

  </body>
</html>
