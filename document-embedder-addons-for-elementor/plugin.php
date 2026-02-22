<?php
namespace BAddon;

use BAddon\Widgets\bae_pdf_native_embedder;
use BAddon\Widgets\bae_pdf_embedder;
use BAddon\Widgets\bae_doc_embedder;
use BAddon\Widgets\bae_excel_embedder;
use BAddon\Widgets\bae_pp_embedder;
use BAddon\Widgets\bae_word_viewer;
use BAddon\Widgets\bae_excel_viewer;
use BAddon\Widgets\bae_powerpoint_viewer;
use BAddon\Widgets\bae_google_docs;
use BAddon\Widgets\bae_google_sheets;
use BAddon\Widgets\bae_google_slides;
use BAddon\Widgets\My_Lock_Widget;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Bae_BAddon {

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

		if ( !in_array( 'bae_pdf_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-pdf-embedder.php' );
		}
		if ( !in_array( 'bae_doc_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-doc-embedder.php' );
		}
		if ( !in_array( 'bae_pdf_native_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-pdf-native-embedder.php' );
		}
		if ( !in_array( 'bae_pdf_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-pdf-embedder.php' );
		}
		if ( !in_array( 'bae_excel_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-excel-embedder.php' );
		}
		if ( !in_array( 'bae_powerpoint_embedder', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-powerpoint-embedder.php' );
		}
		if ( !in_array( 'bae_word_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-word-viewer.php' );
		}
		if ( !in_array( 'bae_excel_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-excel-viewer.php' );
		}
		if ( !in_array( 'bae_powerpoint_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-powerpoint-viewer.php' );
		}
		if ( !in_array( 'bae_google_docs', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-google-docs.php' );
		}
		if ( !in_array( 'bae_google_sheets', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-google-sheets.php' );
		}
		if ( !in_array( 'bae_google_slides', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-google-slides.php' );
		}
		if ( !in_array( 'bae_3d_flip_pdf_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-3d-flip-pdf-viewer.php' );
		}
		if ( !in_array( 'bae_sleek_pdf_viewer', $active_widgets, true ) ) {
			require_once( __DIR__ . '/public/widgets/bae-sleek-pdf-viewer.php' );
		}
		if( deafeIsPremium()) {
			if ( !in_array( 'bae_adobe_pdf_viewer', $active_widgets, true ) ) {
				require_once( __DIR__ . '/public/widgets/bae-adobe-pdf-viewer.php' );
			}
			if ( !in_array( 'bae_document_library', $active_widgets, true ) ) {
				require_once( __DIR__ . '/public/widgets/bae-document-library.php' );
			}
			if ( !in_array( 'bae_pdfjs_pdf_viewer', $active_widgets, true ) ) {
				require_once( __DIR__ . '/public/widgets/bae-pdf-js-pdf-viewer.php' );
			}
		} else {
			//load lock widget for non pro users
			require_once( __DIR__ . '/public/widgets/bae-placeholder-widget.php' );
		}
	}

	//editor scripts
	function editor_scripts() {
		wp_register_style("deafe-aa", plugins_url("/admin/assets/css/style.css",__FILE__));
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

		wp_register_style("bae-main", plugins_url("/admin/assets/css/main.css",__FILE__));
		wp_register_script("bae-public", plugins_url("/public/assets/js/public.js",__FILE__));
		wp_enqueue_style( 'bae-main' );
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

		if ( !in_array( 'bae_doc_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_doc_embedder() );
		}
		if ( !in_array( 'bae_pdf_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_pdf_embedder() );
		}
		if ( !in_array( 'bae_word_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_word_viewer() );
		}
		if ( !in_array( 'bae_excel_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_excel_embedder() );
		}
		if ( !in_array( 'bae_excel_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_excel_viewer() );
		}
		if ( !in_array( 'bae_pp_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_pp_embedder() );
		}
		if ( !in_array( 'bae_powerpoint_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_powerpoint_viewer() );
		}
		if ( !in_array( 'bae_pdf_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_pdf_embedder() );
		}
		if ( !in_array( 'bae_google_docs', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_google_docs() );
		}
		if ( !in_array( 'bae_google_sheets', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_google_sheets() );
		}
		if ( !in_array( 'bae_google_slides', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_google_slides() );
		}
		if ( !in_array( 'bae_pdf_native_embedder', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_pdf_native_embedder() );
		}
		if ( !in_array( 'bae_sleek_pdf_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_sleek_pdf_viewer() );
		}
		if ( !in_array( 'bae_3d_flip_pdf_viewer', $active_widgets, true ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_3d_flip_pdf_viewer() );
		}
		if( deafeIsPremium() ) {
			if ( !in_array( 'bae_adobe_pdf_viewer', $active_widgets, true ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_adobe_pdf_viewer() );
			}
			if ( !in_array( 'bae_document_library', $active_widgets, true ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_document_library_Widget() );
			}
			if ( !in_array( 'bae_pdfjs_pdf_viewer', $active_widgets, true ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\bae_pdf_js_pdf_viewer() );
			}
		} else {
			//register lock widget for non pro users
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\My_Lock_Widget('Adobe PDF Viewer', 'adobe-viewer-placeholder', 'adobe-pdf-icon') );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\My_Lock_Widget('Document Library', 'document-library-placeholder', 'document-library-icon') );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\My_Lock_Widget('Pdf.js PDF Viewer', 'pdf-js-viewer-placeholder', 'pdf-js-icon') );

		}
	}
	
	//category registered
	public function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'document-embedder-addons-for-elementor',
			[
				'title' => __( 'B Addon', 'document-embedder-addons-for-elementor' ),
				'icon' => 'fa fa-plug',
			]
		);
		$elements_manager->add_category(
			'my_pro_widgets',
			[
				'title' => __( 'B Addon Pro', 'document-embedder-addons-for-elementor' ),
				'icon'  => 'fa fa-lock',
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
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_dearflip_via_cdn' ] );
        
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		//category registered
		add_action( 'elementor/elements/categories_registered',  [ $this,'add_elementor_widget_categories' ]);
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_scripts' ] );
		add_action('elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_dearflip_via_cdn' ]);
		add_action('elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_dearflip_via_cdn' ]);
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'register_lock_script' ] );

	}

	public function register_lock_script() {
		wp_enqueue_script(
			'dae-locked-widget-admin-lock',
			plugin_dir_url( __FILE__ ) . 'admin/assets/js/admin-lock.js',
			['jquery'],
			'1.0.0',
			true
		);
		wp_localize_script( 'dae-locked-widget-admin-lock', 'MyLockedWidget', [
			'upgradeUrl' => admin_url( 'admin.php?page=document-embedder-addons-for-elementor#/pricing' ),
			'widgetName' => 'Document Embedder Addons Pro',
		] );
	}

	public function enqueue_dearflip_via_cdn() {
		wp_enqueue_script( 'dearflip-js', 'https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/dflip.min.js', array('elementor-frontend'), '1.7.3', true );
		wp_enqueue_script( 'main-script', plugin_dir_url( __FILE__ ) . 'admin/assets/js/main.js', array('jquery', 'dearflip-js', 'elementor-frontend'), '1.0', true );
		wp_enqueue_style( 'dearflip-css', 'https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/dflip.min.css', array(), '1.7.3' );
	}
}

// Instantiate Plugin Class
Bae_BAddon::instance();
