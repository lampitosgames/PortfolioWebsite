var utils = {
	//normalize function (find where the 'value' falls percentage-wise between the min and max)
	norm: function(value, min, max) {
		return (value - min) / (max - min);
	},
	//linear interpolation function (find the value from a min and max value, and a normalized number) ((max-min) * norm + min)
	lerp: function(norm, min, max) {
		return (max - min) * norm + min;
	},
	//Map funciton that gets the normalized value of a number in one range, and returns the interpolated value in a second range
	map: function(value, sourceMin, sourceMax, destMin, destMax) {
		var n = utils.norm(value, sourceMin, sourceMax);
		return utils.lerp(n, destMin, destMax);
	},
	//Clamp.  Make sure a value stays between two values in a range
	clamp: function(value, min, max) {
		return Math.min(Math.max(value, Math.min(min, max)), Math.max(min, max));
	},
	//detect if a value is within a range
	inRange: function(value, min, max) {
		return value >= Math.min(min, max) && value <= Math.max(min, max);
	},
	//detect if two ranges overlap
	rangeIntersect: function(min0, max0, min1, max1) {
		return Math.max(min0, max0) >= Math.min(min1, max1) &&
			   Math.min(min0, max0) <= Math.min(min1, max1);
	},
	//detect if one range is fully in another range
	rangeContains: function(min0, max0, min1, max1) {
		return Math.max(min0, max0) >= Math.max(min1, max1) &&
			   Math.min(min0, max0) <= Math.min(min1, max1);
	},
	//random number within a range
	randomRange: function(min, max) {
		return min + Math.random() * (max - min);
	},
	//random integer within a range
	randomInt: function(min, max) {
		return Math.floor(min + Math.random() * (max - min + 1));
	},
	//convert degrees to radians
	inRads: function(degr) {
		return degr / 180 * Math.PI;
	},
	//convert radians to degrees
	inDegr: function(rads) {
		return rads * 180 / Math.PI;
	},

    /**
     * Resize content to fit inside it's parents.  Content should have 2 parents, one that is the div it fits inside, and one that is the 'frame' that cuts off extras
     * content  Image/video object to fit into the div
     * boxW  Content containing div new width
     * boxH  Content containing div new height
     */
     fitContent: function(content, boxW, boxH) {
        //Make sure the w and h properties exist
        if (content.attr("w") == '0') {
            content.attr("w", content.width());
        }
        if (content.attr("h") == '0') {
            content.attr("h", content.height());
        }
        //Get the div containing the content.  This div has the proper dimensions
        var contentDiv = content.parent();
        //Get the 'frame' div.  This element is the actual view on screen
        var frameDiv = contentDiv.parent();
        //Get the original width/height values of the background image
        var oW = content.attr('w');
        var oH = content.attr('h');
        //Get the scale ratios.  Add 0.01 to avoid weird half-pixel glyches
        var hScale = 0.01 + (boxH / oH);
        var wScale = 0.01 + (boxW / oW);
        var contentNW, contentNH;
        //Use the largest scale to scale the original height and width so that the image just barely fits inside the backDiv
        if (hScale > wScale) {
            contentNH = oH * hScale;
            contentNW = oW * hScale;
        } else {
            contentNH = oH * wScale;
            contentNW = oW * wScale;
        }
        //Get all the centers
        var contentCX = contentNW / 2;
        var contentCY = contentNH / 2;
        var contentDivCX = boxW / 2;
        var contentDivCY = boxH / 2;
        var frameCX = frameDiv.width() / 2;
        var frameCY = frameDiv.height() / 2;
        //Set the new CSS properties for the content
        content.css({ "left": contentDivCX - contentCX, "top": contentDivCY - contentCY, "width": contentNW, "height": contentNH });
        //Set the new CSS properties for the content div
        contentDiv.css({ "left": frameCX - contentDivCX, "top": frameCY - contentDivCY, "width": boxW, "height": boxH });
    }
}

/**
 * Check for mobile browsers
 */
window.mobilecheck = function () {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true;
    } else {
        return false;
    }
}
function viewport() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window)) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width: e[a + 'Width'], height: e[a + 'Height'] };
}

/**
 * Get classes for a jquery objects
 */
; !(function ($) {
    $.fn.classes = function (callback) {
        var classes = [];
        $.each(this, function (i, v) {
            var splitClassName = v.className.split(/\s+/);
            for (var j in splitClassName) {
                var className = splitClassName[j];
                if (-1 === classes.indexOf(className)) {
                    classes.push(className);
                }
            }
        });
        if ('function' === typeof callback) {
            for (var i in classes) {
                callback(classes[i]);
            }
        }
        return classes;
    };
})(jQuery);