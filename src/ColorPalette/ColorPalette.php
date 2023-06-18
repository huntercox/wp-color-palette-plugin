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
	}

	public function enqueue_styles()
	{
		wp_enqueue_style('hsc-color-palette-plugin', plugin_dir_url(__FILE__) . 'assets/css/hsc-color-palette.css', '1.0.0');
	}

	public function enqueue_admin_styles()
	{
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('color-palette-admin', MY_PLUGIN_DIR_URL . 'assets/js/admin.js', ['jquery', 'wp-color-picker'], '1.0.0', true);

		$script = "
	jQuery(document).ready(function($) {
		function initColorPicker() {
			$('.color-field').wpColorPicker({
				change: function(e, ui) {
					$(this).val(ui.color.toString());
				}
			});
		}

		initColorPicker();

		$('#add-color').click(function(e) {
			e.preventDefault();
			var colorInput = $('<input type=\"text\" name=\"hsc_color_palette[color][]\" class=\"color-field\" /><button class=\"remove-color\">Remove</button><br />');
			$(this).before(colorInput);
			initColorPicker();
		});

		$(document).on('click', '.remove-color', function(e) {
			e.preventDefault();
			$(this).prev('.color-field').remove();
			$(this).next('br').remove();
			$(this).remove();
		});
	});
	";

		wp_add_inline_script('color-palette-admin', $script);
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
					$color = $this->options['color'];
					echo '<div style="width: 20px; height: 20px; background-color: ' . $color . ';"></div>';
				}
				settings_fields('hsc_color_palette_group');
				do_settings_sections('hsc_color_palette');
				submit_button();
				?>
			</form>
		</div>
<?php
	}

	public function page_init()
	{
		register_setting(
			'hsc_color_palette_group', // Option group
			'hsc_color_palette', // Option name
			[$this, 'sanitize'] // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'Section Title', // Title
			[$this, 'print_section_info'], // Callback
			'hsc_color_palette' // Page
		);

		add_settings_field(
			'color', // ID
			'Color', // Title
			[$this, 'color_callback'], // Callback
			'hsc_color_palette', // Page
			'setting_section_id' // Section
		);
	}

	public function sanitize($input)
	{
		$new_input = array();
		if (isset($input['color']))
			$new_input['color'] = sanitize_text_field($input['color']);



		return $new_input;
	}

	public function print_section_info()
	{
		print 'Enter your settings below:';
	}

	public function color_callback()
	{
		printf(
			'<input type="text" id="color" name="hsc_color_palette[color]" value="%s" class="color-field" />',
			isset($this->options['color']) ? esc_attr($this->options['color']) : ''
		);
	}




	// END CLASS
}
