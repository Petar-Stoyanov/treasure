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
	var initialEl = $("#suggestion-location1").text();
	var el2 = $("#suggestion-location1").text();

	// newArray.splice(20, lastArrayEl);
	// newArray = newArray.toString();
	// el2 = newArray;

	// if(el2.length > 330) {
		// split the text and make it an array
		function shortenRelatedPlaceText() {
	    	var newArray = el2.split(" ");

	    	// get the amout of elements in the array in order to have ending point to which you cut the text
			var lastArrayEl = newArray.length;

			newArray.splice(20, lastArrayEl);
			newArray = newArray.join(" ");
			el2 = newArray;
			// el2 = $("#suggestion-location1").text(el2);
			el2 = $("#suggestion-location1").text(el2) + "+++";
			el2 += "...";
		}
		shortenRelatedPlaceText();
    // }

	// var elem = $("#suggestion-location1");

	// if(elem) {
 //    	if (elem.text().length > 330) {
 //        	elem.text(elem.text().substring(0, 330) + " ...");
 //        }	
	// }

	$(document).on('click', ".see-more-one", function() {
		$("#suggestion-location1").toggleClass("clicked1");

		// if(el2.length > 330) {
		// if($("#suggestion-location1").hasClass("clicked1")) {
  //   		elem.text;
		// } else {
		// 	if(elem) {
	 //        	if (elem.text().length > 330);
	 //            	elem.text(elem.text().substr(0, 330) + " ...");
	 //    	}
		 	if($("#suggestion-location1").hasClass("clicked1")) {
		 		el2 = $("#suggestion-location1").text(initialEl);
		    } else {
		    	// split the text and make it an array
		  //   	var newArray = el2.split(" ");

		  //   	// get the amout of elements in the array in order to have ending point to which you cut the text
				// var lastArrayEl = newArray.length;

				// newArray.splice(20, lastArrayEl);
				// newArray = newArray.join(" ");
				// el2 = newArray;
				// el2 = $("#suggestion-location1").text(el2) + "+++";
				// el2 += "...";
				shortenRelatedPlaceText();
		    }
		// }
	});

	// var elem = $("#suggestion-location1");

 //    if(elem){
 //        if (elem.text().length > 330);
 //            elem.text(elem.text().substr(0, 330) + " ...");
 //    }

    var elem2 = $("#suggestion-location2");

    if(elem2){
        if (elem2.text().length > 330);
            elem2.text(elem2.text().substr(0, 330) + " ...");
    }

});