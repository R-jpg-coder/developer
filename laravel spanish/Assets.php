<?php


namespace Easy\Booked;

/**
 * Class Assets
 *
 * @package Easy\Booked
 */
class Assets {

    /**
     * Assets constructor.
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'front_end_enqueue' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
    }

    /**
     * Front css js enqueue
     */
    public function front_end_enqueue() {

    }

    /**
     * Admin css js enqueue
     */
    public function admin_enqueue() {
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js', array(), '11.0.18', true);
        wp_enqueue_style('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css', array(), '11.0.18', 'all');

        wp_enqueue_style( 'ebp-custom-fields', EBP_PLUGIN_URL . 'assets/css/custom-fields.css', null, EBP_VERSION );
        wp_enqueue_script( 'ebp-custom-fields', EBP_PLUGIN_URL . 'assets/js/custom-fields.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-sortable', 'jquery-ui-core' ), EBP_VERSION, true );
        wp_enqueue_script( 'ebp-backend', EBP_PLUGIN_URL . 'assets/js/backend.js', array( 'jquery' ), EBP_VERSION, false );

        wp_localize_script( 'ebp-custom-fields', 'data', array(
            'ajax_url'                      => admin_url( 'admin-ajax.php' ),
            'custom_fields'                 => wp_create_nonce( 'custom-fields' ),
            'abs_field_label'               => esc_html__( 'Filed Label:' , 'appointment-booking' ),
        ) );

        wp_localize_script( 'ebp-backend', 'data', array(
            'edit_time_slots'                 => wp_create_nonce( 'edit-time-slots' ),
        ) );
    }
}