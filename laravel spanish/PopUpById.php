<?php


namespace Easy\Booked\Frontend;


class PopUpById {

    /**
     * PopUpById constructor.
     */
    public function __construct() {
        add_shortcode( 'easy-booked-popup-by-id', array( $this, 'popup' ) );
    }

    /**
     * @param $atts
     * @return string
     */
    public function popup( $atts ) {

        $atts = shortcode_atts(
            array(
                'calendar_id' => '',
                'button_id'   => '',
            ),
            $atts,
            'easy-booked-popup-by-id'
        );

        // Sanitize and validate the values
        $calendar_id = sanitize_text_field($atts['calendar_id']);
        $button_id = sanitize_text_field($atts['button_id']);

        $html = sprintf(
            '
            <div class="%s abs-pop-up" max-width>
                <!-- Modal content -->
                <div class="abs-pop-up-modal-content">
                    <div class="abs-pop-up-close">
                        <i class="fas fa-times "></i>
                    </div>
                    %s
                </div>
                
            </div>',
            esc_attr( 'abs-popup-'. $button_id ),
            do_shortcode("[easy-booked calendar={$calendar_id}]")
        );

        $custom_script = ";
                (function ($) {
                    $(document).on('click', '#" . $button_id . "', function (event) {
                        $('.abs-popup-" . $button_id . "').show();
                        $('.abs-popup-" . $button_id . "').find('.abs-pop-up-modal-content').addClass('abs-zoom-in');
                        if (typeof window.abs_adjust_calendar_boxes === 'function') {
                            window.abs_adjust_calendar_boxes();
                        }
                    });
                })(jQuery);
            ";
        wp_add_inline_script("abs-frontend", $custom_script);

        $custom_css = "
            .abs-popup-{$button_id}.abs-pop-up-modal-content {
                opacity: 0; /* Start with opacity 0 */
                transform: scale(0.7); /* Start with a smaller size */
                transition: opacity 0.3s ease, transform 0.3s ease; /* Add transition properties */
            } 
            
        ";
        wp_add_inline_style( 'abs-frontend', $custom_css );

        return $html;
    }
}