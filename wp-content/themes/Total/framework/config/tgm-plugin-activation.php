<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Total WordPress Theme
 * @subpackage Configs
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Recommend_Plugins' ) ) {

	class WPEX_Recommend_Plugins {

		/**
		 * Start things up
		 *
		 * @since 1.6.0
		 */
		public function __construct() {
			add_action( 'deactivated_plugin', array( $this, 'delete_meta' ) );
			add_action( 'tgmpa_register', array( $this, 'config' ) );
		}

		/**
		 * Delete meta on plugin de-activation
		 *
		 * @since 1.6.0
		 */
		public function delete_meta() {
			delete_metadata( 'user', null, 'tgmpa_dismissed_notice_wpex_theme', null, true );
		}

		/**
		 * Configures the TGMA script
		 *
		 * @since 1.6.0
		 */
		public function config() {

			// Return if function doesn't exist
			if ( ! function_exists( 'tgmpa' ) ) {
				return;
			}
				
			// Define plugins dir
			$plugins_dir = get_template_directory_uri() .'/framework/plugins/';

			// Define array of recommended plugins
			$plugins = apply_filters( 'wpex_recommended_plugins', array(
				/*'wpex-total-importer' => array(
					'name' => 'Total Demo Importer',
					'slug' => 'wpex-total-importer', 
					'source' => $plugins_dir .'wpex-total-importer.zip',
					'required' => false,
					'force_activation' => false,
				),*/
				'js_composer'  => array(
					'name' => 'WPBakery Visual Composer',
					'slug' => 'js_composer',
					'version' => WPEX_VC_SUPPORTED_VERSION,
					'source' => $plugins_dir .'js_composer.zip',
					'required' => false,
					'force_activation' => false,
				),
				'templatera' => array(
					'name' => 'Templatera',
					'slug' => 'templatera', 
					'source' => $plugins_dir .'templatera.zip',
					'version' => '1.1.4',
					'required' => false,
					'force_activation' => false,
				),
				'revslider'  => array(
					'name' => 'Revolution Slider',
					'slug' => 'revslider',
					'version' => '5.0.8',
					'source' => $plugins_dir .'revslider.zip',
					'required' => false,
					'force_activation' => false,
				),
				'contact-form-7' => array(
					'name' => 'Contact Form 7',
					'slug' => 'contact-form-7', 
					'required' => false,
					'force_activation' => false,
				),
				'woocommerce'  => array(
					'name' => 'WooCommerce',
					'slug' => 'woocommerce', 
					'required' => false,
					'force_activation' => false,
				), 
			) );

			// Prevent dismiss
			$dismissable = true;
			if ( defined( 'WPB_VC_VERSION' )
				&& apply_filters( 'wpex_display_outdated_vc_notice', true )
				&& version_compare( WPEX_VC_SUPPORTED_VERSION, WPB_VC_VERSION, '>' )
			) {
				$dismissable = false;
			}

			// Register notice
			tgmpa( $plugins, array(
				'id'           => 'wpex_theme',
				'domain'       => 'wpex',
				'menu'         => 'install-required-plugins',
				'has_notices'  => true,
				'is_automatic' => true,
				'dismissable'  => $dismissable,
			) );

		}

	}

}
new WPEX_Recommend_Plugins();