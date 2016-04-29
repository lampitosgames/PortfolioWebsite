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
 * Align all display boxes in a visually-appealing manner
 */
function alignBoxes() {
    var nBoxGridWidth;
    //Determine the width of the display box grid
    if (contentWidth >= 1000) {
        nBoxGridWidth = 8;
        displayBoxWidth = contentWidth * 0.1075;
        displayMarginSize = contentWidth * 0.02;
    } else if (contentWidth >= 800 && window.mobilecheck() == false) {
        nBoxGridWidth = 6;
        displayBoxWidth = contentWidth * 0.1416;
        displayMarginSize = contentWidth * 0.03;
    } else {
        nBoxGridWidth = 4;
        displayBoxWidth = contentWidth * 0.2163;
        displayMarginSize = contentWidth * 0.045;
    }

    //The window was resized. Is the new box grid width different from the old?
    if (nBoxGridWidth != boxGridWidth) {
        //Set the grid width
        boxGridWidth = nBoxGridWidth;

        //Create the grid.
        //Default grid height of 1.  The size gets dynamically increased
        boxGrid = new Array();
        boxGrid.push(new Array(boxGridWidth))
        for (var j = 0; j < boxGrid[0].length; j++) {
            boxGrid[0][j] = -1;
        }

        /*
            Get the focus boxes
        */
        //An array of the largest, most 'important' boxes that will draw the user's focus
        var focusBoxes = new Array();
        //Get all focus boxes
        $('.focusBox').each(function () {
            //Create an array to represent this display box
            //0 = reference, 1 = width, 2 = height, 3 = priority
            var focusBoxArray = new Array();
            focusBoxArray.push($(this));

            //Get the rest of the box parameters based on it's class names
            $(this).classes(function (c) {
                if (/db[0-9]x[0-9]/.exec(c) != null) {
                    focusBoxArray.push(parseInt(/[0-9](?=x)/.exec(c)));
                    focusBoxArray.push(parseInt(/[0-9]$/.exec(c)));
                } else if (/importance[0-9]/.exec(c) != null) {
                    focusBoxArray.push(parseInt(/[0-9]$/.exec(c)));
                }
            });
            focusBoxes.push(focusBoxArray);
        });
        //Insertion sort the focus boxes by order of priority
        for (var j = 0; j < focusBoxes.length - 1; j++) {
            for (var k = j; (k >= 1) && (focusBoxes[j][3] < focusBoxes[k - 1][3]); k--) {
                var tempItem = focusBoxes[k];
                focusBoxes[k] = focusBoxes[k - 1];
                focusBoxes[k - 1] = tempItem;
            }
        }

        //Place the focus boxes into the box grid
        for (var i = 0; i < focusBoxes.length; i++) {
            //Box to place
            var thisBox = focusBoxes[i];

            //Position to place in
            var placeX = 0;
            var placeY = 0;

            var dissimilarCoordinates, doubleAdjacency;

            //A valid location is one that doesn't share an x or y value with any other box, or one that is 2 spaces separated from other boxes in coordinate directions
            //Loop through positions in the box grid until a valid location is found
            for (var h = 0; h < boxGrid.length; h++) {
                for (var w = 0; w < boxGrid[h].length; w++) {
                    //If the location satisfies either of these properties, it can be placed
                    //The location has dissimilar coordinates until proven otherwise.  This means that it doesn't have the same x or the same y as any other element
                    dissimilarCoordinates = false;
                    //The location has false double adjacency until proven otherwise.  This means that there are at least 2 blocks in all 4 directions.  Does not calculate for diagonal
                    doubleAdjacency = false;

                    //Save this location
                    placeX = w;
                    placeY = h;

                    //If this place plus the height is too big for the box grid, expand the box grid
                    while (h + thisBox[2] > boxGrid.length) {
                        boxGrid.push(new Array(boxGridWidth))
                        for (var j = 0; j < boxGridWidth; j++) {
                            boxGrid[boxGrid.length-1][j] = -1;
                        }
                    }
                    
                    /*
                        The first check is to make sure that this box doesn't collide with other boxes at the current location
                    */
                    var lCollision = false;
                    //Get the subgrid where this item would be placed
                    var subGrid = GetRegion(w, h, thisBox[1], thisBox[2]);
                    //If the subgrid isn't oob
                    if (subGrid != null) {
                        //Loop through the subgrid, make sure it is all -1's
                        for (var sy = 0; sy < subGrid.length; sy++) {
                            for (var sx = 0; sx < subGrid[sy].length; sx++) {
                                if (subGrid[sy][sx] instanceof Array || subGrid[sy][sx] == 1) {
                                    lCollision = true;
                                }
                            }
                        }
                    //The subgrid is oob, this isn't a valid location
                    } else { continue; }
                    //If a collision was found, this isn't a valid location
                    if (lCollision == true) { continue; }

                    /*
                        The second check is to detect dissimilar coordinates.  If there is another box reference on the current row, or another box reference in the current column above
                        this location, then the variable dissimilarCoordinates is invalid
                    */
                    //True until proven otherwise
                    dissimilarCoordinates = true;
                    //Loop over the current row and check for references.  (A reference has a value of not -1 and not 1)
                    for (var curRow = 0; curRow < boxGrid[h].length; curRow++) {
                        //If any of the positions has a value other than -1 and 1, there is a reference
                        if (boxGrid[h][curRow] instanceof Array) {
                            dissimilarCoordinates = false;
                            break;
                        }
                    }
                    //Loop through rows above this one and check the current x position
                    //Check a maximum of 6 rows up
                    var iterCount = 0;
                    for (var colNum = h; colNum >= 0; colNum--) {
                        iterCount++;
                        //If any of the positions has a value other than -1 and 1, there is a reference
                        if (boxGrid[colNum][w] instanceof Array) {
                            dissimilarCoordinates = false;
                            break;
                        }
                        if (iterCount == 6) {
                            break;
                        }
                    }
                    //If dissimilarCoordinates is already fulfilled, there is no need to continue
                    if (dissimilarCoordinates) { break; }

                    /*
                        The third check is to detect double adjacency.  If there are two spaces above and to both sides of the location for this box, it is a valid placement
                    */
                    //True until proven otherwise
                    doubleAdjacency = true;
                    //Loop through the width of the box
                    for (var checkCol = w; checkCol < w + thisBox[1]; checkCol++) {
                        //Check if there is a row above this one
                        if (h - 1 >= 0) {
                            //Check two above
                            if (boxGrid[h - 1][checkCol] instanceof Array || boxGrid[h-1][checkCol] == 1) {
                                doubleAdjacency = false;
                                break;
                            }
                            //Check if there is a row two above this one
                            if (h - 2 >= 0) {
                                if (boxGrid[h - 2][checkCol] instanceof Array || boxGrid[h - 2][checkCol] == 1) {
                                    doubleAdjacency = false;
                                    break;
                                }
                            }
                        }
                    }
                    //Loop through the height of the box and check to either side
                    for (var checkRow = h; checkRow < h + thisBox[2]; checkRow++) {
                        //If there is a row to the left
                        if (w - 1 >= 0) {
                            //Check to the left
                            if (boxGrid[checkRow][w-1] instanceof Array || boxGrid[checkRow][w-1] == 1) {
                                doubleAdjacency = false;
                                break;
                            }
                            //If there is a row two to the left
                            if (w - 2 >= 0) {
                                if (boxGrid[checkRow][w - 2] instanceof Array || boxGrid[checkRow][w - 2] == 1) {
                                    doubleAdjacency = false;
                                    break;
                                }
                            }
                        }
                        //If there is a row to the right
                        if (w + thisBox[1] + 1 < boxGrid[h].length) {
                            //Check to the right
                            if (boxGrid[checkRow][w + thisBox[1] + 1] instanceof Array || boxGrid[checkRow][w + thisBox[1] + 1] == 1) {
                                doubleAdjacency = false;
                                break;
                            }
                            //If there is a row two to the right
                            if (w + thisBox[1] + 2 < boxGrid[h].length) {
                                if (boxGrid[checkRow][w + thisBox[1] + 2] instanceof Array || boxGrid[checkRow][w + thisBox[1] + 2] == 1) {
                                    doubleAdjacency = false;
                                    break;
                                }
                            }
                        }
                    }
                    if (doubleAdjacency) { break;}
                }
                //If either check was found to be valid, this is a valid placement location
                if (dissimilarCoordinates || doubleAdjacency) { break; }
            }

            //A position was found.  Place this box
            //Loop through the box grid, setting the bounds for this box to 1
            for (var h = placeY; h < placeY + thisBox[2]; h++) {
                for (var w = placeX; w < placeX + thisBox[1]; w++) {
                    boxGrid[h][w] = 1;
                }
            }
            boxGrid[placeY][placeX] = thisBox;
        }


        /*
            Get the filler boxes
        */
        //An array of the smaller boxes that fill in the gaps
        var fillerBoxes = new Array();
        //Get all filler boxes
        $('.fillerBox').each(function () {
            //Create an array to represent this display box
            //0 = reference, 1 = width, 2 = height, 3 = priority
            var fillerBoxArray = new Array();
            fillerBoxArray.push($(this));

            //Get the rest of the box parameters based on it's class names
            $(this).classes(function (c) {
                if (/db[0-9]x[0-9]/.exec(c) != null) {
                    fillerBoxArray.push(parseInt(/[0-9](?=x)/.exec(c)));
                    fillerBoxArray.push(parseInt(/[0-9]$/.exec(c)));
                } else if (/importance[0-9]/.exec(c) != null) {
                    fillerBoxArray.push(parseInt(/[0-9]$/.exec(c)));
                }
            });
            fillerBoxes.push(fillerBoxArray);
        });
        //Insertion sort the focus boxes by order of priority
        for (var j = 0; j < fillerBoxes.length - 1; j++) {
            for (var k = j; (k >= 1) && (fillerBoxes[j][3] < fillerBoxes[k - 1][3]) ; k--) {
                var tempItem = fillerBoxes[k];
                fillerBoxes[k] = fillerBoxes[k - 1];
                fillerBoxes[k - 1] = tempItem;
            }
        }

        //Place the filler boxes
        for (var i = 0; i < fillerBoxes.length; i++) {
            var thisBox = fillerBoxes[i];

            //Position to place in
            var placeX = 0;
            var placeY = 0;

            //Filler boxes go in any empty space that they fit in.  The goal is to fill out the entire grid as much as possible
            for (var h = 0; h < boxGrid.length; h++) {
                var lCollision;
                for (var w = 0; w < boxGrid[h].length; w++) {
                    //Collision initially is false
                    lCollision = false;
                    //Save this location
                    placeX = w;
                    placeY = h;

                    //If this place plus the height is too big for the box grid, expand the box grid
                    while (h + thisBox[2] > boxGrid.length) {
                        boxGrid.push(new Array(boxGridWidth))
                        for (var j = 0; j < boxGridWidth; j++) {
                            boxGrid[boxGrid.length - 1][j] = -1;
                        }
                    }

                    /*
                        Check is to make sure that this box doesn't collide with other boxes at the current location
                    */
                    for (var bh = h; bh < h + thisBox[2]; bh++) {
                        for (var bw = w; bw < w + thisBox[1]; bw++) {
                            //If the width position is oob
                            if (bw > boxGrid[bh].length - 1) {
                                lCollision = true;
                                continue;
                            }
                            if (boxGrid[bh][bw] instanceof Array || boxGrid[bh][bw] == 1) {
                                lCollision = true;
                            }
                        }
                    }
                    //If a collision was found, this isn't a valid location
                    if (lCollision == true) { continue; } else { break; }
                }
                if (lCollision == true) { continue; } else { break; }
            }

            //A position was found.  Place this box
            //Loop through the box grid, setting the bounds for this box to 1
            for (var h = placeY; h < placeY + thisBox[2]; h++) {
                for (var w = placeX; w < placeX + thisBox[1]; w++) {
                    boxGrid[h][w] = 1;
                }
            }
            boxGrid[placeY][placeX] = thisBox;
        }
    }

    //Resize the boxes in the boxGrid
    //Loop through the boxGrid
    for (var h = 0; h < boxGrid.length; h++) {
        for (var w = 0; w < boxGrid[h].length; w++) {
            //If this location is an array, that means it is a displaybox
            if (boxGrid[h][w] instanceof Array) {
                var curDisplayBox = boxGrid[h][w][0];
                var boxW = boxGrid[h][w][1];
                var boxH = boxGrid[h][w][2];

                //Set the position of the display box
                curDisplayBox.css("top", h * displayBoxWidth + h * displayMarginSize);
                curDisplayBox.css("left", w * displayBoxWidth + w * displayMarginSize);
                curDisplayBox.css("width", boxW*displayBoxWidth + (boxW-1)*displayMarginSize);
                curDisplayBox.css("height", boxH * displayBoxWidth + (boxH - 1) * displayMarginSize);

                //Get the description boxes
                var description = curDisplayBox.children(".dBoxDescription");
                var descTitle = description.children(".dBoxDescTitle");
                var descBody = description.children(".dBoxDescBody");
                if (description.length > 0) {
                    //If the width/height of the display box are both >= 3
                    if (boxW >= 3 && boxH >= 3) {
                        //Set the font for the description to a fixed value
                        descTitle.css("font-size", "20px");
                        descBody.css("font-size", "18px");
                        //Else, change the font size to fit the box
                    } else {
                        var titleSize = 0.02866 * (parseInt(curDisplayBox.width()) + parseInt(curDisplayBox.height()));
                        var descSize = 0.02548 * (parseInt(curDisplayBox.width()) + parseInt(curDisplayBox.height()));
                        descTitle.css("font-size", (titleSize < 18 ? titleSize : 18) + "px");
                        descBody.css("font-size", (descSize < 16 ? descSize : 16) + "px");
                    }
                }
            }
        }
    }
    //Set the display body height
    $("#displayBody").css("height", boxGrid.length * displayBoxWidth + boxGrid.length * displayMarginSize);
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