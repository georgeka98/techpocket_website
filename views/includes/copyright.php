      </div>
      <footer>
        <section class="copyright">
          <div class="cont cont-copyright">
            <p class="made-by">This website was made by <a href="http://www.georgekarabassis.com" class="website-dev-name" target="_blank">George Karabassis</a></p>
            <p class="copyright-statement">© Copyright <?php echo date("Y");?> | All rights reserved</p>
          </div>
        </section>
      </footer>
    </body>
  <script src="<?= BASE_DIR?>views/js/main.js"></script>
  <?php if (!empty($this->js)):?>
    <?php foreach ($this->js as $script): ?>
      <?php if (!empty($script)): ?>
        <script src="<?= BASE_DIR?>views/js/<?= $script ?>.js"></script>
      <?php endif;?>
    <?php endforeach;?>
  <?php endif;?>
</html>
