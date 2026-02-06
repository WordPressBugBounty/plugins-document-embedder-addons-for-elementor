<?php
namespace BAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use BAddon\BAE\BAE_Common_Settings_Render;

if ( !defined( 'ABSPATH' ) ) 
	exit; 

class bae_3d_flip_pdf_viewer extends Widget_Base {

	use BAE_Common_Settings_Render;
	public function get_name() {
		return 'bae-3d-flip-pdf-viewer';
	}

	public function get_title() {
		return esc_html__( '3D Flip PDF Viewer', 'document-embedder-addons-for-elementor' );
	}

	public function get_icon() {
		return 'bl_icon fas fa-file-pdf eicon-post-content';
	}

	public function get_categories() {
		return [ 'document-embedder-addons-for-elementor' ];
	}

	public function get_script_depends() {
		return ['elementor-frontend', 'dearflip-js', 'main-script'];
	}

	protected function register_controls() {

		$this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'PDF Content', 'document-embedder-addons-for-elementor' )
            ]
        );
		$this->add_control(
			'label_name',
			[
				'label' 		=> esc_html__( 'Source options', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::HEADING,
				'separator' 	=> 'before',
			]
		);
		$this->add_control(
			'choose_source',
			[
				'label' 		=> __( 'Source Type', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Link', 'document-embedder-addons-for-elementor' ),
				'label_off' 	=> __( 'Upload', 'document-embedder-addons-for-elementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> '',
			]
		);
		$this->add_control(
            'pdf_file',
            [
				'label' 		=> esc_html__( 'Upload PDF File', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::MEDIA,
				'media_type' 	=> 'application/pdf',
				'description' 	=> esc_html__( 'Upload a file on live server', 'document-embedder-addons-for-elementor' ),
				'dynamic' 		=> [
					'active' => true,
				],
				'condition'		=> [
					'choose_source' => '',
				]
			]
        );
		$this->add_control(
			'pdf_url',
			[
				'label' 		=> esc_html__( 'PDF URL', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> esc_html__( 'Paste a pdf file link here.', 'document-embedder-addons-for-elementor' ),
				'description' 	=> esc_html__( 'Provide a link to a file from sharable server', 'document-embedder-addons-for-elementor' ),
				'show_external' => true,
				'default' => [
					'is_external' 	=> true,
					'nofollow' 		=> true,
				],
				'dynamic' => [
					'active' => true,
				],
				'condition'		=> [
					'choose_source' => 'yes',
				]
			],
		);
		$this->end_controls_section();

		$this->start_controls_section(
            'section_content_setting',
            [
                'label' => esc_html__( 'PDF Viewer Setting', 'document-embedder-addons-for-elementor' ),
            ]
        );
		$this->add_control(
			'height',
			[
				'label' 		=> esc_html__( 'Height', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ '%', 'px' ],
				'range' => 
				[
					'px' => [
						'min' 	=> 0,
						'max' 	=> 1500,
						'step' 	=> 5,
					],
					'%' => [
						'min' 	=> 0,
						'max' 	=> 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 830,
				],
				'selectors' => [
					'{{WRAPPER}} .my_3d_flip_viewer iframe' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
        $this->add_control(
			'width',
			[
				'label' 		=> esc_html__( 'Width', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' 	=> [ '%', 'px' ],
				'range' 		=> 
				[
					'px' => [
						'min' 	=> 0,
						'max' 	=> 1500,
						'step' 	=> 5,
					],
					'%' => [
						'min' 	=> 0,
						'max' 	=> 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 640,
				],
				'selectors' => [
					'{{WRAPPER}} .my_3d_flip_viewer iframe' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' 	=> esc_html__( 'Alignment', 'document-embedder-addons-for-elementor' ),
				'type' 		=> Controls_Manager::CHOOSE,
				'options' 	=> 
				[
					'flex-start' => [
						'title' => esc_html__( 'Left', 'document-embedder-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'document-embedder-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'document-embedder-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default' 	=> 'center',
				'selectors' => [
					'{{WRAPPER}} .my_native' => 'display:flex;justify-content:{{VALUE}}',
				],
				'toggle' 	=> true,
			]
		);

		$this->add_control(
			'file_name',
			[
				'label' 			=> __( 'Show File Name On top', 'document-embedder-addons-for-elementor' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> __( 'On', 'document-embedder-addons-for-elementor' ),
				'label_off' 		=> __( 'Off', 'document-embedder-addons-for-elementor' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'yes',
				'description' 		=> __( 'On, if you want to show the file name in the top of the viewer.', 'document-embedder-addons-for-elementor' ),
				'style_transfer'	=> true,
			]
		);

		$this->add_control(
            'file_name_text', [
                'label'          => esc_html__( 'File Name', 'document-embedder-addons-for-elementor' ),
                'type'           => Controls_Manager::TEXT,
                'label_block'    => true,
                'placeholder'    => esc_html__( 'Write Here File Name', 'document-embedder-addons-for-elementor' ),
                'default'        => esc_html__( 'PDF Test File', 'document-embedder-addons-for-elementor' ),
                'condition' => [
                    'file_name' => 'yes'
                ]
            ]
        );

		$this->add_control(
			'download_button',
			[
				'label' 			=> __( 'Show Download button on top', 'document-embedder-addons-for-elementor' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> __( 'On', 'document-embedder-addons-for-elementor' ),
				'label_off' 		=> __( 'Off', 'document-embedder-addons-for-elementor' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'no',
				'separator' 		=> 'before',
				'description' 		=> __( 'On, if you want to show "Download" Button in the top of the viewer.', 'document-embedder-addons-for-elementor' ),
				'style_transfer' 	=> true
			]
		);

		$this->add_control(
            'download_btn_text', [
                'label'          => esc_html__( 'Button Text', 'document-embedder-addons-for-elementor' ),
                'type'           => Controls_Manager::TEXT,
                'label_block'    => true,
                'placeholder'    => esc_html__( 'Write Here Download Button Name', 'document-embedder-addons-for-elementor' ),
                'default'        => esc_html__( 'Download PDF', 'document-embedder-addons-for-elementor' ),
                'condition' => [
                    'download_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'canvas_bg_color',
            [
                'label' => esc_html__( 'Canvas Background Color', 'document-embedder-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .my_3d_flip_viewer div#documentViewer' => 'background: {{VALUE}} !important;',
                ],
            ]
        );


		$this->end_controls_section();
    
		$this->render_common_style_settings();
	}

	public function render_common_style_settings() {
		$this->bae_box_common_styles_render( $id = 'pdf_viewer', $label = 'PDF Viewer', $condition = [], $selector = '#flipbook-container' );
		$this->bae_text_common_styles_render( $id = 'file_name', $label = 'File Name', $condition = [ 'file_name' => 'yes' ], $selector = '.flip_viewer_style h3', $default = 'PDF Test File' );
		$this->bae_button_common_styles_render( $id = 'download_btn', $label = 'Download Button', $condition = [ 'download_button' => 'yes' ], $selector = '.flip_viewer_style .bbutton-bottom', $default = 'Download PDF' );
	}

	

	protected function render() {
		$settings = $this->get_settings_for_display();
		$pdf_file = $settings['pdf_file'];
		$pdf_url = $settings['pdf_url'];
		$file_name_text = $settings[ 'file_name_text' ];
		$download_btn_text = $settings[ 'download_btn_text' ];
		$final_pdf_link = '';		
		$source_type = $settings['choose_source'];		
		if($source_type){
			$final_pdf_link = isset($pdf_url['url']) ? $pdf_url['url'] : '';
		}else{
			$final_pdf_link = isset($pdf_file['url']) ? $pdf_file['url'] : '';
		}
		?>
		<div class ="flip_viewer_style">
			<?php 
			if($file_name_text !=''):?>
		        <h3><?php echo esc_html($file_name_text);?></h3>
		     <?php endif;?>
     		<div class="download">
				<?php if($download_btn_text !=''):?>
		        	<a download href="<?php echo esc_url($final_pdf_link); ?>" target="_blank"><button class="bbutton-bottom"><?php echo esc_html($download_btn_text);?></button></a>
	     		<?php endif;?>
			</div>
		</div>
		<?php if($final_pdf_link == ''): ?>
			<center><h3><?php esc_html_e('Paste the pdf file link from setting widget.','document-embedder-addons-for-elementor') ?></h3></center>
		<?php else: ?>
		 <!-- Flipbook container -->
    <div id="flipbook-container" class="_df_book" source="<?php echo esc_url($final_pdf_link); ?>"></div>
    <script>
		(function ($) {
	function initDearFlip() {
		if (typeof $.fn.dflip !== 'function') {
			console.error('DearFlip is not loaded. Check CDN or script inclusion.');
			return;
		}

		const $container = $("#flipbook-container");
		if ($container.length && !$container.hasClass('dflip-initialized')) {
			$container.addClass('dflip-initialized').dflip({
				source: "<?php echo esc_url($final_pdf_link); ?>",
				height: 600,
				width: "100%",
				pageMode: "3d",
				webgl: true,
				controls: {
					toolbar: false,
					zoom: true,
					layout: "double",
					autoZoom: true
				}
			});
		}
	}

	// Frontend load
	$(document).ready(function () {
		initDearFlip();
	});

	// Elementor editor load
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/bae-3d-flip-pdf-viewer', function () {
			initDearFlip();
		});
	});
})(jQuery);
	</script>
	<?php endif; 
	}
}