/* Scrolling Code */
/** COPYRIGHT DANIEL TIMKO 2015 **/

//globals pertaining to scrolling
//How far the user has scrolled.  Starts neutral at 0
var scrollStep = 0;
//Min/Max scrollStep value for parallaxing
var maxScrollStep = 0;
var minScrollStep = 0;
//list of "steps down page" for each inViewParallax element.  Stores the scrollStep value when the item first appears on the page
//elements with the inViewParallax tag will begin parallaxing only when they become visible.  This is useful for elements that are an unknown distance
//down the page
var inViewParallaxSteps = [];

//handle the dragging of the scrollbar
//variable showing the state of the mouse
var mouseIsDown = false;
//position of the scrollbar in the window
var scrollBarPos = 0;

//On mousedown over the scrollbar
$('#scrollBar').mousedown(function() {
	//set the mousedown variable to true
	mouseIsDown = true;
});

//On mouseup anywhere on the page.
//The reason for this is so that the user can move the mouse anywhere on the page while scrolling IF the mouse is held down
$('html').mouseup(function() {
	//set the mousedown variable to false
	mouseIsDown = false;
	//reset the css properties.  Re-enable text highlighting and return the cursor to normal
	$('html').css({
		"-webkit-touch-callout": "all",
		"-webkit-user-select": "all",
		"-moz-user-select": "all",
		"-ms-user-select": "all",
		"user-select": "all",
		"cursor": "auto"
	});
//On mousemove anywhere on the page, pass the event to a function
}).mousemove(function(event) {
	//if the mouse is down
	if (mouseIsDown) {
		//disable text highlighting and set the cursor to the n-resize (up-down arrow)
		$('html').css({
			"-webkit-touch-callout": "none",
			"-webkit-user-select": "none",
			"-moz-user-select": "none",
			"-ms-user-select": "none",
			"user-select": "none",
			"cursor": "n-resize"
		});
		//set the position of the middle of the scrollbar to the mouse's y position
		scrollBarPos = utils.clamp(event.pageY - Math.round($('#scrollBar').height()/2), 0, $(window).height()-$('#scrollBar').height());
		//calculate dem scrolls!
		calculateScroll();
	}
});

//function to handle scrollbar's movement
function calculateScroll() {
	//height that results from subtracting the bar's height from the window's height.  Useful for calculating position
	var barHeight = $(window).height() - $('#scrollBar').height();
	//parallax to the clamped percentage value of the scrollbar position (based on mouse position).  Do not animate
	parallaxTo(utils.clamp((scrollBarPos/barHeight)*100, 0, $(window).height()-$('#scrollBar').height()), false);
}

//scroll function.  Boolean 'dir' determines scroll direction (false = down, true = up)
function scroll(dir) {
	//if the scroll direction is up
	if (dir) {
		//if the current scroll position is above the minimum
		if (scrollStep > minScrollStep) {
			//subtract from the scroll clicks
			scrollStep = Math.round(scrollStep);
			scrollStep -= 1;
			//calculate the percentage distance down the page
			var downPage = (scrollStep / maxScrollStep) * 100;
			//parallax to the newly scrolled position, animating changes
			parallaxTo(downPage, true);
		}
	//else, the scroll direction is down
	} else {
		//if the current scroll position is below the maximum
		if (scrollStep < maxScrollStep) {
			//add to the scroll clicks
			scrollStep = Math.round(scrollStep);
			scrollStep += 1;
			//calculate the percentage distance down the page
			var downPage = (scrollStep / maxScrollStep) * 100;
			//parallax to the newly scrolled position, animating changes
			parallaxTo(downPage, true);
		}
	}
}