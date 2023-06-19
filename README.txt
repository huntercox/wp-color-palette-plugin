=== Color Palette ===
Contributors: Hunter Cox
Requires at least: 5.5
Tested up to: 5.8
Stable tag: 1.0.0
Requires PHP: 5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
== Description ==
WordPress Plugin that creates a page in WP Admin for you to build a palette and add it to the frontend as CSS variables.

This plugin does the following:

1. Upon activation creates a settings page in the WP Admin called "Color Palette"
2. Within the Color Palette plugin page you can proceed to build a color palette with the option to pass colors to frontend.
3. Choose a color by clicking the 'Select Color' button on a color picker and populating the field with a hex code.
4. Fill out the corresponding text field to give the color an identifier.
5. Click Update Settings to save the colors into the database.
6. To add more colors, click the Add Color button to generate another color picker.
7. Choose to enable passing this array to the client-side DOM for usage on frontend by checking the "Add colors to root element as CSS variables." checkbox.
8. If checked, colors are output via an inline-stylesheet to the <head> of the HTML document.
9. CSS variables with corresponding IDs are added to the body element within the stylesheet.

**Usage with SCSS**

In order to use these variables with SCSS you must format the variables like this:

$green: --green;

Where --green is your color's ID and $green is the variable you'll to output using var() when you need to use the function in a

You cannot declare the variables with a var() function around them so that you can use $green everywhere. You must decalre them as text and then use var() in each place to output the hex code. Like so:

	// SCSS input
	background-color: var($green);

	// CSS ouput
	background-color: #38d6b4;

**Known Issues:**
This method does not work with certain Sass functions such as lighten(), darken() and rgba(). You cannot pass an interpolated variable through these functions.
