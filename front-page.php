<?php
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
}
get_header(); ?>
<div class="container">
    <?php
    if (is_user_logged_in()) {
        echo '<p>Welcome, Admin!</p>';
    } else {
        echo '<p>Welcome, visitor!</p>';
    }
    ?>
</div>

<?php get_footer(); ?>