<?php
namespace DEAFE;

use DEAFE\Widgets\deafe_pdf_native_embedder;
use DEAFE\Widgets\deafe_pdf_embedder;
use DEAFE\Widgets\deafe_doc_embedder;
use DEAFE\Widgets\deafe_excel_embedder;
use DEAFE\Widgets\deafe_pp_embedder;
use DEAFE\Widgets\deafe_word_viewer;
use DEAFE\Widgets\deafe_excel_viewer;
use DEAFE\Widgets\deafe_powerpoint_viewer;
use DEAFE\Widgets\deafe_google_docs;
use DEAFE\Widgets\deafe_google_sheets;
use DEAFE\Widgets\deafe_google_slides;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class DEAFE_BAddon {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		//controls
		// require_once( __DIR__ . '/public/controls/register-controls.php' );
		

		//widgets
		$active_widgets = (array) get_option( 'deafeGetWidgets', [] );

		if ( !in_array( 'deafe_pdf_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-pdf-embedder.php' );
		}
		if ( !in_array( 'deafe_doc_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-doc-embedder.php' );
		}
		if ( !in_array( 'deafe_pdf_native_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-pdf-native-embedder.php' );
		}
		if ( !in_array( 'deafe_pdf_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-pdf-embedder.php' );
		}
		if ( !in_array( 'deafe_excel_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-excel-embedder.php' );
		}
		if ( !in_array( 'deafe_powerpoint_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-powerpoint-embedder.php' );
		}
		if ( !in_array( 'deafe_word_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-word-viewer.php' );
		}
		if ( !in_array( 'deafe_excel_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-excel-viewer.php' );
		}
		if ( !in_array( 'deafe_powerpoint_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-powerpoint-viewer.php' );
		}
		if ( !in_array( 'deafe_google_docs', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-google-docs.php' );
		}
		if ( !in_array( 'deafe_google_sheets', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-google-sheets.php' );
		}
		if ( !in_array( 'deafe_google_slides', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-google-slides.php' );
		}
		if ( !in_array( 'deafe_sleek_pdf_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/deafe-sleek-pdf-viewer.php' );
		}
	}

	//editor scripts
	function editor_scripts() {
		wp_register_style("deafe-aa", plugins_url("/admin/assets/css/style.css",__FILE__), [], DEAFE_VERSION);
		wp_enqueue_style( 'deafe-aa' );
	}
	
	/**
	 * widget_styles
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_styles(){

		wp_register_style("deafe-main", plugins_url("/admin/assets/css/main.css",__FILE__), [], DEAFE_VERSION);
		wp_register_script("deafe-public", plugins_url("/public/assets/js/public.js",__FILE__), [], DEAFE_VERSION, true);
		wp_enqueue_style( 'deafe-main' );
	}
	
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		$active_widgets = get_option( 'deafeGetWidgets', [] );

		if(empty($active_widgets)) {
			$active_widgets = ['default_list'];
		}

		if ( !in_array( 'deafe_doc_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_doc_embedder() );
		}
		if ( !in_array( 'deafe_pdf_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_pdf_embedder() );
		}
		if ( !in_array( 'deafe_word_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_word_viewer() );
		}
		if ( !in_array( 'deafe_excel_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_excel_embedder() );
		}
		if ( !in_array( 'deafe_excel_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_excel_viewer() );
		}
		if ( !in_array( 'deafe_powerpoint_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_pp_embedder() );
		}
		if ( !in_array( 'deafe_powerpoint_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_powerpoint_viewer() );
		}
		if ( !in_array( 'deafe_pdf_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_pdf_embedder() );
		}
		if ( !in_array( 'deafe_google_docs', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_google_docs() );
		}
		if ( !in_array( 'deafe_google_sheets', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_google_sheets() );
		}
		if ( !in_array( 'deafe_google_slides', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_google_slides() );
		}
		if ( !in_array( 'deafe_pdf_native_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_pdf_native_embedder() );
		}
		if ( !in_array( 'deafe_sleek_pdf_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\deafe_sleek_pdf_viewer() );
		}
	}
	
	//category registered
	public function deafe_add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'document-embedder-addons-for-elementor',
			[
				'title' => __( 'B Addon', 'document-embedder-addons-for-elementor' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		// Enqueue widget styles
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] , 100 );
        add_action( 'admin_enqueue_scripts', [ $this, 'widget_styles' ] , 100 );
        
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		//category registered
		add_action( 'elementor/elements/categories_registered',  [ $this,'deafe_add_elementor_widget_categories' ]);
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_scripts' ] );

	}
	
}

// Instantiate Plugin Class
DEAFE_BAddon::instance();
