var contentWidth = 1248;
var maxContentWidth = 1248;
var minMarginSize = 100;

//Window width and height
var wWidth = 0;
var wHeight = 0;

//Scroll values
scrollElem = null;
viewTop = 0;

//Dark or Light text to be used
colorMode = 1;

sidebarToggle = 0;

//Before anything else happens, initialize display box image background sizes
$(document).ready(function () {
    $("img").each(function () {
        $(this).attr("w", 0);
        $(this).attr("h", 0);
    });
    $("iframe").each(function () {
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
    headerScroll(30, colorMode);

    //Set the text color of the floating title based on the color mode
    if (colorMode == 0) {
        $(".pageTitleTextBox").css("color", "#444444");
        $(".dBoxButtonText").css("color", "#444444");
    } else if (colorMode == 1) {
        $(".pageTitleTextBox").css("color", "#fcfcfc");
    }

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
    });

    //Header links
    $(".headerLinkCell").mouseenter(function () {
        headerLineTo($(this));
    }).mouseleave(function () {
        headerLineReset();
    });

    //Content Item Highlight animations
    $(".cIHItem").mouseenter(function () {
        cIHItemEnter($(this));
    }).mouseleave(function () {
        cIHItemLeave($(this));
    });

    //On a read more click, scroll to the article body
    $("#readMore").mouseup(function () {
        $('html, body').stop().animate({
            scrollTop: $("#readMoreTarget").offset().top
        }, 1000, 'easeInOutCubic');
    });

    //When the hamburger button is clicked
    $("#mobileHeaderButton").mouseup(function () {
        headerActivateSidebar();
    });
    $("#mobileSidebar").mouseleave(function () {
        headerActivateSidebar();
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
    //Get the scroll position of the page
    scrollElem = ((navigator.userAgent.toLocaleLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    viewTop = $(scrollElem).scrollTop();

    $('.animIn').each(function () {
        checkAnimation($(this));
    });
    headerScroll(30, colorMode);

    //Parallax the title box
    $(".pageFloatingTitleBox").css({
        "top": (wHeight - $(".pageFloatingTitleBox").height()) * 0.5 - viewTop/2.5
    });
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
    headerScroll(40, colorMode);

    //Position the page title box
    $(".pageFloatingTitleBox").css({
        "left": (wWidth - $(".pageFloatingTitleBox").width()) * 0.5,
        "top": (wHeight - $(".pageFloatingTitleBox").height()) * 0.5
    });

    //Animate the title decorations
    var titleWidth = $(".pageTitleText").children("span").width();
    $(".pTLine").each(function () {
        $(this).css({ "margin-left": $(".pageTitleText").width() * 0.5, "width": "0px" });
        $(this).stop().animate({
            "width": titleWidth - 60,
            "margin-left": ($(".pageTitleText").width() - $(".pageTitleText").children("span").width()) * 0.5 + 30
        }, 3000, 'easeOutCubic');
    });
    $(".titleButtons").css({ "left": ($(".pageFloatingTitleBox").width() - $(".titleButtons").width()) * 0.5 });
     

    //Resize the background image
    utils.fitContent($(".pageIHContent"), wWidth + 100, wHeight + 100);

    //Resize buttons
    buttonResize(colorMode);
    $("#readMore").css({
        "top": "auto",
        "bottom": "0px",
        "left": "0px",
        "position": "absolute"
    });
    $("#viewCode").css({
        "top": "auto",
        "bottom": "0px",
        "right": "0px",
        "left": "auto",
        "position": "absolute"
    })

    //Resize content elements
    cElemResize();
}

$.easing.jswing = $.easing.swing;

$.extend($.easing,
{
    def: 'easeOutQuad',
    easeOutCubic: function (x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t + 1) + b;
    },
    easeInOutCubic: function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    }
});