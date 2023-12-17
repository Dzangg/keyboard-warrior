<?php
///** @var \App\Model\Admin $admin */
/** @var \App\Service\Router $router */
/** @var string $error */

$title = 'Admin panel';

ob_start();  ?>

<form action="<?= $router->generatePath('admin-validate') ?>" method="post" class="edit-form">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" value="<?= $_POST['password'] ?? '' ?>" required>
    </div>

    <?php if ($error) : ?>
        <div class="error-message">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <input type="submit" value="Log in">
    </div>
</form>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
