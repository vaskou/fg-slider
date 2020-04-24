<?php

class FG_Slider_Option_Fields extends FG_Slider_Post_Type_Fields {

	private static $instance;

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->metabox_id    = 'options';
		$this->metabox_title = __( 'Slider Options', 'fg-slider' );
		$this->fields        = array(
			'type'              => array(
				'name'    => __( 'Type', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'slider',
				'options' => array(
					'slider'    => __( 'Slider', 'fg-slider' ),
					'slideshow' => __( 'Slideshow', 'fg-slider' ),
				)
			),
			'animation'         => array(
				'name'    => __( 'Animation', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'slide',
				'options' => array(
					'fade'  => __( 'Fade', 'fg-slider' ),
					'pull'  => __( 'Pull', 'fg-slider' ),
					'push'  => __( 'Push', 'fg-slider' ),
					'scale' => __( 'Scale', 'fg-slider' ),
					'slide' => __( 'Slide', 'fg-slider' ),
				),
			),
			'autoplay'          => array(
				'name'    => __( 'Autoplay', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'disable',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				)
			),
			'autoplay-interval' => array(
				'name'       => __( 'Autoplay Interval', 'fg-slider' ),
				'type'       => 'text',
				'default'    => 7000,
				'attributes' => array(
					'type' => 'number',
				)
			),
			'draggable'         => array(
				'name'    => __( 'Draggable', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'enable',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				)
			),
//			'easing'         => array(
//				'name'   => __( 'Easing', 'fg-slider' ),
//				'type'    => 'select',
//				'default' => 'ease',
//				'options' => array(
//					'ease'  => __( 'Ease', 'fg-slider' ),
//				)
//			),
			'finite'            => array(
				'name'    => __( 'Finite', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'disable',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				)
			),
			'pause-on-hover'    => array(
				'name'    => __( 'Pause On Hover', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'enable',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				)
			),
		);

	}

}