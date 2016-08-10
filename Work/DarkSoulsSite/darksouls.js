/* Main Homepage Code */
/** COPYRIGHT DANIEL TIMKO 2015 **/

//track whether or not the sidebar currently holds focus (Focus can be acquired by rolling over the top-left hamburger button with the mouse pointer)
var sidebarFocus = false;

//store the old window height to be used on resize
var oldWindowHeight;

//when the page is loaded
$(window).load(function() {
	//set the height of the main content pane to be the height of the article wrapper plus the margin
	$(".mainContentPane").css('height', parseInt($(window).height()) + parseInt($(".mainContentPane").css('height')) + 'px');
	//store the initial window height
	oldWindowHeight = $(window).height();
	
	//call the resize function to calculate the correct sizes for elements on the page
	resize();
	//call the parallax reset function to prepare currently loaded parallaxing elements
	resetParallax(0);
	
	//Disable middle mouse button scrolling as it breaks parallax and custom scrolling code
	$(window).mousedown(function(e) {
		if (e.button == 1) {
			return false;
		}
	});
	
	//since the css 'pointer-events' property doesn't validate, work around that and add it via javascript
	//this is very hacky and unessasary since all browsers except opera mobile support this CSS tag, but the website needs
	//to validate, soo...
	$(".topLinkLine").css('pointer-events', 'none');
	$(".bottomLinkLine").css('pointer-events', 'none');
	$(".leftLinkLine").css('pointer-events', 'none');
	$(".rightLinkLine").css('pointer-events', 'none');
	$(".imageLinkTitle").css('pointer-events', 'none');
	$(".topButtonWrapper").css('pointer-events', 'all');
	//same deal here.  ::selection tag doesn't validate even though it is valid on all browsers.
	$("head").append("<style> ::selection {color: #F0F0F0; background: #AD382B;} ::-moz-selection {color: #F0F0F0; background: #AD382B;}</style>")
	
	//animate the sidebar on page load so that the user knows links are there
	//Show the sidebar's background
	$("#navbarBackground").css('left', '0px');
	//animate the links into frame
	$(".linkWrapper").css('left', '100px');
	//enable pointer events for the sidebar
	$('#navbar').css('pointer-events', 'all');
	//loop through each highlight link.  By animating for both inactive and active states on all links, everything will animate correctly
	$(".link").each(function() {
		//animate this link's properties if it is active
		$(this).children(".linkTextActive").css('opacity', '1.0');
		$(this).children(".linkTextActive").css('left', '-10px');
		$(this).children(".linkLineActive").css('width', '176px');
		$(this).children(".linkLineActive").css('left', '100px');
		$(this).children(".linkCircleActive").css('background-color', 'rgba(250, 250, 250, 1)');
	});
	
	//close the sidebar after 2 seconds asynchronously
	setTimeout(function(){
		//animate the sidebar's background to out of frame
		$("#navbarBackground").css('left', '400px');
		//animate the links out of frame
		$(".linkWrapper").css('left', '500px');
		//disable pointer events for the sidebar
		$('#navbar').css('pointer-events', 'none');
	}, 750);
	
	//when the mousewheel moves, check the event delta (scroll direction), and pass the direction to the scroll() function
	$(window).mousewheel(function(event, delta) {
		//if the direction of the delta is down
		if (delta < 0) {
			//call the scroll function with the down boolean (false)
			scroll(false);
		//else, the direction of the delta is up
		} else {
			//call the scroll function with the up boolean (true)
			scroll(true);
		}
		//don't do any normal mouse scroll actions
		return false;
	
	//when a key is pressed, handle custom scrolling code
	}).keydown(function(e) {
		//use a switch statement to determine which key was pressed (using the keycode)
		switch (e.keyCode) {
			//up directional button was pressed
			case 38:
				//call the scroll function with the up boolean (true)
				scroll(true);
				break;
			//down directional button was pressed
			case 40:
				//call the scroll function with the down boolean (false)
				scroll(false);
				break;
			//spacebar button was pressed
			case 32:
				//call the scroll function with the down boolean (false)
				scroll(false);
				break;
			//any other key was pressed
			default:
				//do nothing
				break;
		}
	});
	
	//when the mouse pointer enters the hamburger button
	$(".hamburgerButton").mouseenter(function() {
		//animate in the sidebar's background (again, the css contains the animation parameters, so .animate() isn't needed)
		$("#navbarBackground").css('left', '0px');
		//animate the links into frame
		$(".linkWrapper").css('left', '100px');
		//enable pointer events for the sidebar
		$('#navbar').css('pointer-events', 'all');
		
		//loop through each highlight link.  By animating for both inactive and active states on all links, everything will animate correctly
		$(".link").each(function() {
			//animate this link's properties if it is active
			$(this).children(".linkTextActive").css('opacity', '1.0');
			$(this).children(".linkTextActive").css('left', '-10px');
			$(this).children(".linkLineActive").css('width', '176px');
			$(this).children(".linkLineActive").css('left', '100px');
			$(this).children(".linkCircleActive").css('background-color', 'rgba(250, 250, 250, 1)');
		});
	});
	
	//when the mouse pointer leaves the sidebar
	$("#navbar").mouseleave(function() {
		//animate the sidebar's background to out of frame
		$("#navbarBackground").css('left', '400px');
		//animate the links out of frame
		$(".linkWrapper").css('left', '500px');
		//disable pointer events for the sidebar
		$('#navbar').css('pointer-events', 'none');
	});
	
	//on the mouseenter event for all sidebar links...
	$(".link").mouseenter(function() {
		//all the links have two states: Active or inactive.  If we pretend a link is both, the correct properties will change
		//animate all of this link's settings if it isn't active
		$(this).children(".linkText").css('opacity', '1.0');
		$(this).children(".linkText").css('left', '-6px');
		$(this).children(".linkLine").css('width', '176px').css('left', '96px');
		$(this).children(".linkCircle").css('background-color', 'rgba(250, 250, 250, 1)');
		//animate all of this link's settings if it IS active
		$(this).children(".linkTextActive").css('left', '-20px');
		$(this).children(".linkLineActive").css('width', '246px').css('left', '30px');
	//on the mouseleave event for all sidebar links...
	}).mouseleave(function() {
		//animate all of this link's settings if it isn't active
		$(this).children(".linkText").css('opacity', '0.8');
		$(this).children(".linkText").css('left', '0px');
		$(this).children(".linkLine").css('width', '8px').css('left', '264px');
		$(this).children(".linkCircle").css('background-color', 'rgba(250, 250, 250, 0)');
		//animate all of this link's settings if it IS active
		$(this).children(".linkTextActive").css('left', '-10px');
		$(this).children(".linkLineActive").css('width', '176px').css('left', '100px');
		$(this).children(".linkCircleActive").css('background-color', 'rgba(250, 250, 250, 1)');
	});
});

