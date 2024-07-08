<?php


namespace Easy\Booked\Frontend;


class Staff_Member {

    /**
     * Staff_Member constructor.
     */
    public function __construct() {
        add_filter( 'abs_user_profile_menu', array( $this, 'staff_member_menu' ) );
        add_filter( 'abs_user_template_load', array( $this, 'load_template' ) , 10, 2 );
    }

    /**
     * User profile menu init
     *
     * @param $menus
     * @return mixed
     */
    public function staff_member_menu( $menus ) {

        $user = wp_get_current_user();

        if ( in_array( 'administrator', $user->roles ) || in_array( 'easy_booked_staff_member', $user->roles ) ) {

            unset( $menus['upcomming'] );

            $new_menu['pending']   = array( 'fas fa-calendar-plus', esc_html( 'Pending', 'appointment-booking' ) );

            foreach ( $menus as  $key => $row ) {
                $new_menu[ $key ] = $row;
            }

            return $new_menu;

        } else {
            return $menus;
        }

    }

    /**
     *
     */
    public function load_template( $template, $action ) {
        $user = wp_get_current_user();

        if ( in_array( 'administrator', $user->roles ) || in_array( 'easy_booked_staff_member', $user->roles ) ) {

            if ( $action == 'pending' || empty( $action ) ) {
                $template = __DIR__ . '/views/pending.php';
            }

            return $template;
        }

        return $template;
    }
}