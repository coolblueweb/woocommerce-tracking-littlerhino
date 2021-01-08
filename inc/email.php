<?php
/**
Add tracking to email.
**/
add_action( 'woocommerce_email_before_order_table', 'lr_shiptrack_email_tracking', 10, 4 );
function lr_shiptrack_email_tracking( $order, $sent_to_admin, $plain_text, $email ) {

    // Set default output.
    $output = '';

    // Check email.
    if( $email->id === 'customer_completed_order' ) {

        // Get meta data.
        $number     = get_post_meta( $order->get_id(), '_lr_shiptrack_tracking', true ) ? get_post_meta( $order->get_id(), '_lr_shiptrack_tracking', true ) : '';
        $carrier    = get_post_meta( $order->get_id(), '_lr_shiptrack_tracking_carrier', true ) ? get_post_meta( $order->get_id(), '_lr_shiptrack_tracking_carrier', true ) : '';

        // Check.
        if( !empty( $number ) && !empty( $carrier ) ) {

            // Set output.
            $output = "Shipped via " . str_replace( '_', '', $carrier ) . " with tracking number <a href='" . lr_shiptrack_get_tracking_link( $carrier, $number ) . "'>" . $number . "</a>.<br><br>";

        }

    }

    // Echo.
    echo $output;

}
