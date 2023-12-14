<?php
/** @var $admin ?\App\Model\Admin */
?>

<div class="form-group">
    <label for="subject">Username</label>
    <input type="text" id="subject" name="admin[username]" value="<?= isset($admin) ? $admin->getUsername() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Password</label>
    <textarea id="content" name="admin[password]"><?= isset($admin) ? $admin->getPassword() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
