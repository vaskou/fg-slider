<?php

class FG_Slider_Option_Fields extends FG_Slider_Post_Type_Fields {

	private static $instance;

	private $slider_fields_only = array(
		'center',
		'sets'
	);

	private $slideshow_fields_only = array(
		'animation',
		'ratio',
		'min-height',
		'max-height'
	);

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
				'default' => 'false',
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
				'default' => 'true',
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
				'default' => 'false',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				)
			),
			'pause-on-hover'    => array(
				'name'    => __( 'Pause On Hover', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'true',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				)
			),
			'ratio'             => array(
				'name' => __( 'Ratio', 'fg-slider' ),
				'type' => 'ratio',
			),
			'sets'              => array(
				'name'    => __( 'Sets', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'false',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				),
			),
			'items_per_slide'   => array(
				'name' => __( 'Items Per Slide', 'fg-slider' ),
				'type' => 'items_per_slide',
			),
			'navigation_arrows' => array(
				'name'    => __( 'Navigation Arrows', 'fg-slider' ),
				'type'    => 'select',
				'default' => 'false',
				'options' => array(
					'true'  => __( 'Enable', 'fg-slider' ),
					'false' => __( 'Disable', 'fg-slider' ),
				)
			),
		);

		$this->fields = $this->_filter_field_classes( $this->fields );

	}

	public function getPostMeta( $post_id ) {

		$post_meta = parent::getPostMeta( $post_id );

		$filtered_options = array();

		$options = $post_meta[ $this->metabox_id ];

		$filtered_options_keys = $this->_filter_options_keys( $options );

		foreach ( $options as $key => $value ) {
			if ( ! in_array( $key, $filtered_options_keys ) ) {
				continue;
			}
			$filtered_options[ $key ] = $value;
		}

		$post_meta[ $this->metabox_id ] = $filtered_options;

		return $post_meta;

	}

	private function _filter_field_classes( $fields ) {
		foreach ( $fields as $key => &$value ) {
			$classes = is_array( $value['classes'] ) ? $value['classes'] : ! empty( $value['classes'] ) ? array( $value['classes'] ) : array();
			if ( in_array( $key, $this->slider_fields_only ) ) {
				$classes = array_merge( $classes, array( 'show-on-slider', 'show-on' ) );
			}
			if ( in_array( $key, $this->slideshow_fields_only ) ) {
				$classes = array_merge( $classes, array( 'show-on-slideshow', 'show-on' ) );
			}
			$value['classes'] = $classes;
		}

		return $fields;
	}

	private function _filter_options_keys( $options, $excluded_options = array() ) {

		$filtered_options = array();

		if ( 'slider' == $options['type'] ) {
			$excluded_options = array_merge( $excluded_options, $this->slideshow_fields_only );
		}

		if ( 'slideshow' == $options['type'] ) {
			$excluded_options = array_merge( $excluded_options, $this->slider_fields_only );
		}

		foreach ( $options as $key => $value ) {
			if ( in_array( $key, $excluded_options ) ) {
				continue;
			}
			$filtered_options[] = $key;
		}

		return $filtered_options;
	}

}