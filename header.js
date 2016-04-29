function headerScroll(startSnapDist, colorMode) {
    //Get the scroll distance
    var scrollElem = ((navigator.userAgent.toLocaleLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewTop = $(scrollElem).scrollTop();

    //If the scroll distance is larger than 40
    if (viewTop > startSnapDist) {
        $("#header").css({ "height": "95px", "top": "-15px", "position": "fixed"});
        $("#header").children("#siteTitle").css({ "height": "95px" });
        $("#header").children("#headerLinks").css({ "height": "95px" });
        $("#mobileLinks").css({ "margin-top": $("#mobileHeaderButton").height() - 15});
    } else {
        $("#header").css({ "height": "120px", "top": "0px", "position": "absolute"});
        $("#header").children("#siteTitle").css({ "height": "120px" });
        $("#header").children("#headerLinks").css({ "height": "120px" });
        $("#mobileLinks").css({ "margin-top": $("#mobileHeaderButton").height() + 15 + $(".hamburgerButtonWrapper").height() });
    }
    //If the header starts with white text
    if (colorMode == 1) {
        //If the header scroll distance is less than the startSnapDist + 1/2 page height
        if (viewTop < startSnapDist + wHeight*0.5) {
            $("#siteTitle").css({ "color": "#fcfcfc" });
            $("#headerLinks").css({ "color": "#fcfcfc" });
            $("#header").css({ "background-color": "rgba(34, 34, 34, 0)" });
        } else {
            $("#siteTitle").css({ "color": "#fcfcfc" });
            $("#headerLinks").css({ "color": "#fcfcfc" });
            $("#header").css({ "background-color": "rgba(34, 34, 34, 1)"});
        }
        $(".hamBar").css({ "background-color": "#fcfcfc" });
        $("#mobileSidebar").css({ "background-color": "#222222" });
        $(".mobileSBLink").css({ "color": "#fcfcfc", "border-top": "1px solid #444444" });
    //Else, the header starts with black text
    } else {
        if (viewTop < startSnapDist) {
            $("#siteTitle").css({ "color": "#444444" });
            $("#headerLinks").css({ "color": "#999999" });
            $("#header").css({ "background-color": "rgba(248, 248, 248, 0)" });
            $(".hamBar").css({ "background-color": "#222222" });
        } else {
            $("#siteTitle").css({ "color": "#fcfcfc" });
            $("#headerLinks").css({ "color": "#fcfcfc" });
            $("#header").css({ "background-color": "rgba(34, 34, 34, 1)" });
            $(".hamBar").css({ "background-color": "#fcfcfc" });
        }
        $("#mobileSidebar").css({ "background-color": "#222222" });
        $(".mobileSBLink").css({ "color": "#fcfcfc", "border-top": "1px solid #444444" });
    }
}

function headerResize() {
    $("#siteTitle").css({ "margin-left": (wWidth - contentWidth) * 0.5 });
    $("#headerLinks").css({ "right": (wWidth - contentWidth) * 0.5 });
    if (contentWidth < 800) {
        $("#headerLinks").css("visibility", "hidden");
        $("#headerHoverLine").css("visibility", "hidden");
        $("#mobileHeaderButton").css("visibility", "visible");
    } else {
        $("#headerLinks").css("visibility", "visible");
        $("#headerHoverLine").css("visibility", "visible");
        $("#mobileHeaderButton").css("visibility", "hidden");
    }

    $("#mobileSidebar").css({ "right": -340 });
}

function headerActivateSidebar() {
    if (sidebarToggle == 0) {
        $("#mobileSidebar").stop().animate({ "right": 0 }, 200);
        sidebarToggle = 1;
    } else {
        $("#mobileSidebar").stop().animate({ "right": -340 }, 200);
        sidebarToggle = 0;
    }
}

function headerLineTo(headerLinkCell) {
    var link = headerLinkCell.children(".headerLinkText");
    var highlightWidth = parseInt(link.width());
    var highlightLeft = parseInt(link.offset().left);
    $("#headerHoverLine").stop().animate({
        "width": highlightWidth,
        "left": highlightLeft,
        "bottom": 55
    }, 100);
}

function headerLineReset() {
    //Position the header hover line
    var highlightWidth = parseInt($("#headerLinkActive").width());
    var highlightLeft = parseInt($("#headerLinkActive").offset().left);
    $("#headerHoverLine").stop().animate({
        "width": highlightWidth,
        "left": highlightLeft,
        "bottom": 55
    }, 100);
}