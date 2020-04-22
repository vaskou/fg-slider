<?php

defined( 'ABSPATH' ) or die();

class FG_Slider_Post_Type {

	const POST_TYPE_NAME = 'fg_slider';
	const POST_TYPE_SLUG = 'slider';

	private static $instance = null;
	private $metabox_prefix = 'fg_slider_metabox_';
	private $field_prefix = 'fg_slider_';

	/**
	 * FG_Guitars_Post_Type constructor.
	 */
	private function __construct() {
	}

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_metaboxes' ) );
	}

	/**
	 * Registers post type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'FG Sliders', 'FG Sliders General Name', 'fg-slider' ),
			'singular_name'         => _x( 'FG Slider', 'FG Slider Singular Name', 'fg-slider' ),
			'menu_name'             => __( 'FG Sliders', 'fg-slider' ),
			'name_admin_bar'        => __( 'FG Sliders', 'fg-slider' ),
			'archives'              => __( 'FG Slider Archives', 'fg-slider' ),
			'attributes'            => __( 'FG Slider Attributes', 'fg-slider' ),
			'parent_item_colon'     => __( 'Parent FG Slider:', 'fg-slider' ),
			'all_items'             => __( 'All FG Sliders', 'fg-slider' ),
			'add_new_item'          => __( 'Add New FG Slider', 'fg-slider' ),
			'add_new'               => __( 'Add New', 'fg-slider' ),
			'new_item'              => __( 'New FG Slider', 'fg-slider' ),
			'edit_item'             => __( 'Edit FG Slider', 'fg-slider' ),
			'update_item'           => __( 'Update FG Slider', 'fg-slider' ),
			'view_item'             => __( 'View FG Slider', 'fg-slider' ),
			'view_items'            => __( 'View FG Sliders', 'fg-slider' ),
			'search_items'          => __( 'Search FG Slider', 'fg-slider' ),
			'not_found'             => __( 'Not found', 'fg-slider' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'fg-slider' ),
			'featured_image'        => __( 'Featured Image', 'fg-slider' ),
			'set_featured_image'    => __( 'Set Featured Image', 'fg-slider' ),
			'remove_featured_image' => __( 'Remove Featured Image', 'fg-slider' ),
			'use_featured_image'    => __( 'Use as Featured Image', 'fg-slider' ),
			'insert_into_item'      => __( 'Insert into FG Slider', 'fg-slider' ),
			'uploaded_to_this_item' => __( 'Uploaded to this FG Slider', 'fg-slider' ),
			'items_list'            => __( 'FG Sliders list', 'fg-slider' ),
			'items_list_navigation' => __( 'FG Sliders list navigation', 'fg-slider' ),
			'filter_items_list'     => __( 'Filter FG Sliders list', 'fg-slider' ),
		);

		$rewrite = array(
			'slug'       => self::POST_TYPE_SLUG,
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'         => __( 'FG Slider', 'fg-slider' ),
			'description'   => __( 'FG Slider Description', 'fg-slider' ),
			'labels'        => $labels,
			'supports'      => array( 'title' ),
			'taxonomies'    => array(),
			'hierarchical'  => false,
			'public'        => false,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-admin-post',
			'menu_position' => 30,
			'can_export'    => true,
			'rewrite'       => $rewrite,
			'map_meta_cap'  => true,
			'show_in_rest'  => false,
		);
		register_post_type( self::POST_TYPE_NAME, $args );
	}

	/**
	 * Adds metaboxes
	 */
	public function add_metaboxes() {
		$cmb2_metabox = new_cmb2_box( array(
			'id'           => $this->metabox_prefix . 'options',
			'title'        => __( 'Slider Options', 'fg-slider' ),
			'object_types' => array( self::POST_TYPE_NAME ), // Post type
			'context'      => 'side',
			'priority'     => 'low',
			'show_names'   => true, // Show field names on the left
		) );

		$cmb2_metabox->add_field( array(
			'id'      => $this->field_prefix . 'type',
			'name'    => __( 'Type', 'fg-slider' ),
			'type'    => 'select',
			'default' => 'slider',
			'options' => array(
				'slider'    => __( 'Slider', 'fg-slider' ),
				'slideshow' => __( 'Slideshow', 'fg-slider' ),
			)
		) );

		$cmb2_metabox->add_field( array(
			'id'      => $this->field_prefix . 'animation',
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
		) );

		$cmb2_metabox->add_field( array(
			'id'      => $this->field_prefix . 'autoplay',
			'name'    => __( 'Autoplay', 'fg-slider' ),
			'type'    => 'select',
			'default' => 'disable',
			'options' => array(
				'true'  => __( 'Enable', 'fg-slider' ),
				'false' => __( 'Disable', 'fg-slider' ),
			)
		) );

		$cmb2_metabox->add_field( array(
			'id'         => $this->field_prefix . 'autoplay-interval',
			'name'       => __( 'Autoplay Interval', 'fg-slider' ),
			'type'       => 'text',
			'default'    => 7000,
			'attributes' => array(
				'type' => 'number',
			)
		) );

		$cmb2_metabox->add_field( array(
			'id'      => $this->field_prefix . 'draggable',
			'name'    => __( 'Draggable', 'fg-slider' ),
			'type'    => 'select',
			'default' => 'enable',
			'options' => array(
				'true'  => __( 'Enable', 'fg-slider' ),
				'false' => __( 'Disable', 'fg-slider' ),
			)
		) );

//		$cmb2_metabox->add_field( array(
//			'id'      => $this->field_prefix . 'easing',
//			'name'    => __( 'Easing', 'fg-slider' ),
//			'type'    => 'select',
//			'default' => 'ease',
//			'options' => array(
//				'ease'  => __( 'Ease', 'fg-slider' ),
//			),
//		) );

		$cmb2_metabox->add_field( array(
			'id'      => $this->field_prefix . 'finite',
			'name'    => __( 'Finite', 'fg-slider' ),
			'type'    => 'select',
			'default' => 'disable',
			'options' => array(
				'true'  => __( 'Enable', 'fg-slider' ),
				'false' => __( 'Disable', 'fg-slider' ),
			)
		) );

		$cmb2_metabox->add_field( array(
			'id'      => $this->field_prefix . 'pause-on-hover',
			'name'    => __( 'Pause On Hover', 'fg-slider' ),
			'type'    => 'select',
			'default' => 'enable',
			'options' => array(
				'true'  => __( 'Enable', 'fg-slider' ),
				'false' => __( 'Disable', 'fg-slider' ),
			)
		) );

		$cmb2_metabox = new_cmb2_box( array(
			'id'           => $this->metabox_prefix . 'slides',
			'title'        => __( 'Slides', 'fg-slider' ),
			'object_types' => array( self::POST_TYPE_NAME ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		) );

		$group_field_slides = $cmb2_metabox->add_field( array(
			'id'      => $this->field_prefix . 'slides',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Slide {#}', 'fg-slider' ),
				'add_button'    => __( 'Add Another Slide', 'fg-slider' ),
				'remove_button' => __( 'Remove Slide', 'fg-slider' ),
			)
		) );

		$cmb2_metabox->add_group_field( $group_field_slides, array(
			'name'         => __( 'Image', 'fg-slider' ),
			'id'           => 'image',
			'type'         => 'file',
			'options'      => array(
				'url' => false,
			),
			'text'         => array(
				'add_upload_file_text' => 'Add Slide'
			),
			'preview_size' => 'thumbnail',
		) );

		$cmb2_metabox->add_group_field( $group_field_slides, array(
			'name' => __( 'Link', 'fg-slider' ),
			'id'   => 'link',
			'type' => 'text_url',
		) );
	}

	/**
	 * @return int[]|WP_Post[]
	 */
	public function get_items() {
		return $this->_get_items();
	}

	/**
	 * @param $id
	 *
	 * @return int[]|WP_Post[]
	 */
	public function get_item( $id ) {
		$args = array(
			'p' => $id
		);

		return $this->_get_items( $args );
	}

	public function get_slider( $id ) {
		$item = $this->get_item( $id );

		if ( empty( $item[0] ) ) {
			return false;
		}

		$slider_id = $item[0]->ID;

		$slider = array(
			'options' => array(
				'type'              => get_post_meta( $slider_id, $this->field_prefix . 'type', true ),
				'animation'         => get_post_meta( $slider_id, $this->field_prefix . 'animation', true ),
				'autoplay-interval' => get_post_meta( $slider_id, $this->field_prefix . 'autoplay-interval', true ),
				'autoplay'          => get_post_meta( $slider_id, $this->field_prefix . 'autoplay', true ),
				'draggable'         => get_post_meta( $slider_id, $this->field_prefix . 'draggable', true ),
				'finite'            => get_post_meta( $slider_id, $this->field_prefix . 'finite', true ),
				'pause-on-hover'    => get_post_meta( $slider_id, $this->field_prefix . 'pause-on-hover', true ),
			),
			'slides'  => get_post_meta( $slider_id, $this->field_prefix . 'slides', true )
		);

		return $slider;

	}

	/**
	 * @param array $args
	 *
	 * @return int[]|WP_Post[]
	 */
	private function _get_items( $args = array() ) {

		$default = array(
			'post_type'      => self::POST_TYPE_NAME,
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
		);

		$args = wp_parse_args( $args, $default );

		$query = new WP_Query( $args );

		return $query->get_posts();
	}

}