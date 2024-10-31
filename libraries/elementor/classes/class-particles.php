<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Elementor_Particles_Ext_WP_Plugin_Particles' ) ) {

    class Elementor_Particles_Ext_WP_Plugin_Particles {

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

			add_action( 'elementor/element/container/section_layout/before_section_start', [ $this, 'register_section' ], 999, 2 );
			add_action( 'elementor/element/section/section_structure/after_section_end', [ $this, 'register_section' ], 999, 2 );

			add_action( 'elementor/elements/elements_registered', [ $this, 'elements_registered' ] );

			do_action( 'mgs-pefe-action/plugin/elementor/extension/particles/loaded' );
		}

		public function register_section( $element, $section_id ) {
            $tab      = Elementor\Controls_Manager::TAB_LAYOUT;
            $ele_name = $element->get_name();
            $name     = str_replace( ' ', '', ucwords( str_replace( '-', ' ', $ele_name ) ) );

			$this->_register_particles_section( $element, $name, $tab );
		}

		public function _register_particles_section( $controls_stack, $name, $tab ) {
            $controls_stack->start_controls_section( '_stack_particles_section', [
                'label' => sprintf(
					/* translators: %s: Element Name ( Section or Container ) */
					__( '%s : Particles', 'particles-extension-for-elementor'),
					$name
				),
                'tab'   => $tab
            ] );
				$controls_stack->add_control( '_enable_particles', [
					'label'        => esc_html__( 'Enable Particles', 'particles-extension-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'particles-extension-for-elementor' ),
					'label_off'    => esc_html__( 'No', 'particles-extension-for-elementor' ),
					'return_value' => 'yes',
					'default'      => 'no',
				] );
				$controls_stack->add_control( '_particles_number', [
					'label'     => esc_html__( 'Number', 'particles-extension-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::NUMBER,
					'min'       => 1,
					'max'       => 200,
					'step'      => 1,
					'default'   => 20,
					'condition' => [
						'_enable_particles' => 'yes'
					],
				] );
				$controls_stack->add_control( '_particles_shapes', [
					'label'       => esc_html__( 'Shapes', 'particles-extension-for-elementor' ),
					'label_block' => true,
					'multiple'    => true,
					'type'        => \Elementor\Controls_Manager::SELECT2,
					'options'     => [
						'circle'   => esc_html__( 'Circle', 'particles-extension-for-elementor' ),
						'edge'     => esc_html__( 'Square', 'particles-extension-for-elementor' ),
						'star'     => esc_html__( 'Star', 'particles-extension-for-elementor' ),
						'triangle' => esc_html__( 'Triangle', 'particles-extension-for-elementor' ),
					],
					'default'     => [
						'circle'
					],
					'condition'   => [
						'_enable_particles' => 'yes'
					],
				] );
				$controls_stack->add_control( '_particles_size', [
					'label'     => esc_html__( 'Size', 'particles-extension-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::NUMBER,
					'min'       => 1,
					'max'       => 100,
					'step'      => 1,
					'default'   => 20,
					'condition' => [
						'_enable_particles' => 'yes'
					],
				] );
				$controls_stack->add_control( '_particles_random_size', [
					'label'        => esc_html__( 'Enable Random Size', 'particles-extension-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'particles-extension-for-elementor' ),
					'label_off'    => esc_html__( 'No', 'particles-extension-for-elementor' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'_enable_particles' => 'yes'
					],
				] );
				$controls_stack->add_control( '_particles_dir', [
					'label'       => esc_html__( 'Animation Direction', 'particles-extension-for-elementor' ),
					'type'        => \Elementor\Controls_Manager::CHOOSE,
					'label_block' => true,
					'options'     => [
						'none'         => [
							'title' => esc_html__('None', 'particles-extension-for-elementor'),
							'icon'  => '',
						],
						'top'          => [
							'title' => esc_html__('Top', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-up',
						],
						'top-right'    => [
							'title' => esc_html__('Top Right', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-up mgs-pefe-icon-rotate-45',
						],
						'right'        => [
							'title' => esc_html__('Right', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-right',
						],
						'bottom-right' => [
							'title' => esc_html__('Bottom Right', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-down mgs-pefe-icon-rotate-45-alt',
						],
						'bottom'       => [
							'title' => esc_html__('Bottom', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-down',
						],
						'bottom-left'  => [
							'title' => esc_html__('Bottom Left', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-down mgs-pefe-icon-rotate-45',
						],
						'left'         => [
							'title' => esc_html__('Left', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-left',
						],
						'top-left'     => [
							'title' => esc_html__('Top Left', 'particles-extension-for-elementor'),
							'icon'  => 'eicon-arrow-up mgs-pefe-icon-rotate-45-alt',
						],
					],
					'default'     => 'left',
					'toggle'      => false,
					'condition'   => [
						'_enable_particles' => 'yes'
					],
				] );
				$controls_stack->add_control( '_enable_particles_line_linked', [
					'label'        => esc_html__( 'Enable Linked Line', 'particles-extension-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'particles-extension-for-elementor' ),
					'label_off'    => esc_html__( 'No', 'particles-extension-for-elementor' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'_enable_particles' => 'yes'
					],
				] );
				$controls_stack->add_control( '_particles_line_linked_color', [
					'label'     => esc_html__( 'Linked Line Color', 'particles-extension-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						'_enable_particles'             => 'yes',
						'_enable_particles_line_linked' => 'yes',
					],
				] );

				$repeater = new \Elementor\Repeater();
				$repeater->add_control( '_particles_color', [
					'label' => esc_html__( 'Color', 'particles-extension-for-elementor' ),
					'type'  => \Elementor\Controls_Manager::COLOR,
				]);
				$controls_stack->add_control( '_particles_color_item', [
					'label'     => esc_html__( 'Colors', 'particles-extension-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::REPEATER,
					'fields'    => $repeater->get_controls(),
					'default'   => [],
					'condition' => [
						'_enable_particles' => 'yes',
					]
				] );
			$controls_stack->end_controls_section();
		}

		public function elements_registered( $el_manager ){

            /**
             * Section
             */
			require_once MGS_PEFE_CONST_DIR . 'libraries/elementor/elements/class-section.php';
            $el_manager->register_element_type( new Elementor_Particles_Ext_WP_Plugin_Section_Ele() );

            /**
             * Container
             */
			require_once MGS_PEFE_CONST_DIR . 'libraries/elementor/elements/class-container.php';
            $el_manager->register_element_type( new Elementor_Particles_Ext_WP_Plugin_Container_Ele() );


		}

    }

}

if( !function_exists( 'mgs_pefe_wp_plugin_elementor_particles' ) ) {

    /**
     * Returns the instance of a class.
     */
    function mgs_pefe_wp_plugin_elementor_particles() {

        return Elementor_Particles_Ext_WP_Plugin_Particles::get_instance();
    }
}

mgs_pefe_wp_plugin_elementor_particles();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */