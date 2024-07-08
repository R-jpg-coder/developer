<?php
// Hook into the admin_notices action
add_action('admin_notices', 'easy_booked_require_user_registration_plugin');

function easy_booked_require_user_registration_plugin() {
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    }

    // Check if the User Registration plugin is not active
    if ( ! is_plugin_active( 'easy-booked/appointment-booking-and-scheduling.php' ) ) {
        $install_url = wp_nonce_url(
            add_query_arg(
                array(
                    'action' => 'install-plugin',
                    'plugin' => 'easy-booked',
                ),
                admin_url('update.php')
            ),
            'install-plugin_easy-booked'
        );
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php
                printf(
                    esc_html__(
                        'To use the Easy Booked Pro plugin, you need to have the %s installed and activated.',
                        'appointment-booking-pro'
                    ),
                    '<a href="' . esc_url($install_url) . '">' . esc_html__('Easy Booked free version plugin', 'appointment-booking-pro') . '</a>'
                );
                ?></p>
        </div>
        <?php
    }
}


