<?php

class CMB2_Type_Ratio {

	const FIELD_TYPE = 'ratio';

	private static $single_instance;

	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	public function __construct() {
		$field_type = self::FIELD_TYPE;
		add_action( "cmb2_render_{$field_type}", array( $this, 'render' ), 10, 5 );
		add_action( "cmb2_sanitize_{$field_type}", array( $this, 'sanitize' ), 10, 2 );
		add_action( "cmb2_types_esc_{$field_type}", array( $this, 'escape_value' ), 10, 2 );
	}


	/**
	 * @param $field         CMB2_Field
	 * @param $escaped_value mixed
	 * @param $object_id     int
	 * @param $object_type   string
	 * @param $field_type    CMB2_Types
	 */
	public function render( $field, $escaped_value, $object_id, $object_type, $field_type ) {
		ob_start();

		$options = ! empty( $field->args['options'] ) ? $field->args['options'] : array();
		?>
        <div class="ratio-field-wrapper">
			<?php
			$args = array(
				'type'  => 'number',
				'id'    => $field_type->_id( 'ratio' ),
				'name'  => $field_type->_name( '[width]' ),
				'value' => $escaped_value['width'],
				'desc'  => '',
			);
			?>

            <div class="ratio-width">
				<?php echo $field_type->input( $args ); ?>
            </div>

			<?php

			$args['name']  = $field_type->_name( '[height]' );
			$args['value'] = $escaped_value['height'];

			?>

            <div class="ratio-height">
				<?php echo $field_type->input( $args ); ?>
            </div>
        </div>
		<?php

		$html = ob_get_clean();

		echo $html;

		$field_type->_desc( true, true );
	}

	public function sanitize( $sanitized_val, $val ) {

		if ( ! is_array( $val ) ) {
			return array();
		}

		foreach ( $val as $key => $value ) {
			$sanitized_value = sanitize_text_field( $value );
			$sanitized_value = isset( $sanitized_value ) && '' != $sanitized_value ? intval( $sanitized_value ) : '';

			$sanitized_val[ $key ] = is_int( $sanitized_value ) ? $sanitized_value : '';
		}

		return $sanitized_val;
	}

	public function escape_value( $escaped_value, $val ) {

		if ( ! is_array( $val ) ) {
			return array();
		}

		foreach ( $val as $key => $value ) {
			$escaped_value[ $key ] = esc_attr( $value );
		}

		return $escaped_value;
	}

}

CMB2_Type_Ratio::get_instance();
