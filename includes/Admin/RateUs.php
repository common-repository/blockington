<?php

namespace ReelSoftware\Blockington\Admin;

class RateUs
{
    /**
     * Setup instance.
     *
     * @var RateUs
     */
    private static $instance;

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof RateUs)) {
            self::$instance = new Self();
        }

        return self::$instance;
    }

    /**
     * Adds rate us admin notice to the dashboard
     *
     * @since 1.0.2
     */
    public function rate_us_admin_notice()
    {
        $days_since_activation = date_diff(new \DateTime(get_option('rs_blockington_rate_us_date')), new \DateTime(date("Y-m-d h:i:s")))->d;
        $current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if ($days_since_activation >= get_option('rs_blockington_rate_us_after') && get_option('rs_blockington_is_rate_us_showing') === 'show') {
            ?>
            <div class="notice notice-info">
                <p><?php _e('Hey, I noticed you have been using <b>Blockington</b> for ' . $days_since_activation . ' days - that\'s awesome!', 'rs-blockington'); ?></p>
                <p><?php _e('Could you please do me a BIG favor and give it a <b>5-star</b> rating on WordPress? Just to help us spread the word and boost our motivation.', 'rs-blockington'); ?></p>

                <ul>
                    <li>
                        <form action="admin-post.php" method="POST" id="rs_blockington_rate_form">
                            <?php wp_nonce_field('rs_blockington_rate_us_verify'); ?>
                            <input type="hidden" name="action" value="rs_blockington_rate_us_action">
                            <input type="hidden" name="rs_blockington_rate_us_option" value="rate">
                            <input type="hidden" name="rs_blockington_current_url" value="<?php echo esc_url($current_url); ?>">
                            <a href="javascript:document.getElementById('rs_blockington_rate_form').submit();"><?php _e('⭐Ok, you deserve it', 'rs-blockington'); ?></a>
                        </form>
                    </li>
                    
                    <li>
                        <form action="admin-post.php" method="POST" id="rs_blockington_later_form">
                            <?php wp_nonce_field('rs_blockington_rate_us_verify'); ?>
                            <input type="hidden" name="action" value="rs_blockington_rate_us_action">
                            <input type="hidden" name="rs_blockington_rate_us_option" value="later">
                            <input type="hidden" name="rs_blockington_current_url" value="<?php echo esc_url($current_url); ?>">
                            <a href="javascript:document.getElementById('rs_blockington_later_form').submit();"><?php _e('😔 Nope, maybe later', 'rs-blockington'); ?></a>
                        </form>
                    </li>

                    <li>
                        <form action="admin-post.php" method="POST" id="rs_blockington_done_form">
                            <?php wp_nonce_field('rs_blockington_rate_us_verify'); ?>
                            <input type="hidden" name="action" value="rs_blockington_rate_us_action">
                            <input type="hidden" name="rs_blockington_rate_us_option" value="done">
                            <input type="hidden" name="rs_blockington_current_url" value="<?php echo esc_url($current_url); ?>">
                            <a href="javascript:document.getElementById('rs_blockington_done_form').submit();"><?php _e('😀 I already did', 'rs-blockington'); ?></a>
                        </form>
                    </li>
                </ul>
            </div>
            <?php
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
        add_action('admin_notices', array($this, 'rate_us_admin_notice'));
    }
}