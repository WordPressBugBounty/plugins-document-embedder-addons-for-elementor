<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

if(!class_exists("DEAFEAdminMenu")) {
	class DEAFEAdminMenu {
		public function __construct() {
			add_action( 'admin_menu', [ $this, 'deafeAdminMenu' ] );
			add_action( 'admin_enqueue_scripts', [$this, 'deafeAdminEnqueueScripts'] );
			add_action('wp_ajax_deafeGetBlocks', [ $this, 'deafeGetBlocks' ]);
			add_action('admin_head', [ $this, 'deafeIconImgSizeStyle' ]);
		}

		public function deafeIconImgSizeStyle() {
			$screen = get_current_screen();
				echo '
				<style>
					#toplevel_page_document-embedder-addons-for-elementor .wp-menu-image img {
						width: 20px !important;
						height: 20px !important;
						object-fit: contain;
					}
					.fs-submenu-item.document-embedder-addons-for-elementor.pricing.upgrade-mode {
						background: #146ef5;
						border-radius: 3px;
						color: #fff;
						display: inline-block;
						padding: 9px 20px 9px 18px;
					}
				</style>';
		}
	
		public function deafeAdminMenu() {

			$menu_icon = plugins_url( 'admin/assets/img/menu-icon.png', __FILE__ );

			add_menu_page(
				__( 'Document Embedder by bPlugins', 'document-embedder-addons-for-elementor' ),
				__( 'Docs Embedder', 'document-embedder-addons-for-elementor' ),
				'manage_options',
				'document-embedder-addons-for-elementor',
				'',
				$menu_icon,
				66
			);
	
			add_submenu_page(
				'document-embedder-addons-for-elementor',
				__('Dashboard - Document Embedder by bPlugins', 'document-embedder-addons-for-elementor'),
				__('Dashboard', 'document-embedder-addons-for-elementor'),
				'manage_options',
				'document-embedder-addons-for-elementor',
				[$this, 'deafeRenderDashboardPage'],
				0
			);
		}

		public function deafeGetBlocks(){
			// $nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) ?? null;
			$nonce = isset( $_POST['_wpnonce'] )
				? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) )
				: null;

			if( !wp_verify_nonce( $nonce, 'deafe_admin_nonce' )){
				wp_send_json_error( 'Invalid Request' );
			}

			// Add this capability check
			if( !current_user_can( 'manage_options' ) ) {
				wp_send_json_error( 'Unauthorized' );
			}

			// $data = json_decode( stripslashes( $_POST['data'] ), true );
			$data = isset( $_POST['data'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['data'] ) ) : array();
			$db_data = get_option( 'deafeGetWidgets', [] );

			if( !isset( $data ) && $db_data ){
				wp_send_json_success( $db_data );
			}

			update_option( 'deafeGetWidgets', $data );
			wp_send_json_success( $data );

		}
	
		public function deafeRenderDashboardPage(){ ?>
			<div
				id='deafeDashboard'
				data-info='<?php echo esc_attr( wp_json_encode( [
					'version' => DEAFE_VERSION,
					'nonce' => wp_create_nonce( 'deafe_admin_nonce' ),
					false,
					false,
					'action' => 'deafeGetBlocks',
					'pricingUrl' => admin_url( 'admin.php?page=document-embedder-addons-for-elementor#/pricing' ),
				] ) ); ?>'
			></div>
		<?php }
	
		function deafeAdminEnqueueScripts( $hook ) {
			if( strpos( $hook, 'document-embedder-addons-for-elementor' ) ){
				wp_enqueue_style( 'deafe-admin-dashboard', DEAFE_DIR_URL . 'build/admin/dashboard.css', [], DEAFE_VERSION );
				wp_enqueue_script( 'deafe-admin-dashboard', DEAFE_DIR_URL . 'build/admin/dashboard.js', [ 'react', 'react-dom','wp-util' ], DEAFE_VERSION, true );
				wp_set_script_translations( 'deafe-admin-dashboard', 'document-embedder-addons-for-elementor', DEAFE_DIR_PATH . 'languages' );
			}
		}
	}
	new DEAFEAdminMenu();
}
