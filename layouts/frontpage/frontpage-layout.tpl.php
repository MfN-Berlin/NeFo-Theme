<div class="color-rule"></div>
<div <?php print $attributes; ?>>
    <header class="l-header" role="banner">
        <div class="l-branding">
            <?php if ($logo): ?>
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="site-logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" /></a>
            <?php endif; ?>

            <?php if ($site_name || $site_slogan): ?>
                <?php if ($site_name): ?>
                    <h1 class="site-name">
                        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                    </h1>
                <?php endif; ?>

                <?php if ($site_slogan): ?>
                    <h2 class="site-slogan"><?php print $site_slogan; ?></h2>
                <?php endif; ?>
            <?php endif; ?>

            <?php print render($page['branding']); ?>
        </div>

        <?php print render($page['header']); ?>
        <?php print render($page['navigation']); ?>
    </header>

    <div class="l-main">
        <?php print render($page['highlighted']); ?>
        <?php print render($page['featured']); ?>
        <?php print render($page['slider']); ?>
        <?php print $messages; ?>
        <div class="l-content" role="main">
            <a id="main-content"></a>
            <?php print render($page['help']); ?>
            <?php if ($action_links): ?>
                <ul class="action-links"><?php print render($action_links); ?></ul>
            <?php endif; ?>
            <?php print render($page['atlas']); ?>
            <?php print render($page['news']); ?>
            <?php print render($page['products']); ?>
            <?php print render($page['misc']); ?>
            <?php print render($page['studies']); ?>
            <?php print render($page['interviews']); ?>
            <?php print $feed_icons; ?>
        </div>
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
