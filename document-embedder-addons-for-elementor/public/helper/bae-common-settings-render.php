<?php
namespace BAddon\BAE;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

/**
 * Common Settings Render
 *
 * @package BAE
 */

trait BAE_Common_Settings_Render {

    /**
     * Text Common Settings
     *
     * @access public
     */
    public function bae_text_common_styles_render( $id = '', $label = '', $condition = [], $selector = '', $default = '' ) {
        $this->start_controls_section(
			'section_'. $id .'_style',
			[
				'label' => esc_html__( 'File Name', 'document-embedder-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => $condition
			]
		);

		$this->add_control(
			'file_name_color',
			[
				'label' => esc_html__( 'Text Color', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group__control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'file_name_typography',
				'label' => __('Typography', 'document-embedder-addons-for-elementor'),
				'selector' => '{{WRAPPER}} '.$selector,
			]
		);
		$this->add_control(
			'file_name_margin',
			[
				'label' => esc_html__( 'Margin', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'file_name_padding',
			[
				'label' => esc_html__( 'Padding', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
    }

    /**
     * Button Common Settings
     *
     * @access public
     */
    public function bae_button_common_styles_render( $id = '', $label = '', $condition = [], $selector = '', $default = '' ) {
        $this->start_controls_section(
			'section_'. $id .'_style',
			[
				'label' => esc_html__( 'Download Button', 'document-embedder-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => $condition
			]
		);

		$this->add_group__control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __('Typography', 'document-embedder-addons-for-elementor'),
				'selector' => '{{WRAPPER}} '.$selector,
			]
		);

		$this->start_controls_tabs( $id .'_style_tabs' );

		$this->start_controls_tab(
			$id .'_style_normal',
			[
				'label' => esc_html__( 'Normal', 'document-embedder-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group__control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} '.$selector,
				'label' => 'Border Type',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$id .'_style_hover',
			[
				'label' => esc_html__( 'Hover', 'document-embedder-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$selector.':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} '.$selector.':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group__control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border_hover',
				'selector' => '{{WRAPPER}} '.$selector.':hover',
				'label' => 'Border Type'
			]
		);

		$this->add_control(
			'button_border_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} '.$selector.':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_margin',
			[
				'label' => esc_html__( 'Margin', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'document-embedder-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} '.$selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group__control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} '.$selector,
				'label' => "Box Shadow",
			]
		);
		
		$this->end_controls_section();
    }

    /**
     * Box Common Settings
     *
     * @access public
     */
    public function bae_box_common_styles_render( $id = '', $label = '', $condition = [], $selector = '' ) {
        $this->start_controls_section(
            'section_'. $id .'_style',
            [
                'label'     => esc_html__( 'Viwer Layout', 'document-embedder-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        // Border
        $this->add_group__control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'viewer_border',
                'selector' => '{{WRAPPER}} ' . $selector,
				'label' => 'Border Type',
            ]
        );

        // Border Radius
        $this->add_control(
            'viewer_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'document-embedder-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group__control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'viewer_box_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
				'label' => 'Box Shadow',
            ]
        );

        // Padding
        $this->add_control(
            'viewer_box_padding',
            [
                'label'      => esc_html__( 'Padding', 'document-embedder-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin
        $this->add_control(
            'viwer_box_margin',
            [
                'label'      => esc_html__( 'Margin', 'document-embedder-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	/**
     * Add a control to the widget.
     * 
     * Extends parent add_control to handle premium controls by adding
     * visual indicators and locking for non-premium users.
     *
     * @param string $name Control name
     * @param array $args Control arguments
     * @param array $options Control additional options
     * @return void
     */
    public function add_control($id, $args = [], $options = [])
    {
        // Check if this is a premium control and user doesn't have premium access
        if (!$this->is_premium() && in_array($id, $this->premium_controls())) {
            // Append _locked to control id
            $id = $id . '_locked';

            // Add Pro label and locked class
            $args['label'] = $args['label'] . " <span class='fs_pro_control_label'>Pro</span>";
            $args['classes'] = isset($args['classes']) ? $args['classes'] . ' fs-locked' : 'fs-locked';
        }

        parent::add_control($id, $args, $options);
    }

	

	/**
     * Check if premium features are available
     * 
     * Checks if the premium licensing system is active and the current user
     * has access to premium features.
     *
     * @since 1.0.0
     * @access public
     * @return boolean True if premium features are available, false otherwise
     */
    public function is_premium() 
    {
        return function_exists('deafe_fs') && deafe_fs()->can_use_premium_code();
    }

	/**
     * Get list of premium controls
     * 
     * Returns an array of control names that are only available in premium version.
     *
     * @since 1.0.0
     * @access public
     * @return array Array of premium control names/ids
     */
    public function premium_controls()
    {
        return [
			'viewer_border',
		   'viewer_border_radius',
		   'viwer_box_margin',
		   'viewer_box_padding',
		   'viewer_box_shadow',
		   'file_name_color',
		   'file_name_typography',
		   'file_name_margin',
		   'file_name_padding',
		   'button_typography',
		   'button_box_shadow',
		   'button_padding',
		   'button_margin',
		   'button_border_radius',
		   'button_border',
		   'button_border_radius_hover',
		   'button_border_hover',
		   'button_text_color',
		   'button_bg_color',
		   'button_text_color_hover',
		   'button_bg_color_hover',
        ];
    }

	public function add_group__control($group_name, $args = [], $options = [])
    {
        // Check if this is a premium control and user doesn't have premium access
        if (!$this->is_premium() && in_array($args['name'], $this->premium_controls())) {
            // Append _locked to control name
            $args['name'] = $args['name'] . '_locked';

            // Add Pro label and locked class
            $args['label'] = $args['label'] . " <span class='fs_pro_control_label'>Pro</span>";
            $args['classes'] = isset($args['classes']) ? $args['classes'] . ' fs-locked' : 'fs-locked';
            $args['type'] =  Controls_Manager::RAW_HTML;
            $args['raw']   = ' <i class="eicon-edit" aria-hidden="true" style="font-family: eicons, Bangla1046, sans-serif;"></i>';

            parent::add_control($args['name'], $args, $options);
        } else {
            parent::add_group_control($group_name, $args, $options);
        }
    }

}


?>