<?php if(isset($_SESSION['user_id'])): ?>
    <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
<?php else: ?>
    <?php redirect('users/login'); ?>
<?php endif;?>