//when the window is resized
$(window).resize(function() {
	//call the resize function
	resize();
});

//resize function.  Handles variable sizing while the page is loaded (people resize the page, because they are just mean like that)
function resize() {
	//pass long-winded references to easy-to-use variables
	//get the window height/width
	var width = $(window).width();
	var height = $(window).height();
	//get all highlight background images
	var image = $(".backImageWrapper");
	
	var newSize = $(".mainContentPane").css('height') - oldWindowHeight + height;
	//set the height of the main content pane to be the height of the article wrapper plus the margin
	$(".mainContentPane").css('height', newSize);
	
	//move the sidebar images
	$(".titleImage").each(function() {
		var thisWidth = parseInt($(this).width());
		$(this).css('left', -thisWidth + parseInt($(this).parent().width())+ 'px');
	});
	
	//move the navbar to the right side of the page
	$("#navbar").css('left', (width - 400) + 'px');
	//move the navbar's background to the right side of the page, just out of view
	$("#navbarBackground").css('left', '400px');
	//move the navbar's links to the right side of the page, just out of view
	$(".linkWrapper").css('left', (width + 100) + 'px');
	
	//resize image links
	//get image width
	$(".imageLink").each(function() {
		var parWidth = $(".imageLinkCell").width();
		var width = $(this).width();
		$(this).css('left', (width - parWidth)/-2 + 'px');
	});
	
	//Based on ratios, resize the background image to fill the entire screen.  All images are 1920x1200 pixels
	//if the image is too tall...
	if (width / height > 1.6) {
		//keep the width
		image.css('width', width + 'px');
		//set the height to the correct value based on the width
		image.css('height', width/1.6 + 'px');
		image.css('left', '0px');
	//or, if the image is too wide...
	} else if (width / height < 1.6) {
		//set the width to the correct value based on the height
		image.css('width', height*1.6 + 'px');
		//keep the height
		image.css('height', height + 'px');
		//center the image
		image.css('left', ((width - height*1.6) / 2) + 'px');
	//or, if the image is good as-is
	} else {
		//keep both the width
		image.css('width', width + 'px');
		//and the height
		image.css('height', height + 'px');
	}
	
	//Move the scrollbar to the right edge of the page (the scrollbar is 10 pixels wide)
	$("#scrollBarWrapper").css('height', height).css('left', width-10);
	//set the dimensions of the scrollbar (should be 1/6th the height of the page)
	$('#scrollBar').css('height', height/6);
	
	//Update parallax
	//Determine the percentage distance down the page
	var downPage = utils.clamp(scrollStep, minScrollStep, maxScrollStep);
	//if parallax is on
	resetParallax(downPage);
}