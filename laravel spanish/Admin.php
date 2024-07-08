<?php

namespace Easy\Booked;

/**
 * Class Admin
 *
 * @package Easy\Booked
 */
class Admin {

    /**
     * Admin constructor.
     */
    public function __construct() {
        $custom_fields = new Admin\CustomFields();
        $edit_time_slots = new Admin\Time_Slots_Edit();
        new Admin\Settings();
        new Admin\Calendar_Manage();
        new Admin\Wc_Product_Mata_Data();
        new Admin\Calendar_Setting_Fields();
        $this->dispatch_actions( $custom_fields, $edit_time_slots );
    }

    /**
     * Dispatch Actions
     */
    public function dispatch_actions( $custom_fields, $edit_time_slots ) {
        // Calendar Custom Fields
        add_action( 'wp_ajax_custom_fields', array( $custom_fields, 'custom_fields' ) );
        add_action( 'wp_ajax_abs_edit_time_slots', array( $edit_time_slots, 'edit_time_slots' ) );
        add_action( 'wp_ajax_abs_update_time_slot', array( $edit_time_slots, 'update_time_slot' ) );
    }
}