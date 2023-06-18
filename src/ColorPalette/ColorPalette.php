<?php

namespace ColorPalette;

class ColorPalette
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
	}

	public function enqueue_styles()
	{
		wp_enqueue_style('hsc-color-palette-plugin', plugin_dir_url(__FILE__) . 'assets/css/hsc-color-palette.css', '1.0.0');
	}

	public function create_settings_page()
	{
	}
}
