<?php

/**
 * @package           hsc_color_palette
 *
 * @wordpress-plugin
 * Plugin Name: HSC Color Palette
 * Description: Create a color palette in WP Admin and output to the frontend of your site as CSS variables.
 * Version: 1.0.0
 * Author: Hunter Cox
 * Author URI: www.huntercox.dev
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: hsc-color-palette
 */

require_once __DIR__ . '/vendor/autoload.php';

define('MY_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('MY_PLUGIN_DIR_PATH', untrailingslashit(plugin_dir_path(__FILE__)));

new ColorPalette\ColorPalette();
