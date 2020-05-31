<?php

class FG_Slider_Slides_Fields extends FG_Slider_Post_Type_Fields {

	private static $instance;

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->metabox_id    = 'slides';
		$this->metabox_title = __( 'Slides', 'fg-slider' );
		$this->fields        = array(
			'items' => array(
				'name'  => __( 'Slide', 'fg-slider' ),
				'type'   => 'group',
				'fields' => array(
					'image' => array(
						'name'         => __( 'Image', 'fg-slider' ),
						'type'         => 'file',
						'options'      => array(
							'url' => false,
						),
						'text'         => array(
							'add_upload_file_text' => __( 'Add Slide', 'fg-slider' )
						),
						'preview_size' => 'thumbnail',
					),
					'link'  => array(
						'name' => __( 'Link', 'fg-slider' ),
						'type' => 'text_url',
					),
					'title'  => array(
						'name' => __( 'Title', 'fg-slider' ),
						'type' => 'text',
					),
				)
			),
		);

	}

}