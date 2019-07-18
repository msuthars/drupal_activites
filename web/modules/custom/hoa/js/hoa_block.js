(($, Drupal) => {
	Drupal.behaviors.blockFlip = {
		attach: function (context) {
			const $rotatorBlock = $('div[id^="block-rotator"] .content .field .field__items', context);
			$rotatorBlock.flip({
				front: '.odd',
				back: '.even',
				trigger: 'hover'
			});
		}
	};
})(jQuery, Drupal);