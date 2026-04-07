<?php
/**
 * Template Name: Intern management (Fullscreen)
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <title>Hệ thống IMS</title>
    <link rel="stylesheet" crossorigin href="<?= INTERN_MANAGEMENT_URL . 'resources/dist/css/ims-style.css' ?>">
</head>
<body>
<div id="app"></div>
<script>
    window.InternApp = <?php
    //$current_user = wp_get_current_user();
    $intern_app_data = [
        'api_url' => esc_url_raw( rest_url() ),
        'nonce'   => wp_create_nonce( 'wp_rest' ),
        //'caps'    => is_user_logged_in() ? $current_user->allcaps : []
    ];
    echo wp_json_encode( $intern_app_data );
    ?>;
</script>
<script type="module" crossorigin src="<?= INTERN_MANAGEMENT_URL . 'resources/dist/js/ims-app.js' ?>"></script>
</body>
</html>
