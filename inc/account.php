<?php
/**
Load in View Order.
**/
add_action( 'woocommerce_view_order', 'lr_shiptrack_view_order', 1 );
function lr_shiptrack_view_order( $order_id ) {

    // Get meta data.
    $number     = get_post_meta( $order_id, '_lr_shiptrack_tracking', true ) ? get_post_meta( $order_id, '_lr_shiptrack_tracking', true ) : '';
    $carrier    = get_post_meta( $order_id, '_lr_shiptrack_tracking_carrier', true ) ? get_post_meta( $order_id, '_lr_shiptrack_tracking_carrier', true ) : '';
    $status     = get_post_meta( $order_id, '_lr_shiptrack_tracking_status', true ) ? get_post_meta( $order_id, '_lr_shiptrack_tracking_status', true ) : '';
    $date       = get_post_meta( $order_id, '_lr_shiptrack_tracking_json_date', true ) ? get_post_meta( $order_id, '_lr_shiptrack_tracking_json_date', true ) : '';

    // Check if number already exists and if delivered.
    if( !empty( $number ) && $status !== 'Delivered' ) {

        // Check if first time.
        if( empty( $date ) ) {

            // Run API for the first time.
            lr_shiptrack_get_tracking( $number, $order_id, NULL );

        } else {

            // Run API with last updated time.
            lr_shiptrack_get_tracking( $number, $order_id, $date );

        }

    }

    // Include template.
    include LR_SHIPTRACK_PATH . 'inc/template.php';

}
