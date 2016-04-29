
/**
 * When the mouse enters a display box button
 */
function buttonEnter(button) {
    if (!button.hasClass("active")) {
        //Get the top red line and animate it
        var topRed = button.children('.dBoxButtonRLine').children('.dBBHRLine');
        var leftPos = parseInt(button.children('.dBoxButtonRLine').css('left')) - parseInt(button.children('.dBoxButtonWLine1').css('left'));
        var topWidth = parseInt(button.children('.dBoxButtonWLine2').css('left')) + parseInt(button.children('.dBoxButtonWLine2').css("width")) - parseInt(button.children('.dBoxButtonWLine1').css('left'));
        leftPos *= -1;
        topRed.css({ "left": leftPos, "width": topWidth });

        //Get the left red line and animate it on a slight timing delay
        var leftRed = button.children('.dBoxButtonWLine5').children('.dBBHWLineLL');
        //set the top position to zero
        setTimeout(function () {
            leftRed.css({ "top": 0 });
        }, 75);

        //Get the right red line and animate it on a slight timing delay
        var rightRed = button.children('.dBoxButtonWLine3').children('.dBBHWLineRR');
        //Set the top position to zero
        setTimeout(function () {
            rightRed.css({ "top": 0 });
        }, 75);

        //Get the bottom lines and animate them on an even larger timing delay
        var bottomLeftRed = button.children('.dBoxButtonWLine4').children('.dBBHWLineBL');
        var bottomRightRed = button.children('.dBoxButtonWLine4').children('.dBBHWLineBR');
        setTimeout(function () {
            bottomLeftRed.css({ "left": 1 });
            bottomRightRed.css({ "left": parseInt(bottomRightRed.css('width')) });
        }, 100);

        //If this dBox has no description, set the DBox link to active
        var parentDBox = button.parent();
        if (parentDBox.children(".dBoxDescription").length == 0 && parentDBox.hasClass("displayBox")) {
            parentDBox.children(".dBoxLink").children(".linkSpan").css({ "visibility": "visible" });
            //The link is active.  Don't animate out on mouse leave
            button.addClass("linkActive");
        }
    }
}

/**
 * When the mouse leaves a display box button
 */
function buttonLeave(button) {
    if (!button.hasClass("active") && !button.hasClass("linkActive")) {
        setTimeout(function () {
            //Get the bottom lines and animate them
            var bottomLeftRed = button.children('.dBoxButtonWLine4').children('.dBBHWLineBL');
            var bottomRightRed = button.children('.dBoxButtonWLine4').children('.dBBHWLineBR');
            bottomLeftRed.css({ "left": -1 * parseInt(bottomLeftRed.css("width")) });
            bottomRightRed.css({ "left": parseInt(bottomRightRed.parent().css('width')) });

            //Get the left red line and animate it on a slight timing delay
            var leftRed = button.children('.dBoxButtonWLine5').children('.dBBHWLineLL');
            //set the top position to zero
            setTimeout(function () {
                leftRed.css({ "top": -1 * parseInt(leftRed.css("height")) });
            }, 75);

            //Get the right red line and animate it on a slight timing delay
            var rightRed = button.children('.dBoxButtonWLine3').children('.dBBHWLineRR');
            //Set the top position to zero
            setTimeout(function () {
                rightRed.css({ "top": -1 * parseInt(rightRed.css("height")) });
            }, 75);

            //Get the top red line and animate it
            var topRed = button.children('.dBoxButtonRLine').children('.dBBHRLine');
            var topWidth = parseInt(button.children('.dBoxButtonRLine').css('width'));
            setTimeout(function () {
                topRed.css({ "left": 0, "width": topWidth });
            }, 100);
        }, 100);
    }
}

