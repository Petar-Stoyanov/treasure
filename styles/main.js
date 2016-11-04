$(document).ready(function() {

	// show and hide the side menu on the manp page
	$(".side-menu-title").click( function() {
		$(".colapsable-uls-hidden").toggleClass("colapsable-uls");
	});

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

	// shorten amount of text on the inner page suggested places
	var elem = $("#suggestion-location1");

    if(elem){
        if (elem.text().length > 330);
            elem.text(elem.text().substr(0, 330) + " ...");
    }

    var elem2 = $("#suggestion-location2");

    if(elem2){
        if (elem2.text().length > 330);
            elem2.text(elem2.text().substr(0, 330) + " ...");
    }

});