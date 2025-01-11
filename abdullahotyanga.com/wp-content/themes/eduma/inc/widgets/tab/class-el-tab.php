<?php
/**
 * Thim_Builder Elementor Tab widget
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, tuanta
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_El_Tab' ) ) {
	/**
	 * Class Thim_Builder_El_Tab
	 */
	class Thim_Builder_El_Tab extends Thim_Builder_El_Widget {

		/**
		 * @var string
		 */
		protected $config_class = 'Thim_Builder_Config_Tab';

		/**
		 * Register controls.
		 */
		protected function _register_controls() {
			$this->start_controls_section(
				'el-tab', [ 'label' => esc_html__( 'Thim: Tab', 'eduma' )]
			);

			$controls = \Thim_Builder_El_Mapping::mapping( $this->options() );

			foreach ( $controls as $key => $control ) {
 				$this->add_control( $key, $control );
			}

			$this->end_controls_section();
		}
	}
}