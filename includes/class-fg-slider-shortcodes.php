<?php

defined( 'ABSPATH' ) or die();

class FG_Slider_Shortcodes {

	const SLIDER_SHORTCODE_NAME = 'fg-slider';

	private static $instance = null;

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	public function register_shortcodes() {
		add_shortcode( self::SLIDER_SHORTCODE_NAME, array( $this, 'slider_shortcode' ) );
	}

	public function slider_shortcode( $atts ) {

		$default = array(
			'id' => ''
		);

		$args = shortcode_atts( $default, $atts );

		if ( empty( $args['id'] ) ) {
			return '';
		}

		$slider = FG_Slider_Post_Type::getInstance()->get_slider( $args['id'] );

		if ( empty( $slider['slides'] ) ) {
			return '';
		}

		$options = $slider['options'];
		$slides  = $slider['slides'];

		$formatted_options = $this->_format_slider_options( $options );

		ob_start();
		?>
        <div uk-<?php echo $options['type']; ?>="<?php echo $formatted_options; ?>">
            <ul class="uk-<?php echo $options['type']; ?>-items">
				<?php
				foreach ( $slides as $slide ):
					?>
                    <li>
						<?php
						if ( ! empty( $slide['link'] ) ):
						?>
                        <a href="<?php echo $slide['link']; ?>">
							<?php
							endif;
							echo wp_get_attachment_image( $slide['image_id'], 'full' );
							if ( ! empty( $slide['link'] ) ):
							?>
                        </a>
					<?php
					endif;
					?>
                    </li>
				<?php
				endforeach;
				?>
            </ul>
        </div>
		<?php
		$html = ob_get_clean();

		return $html;

	}

	/**
	 * @param $options array
	 *
	 * @return string
	 */
	private function _format_slider_options( $options = array() ) {
		$formatted_options = '';
		foreach ( $options as $option_name => $option ) {
			if ( 'type' == $option_name ) {
				continue;
			}
			$formatted_options .= $option_name . ': ' . $option . ';';
		}

		return $formatted_options;
	}
}