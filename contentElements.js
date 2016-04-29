function cElemResize() {
    //Re-size full-text content paragraphs based on window size
    if (contentWidth >= 1000) {
        $(".cTextFull").css("width", "85%");
    } else {
        $(".cTextFull").css("width", "100%");
    }

    //Make sure that the height of the item highlights are all equal
    var maxHeight = 0;
    $(".cIHItem").each(function () {
        var thisHeight = $(this).children(".cIHItemTitle").height() + $(this).children(".cIHItemDesc").height() + 80;
        if (thisHeight > maxHeight) {
            maxHeight = thisHeight;
        }
    });
    $(".cIHItem").css({ "height": maxHeight });

    //Position content item highlight red lines
    $(".cIHItemRedCenterLine").each(function () {
        if ($(this).parent().parent().hasClass("cIHLeftList")) {
            $(this).css({ "left": parseInt($(this).parent().width()) - 2 });
        }
    });

    $(".cPictureContent").each(function () {
        $(this).parent().parent().css("width", contentWidth);
        $(this).parent().parent().css("height", contentWidth / 1.618);
        utils.fitContent($(this), contentWidth, contentWidth / 1.618);
    });
}

/**
 * Content Item Highlights Item MouseEnter code
 * Does all the animation for mouseEnter
 */
function cIHItemEnter(item) {
    //Get the parent
    var thisParent = item.parent();
    //Get the top and bottom lines based on the item number
    var boxNum = 0;
    item.classes(function (c) {
        if (/cIHItem[0-9]+/.exec(c) != null) { boxNum = parseInt(/[0-9]+/.exec(c)); }
    });
    var topLine = thisParent.children('.cIHL' + boxNum);
    var bottomLine = thisParent.children('.cIHL' + (boxNum + 1));
    //Get the middle line
    var middleLine = item.children(".cIHItemRedCenterLine");
    //Animate those lines to have different properties
    middleLine.stop().animate({ "height": "100%", "top": "0%" }, 150);
    topLine.css({ "background-color": "rgba(216, 33, 50, 1.0)", "height": "2px", "margin-bottom": "0px" });
    bottomLine.css({ "background-color": "rgba(216, 33, 50, 1.0)", "height": "2px", "margin-bottom": "0px" });
}
/**
 * Content Item Highlights Item MouseLeave code
 */
function cIHItemLeave(item) {
    //Get the parent
    var thisParent = item.parent();
    //Get the top and bottom lines based on the item number
    var boxNum = 0;
    item.classes(function (c) {
        if (/cIHItem[0-9]+/.exec(c) != null) { boxNum = parseInt(/[0-9]+/.exec(c)); }
    });
    var topLine = thisParent.children('.cIHL' + boxNum);
    var bottomLine = thisParent.children('.cIHL' + (boxNum + 1));
    //Get the middle line
    var middleLine = item.children(".cIHItemRedCenterLine");
    //Animate those lines to have different properties
    middleLine.stop().animate({ "height": "16%", "top": "42%" }, 150);
    topLine.css({ "background-color": "#dedede", "height": "1px", "margin-bottom": "1px" });
    bottomLine.css({ "background-color": "#dedede", "height": "1px", "margin-bottom": "1px" });
}