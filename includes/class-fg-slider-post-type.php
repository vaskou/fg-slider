<?php

defined( 'ABSPATH' ) or die();

class FG_Slider_Post_Type {

	const POST_TYPE_NAME = 'fg_slider';
	const POST_TYPE_SLUG = 'slider';

	private static $instance = null;

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

		FG_Slider_Option_Fields::getInstance()->addMetaboxes( self::POST_TYPE_NAME, 'side', 'low' );
		FG_Slider_Slides_Fields::getInstance()->addMetaboxes( self::POST_TYPE_NAME );
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

		$options = FG_Slider_Option_Fields::getInstance()->getPostMeta( $slider_id );

		$slides = FG_Slider_Slides_Fields::getInstance()->getPostMeta( $slider_id );

		$slider = array_merge( $options, $slides );

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