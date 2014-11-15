  </section>

  <footer>
    <?php
      if (!$this->session->userdata('logged_in')) {
        echo anchor('/admin', 'Admin Login', 'id="login-link"');
      }
    ?>

    <p>By Eugene Yue-Hin Cheung (g3cheunh) and Ramaneek Gill (g3gillra)</p>
  </footer>
</body>
</html>
