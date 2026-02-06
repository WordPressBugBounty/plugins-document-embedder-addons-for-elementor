<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

if(!class_exists("BPTBAdminMenu")) {
	class BPTBAdminMenu {
		public function __construct() {
			add_action( 'admin_menu', [ $this, 'bptbAdminMenu' ] );
			add_action( 'admin_enqueue_scripts', [$this, 'bptbAdminEnqueueScripts'] );
			add_action('wp_ajax_bptbGetBlocks', [ $this, 'bptbGetBlocks' ]);
			add_action('admin_head', [ $this, 'bpdeIconImgSizeStyle' ]);
		}

		public function bpdeIconImgSizeStyle() {
			$screen = get_current_screen();
				echo '
				<style>
					#toplevel_page_document-embedder-addons-for-elementor .wp-menu-image img {
						width: 20px !important;
						height: 20px !important;
						object-fit: contain;
					}
				</style>';
		}
	
		public function bptbAdminMenu() {

			$menu_icon = plugins_url( 'admin/assets/img/menu-icon.png', __FILE__ );

			add_menu_page(
				__( 'Document Embedder by bPlugins', 'document-embedder-addons-for-elementor' ),
				__( 'Docs Embedder', 'document-embedder-addons-for-elementor' ),
				'manage_options',
				'document-embedder-addons-for-elementor',
				'',
				$menu_icon,
				20
			);
	
			add_submenu_page(
				'document-embedder-addons-for-elementor',
				__('Dashboard - Document Embedder by bPlugins', 'document-embedder-addons-for-elementor'),
				__('Dashboard', 'document-embedder-addons-for-elementor'),
				'manage_options',
				'document-embedder-addons-for-elementor',
				[$this, 'bptbRenderDashboardPage'],
				0
			);
		}

		public function bptbGetBlocks(){
			$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) ?? null;

			if( !wp_verify_nonce( $nonce, 'bptb_admin_nonce' )){
				wp_send_json_error( 'Invalid Request' );
			}

			$data = json_decode( stripslashes( $_POST['data'] ), true );
			$db_data = get_option( 'bptbGetBlocks', [] );

			if( !isset( $data ) && $db_data ){
				wp_send_json_success( $db_data );
			}

			update_option( 'bptbGetBlocks', $data );
			wp_send_json_success( $data );

		}
	
		public function bptbRenderDashboardPage(){ ?>
			<div
				id='bptbDashboard'
				data-info='<?php echo esc_attr( wp_json_encode( [
					'version' => BPTB_VERSION,
					'nonce' => wp_create_nonce( 'bptb_admin_nonce' ),
					'isPremium' => bptbIsPremium(),
					'pricingUrl' => admin_url( 'admin.php?page=document-embedder-addons-for-elementor#/pricing' ),
				] ) ); ?>'
			></div>
		<?php }
	
		function bptbAdminEnqueueScripts( $hook ) {
			if( strpos( $hook, 'document-embedder-addons-for-elementor' ) ){
				wp_enqueue_style( 'bptb-admin-dashboard', BPTB_DIR_URL . 'build/admin/dashboard.css', [], BPTB_VERSION );
				wp_enqueue_script( 'bptb-admin-dashboard', BPTB_DIR_URL . 'build/admin/dashboard.js', [ 'react', 'react-dom','wp-util' ], BPTB_VERSION, true );
				wp_set_script_translations( 'bptb-admin-dashboard', 'document-embedder-addons-for-elementor', BPTB_DIR_PATH . 'languages' );
			}
		}
	}
	new BPTBAdminMenu();
}
