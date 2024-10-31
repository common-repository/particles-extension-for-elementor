<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Elementor_Particles_Ext_WP_Plugin_Elementor' ) ) {

    class Elementor_Particles_Ext_WP_Plugin_Elementor {

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

		/**
		 * Constructor
		 */
        public function __construct() {
			if ( ! did_action( 'elementor/loaded' ) ) {
				return;
			}

            add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 9  );
			add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'load_editor_assets' ]);

			$this->load_modules();

			do_action( 'mgs-pefe-action/plugin/elementor/loaded' );
        }

		public function register_scripts() {
            if ( ! wp_script_is( 'mgs-pefe-particles', 'enqueued' ) ) {
                wp_register_script( 'mgs-pefe-particles',
					MGS_PEFE_CONST_URL . 'assets/js/particles' . MGS_PEFE_CONST_DEBUG_SUFFIX . '.js',
                    [ 'jquery' ],
                    MGS_PEFE_CONST_VERSION,
                    true
                );
			}

			wp_register_script( 'mgs-pefe-elementor',
				MGS_PEFE_CONST_URL . 'assets/js/script' . MGS_PEFE_CONST_DEBUG_SUFFIX . '.js',
				[ 'jquery' ],
				MGS_PEFE_CONST_VERSION,
				true
			);

			wp_register_style( 'mgs-pefe-elementor',
				MGS_PEFE_CONST_URL . 'assets/css/style' . MGS_PEFE_CONST_DEBUG_SUFFIX . '.css',
				[],
				MGS_PEFE_CONST_VERSION,
				'all'
			);
		}

		public function load_editor_assets() {
			wp_enqueue_style(
				'mgs-pefe-elementor-editor',
				MGS_PEFE_CONST_URL . 'assets/css/elementor-editor' . MGS_PEFE_CONST_DEBUG_SUFFIX . '.css',
				[],
				MGS_PEFE_CONST_VERSION,
				'all'
			);
		}

        /**
         * Load the required dependencies for elementor.
         */
		public function load_modules() {

            /**
             * Particles Extension
             */
			require_once MGS_PEFE_CONST_DIR . 'libraries/elementor/classes/class-particles.php';

        }

    }

}

if( !function_exists( 'mgs_pefe_wp_plugin_elementor' ) ) {

    /**
     * Returns the instance of a class.
     */
    function mgs_pefe_wp_plugin_elementor() {

        return Elementor_Particles_Ext_WP_Plugin_Elementor::get_instance();
    }
}

mgs_pefe_wp_plugin_elementor();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */