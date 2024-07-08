<?php


namespace Easy\Booked\Frontend;

/**
 * Class Wc_Shop_Page
 *
 * @package Appointment\Booking\Frontend\WooCommerce
 */
class Wc_Shop_Page {

    /**
     * Wc_Shop_Page constructor.
     */
    public function __construct() {
        add_action('pre_get_posts', array($this, 'remove_products_from_shop_listing'), 90, 1);
    }

    /**
     * Remove product from shop page
     *
     * @param $query
     * @return mixed
     */
    public function remove_products_from_shop_listing( $query ) {
        if ( is_admin() ) {
            return $query;
        }

        if ( $query->get( 'post_type' ) !=='product' ) {
            return $query;
        }

        $easy_booked_products = abs_easy_booked_product_id();

        if ( ! $easy_booked_products ) {
            return $query;
        }

        $post__no_in = (array) $query->get( 'post__not_in' );

        $query->set( 'post__not_in', array_merge( $post__no_in, $easy_booked_products ) );

        return $query;

    }
}