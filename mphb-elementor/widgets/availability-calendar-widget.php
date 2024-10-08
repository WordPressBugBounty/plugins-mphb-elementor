<?php

namespace mphbe\widgets;

use \Elementor\Controls_Manager;

class AvailabilityCalendarWidget extends AbstractCalendarWidget {

	public function get_name() {
		return 'mphbe-availability-calendar';
	}

	public function get_title() {
		return __( 'Availability Calendar', 'mphb-elementor' );
	}

	public function get_icon() {
		// Elementor icon class ( https://pojome.github.io/elementor-icons/ ) or
		// Font Awesome icon class ( https://fontawesome.com/ ), like:
		return 'eicon-archive-posts';
	}

	/**
	 * Adds different input fields to allow the user to change and customize the
	 * widget settings.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_parameters',
			array(
				'label' => __( 'Parameters', 'mphb-elementor' ),
			)
		);

		// "id" required, but it will cause Backbone error "A "url" property or function must be specified"
		$this->add_control(
			'type_id',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'ID', 'mphb-elementor' ),
				'description' => __( 'ID of accommodation type.', 'mphb-elementor' ),
				'default'     => '',
			)
		);

		$this->add_control(
			'monthstoshow',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'How many months to show', 'mphb-elementor' ),
				'description' => __( 'Set the number of columns or the number of rows and columns separated by comma. Example: "3" or "2,3"', 'mphb-elementor' ),
				'default'     => '2',
			)
		);

		$this->add_control(
			'display_price',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => __( 'Display prices', 'mphb-elementor' ),
				'description' => __( 'Display per-night prices in the availability calendar.', 'mphb-elementor' ),
				'default'     => false,
			)
		);

		$this->add_control(
			'truncate_price',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => __( 'Truncate prices', 'mphb-elementor' ),
				'description' => __( 'Truncate per-night prices in the availability calendar.', 'mphb-elementor' ),
				'default'     => true,
			)
		);

		$this->add_control(
			'display_currency',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => __( 'Display currency', 'mphb-elementor' ),
				'description' => __( 'Display the currency sign in the availability calendar.', 'mphb-elementor' ),
				'default'     => false,
			)
		);

		$this->add_control(
			'class',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Class', 'mphb-elementor' ),
				'description' => __( 'Custom CSS class for shortcode wrapper.', 'mphb-elementor' ),
				'default'     => '',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {

		$atts                     = $this->get_settings();
		$atts['id']               = absint( $atts['type_id'] );
		$atts['monthstoshow']     = sanitize_text_field( $atts['monthstoshow'] );
		$atts['display_price']    = boolval( $atts['display_price'] );
		$atts['truncate_price']   = boolval( $atts['truncate_price'] );
		$atts['display_currency'] = boolval( $atts['display_currency'] );

		do_action( 'mphbe_before_availability_calendar_widget_render', $atts );

		$shortcode = MPHB()->getShortcodes()->getAvailabilityCalendar();
        echo $shortcode->render($atts, null, $shortcode->getName()); // phpcs:ignore
		parent::render();

		do_action( 'mphbe_after_availability_calendar_widget_render', $atts );
	}
}
