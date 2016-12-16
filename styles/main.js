$(document).ready(function() {

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
	// text 1
	var initialEl = $("#suggestion-location1").text();
	var elementOne = $("#suggestion-location1").text();

		function shortenRelatedPlaceText() {
	    	var newArray = elementOne.split(" ");

	    	// get the amout of elements in the array in order to have ending point to which you cut the text
			var lastArrayEl = newArray.length;

			newArray.splice(35, lastArrayEl);
			newArray = newArray.join(" ");
			elementOne = newArray;

			elementOne = $("#suggestion-location1").text(elementOne + " ...");
		}
		shortenRelatedPlaceText();

	$(document).on('click', ".see-more-one", function() {
		$(".see-more-one").remove();
		elementOne = $("#suggestion-location1").text(initialEl);
	});
	
	// text 2
	var initialEl2 = $("#suggestion-location2").text();
	var elementTwo = $("#suggestion-location2").text();

		function shortenRelatedPlaceText2() {
	    	var newArray2 = elementTwo.split(" ");

	    	// get the amout of elements in the array in order to have ending point to which you cut the text
			var lastArrayEl = newArray2.length;

			newArray2.splice(35, lastArrayEl);
			newArray2 = newArray2.join(" ");
			elementTwo = newArray2;

			elementTwo = $("#suggestion-location2").text(elementTwo + " ...");
		}
		shortenRelatedPlaceText2();

	$(document).on('click', ".see-more-two", function() {
		$(".see-more-two").remove();
		elementTwo = $("#suggestion-location2").text(initialEl2);
	});

    // var elem2 = $("#suggestion-location2");

    // if(elem2){
    //     if (elem2.text().length > 330);
    //         elem2.text(elem2.text().substr(0, 330) + " ...");
    // }

});