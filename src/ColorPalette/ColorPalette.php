<?php

namespace ColorPalette;

class ColorPalette
{
	private $options;
	public function __construct()
	{
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);

		// Hook into the admin menu
		add_action('admin_menu', [$this, 'add_page']);
		add_action('admin_init', [$this, 'page_init']);


		add_action('wp_head', [$this, 'output_palette_styles']);
	}

	public function enqueue_styles()
	{
		wp_enqueue_style('hsc-color-palette-plugin', MY_PLUGIN_DIR_URL . 'assets/css/hsc-color-palette.css', '1.0.0');
	}

	public function enqueue_admin_styles()
	{
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('color-palette-admin', MY_PLUGIN_DIR_URL . 'assets/js/admin.js', ['jquery', 'wp-color-picker'], '1.0.0', true);
	}

	public function add_page()
	{
		add_menu_page(
			'Color Palette',
			'Color Palette',
			'manage_options',
			'hsc_color_palette',
			[$this, 'create_admin_page'],
			'dashicons-admin-customizer',
			100
		);
	}

	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option('hsc_color_palette');
?>
		<div class="wrap">
			<h1>Color Palette</h1>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				if (isset($this->options['color'])) {
					$colors = $this->options['color'];
					if (is_array($colors)) {
						foreach ($colors as $color) {
							echo '<div style="width: 20px; height: 20px; background-color: ' . $color . ';"></div>';
						}
					}
				}
				settings_fields('hsc_color_palette_group');
				do_settings_sections('hsc_color_palette');
				?>
				<div id="color-pickers">
					<button id="add-color">Add Color</button>
					<?php
					submit_button('Save Colors');
					?>
			</form>
		</div>
<?php
	}

	public function page_init()
	{
		// Choose Colors


		add_settings_section(
			'setting_section_id', // ID
			'Section Title', // Title
			[$this, 'print_section_info'], // Callback
			'hsc_color_palette' // Page
		);
		register_setting(
			'hsc_color_palette_group', // Option group
			'hsc_color_palette', // Option name
			[$this, 'sanitize'] // Sanitize
		);

		add_settings_field(
			'color', // ID
			'Color', // Title
			[$this, 'color_callback'], // Callback
			'hsc_color_palette', // Page
			'setting_section_id' // Section
		);

		// Toggle Palette
		add_settings_section(
			'setting_section_id2', // ID
			'Section Title 2', // Title
			null, // Callback
			'hsc_color_palette' // Page
		);

		// register_setting(
		// 	'hsc_show_palette_group', // Option group
		// 	'hsc_show_palette', // Option name
		// 	[$this, 'sanitize_show_palette'] // Sanitize
		// );

		add_settings_field(
			'show_palette', // ID
			'Show Color Palette', // Title
			[$this, 'show_palette_callback'], // Callback
			'hsc_color_palette', // Page
			'setting_section_id2' // Section
		);
	}

	public function sanitize($input)
	{
		$new_input = array();
		if (isset($input['color']) && is_array($input['color'])) {
			foreach ($input['color'] as $color) {
				$new_input['color'][] = sanitize_text_field($color);
			}
		}
		$new_input['show_palette'] = isset($input['show_palette']) ? (bool) $input['show_palette'] : false;

		return $new_input;
	}

	public function print_section_info()
	{
		print 'Enter your settings below:';
	}

	public function color_callback()
	{
		$colors = isset($this->options['color']) ? $this->options['color'] : array('');
		foreach ($colors as $index => $color) {
			printf(
				'<input type="text" id="color" name="hsc_color_palette[color][]" value="%s" class="color-field" /> <br/>',
				esc_attr($color)
			);
		}
	}


	public function show_palette_callback()
	{
		$showPalette = isset($this->options['show_palette']) ? $this->options['show_palette'] : false;
		echo '<input type="checkbox" id="show_palette" name="hsc_color_palette[show_palette]" value="1" ' . checked(1, $showPalette, false) . ' />';
	}

	public function output_palette_styles()
	{
		$options = get_option('hsc_color_palette');
		$showPalette = isset($options['show_palette']) ? $options['show_palette'] : false;
		if ($showPalette && isset($options['color']) && is_array($options['color'])) {
			echo '<style type="text/css">body {';
			foreach ($options['color'] as $index => $color) {
				echo " --color{$index}: {$color};";
			}
			echo '}</style>';
		}
	}
}
