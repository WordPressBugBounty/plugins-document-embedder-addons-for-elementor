<?php
namespace DEAFE\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use DEAFE\Helper\DEAFE_Common_Settings_Render;

if ( !defined( 'ABSPATH' ) ) 
	exit; 

class deafe_doc_embedder extends Widget_Base {

	use DEAFE_Common_Settings_Render;
	public function get_name() {
		return 'deafe-doc-embedder';
	}

	public function get_title() {
		return esc_html__( 'Doc Embedder', 'document-embedder-addons-for-elementor' );
	}

	public function get_icon() {
		return 'deafe_icon far fa-file-word eicon-document-file';
	}

	public function get_categories() {
		return [ 'document-embedder-addons-for-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Docs Content', 'document-embedder-addons-for-elementor' )
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
            'doc_file',
            [
				'label' 		=> esc_html__( 'Upload Doc File', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::MEDIA,
				'placeholder' 	=> esc_html__( 'Upload a word file here.', 'document-embedder-addons-for-elementor' ),
				'description' 	=> esc_html__( 'Upload a file on live server', 'document-embedder-addons-for-elementor' ),
				'media_type' 	=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'dynamic' => [
					'active' => true,
				],
				'condition'		=> [
					'choose_source' => '',
				]
			]
        );

		$this->add_control(
			'doc_url',
			[
				'label' 		=> esc_html__( 'Doc URL', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> esc_html__( 'Paste a word file link here.', 'document-embedder-addons-for-elementor' ),
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
                'label' => esc_html__( 'Doc Content Setting', 'document-embedder-addons-for-elementor' ),
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
					'{{WRAPPER}} .my-doc iframe' => 'max-width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .my-doc iframe' => 'height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .my-doc' => 'display:flex;justify-content:{{VALUE}}',
				],
				'toggle' 	=> true,
			]
		);
		$this->end_controls_section();

		$this->render_common_style_settings();
	}

	protected function get_upsale_data(): array {
		return [
			'condition' => ! \Elementor\Utils::has_pro(),
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'document-embedder-addons-for-elementor' ),
			'title' => esc_html__( 'Document Embedder Addons', 'document-embedder-addons-for-elementor' ),
			'description' => esc_html__( 'This viewer has multiple premium controls like border, shadow, etc. To get all the premium controls, please upgrade to the pro version.', 'document-embedder-addons-for-elementor' ),
			'upgrade_url' => esc_url( 'https://bplugins.com/products/document-embedder-addons-for-elementor/pricing/' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'document-embedder-addons-for-elementor' ),
		];
	}


	public function render_common_style_settings() {
		$this->deafe_promotion_notice_render( $id = 'file_name', $label = 'File Name', $condition = [ 'file_name' => 'yes' ], $selector = '.native_style h3', $default = 'PDF Test File' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$doc_file = $settings['doc_file'];
		$doc_url = $settings['doc_url'];
		$final_doc_link = '';		
		$source_type = $settings['choose_source'];		
		if($source_type){
			$final_doc_link = isset($doc_url['url']) ? $doc_url['url'] : '';
		}else{
			$final_doc_link = isset($doc_file['url']) ? $doc_file['url'] : '';
		}

		if(strpos($final_doc_link, 'drive.google.com')){
			$source = str_replace('view', 'preview', $final_doc_link);
		} else if(strpos($final_doc_link, 'docs.google.com')){
			$source = str_replace('edit', 'preview', $final_doc_link);
		}else {
			$source = "https://docs.google.com/viewer?url=$final_doc_link?download=false&amp;embedded=true";
		}


	if($final_doc_link =='') { ?>
		<h3><?php echo esc_html__('Paste the pdf file link from setting widget.','document-embedder-addons-for-elementor') ?></h3>
	<?php } else { ?>
      <div class="my-doc">
		<iframe src="<?php echo esc_url($source);?>&amp;embedded=true"  allowfullscreen>
		</iframe>
	</div>
	<?php } 
	       
	}
}