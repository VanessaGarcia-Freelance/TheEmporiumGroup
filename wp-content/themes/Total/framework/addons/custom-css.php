<?php
/**
 * Creates the admin panel and custom CSS output
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Custom_CSS' ) ) {
	class WPEX_Custom_CSS {

		/**
		 * Start things up
		 *
		 * @since 1.6.0
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_page' ), 20 );
			add_action( 'admin_bar_menu', array( $this, 'adminbar_menu' ), 999 );
			add_action( 'admin_init', array( $this,'register_settings' ) );
			add_action( 'admin_enqueue_scripts',array( $this,'scripts' ) );
			add_action( 'admin_notices', array( $this, 'notices' ) );
			add_action( 'wpex_head_css' , array( $this, 'output_css' ), 9999 );
		}

		/**
		 * Add sub menu page for the custom CSS input
		 *
		 * @since 1.6.0
		 */
		public function add_page() {
			add_submenu_page(
				WPEX_THEME_PANEL_SLUG,
				__( 'Custom CSS', 'wpex' ),
				__( 'Custom CSS', 'wpex' ),
				'administrator',
				WPEX_THEME_PANEL_SLUG .'-custom-css',
				array( $this, 'create_admin_page' )
			);
		}

		/**
		 * Add custom CSS to the adminbar since it will be used frequently
		 *
		 * @since 1.6.0
		 */
		public static function adminbar_menu( $wp_admin_bar ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			$url  = admin_url( 'admin.php?page='. WPEX_THEME_PANEL_SLUG .'-custom-css' );
			$args = array(
				'id'    => 'wpex_custom_css',
				'title' => __( 'Custom CSS', 'wpex' ),
				'href'  => $url,
				'meta'  => array(
				'class' => 'wpex-custom-css',
				)
			);
			$wp_admin_bar->add_node( $args );
		}

		/**
		 * Load scripts
		 *
		 * @since 1.6.0
		 */
		public function scripts( $hook ) {
			if ( WPEX_ADMIN_PANEL_HOOK_PREFIX . '-custom-css' == $hook ) {
				wp_deregister_script( 'ace-editor' );
				wp_enqueue_script( 'wpex-ace-editor',  WPEX_FRAMEWORK_DIR_URI .'addons/assets/ace.js', array(), true );
			}
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * @since 1.6.0
		 */
		public function register_settings() {
			register_setting( 'wpex_custom_css', 'wpex_custom_css', array( $this, 'sanitize' ) );
		}

		/**
		 * Displays all messages registered to 'wpex-custom_css-notices'
		 *
		 * @since 1.6.0
		 */
		public static function notices() {
			settings_errors( 'wpex_custom_css_notices' );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.6.0
		 */
		public static function sanitize( $option ) {

			// Set option to theme mod
			set_theme_mod( 'custom_css', $option );

			// Return notice
			add_settings_error(
				'wpex_custom_css_notices',
				esc_attr( 'settings_updated' ),
				__( 'Settings saved.', 'wpex' ),
				'updated'
			);

			// Lets save the custom CSS into a standard option as well for backup
			return $option;
		}

		/**
		 * Settings page output
		 *
		 * @since 1.6.0
		 */
		public static function create_admin_page() { ?>

			<div class="wrap">

				<h2><?php _e( 'Custom CSS', 'wpex' ); ?></h2>

				<div>
					<form method="post" action="options.php">
						<?php settings_fields( 'wpex_custom_css' ); ?>
						<table class="form-table">
							<tr valign="top">
								<td style="padding:0;">
									<textarea rows="40" cols="50" id="wpex_custom_css" style="display:none;" name="wpex_custom_css"><?php echo wpex_get_mod( 'custom_css', false ); ?></textarea>
									<pre id="wpex_custom_css_editor" style="width:100%;height:800px;font-size:14px;    border: 1px solid #BABABA;"><?php echo wpex_get_mod( 'custom_css', false ); ?></pre>
								</td>
							</tr>
						</table>
						<?php submit_button(); ?>
					</form>
				</div>

			</div><!-- .wrap -->

			<script>
				( function( $ ) {
					"use strict";
					jQuery( document ).ready( function( $ ) {

						// Start ace editor
						var $css_editor = $( '#wpex_custom_css_editor' ),
							$css_editor_input = $( '#wpex_custom_css' ),
							$editor = ace.edit( 'wpex_custom_css_editor' );
						$editor.getSession().setUseWorker(false);
						$editor.getSession().setMode( "ace/mode/css" );
						$editor.setTheme( "ace/theme/chrome" );
						$editor.find('needle',{
							backwards: false,
							wrap: false,
							caseSensitive: false,
							wholeWord: false,
							regExp: false
						});
						$editor.findNext();
						$editor.findPrevious();

						// Add val to hidden field
						$editor.on('input', function() {
							$css_editor_input.val( $editor.getValue() );
						} );

					} );
				} ) ( jQuery );
			</script>

		<?php }

		/**
		 * Outputs the custom CSS to the wp_head
		 *
		 * @since 1.6.0
		 */
		public static function output_css( $output ) {
			if ( $css = wpex_get_mod( 'custom_css', false ) ) {
				$output .= '/*CUSTOM CSS*/'. $css;
			}
			return $output;
		}

	}
}
$wpex_custom_css = new WPEX_Custom_CSS();