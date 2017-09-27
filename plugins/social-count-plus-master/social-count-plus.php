<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Social_Count_Plus' ) ) :

/**
 * Social_Count_Plus main class.
 *
 * @package  Social_Count_Plus
 * @category Core
 * @author   Claudio Sanches
 */
class Social_Count_Plus {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '3.3.6';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		// Include classes.
		$this->includes();
		$this->include_counters();

		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			$this->admin_includes();
		}


		// Shortcode.
		add_shortcode( 'scp', array( 'Social_Count_Plus_Shortcodes', 'counter' ) );


	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Include admin actions.
	 */
	protected function admin_includes() {
		include dirname( __FILE__ ) . '/includes/admin/class-social-count-plus-admin.php';
	}

	/**
	 * Include plugin functions.
	 */
	protected function includes() {
		include_once dirname( __FILE__ ) . '/includes/class-social-count-plus-generator.php';
		include_once dirname( __FILE__ ) . '/includes/abstracts/abstract-social-count-plus-counter.php';
		include_once dirname( __FILE__ ) . '/includes/class-social-count-plus-view.php';
		include_once dirname( __FILE__ ) . '/includes/class-social-count-plus-widget.php';
		include_once dirname( __FILE__ ) . '/includes/class-social-count-plus-shortcodes.php';
		include_once dirname( __FILE__ ) . '/includes/social-count-plus-functions.php';
		include_once dirname( __FILE__ ) . '/includes/social-count-plus-deprecated-functions.php';
	}

	/**
	 * Include counters.
	 */
	protected function include_counters() {
		foreach ( glob( realpath( dirname( __FILE__ ) ) . '/includes/counters/*.php' ) as $filename ) {
			include_once $filename;
		}
	}


}

/**
 * Init the plugin.
 */
add_action( 'plugins_loaded', array( 'Social_Count_Plus', 'get_instance' ) );

endif;
