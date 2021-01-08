<?php
/**
Front-end template.
**/

// Get meta.
$json   = get_post_meta( $order_id, '_lr_shiptrack_tracking_json', true ) ? get_post_meta( $order_id, '_lr_shiptrack_tracking_json', true ) : '';

// Get latest.
$latest = end( $json[key($json)] ); ?>

<div id="trackinginfo-<?php echo $order_id; ?>" class="lr-shiptrack-module">
    <div id="trackinginfo-now">
        <div class="trackinginfo-now-outer">
            <?php
            // Icon.
            if( $latest['status'] === 'Delivered' ) {

                // Set icon.
                $icon = LR_SHIPTRACK_URL . 'assets/images/delivered-symbol.png';

            } elseif( empty( $latest['location'] ) ) {

                // Set icon.
                $icon = LR_SHIPTRACK_URL . 'assets/images/awaitingpickup-symbol.png';

            } else {

                // Set icon.
                $icon = LR_SHIPTRACK_URL . 'assets/images/intransit-symbol.png';

            } ?>
            <div class="trackinginfo-icon">
                <img src="<?php echo $icon; ?>" alt="<?php echo $latest['status']; ?>" />
            </div>
            <div class="trackinginfo-status">
                <h2><?php echo $latest['status']; ?></h2>
            </div>
            <div class="trackinginfo-date">
                <p><?php echo date( 'l m/d/Y', strtotime( $latest['timestamp'] ) ); ?> at <?php echo date( 'g:iA', strtotime( $latest['timestamp'] ) ); ?></p>
            </div>
            <div class="trackinginfo-location">
                <p><?php echo $latest['location']['city'] . ', ' . $latest['location']['state']; ?></p>
            </div>
            <div class="trackinginfo-link">
                <p><a href="<?php echo lr_shiptrack_get_tracking_link( get_post_meta( $order_id, '_lr_shiptrack_tracking_carrier', true ), get_post_meta( $order_id, '_lr_shiptrack_tracking', true ) ); ?>" target="_blank"><?php echo get_post_meta( $order_id, '_lr_shiptrack_tracking', true ); ?></a></p>
            </div>
        </div>
    </div>
    <div id="trackinginfo-history">
        <div class="trackinginfo-past-outer">
            <div class="trackinginfo-past-header">
                <h3>Shipment History</h3>
                <i class="arrow down"></i>
            </div>
            <div class="trackinginfo-past-inner">
                <?php
                // Loop through.
                foreach( $json[key($json)] as $history ) {

                    // Check.
                    if( !empty( $history['location']['state'] ) ) {

                        // Set location.
                        $location = $history['location']['city'] . ', ' . $history['location']['state'];

                    } ?>

                    <div class="trackinginfo-history-single">
                        <div class="trackinginfo-history-single-sub trackinginfo-history-date"><?php echo date( 'l m/d/Y', strtotime( $history['timestamp'] ) ); ?></div>
                        <div class="trackinginfo-history-single-sub trackinginfo-history-time"><?php echo date( 'g:iA', strtotime( $history['timestamp'] ) ); ?></div>
                        <div class="trackinginfo-history-single-sub trackinginfo-history-loca"><?php echo $location; ?></div>
                        <div class="trackinginfo-history-single-sub trackinginfo-history-stat"><?php echo $history['status']; ?></div>
                    </div><?php

                } ?>
            </div>
        </div>
    </div>
</div>
