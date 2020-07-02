<?php

abstract class FG_Slider_Post_Type_Fields {

	private $prefix_metabox_id = 'fg_slider_metabox_';
	private $prefix_field_id = 'fg_slider_';

	protected $metabox_id = '';
	protected $metabox_title = '';
	protected $fields = array();

	/**
	 * @return string
	 */
	public function getPrefixMetaboxId() {
		return $this->prefix_metabox_id;
	}

	/**
	 * @return string
	 */
	public function getPrefixFieldId() {
		return $this->prefix_field_id;
	}

	/**
	 * @return mixed
	 */
	public function getMetaboxId() {
		return $this->metabox_id;
	}

	/**
	 * @return mixed
	 */
	public function getMetaboxTitle() {
		return $this->metabox_title;
	}

	/**
	 * @return mixed
	 */
	public function getFields() {
		return $this->fields;
	}

	public function getPostMeta( $post_id ) {
		$post_meta    = array();
		$field_prefix = $this->getFieldMetaKeyPrefix();

		foreach ( $this->fields as $key => $args ) {
			$post_meta[ $this->metabox_id ][ $key ] = get_post_meta( $post_id, $field_prefix . $key, true );
		}

		return $post_meta;
	}


	public function getFieldMetaKeyPrefix() {
		return $this->getPrefixFieldId() . $this->getMetaboxId() . '_';
	}

	public function addMetaboxes( $post_type, $context = 'normal', $priority = 'high' ) {
		if ( ! function_exists( 'new_cmb2_box' ) ) {
			return;
		}

		$metabox = $this->_addMetabox( $post_type, $context, $priority );

		$this->_addMetaboxFields( $metabox );
	}

	protected function _addMetabox( $post_type, $context = 'normal', $priority = 'high' ) {
		return new_cmb2_box( array(
			'id'           => $this->getPrefixMetaboxId() . $this->getMetaboxId(),
			'title'        => $this->getMetaboxTitle(),
			'object_types' => array( $post_type ), // Post type
			'context'      => $context,
			'priority'     => $priority,
			'show_names'   => true, // Show field names on the left
		) );
	}

	/**
	 * @param $metabox CMB2
	 */
	protected function _addMetaboxFields( $metabox ) {
		if ( empty( $metabox ) ) {
			return;
		}

		foreach ( $this->fields as $id => $values ) {

			$defaults = array(
				'id' => $this->getFieldMetaKeyPrefix() . $id,
			);

			$args = wp_parse_args( $values, $defaults );

			if ( 'group' == $values['type'] ) {
				$this->_addMetaboxGroupField( $metabox, $args );
			} else {
				$metabox->add_field( $args );
			}

		}
	}

	/**
	 * @param $metabox CMB2
	 */
	private function _addMetaboxGroupField( $metabox, $args ) {
		if ( empty( $metabox ) ) {
			return;
		}

		$group_title = $args['name'];

		$group_id = $metabox->add_field( array(
			'id'      => $args['id'],
			'type'    => 'group',
			'options' => array(
				'group_title'   => $group_title . ' {#}',
				'add_button'    => sprintf( __( 'Add Another %s', 'fg-slider' ), $group_title ),
				'remove_button' => sprintf( __( 'Remove %s', 'fg-slider' ), $group_title ),
				'sortable'      => true,
				// 'closed'         => true, // true to have the groups closed by default
				// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
			),
		) );

		$this->_addMetaboxGroupFields( $metabox, $group_id, $args );
	}

	/**
	 * @param $metabox CMB2
	 * @param $group_id integer
	 */
	private function _addMetaboxGroupFields( $metabox, $group_id, $args ) {
		if ( empty( $metabox ) ) {
			return;
		}

		foreach ( $args['fields'] as $id => $values ) {

			$defaults = array(
				'id' => $id,
			);

			$args = wp_parse_args( $values, $defaults );

			$metabox->add_group_field( $group_id, $args );

		}

	}


}