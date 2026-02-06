<?php
namespace BAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use BAddon\BAE\BAE_Common_Settings_Render;

if ( !defined( 'ABSPATH' ) ) 
	exit; 

class bae_pdf_embedder extends Widget_Base {

	use BAE_Common_Settings_Render;
	public function get_name() {
		return 'bae-pdf-embedder';
	}

	public function get_title() {
		return esc_html__( 'PDF Embedder', 'document-embedder-addons-for-elementor' );
	}

	public function get_icon() {
		return 'bl_icon far fa-file-pdf eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'document-embedder-addons-for-elementor' ];
	}


	public function get_script_depends() {
		return ['bae-public'];
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
				'placeholder' 	=> esc_html__( 'Upload a pdf file here.', 'document-embedder-addons-for-elementor' ),
				'description' 	=> esc_html__( 'Upload a file on live server', 'document-embedder-addons-for-elementor' ),
				'media_type' 	=> 'application/pdf',
				'dynamic' => [
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
				'description' 	=> esc_html__( 'Provide a google drive link of a pdf file to preview', 'document-embedder-addons-for-elementor' ),
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
                'label' => esc_html__( 'PDF Content Setting', 'document-embedder-addons-for-elementor' ),
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
					'{{WRAPPER}} .my-PDF iframe' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
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
					'{{WRAPPER}} .my-PDF iframe' => 'height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .my-PDF' => 'display:flex;justify-content:{{VALUE}}',
				],
				'toggle' 	=> true,
			]
		);
		$this->end_controls_section();

		$this->render_common_style_settings();
	}

	public function render_common_style_settings() {
		$this->bae_box_common_styles_render( $id = 'pdf_viewer', $label = 'PDF Viewer', $condition = [], $selector = '.bae-pdf iframe' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$PDF_file = $settings['pdf_file'];
		$PDF_url = $settings['pdf_url'];
		$final_PDF_link = '';		
		$source_type = $settings['choose_source'];		
		if($source_type){
			$final_PDF_link = isset($PDF_url['url']) ? $PDF_url['url'] : '';
		}else{
			$final_PDF_link = isset($PDF_file['url']) ? $PDF_file['url'] : '';
		}

		// print_r($PDF_file);

		if(strpos($final_PDF_link, 'drive.google.com')){
			$source = str_replace('view', 'preview', $final_PDF_link);
		} else if(strpos($final_PDF_link, 'docs.google.com')){
			$source = str_replace('edit', 'preview', $final_PDF_link);
		}else {
			$source = "https://docs.google.com/gview?embedded=true&url=$final_PDF_link?download=false&amp;embedded=true";
		}


	if($final_PDF_link =='') { ?>
		<h3><?php echo esc_html__('Paste the pdf file link from setting widget.','document-embedder-addons-for-elementor') ?></h3>
	<?php } else { ?>
      <div class="my-PDF bae-pdf">
		<iframe src="<?php echo esc_url($source);?>&amp;embedded=true"  allowfullscreen>
		</iframe>
	</div>
	<?php } 
	       
	}
}