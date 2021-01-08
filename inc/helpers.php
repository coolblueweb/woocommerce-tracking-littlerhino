<?php
/**
Get tracking link.
**/
function lr_shiptrack_get_tracking_link( $carrier, $number ) {

    // Set default.
    $link = false;

    // Checks.
    if( isset( $carrier ) && isset( $number ) ) {

        // Check carrier.
        if( $carrier === 'FEDEX' ) {

            // Set link for FedEx.
            $link = 'https://www.fedex.com/fedextrack/?tracknumbers=' . $number;

        } elseif( $carrier === 'USPS' ) {

            // Set link for USPS.
            $link = 'https://tools.usps.com/go/TrackConfirmAction.action?tLabels=' . $number;

        } elseif( $carrier === 'UPS' ) {

            // Set link for UPS.
            $link = 'http://wwwapps.ups.com/WebTracking/processInputRequest?TypeOfInquiryNumber=T&InquiryNumber1=' . $number;

        } elseif( $carrier === 'DHL' ) {

            // Set link for DHL.
            $link = 'http://www.dhl.com/en/express/tracking.html?AWB=' . $number . '&brand=DHL';

        } elseif( $carrier === 'CANADA_POST' ) {

            // Set link for Canada Post.
            $link = 'https://www.canadapost.ca/trackweb/en#/search?searchFor=' . $number;

        } else {

            // Unrecognized carrier.
            $link = false;

        }

    }

    // Return.
    return $link;

}
