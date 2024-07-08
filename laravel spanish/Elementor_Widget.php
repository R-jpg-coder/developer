<?php


namespace Easy\Booked;


use Easy\Booked\Elementor_Widget\PopupCalendar;
use Easy\Booked\Elementor_Widget\Booking_List;

class Elementor_Widget {

    /**
     * Elementor_Widget constructor.
     */
    public function __construct() {
        add_action( 'elementor/widgets/register', array( $this, 'register_widget' ) );
    }

    /**
     * Register elementor widget
     */
    public function register_widget() {
        // Check if Elementor is active
        if (class_exists('Elementor\Widget_Base')) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new PopupCalendar() );
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Booking_List() );
        }
    }
}