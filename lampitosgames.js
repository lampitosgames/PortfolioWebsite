var contentWidth = 1248;
var maxContentWidth = 1248;
var minMarginSize = 100;

//Display Box Variables
//Smallest display box is 15% of the content width
var displayBoxWidth = 1248 * 0.15;
var boxGridWidth = 0;
var displayMarginSize = 1248 * 0.02;

//An array that holds references to displayBox objects in the order they appear on screen
var boxGrid = new Array();

//The absolute minimum size for the small display box.  After this, the boxes will stop resizing and re-arrange.
//The boxes are initially 8 across.  At 1000, the boxes will shift to 6 across.  At 800, the site will shift into mobile mode and severely reduce margin size
var minDisplayBoxWidth = 150;

//Window width and height
var wWidth = 0;
var wHeight = 0;

//Dark or Light text to be used
colorMode = 1;

sidebarToggle = 0;

//Before anything else happens, initialize display box image background sizes
$(document).ready(function () {
    $(".displayBoxBackContent").each(function () {
        $(this).attr("w", 0);
        $(this).attr("h", 0);
    });
});

//Once all page content has loaded
$(window).on("load", function () {
    //Make all resize calculations
    resize();

    //After resize and all elements are done moving around, make the page visible
    $("html").css("visibility", "visible");
    //Loop through all elements that animate in and check if they are on the page
    $('.animIn').each(function () {
        checkAnimation($(this));
    });

    //Position the header hover line
    headerLineReset();


    /*
     * EVENT BINDING
     */
    //Bind mouse events to display box buttons
    $(".dBoxButtonText").mouseenter(function () {
        //On mouse enter, call the button enter function
        buttonEnter($(this).parent());
    }).mouseleave(function () {
        //On mouse leave, call the button leave function
        buttonLeave($(this).parent());
    }).mouseup(function () {
        //On a click, set the display box to active
        setDBActive($(this).parent());
    });

    //Bind mouse events to display boxes
    $(".displayBox").mouseleave(function () {
        //When the mouse leaves an active display box, make it inactive
        if ($(this).hasClass("active")) {
            setDBInactive($(this));
        }
        //When the mouse leaves a display box without a description, set it's link to inactive
        var bWrap = $(this).children(".dBoxButtonWrapper");
        if (bWrap.hasClass("linkActive")) {
            bWrap.removeClass("linkActive");
            $(this).children(".dBoxLink").children(".linkSpan").css({ "visibility": "hidden" });
            buttonLeave($(this).children(".dBoxButtonWrapper"));
        }
    }).mouseup(function () {
        //Make display boxes work like buttons on mobile
        if (window.mobilecheck()) {
            setDBActive($(this).children(".dBoxButtonWrapper"));
            if ($(this).children(".dBoxButtonWrapper").hasClass("linkActive")) {
                $(this).children(".dBoxLink").children(".linkSpan").css({ "visibility": "visible" });
            }
        }
    });

    //Social Media display boxes
    $(".socialMedia").mouseenter(function () {
        $(this).children(".dBoxLink").children(".socialLink").css({ "visibility": "visible" });
        //Zoom the background
        var boxW = parseInt($(this).width()) + 40;
        var boxH = parseInt($(this).height()) + 40;
        utils.fitContent($(this).children(".displayBoxBackground").children(".displayBoxBackContent"), boxW, boxH);
    }).mouseleave(function () {
        $(this).children(".dBoxLink").children(".socialLink").css({ "visibility": "hidden" });
        //Reset the background
        var boxW = parseInt($(this).width());
        var boxH = parseInt($(this).height());
        utils.fitContent($(this).children(".displayBoxBackground").children(".displayBoxBackContent"), boxW, boxH);
    });

    //Header links
    $(".headerLinkCell").mouseenter(function () {
        headerLineTo($(this));
    }).mouseleave(function () {
        headerLineReset();
    });

    //When the hamburger button is clicked
    $("#mobileHeaderButton").mouseup(function () {
        headerActivateSidebar();
    });
    $("#mobileSidebar").mouseleave(function () {
        headerActivateSidebar();
    });

    //Content Item Highlight animations
    $(".cIHItem").mouseenter(function () {
        cIHItemEnter($(this));
    }).mouseleave(function () {
        cIHItemLeave($(this));
    });

    //Set the copyright text
    var curDate = new Date()
    $('.copyright').replaceWith('<div class="copyright">Copyright © ' + curDate.getFullYear() + ' Daniel Timko</div>');
});

window.onresize = function () {
    if (window.mobilecheck() == false) {
        resize();
    }
};

$(window).scroll(function () {
    $('.animIn').each(function () {
        checkAnimation($(this));
    });
    //Scroll the header when the scroll distance reaches 30.  The header is transparent
    headerScroll(30, 0);
});

