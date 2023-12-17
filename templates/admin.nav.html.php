<?php
/** @var $router \App\Service\Router */
?>
    <ul>
        <li><a href="<?= $router->generatePath('admin-panel') ?>">Admin panel</a></li>
        <li><a href="<?= $router->generatePath('admin-logout') ?>">Logout</a></li>
    </ul>
<?php
