<?php

/*
 * Plugin Name: Document Embedder Addons for Elementor
 * Plugin URI:  https://wordpress.org/plugins
 * Description: You can easily Embed pdf, docs, xlsx, pptx files in wordress post, page, widget area and theme template file. 
 * Version:     1.1.7
 * Author:     	bPlugins LLC
 * Author URI: 	https://bplugins.com
 * License:     GPLv3
 * Text Domain: document-embedder-addons-for-elementor
 * Domain Path: /languages
 * 
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( function_exists( 'deafe_fs' ) ) {
    deafe_fs()->set_basename( false, __FILE__ );
} else {
    define( 'DEAFE_VERSION', ( isset( $_SERVER['HTTP_HOST'] ) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.1.6' ) );
    define( 'DEAFE_DIR_URL', plugin_dir_url( __FILE__ ) );
    define( 'DEAFE_DIR_PATH', plugin_dir_path( __FILE__ ) );
    define( 'DEAFE_HAS_PRO', plugin_basename( __FILE__ ) === "document-embedder-addons-for-elementor-pro/document-embedder-addons-for-elementor.php" );
    /**
     * DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE
     * `function_exists` CALL ABOVE TO PROPERLY WORK.
     */
    if ( !function_exists( 'deafe_fs' ) ) {
        function deafe_fs() {
            global $deafe_fs;
            if ( !isset( $deafe_fs ) ) {
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $deafe_fsConfig = array(
                    'id'                  => '20539',
                    'slug'                => 'document-embedder-addons-for-elementor',
                    'premium_slug'        => 'document-embedder-addons-for-elementor-pro',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_266740f98755c34bcd6cf52c052f8',
                    'is_premium'          => false,
                    'premium_suffix'      => 'Pro',
                    'has_premium_version' => true,
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'trial'               => array(
                        'days'               => 7,
                        'is_require_payment' => false,
                    ),
                    'menu'                => array(
                        'slug'       => 'document-embedder-addons-for-elementor',
                        'first-path' => 'admin.php?page=document-embedder-addons-for-elementor',
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
    // ... Your plugin's main file logic ...
    //
    function deafeIsPremium() {
        return ( DEAFE_HAS_PRO ? deafe_fs()->can_use_premium_code() : false );
    }

    require_once 'DEAFEAdminMenu.php';
    if ( DEAFE_HAS_PRO ) {
        require_once 'public/helper/LicenseActivation.php';
    }
    require_once 'enable-mime-type.php';
    require_once dirname( __FILE__ ) . '/public/helper/bae-common-settings-render.php';
    require_once 'freemius-extend/index.php';
    FreemiusExtend::instance( deafe_fs(), [
        'upgradeUrl' => admin_url( 'admin.php?page=document-embedder-addons-for-elementor#/pricing' ),
        'title'      => 'Unlock Pro features',
        'message'    => 'This control is available in Pro.',
        'confirm'    => 'Upgrade Now',
        'cancel'     => 'Maybe later',
    ] );
    final class BAddon_main_element_pro {
        /**
         * Plugin Version
         *
         * @since 1.2.0
         * @var string The plugin version.
         */
        const VERSION = '1.1.6';

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
            add_action( 'init', array($this, 'i18n') );
            // Init Plugin
            add_action( 'plugins_loaded', array($this, 'init') );
            register_activation_hook( __FILE__, [$this, 'activate'] );
            add_action( 'admin_enqueue_scripts', [$this, 'b_enqueue_admin_style_scripts'] );
            add_action( 'wp_ajax_allembed_install_plugin', [$this, 'b_allembed_install_plugin'] );
            add_action( 'wp_ajax_allembed_activate_plugin', [$this, 'b_allembed_activate_plugin'] );
        }

        /**
         * register activation hook
         */
        public function activate() {
            if ( !function_exists( 'deactivate_plugins' ) ) {
                require_once ABSPATH . '/wp-admin/includes/plugin.php';
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
            load_plugin_textdomain( 'document-embedder-addons-for-elementor', false, dirname( __FILE__ ) . "/languages" );
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
            if ( !did_action( 'elementor/loaded' ) ) {
                add_action( 'admin_notices', array($this, 'admin_notice_missing_main_plugin') );
                return;
            }
            // Check for required Elementor version
            if ( !version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
                add_action( 'admin_notices', array($this, 'admin_notice_minimum_elementor_version') );
                return;
            }
            // Check for required PHP version
            if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
                add_action( 'admin_notices', array($this, 'admin_notice_minimum_php_version') );
                return;
            }
            // Once we get here, We have passed all validation checks so we can safely include our plugin
            require_once 'plugin.php';
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
            if ( isset( $_GET['activate'] ) ) {
                unset($_GET['activate']);
            }
            $plugin_file = 'elementor/elementor.php';
            // Elementor installed?
            $installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin_file );
            // Elementor active?
            $active = is_plugin_active( $plugin_file );
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p>' . esc_html__( '"Document Embedder Addons For Elementor" requires "Elementor" to be installed and activated.', 'allembed' ) . '</p>';
            if ( !$installed ) {
                echo '<p><button class="button button-primary" id="allembed-install-elementor">' . esc_html__( 'Install Elementor', 'allembed' ) . '</button></p>';
            } elseif ( !$active ) {
                echo '<p><button class="button button-primary" id="allembed-activate-elementor">' . esc_html__( 'Activate Elementor', 'allembed' ) . '</button></p>';
            }
            echo '</div>';
        }

        /**
         * Enqueue admin style and scripts
         */
        public function b_enqueue_admin_style_scripts() {
            wp_enqueue_script(
                'allembed-plugin-install',
                plugin_dir_url( __FILE__ ) . 'admin/assets/js/plugin-install.js',
                ['jquery'],
                '1.0',
                true
            );
            wp_localize_script( 'allembed-plugin-install', 'allembedInstall', [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'allembed_install_plugin' ),
            ] );
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
            if ( isset( $_GET['activate'] ) ) {
                unset($_GET['activate']);
            }
            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'document-embedder-addons-for-elementor' ),
                '<strong>' . esc_html__( 'b addon', 'document-embedder-addons-for-elementor' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'document-embedder-addons-for-elementor' ) . '</strong>',
                self::MINIMUM_ELEMENTOR_VERSION
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
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
            if ( isset( $_GET['activate'] ) ) {
                unset($_GET['activate']);
            }
            $message = sprintf(
                /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'document-embedder-addons-for-elementor' ),
                '<strong>' . esc_html__( 'Document Embedder Addons', 'document-embedder-addons-for-elementor' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'document-embedder-addons-for-elementor' ) . '</strong>',
                self::MINIMUM_PHP_VERSION
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }

        public function b_allembed_install_plugin() {
            if ( !current_user_can( 'install_plugins' ) || !check_ajax_referer( 'allembed_install_plugin', 'nonce', false ) ) {
                wp_send_json_error( 'Unauthorized' );
            }
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            include_once ABSPATH . 'wp-admin/includes/file.php';
            include_once ABSPATH . 'wp-admin/includes/misc.php';
            $plugin_slug = 'elementor';
            $api = plugins_api( 'plugin_information', [
                'slug'   => $plugin_slug,
                'fields' => [
                    'sections' => false,
                ],
            ] );
            if ( is_wp_error( $api ) ) {
                wp_send_json_error( $api->get_error_message() );
            }
            $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
            $result = $upgrader->install( $api->download_link );
            if ( is_wp_error( $result ) ) {
                wp_send_json_error( $result->get_error_message() );
            }
            wp_send_json_success( 'Elementor installed successfully! Please activate it.' );
        }

        public function b_allembed_activate_plugin() {
            if ( !current_user_can( 'activate_plugins' ) || !check_ajax_referer( 'allembed_install_plugin', 'nonce', false ) ) {
                wp_send_json_error( 'Unauthorized' );
            }
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            $plugin = 'elementor/elementor.php';
            $result = activate_plugin( $plugin );
            if ( is_wp_error( $result ) ) {
                wp_send_json_error( $result->get_error_message() );
            }
            wp_send_json_success( 'Elementor activated successfully!' );
        }

    }

    // ... Your plugin's main file logic ...
    // Instantiate BAddon_main_element.
    new BAddon_main_element_pro();
}