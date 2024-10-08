<?php

namespace mphbe\widgets;

use \Elementor\Controls_Manager;

class CheckoutWidget extends AbstractWidget
{
    public function get_name()
    {
        return 'mphbe-checkout';
    }

    public function get_title()
    {
        return __('Checkout Form', 'mphb-elementor');
    }

    public function get_icon()
    {
        // Elementor icon class ( https://pojome.github.io/elementor-icons/ ) or
        // Font Awesome icon class ( https://fontawesome.com/ ), like:
        return 'eicon-price-list';
    }

    /**
     * Adds different input fields to allow the user to change and customize the
     * widget settings.
     */
    protected function register_controls()
    {
        $this->start_controls_section('section_parameters', array(
            'label'       => __('Parameters', 'mphb-elementor')
        ));

        $this->add_control('class', array(
            'type'        => Controls_Manager::TEXT,
            'label'       => __('Class', 'mphb-elementor'),
            'description' => __('Custom CSS class for shortcode wrapper.', 'mphb-elementor'),
            'default'     => ''
        ));

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     */
    protected function render()
    {
        $atts = $this->get_settings();

        do_action('mphbe_before_checkout_widget_render', $atts);

        $shortcode = MPHB()->getShortcodes()->getCheckout();
        echo $shortcode->render($atts, null, $shortcode->getName()); // phpcs:ignore

        do_action('mphbe_after_checkout_widget_render', $atts);

    }
}
