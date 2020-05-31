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

		if ( empty( $slider['slides']['items'] ) || empty( $slider['options'] ) ) {
			return '';
		}

		$options = $slider['options'];
		$slides  = $slider['slides']['items'];

		$type = $options['type'];
		//TODO: add gap option
		$formatted_options = $this->_format_options( $options );

		$items_per_slide_classes = 'slider' == $type ? $this->_get_items_per_slide_classes( $options ) : '';

		$gap_classes = 'slider' == $type ? $this->_get_gap_classes( $options ) : '';

		ob_start();
		?>
        <div uk-<?php echo $type; ?>="<?php echo $formatted_options; ?>">
            <div class="uk-position-relative uk-visible-toggle uk-light">
                <ul class="uk-<?php echo $type; ?>-items <?php echo $items_per_slide_classes; ?> <?php echo $gap_classes; ?>">
					<?php
					$counter = 0;
					$count   = count( $slides );

					foreach ( $slides as $slide ):
						$attr['uk-img'] = "target: !li -*, !li +*";
						$counter ++;
						if ( 1 == $counter ):
							$attr['uk-img'] = "target: !ul > :last-child, !li +*";
                        elseif ( $count == $counter ):
							$attr['uk-img'] = "target: !li -*, !ul > :first-child";
						endif;
						?>
                        <li class="uk-flex uk-flex-center uk-flex-wrap uk-flex-bottom">
							<?php
							if ( 'slider' == $type && ! empty( $slide['title'] ) ):
								?>
                                <h5 class="fg-slider-title uk-width-1-1"><?php echo $slide['title']; ?></h5>
							<?php
							endif;

							?>
                            <div class="fg-slider-image uk-width-1-1">
								<?php
								if ( ! empty( $slide['link'] ) ):
								?>
                                <a href="<?php echo $slide['link']; ?>">
									<?php
									endif;

									echo wp_get_attachment_image( $slide['image_id'], 'full', false, $attr );

									if ( ! empty( $slide['link'] ) ):
									?>
                                </a>
							<?php
							endif;
							?>
                            </div>
                        </li>
					<?php
					endforeach;
					?>
                </ul>
				<?php
				if ( ! empty( $options['navigation_arrows'] ) && 'true' == $options['navigation_arrows'] ):
					?>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-<?php echo $type; ?>-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-<?php echo $type; ?>-item="next"></a>
				<?php
				endif;
				?>
            </div>
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
	private function _format_options( $options = array() ) {
		$formatted_options = '';
		//TODO: excluded_options convert to general variable
		$excluded_options = array(
			'type',
			'navigation_arrows',
			'items_per_slide',
			'gap'
		);

		foreach ( $options as $option_name => $option ) {

			if ( in_array( $option_name, $excluded_options ) ) {
				continue;
			}

			if ( empty( $option ) ) {
				continue;
			}

			if ( 'ratio' == $option_name ) {
				if ( empty( $option['width'] ) || empty( $option['height'] ) ) {
					continue;
				}
				$option = $option['width'] . ':' . $option['height'];
			}

			$formatted_options .= $option_name . ': ' . $option . ';';
		}

		return $formatted_options;
	}

	private function _get_items_per_slide_classes( $options ) {
		if ( empty( $options['items_per_slide'] ) ) {
			return '';
		}

		$classes = array();

		foreach ( $options['items_per_slide'] as $breakpoint => $value ) {
			if ( ! empty( $value ) ) {
				$classes[] = 'uk-child-width-1-' . $value . '@' . $breakpoint;
			}
		}

		return implode( ' ', $classes );
	}

	private function _get_gap_classes( $options ) {
		if ( empty( $options['gap'] ) ) {
			return '';
		}

		return 'uk-grid uk-grid-' . $options['gap'];
	}
}