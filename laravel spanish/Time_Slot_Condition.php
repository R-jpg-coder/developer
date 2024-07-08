<?php


namespace Easy\Booked\Frontend;


/**
 * Class Time_Slot_Condition
 *
 * @package Easy\Booked\Frontend
 */
class Time_Slot_Condition {

    /**
     * Time_Slot_Condition constructor.
     */
    public function __construct() {
        add_filter( "abs_time_slot_remove", array( $this, "time_slot_remove" ),10,3 );
    }

    /**
     * @param $value
     * @param $appointment_time
     * @param $calendar_id
     * @return mixed
     */
    public function time_slot_remove( $value, $appointment_time, $calendar_id ) {
        $time_format = get_option( 'time_format' );
        $now_time = date_i18n( 'Y-m-d ' . $time_format );

        $prevent_before_minutes = $this->get_options( "prevent_before", $calendar_id );
        if ( ! empty( $prevent_before_minutes ) ) {
            $prevent_before_time = strtotime( "-{$prevent_before_minutes} minutes", strtotime( $appointment_time ) );
            if ( $prevent_before_time >= strtotime( $now_time ) ) {
                return true;
            }
        }

        $prevent_after_minutes = $this->get_options( "prevent_after", $calendar_id );
        if ( ! empty( $prevent_after_minutes ) ) {
            $prevent_after_time = strtotime( "-{$prevent_after_minutes} minutes", strtotime( $appointment_time ) );
            if ( strtotime( $now_time ) >= $prevent_after_time ) {
                return true;
            }
        }

        return $value;
    }

    /**
     * @param $index_name
     * @param $calendar_id
     * @return mixed|void
     */
    public function get_options(  $index_name, $calendar_id ) {
        $options = get_option( 'abs_calendar_general' . $calendar_id );

        if ( isset( $options[ $index_name ] ) ) {
            return $options[ $index_name ];
        } else {
            return;
        }
    }
}