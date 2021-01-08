<?php
/**
Add metabox to shop_order page.
**/
add_action( 'add_meta_boxes', 'lr_shiptrack_metaboxes' );
function lr_shiptrack_metaboxes() {

    // Add the box.
    add_meta_box( 'lr_shiptrack_tracking_field', __( 'Shipment Tracking', LR_SHIPTRACK_TXT ), 'lr_shiptrack_tracking_field_callback', 'shop_order', 'side', 'core' );

}

/**
Add the HTML for the field.
**/
function lr_shiptrack_tracking_field_callback() {

    // Get the post.
    global $post;

    // Get meta data.
    $number     = get_post_meta( $post->ID, '_lr_shiptrack_tracking', true ) ? get_post_meta( $post->ID, '_lr_shiptrack_tracking', true ) : '';
    $carrier    = get_post_meta( $post->ID, '_lr_shiptrack_tracking_carrier', true ) ? get_post_meta( $post->ID, '_lr_shiptrack_tracking_carrier', true ) : '';
    $status     = get_post_meta( $post->ID, '_lr_shiptrack_tracking_status', true ) ? get_post_meta( $post->ID, '_lr_shiptrack_tracking_status', true ) : '';
    $date       = get_post_meta( $post->ID, '_lr_shiptrack_tracking_json_date', true ) ? get_post_meta( $post->ID, '_lr_shiptrack_tracking_json_date', true ) : '';

    // Check if number already exists and if delivered.
    if( !empty( $number ) && $status !== 'Delivered' ) {

        // Check if first time.
        if( empty( $date ) ) {

            // Run API for the first time.
            lr_shiptrack_get_tracking( $number, $post->ID, NULL );

        } else {

            // Run API with last updated time.
            lr_shiptrack_get_tracking( $number, $post->ID, $date );

        }

    }

    // Output. ?>
    <input type="hidden" name="lr_shiptrack_tracking_nonce" value="<?php echo wp_create_nonce(); ?>">
    <p style="border-bottom:sold 1px #eee;padding-bottom:13px">
        <input type="text" style="width:250px" name="lr_shiptrack_tracking_number" placeholder="Tracking Number" value="<?php echo $number; ?>">
        <?php
        // Check for tracking number and carrier.
        if( !empty( $number ) && !empty( $carrier ) ) { ?>
            <span style="display:block;margin-top:5px;">
                <a href="<?php echo lr_shiptrack_get_tracking_link( $carrier, $number ); ?>" style="font-weight:bold" target="_blank">Track Shipment</a> &mdash;
                <span<?php if( $status === 'Delivered' ) { echo ' style="color:green"'; } ?>><?php echo $status; ?></span>
            </span><?php
        } ?>
    </p><?php

}

/**
Save the field data.
**/
add_action( 'save_post', 'lr_shiptrack_tracking_field_save', 10, 1 );
function lr_shiptrack_tracking_field_save( $post_id ) {

    // Check if nonce is set.
    if( !isset( $_POST['lr_shiptrack_tracking_nonce'] ) ) {
        return $post_id;
    }

    // Verify nonce.
    if( !wp_verify_nonce( $_REQUEST['lr_shiptrack_tracking_nonce'] ) ) {
        return $post_id;
    }

    // Check if this is an autosave.
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    // Check the users permissions.
    if( 'page' == $_POST['post_type'] ) {

        // Check current user.
        if( !current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }

    } else {

        // Check current user.
        if( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

    }

    // Sanitize.
    $tracking = sanitize_text_field( $_POST['lr_shiptrack_tracking_number'] );

    // Save.
    update_post_meta( $post_id, '_lr_shiptrack_tracking', $tracking );

}
