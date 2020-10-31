<?php

defined( 'ABSPATH' ) or die();

class FG_Slider_Dependencies {

	private static $instance = null;

	private function __construct() {
		if ( did_action( 'plugins_loaded' ) ) {
			self::on_plugins_loaded();
		} else {
			add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
		}
	}

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function on_plugins_loaded() {
		if ( ! $this->has_satisfied_dependencies() ) {
			add_action( 'admin_init', array( $this, 'deactivate_self' ) );
			add_action( 'admin_notices', array( $this, 'render_dependencies_notice' ) );

			return;
		}
	}

	protected function has_satisfied_dependencies() {
		$dependency_errors = $this->get_dependency_errors();

		return 0 === count( $dependency_errors );
	}

	protected function get_dependency_errors() {
		$errors = array();

		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		$cmb2_met       = in_array( 'cmb2/init.php', $active_plugins );

		if ( ! $cmb2_met ) {
			$errors[] = sprintf(
				__( 'The FremeditiGuitars - Slider plugin requires <a href="%s">CMB2</a> to be installed and active.', 'fg-slider' ),
				'https://wordpress.org/plugins/cmb2/'
			);
		}

		return $errors;
	}

	public function deactivate_self() {
		deactivate_plugins( plugin_basename( FG_SLIDER_PLUGIN_BASENAME ) );
		unset( $_GET['activate'] );
	}

	public function render_dependencies_notice() {
		$message = $this->get_dependency_errors();
		printf( '<div class="error"><p>%s</p></div>', implode( ' ', $message ) );
	}

}