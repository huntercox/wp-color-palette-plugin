jQuery(document).ready(function ($) {
	function initColorPicker() {
		$('.color-field:not(.wp-color-picker)').wpColorPicker({
			change: function (e, ui) {
				$(this).val(ui.color.toString());
			}
		});
	}

	initColorPicker();

	$('#add-color').click(function (e) {
		e.preventDefault();
		var colorInput = $('<div><input type="text" name="hsc_color_palette[color][]" class="color-field" /><input type="text" name="hsc_color_palette[id][]" class="id-field" /><button class="remove-color">X</button></div></br>');
		$(this).before(colorInput);
		initColorPicker();
	});

	$(document).on('click', '.remove-color', function (e) {
		e.preventDefault();
		$(this).parent().next('br').remove();
		$(this).parent().remove();
	});


	// Create new div for other settings
	let $newDiv = $('<div id="colors-toggle"></div>');
	$newDiv.appendTo('.form .columns');
	// Move H2 and Checkbox into the new div
	$('#color-pickers h2:last-of-type').appendTo('#colors-toggle');
	$('#color-pickers .form-table:last-of-type').appendTo('#colors-toggle');

	// Move Submit button to the bottom of the form
	$('.submit').appendTo('.form');


	// Wrap each color picker and text field in a div
	$('#color-pickers .wp-picker-container').each(function () {
		$(this).next('input').andSelf().wrapAll('<div class="color-row"></div>');

		// add a class to each wrapper based on the input's value (the color)
		let $color = $(this).next('input').val();
		$(this).parent().addClass('color--' + $color);

	});
});
