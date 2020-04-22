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
		FG_Slider_Dependencies::getInstance()->init();
		FG_Slider_Post_Type::getInstance()->init();
		FG_Slider_Shortcodes::getInstance()->init();
	}
}