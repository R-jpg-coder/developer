<?php


namespace Easy\Booked\Frontend;

/**
 * Class Booked_Appointment
 *
 * @package Easy\Booked\Frontend
 */
class Booked_Appointment {

    /**
     * Booked_Appointment constructor.
     */
    public function __construct() {
        add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'appointment_time_add' ), 10, 4 );
        add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'paid_appointment' ) );
    }

    /**
     * Add appointment date time in the order
     *
     * @param $item
     * @param $cart_item_key
     * @param $values
     * @param $order
     */
    public function appointment_time_add( $item, $cart_item_key, $values, $order ) {
        foreach ( $item as $cart_item_key => $values ) {
            if ( isset( $values['book_name'] ) ) {

                $booking_time = explode( '-', $values['time_slot'] );
                $time_format = get_option( 'time_format' );

                if ( isset( $booking_time['1'] ) ) {
                    $appointment_time = sprintf(
                        "from %s to %s on %s",
                        date_i18n( $time_format, strtotime( $booking_time['0'] ) ),
                        date_i18n( $time_format, strtotime( $booking_time['1'] ) ),
                        $values['date']
                    );
                } else {
                    $appointment_time = sprintf(
                        "%s (All day)",
                        $values['date']
                    );
                }

                $item->add_meta_data( 'Appointment  Time Slot', $appointment_time, true );
            }
        }

    }

    /**
     * Paid Appointment  Add
     *
     * @param $order_id
     */
    public function paid_appointment( $order_id ) {
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();

        foreach ( $items as $cart_item_key => $values ) {
            if ( isset( $values['book_name'] ) ) {

                global $wpdb;

                $booking_time = explode( '-', $values['time_slot'] );
                $start_booking_time = strtotime( $values['date'] . $booking_time['0'] );
                $end_booking_time = isset( $booking_time['1'] ) ? strtotime( $values['date'] . $booking_time['1'] ) : '';

                $fields = array(
                    'slot_id'    => $values['slot_id'],
                    'slot_type'  => $values['slot_type'],
                    'phone'      => $values['phone'],
                    'email'      => $values['book_email'],
                    'order_id'   => $order_id,
                    'start_date' => $start_booking_time,
                    'end_date'   => $end_booking_time,
                    'slot_title' => $values['slot_title'],
                    'appointment_reminder_email' => 1,
                );

                $appointment_default = $values['appointment_default'];

                if ( strtolower( $appointment_default ) === strtolower( 'Approve Immediately' ) ) {
                    $status = 'eb-approve';
                } else {
                    $status = 'eb-pending';
                }


                $post = array(
                    'post_author'  => get_current_user_id(),
                    'post_name'    => $values['book_name'],
                    'post_title'   => $values['book_name'],
                    'post_status'  => $status,
                    'post_type'    => 'easy-appointments',
                );

                $post_id = wp_insert_post( $post );

                foreach ( $fields as $key => $value ) {
                    update_post_meta( $post_id, $key,  $value );
                }

                foreach ( $values['custom_filed'] as $row ) {
                    update_post_meta( $post_id, 'cmf_' . $row['name'],  $row['value'] );
                }

                $table = $values['table'];
                $info = $wpdb->get_row(
                    $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %s", $values['slot_id'] )
                );

                do_action( 'abs_appointment_confirmation_email', $post_id, $info->title );
                update_post_meta( $order_id, 'appointment_id', $wpdb->insert_id );
                update_post_meta( $order_id, 'calendar_id', $values['calendar_id'] );

                $update_data = array(
                    'space_available' => $info->space_available - 1,
                    'booked_space'    => $info->booked_space + 1,
                );

                $booked_format = array( '%d', '%d' );
                $wpdb->update( $table, $update_data, array( 'id' => $values['slot_id'] ), $booked_format );
            }
        }
    }
}