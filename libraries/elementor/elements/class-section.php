<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class Elementor_Particles_Ext_WP_Plugin_Section_Ele extends  \Elementor\Element_Section {

	public function after_render() {
        printf(
            '</div> %2$s </%1$s>',
            esc_attr( $this->get_html_tag() ),
            wp_kses_post ( $this->_get_particles_section() )
        );
    }

    public function _get_particles_section() {
        $html     = '';
        $settings = $this->get_settings_for_display();

        if( isset( $settings['_enable_particles'] ) && $settings['_enable_particles'] == 'yes' ) {

            wp_enqueue_script( 'mgs-pefe-particles' );
            wp_enqueue_script( 'mgs-pefe-elementor' );
            wp_enqueue_style( 'mgs-pefe-elementor' );

            /**
             * ID
             */
                $this->add_render_attribute( 'particles', 'id', 'section-mgs-pefe-particles-'.esc_attr( $this->get_id() ) );

            /**
             * Class
             */
                $this->add_render_attribute( 'particles', 'class', 'mgs-pefe-particles' );

            /**
             * Number
             */
                $this->add_render_attribute( 'particles', 'data-number', esc_attr( $settings['_particles_number'] ) );

            /**
             * Shapes
             */
                $shapes = [];
                foreach( $settings['_particles_shapes'] as $shape ) {
                    $shapes[] = $shape;
                }

                if( empty( $shapes ) ) {
                    $shapes[] = 'circle';
                }

                $this->add_render_attribute( 'particles', 'data-shapes', wp_json_encode( $shapes ) );

            /**
             * Size
             */
                $this->add_render_attribute( 'particles', 'data-size', esc_attr( $settings['_particles_size'] ) );

            /**
             * Random Size
             */
                $this->add_render_attribute( 'particles', 'data-size-random', esc_attr( $settings['_particles_random_size'] ) );

            /**
             * Direction
             */
                $this->add_render_attribute( 'particles', 'data-dir', esc_attr( $settings['_particles_dir'] ) );

            /**
             * Line Linked
             */
                $this->add_render_attribute( 'particles', 'data-line-linked', esc_attr( $settings['_enable_particles_line_linked'] ) );
                if( $settings['_enable_particles_line_linked'] === 'yes' ) {
                    $this->add_render_attribute( 'particles', 'class', 'mgs-pefe-particles-has-linked' );
                }

            /**
             * Line Linked Color
             */
                $llcolor = !empty( $settings['_particles_line_linked_color'] ) ? $settings['_particles_line_linked_color'] : '#FFFFFF';
                $this->add_render_attribute( 'particles', 'data-line-linked-color', esc_attr( $llcolor ) );

            /**
             * Colors
             */
                $colors = [];
                foreach( $settings['_particles_color_item'] as $color ) {
                    $colors[] = $color['_particles_color'];
                }

                if( empty( $colors ) ) {
                    $colors[] = '#e4f1d5';
                }

                $this->add_render_attribute( 'particles', 'data-color', wp_json_encode($colors) );

            $html = '<div '. $this->get_render_attribute_string( 'particles' ).'></div>';
        }

        return $html;
    }

}