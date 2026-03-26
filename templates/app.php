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
    window.InternApp = {
        api_url: "<?php echo rest_url(); ?>",
        nonce: "<?php echo wp_create_nonce('wp_rest'); ?>"
    };
</script>
<script type="module" crossorigin src="<?= INTERN_MANAGEMENT_URL . 'resources/dist/js/ims-app.js' ?>"></script>
</body>
</html>
