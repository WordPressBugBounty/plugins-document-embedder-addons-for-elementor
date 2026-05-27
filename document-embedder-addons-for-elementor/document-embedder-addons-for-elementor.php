<?php

/*
 * Plugin Name: Document Embedder Addons for Elementor – Embed Documents in Elementor Websites
 * Plugin URI:  https://wordpress.org/plugins
 * Description: You can easily Embed pdf, docs, xlsx, pptx files in wordress post, page, widget area and theme template file. 
 * Version:     1.1.9
 * Author:     	bPlugins LLC
 * Author URI: 	https://bplugins.com
 * License:     GPLv3
 * Text Domain: document-embedder-addons-for-elementor
 * Domain Path: /languages
 * Requires Plugins: elementor
 */


if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'deafe_fs' ) ) {
	deafe_fs()->set_basename( true, __FILE__ );
} else {
	define('DEAFE_VERSION', isset($_SERVER['HTTP_HOST']) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.1.9');
	define('DEAFE_DIR_URL', plugin_dir_url(__FILE__));
	define('DEAFE_DIR_PATH', plugin_dir_path(__FILE__));
	
	/**
	 * DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE
	 * `function_exists` CALL ABOVE TO PROPERLY WORK.
	 */
	if ( ! function_exists( 'deafe_fs' ) ) {
		function deafe_fs() {
			global $deafe_fs;

			if ( ! isset( $deafe_fs ) ) {
				require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';
				$deafe_fsConfig = array(
					'id'                  => '20539',
                    'slug'                => 'document-embedder-addons-for-elementor',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_266740f98755c34bcd6cf52c052f8',
                    'is_premium'          => false,
                    'has_premium_version' => true,
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'menu'                => array(
                        'slug'       => 'document-embedder-addons-for-elementor',
                        'first-path' => 'admin.php?page=document-embedder-addons-for-elementor#/welcome',
                    ),
				);

				$deafe_fs = fs_dynamic_init( $deafe_fsConfig );
			}

			return $deafe_fs;
		}

		// Init Freemius.
		deafe_fs();
		// Signal that SDK was initiated.
		do_action( 'deafe_fs_loaded' );
	}

	require_once 'DEAFEAdminMenu.php';
	require_once 'enable-mime-type.php';
	require_once 'public/helper/deafe-common-settings-render.php';

	final class DEAFE_main_element_pro {
	
		/**
		 * Plugin Version
		 *
		 * @since 1.2.0
		 * @var string The plugin version.
		 */
		const VERSION = '1.1.9';
	
		/**
		 * Minimum Elementor Version
		 *
		 * @since 1.2.0
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	
		/**
		 * Minimum PHP Version
		 *
		 * @since 1.2.0
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.0';
	
		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {
	
			// Load translation
			add_action( 'init', array( $this, 'i18n' ) );
	
			// Init Plugin
			add_action( 'plugins_loaded', array( $this, 'init' ) );
	
			register_activation_hook( __FILE__, [$this, 'activate']);
			add_action( 'admin_enqueue_scripts', [ $this, 'deafe_enqueue_admin_style_scripts' ] );
		}
	
		/**
		 * register activation hook
		 */
		public function activate(){
			if ( !function_exists( 'deactivate_plugins' ) ) { 
			}
			// deactivate_plugins('document-embedder-addons-for-elementor/document-embedder-addons-for-elementor.php');
		} 
	
		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 * Fired by `init` action hook.
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function i18n() {
			//load_plugin_textdomain( 'document-embedder-addons-for-elementor', false, dirname( __FILE__ ) . "/languages" );
		}
	
		/**
		 * Initialize the plugin
		 *
		 * Validates that Elementor is already loaded.
		 * Checks for basic plugin requirements, if one check fail don't continue,
		 * if all check have passed include the plugin class.
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.2.0
		 * @access public
		 */
		public function init() {
	
			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}
	
			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
				return;
			}
	
			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
				return;
			}
	
			// Once we get here, We have passed all validation checks so we can safely include our plugin
			require_once( 'plugin.php' );
		}
	
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {
			// if ( isset( $_GET['activate'] ) ) {
			// 	unset( $_GET['activate'] );
			// }

			if (
				isset( $_GET['activate'], $_GET['_wpnonce'] ) &&
				wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'activate-plugin_action' )
			) {
				unset( $_GET['activate'] );
			}

			$plugin_file = 'elementor/elementor.php';

			// Elementor installed?
			$installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin_file );

			// Elementor active?
			$active = is_plugin_active( $plugin_file );

			echo '<div class="notice notice-warning is-dismissible">';
			echo '<p>' . esc_html__( '"Document Embedder Addons For Elementor" requires "Elementor" to be installed and activated.', 'document-embedder-addons-for-elementor' ) . '</p>';

			if ( ! $installed ) {
				echo '<p><button class="button button-primary" id="deafe-install-elementor">' . esc_html__( 'Install Elementor', 'document-embedder-addons-for-elementor' ) . '</button></p>';
			} elseif ( ! $active ) {
				echo '<p><button class="button button-primary" id="deafe-activate-elementor">' . esc_html__( 'Activate Elementor', 'document-embedder-addons-for-elementor' ) . '</button></p>';
			}
			echo '</div>';
		}
		/**
		 * Enqueue admin style and scripts
		 */
		public function deafe_enqueue_admin_style_scripts() {
			wp_enqueue_script(
				'deafe-plugin-install',
				plugin_dir_url( __FILE__ ) . 'admin/assets/js/plugin-install.js',
				[ 'jquery' ],
				'1.1',
				true
			);
			wp_localize_script( 'deafe-plugin-install', 'deafeInstall', [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'deafe_install_plugin' ),
			]);
		}
	
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required Elementor version.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_minimum_elementor_version() {
			// if ( isset( $_GET['activate'] ) ) {
			// 	unset( $_GET['activate'] );
			// }
			if (
				isset( $_GET['activate'], $_GET['_wpnonce'] ) &&
				wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'activate-plugin_action' )
			) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'document-embedder-addons-for-elementor' ),
				'<strong>' . esc_html__( 'b addon', 'document-embedder-addons-for-elementor' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'document-embedder-addons-for-elementor' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);
	
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', esc_html($message));
		}
	
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {
			// if ( isset( $_GET['activate'] ) ) {
			// 	unset( $_GET['activate'] );
			// }

			if (
				isset( $_GET['activate'], $_GET['_wpnonce'] ) &&
				wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'activate-plugin_action' )
			) {
				unset( $_GET['activate'] );
			}
	
			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'document-embedder-addons-for-elementor' ),
				'<strong>' . esc_html__( 'Document Embedder Addons', 'document-embedder-addons-for-elementor' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'document-embedder-addons-for-elementor' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);
	
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', esc_html($message));
		}
	}
	
	// ... Your plugin's main file logic ...
	// Instantiate BAddon_main_element.
	new DEAFE_main_element_pro();
	
}