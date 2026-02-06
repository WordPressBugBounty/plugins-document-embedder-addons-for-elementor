<?php
namespace BAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use BAddon\BAE\BAE_Common_Settings_Render;

if ( !defined( 'ABSPATH' ) ) 
	exit; 

class bae_pp_embedder extends Widget_Base {

	use BAE_Common_Settings_Render;
	public function get_name() {
		return 'bae-pp-embedder';
	}

	public function get_title() {
		return esc_html__( 'PowerPoint Embedder', 'document-embedder-addons-for-elementor' );
	}

	public function get_icon() {
		return 'bl_icon far fa-file-powerpoint eicon-nested-carousel'; 
	}

	public function get_categories() {
		return [ 'document-embedder-addons-for-elementor' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'PowerPoint Content', 'document-embedder-addons-for-elementor' )
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
			'pptx_file',
			[
				'label' 		=> esc_html__( 'Upload PowerPoint File', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::MEDIA,
				'media_type' 	=> 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
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
			'pptx_url',
			[
				'label' 		=> esc_html__( 'PowerPoint URL', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> esc_html__( 'Paste a powerpoint file link here.', 'document-embedder-addons-for-elementor' ),
				'description' 	=> esc_html__( 'Provide a link to a file from sharable server', 'document-embedder-addons-for-elementor' ),
				'show_external' => true,
				'default' 		=> [
					'is_external' 	=> true,
					'nofollow'		=> true,
				],
				'dynamic' 		=> [
					'active' => true,
				],
				'condition'		=> [
					'choose_source' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'section_content_setting',
            [
                'label' => esc_html__( 'PowerPoint Content Setting', 'document-embedder-addons-for-elementor' ),
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
					'{{WRAPPER}} .powerpoin_embeder iframe' => 'max-width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .powerpoin_embeder iframe' => 'height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .powerpoin_embeder' => 'display:flex;justify-content:{{VALUE}}; width:100%;',
				],
				'toggle' 	=> true,
			]
		);
		$this->end_controls_section();

		$this->render_common_style_settings();
	}

	public function render_common_style_settings() {
		$this->bae_box_common_styles_render( $id = 'powerpoint_viewer', $label = 'PowerPoint Viewer', $condition = [], $selector = '.powerpoin_embeder iframe' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$pptx_file = $settings['pptx_file'];
		$pptx_url = $settings['pptx_url'];
		$final_pptx_link = '';		
		$source_type = $settings['choose_source'];		
		if($source_type){
			$final_pptx_link = isset($pptx_url['url']) ? $pptx_url['url'] : '';
		}else{
			$final_pptx_link = isset($pptx_file['url']) ? $pptx_file['url'] : '';
		}
		if($final_pptx_link == ''):?>
			<center><h3><?php esc_html_e('Paste the powerpoint file link from setting widget.','document-embedder-addons-for-elementor') ?></h3></center>
		<?php else: ?>
			<div class="powerpoin_embeder">
				<iframe src="https://docs.google.com/viewer?url=<?php echo esc_url($final_pptx_link); ?> &amp;embedded=true" allowfullscreen></iframe>
			</div>	
		<?php endif; 
		
	}
}