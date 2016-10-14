$(document).ready(function() {

	// show and hide the side menu on the manp page
	$(".side-menu-title").click( function() {
		$(".colapsable-uls-hidden").toggleClass("colapsable-uls");
	});
	
 //  	var $grid = $('.grid').masonry({
	 
	// });

	// $grid.imagesLoaded().progress( function() {
	//   $grid.masonry('layout');
	// });

	$(function() {
		app.setup({
			share: 1,
			layout: 1,
			events: 1,
			methods: 1,
			options: 1,
			preload: 1,
			drillhole: 1
		});
	});
});