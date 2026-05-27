<?php
namespace DEAFE\Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

trait DEAFE_Common_Settings_Render {

    /**
     * Text Common Settings
     *
     * @access public
     */
    public function deafe_promotion_notice_render( $id = '', $label = '', $condition = [], $selector = '', $default = '' ) {
        $this->start_controls_section(
			'section_'. $id .'_style',
			[
				'label' => esc_html__( 'Viewer Layout', 'document-embedder-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => $condition
			]
		);

		$this->add_control(
			'layout_pro_notice',
			[
				'type' => \Elementor\Controls_Manager::NOTICE,
				'notice_type' => 'info',
				'dismissible' => true,
				'heading' => esc_html__( 'Pro Controls', 'document-embedder-addons-for-elementor' ),
				'content' => esc_html__( 'This is a Pro feature. Please upgrade to Pro to get access to all features.', 'document-embedder-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();
    }


}


?>