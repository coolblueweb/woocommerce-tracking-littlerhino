<?php
/**
Enqueue.
**/
add_action( 'wp_enqueue_scripts', 'lr_trackship_enqueue' );
function lr_trackship_enqueue() {

    // CSS.
    wp_enqueue_style( 'lr-trackship-css', LR_SHIPTRACK_URL . 'assets/css/style.css', [], LR_SHIPTRACK_VERSION, 'all' );

    // JS.
    wp_enqueue_script( 'lr-trackship-js', LR_SHIPTRACK_URL . 'assets/js/tracking.js', [ 'jquery' ], LR_SHIPTRACK_VERSION, true );

}
