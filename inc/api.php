<?php
/**
Get tracking information.
**/
function lr_shiptrack_get_tracking( $number, $order_id, $time ) {

    // Set run.
    $run = false;

    // Check time.
    if( $time === NULL ) {

        // Set run.
        $run = true;

    } else {

        // Check.
        $now = strtotime( '-6 hours' );

        // Compare.
        if( $time >= $now ) {

            // We already updated within the last 6 hours.

        } else {

            // Run the update.
            $run = true;

        }

    }

    // Check for tracking number.
    if( $run ) {

        // Set args.
        $args = [
            'redirection' => 5,
            'blocking'    => true,
            'sslverify'   => false,
            'timeout'     => 60,
        ];

        // Set endpoint.
        $endpoint = 'https://package.place/api/track/';

        // GET.
        $response = wp_remote_get( $endpoint . $number, $args );

        // Decode JSON.
        $response = json_decode( wp_remote_retrieve_body( $response ), true );

        // Save data.
        update_post_meta( $order_id, '_lr_shiptrack_tracking_json', $response );
        update_post_meta( $order_id, '_lr_shiptrack_tracking_json_date', date( 'Y-m-d H:i:s') );
        update_post_meta( $order_id, '_lr_shiptrack_tracking_carrier', key( $response ) );
        update_post_meta( $order_id, '_lr_shiptrack_tracking_status', end($response[key($response)])['status'] );

    }

}
