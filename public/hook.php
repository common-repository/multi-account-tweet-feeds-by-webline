<?php

class maTweetFeedsHooks {

	public function __construct() {
		register_activation_hook( MATF_PATH . MATF_PLUGIN_FILE, array( $this, 'MATF_default_option_value' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'MATF_scripts') );
		register_uninstall_hook( MATF_PATH . MATF_PLUGIN_FILE, array( __CLASS__, 'MATF_delete_option_value' ) );
	}

	/**
	 *  This function is used to enqueue plugin stylesheet css.
	 *
	 *	@since   			1.0.3
	 *
	 *  @return             void
	 *  @var                No arguments passed
	 *  @author             Weblineindia
	 */
	public function MATF_scripts() {
		wp_enqueue_style( 'matweetfeeds-style', MATF_URL . '/public/assets/css/matweetfeeds-style.css' );
	}
	

	/**
	 *  This function is called when the plugin is activated.
	 *
	 *	@since   			1.0.1
	 *
	 *  @return             void
	 *  @var                No arguments passed
	 *  @author             Weblineindia
	 */
	public function MATF_default_option_value() {
		$default_values = array( 'version' => MATF_VERSION );
		add_option( 'MATF_settings', $default_values );
	}

	/**
	 *  This function is called when the plugin is uninstalled.
	 *
	 *	@since    			1.0.1
	 *
	 *  @return             void
	 *  @var                No arguments passed
	 *  @author             Weblineindia
	 */
	public static function MATF_delete_option_value() {
		delete_option( 'MATF_settings' );
	}
}

new maTweetFeedsHooks();
?>
