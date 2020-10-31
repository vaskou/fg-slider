<?php

class CMB2_Type_Items_Per_Slide {

	const FIELD_TYPE = 'items_per_slide';

	private static $single_instance;

	public static function instance() {
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

		$breakpoints = array(
			's'  => __( 'Small', 'fg-slider' ),
			'm'  => __( 'Medium', 'fg-slider' ),
			'l'  => __( 'Large', 'fg-slider' ),
			'xl' => __( 'Extra Large', 'fg-slider' ),
		);

		?>
        <div class="items-per-slide-field-wrapper">
			<?php

			foreach ( $breakpoints as $key => $breakpoint ):
				$args = array(
					'type'  => 'number',
					'id'    => $field_type->_id( '_ips_' . $key ),
					'name'  => $field_type->_name( '[' . $key . ']' ),
					'value' => ! empty( $escaped_value[ $key ] ) ? $escaped_value[ $key ] : '',
					'max'   => 6,
					'min'   => 1
				);

				?>
                <div class="items-per-slide-<?php echo $key; ?>">
                    <label><?php echo $breakpoint; ?></label>
					<?php echo $field_type->input( $args ); ?>
                </div>
			<?php

			endforeach;

			?>

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

CMB2_Type_Items_Per_Slide::instance();
