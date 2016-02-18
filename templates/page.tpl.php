<nav class="green" role="navigation">
  <div class="nav-wrapper container clearfix">
    <?php print $top_bar_secondary_menu; ?>
  </div>
  <div class="nav-wrapper container" style="height:64px;">

    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>

    <?php if ($site_name): ?>
      <a href="<?php print $front_page; ?>" id="logo-container" class="brand-logo" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a>
    <?php endif; ?>

    <?php print $sidebar_combined_menu; ?>

    <ul id="nav-mobile" class="side-nav">
      <li><a href="#">Navbar Link</a></li>
    </ul>

  </div>
  <div class="green darken-1">
    <div class="nav-wrapper container clearfix">
      <?php print $top_bar_main_menu; ?>
    </div>
  </div>
</nav>

<?php if ($title): ?>
  <div class="section">
    <div class="container">
      <?php print render($title_prefix); ?>
      <h1 id="page-title" class="header orange-text title"><?php print $title; ?></h1>
      <?php print render($title_suffix); ?>
    </div>
  </div>
<?php endif; ?>

<?php if ($messages): ?>
  <div class="section">
    <div class="container">
      <?php print $messages; ?>
    </div>
  </div>
<?php endif; ?>

<div class="section content">
  <?php print render($page['content']); ?>
</div>

<footer class="page-footer orange">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">Company Bio</h5>
        <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


      </div>
      <div class="col l3 s12">
        <h5 class="white-text">Settings</h5>
        <ul>
          <li><a class="white-text" href="#!">Link 1</a></li>
          <li><a class="white-text" href="#!">Link 2</a></li>
          <li><a class="white-text" href="#!">Link 3</a></li>
          <li><a class="white-text" href="#!">Link 4</a></li>
        </ul>
      </div>
      <div class="col l3 s12">
        <h5 class="white-text">Connect</h5>
        <ul>
          <li><a class="white-text" href="#!">Link 1</a></li>
          <li><a class="white-text" href="#!">Link 2</a></li>
          <li><a class="white-text" href="#!">Link 3</a></li>
          <li><a class="white-text" href="#!">Link 4</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
    Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
    </div>
  </div>
</footer>
