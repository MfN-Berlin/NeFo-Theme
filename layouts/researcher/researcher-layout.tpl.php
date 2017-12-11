<div<?php print $attributes; ?>>
    <div class="color-rule"></div>
    <header class="l-header" role="banner">
      <div class="l-branding">
<?php
if ($logo) {
  $path = drupal_get_path('theme', 'ofen');
  print '<a href="'. $front_page .'" title="'. t('Home') .'" rel="home" class="site-logo">';
  print '<img class="nefo-logo-mobile" src="/'. $path .'/images/logos/nefo-logo-mobile.png" alt="'. t('Home') .'" />';
  print '<img class="nefo-logo-tablet" src="/'. $path .'/images/logos/nefo-logo-tablet.png" alt="'. t('Home') .'" />';
  print '<img class="nefo-logo-desktop" src="/'. $path .'/images/logos/nefo-logo-desktop.png" alt="'. t('Home') .'" />';
  print '</a>';
}
?>

            <div class="branding-blocks">
              <div class="branding-block-first">
                <?php print render($page['branding']); ?>
              </div>
              <div class="branding-block-second">
                <?php print render($page['header']); ?>
              </div>
            </div>

        </div><!-- l-branding -->

        <?php print render($page['header_first']); ?>
        <?php print render($page['header_second']); ?>
        <?php print render($page['navigation']); ?>

    </header>

    <div class="l-main">
      <div class="l-content" role="main">
        <?php print render($page['highlighted']); ?>
        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if ($title): ?>
          <h1><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php print $messages; ?>
        <?php print render($tabs); ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
        <?php print $feed_icons; ?>
      </div>
      <?php print render($page['sidebar']); ?>
    </div>
    <div class="color-rule"></div>
    <footer class="l-footer" role="contentinfo">
        <?php print render($page['footer']); ?>
        <?php print render($page['footer_first']); ?>
        <?php print render($page['footer_second']); ?>
        <?php print render($page['footer_third']); ?>
        <?php print render($page['footer_fourth']); ?>
        <?php print render($page['footer_fifth']); ?>
        <?php print render($page['footer_sixth']); ?>
    </footer>
</div>