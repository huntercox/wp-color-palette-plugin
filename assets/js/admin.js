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
});
