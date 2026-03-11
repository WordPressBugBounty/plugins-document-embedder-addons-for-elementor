<?php
namespace BAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use BAddon\BAE\BAE_Common_Settings_Render;

if ( !defined( 'ABSPATH' ) ) 
	exit; 

class bae_google_sheets extends Widget_Base {

	use BAE_Common_Settings_Render;
	public function get_name() {
		return 'bae-google-sheets';
	}

	public function get_title() {
		return esc_html__( 'Google Sheets', 'document-embedder-addons-for-elementor' );
	}

	public function get_icon() {
		return 'bl_icon fas fa-table eicon-table-of-contents';
	}

	public function get_categories() {
		return [ 'document-embedder-addons-for-elementor' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Google Sheets Content', 'document-embedder-addons-for-elementor' )
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
            'word_file',
            [
				'label' 		=> esc_html__( 'Upload Word File', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::MEDIA,
				'media_type' 	=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
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
			'sheets_url',
			[
				'label' 		=> esc_html__( 'Google docs URL', 'document-embedder-addons-for-elementor' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> esc_html__( 'Paste an excel file link here.', 'document-embedder-addons-for-elementor' ),
				'description' 	=> esc_html__( 'Provide a link to a file from sharable server', 'document-embedder-addons-for-elementor' ),
				'show_external' => true,
				'default' 		=> [
					'is_external' 	=> true,
					'nofollow' 		=> true,
				],
				'dynamic' 		=> [
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
                'label' => esc_html__( 'Google Sheets Setting', 'document-embedder-addons-for-elementor' ),
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
					'{{WRAPPER}} .google_sheet_style iframe' => 'height: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .google_sheet_style iframe' => 'max-width: {{SIZE}}{{UNIT}}',
				]
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
					'{{WRAPPER}} .google_sheet_style' => 'display:flex;justify-content:{{VALUE}}',
				],
				'toggle' 	=> true,
			]
		);

		$this->add_control(
			'file_name',
			[
				'label' 			=> esc_html__( 'Show File Name On top', 'document-embedder-addons-for-elementor' ),
				'type' 				=> Controls_Manager::SWITCHER,
				'label_on' 			=> esc_html__( 'On', 'document-embedder-addons-for-elementor' ),
				'label_off' 		=> esc_html__( 'Off', 'document-embedder-addons-for-elementor' ),
				'return_value' 		=> 'yes',
				'default' 			=> 'yes',
				'description' 		=> esc_html__( 'On, if you want to show the file name in the top of the viewer.', 'document-embedder-addons-for-elementor' ),
				'style_transfer'	=> true,
			]
		);

		$this->add_control(
            'file_name_text', [
                'label'          => esc_html__( 'File Name', 'document-embedder-addons-for-elementor' ),
                'type'           => Controls_Manager::TEXT,
                'label_block'    => true,
                'placeholder'    => esc_html__( 'Write Here File Name', 'document-embedder-addons-for-elementor' ),
                'default'        => esc_html__( 'Sheets Test File', 'document-embedder-addons-for-elementor' ),
                'condition' => [
                    'file_name' => 'yes'
                ]
            ]
        );

		$this->end_controls_section();

		$this->render_common_style_settings();
	}

	public function render_common_style_settings() {
		$this->bae_box_common_styles_render( $id = 'sheet_viewer', $label = 'Sheet Viewer', $condition = [], $selector = '.google_sheet_style iframe' );
		$this->bae_text_common_styles_render( $id = 'file_name', $label = 'File Name', $condition = [ 'file_name' => 'yes' ], $selector = '.google_sheet h3', $default = 'Sheets Test File' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$word_file = $settings['word_file'];
		$sheets_url = $settings['sheets_url'];
		$file_name_text = $settings[ 'file_name_text' ];

		$final_word_link = '';		
		$source_type = $settings['choose_source'];		
		if($source_type){
			$final_word_link = isset($sheets_url['url']) ? $sheets_url['url'] : '';
		}else{
			$final_word_link = isset($word_file['url']) ? $word_file['url'] : '';
		}
		?>
		<div class="google_sheet">
			<?php 
			if($file_name_text !=''):?>
		        <h3><?php echo esc_html($file_name_text);?></h3>
		     <?php endif;?>
		</div>
		<?php
			if($final_word_link == ''): ?>
				<center><h3><?php echo esc_html__('Paste the excel file link from setting widget.','document-embedder-addons-for-elementor'); ?></h3></center>
			<?php else: ?>
				<div class="google_sheet_style">
					<iframe src="<?php echo esc_url($final_word_link); ?>"></iframe>
				</div>
			<?php endif; 
	}
}