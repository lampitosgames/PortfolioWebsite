/** 
 * Align all display boxes in a visually-appealing manner.
 * This is probably more complicated than it needs to be, but it makes everything
 * much more aesthetically pleasing than just shoving all the boxes together.
 * This algorithm is designed to give proper flow to the page no matter what configuration
 * the boxes are being loaded in.
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