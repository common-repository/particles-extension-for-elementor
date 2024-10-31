<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Elementor_Particles_Ext_WP_Plugin_Action_Links' ) ) {

	/**
	 * Define the additional links and row meta of the plugin.
	 */
    final class Elementor_Particles_Ext_WP_Plugin_Action_Links {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Returns the instance.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
            }

			return self::$instance;
		}

        public function __construct() {
            add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 4 );
			do_action( 'mgs-pefe-action/plugin/action-links/loaded' );
        }

        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
            $new_meta = [];

            if( MGS_PEFE_CONST_BASENAME === $plugin_file ) {
				$new_meta ['support'] = sprintf(
					'<a href="%1$s" target="_blank">🤚🏾 %2$s</a>',
					esc_url( '//wordpress.org/support/plugin/particles-extension-for-elementor/' ),
					esc_html__( 'Support', 'particles-extension-for-elementor' )
				);
            }

            return array_merge( $plugin_meta, $new_meta );
        }
	}

}

if( !function_exists( 'mgs_pefe_wp_plugin_action_links' ) ) {
    /**
     * Returns instance of the class.
     */
    function mgs_pefe_wp_plugin_action_links() {
        return Elementor_Particles_Ext_WP_Plugin_Action_Links::get_instance();
    }
}

mgs_pefe_wp_plugin_action_links();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */