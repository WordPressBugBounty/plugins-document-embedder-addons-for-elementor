<?php
namespace BAddon\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class My_Lock_Widget extends Widget_Base {

    private $locked_widget_name;
    private $locked_widget_icon;
    private $locked_widget_id;

    public function __construct( $locked_widget_name = 'Locked Widget', $locked_widget_id = 'my-lock-widget', $locked_widget_icon = 'eicon-lock-user', $data = [], $args = null ) {
        parent::__construct( $data, $args );
        $this->locked_widget_name = $locked_widget_name;
        $this->locked_widget_icon = $locked_widget_icon;
        $this->locked_widget_id = $locked_widget_id;
    }

    public function get_name() {
        return $this->locked_widget_id;
    }

    public function get_title() {
        return esc_html__( $this->locked_widget_name, 'document-embedder-addons-for-elementor' );
    }

    public function get_icon() {
        return $this->locked_widget_icon;
    }

    public function get_categories() {
        return [ 'my_pro_widgets' ];
    }

    public function is_premium() {
        return true;
    }

    public function get_keywords() {
        return [ 'locked', 'pro', 'upgrade' ];
    }

    protected function get_upsale_data(): array {
        return [
            'condition'    => ! \Elementor\Utils::has_pro(),   // only show if Pro is NOT active
            'image'        => esc_url( plugins_url( 'assets/images/go-pro.svg', __FILE__ ) ),  // your promotion image
            'image_alt'    => esc_attr__( 'Upgrade to Pro', 'your-text-domain' ),
            'title'        => esc_html__( 'Get More Features', 'your-text-domain' ),
            'description'  => esc_html__( 'Unlock advanced options, styling & templates with the Pro version.', 'your-text-domain' ),
            'upgrade_url'  => esc_url( 'https://your-site.com/buy-pro' ),
            'upgrade_text' => esc_html__( 'Go Pro Now', 'your-text-domain' ),
        ];
    }

    protected function render() {
        // This will be seen only if manually added somehow.
        echo '<div style="border:1px dashed #ccc;padding:10px;text-align:center;">';
        echo esc_html__( 'This is a Pro widget. Please upgrade to unlock full access.', 'document-embedder-addons-for-elementor' );
        echo '</div>';
    }
}