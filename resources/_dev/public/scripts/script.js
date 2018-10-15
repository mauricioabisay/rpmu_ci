jQuery(document).ready(function() {
	jQuery('.rpm-menu-close').click(function() {
		var parent = jQuery(this).parent();
		parent.css('display', 'none');
	});
	jQuery('.rpm-menu-open').click(function() {
		console.log('hola');
		var menu = jQuery(this).parents('.rpm-menu').find('.rpm-menu-toggle');
		menu.css('display', 'block');
	});
});
window.onload = function() {
	jQuery('.rpm-researches-list').masonry({itemSelector: '.rpm-research-item'});
	jQuery('.rpm-research-carousel').slick({dots: true});
};