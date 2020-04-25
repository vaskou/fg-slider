<?php

defined( 'ABSPATH' ) or die();

class FG_Slider {

	private static $instance = null;

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		FG_Slider_Dependencies::getInstance()->init();
		FG_Slider_Post_Type::getInstance()->init();
		FG_Slider_Shortcodes::getInstance()->init();
	}

	public function enqueue_admin_styles() {

		$version = $this->_get_file_version( FG_SLIDER_PLUGIN_DIR_PATH . 'assets/css/admin_styles.css' );
		wp_enqueue_style( 'fg-slider-css', FG_SLIDER_PLUGIN_URL . '/assets/css/admin_styles.css', array(), $version, 'all' );
	}

	public function enqueue_admin_scripts() {

		$version = $this->_get_file_version( FG_SLIDER_PLUGIN_DIR_PATH . 'assets/js/admin_scripts.js' );
		wp_enqueue_script( 'fg-slider-css', FG_SLIDER_PLUGIN_URL . '/assets/js/admin_scripts.js', array( 'jquery' ), $version, true );
	}

	private function _get_file_version( $filename ) {

		$filetime = file_exists( $filename ) ? filemtime( $filename ) : '';

		return FG_SLIDER_VERSION . ( ! empty( $filetime ) ? '-' . $filetime : '' );
	}
}