/**
 * Check if an animIn object should animate
 */
function checkAnimation(elem) {
    //If the element has already animated, do nothing
    if (elem.hasClass('start')) {
        return;
    }
    //If the element is in the view, begin css animation
    if (isElementInView(elem)) {
        elem.addClass('start');
    }
}
/**
 * Check if a DOM element is visible
 */
function isElementInView(elem) {
    //Get the scroll position of the page
    var scrollElem = ((navigator.userAgent.toLocaleLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewTop = $(scrollElem).scrollTop();
    var viewBottom = viewTop + wHeight;

    //Get the position of the element on the page
    var elemTop = Math.round(elem.offset().top);
    var elemBottom = elemTop + elem.height();

    return ((elemTop < viewBottom) && (elemBottom > viewTop));
}

/**
 * The function called on window resize.  It makes sure that everything works properly with the new dynamic window sizing
 */
function resize() {
    //Get the window size
    wWidth = $(window).width();
    wHeight = $(window).height();

    //Find a proper size for the margins
    //If the min margin size plus the max content width is still smaller than the window width
    if (2 * minMarginSize + maxContentWidth < wWidth) {
        //Make the margins equal, and set the content width to it's max
        var marginSize = 0.5 * (wWidth - maxContentWidth);
        contentWidth = maxContentWidth;
        $('.mainContent').css("margin-left", marginSize).css("margin-right", marginSize);
        $('.mainContent').css("width", maxContentWidth);

    //Else, the default-sized content box won't fit in the window.  Resize it.
    } else {
        $('.mainContent').css("margin-left", minMarginSize).css("margin-right", minMarginSize);
        //Get the width of the middle box
        contentWidth = wWidth - 2 * minMarginSize;
        $('.mainContent').css("width", contentWidth);
    }
	
    //Position the header
    $("#header").css("width", wWidth);
    headerResize();
    headerLineReset();
    headerScroll(40, 0);

    //Resize content elements
    cElemResize();

    //Resize and align the display boxes
    alignBoxes();

	//Fix display box inner proportions
    $(".displayBoxBackContent").each(function () {
        //Get the box width and height
        var boxW = $(this).parent().parent().width();
        var boxH = $(this).parent().parent().height();

        utils.fitContent($(this), boxW, boxH);
    });

    //Re-format box descriptions
    $(".dBoxDescription").each(function () {
        //Position the display box description
        var boxH = $(this).parent().height();
        //Set the top position of the description to off-screen
        $(this).css("top", boxH);
    });

    /*
        Position the buttons properly
    */
    buttonResize(colorMode);
}

/**
 * Set a display box to active, animate the description
 */
function setDBActive(button) {
    button.addClass("active");
    var activeDisplayBox = button.parent();
    var activeDBDesc = activeDisplayBox.children(".dBoxDescription");
    activeDisplayBox.addClass("active");

    //If the display box has a description
    if (activeDBDesc.length > 0) {
        //Set the link to visible
        activeDisplayBox.children(".dBoxLink").children(".linkSpan").css({ "visibility": "visible" });

        //Active positioning
        var topDescMargin = parseInt(activeDisplayBox.height()) * 0.45;
        var topButtonMargin = (topDescMargin / 4) - (button.height() / 2);

        button.stop().animate({ "top": topButtonMargin }, 300);
        //Animate button children elements so the button becomes a title
        var leftLine = button.children(".dBoxButtonWLine5").children(".dBBHWLineLL");
        var rightLine = button.children(".dBoxButtonWLine3").children(".dBBHWLineRR");
        var text = button.children(".dBoxButtonText").children("span");
        var bottomLLine = button.children(".dBoxButtonWLine4").children(".dBBHWLineBL");
        var bottomRLine = button.children(".dBoxButtonWLine4").children(".dBBHWLineBR");
        //Set the opacity of all white line backgrounds to zero:
        button.children(".dBoxButtonWLine1").css("background-color", "rgba(255, 255, 255, 0)");
        button.children(".dBoxButtonWLine2").css("background-color", "rgba(255, 255, 255, 0)");
        button.children(".dBoxButtonWLine3").css("background-color", "rgba(255, 255, 255, 0)");
        button.children(".dBoxButtonWLine4").css("background-color", "rgba(255, 255, 255, 0)");
        button.children(".dBoxButtonWLine5").css("background-color", "rgba(255, 255, 255, 0)");
        //Animate the actual opacity of the top red line to zero
        button.children(".dBoxButtonRLine").stop().animate({ "opacity": 0 }, 300);
        //Animate the side red lines down
        leftLine.stop().animate({ "top": leftLine.height() }, 300);
        rightLine.stop().animate({ "top": rightLine.height() }, 300);

        //Animate the text down by a small margin
        text.stop().animate({ "top": text.parent().height() - (text.height() + 5) }, 300);

        //Animate the bottom red lines to fit as a text underline
        bottomLLine.stop().animate({ "left": text.css("left") });
        bottomRLine.stop().animate({ "left": parseInt(bottomRLine.parent().width()) / 2 - parseInt(text.css("left")) });

        activeDBDesc.stop().animate({ "top": topDescMargin }, 300);

        //Zoom in with 20 pixel margins
        var activeDBBack = activeDisplayBox.children(".displayBoxBackground");
        var boxW = activeDisplayBox.width() + 40;
        var boxH = activeDisplayBox.height() + 40;
        utils.fitContent(activeDBBack.children(".displayBoxBackContent"), boxW, boxH);

        //Else, there is no description
    } else {
        button.removeClass("active");
        //Set the button to active link.  This is only for mobile purposes.  Link forewarding is handled mostly by mouse move events.
        buttonEnter(button);
    }
}

/**
 * Set a display box to inactive and reset it's CSS
 */
function setDBInactive(curDisplayBox) {
    curDisplayBox.removeClass("active");

    var curButton = curDisplayBox.children(".dBoxButtonWrapper");
    curButton.removeClass("active");

    var activeDBDesc = curDisplayBox.children(".dBoxDescription");

    //If there is a description
    if (activeDBDesc.length > 0) {
        //Set the link to invisible
        curDisplayBox.children(".dBoxLink").children(".linkSpan").css({ "visibility": "hidden" });

        var topButtonMargin = (parseInt(curDisplayBox.height()) - parseInt(curButton.height())) / 2;
        curButton.stop().animate({ "top": topButtonMargin }, 300);

        //Reset the title to become a button again
        var leftLine = curButton.children(".dBoxButtonWLine5").children(".dBBHWLineLL");
        var rightLine = curButton.children(".dBoxButtonWLine3").children(".dBBHWLineRR");
        var text = curButton.children(".dBoxButtonText").children("span");
        var bottomLLine = curButton.children(".dBoxButtonWLine4").children(".dBBHWLineBL");
        var bottomRLine = curButton.children(".dBoxButtonWLine4").children(".dBBHWLineBR");
        //Animate the bottom red lines to fit as a text underline
        bottomLLine.stop().animate({ "left": 0 }, 150);
        bottomRLine.stop().animate({ "left": parseInt(bottomRLine.parent().width()) / 2 }, 150);
        //Animate the side red lines up
        leftLine.stop().animate({ "top": 0 }, 150);
        rightLine.stop().animate({ "top": 0 }, 150);
        //Animate the opacity of the red line back to 100%
        setTimeout(function () {
            curButton.children(".dBoxButtonRLine").stop().animate({ "opacity": 100 }, 150);
        }, 150);
        //Set the text back to its original location
        text.stop().animate({ "top": parseInt(text.parent().height()) / 2 - parseInt(text.css("font-size")) / 1.5 }, 300);
        setTimeout(function () {
            //Fix the white line border opacity
            curButton.children(".dBoxButtonWLine1").css("background-color", "#fcfcfc");
            curButton.children(".dBoxButtonWLine2").css("background-color", "#fcfcfc");
            curButton.children(".dBoxButtonWLine3").css("background-color", "#fcfcfc");
            curButton.children(".dBoxButtonWLine4").css("background-color", "#fcfcfc");
            curButton.children(".dBoxButtonWLine5").css("background-color", "#fcfcfc");

            buttonLeave(curDisplayBox.children(".dBoxButtonWrapper"));
        }, 200);

        activeDBDesc.stop().animate({ "top": parseInt(curDisplayBox.height()) }, 300);

        //Zoom to normal
        var activeDBBack = curDisplayBox.children(".displayBoxBackground");
        var boxW = curDisplayBox.width();
        var boxH = curDisplayBox.height();
        utils.fitContent(activeDBBack.children(".displayBoxBackContent"), boxW, boxH);
    }
}

/**
 * Get a 2d region of a parent 2d array
 */
function GetRegion(x, y, areaWidth, areaHeight) {
    if (y+areaHeight > boxGrid.length || x+areaWidth > boxGrid[0].length) {
        return null;
    }
    var newGrid = new Array(areaHeight);
    for (var o=0; o<newGrid.length; o++) {
        newGrid[o] = new Array(areaWidth);
    }

    for (var h = 0; h < newGrid.length; h++) {
        for (var w = 0; w < newGrid[h].length; w++) {
            newGrid[h][w] = boxGrid[y+h][x+w];
        }
    }
    return newGrid;
}