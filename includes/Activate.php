<?php

namespace ReelSoftware\Blockington;

class Activate
{
    /**
     * Setup instance.
     *
     * @var Activate
     */
    private static $instance;

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Activate)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Functions to run before the plugin is activated.
     * 
     * Can be used for initialization purposes.
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function activate_plugin() {
        if (version_compare(get_bloginfo('version'), '6.0', '<')) {
            wp_die(
                __('You must update WordPress to at least 6.0 in order to use this plugin', 'rs-blockington')
            );
        }

        if(get_option('rs_blockington_initial_activation_date') == false) {
            add_option('rs_blockington_initial_activation_date', date("Y-m-d h:i:s"));
        }

        // Date used to display or hide rate us pop-ups
        if(get_option('rs_blockington_rate_us_date') == false) {
            add_option('rs_blockington_rate_us_date', date("Y-m-d h:i:s"));
        }

        // Number of days after which we ask for review (7, 14, 30)
        if(get_option('rs_blockington_rate_us_after') == false) {
            add_option('rs_blockington_rate_us_after', 7);
        }

        // If option is show then display, else option is hide 
        if(get_option('rs_blockington_is_rate_us_showing') == false) {
            add_option('rs_blockington_is_rate_us_showing', 'show');
        }

        flush_rewrite_rules();
    }
}
