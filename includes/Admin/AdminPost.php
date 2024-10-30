<?php

namespace ReelSoftware\Blockington\Admin;

class AdminPost
{
    /**
     * Setup instance.
     *
     * @var AdminPost
     */
    private static $instance;

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof AdminPost)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Updates rate us admin notice
     *
     * @since 1.0.2
     */
    public function update_rate_us_admin_notice()
    {
        check_admin_referer('rs_blockington_rate_us_verify');

        // User chose "Nope, maybe later"
        if(esc_textarea($_POST['rs_blockington_rate_us_option']) === 'later') {
            $rate_us_after = get_option('rs_blockington_rate_us_after');
            if($rate_us_after === '7') {
                update_option('rs_blockington_rate_us_after', 14);
            } else if($rate_us_after === '14') {
                update_option('rs_blockington_rate_us_after', 30);
            } else {
                // If over 30 days passed then update the rate us date and display again after 30 days
                update_option('rs_blockington_rate_us_date', date("Y-m-d h:i:s"));
            }
        } else {
            update_option('rs_blockington_is_rate_us_showing', 'hide');
        }  
        
        // User chose "Ok, you deserve it"
        if(sanitize_text_field($_POST['rs_blockington_rate_us_option']) === 'rate') {
            wp_redirect('https://blockington.com/rate-plugin-wordpress-admin');
        } else {
            wp_redirect(esc_url($_POST['rs_blockington_current_url']));
        }
    }

    /**
     * Register hooks and filters with WordPress.
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function register()
    {
        add_action('admin_post_rs_blockington_rate_us_action', array($this, 'update_rate_us_admin_notice'));
    }
}