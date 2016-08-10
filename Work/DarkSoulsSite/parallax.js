/* Parallax Code */
/** COPYRIGHT DANIEL TIMKO 2015 **/

//This function parallaxes elements to the correct position on the page
//pagePercent = percent of the way down the page to scroll
//animate = whether or not to animate the transition
function parallaxTo(pagePercent, animate) {
	//calculate the number of scroll steps down the page we are (multiply the total number of possible steps by the percentage parameter)
	var stepsDownPage = (pagePercent/100) * maxScrollStep;
	//set the scrollstep global equal to the number of steps down the page
	scrollStep = stepsDownPage;
	
	//the scrollbar positioning is based on the following idea.  The bar itself takes up space, and the remaining space is how much it can move.  Divide that
	//remaining space by however many possible steps there are, and it is easy to calculate where to place the scrollbar.
	//animate the scrollbar (instead of dividing by 6, as is done outside of parallax, divide by the maximum number of steps)
	var scrollBarTop = ($(window).height() - $('#scrollBar').height()) / maxScrollStep;
	//if the animation parameter is true
	if (animate) {
		//animate the scrollbar to the correct position
		$('#scrollBar').stop().animate({top: scrollBarTop * scrollStep}, 100);
	//else, the animation parameter is false
	} else {
		//still animate, but a negligable amount.  Prevents scrollbar jumping
		$('#scrollBar').stop().animate({top: scrollBarTop * scrollStep}, 15);
	}
	
	//save the window height to a variable
	var windowHeight = $(window).height();
	//for each element in the .parallax class
	$(".parallax").each(function() {
		//calculate this element's distance from the top of the page
		//an element's parallax weight determines how fast it scrolls relative to the background, per step.  The value is percentage of page heights (a parallaxWeight of 1 = 1% of total page height per step)
		//((parallaxWeight / 100) * windowHeight) * stepsDownPage * -1
		var topValue = ((parseFloat($(this).attr("data-parallaxWeight")) / 100) * windowHeight) * stepsDownPage * -1;
		//if the current parallax element is the main content pane
		if ($(this).hasClass("mainContentPane")) {
			//add the window height to it's distance from the top (this ensures that everything starts out of frame)
			topValue += windowHeight;
		}
		//if the current parallax element is the title box
		if ($(this).hasClass("mainTitleBox")) {
			//add a y distance so that it is centered on load
			topValue += Math.floor((windowHeight / 2) - ($(this).height() / 2));
		}
		//if the animate parameter is true
		if (animate) {
			//animate this element's top value to the calculated position
			$(this).stop().animate({top: topValue}, 100);
		//else, the animate parameter is false
		} else {
			//set this element's top value to the calculated position
			$(this).stop().css('top', topValue);
		}
	});
}

//the reset parallax function recalculates the number of parallax elements, as well as new page height due to parallax content changing
function resetParallax(thisDownPage) {
	//get the height of the main content pane
	var mainHeight = $('.mainContentPane').height();
	//get the window height
	var windowHeight = $(window).height();
	//get the parallax weight of the main content pane
	var mainWeight = parseFloat($('.mainContentPane').attr("data-parallaxWeight"));
	//calculate the maximum number of scroll steps
	maxScrollStep = Math.floor((mainHeight)/((mainWeight/100)*windowHeight));
	minScrollStep = 0;
	//set the scroll steps to zero
	scrollStep = thisDownPage;
	//parallax to the current scroll step, not animating the transition
	parallaxTo(((scrollStep/maxScrollStep) * 100), false);
}