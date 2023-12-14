<?php
/** @var \App\Model\Admin $admin */
/** @var \App\Service\Router $router */

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


    <div class="form-group">
        <input type="submit" value="Log in">
    </div>
</form>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
