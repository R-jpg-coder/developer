<?php


namespace Easy\Booked;

/**
 * Class Frontend
 *
 * @package Easy\Booked
 */
class Frontend  {

    /**
     * Frontend constructor.
     */
    public function __construct() {
        new Frontend\Wc_Shop_Page();
        new Frontend\Booked_Appointment();
        new Frontend\Staff_Member();
        new Frontend\Time_Slot_Condition();
    }

}