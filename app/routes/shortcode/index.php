<?php

add_action('init', function () {
    add_shortcode('intern_dashboard', [new InternManagement\App\Shortcodes\TestShortcode(), 'render']);
});