function buttonResize(colorMode) {
    var buttonColor = colorMode == 0 ? "#444444" : "#fcfcfc";
    //Focus Buttons
    $(".dBoxButtonWrapper").each(function () {
        if ($(this).hasClass("inlineViewButton")) {
            buttonColor = "#444444";
        }
        //Set this object and the parent element to inactive
        $(this).removeClass("active");
        $(this).parent().removeClass("active");
        //Get the square size for calculating button values
        var bSize = 0;
        if ($(this).parent().hasClass("displayBox")) {
            bSize = 200 < (displayBoxWidth * 2 + displayMarginSize) * 0.70 ? 200 : (displayBoxWidth * 2 + displayMarginSize) * 0.70;
        } else {
            if ($(this).parent().hasClass("customButtonSize")) {
                bSize = parseInt($(this).parent().css("width"));
            } else {
                bSize = 175;
            }
        }
        var bWidth = 200 == bSize ? 175 : bSize * 0.8724;
        var bHeight = 200 == bSize ? 67 : bSize * 0.3364;
        var bTopMidSep = 200 == bSize ? 75 : bSize * 0.3796;
        var bTopWhite = 200 == bSize ? 50 : bSize * 0.2464;
        var bRedLine = 200 == bSize ? 33 : bSize * 0.1636;
        var bWeight = 200 == bSize ? 4 : bSize * 0.020;

        //If this is a filler button, use a different set of values
        if (/fillerBox/g.exec($(this).parent().prop("class")) != null && $(this).parent().hasClass("displayBox")) {
            //If this filler button size is smaller than 2x2
            //(Sometimes due to desired layout, it is better to create filler boxes that are larger than the default)
            var s1=1, s2=1;
            $(this).parent().classes(function (c) { if (/db[0-9]x[0-9]/.exec(c) != null) { s1 = parseInt(/[0-9](?=x)/.exec(c)); s2 = parseInt(/[0-9]$/.exec(c)); } });
            if (s1 < 2 || s2 < 2) {
                //Filler Buttons Sizing
                bSize = 130 < displayBoxWidth ? 130 : displayBoxWidth;
                bWidth = 130 == bSize ? 113 : bSize * 0.8724;
                bHeight = 130 == bSize ? 44 : bSize * 0.3364;
                bTopMidSep = 130 == bSize ? 49 : bSize * 0.3796;
                bTopWhite = 130 == bSize ? 32 : bSize * 0.2464;
                bRedLine = 130 == bSize ? 21 : bSize * 0.1636;
                bWeight = 130 == bSize ? 2 : bSize * 0.020;
            }
        }

        //Get the border lines
        var whiteTopLineL = $(this).children(".dBoxButtonWLine1");
        var whiteTopLineR = $(this).children(".dBoxButtonWLine2");
        var whiteLeftLine = $(this).children(".dBoxButtonWLine5");
        var whiteRightLine = $(this).children(".dBoxButtonWLine3");
        var whiteBottomLine = $(this).children(".dBoxButtonWLine4");
        var redLine = $(this).children(".dBoxButtonRLine");

        //Set CSS properties for the button wrapper
        $(this).css({
            "left": ($(this).parent().width() / 2) - (bSize / 2),
            "top": ($(this).parent().height() / 2) - (bSize / 2),
            "width": bSize,
            "height": bSize
        });

        //Get the left offset
        var lOff = ($(this).width() / 2) - (bWidth / 2);
        //Get the top offset
        var tOff = ($(this).height() / 2) - (bHeight / 2);


        //Set the line css properties
        whiteTopLineL.css({
            "background-color": buttonColor,
            "left": lOff,
            "top": tOff,
            "width": bTopWhite,
            "height": bWeight
        });
        whiteTopLineR.css({
            "background-color": buttonColor,
            "left": lOff + bTopWhite + bTopMidSep,
            "top": tOff,
            "width": bTopWhite,
            "height": bWeight
        });
        whiteLeftLine.css({
            "background-color": buttonColor,
            "left": lOff,
            "top": tOff,
            "width": bWeight,
            "height": bHeight
        }).children('.dBBHWLineLL').css({
            "background-color": "#d72132",
            "left": 0,
            "top": -1*bHeight,
            "width": bWeight,
            "height": bHeight,
            "position": "absolute"
        });
        whiteRightLine.css({
            "background-color": buttonColor,
            "left": lOff + bWidth - bWeight,
            "top": tOff,
            "width": bWeight,
            "height": bHeight
        }).children('.dBBHWLineRR').css({
            "background-color": "#d72132",
            "left": 0,
            "top": -1*bHeight,
            "width": bWeight,
            "height": bHeight,
            "position": "absolute"
        });
        whiteBottomLine.css({
            "background-color": buttonColor,
            "left": lOff,
            "top": tOff + bHeight - bWeight,
            "width": bWidth,
            "height": bWeight
        });
        whiteBottomLine.children('.dBBHWLineBL').css({
            "background-color": "#d72132",
            "left": -1*bWidth/2,
            "top": 0,
            "width": bWidth/2,
            "height": bWeight,
            "position": "absolute"
        });
        whiteBottomLine.children('.dBBHWLineBR').css({
            "background-color": "#d72132",
            "left": bWidth,
            "top": 0,
            "width": bWidth/2,
            "height": bWeight,
            "position": "absolute"
        });
        redLine.css({
            "background-color": "#d72132",
            "left": lOff + bTopWhite + bTopMidSep/2 - bRedLine/2,
            "top": tOff,
            "width": bRedLine,
            "height": bWeight
        }).children('.dBBHRLine').css({
            "background-color": "#d72132",
            "left": 0,
            "top": 0,
            "width": bRedLine,
            "height": bWeight,
            "position": "absolute"
        });

        //Get the button text
        var bText = $(this).children(".dBoxButtonText");
        bText.css({
            "left": lOff + bWeight,
            "top": tOff + bWeight,
            "width": bWidth - bWeight * 2,
            "height": bHeight - bWeight * 2,
            "color": buttonColor
        });
        //Get the child span
        var cSpan = bText.children("span");
        //Set the position to absolute
        cSpan.css("position", "absolute");
        //Scale the font size
        cSpan.css("font-size", Math.floor((bText.width() / cSpan.width()) * parseInt(cSpan.css("font-size")) * 0.75));
        //Get the font size
        var fontSize = parseInt(cSpan.css("font-size"));
        //Set the top margin of the span
        cSpan.css("top", bText.height() / 2 - fontSize/1.5);
        //Set the left margin of the span
        cSpan.css("left", bText.width()/2 - cSpan.width() / 2);
    });
}