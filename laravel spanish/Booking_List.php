<?php


namespace Easy\Booked\Frontend;

use Appointment\Booking\Frontend\Build_Calendar as Original_Build_Calendar;


/**
 * Class Booking_List
 *
 * @package Easy\Booked\Frontend
 */
class Booking_List extends Original_Build_Calendar {

    /**\
     * Booking_List constructor.
     */
    public function __construct() {
        add_shortcode("booking_list", array( $this, "booking_list" ) );
    }

    /**
     * @param $atts
     * @return false|string\
     */
    public function booking_list( $atts ) {
        // Parse shortcode attributes
        $atts = shortcode_atts(
            array(
                'calendar_id'    => 1,
                'date_or_week'   => date_i18n('Y-m-d'),
            ),
            $atts,
            'booking_list'
        );
        
        $calendar_id = intval($atts['calendar_id']);
        $date_or_week = $atts['date_or_week'];

        if ( $init_date = $this->get_date_week_name( $date_or_week ) ) {
           $date = $init_date;
        } else {
            $date = date_i18n('Y-m-d', strtotime( $date_or_week ) );
        }

        ob_start();
            ?>
            <div class="abs-booked-calendar-area">
                <?php
                $this->get_single_date_appointments( $calendar_id, $date );
                ?>
                <!-- The Modal -->
                <div class="abs-booked-modal abs-loading-book-form <?php echo esc_attr( 'abs-book-form-' . $calendar_id ); ?>">
                    <img src="<?php echo esc_url( ABS_PLUGIN_URL . 'assets/images/loading.gif' ); ?>"
                         alt="<?php echo esc_attr__( 'Loading Booking Form', 'appointment-booking' ); ?>">
                    <!-- Modal content -->
                    <div class="abs-booked-modal-content">

                    </div>
                </div>
            </div>
            <?php

        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * @param $week_name
     * @return false|string
     */
    private function get_date_week_name( $week_name ) {
        $valid_week_names = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        
        if (!in_array($week_name, $valid_week_names)) {
            return false;
        }

        $start_date_string = date_i18n( 'Y-m-d' );
        $start_date_timestamp = strtotime( $start_date_string );
        
        $next_week_timestamp = strtotime( $week_name, $start_date_timestamp );
        $next_week_date = date_i18n( 'Y-m-d', $next_week_timestamp );
        
        return $next_week_date;
    }


}