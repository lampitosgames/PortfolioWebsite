<?php
session_start();
if (!isset($_SESSION['ShapeClickerData'])) {
	$_SESSION['ShapeClickerData']="";
}
if (!isset($_SESSION['ShapeClickerScore'])) {
	$_SESSION['ShapeClickerScore']=0;
}
?>
<head>
	<title id='pageTitle'>0 - Shape Clicker</title>
	<script src="JQuery.js"></script>
	<link rel="stylesheet" href="JQueryUI.css">
	<script src="JQueryUI.js"></script>
</head>
<body>
	<div id="wrapper" class="noSelect" style="overflow: hidden;">
		<div id="canvas" style="overflow: hidden; margin-left: 2%; margin-top: 2%; width: 96%; height: 86%; float: left; display: inline; position: relative;">
			<canvas id="Game" width="640" height="480" style="z-index: 0; border: 2px solid #000000; position: absolute;">update your browser, fool!</canvas>
			<div id="bottomToolbar" style="z-index: 1; float: bottom; position: relative; height: 150px; border-top: 2px solid #cccccc; border-left: 2px solid black; border-right: 2px solid black; background: #f9f9f9; background: -moz-linear-gradient(top, #f9f9f9 50%, #eaeaea 100%); background: -webkit-linear-gradient(top, #f9f9f9 50%,#eaeaea 100%); background: -ms-linear-gradient(top, #f9f9f9 50%,#eaeaea 100%); background: linear-gradient(to bottom, #f9f9f9 50%,#eaeaea 100%);">
				<div id="scoreWrapper" style="height: 100%; z-index: 2; position: relative; float: left; text-align: center; width: 40%; display: inline-block;">
					<span id="Score" style="position: relative; line-height: 140px; display: inline; font-size: 100px; font-family: cursive; color: #1c94c4; text-align: center;">0</span>
					<span class="fade" style="background-color: #f9f9f9; margin-right: -1px; font-size: 16px; float: right; font-family: Calibri; border-left: 1px solid #cccccc; color: #ef8c08; width: 100px; border-bottom: 1px solid #cccccc; border-bottom-left-radius: 3px; padding: 3px;">Per Second: <span id="ScorePerSecond">0</span></span>
				</div>
				<img class="fade" src="graphics/bottomDividerLine.png" style="display: inline-block; float: left;"/>
				<div class="fade" id="controlsWrapper" style="height: 100%; z-index: 2; position: relative; float: left; text-align: center; width: 20%; display: inline-block;">
					<div id="DeleteObject" style="background-color: pink; font-family: Calibri; border: 1px solid red; width: 70%; margin-top: 10px; margin-left: 14%; border-radius: 5px; padding: 5px; height: 20px; z-index: 2; cursor: pointer;">
						<span id="DeleteText" style="font-size: 15px;">Delete Something</span>
					</div>
					<img id="UpArrow" src='graphics/arrows/UpArrow.png' style="margin-top: 16px; cursor: pointer;"/>
					<img id="RightArrow" src='graphics/arrows/RightArrow.png' style="margin-top: 16px; cursor: pointer;"/>
					<img id="DownArrow" src='graphics/arrows/DownArrow.png' style="margin-top: 16px; cursor: pointer;"/>
					<img id="LeftArrow" src='graphics/arrows/LeftArrow.png' style="margin-top: 16px; cursor: pointer;"/>
					<div id="ToggleDisplayPoints" style="background-color: #7CDB4B; font-family: Calibri; border: 1px solid green; width: 70%; margin-top: 16px; margin-left: 14%; border-radius: 5px; padding: 5px; height: 20px; z-index: 2; cursor: pointer;">
						<span id="TogglePointText" style="font-size: 15px;">Toggle Point Display</span>
					</div>
				</div>
				<img class="fade" src="graphics/bottomDividerLine.png" style="display: inline-block; float: left;"/>
				<div class="fade" id="lagDebugWrapper" style="height: 100%; z-index: 2; position: relative; float: left; text-align: center; width: 17%; display: inline-block;">
					<div style="width: 100%; text-align: center; position: relative; margin-top: 10px;">
						<span style="font-size: 18px; color: #ef8c08; font-family: Calibri;">Target FPS : </span>
						<input id="CurrentFPS" type="text" size="2" style="padding-left: 3px; display: float; color: #1c94c4;">
						<img src='graphics/ScrollerArrow.png' style="pointer-events: none; margin-top: 4px; margin-left: -20px; position: absolute;">
					</div>
					<div style="width: 100%; text-align: center; position: relative; margin-top: 10px;">
						<span style="font-size: 18px; color: #ef8c08; font-family: Calibri;">Current FPS : </span>
						<span id='RealFPS' style="font-size: 18px; font-weight: bold; font-family: Calibri; color: #1c94c4;">30</span>
					</div>
					<div style="width: 100%; text-align: center; position: relative; margin-top: 10px;">
						<span style="font-size: 18px; color: #ef8c08; font-family: Calibri;">Lag Status : </span>
						<span id='LagStatus' style="font-family: Calibri; font-size: 16px; text-shadow: -1px -1px 0 #000000, 1px -1px 0 #000000, -1px 1px 0 #000000, 1px 1px 0 #000000;">Good</span>
					</div>
					<div id="NewGame" style="background-color: white; font-family: Calibri; border: 1px solid lightgray; width: 70%; margin-top: 10px; margin-left: 14%; border-radius: 5px; padding: 5px; height: 20px; z-index: 2; cursor: pointer;">
						<span id="DeleteText" style="font-size: 15px;">New Game</span>
					</div>
					<div style="display: none;">
					<!-- Start: TraceMyIP.org Code //-->
					<script type="text/javascript" src="http://s2.tracemyip.org/tracker/lgUrl.php?stlVar2=1302&amp;rgtype=4684NR-IPIB&amp;pidnVar2=64632&amp;prtVar2=19&amp;scvVar2=12&amp;gustVarS=2&amp;gustVarU=45677&amp;gustVarM=2"></script><noscript><a title="trace my ip location" href="http://www.tracemyip.org/pv1-2-45677-2" target="_blank"><img src="http://s2.tracemyip.org/tracker/1302/4684NR-IPIB/64632/19/12/ans/" alt="trace my ip location" border="0"></a></noscript>
					<!-- End: TraceMyIP.org Code //-->
					</div>
				</div>
				<img class="fade" src="graphics/bottomDividerLine.png" style="display: inline-block; float: left;"/>
				<div class="fade" id="shapeCountWrapper" style="height: 100%; z-index: 2; position: relative; float: left; text-align: center; width: 20%; display: inline-block;">
					<table style="width: 100%; height: 100%; text-align: center; border-collapse: collapse; margin-left: -2px;">
							<tr>
								<td style="font-size: 18px; color: #ef8c08; font-family: Calibri; border-bottom: 1px solid #cccccc;">Points</td>
								<td id='PointsOwned' style="font-size: 18px; font-weight: bold; font-family: Calibri; border-bottom: 1px solid #cccccc; color: #1c94c4;">0</td>
							</tr>
							<tr>
								<td style="font-size: 18px; color: #ef8c08; font-family: Calibri; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc;">Lines</td>
								<td id='LinesOwned' style="font-size: 18px; font-weight: bold; font-family: Calibri; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc; color: #1c94c4;">0</td>
							</tr>
							<tr>
								<td style="font-size: 18px; color: #ef8c08; font-family: Calibri; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc;">Shapes</td>
								<td id='ShapesOwned' style="font-size: 18px; font-weight: bold; font-family: Calibri; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc; color: #1c94c4;">0</td>
							</tr>
							<tr>
								<td style="font-size: 18px; color: #ef8c08; font-family: Calibri; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc;">Circles</td>
								<td id='CirclesOwned' style="font-size: 18px; font-weight: bold; font-family: Calibri; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc; color: #1c94c4;">0</td>
							</tr>
							<tr>
								<td style="font-size: 18px; color: #ef8c08; font-family: Calibri; border-top: 1px solid #cccccc;">Custom Shapes</td>
								<td id='CustomShapesOwned' style="font-size: 18px; font-weight: bold; font-family: Calibri; border-top: 1px solid #cccccc; color: #1c94c4;">0</td>
							</tr>
					</table>
				</div>
			</div>
			<div id="storeWrapper" style="top: 2px; overflow: hidden; position: absolute; width: 542px; pointer-events: none;">
				<div id="store" style="height: 100%; width: 542px; pointer-events: all; overflow: auto; position: relative; border-left: 2px solid #cccccc; background: #f9f9f9; background: -moz-linear-gradient(left, #f9f9f9 50%, #eaeaea 100%); background: -webkit-linear-gradient(left, #f9f9f9 50%,#eaeaea 100%); background: -ms-linear-gradient(left, #f9f9f9 50%,#eaeaea 100%); background: linear-gradient(to right, #f9f9f9 50%,#eaeaea 100%);">
					<table style="width: 100%; height: 100%; text-align: center; border-collapse: collapse;">
						<tr>
							<td style="border-right: 2px solid #cccccc; cursor: pointer;">
								<img src="graphics/buyShapesButton.png"/>
							</td>
							<td style="padding-left: 5px;">
								<div id="BuyMultiply" style="cursor: pointer; text-align: center; display: table;">
									<div style="display: table-cell; width: 290px; height: 90px;">
										<img id='BuyMultiplyPictureLeft' src='graphics/buttons/MultiplyPictureLeft.png'/>
									</div>
									<div id='BuyMultiplyPictureRight' style="display: table-cell; padding-left: 5px; padding-right: 10px; vertical-align: middle; position: relative; font-family: Courier; font-size: 65px; width: 195px; background-image: url('graphics/buttons/MultiplyPictureRight.png');">
										15
									</div>
								</div>
								<div id="BuyLine" style="cursor: pointer; text-align: center; display: table;">
									<div style="display: table-cell; width: 290px; position: relative; height: 90px;">
										<img id='BuyLinePictureLeft' src='graphics/buttons/LinePictureLeft.png'/>
									</div>
									<div id='BuyLinePictureRight' style="display: table-cell; padding-left: 5px; padding-right: 10px; vertical-align: middle; position: relative; font-family: Courier; font-size: 65px; width: 195px; background-image: url('graphics/buttons/LinePictureRight.png');">
										30
									</div>
								</div>
								<div id="BuyShape" style="cursor: pointer; text-align: center; display: table;">
									<div style="display: table-cell; width: 290px; position: relative; height: 90px;">
										<img id='BuyShapePictureLeft' src='graphics/buttons/ShapePictureLeft.png'/>
									</div>
									<div id='BuyShapePictureRight' style="display: table-cell; padding-left: 5px; padding-right: 10px; vertical-align: middle; position: relative; font-family: Courier; font-size: 65px; width: 195px; background-image: url('graphics/buttons/ShapePictureRight.png');">
										270
									</div>
								</div>
								<div id="BuyCircle" style="cursor: pointer; text-align: center; display: table;">
									<div style="display: table-cell; width: 290px; position: relative; height: 90px;">
										<img id='BuyCirclePictureLeft' src='graphics/buttons/CirclePictureLeft.png'/>
									</div>
									<div id='BuyCirclePictureRight' style="display: table-cell; padding-left: 5px; padding-right: 10px; vertical-align: middle; position: relative; font-family: Courier; font-size: 65px; width: 195px; background-image: url('graphics/buttons/CirclePictureRight.png');">
										900
									</div>
								</div>
								<div id="BuyCustomShape" style="cursor: pointer; text-align: center; display: table;">
									<div style="display: table-cell; width: 290px; position: relative; height: 90px;">
										<img id='BuyCustomShapePictureLeft' src='graphics/buttons/CustomShapePictureLeft.png'/>
									</div>
									<div id='BuyCustomShapePictureRight' style="display: table-cell; padding-left: 5px; padding-right: 10px; vertical-align: middle; position: relative; font-family: Courier; font-size: 65px; width: 195px; background-image: url('graphics/buttons/CustomShapePictureRight.png');">
										15000
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="helpWrapper" style="z-index: 3; top: 2px; left: 2px; overflow: hidden; position: absolute; pointer-events: none; width: 710px; height: 605px;">
				<div id="help" style="position: relative; width: 701px; height: 595px; pointer-events: all; line-height: 110%; border: 2px solid #cccccc; background: #f9f9f9; background: -moz-linear-gradient(top, #f9f9f9 50%, #eaeaea 100%); background: -webkit-linear-gradient(top, #f9f9f9 50%,#eaeaea 100%); background: -ms-linear-gradient(top, #f9f9f9 50%,#eaeaea 100%); background: linear-gradient(to bottom, #f9f9f9 50%,#eaeaea 100%);">
					<div style="width: 700px; height: 590px;">
					<div id="accordion">
						<h3>Basic Gameplay</h3>
						<div style='font-size: 14px; font-family: cursive;'>
							<ul>
								<li>Click the grid to earn points.</li>
								<li>Scroll around the grid using the arrow keys, WASD, or the arrow buttons below the game window.</li>
								<li>Use the 'Delete Something' button in order to delete items from the grid space.</li>
								<li>You will get the same number of points no matter if your FPS is 1 or 100!  The game scales and takes into consideration the speed it is running.</li>
								<li>Roll over the "Buy Shapes" tab to the right side of the game to purchase shapes.</li>
								<li>The number of each shape you own is displayed in the lower-right of the game window.</li>
								<li>The game saves automatically every 10 seconds, or when you purchase and place a shape!</li>
								<li>The game loads automatically, so you don't have to.</li>
								<li>Want to start over?  Hit the "New Game" button located below the FPS information.</li>
								<li>If the game looks cut off, it is because your window is too small.  The game has a minimum size of 860x620 in order to function properly.  If you are having issues, try resizing your browser window.</li>
							</ul>
						</div>
						<h3>De-lag Features</h3>
						<div style='font-size: 14px; font-family: cursive;'>
							<p>All features listed have some effect on how efficient the game runs.</p>
							<ul>
								<li>The 'Toggle Point Display' button will toggle the little '+1' points on the grid (you will still earn the same number of points).</li>
								<li>The 'Target FPS' input box allows you to enter a new target FPS, or use the scrollwheel to pick a value.</li>
								<li>The 'Actual FPS' is calculated by the game, attempting to be as close to the target as possible, and is used in all score increase calculations (so no matter if you have 1 FPS or 100 FPS, the math still gives you points at a fixed rate)</li>
								<li>Note that the 'Lag Status' is simply determined by what my computer gets, and the normal difference in target FPS and actual FPS when the target is 30.  The lag status doesn't matter, and is only in the beta as a debug feature.  Pump up the FPS to whatever gets you the best experience, it will not effect the scoring.</li>
								<li>Lower FPS values make the game look worse, but also conserve battery power.  If you are low on juice, consider dropping the FPS.</li>
							</ul>
						</div>
						<h3>Shape Descriptions!</h3>
						<div style='font-size: 14px; font-family: cursive;'>
							<ul>
								<li>Once you have enough points, you can buy a Point
									<ul>
										<li>Points are placed with a simple click on the grid</li>
										<li>Points will simulate a second click for every one of your clicks</li>
									</ul>
								</li>
								<li>Once you have enough points, you can buy a Line
									<ul>
										<li>Lines will give you 2 points every second</li>
										<li>To place a line, click on one grid square, and then click another</li>
									</ul>
								</li>
								<li>Once you have enough points, you can buy a Shape
									<ul>
										<li>Shapes will give you 2n^2 points per second where n=number of sides (Triangles give 18) per second</li>
										<li>To place a shape, click anywhere on the grid</li>
										<li>To increse the number of sides a shape has, buy a second shape, and click the center point of your shape</li>
										<li>In the beginning, increasing the number of sides on your shapes will slow you down, but once you buy more sides, purchasing extra sides will become more profitable with time</li>
									</ul>
								</li>
								<li>Once you have enough points, you can buy a Circle
									<ul>
										<li>Circles will give you 60 points per second</li>
										<li>Circles can be placed by clicking the grid</li>
									</ul>
								</li>
								<li>Once you have enough points, you can buy a Custom Shape
									<ul>
										<li>Custom Shapes give you 3n^3 points per second (A lot of points) where n=number of sides</li>
										<li>To place a custom shape, click a spot on the grid to begin.  Then, click another spot to place a point, then another spot, etc.  If you click the first point you placed on your shape, the shape will complete itself.  The shape will also auto-complete if you click but don't have enough money to purchase another side.</li>
										<li>Custom Shapes come with 3 free sides, and any extra side after that will cost you more.  How much sides cost increases exponentially</li>
										<li>Custom Shapes are expensive up front, but they give you points much faster than any other purchasable item</li>
										<li>To get tons of points quickly, try saving up and making a very big custom shape</li>
									</ul>
								</li>
							</ul>
						</div>
						<h3>Update Log!</h3>
						<div style='font-size: 14px; font-family: cursive;'>
							<ul>
								<li>Shape Clicker Beta 1.2.0 :: March 21st, 2014
									<br/>
									<ul>
										<li>Session data saves score - finished 3/20/2014</li>
										<li>Session data saves shape layout & stats - finished 3/21/2014</li>
										<li>Periodically save the game - finished 3/21/2014</li>
										<li>Load game on page load - finished 3/21/2014</li>
										<li>"New Game" button - finished 3/21/2014</li>
										<li>Fixed the freeze on save issue - finished 3/26/2014</li>
									</ul>
								</li>
								<br/>
								<li>Shape Clicker Beta 1.1.0 :: March 18th, 2014
									<br/>
									The UI Update!
									<br/>
									<ul>
										<li>Design schematics - finished 3/6/2014</li>
										<li>Color palette finalized - finished 3/13/2014</li>
										<li>Score tab on bottom pannel - finished 3/13/2014</li>
										<li>Controls tab on bottom pannel - finished 3/13/2014</li>
										<li>FPS Info tab on bottom pannel - finished 3/13/2014</li>
										<li>Objects Owned tab on bottom pannel - finished 3/13/2014</li>
										<li>Variable font size for Score, 'Delete Something', and 'Toggle Point Display' based on window size - finished 3/17/2014</li>
										<li>Store Pannel with animations - finished 3/17/2014</li>
										<li>Variable grid size (scales to window) - finished 3/17/2014</li>
										<li>Dropdown Help Menu - finished 3/18/2014</li>
										<li>Update Log - finished 3/18/2014</li>
										<li>Minimum game window size to avoid clipping issues - finished 3/18/2014</li>
									</ul>
								</li>
								<br/>
								<li>Shape Clicker Beta 1.0.0 :: March 1st, 2014
									<ul>
										<li>"Delete Something" button - finished 2/7/2014</li>
										<li>Implemented the 'Point' shape type - finished 2/8/2014</li>
										<li>Resizing canvas on window load/window resize - finished 2/15/2014</li>
										<li>Implemented the 'Custom Shape' shape type - finished 2/16/2014</li>
										<li>"Toggle Point Display" button - finished 2/17/2014</li>
										<li>DisplayPoint particle recycling, for a max of 100 particles (severe reduction to lag) - finished 2/19/2014</li>
										<li>FPS spinner for target FPS - finished 2/19/2014</li>
										<li>Actual FPS and lag meter - finished 2/19/2014</li>
										<li>Set the game to use the variable actual FPS when calculating score - finished 2/20/2014</li>
										<li>Redid score math to be more balanced - finished 2/20/2014</li>
										<li>Score Per Second calculator/display added - finished 2/20/2014</li>
										<li>Number of items owned display - finished 2/20/2014</li>
										<li>Page title tag now displays current score - finished 2/24/2014</li>
										<li>Display of how much next point on a custom shape costs - finished 2/25/2014</li>
										<li>Implemented the 'Circle' shape type - finished 2/28/2014</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
					</div>
					<img id="helpButton" src="graphics/helpButton.png" style="float: right; position: absolute; right: 0px; bottom: 0px; border-left: 2px solid #cccccc; border-top: 2px solid #cccccc;"/>
				</div>
			</div>
		</div>
	</div>
	<script>
		//global variables
		//create the canvas
		var canvas = document.getElementById("Game");
		var ctx = canvas.getContext("2d");
		//game speed
		var FPS = 30;
		//mouse position handlers
		var gridSize = 10;
		var cursorx = 0;
		var cursory = 0;
		
		//Score object
		var score = {
			globalScore: 0,
			sps: 0,
			
			multiplyCost: 15,
			multipliesOwned: 0,
			clickScoreDebt: 0,
			
			lineCost: 30,
			linesOwned: 1,
			
			shapeCost: 270,
			shapesOwned: 1,
			
			circleCost: 900,
			circlesOwned: 0,
			
			customShapeCost: 15000,
			customShapesOwned: 1,
			
			clickMod: 1
		}
		
		//canvas object.  The drawing of data will be based upon relative data, and this is the relative data.  Basically, how big is the canvas, and what point are we calling the origin?
		var canWindow = {
			relX: 0, //x value of the dot that exists in the top-left corner of the viewing window
			relY: 0, //y value of the dot that exists in the top-left corner of the viewing window
			windowSize: [640, 480], //self-explanatory
			totalCanvasSize: [1000, 1000], //total size of the area we are working with
			pointPosition: new Array(), //array to store vertex objects
			
			//Set the location of the top-left corner of the canvas window (for scrolling around the canvas)
			addToRelCoords: function(x, y) {
				this.relX += x;
				this.relY += y;
			},
			
			//change the size of the canvas displayed on the screen
			reconstructCanvasSize: function(xSize, ySize) {
				//set the canvas height and width
				ctx.canvas.height = ySize;
				ctx.canvas.width = xSize;
				//if the new window size is larger than the old, and the relative pos of the TLCorner+change in window growth is greater than or equal to 0 then...
				if (xSize>this.windowSize[0] && this.relX+(this.windowSize[0]-xSize)>=0) {
					//subtract the movement from relX
					this.relX -= xSize-this.windowSize[0];
				//else if the new window size is smaller than the old...
				} else if (xSize<this.windowSize[0]) {
					//add the movement to relX
					this.relX += this.windowSize[0]-xSize;
				}
				//This serves to make sure there are no ArrayIndexOutOfBounds exceptions when calculating mouse position on the grid
				
				//same logic as above with the y values
				if (ySize>this.windowSize[1] && this.relY+(this.windowSize[1]-ySize)>=0) {
					this.relY -= ySize-this.windowSize[1];
				} else if (ySize<this.windowSize[1]) {
					this.relY += this.windowSize[1]-ySize;
				}
				this.windowSize = [xSize, ySize];
			}
		}
		
		//construct the position tracker
		for (var i=0; i<=100; i++) {
			canWindow.pointPosition[i] = new Array();
			for (var k=0; k<=100; k++) {
				canWindow.pointPosition[i][k] = 0;
			}
		}
//___________________________________________________________________________________________________________________________________________
		//Handler for the help menu
		$("#accordion").accordion({ header: "h3",          
			autoheight: false,
			active: false,
			alwaysOpen: false,
			heightStyle: "fill",
			collapsible: false,
		});
//___________________________________________________________________________________________________________________________________________
		//Handler for the FPS Spinner
		//set the value to the current FPS
		$("#CurrentFPS").val(FPS)
		//mousewheel event
		.bind('mousewheel', function(e) {
			//prevent normal scrolling
			e.preventDefault();
			//if the spinner is the focus of the window
			if ($("#CurrentFPS").is(":focus")) {
				//set value variable to store the current value of the spinner
				value = parseInt($(this).val());
				//if the wheel is scrolling up
				if (e.originalEvent.wheelDelta / 120 > 0) {
					//and if the value is less than 120 (the max FPS)
					if (value < 120) {
						//add one to the value
						$(this).val(value + 1);
						//reset the value variable
						value = parseInt($(this).val());
						//and set the FPS
						FPS = value;
					}
				//else, if the wheel is scrolling down
				} else {
					//and if the value is greater than 10 (minimum FPS)
					if (value > 10) {
						//subtract one from the current value
						$(this).val(value - 1);
						//reset the variable
						value = parseInt($(this).val());
						//set the fps
						FPS = value;
					}
				}
			}
		})
		//on keyup (the user pressed a key)
		.keyup(function(e) {
			//check the value to make sure it is legal
			if (!(/^([0-9]{0,3})$/.test($(this).val())) || parseInt($(this).val()) > 120) {
				//if the value is not legal, make it legal again
				$(this).val(value);
				value = parseInt($(this).val());
			//else, if the value is legal
			} else {
				//set the value variable
				value = parseInt($(this).val());
				//if the value is greater than the minimum
				if (value > 9) {
					//set the FPS equal to the value
					FPS = value;
				//else...
				} else {
					//set the value to the min amount, and the FPS to the value
					value = 10;
					FPS = value;
				}
			}
		});
		//value variable to track spinner value
		var value = parseInt($("#CurrentFPS").val());
//___________________________________________________________________________________________________________________________________________
		//Handlers for displaying the number of each item the user owns
		//object to hold how many of each item the user has
		var itemOwnedTotals = {
			multipliesOwned: 0,
			linesOwned: 0,
			shapesOwned: 0,
			circlesOwned: 0,
			customShapesOwned: 0
		}
		//function to call every time an update is required
		function updateOwnedTotals() {
			$("#PointsOwned").html(itemOwnedTotals['multipliesOwned']);
			$("#LinesOwned").html(itemOwnedTotals['linesOwned']);
			$("#ShapesOwned").html(itemOwnedTotals['shapesOwned']);
			$("#CirclesOwned").html(itemOwnedTotals['circlesOwned']);
			$("#CustomShapesOwned").html(itemOwnedTotals['customShapesOwned']);
		}
//___________________________________________________________________________________________________________________________________________
		//GUI positioning and animation handlers
		//make sure it is not animating currently
		var animatingStore = false;
		var animatingHelp = false;
		//when the mouse enters the store, animate the tab opening
		$("#store").mouseenter(function() {
			//if no other animation is occuring
			if (!animatingStore) {
				//set animatingStore to true
				animatingStore = true;
				//animate the openeing of the store window
				$("#store").animate({left: 0}, 150, "swing", function() {
					//once finished, set animatingStore to false
					animatingStore = false;
				});
			}
		}).mouseleave(function() {
			if (!animatingStore) {
				animatingStore = true;
				$("#store").animate({left: 500}, 150, "swing", function() {
					animatingStore = false;
				});
			}
		});
		//when the mouse enters the help menu, animate the tab opening
		$("#help").mouseenter(function() {
			//if no other animation is occuring
			if (!animatingHelp) {
				//set animatingHelp to true
				animatingHelp = true;
				//animate the openeing of the help window
				$("#help").animate({left: 0, top: 0}, 150, "swing", function() {
					//once finished, set animatingHelp to false
					animatingHelp = false;
				});
			}
		}).mouseleave(function() {
			if (!animatingHelp) {
				animatingHelp = true;
				$("#help").animate({left: -575, top: -565}, 150, "swing", function() {
					animatingHelp = false;
				});
			}
		});
//___________________________________________________________________________________________________________________________________________
		//Handlers for resizing (fires once on page load as well)
		function resizeWindow() {
			//reset the gridSize
			if (gridSize > 10) {gridSize = 10;}
			//Set the size of the canvas relative to the user's screen
			//set width and height variables
			var onLoadWidth = Math.round((($("#canvas").width()/100)*96)*0.05)/0.05;
			var onLoadHeight = Math.round((($("#canvas").height()/100)*96)*0.05)/0.05;
			//if the width is smaller than the minimum, set it to the minimum
			if (onLoadWidth < 860) {
				onLoadWidth = 860;
			}
			//if the height is smaller than the minimum, set it to the minimum
			if (onLoadHeight < 620) {
				onLoadHeight = 620;
			}
			//set the grid size based on the width
			if (onLoadWidth/100 >= 10) {
				gridSize = onLoadWidth/100;
			}
			canWindow.totalCanvasSize[0] = 100*gridSize;
			//reset the relx value to avoid problems
			canWindow.relX = 0;
			if (onLoadHeight/100 >= 10) {
				gridSize = onLoadHeight/100;
			}
			canWindow.totalCanvasSize[1] = 100*gridSize;
			//reset the rely value to avoid problems
			canWindow.relY = 0;
			//finally, resize the actual canvas to the window size
			canWindow.reconstructCanvasSize(onLoadWidth, onLoadHeight);
			$("#bottomToolbar").css("width", "" + onLoadWidth);
			
			//make sure that text is the correct size for GUI elements
			//score
			var x = $("#Score");
			//while the width of the score element is larger than it should be...
			while (x.width()+155 > $("#scoreWrapper").width()) {
				//make the font smaller
				var newsize = parseInt(x.css('font-size')) - 1;
				newsize += "px";
				x.css("font-size", newsize);
			}
			//if the font is too small
			if (parseInt(x.css('font-size')) < 100) {
				//while it is smaller than it can be...
				while (x.width()+155 < $("#scoreWrapper").width() && parseInt(x.css('font-size')) < 100) {
					//increase it's size
					var newsize = parseInt(x.css('font-size')) + 1;
					newsize += "px";
					x.css("font-size", newsize);
				}
			}
			
			//fix all the position variables for all the points on the canvas
			for (var i=0; i<canWindow.pointPosition.length; i++) {
				for (var z=0; z<canWindow.pointPosition[i].length; z++) {
					//if the position in the array is a point...
					if (canWindow.pointPosition[i][z] instanceof Point) {
						//grab the old grid size
						var oldGrid = canWindow.pointPosition[i][z]['gridSizeOnCreation'];
						//grab the old coordinates
						var oldCoords = [canWindow.pointPosition[i][z]['positionOnCanvas'][0], canWindow.pointPosition[i][z]['positionOnCanvas'][1]];
						//calculate the new coordinates
						var newX = Math.round(oldCoords[0]/oldGrid) * gridSize;
						var newY = Math.round(oldCoords[1]/oldGrid) * gridSize;
						//set the new coordinates
						canWindow.pointPosition[i][z]['positionOnCanvas'] = [newX, newY];
						//if the point is a line, modify relevant variables
						if (canWindow.pointPosition[i][z] instanceof LinePoint) {
							//calculate coords of the conTo variable
							oldCoords = [canWindow.pointPosition[i][z]['conTo'][0], canWindow.pointPosition[i][z]['conTo'][1]];
							var newX2 = Math.round(oldCoords[0]/oldGrid) * gridSize;
							var newY2 = Math.round(oldCoords[1]/oldGrid) * gridSize;
							//set the conTo variable
							canWindow.pointPosition[i][z]['conTo'] = [newX2, newY2];
							//from that, set the line's center (for displayPoint creation)
							canWindow.pointPosition[i][z]['lineCenter'] = [(newX + newX2) / 2, (newY + newY2) / 2];
						}
						//if the point is a shape, set the radius variable in the same manner
						if (canWindow.pointPosition[i][z] instanceof ShapePoint) {
							canWindow.pointPosition[i][z]['radius'] = 5 * gridSize;
						}
						//if the point is a newcustomshape, change all relevant variables
						if (canWindow.pointPosition[i][z] instanceof NewCustomShapePoint) {
							//loop through the array of vertecies//calculate the length of each hypotenuse (from each vertex to the center point)
							for (var b=0; b<canWindow.pointPosition[i][z]['Vp'].length; b++) {
								//calculate the new coordinates
								oldCoords = [canWindow.pointPosition[i][z]['Vp'][b][0], canWindow.pointPosition[i][z]['Vp'][b][1]];
								var newX2 = Math.round(oldCoords[0]/oldGrid) * gridSize;
								var newY2 = Math.round(oldCoords[1]/oldGrid) * gridSize;
								//set the new coordinates and radius to the final variable
								canWindow.pointPosition[i][z]['Vp'][b] = [newX2, newY2];
							}
							//get the coordinates of the first point
							oldCoords = [canWindow.pointPosition[i][z]['firstPoint'][0], canWindow.pointPosition[i][z]['firstPoint'][1]];
							newX = Math.round(oldCoords[0]/oldGrid) * gridSize;
							newY = Math.round(oldCoords[1]/oldGrid) * gridSize;
							//set the coordinates of the first point
							canWindow.pointPosition[i][z]['firstPoint'] = [newX, newY];
						}
						//finally, reset the old grid size
						canWindow.pointPosition[i][z]['gridSizeOnCreation'] = gridSize;
					//else, if the position is an array of points, loop through and change their variables.  Mostly same logic as above, but there is another for loop thrown into the mix
					} else if (canWindow.pointPosition[i][z] instanceof Array) {
						for (var k=0; k<canWindow.pointPosition[i][z].length; k++) {
							//grab the old grid size
							var oldGrid = canWindow.pointPosition[i][z][k]['gridSizeOnCreation'];
							//grab the old coordinates
							var oldCoords = [canWindow.pointPosition[i][z][k]['positionOnCanvas'][0], canWindow.pointPosition[i][z][k]['positionOnCanvas'][1]];
							//calculate the new coordinates
							var newX = Math.round(oldCoords[0]/oldGrid) * gridSize;
							var newY = Math.round(oldCoords[1]/oldGrid) * gridSize;
							//set the new coordinates
							canWindow.pointPosition[i][z][k]['positionOnCanvas'] = [newX, newY];
							//if the point is a line, modify relevant variables
							if (canWindow.pointPosition[i][z][k] instanceof LinePoint) {
								//calculate coords of the conTo variable
								oldCoords = [canWindow.pointPosition[i][z][k]['conTo'][0], canWindow.pointPosition[i][z][k]['conTo'][1]];
								var newX2 = Math.round(oldCoords[0]/oldGrid) * gridSize;
								var newY2 = Math.round(oldCoords[1]/oldGrid) * gridSize;
								//set the conTo variable
								canWindow.pointPosition[i][z][k]['conTo'] = [newX2, newY2];
								//from that, set the line's center (for displayPoint creation)
								canWindow.pointPosition[i][z][k]['lineCenter'] = [(newX + newX2) / 2, (newY + newY2) / 2];
							}
							//if the point is a shape, set the radius variable in the same manner
							if (canWindow.pointPosition[i][z][k] instanceof ShapePoint) {
								canWindow.pointPosition[i][z][k]['radius'] = 5 * gridSize;
							}
							//if the point is a newcustomshape, change all relevant variables
							if (canWindow.pointPosition[i][z][k] instanceof NewCustomShapePoint) {
								//loop through the array of vertecies//calculate the length of each hypotenuse (from each vertex to the center point)
								for (var b=0; b<canWindow.pointPosition[i][z][k]['Vp'].length; b++) {
									//calculate the new coordinates
									oldCoords = [canWindow.pointPosition[i][z][k]['Vp'][b][0], canWindow.pointPosition[i][z][k]['Vp'][b][1]];
									var newX2 = Math.round(oldCoords[0]/oldGrid) * gridSize;
									var newY2 = Math.round(oldCoords[1]/oldGrid) * gridSize;
									//set the new coordinates to the final variable
									canWindow.pointPosition[i][z][k]['Vp'][b] = [newX, newY];
								}
								//get the coordinates of the first point
								oldCoords = [canWindow.pointPosition[i][z][k]['firstPoint'][0], canWindow.pointPosition[i][z][k]['firstPoint'][1]];
								newX = Math.round(oldCoords[0]/oldGrid) * gridSize;
								newY = Math.round(oldCoords[1]/oldGrid) * gridSize;
								//set the coordinates of the first point
								canWindow.pointPosition[i][z][k]['firstPoint'] = [newX, newY];
							}
							//finally, reset the old grid size
							canWindow.pointPosition[i][z][k]['gridSizeOnCreation'] = gridSize;
						}
					}
				}
			}
			
			//delete something button
			var x = $("#DeleteText");
			while (x.width()+10 > $("#DeleteObject").width()) {
				var newsize = parseInt(x.css('font-size')) - 1;
				newsize += "px";
				x.css("font-size", newsize);
			}
			if (parseInt(x.css("font-size")) < 15) {
				while (x.width()+20 < $("#DeleteObject").width() && parseInt(x.css('font-size')) < 15) {
					var newsize = parseInt(x.css('font-size')) + 1;
					newsize += "px";
					x.css("font-size", newsize);
				}
			}
			
			//toggle point display button
			var x = $("#TogglePointText");
			while (x.width()+10 > $("#ToggleDisplayPoints").width()) {
				var newsize = parseInt(x.css('font-size')) - 1;
				newsize += "px";
				x.css("font-size", newsize);
			}
			if (parseInt(x.css("font-size")) < 15) {
				while (x.width()+20 < $("#ToggleDisplayPoints").width() && parseInt(x.css('font-size')) < 15) {
					var newsize = parseInt(x.css('font-size')) + 1;
					newsize += "px";
					x.css("font-size", newsize);
				}
			}
			
			
			//make sure all elements are in the correct position relative to the canvas.
			$("#bottomToolbar").css("top", canWindow.windowSize[1]-150);
			$("#storeWrapper").css("left", canWindow.windowSize[0]-540);
			$("#storeWrapper").height((canWindow.windowSize[1]-150) + "px");
			//if the object store is not currently animating, close the object store tab
			if (!animatingStore) {
				animatingStore = true;
				$("#store").animate({left: 500}, 1000, "swing", function() {
					animatingStore = false;
				});
			}
			//if the help menu is not currently animating, close the help tab
			if (!animatingHelp) {
				animatingHelp = true;
				$("#help").animate({left: -575, top: -565}, 1000, "swing", function() {
					animatingHelp = false;
				});
			}
		}
		//on window resize...
		window.onresize = function(e) {
			//resize the canvas to fit
			resizeWindow();
		}
		//call on page load
		resizeWindow();
		
//___________________________________________________________________________________________________________________________________________

		//Handlers for moving around the grid inside the canvas window
		var DELETEOBJECT = -1;
		var CLICK = 0;
		var NEWMULTIPLY = 1;
		var NEWLINE = 2;
		var NEWSHAPE = 3;
		var NEWCIRCLE = 4;
		var NEWCUSTOMSHAPE = 5;
		var mouseAction = CLICK;
		//if the down arrow is clicked
		$("#DownArrow").mousedown(function(e) {
			//and if it would not go out of bounds of the canvas size
			if (canWindow.windowSize[1]+canWindow.relY+(5*gridSize-1) < canWindow.totalCanvasSize[1]) {
				//change the relcords in the canvas object
				canWindow.addToRelCoords(0, 5*gridSize);
			}
			return false;
		});
		
		//if the right arrow is clicked (same logic as previous)
		$("#RightArrow").mousedown(function(e) {
			if (canWindow.windowSize[0]+canWindow.relX+(5*gridSize-1) < canWindow.totalCanvasSize[0]-(5*gridSize-1)) {
				canWindow.addToRelCoords(5*gridSize, 0);
			}
			return false;
		});
		
		//if the up arrow is clicked
		$("#UpArrow").mousedown(function(e) {
			if (canWindow.relY-(5*gridSize-1) > 0) {
				canWindow.addToRelCoords(0, -5*gridSize);
			}
			return false;
		});
		
		//if the left arrow is clicked
		$("#LeftArrow").mousedown(function(e) {
			if (canWindow.relX-(5*gridSize-1) > 0) {
				canWindow.addToRelCoords(-5*gridSize, 0);
			}
			return false;
		});
//_____________________________________________________________________________________________________________________________________

		//key-press handlers and short cuts
		document.onkeydown = function(e) {
			var key; //the key that was pressed
			//get the key that was pressed and assign it to key
			if (typeof event !== 'undefined') {
				key = event.keyCode;
			} else if (e) {
				key = e.which;
			}
			//variables denoting certain keys.  Helpful as constants
			var LEFTARROW = 37;
			var RIGHTARROW = 39;
			var UPARROW = 38;
			var DOWNARROW = 40;
			var AKEY = 65;
			var DKEY = 68;
			var WKEY = 87;
			var SKEY = 83;
			//move the canvas view around, same logic as arrow handlers
			if (key == LEFTARROW || key == AKEY) {
				if (canWindow.relX-(5*gridSize-1) > 0) {
					canWindow.addToRelCoords(-5*gridSize, 0);
				}
				return false;
			} else if (key == RIGHTARROW || key == DKEY) {
				if (canWindow.windowSize[0]+canWindow.relX+(5*gridSize-1) < canWindow.totalCanvasSize[0]-(5*gridSize-1)) {
					canWindow.addToRelCoords(5*gridSize, 0);
				}
				return false;
			} else if (key == UPARROW || key == WKEY) {
				if (canWindow.relY-(5*gridSize-1) > 0) {
					canWindow.addToRelCoords(0, -5*gridSize);
				}
				return false;
			} else if (key == DOWNARROW || key == SKEY) {
				if (canWindow.windowSize[1]+canWindow.relY+(5*gridSize-1) < canWindow.totalCanvasSize[1]) {
					canWindow.addToRelCoords(0, 5*gridSize);
				}
				return false;
			}
		}
//_____________________________________________________________________________________________________________________________________
		//The point class.  Master class for all points
		function Point(x, y) {
			//position variable
			this.positionOnCanvas = [x, y];
			this.tick = function() { //tick function that is in all point classes (in this case it does nothing)
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//erase location of this point
				canWindow.pointPosition[this.positionOnCanvas[1]/gridSize][this.positionOnCanvas[0]/gridSize] = 0;
			}
		}
		
		//the temporary point class.  Useful for displaying points that don't do anything yet
		function TempPoint(x, y) {
			//position variable
			this.positionOnCanvas = [x, y];
			this.gridSizeOnCreation = gridSize;
			this.tick = function() { //tick function that is in all point classes
				//get the relative position of the point
				var posx = this.positionOnCanvas[0] - canWindow.relX;
				var poxy = this.positionOnCanvas[1] - canWindow.relY;
				//draw the point
				ctx.fillStyle = "blue";
				ctx.fillRect(posx-2, poxy-2, 4, 4);
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//do nothing because this is a constructor object
			}
		}
		//set temp's parent to the Point class
		TempPoint.prototype = new Point();
		
		//the MultiplyPoint class.  Each MultiplyPoint adds 1 to the score every time the user clicks
		function MultiplyPoint(x, y) {
			//position variables
			this.positionOnCanvas = [x, y];
			this.gridSizeOnCreation = gridSize;
			this.click = function() {
				//if the user wants to display points...
				if (drawDisplayPoints) {
					//draw a new particle
					globalDisplayPoints[displayPointNumber].newPoint([this.positionOnCanvas[0] - canWindow.relX, this.positionOnCanvas[1] - canWindow.relY], 1, '+');
					//increase the position on the globalDisplayPoints array
					displayPointNumber++;
					//if the position in the array is larger than the array length, reset it to 0
					if (displayPointNumber == globalDisplayPoints.length) {
						displayPointNumber = 0;
					}
				}
			}
			this.tick = function() { //tick function that is in all point classes
				//get the relative position of the point
				var posx = this.positionOnCanvas[0] - canWindow.relX;
				var posy = this.positionOnCanvas[1] - canWindow.relY;
				//draw the point
				ctx.fillStyle = "#E301FE";
				ctx.fillRect(posx-2, posy-2, 4, 4);
				//increase score if user has clicked
				if (score['clickScoreDebt'] > 0) {
					this.click();
					score['globalScore'] += 1;
					score['clickScoreDebt'] -= 1;
				}
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//erase location of this point
				canWindow.pointPosition[this.positionOnCanvas[1]/gridSize][this.positionOnCanvas[0]/gridSize] = 0;
				//subtract from how many are owned
				score['multipliesOwned'] -= 1;
				itemOwnedTotals['multipliesOwned'] -= 1;
				updateOwnedTotals();
			}
		}
		//set line's parent to the Point class
		MultiplyPoint.prototype = new Point();
		
		//the LinePoint class.  Each line consists of two points.
		function LinePoint(x, y, conTo) {
			//position variables
			this.positionOnCanvas = [x, y];
			this.gridSizeOnCreation = gridSize;
			this.conTo = [conTo[0], conTo[1]];
			this.lineCenter = [(this.positionOnCanvas[0] + this.conTo[0]) / 2, (this.positionOnCanvas[1] + this.conTo[1]) / 2];
			this.tickCounter = 0;
			this.tick = function() { //tick function that is in all point classes
				//get the relative position of the point
				var posx = this.positionOnCanvas[0] - canWindow.relX;
				var posy = this.positionOnCanvas[1] - canWindow.relY;
				//draw the line
				ctx.beginPath();
				ctx.moveTo(posx, posy);
				ctx.lineTo(this.conTo[0] - canWindow.relX, this.conTo[1] - canWindow.relY);
				ctx.strokeStyle = "#000000";
				ctx.lineWidth = 0.25;
				ctx.stroke();
				//draw the point
				ctx.fillStyle = "blue";
				ctx.fillRect(posx-2, posy-2, 4, 4);
				//add to the tick counter
				this.tickCounter += 1;
				//A full line will give 2 points per second
				if (this.tickCounter % actualFPS == 0 && this.tickCounter != 0) {
					//add to the score
					score['globalScore'] += 1;
					//if the user wants to display points...
					if (drawDisplayPoints) {
						//draw a new particle
						globalDisplayPoints[displayPointNumber].newPoint([this.lineCenter[0] - canWindow.relX, this.lineCenter[1] - canWindow.relY], 1, '+');
						//increase the position on the globalDisplayPoints array
						displayPointNumber++;
						//if the position in the array is larger than the array length, reset it to 0
						if (displayPointNumber == globalDisplayPoints.length) {
							displayPointNumber = 0;
						}
					}
				}
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//erase location of this point
				canWindow.pointPosition[Math.round(this.positionOnCanvas[1]/gridSize)][Math.round(this.positionOnCanvas[0]/gridSize)] = 0;
				//subtract from how many are owned in the GUI tracker
				itemOwnedTotals['linesOwned'] -= 1;
				updateOwnedTotals();
				//subtract from the score per second
				var sps = 2 * -1;
				calcSPS(sps);
				//erase point that this line is connected to
				//store the position of the other linepoint
				var connedTo = canWindow.pointPosition[Math.round(this.conTo[1]/gridSize)][Math.round(this.conTo[0]/gridSize)];
				//if the other point is an array...
				if (connedTo instanceof Array) {
					//...loop through
					for (var i=0; i<connedTo.length; i++) {
						//if the current object is another linepoint...
						if (connedTo[i] instanceof LinePoint) {
							//...check if it is connected to this object.  If it is, delete it from the array
							if (connedTo[i]['conTo'][0]==this.positionOnCanvas[0] && connedTo[i]['conTo'][1]==this.positionOnCanvas[1]) {
								connedTo.splice(i, 1);
							}
						}
					}
				//else, the other point is, in fact, the one connected to this point, so delete it
				} else {
					canWindow.pointPosition[Math.round(this.conTo[1]/gridSize)][Math.round(this.conTo[0]/gridSize)] = 0;
				}
			}
		}
		//set line's parent to the Point class
		LinePoint.prototype = new Point();
		
		//the ShapePoint class.  Each shape has a number of sides 'M' and an positionOnCanvas (origin point) [x, y]
		function ShapePoint(x, y, sides) {
			//position variable
			this.positionOnCanvas = [x, y];
			this.gridSizeOnCreation = gridSize;
			//number of sides
			this.N = sides;
			//current step
			this.step = 0;
			//the radius
			this.radius = 5 * gridSize;
			//the array to store all the angle data
			this.thetas = new Array(this.N);
			//the array to store all the vertex data
			this.vertList = new Array(this.N);
			this.tickCounter = 0;
			//set the sides
			this.setSides = function(sides) {
				this.sides = sides;
			}
			//function to increase all the angels by an even amount
			this.stepPoints = function(s) {
				//for every side
				for (var i=0; i<this.N; i++) {
					//multiply the current 'i' value by ((360/number of sides) + current step).  This serves to create points at even intervals all the way
					//around a circle, and have it increase by s every loop
					this.thetas[i] = (i*(360/this.N)) + s;
					//get the x value with radius*cos(angle for this point).  Same for y, only with sin.  Round both to 2 decimal places
					this.vertList[i] = [Math.round((this.radius*(Math.cos(Math.PI*(this.thetas[i]/180))))*100)/100, Math.round((this.radius*(Math.sin(Math.PI*(this.thetas[i]/180))))*100)/100];
				}
			}
			this.tick = function() { //the main loop for this object
				//setp all the points forward
				this.stepPoints(this.step);
				//for every side in this polyogn...
				for (var i=0; i<this.N; i++) {
					//shorten the location of the positions
					var posX = (this.vertList[i][0] + this.positionOnCanvas[0]) - canWindow.relX;
					var posY = (this.vertList[i][1] + this.positionOnCanvas[1]) - canWindow.relY;
					//begin drawing
					ctx.beginPath();
					//move to the x and y location of the current point
					ctx.moveTo(posX, posY);
					//if point is not the last in the array...
					if (i < this.N-1) {
						//draw a line to the next point in the array
						ctx.lineTo((this.vertList[i+1][0] + this.positionOnCanvas[0]) - canWindow.relX, (this.vertList[i+1][1] + this.positionOnCanvas[1]) - canWindow.relY);
					//else...
					} else {
						//draw a line to the first point in the array
						ctx.lineTo((this.vertList[0][0] + this.positionOnCanvas[0]) - canWindow.relX, (this.vertList[0][1] + this.positionOnCanvas[1]) - canWindow.relY);
					}
					//draw a line
					ctx.strokeStyle = "#000000";
					ctx.lineWidth = 0.5;
					//end
					ctx.stroke();
					//draw the vertex
					ctx.fillStyle = "orange";
					ctx.fillRect(posX-1, posY-1, 2, 2);
				}
				//draw the origin of the polygon
				ctx.fillStyle = "purple";
				ctx.fillRect((this.positionOnCanvas[0]-2) - canWindow.relX, (this.positionOnCanvas[1]-2) - canWindow.relY, 4, 4);
				//if the step is greater than 360, set it to 0 (this is for the drawing of the shape, not the points)
				this.step = this.step % 360;
				this.step += 3;
				//increase the tick counter
				this.tickCounter += 1;
				//add points
				if (this.tickCounter % Math.round(actualFPS/2) == 0 && this.tickCounter != 0) {
					//if the user wants to display points...
					if (drawDisplayPoints) {
						//draw a new particle
						globalDisplayPoints[displayPointNumber].newPoint([this.positionOnCanvas[0] - canWindow.relX, this.positionOnCanvas[1] - canWindow.relY], this.N*this.N, '+');
						//increase the position on the globalDisplayPoints array
						displayPointNumber++;
						//if the position in the array is larger than the array length, reset it to 0
						if (displayPointNumber == globalDisplayPoints.length) {
							displayPointNumber = 0;
						}
					}
					//add to the score
					score['globalScore'] += this.N*this.N;
					this.tickCounter = 0;
				}
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//erase location of this point
				canWindow.pointPosition[this.positionOnCanvas[1]/gridSize][this.positionOnCanvas[0]/gridSize] = 0;
				//subtract from how many are owned in the GUI tracker
				itemOwnedTotals['shapesOwned'] -= 1;
				updateOwnedTotals();
				//subtract from the score per second
				var sps = 2 * Math.pow(this.N, 2) * -1;
				calcSPS(sps);
			}
		}
		ShapePoint.prototype = new Point();
		
		//the CirclePoint class.
		function CirclePoint(x, y) {
			//position variable
			this.positionOnCanvas = [x, y];
			this.gridSizeOnCreation = gridSize;
			//current step
			this.step = 0;
			//the theta of the point that produces the point particles
			this.theta = 0;
			//tick function
			this.tick = function() {
				//if the time is divisible by 1/4th of a second...
				if (this.step % Math.round(actualFPS/6) == 0 && this.step != 0) {
					//shorten the location of the point
					var posX = (Math.round((60*(Math.cos(Math.PI*(this.theta/180))))*100)/100 + this.positionOnCanvas[0]) - canWindow.relX;
					var posY = (Math.round((60*(Math.sin(Math.PI*(this.theta/180))))*100)/100 + this.positionOnCanvas[1]) - canWindow.relY;
					//increase the score
					score['globalScore'] += 10;
					//if the user wants to display points...
					if (drawDisplayPoints) {
						//draw a new particle
						globalDisplayPoints[displayPointNumber].newPoint([posX-15, posY], 10, '+');
						//increase the position on the globalDisplayPoints array
						displayPointNumber++;
						//if the position in the array is larger than the array length, reset it to 0
						if (displayPointNumber == globalDisplayPoints.length) {
							displayPointNumber = 0;
						}
					}
					//if theta is equal to 360, make it 0
					if (this.theta == 360) {
						this.theta = 0;
					}
					//increase theta by 15
					this.theta += 10;
				}
				//begin drawing
				ctx.beginPath();
				//move to the x and y location of the current point
				ctx.arc(this.positionOnCanvas[0]-canWindow.relX, this.positionOnCanvas[1]-canWindow.relY, 60, 0, 2*Math.PI);
				//draw a line
				ctx.strokeStyle = "#FF9B01";
				ctx.lineWidth = 1.0;
				//end
				ctx.stroke();
				//draw the origin of the circle
				ctx.fillStyle = "#4389EE";
				ctx.fillRect((this.positionOnCanvas[0]-2) - canWindow.relX, (this.positionOnCanvas[1]-2) - canWindow.relY, 4, 4);
				//increase the step
				this.step++;
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//erase location of this point
				canWindow.pointPosition[this.positionOnCanvas[1]/gridSize][this.positionOnCanvas[0]/gridSize] = 0;
				//subtract from how many are owned in the GUI tracker
				itemOwnedTotals['circlesOwned'] -= 1;
				updateOwnedTotals();
				//subtract from the score per second
				calcSPS(-60);
			}
		}
		CirclePoint.prototype = new Point();
		
		function NewCustomShapePoint(x, y) {
			//relative center of the shape
			this.positionOnCanvas = [x, y];
			this.gridSizeOnCreation = gridSize;
			//number of sides
			this.N = 1;
			//first point placed
			this.firstPoint = [x, y];
			//the array to store all the vertex data
			this.Vp = [[x, y]];
			//step variable for tracking the number of steps that we pass through
			this.step = 0;
			//cost of the next point
			this.nextCost = 0;
			//function to re-calculate the center of the shape based on new data
			this.calculateCenter = function() {
				//calculate the center of the object
				//total of all the x-values
				var xTotal = 0;
				//total of all the y-values
				var yTotal = 0;
				//loop through all the verts
				for (var i=0; i<this.Vp.length; i++) {
					//add each value to the corosponding value total
					xTotal += this.Vp[i][0];
					yTotal += this.Vp[i][1];
				}
				//round each total to the nearest 10, and set the position on canvas.
				this.positionOnCanvas = [Math.round((xTotal/this.N) / gridSize)*gridSize, Math.round((yTotal/this.N) / gridSize)*gridSize];
			}
			//function to create the new shape
			this.createShape = function() {
				//begin changing from a temp shape to a full shape
				//recalculate the center, just to be safe
				this.calculateCenter();
				//set the location for the CustomShapePoint
				var b = [this.positionOnCanvas[0]/gridSize, this.positionOnCanvas[1]/gridSize]
				//if the position of the CustomShapePoint in the pointPosition array is already an array...
				if (canWindow.pointPosition[b[1]][b[0]] instanceof Array) {
					var foundPoint = false;
					//...push a new CustomShapePoint object into the array we tested for
					canWindow.pointPosition[b[1]][b[0]].push(new CustomShapePoint(this.Vp, this.positionOnCanvas));
				//if the position of the CustomShapePoint in the pointPosition array is already a point object...
				} else if (canWindow.pointPosition[b[1]][b[0]] instanceof Point) {
					//...create a new array containing the old point and the new one
						var newPointArray = [canWindow.pointPosition[b[1]][b[0]], new CustomShapePoint(this.Vp, this.positionOnCanvas)]
					canWindow.pointPosition[b[1]][b[0]] = newPointArray;
				//if the position of the CustomShapePoint in the pointPosition array does not contain any objects yet...
				} else {
					//...create a new CustomShapePoint
					canWindow.pointPosition[b[1]][b[0]] = new CustomShapePoint(this.Vp, this.positionOnCanvas);
				}
				//delete this temporary shape
				canWindow.pointPosition[this.firstPoint[0]/gridSize][this.firstPoint[1]/gridSize] = 0;
				//set the mouse action back to click
				mouseAction = CLICK;
				//set the making shape value to false
				makingShape = false;
			}
			//function to add an additional vertex to the shape, or, if the user clicked the starting vertex, finish the shape
			this.addPoint = function(x, y) {
				//the position of the new vertex
				var pos = [x, y];
				//if the position is equal to the first point in this shape...
				if (pos[0] == this.firstPoint[0] && pos[1] == this.firstPoint[1]) {
					this.createShape();
				//else, check that the user can afford the new vert (cost formula is ((4n^4 - 4(n-1)^4)*30)/2 if the vert is larger than 3)
				} else if (this.nextCost <= score.globalScore) {
					//append it to the array of verts
					this.Vp.push([pos[0], pos[1]]);
					//subtract the cost from the score
					score.globalScore -= this.nextCost;
					//if the user wants to display points...
					if (drawDisplayPoints) {
						//draw a new particle
						globalDisplayPoints[displayPointNumber].newPoint([pos[0] - canWindow.relX, pos[1] - canWindow.relY], this.nextCost, '-');
						//increase the position on the globalDisplayPoints array
						displayPointNumber++;
						//if the position in the array is larger than the array length, reset it to 0
						if (displayPointNumber == globalDisplayPoints.length) {
							displayPointNumber = 0;
						}
					}
					//add to the vertex number
					this.N += 1;
				} else {
					this.createShape();
				}
				//calculate the cost of the next point
				//only calculate cost if the vert is larger than 3
				if (this.N > 2) {
					this.nextCost = (30 * ((4 * Math.pow(this.N, 4)) - (4 * Math.pow(this.N - 1, 4)))) / 2;
				}
			}
			//the tick function
			this.tick = function() {
				//for every vertex in this polygon...
				for (var i=0; i<this.Vp.length; i++) {
					//shorten the location of the positions
					var posX = this.Vp[i][0] - canWindow.relX;
					var posY = this.Vp[i][1] - canWindow.relY;
					//if the step is smaller than half the FPS...
					if (this.step <= actualFPS/2) {
						//begin drawing.  This gives a strobe effect on the lines so the user knows the shape they are creating is not finished
						ctx.beginPath();
						//move to the x and y location of the current vertex
						ctx.moveTo(posX, posY);
						//if vertex is not the last in the array...
						if (i < this.N-1) {
							//draw a line to the next vertex in the array
							ctx.lineTo(this.Vp[i+1][0] - canWindow.relX, this.Vp[i+1][1] - canWindow.relY);
						//else, if it is going to be the next point...
						} else {
							//set the properties of the price text
							ctx.fillStyle = "red";
							ctx.font = 'italic 20pt Calibri';
							//if the user can afford the next point...
							if (this.nextCost <= score['globalScore']) {
								//draw a line to the cursor
								ctx.lineTo(cursorx*gridSize - canWindow.relX, cursory*gridSize - canWindow.relY);
								//draw how much the next point will cost if it isn't on the first point
								if (cursorx*gridSize != this.Vp[0][0] || cursory*gridSize != this.Vp[0][1]) {
									ctx.fillText("-" + this.nextCost, cursorx*gridSize - canWindow.relX, cursory*gridSize - canWindow.relY);
								}
							//else if they can't afford it...
							} else {
								//draw a line to the first point
								ctx.lineTo(this.Vp[0][0] - canWindow.relX, this.Vp[0][1] - canWindow.relY);
								//draw how much the next point will cost, and say it isn't enough
								if (cursorx*gridSize != this.Vp[0][0] || cursory*gridSize != this.Vp[0][1]) {
									ctx.fillText("-" + this.nextCost + " (Not Enough Points)", cursorx*gridSize - canWindow.relX, cursory*gridSize - canWindow.relY);
								}
							}
						}
						//set the color and weight, then draw the line
						ctx.strokeStyle = "#29A5D8";
						ctx.lineWidth = 0.25;
						ctx.stroke();
					}
					//recalculate the center of the polygon
					this.calculateCenter();
					//draw the vertex
					ctx.fillStyle = "#42D829";
					ctx.fillRect(posX-2, posY-2, 4, 4);
				}
				//draw the center vertex
				ctx.fillStyle = "#29D8D7";
				ctx.fillRect(this.positionOnCanvas[0]-canWindow.relX-2, this.positionOnCanvas[1]-canWindow.relY-2, 4, 4);
				//increase the step by two
				if (this.step <= actualFPS) {
					this.step += 2;
				} else {
					this.step = 0;
				}
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//do nothing becuase this is a constructor object
			}
		}
		NewCustomShapePoint.prototype = new Point();
		
		//the ShapePoint class.  Each shape has a number of sides 'M' and an positionOnCanvas (origin point) [x, y]
		function CustomShapePoint(vertPoints, center) {
			//position on the canvas, acts as the center, and it is determined as the average between all the other verts
			this.positionOnCanvas = center;
			this.gridSizeOnCreation = gridSize;
			//number of sides
			this.N = vertPoints.length;
			//current step
			this.step = 0;
			//current tick
			this.tickCounter = 0;
			//the array to store all the angle data
			this.thetas = new Array();
			//the array to store all the vertex data
			this.Vp = vertPoints;
			//an array to store all the original data of the vertPoints.  Useful for gamesaves
			this.originalVertPoints = new Array();
			//way to tell if this object has been constructed or not
			this.constructed = false;
			
			//constructor for this object
			this.construct = function() {
				//increase the score per second
				var sps = 3 * Math.pow(this.N, 3);
				calcSPS(sps);
				//set the length of thetas array
				for (var i=0; i<this.Vp.length; i++) {
					this.thetas.push(0);
				}
				
				//calculate the length of each hypotenuse (from each vertex to the center point)
				//loop through all the points
				for (var i=0; i<this.Vp.length; i++) {
					this.originalVertPoints.push([this.Vp[i][0], this.Vp[i][1]]);
					//use formula sqrt((x2-x1)^2 + (y2-y1)^2) to find length
					var thisLength = Math.sqrt(Math.pow((this.positionOnCanvas[0] - this.Vp[i][0]), 2) + Math.pow((this.positionOnCanvas[1] - this.Vp[i][1]), 2));
					//push result into each point's data
					this.Vp[i].push(thisLength);
				}
				
				//calculate each point's angle relative to 0 degrees
				//loop through all verts
				for (var i=0; i<this.Vp.length; i++) {
					//calculate the adjacent value
					var adj = this.Vp[i][0] - this.positionOnCanvas[0];
					//calculate the opposite value
					var opp = this.Vp[i][1] - this.positionOnCanvas[1];
					//calculate the theta of the triangle
					//if the vertex rests in quadrant I...
					if (adj >= 0 && opp >= 0) {
						//calculate for theta using inverse tangent
						this.thetas[i] = Math.round(Math.atan(opp/adj) * (180/Math.PI));
					//else if the vertex rests in quadrant II...
					} else if (adj < 0 && opp >= 0) {
						//calculate for theta using inverse tangent, and add 180 (This is where you really need to think.  In trig, the angle measured is the smallest angle between the hypotenuse and the x-axis.  We want the full angle from 0 though)
						this.thetas[i] = 180 + Math.round(Math.atan(opp/adj) * (180/Math.PI));
					//else if the vertex rests in quadrant III...
					} else if (adj < 0 && opp < 0) {
						//calculate for theta using inverse tangent, and add 180
						this.thetas[i] = 180 + Math.round(Math.atan(opp/adj) * (180/Math.PI));
					//else if the vertex rests in quadrant IV...
					} else if (adj >= 0 && opp < 0) {
						//calculate for theta using inverse tangent, and add 360
						this.thetas[i] = 360 + Math.round(Math.atan(opp/adj) * (180/Math.PI));
					}
				}
				
				//calculate the relative position of each vertex to the center
				//loop through all the verts
				for (var i=0; i<this.Vp.length; i++) {
					//set the relative x value
					this.Vp[i][0] = this.Vp[i][0] - this.positionOnCanvas[0];
					//set the relative y value
					this.Vp[i][1] = this.Vp[i][1] - this.positionOnCanvas[1];
				}
				
				//save the game
				saveGame();
				
				//set constructed to true
				this.constructed = true;
			}
			this.tick = function() { //the main loop for this object
				//if the object has not yet been constructed (will only run once, hopefully, or on a force-reconstruct if that is ever needed)
				if (this.constructed == false) {
					//call the constructor
					this.construct();
				//else
				} else {
					//loop through all points
					for (var i=0; i<this.Vp.length; i++) {
						//increase the angle by one
						//set the current theta value to the starting value plus the step
						var curTheta = this.thetas[i] + this.step/(this.N/5);
						//calculate the x and y values for each vertex
						this.Vp[i] = [this.Vp[i][2]*(Math.cos(Math.PI*(curTheta/180))), this.Vp[i][2]*(Math.sin(Math.PI*(curTheta/180))), this.Vp[i][2]];
					}
					//increase the step by one if it is under 360 (Step variable is only for calculating theta)
					if (this.step < 360*(this.N/5)) {
						this.step += 1;
					//if over 360, set it back to 0
					} else {
						this.step = 0;
					}
					//increase the tick counter
					this.tickCounter += 1;
					//add to the score
					if (this.tickCounter % Math.round(actualFPS/3) == 0 && this.tickCounter != 0) {
						//add n^4 to the score
						score['globalScore'] += Math.pow(this.N, 3);
						//loop through all points and display earnings
						for (var j=0; j<this.N; j++) {
							//if the user wants to display points...
							if (drawDisplayPoints) {
								//draw a new particle
								globalDisplayPoints[displayPointNumber].newPoint([this.Vp[j][0] + this.positionOnCanvas[0] - canWindow.relX, this.Vp[j][1] + this.positionOnCanvas[1] - canWindow.relY], Math.pow(this.N, 3)/this.N, '+');
								//increase the position on the globalDisplayPoints array
								displayPointNumber++;
								//if the position in the array is larger than the array length, reset it to 0
								if (displayPointNumber == globalDisplayPoints.length) {
									displayPointNumber = 0;
								}
							}
						}
						this.tickCounter = 0;
					}
					this.draw();
				}
			}
			//function to handle all of the canvas drawing
			this.draw = function() {
				//for every side in this polyogn...
				for (var i=0; i<this.N; i++) {
					//shorten the location of the positions
					var posX = (this.Vp[i][0] + this.positionOnCanvas[0]) - canWindow.relX;
					var posY = (this.Vp[i][1] + this.positionOnCanvas[1]) - canWindow.relY;
					//begin drawing
					ctx.beginPath();
					//move to the x and y location of the current vertex
					ctx.moveTo(posX, posY);
					//if vertex is not the last in the array...
					if (i < this.N-1) {
						//draw a line to the next vertex in the array
						ctx.lineTo((this.Vp[i+1][0] + this.positionOnCanvas[0]) - canWindow.relX, (this.Vp[i+1][1] + this.positionOnCanvas[1]) - canWindow.relY);
					//else...
					} else {
						//draw a line to the first vertex in the array
						ctx.lineTo((this.Vp[0][0] + this.positionOnCanvas[0]) - canWindow.relX, (this.Vp[0][1] + this.positionOnCanvas[1]) - canWindow.relY);
					}
					ctx.strokeStyle = "#29A5D8";
					ctx.lineWidth = 0.5;
					ctx.stroke();
					//draw the vertex itself
					ctx.fillStyle = "#eaa81a";
					ctx.fillRect(posX-2, posY-2, 4, 4);
				}
				//draw the center vertex
				ctx.fillStyle = "#9FD829";
				ctx.fillRect(this.positionOnCanvas[0]-canWindow.relX-2, this.positionOnCanvas[1]-canWindow.relY-2, 4, 4);
			}
			//function called when user deletes the point
			this.deleteSelf = function() {
				//erase location of this point
				canWindow.pointPosition[this.positionOnCanvas[1]/gridSize][this.positionOnCanvas[0]/gridSize] = 0;
				//subtract from how many are owned in the GUI tracker
				itemOwnedTotals['customShapesOwned'] -= 1;
				updateOwnedTotals();
				//subtract from the score per second
				var sps = 3 * Math.pow(this.N, 3) * -1;
				calcSPS(sps);
			}
		}
		CustomShapePoint.prototype = new Point();
//_______________________________________________________________________________________________________________________
		//Handlers for the GUI interface
		//Handlers for purchasing different items
		//change the picture on mouseover for a "hover" effect
		$("#BuyMultiply").mouseover(function() {
			//if the global score is greater than the multiply cost
			if (score['globalScore'] >= score['multiplyCost']) {
				//change the picture
				var src = "graphics/buttons/MultiplyPictureHoverLeft.png";
				$("#BuyMultiplyPictureLeft").attr("src", src);
				$("#BuyMultiplyPictureRight").css("backgroundImage", "url('graphics/buttons/MultiplyPictureHoverRight.png')");
			}
		})
		.mouseout(function() {
			//if the score is high enough (making sure we don't change on mouseover when it is greyed out)
			if (score['globalScore'] >= score['multiplyCost']) {
				//change the image to normal
				var src = "graphics/buttons/MultiplyPictureLeft.png";
				$("#BuyMultiplyPictureLeft").attr("src", src);
				$("#BuyMultiplyPictureRight").css("backgroundImage", "url('graphics/buttons/MultiplyPictureRight.png')");
			}
		})
		//when clicked, puchase 1 multiply for the current price
		.click(function() {
			//make sure score is higher than cost
			if (score['globalScore'] >= score['multiplyCost']) {
				//make sure nothing has been bought already
				if (mouseAction == CLICK) {
					//subtract the cost from the global score
					score['globalScore'] -= score['multiplyCost'];
					//set the mouse action to a new line being created
					mouseAction = NEWMULTIPLY;
					//set the number of multiplies owned to +1 for the GUI
					itemOwnedTotals['multipliesOwned'] += 1;
					updateOwnedTotals();
					//multiply the price by 1.5
					score['multiplyCost'] = 15 + (Math.pow(score['multipliesOwned'], 2) * 10);
					//update the GUI to display the new price
					var x = $("#BuyMultiplyPictureRight");
					x.html(score['multiplyCost']);
					//if the new number increased the width of the image, lower the font size until the width is 195
					while (x.width() > 195) {
						var newsize = parseInt(x.css('font-size')) - 1;
						newsize += "px";
						x.css("font-size", newsize);
					}
				}
			}
		});
		//change the picture on mouseover for a "hover" effect
		$("#BuyLine").mouseover(function() {
			//if the global score is greater than the line cost
			if (score['globalScore'] >= score['lineCost']) {
				//change the picture (there are two picture changes because it was the only way I knew how to have a dynamic point system that didn't mess everything up)
				var src = "graphics/buttons/LinePictureHoverLeft.png";
				$("#BuyLinePictureLeft").attr("src", src);
				$("#BuyLinePictureRight").css("backgroundImage", "url('graphics/buttons/LinePictureHoverRight.png')");
			}
		})
		.mouseout(function() {
			//if the score is high enough (making sure we don't change on mouseover when it is greyed out)
			if (score['globalScore'] >= score['lineCost']) {
				//change the image to normal
				var src = "graphics/buttons/LinePictureLeft.png";
				$("#BuyLinePictureLeft").attr("src", src);
				$("#BuyLinePictureRight").css("backgroundImage", "url('graphics/buttons/LinePictureRight.png')");
			}
		})
		//when clicked, puchase 1 line for the current price
		.click(function() {
			//make sure score is higher than cost
			if (score['globalScore'] >= score['lineCost']) {
				//make sure nothing has been bought already
				if (mouseAction == CLICK) {
					//subtract the cost from the global score
					score['globalScore'] -= score['lineCost'];
					//set the mouse action to a new line being created
					mouseAction = NEWLINE;
					//set the number of lines owned to +1 for the GUI
					itemOwnedTotals['linesOwned'] += 1;
					updateOwnedTotals();
					//increase the line cost based on the number of lines already owned
					score['lineCost'] = 30 + Math.round((Math.pow(score['linesOwned'], 2) * 10)/5);
					//update the GUI to display the new price
					var x = $("#BuyLinePictureRight");
					x.html(score['lineCost']);
					//if the new number increased the width of the image, lower the font size until the width is 195
					while (x.width() > 195) {
						var newsize = parseInt(x.css('font-size')) - 1;
						newsize += "px";
						x.css("font-size", newsize);
					}
					
				}
			}
		});
		//buy a shape (Mostly the same logic as the line)
		$("#BuyShape").mouseover(function() {
			if (score['globalScore'] >= score['shapeCost']) {
				var src = "graphics/buttons/ShapePictureHoverLeft.png";
				$("#BuyShapePictureLeft").attr("src", src);
				$("#BuyShapePictureRight").css("backgroundImage", "url('graphics/buttons/ShapePictureHoverRight.png')");
			}
		})
		.mouseout(function() {
			if (score['globalScore'] >= score['shapeCost']) {
				var src = "graphics/buttons/ShapePictureLeft.png";
				$("#BuyShapePictureLeft").attr("src", src);
				$("#BuyShapePictureRight").css("backgroundImage", "url('graphics/buttons/ShapePictureRight.png')");
			}
		})
		//when clicked, puchase 1 shape for the current price
		.click(function() {
			if (score['globalScore'] >= score['shapeCost']) {
				if (mouseAction == CLICK) {
					score['globalScore'] -= score['shapeCost'];
					mouseAction = NEWSHAPE;
					itemOwnedTotals['shapesOwned'] += 1;
					updateOwnedTotals();
					score['shapeCost'] = 270 + ((Math.pow(score['shapesOwned'], 2) * 30) / 2);
					var x = $("#BuyShapePictureRight");
					x.html(score['shapeCost']);
					while (x.width() > 195) {
						var newsize = parseInt(x.css('font-size')) - 1;
						newsize += "px";
						x.css("font-size", newsize);
					}
					
				}
			}
		});
		
		//buy a circle (mostly the same logic as the line)
		$("#BuyCircle").mouseover(function() {
			//if the global score is greater than the multiply cost
			if (score['globalScore'] >= score['circleCost']) {
				//change the picture
				var src = "graphics/buttons/CirclePictureHoverLeft.png";
				$("#BuyCirclePictureLeft").attr("src", src);
				$("#BuyCirclePictureRight").css("backgroundImage", "url('graphics/buttons/CirclePictureHoverRight.png')");
			}
		})
		.mouseout(function() {
			//if the score is high enough (making sure we don't change on mouseover when it is greyed out)
			if (score['globalScore'] >= score['circleCost']) {
				//change the image to normal
				var src = "graphics/buttons/CirclePictureLeft.png";
				$("#BuyCirclePictureLeft").attr("src", src);
				$("#BuyCirclePictureRight").css("backgroundImage", "url('graphics/buttons/CirclePictureRight.png')");
			}
		})
		//when clicked, puchase 1 circle for the current price
		.click(function() {
			//make sure score is higher than cost
			if (score['globalScore'] >= score['circleCost']) {
				//make sure nothing has been bought already
				if (mouseAction == CLICK) {
					//subtract the cost from the global score
					score['globalScore'] -= score['circleCost'];
					//set the mouse action to a new line being created
					mouseAction = NEWCIRCLE;
					//set the number of circles owned to +1 for the GUI
					itemOwnedTotals['circlesOwned'] += 1;
					updateOwnedTotals();
					//add to the cost
					score['circleCost'] = 900 + (Math.pow(score['circlesOwned'], 2) * 20);
					//update the GUI to display the new price
					var x = $("#BuyCirclePictureRight");
					x.html(score['circleCost']);
					//if the new number increased the width of the image, lower the font size until the width is 195
					while (x.width() > 195) {
						var newsize = parseInt(x.css('font-size')) - 1;
						newsize += "px";
						x.css("font-size", newsize);
					}
					
				}
			}
		});
		
		//buy a custom shape (Mostly the same logic as the line)
		$("#BuyCustomShape").mouseover(function() {
			if (score['globalScore'] >= score['customShapeCost']) {
				var src = "graphics/buttons/CustomShapePictureHoverLeft.png";
				$("#BuyCustomShapePictureLeft").attr("src", src);
				$("#BuyCustomShapePictureRight").css("backgroundImage", "url('graphics/buttons/CustomShapePictureHoverRight.png')");
			}
		})
		.mouseout(function() {
			if (score['globalScore'] >= score['customShapeCost']) {
				var src = "graphics/buttons/CustomShapePictureLeft.png";
				$("#BuyCustomShapePictureLeft").attr("src", src);
				$("#BuyCustomShapePictureRight").css("backgroundImage", "url('graphics/buttons/CustomShapePictureRight.png')");
			}
		})
		//when clicked, begin creation of a new custom shape
		.click(function() {
			if (score['globalScore'] >= score['customShapeCost']) {
				if (mouseAction == CLICK) {
					score['globalScore'] -= score['customShapeCost'];
					mouseAction = NEWCUSTOMSHAPE;
					itemOwnedTotals['customShapesOwned'] += 1;
					updateOwnedTotals();
					score['customShapeCost'] = 15000 + (Math.pow(score['customShapesOwned'], 4) * 30);
					var x = $("#BuyCustomShapePictureRight");
					x.html(score['customShapeCost']);
					while (x.width() > 195) {
						var newsize = parseInt(x.css('font-size')) - 1;
						newsize += "px";
						x.css("font-size", newsize);
					}
				}
			}
		});
//_______________________________________________________________________________________________________________________
		//handler for the "delete something" button
		//on mouseover
		$("#DeleteObject").mouseover(function() {
			//if the mouse isn't doing anything else
			if (mouseAction == CLICK) {
				//change the background color to red, and the font color to white
				$(this).css('background-color', 'red');
				$(this).css('color', '#ffffff');
			}
		})
		//on mouseout
		.mouseout(function() {
			//if the mouse is not doing anything else
			if (mouseAction == CLICK) {
				//change the background and font colors to default
				$(this).css('background-color', 'pink');
				$(this).css('color', '#000000');
			}
		})
		//when the user clicks
		.click(function() {
			//if the mouse is doing nothing else
			if (mouseAction == CLICK) {
				//change background color so user knows they clicked
				$(this).css('background-color', 'darkred');
				//set the next mouse action to delete object
				mouseAction = DELETEOBJECT;
			//else if we are already deleting an object...
			} else if (mouseAction == DELETEOBJECT) {
				//change everything back
				$(this).css('background-color', 'red');
				mouseAction = CLICK;
			}
		});
//_______________________________________________________________________________________________________________________
		//handler for the "Toggle Point Display" button
		//on mouseover
		$("#ToggleDisplayPoints").mouseover(function() {
			//if point display is on...
			if (drawDisplayPoints) {
				//change the background color to a darker green
				$(this).css('background-color', '#579836');
			//else if it is off
			} else {
				$(this).css('background-color', '#E02855');
			}
		})
		//on mouseout
		.mouseout(function() {
			//if point display is on...
			if (drawDisplayPoints) {
				$(this).css('background-color', '#7CDB4B');
			//else if point display is off...
			} else {
				$(this).css('background-color', '#FF6E74');
			}
		})
		//on click
		.click(function() {
			if (drawDisplayPoints) {
				drawDisplayPoints = false;
				$(this).css('border', '1px solid red');
				$(this).css('background-color', '#FF6E74');
			} else {
				drawDisplayPoints = true;
				$(this).css('border', '1px solid green');
				$(this).css('background-color', '#7CDB4B');
			}
		});
//_______________________________________________________________________________________________________________________
		//handler for the "New Game" button
		//on mouseover
		$("#NewGame").mouseover(function() {
			//change the background color to light grey
			$(this).css('background-color', '#cccccc');
		})
		//on mouseout
		.mouseout(function() {
			//change the background color to white
			$(this).css('background-color', 'white');
		})
		//on click
		.click(function() {
			//change the background color to grey
			$(this).css('background-color', 'grey');
			//call the newGame() function
			newGame();
		});
//_______________________________________________________________________________________________________________________
		//handlers for displaying points
		//array of all the GUI score objects
		var globalDisplayPoints = [];
		var drawDisplayPoints = true;
		var displayPointNumber = 0;
		//displayPoint object
		var displayPoints = function() {
			//set the local variables
			//how many points this particle stands for
			this.points = 0;
			//the x-coord random displacement
			this.positionMod = 0;
			//the starting position of the particle
			this.position = [0, 0];
			//whether or not this particle is in use
			this.isValidPart = false;
			//random color
			this.rawColor = [0, 0, 0];
			//opacity of the particle
			this.opacity = 0;
			//velocity of the particle
			this.velocity = 0.0;
			//the sign (positive or negative) of the particle
			this.sign = '+';
			
			//recycle the particle to make it act like a new particle
			this.newPoint = function(position, points, sign) {
				//set the value of points
				this.points = points;
				//set the position of the particle
				this.position = [position[0], position[1]];
				//roll a new position modifier
				this.positionMod =  -15 + Math.round(Math.random() * 30);
				//get a new randomized color
				this.rawColor = [Math.round(Math.random()*255), Math.round(Math.random()*255), Math.round(Math.random()*255)];
				//reset the opacity and velocity
				this.opacity = 1;
				this.velocity = 0.001;
				//set the sign (positive or negative)
				this.sign = sign;
				//set this to a valid particle
				this.isValidPart = true;
			}
			
			//loop that draws the point number on the screen
			this.draw = function() {
				if (drawDisplayPoints && this.isValidPart) {
					if (this.opacity > 0) {
						//set the color to the local random color
						var color = "rgba(" + this.rawColor[0] + ", " + this.rawColor[1] + ", " + this.rawColor[2] + ", " + this.opacity + ")";
						//set the context font
						ctx.font = 'italic 20pt Calibri';
						//set the fill style to our random color
						ctx.fillStyle = color;
						//draw the text
						ctx.fillText(this.sign + this.points, this.position[0]-this.positionMod, this.position[1]);
						//reduce opacity, and move it down, while increasing the velocity (gives an acceleration effect)
						this.opacity -= 0.05;
						this.position[1] += (380-actualFPS*3)*this.velocity;
						this.velocity *= 1.5+(15/actualFPS);
					} else {
						this.isValidPart = false;
					}
				}
			}
		}
		
		//populate the globalDisplayPoints array
		for (var i=0; i<100; i++) {
			globalDisplayPoints.push(new displayPoints());
		}
//_______________________________________________________________________________________________________________________
		//handlers for mouse events
		//function to get the mouse position relative to the canvas
		function getMousePos(canvas, evt) {
			var rect = canvas.getBoundingClientRect();
			return {
				x: evt.clientX - rect.left,
				y: evt.clientY - rect.top
			};
		}
		
		//handler for the mouse moving
		$(document).mousemove(function(e) {
		//plugging the mouse location into global grid array
			//get the mouse position
			var mPos = getMousePos(canvas, e);
			//checks to make sure vertecies are not drawn outside of canvas
			if (mPos.x >= canWindow.windowSize[0]) { mPos.x = canWindow.windowSize[0]; }
			if (mPos.y >= canWindow.windowSize[1]) { mPos.y = canWindow.windowSize[1]; }
			if (mPos.x <= 0) { mPos.x = 0; }
			if (mPos.y <= 0) { mPos.y = 0; }
			cursorx = Math.round((mPos.x + canWindow.relX) / gridSize);
			cursory = Math.round((mPos.y + canWindow.relY) / gridSize);
			$("#mousepos").html(mPos.x + ", " + mPos.y);
		})

		//handler for setting points (used in line creation
		//handles which point is being set
		var nextPointNum = 1;
		//temporary point data
		var point1;
		var arrayPoint1;
		var point2;
		var arrayPoint2;
		var makingShape = false;
		var curWIPShape;
		$("#Game").mousedown(function(e) {
			e.preventDefault();
			switch (e.which) {
				case 1: //Left Mouse Button
					switch (mouseAction) {
						case NEWLINE: //if user has bought a line;
							//check for which point is being created
							if (nextPointNum == 1) {
								//set point1, and make next point to be created point2
								arrayPoint1 = [cursorx, cursory]
								point1 = [gridSize*cursorx, gridSize*cursory];
								//if the position of point1 in the pointPosition array is already an array...
								if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Array) {
									//...push a new tempPoint object into the array we tested for
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].push(new TempPoint(point1[0], point1[1]));
								//if the position of point1 in the pointPosition array is a point object...
								} else if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Point) {
									//...create a new array containing the old point and the new one
									newPointArray = [canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]], new TempPoint(point1[0], point1[1])]
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = newPointArray;
								//if the position of point1 in the pointPosition array does not contain any objects yet...
								} else {
									//...create a new TempPoint
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = new TempPoint(point1[0], point1[1]);
								}
								//set the next point to be a LinePoint
								nextPointNum = 2;
							} else if (nextPointNum == 2) {
								//set point2, push the line to the line manager, and set next point to be created to point1
								arrayPoint2 = [cursorx, cursory];
								point2 = [gridSize*cursorx, gridSize*cursory];
								//same logic as the above if statement.  Replaces all the TempPoints with an instance of the LinePoint object
								if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Array) {
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].push(new LinePoint(point1[0], point1[1], point2));
									//remove the TempPoint by looping through array
									for (var i=0; i<canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].length; i++) {
										//if current point is a temppoint...
										if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]][i] instanceof TempPoint) {
											//remove it from the array
											canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].splice(i, 1);
										}
									}
								} else if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Point) {
									//create a variable to hold new point data
									var newPointArray;
									//if the new point is not a temp point...create a new array
									if (!(canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof TempPoint)) {
										//set variable data equal to array containing old point and new linepoint
										newPointArray = [canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]], new LinePoint(point1[0], point1[1], point2)];
									} else if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof TempPoint) {
										//else, if the point was a tempPoint, remove it
										newPointArray = new LinePoint(point1[0], point1[1], point2);
									}
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = newPointArray;
								} else {
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = new LinePoint(point1[0], point1[1], point2);
								}
								//same logic still.  Places the second point in the pointPosition array
								if (canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]] instanceof Array) {
									canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]].push(new LinePoint(point2[0], point2[1], point1));
									//remove the TempPoint by looping through array
									for (var i=0; i<canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]].length; i++) {
										//if current point is a temppoint...
										if (canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]][i] instanceof TempPoint) {
											//remove it from the array
											canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]].splice(i, 1);
										}
									}
								} else if (canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]] instanceof Point) {
									//create a new variable to hold new point data
									var newPointArray;
									//if the new point is not a temp point...create a new array
									if (!(canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]] instanceof TempPoint)) {
										//set the variable data equal to array containing old point and new linepoint
										newPointArray = [canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]], new LinePoint(point2[0], point2[1], point1)];
									} else {
										//else, if the point was a tempPoint, remove it
										newPointArray = new Linepoint(point2[0], point2[1], point1);
									}
									canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]] = newPointArray;
								} else {
									canWindow.pointPosition[arrayPoint2[1]][arrayPoint2[0]] = new LinePoint(point2[0], point2[1], point1);
								}
								score['linesOwned'] += 1;
								//calculate new score per second
								calcSPS(2);
								//set the next point to be created as a temporary point
								nextPointNum = 1;
								mouseAction = CLICK;
							}
							//save the game
							saveGame();
							break;
						case NEWSHAPE:
							//set the location for the ShapePoint
							arrayPoint1 = [cursorx, cursory]
							point1 = [gridSize*cursorx, gridSize*cursory];
							//if the position of the ShapePoint in the pointPosition array is already an array...
							if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Array) {
								var foundPoint = false;
								//...push a new ShapePoint object into the array we tested for
								//loop through array
								for (var i=0; i<canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].length; i++) {
									//if there is a shapepoint object already...
									if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]][i] instanceof ShapePoint) {
										//add to the number of sides
										canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]][i].N +=1;
										//increase the score per second
										var sps = 2 * Math.pow(canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]][i].N, 2);
										sps -= 2 * Math.pow(canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]][i].N - 1, 2);
										calcSPS(sps);
										//not actually new shape
										itemOwnedTotals['shapesOwned'] -= 1;
										updateOwnedTotals();
										//tell the game we have another shape
										score['shapesOwned'] += 1;
										//tell the loop we found a point
										foundPoint = true;
									}
								}
								//if there was no shapepoint found...
								if (!foundPoint) {
									//create one!
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].push(new ShapePoint(point1[0], point1[1], 3));
									//increase the score per second
									calcSPS(18);
									//tell the game we have another shape
									score['shapesOwned'] += 1;
								}
							//if the position of the ShapePoint in the pointPosition array is already a point object...
							} else if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Point) {
								//...create a new array containing the old point and the new one
								if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof ShapePoint) {
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].N += 1;
									//increase the score per second
									var sps = 2 * Math.pow(canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].N, 2);
									sps -= 2 * Math.pow(canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].N - 1, 2);
									calcSPS(sps);
									//not actually new shape
									itemOwnedTotals['shapesOwned'] -= 1;
									updateOwnedTotals();
									//tell the game we have another shape
									score['shapesOwned'] += 1;
								} else {
									var newPointArray = [canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]], new ShapePoint(point1[0], point1[1], 3)];
									canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = newPointArray;
									//increase the score per second
									calcSPS(18);
									//tell the game we have another shape
									score['shapesOwned'] += 1;
								}
							//if the position of the ShapePoint in the pointPosition array does not contain any objects yet...
							} else {
								//...create a new ShapePoint
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = new ShapePoint(point1[0], point1[1], 3);
								//increase the score per second
								calcSPS(18);
								//tell the game we have another shape
								score['shapesOwned'] += 1;
							}
							mouseAction = CLICK;
							//save the game
							saveGame();
							break;
						case NEWMULTIPLY:
							//set the location for the MultiplyPoint
							arrayPoint1 = [cursorx, cursory]
							point1 = [gridSize*cursorx, gridSize*cursory];
							//if the position of the MultiplyPoint in the pointPosition array is already an array...
							if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Array) {
								var foundPoint = false;
								//...push a new MultiplyPoint object into the array we tested for
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].push(new MultiplyPoint(point1[0], point1[1]));
								//tell the game we have another multiply
								score['multipliesOwned'] += 1;
							//if the position of the MultiplyPoint in the pointPosition array is already a point object...
							} else if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Point) {
								//...create a new array containing the old point and the new one
								var newPointArray = [canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]], new MultiplyPoint(point1[0], point1[1])]
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = newPointArray;
								//tell the game we have another multiply
								score['multipliesOwned'] += 1;
							//if the position of the MultiplyPoint in the pointPosition array does not contain any objects yet...
							} else {
								//...create a new MultiplyPoint
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = new MultiplyPoint(point1[0], point1[1]);
								//tell the game we have another multiply
								score['multipliesOwned'] += 1;
							}
							mouseAction = CLICK;
							//save the game
							saveGame();
							break;
						case NEWCIRCLE:
							//set the location for the CirclePoint
							arrayPoint1 = [cursorx, cursory]
							point1 = [gridSize*cursorx, gridSize*cursory];
							//if the position of the CirclePoint in the pointPosition array is already an array...
							if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Array) {
								var foundPoint = false;
								//...push a new CirclePoint object into the array we tested for
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].push(new CirclePoint(point1[0], point1[1]));
								//tell the game we have another circle
								score['circlesOwned'] += 1;
								//increase the score per second
								calcSPS(60);
							//if the position of the CirclePoint in the pointPosition array is already a point object...
							} else if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Point) {
								//...create a new array containing the old point and the new one
								var newPointArray = [canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]], new CirclePoint(point1[0], point1[1])]
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = newPointArray;
								//tell the game we have another circle
								score['circlesOwned'] += 1;
								//increase the score per second
								calcSPS(60);
							//if the position of the CirclePoint in the pointPosition array does not contain any objects yet...
							} else {
								//...create a new CirclePoint
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] = new CirclePoint(point1[0], point1[1]);
								//tell the game we have another circle
								score['circlesOwned'] += 1;
								//increase the score per second
								calcSPS(60);
							}
							mouseAction = CLICK;
							//save the game
							saveGame();
							break;
						case NEWCUSTOMSHAPE:
							//if user is not currently making a shape, and the user can afford it (they get 3 free sides when they buy)...
							if (makingShape == false) {
								//create a new shape at the cursor
								canWindow.pointPosition[cursorx][cursory] = new NewCustomShapePoint(gridSize*cursorx, gridSize*cursory);
								//set the location of the current shape
								curWIPShape = [cursorx, cursory];
								//set making shape to true
								makingShape = true;
								//add to how many shapes the player owns
								score['customShapesOwned'] += 1;
							//else, if the user is already creating a shape...
							} else {
								//add one point to the shape
								canWindow.pointPosition[curWIPShape[0]][curWIPShape[1]].addPoint(cursorx*gridSize, cursory*gridSize);
							}
							break;
						case DELETEOBJECT:
							//set the array point to the cursor position
							arrayPoint1 = [cursorx, cursory];
							//if the point clicked is an array
							if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Array) {
								//loop through the array, and delete all points in it
								//make a copy of the current array
								var curArray = canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]];
								for (var i=0; i<curArray.length; i++) {
									//call the delete method for the point object
									curArray[i].deleteSelf();
								}
								//set the mouse action to clicking again
								mouseAction = CLICK;
								//change the background and font colors to default on the delete object button
								$("#DeleteObject").css('background-color', 'pink');
								$("#DeleteObject").css('color', '#000000');
							//else, if the point is simply a point
							} else if (canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]] instanceof Point) {
								//call the delete method on the point object
								canWindow.pointPosition[arrayPoint1[1]][arrayPoint1[0]].deleteSelf();
								//set the mouse action to clicking again
								mouseAction = CLICK;
								//change the background and font colors to default on the delete object button
								$("#DeleteObject").css('background-color', 'pink');
								$("#DeleteObject").css('color', '#000000');
							}
							//save the game
							saveGame();
							break;
						default: //default is add to the score
							var addedPoint = false;
							//add 1 to the score
							score['globalScore'] += 1;
							//set the clickScoreDebt equal to the number of MultiplyPoints owned.
							score['clickScoreDebt'] = score['multipliesOwned'];
							//if the user wants to display points...
							if (drawDisplayPoints) {
								//draw a new particle
								globalDisplayPoints[displayPointNumber].newPoint([cursorx*gridSize - canWindow.relX, cursory*gridSize - canWindow.relY], 1*score['clickMod'], '+');
								//increase the position on the globalDisplayPoints array
								displayPointNumber++;
								//if the position in the array is larger than the array length, reset it to 0
								if (displayPointNumber == globalDisplayPoints.length) {
									displayPointNumber = 0;
								}
							}
						}
					break;
				default:
					return false;
			}
		});
//_______________________________________________________________________________________________________________
		//Save and Load handlers (save to session data)
		//javascript data fetching via ajax, php, and sql
		function get_data_async(phpfile, action, data) {
			if (!data) {
				var data = '';
			}
			var value = $.ajax({
				type: "POST",
				url: phpfile,
				data: {action: action, data: data, score: "" + score['globalScore']},
				async: true
			}).responseText;
			return value;
		}
		function get_data(phpfile, action, data) {
			if (!data) {
				var data = '';
			}
			var value = $.ajax({
				type: "POST",
				url: phpfile,
				data: {action: action, data: data, score: "" + score['globalScore']},
				async: false
			}).responseText;
			return value;
		}
		//function to start a new game
		function newGame() {
			for (var b=0; b<canWindow.pointPosition.length; b++) {
				for (var a=0; a<canWindow.pointPosition[b].length; a++) {
					canWindow.pointPosition[b][a] = 0;
				}
			}
			score = {globalScore: 0, sps: 0, multiplyCost: 15, multipliesOwned: 0, clickScoreDebt: 0, lineCost: 30, linesOwned: 1, shapeCost: 270, shapesOwned: 1, circleCost: 900, circlesOwned: 0, customShapeCost: 15000, customShapesOwned: 1, clickMod: 1};
			itemOwnedTotals = {multipliesOwned: 0, linesOwned: 0, shapesOwned: 0, circlesOwned: 0, customShapesOwned: 0};
			updateOwnedTotals();
			//array of all element names to be modified
			var x = ["#BuyMultiplyPictureRight", "#BuyLinePictureRight", "#BuyShapePictureRight", "#BuyCirclePictureRight", "#BuyCustomShapePictureRight"];
			//array of item costs
			var cost = [score['multiplyCost'], score['lineCost'], score['shapeCost'], score['circleCost'], score['customShapeCost']];
			//loop through all elements in need of cost change
			for (var i=0; i<x.length; i++) {
				//set the cost to the correct number
				$(x[i]).html(cost[i]);
				//resize the font until it fits
				while ($(x[i]).width() > 195) {
					var newsize = parseInt($(x[i]).css('font-size')) - 1;
					newsize += "px";
					$(x[i]).css("font-size", newsize);
				}
			}
			calcSPS(0);
			saveGame();
		}
		//function to save the game
		function saveGame() {
			//new array to store the data
			var pointData = new Array();
			//for all y values in the pointposition array
			for (var b=0; b<canWindow.pointPosition.length; b++) {
				//push a row into the data array
				pointData.push(new Array());
				//for all x values in the current row
				for (var a=0; a<canWindow.pointPosition[b].length; a++) {
					//get the current point
					var cur = canWindow.pointPosition[b][a];
					//if the current point is an array containing multiple points...
					if (cur instanceof Array) {
						pointData[b].push(new Array());
						for (var i=0; i<canWindow.pointPosition[b][a].length; i++) {
							if (cur[i] instanceof MultiplyPoint) {
								pointData[b][a].push(["Point"]);
							} else if (cur[i] instanceof LinePoint) {
								pointData[b][a].push(["Line", [Math.round(cur[i]['conTo'][0]/gridSize), Math.round(cur[i]['conTo'][1]/gridSize)]]);
							} else if (cur[i] instanceof ShapePoint) {
								pointData[b][a].push(["Shape", cur[i]['N']]);
							} else if (cur[i] instanceof CirclePoint) {
								pointData[b][a].push(["Circle"]);
							} else if (cur[i] instanceof CustomShapePoint) {
								pointData[b].push(["CustomShape", cur[i]['originalVertPoints'], [cur[i]['positionOnCanvas'][0], cur[i]['positionOnCanvas'][1]], gridSize]);
							}
						}
					//else if the current point is a point...
					} else if (cur instanceof Point) {
						//if it is a Multiply point, push the point data
						if (cur instanceof MultiplyPoint) {
							pointData[b].push(["Point"]);
						//if it is a Line point, push the point data
						} else if (cur instanceof LinePoint) {
							pointData[b].push(["Line", [Math.round(cur['conTo'][0]/gridSize), Math.round(cur['conTo'][1]/gridSize)]]);
						//if it is a Shape point, push the point data
						} else if (cur instanceof ShapePoint) {
							pointData[b].push(["Shape", cur['N']]);
						//if it is a Circle point, push the point data
						} else if (cur instanceof CirclePoint) {
							pointData[b].push(["Circle"]);
						//if it is a Custom Shape point, push the point data
						} else if (cur instanceof CustomShapePoint) {
							pointData[b].push(["CustomShape", cur['originalVertPoints'], [cur['positionOnCanvas'][0], cur['positionOnCanvas'][1]], gridSize]);
						} else {
							pointData[b].push(0);
						}
					//else it is empty, so push a 0 into it
					} else {
						pointData[b].push(0);
					}
				}
			}
			//parse the data into JSON format
			var saveData = JSON.stringify(pointData);
			//send data to PHP to be saved as a session variable
			var success = get_data_async("SessionSave.php", 'save', saveData);
		}
		//function that loads game data
		function loadGame() {
			//load the data from session variable
			var loadData = get_data("SessionSave.php", 'load', "");
			//if the data is not blank
			if (loadData != "") {
				//parse the data
				console.log(loadData);
				var pointData = JSON.parse(loadData);
				//store the number of objects we are about to create
				var totalMultiplies = 0;
				var totalLines = 0;
				var totalShapes = 0;
				var totalShapeSides = 0;
				var totalCircles = 0;
				var totalCustomShapes = 0;
				//reset the score per second
				score['sps'] = 0;
				//loop through the pointData and populate the pointPosition array
				for (var b=0; b<pointData.length; b++) {
					for (var a=0; a<pointData[b].length; a++) {
						//calculate canvas position of point
						position = [a*gridSize, b*gridSize];
						//if the point we are checking is not blank...
						if (pointData[b][a] instanceof Array) {
							//if the point we are checking contains multiple points...
							if (pointData[b][a][0] instanceof Array) {
								//create a new array at the square on the pointPosition array, and use the same methods as above
								canWindow.pointPosition[b][a] = new Array();
								for (var v=0; v<pointData[b][a].length; v++) {
									if (pointData[b][a][v][0] == "Point") {
										canWindow.pointPosition[b][a].push(new MultiplyPoint(position[0], position[1]));
										//add to total multiplies
										totalMultiplies++;
									} else if (pointData[b][a][v][0] == "Line") {
										canWindow.pointPosition[b][a].push(new LinePoint(position[0], position[1], [pointData[b][a][v][1][0]*gridSize, pointData[b][a][v][1][1]*gridSize]));
										//add to total lines and sps
										totalLines++;
										//calculate score per second
										calcSPS(1);
									} else if (pointData[b][a][v][0] == "Shape") {
										canWindow.pointPosition[b][a].push(new ShapePoint(position[0], position[1], pointData[b][a][v][1]));
										//add to total shapes and sps
										totalShapes++;
										totalShapeSides += pointData[b][a][v][1]-2;
										//calculate score per second
										calcSPS(2 * Math.pow(pointData[b][a][v][1], 2));
									} else if (pointData[b][a][v][0] == "Circle") {
										canWindow.pointPosition[b][a].push(new CirclePoint(position[0], position[1]));
										//add to total circles and sps
										totalCircles++;
										//calculate score per second
										calcSPS(60);
									} else if (pointData[b][a][v][0] == "CustomShape") {
										//grab the old grid size
										var oldGrid = pointData[b][a][v][3];
										//grab the old coordinates
										var oldCoords = [pointData[b][a][v][2][0], pointData[b][a][v][2][1]];
										var oldVerts = pointData[b][a][v][1];
										//calculate the new coordinates
										var newX = Math.round(oldCoords[0]/oldGrid) * gridSize;
										var newY = Math.round(oldCoords[1]/oldGrid) * gridSize;
										var newVerts = new Array();
										for (var z=0; z<oldVerts.length; z++) {
											newVerts.push([Math.round(oldVerts[z][0]/oldGrid) * gridSize, Math.round(oldVerts[z][1]/oldGrid) * gridSize])
										}
										canWindow.pointPosition[b][a] = new CustomShapePoint(newVerts, [newX, newY]);
										//add to total custom shapes and sps
										totalCustomShapes++;
										//calculate score per second
										calcSPS(3 * Math.pow(pointData[b][a][v][1].length, 3));
									}
								}
							//if loaded square is a point...
							} else if (pointData[b][a][0] == "Point") {
								//create a point on the pointPosition array
								canWindow.pointPosition[b][a] = new MultiplyPoint(position[0], position[1]);
								//add to total multiplies
								totalMultiplies++;
							//if loaded square is a line...
							} else if (pointData[b][a][0] == "Line") {
								//create a line on the pointPosition array
								canWindow.pointPosition[b][a] = new LinePoint(position[0], position[1], [pointData[b][a][1][0]*gridSize, pointData[b][a][1][1]*gridSize]);
								//add to total lines and sps
								totalLines++;
								//calculate score per second
								calcSPS(1);
							//if loaded square is a shape...
							} else if (pointData[b][a][0] == "Shape") {
								//create a shape on the pointPosition array
								canWindow.pointPosition[b][a] = new ShapePoint(position[0], position[1], pointData[b][a][1]);
								//add to total shapes and sps
								totalShapes++;
								totalShapeSides += pointData[b][a][1]-2;
								//calculate score per second
								calcSPS(2 * Math.pow(pointData[b][a][1], 2));
							//if loaded square is a circle...
							} else if (pointData[b][a][0] == "Circle") {
								//create a circle on the pointPosition array
								canWindow.pointPosition[b][a] = new CirclePoint(position[0], position[1]);
								//add to total circles and sps
								totalCircles++;
								//calculate the score per second
								calcSPS(60);
							//if loaded square is a custom shape...
							} else if (pointData[b][a][0] == "CustomShape") {
								//grab the old grid size
								var oldGrid = pointData[b][a][3];
								//grab the old coordinates
								var oldCoords = [pointData[b][a][2][0], pointData[b][a][2][1]];
								var oldVerts = pointData[b][a][1];
								//calculate the new coordinates
								var newX = Math.round(oldCoords[0]/oldGrid) * gridSize;
								var newY = Math.round(oldCoords[1]/oldGrid) * gridSize;
								var newVerts = new Array();
								for (var z=0; z<oldVerts.length; z++) {
									newVerts.push([Math.round(oldVerts[z][0]/oldGrid) * gridSize, Math.round(oldVerts[z][1]/oldGrid) * gridSize])
								}
								canWindow.pointPosition[b][a] = new CustomShapePoint(newVerts, [newX, newY]);
								//add to total custom shapes and sps
								totalCustomShapes++;
								//calculate the score per second
								calcSPS(3 * Math.pow(pointData[b][a][1].length, 3));
							}
						} else {
							canWindow.pointPosition[b][a] = 0;
						}
					}
				}
				//divide lines by two (each line consists of 2 objects)
				totalLines /= 2;
				//change global modifiers to fit the new criteria
				//points
				score['multipliesOwned'] = totalMultiplies;
				itemOwnedTotals['multipliesOwned'] = totalMultiplies;
				//multiply cost calculation
				score['multiplyCost'] = 15 + (Math.pow(totalMultiplies, 2) * 10);
				
				//lines
				score['linesOwned'] = totalLines;
				itemOwnedTotals['linesOwned'] = totalLines;
				//line cost calculation
				score['lineCost'] = 30 + Math.round((Math.pow(totalLines, 2) * 10)/5);
				
				//shapes
				score['shapesOwned'] = totalShapeSides;
				itemOwnedTotals['shapesOwned'] = totalShapes;
				//shape cost calculation
				score['shapeCost'] = 270 + ((Math.pow(totalShapeSides, 2) * 30) / 2);
				
				//circles
				score['circlesOwned'] = totalCircles;
				itemOwnedTotals['circlesOwned'] = totalCircles;
				//circle cost calculation
				score['circleCost'] = 900 + (Math.pow(totalCircles, 2) * 20);
				
				//custom shapes
				score['customShapesOwned'] = totalCustomShapes;
				itemOwnedTotals['customShapesOwned'] = totalCustomShapes;
				//custom shapes cost calculation
				score['customShapeCost'] = 15000 + (Math.pow(totalCustomShapes, 4) * 30);
				
				//update the GUI with the new totals
				updateOwnedTotals();
				//array of all element names to be modified
				var x = ["#BuyMultiplyPictureRight", "#BuyLinePictureRight", "#BuyShapePictureRight", "#BuyCirclePictureRight", "#BuyCustomShapePictureRight"];
				//array of item costs
				var cost = [score['multiplyCost'], score['lineCost'], score['shapeCost'], score['circleCost'], score['customShapeCost']];
				//loop through all elements in need of cost change
				for (var i=0; i<x.length; i++) {
					//set the cost to the correct number
					$(x[i]).html(cost[i]);
					//resize the font until it fits
					while ($(x[i]).width() > 195) {
						var newsize = parseInt($(x[i]).css('font-size')) - 1;
						newsize += "px";
						$(x[i]).css("font-size", newsize);
					}
				}
				//load the score
				var loadScore = get_data("SessionSave.php", 'score', "");
				console.log(loadScore)
				score['globalScore'] = parseInt(loadScore);
			}
		}
//_______________________________________________________________________________________________________________
		//The Game Loop//
		/*
		 ___________________
		/                   \
		|                   |
		|                   |
		|                   |
		|                   |
		|                   |
		\___________________/
		
		*/
		//this function is called every tick to draw everything.
		function draw() {
			//check and see if anything is affordable, and if not, grey it out
			//if the global score is less than the line cost
			if (score['globalScore'] < score['lineCost']) {
				//grey out the picture
				var src = "graphics/buttons/LinePictureLockedLeft.png";
				$("#BuyLinePictureLeft").attr("src", src);
				$("#BuyLinePictureRight").css("backgroundImage", "url('graphics/buttons/LinePictureLockedRight.png')");
			} else {
				//else, change the picture to normal
				var src = "graphics/buttons/LinePictureLeft.png";
				if ($("#BuyLinePictureLeft").attr("src") == "graphics/buttons/LinePictureLockedLeft.png") {
					$("#BuyLinePictureLeft").attr("src", src);
					$("#BuyLinePictureRight").css("backgroundImage", "url('graphics/buttons/LinePictureRight.png')");
				}
			}
			//check for point (same logic as line)
			if (score['globalScore'] < score['multiplyCost']) {
				var src = "graphics/buttons/MultiplyPictureLockedLeft.png";
				$("#BuyMultiplyPictureLeft").attr("src", src);
				$("#BuyMultiplyPictureRight").css("backgroundImage", "url('graphics/buttons/MultiplyPictureLockedRight.png')");
			} else {
				var src = "graphics/buttons/MultiplyPictureLeft.png";
				if ($("#BuyMultiplyPictureLeft").attr("src") == "graphics/buttons/MultiplyPictureLockedLeft.png") {
					$("#BuyMultiplyPictureLeft").attr("src", src);
					$("#BuyMultiplyPictureRight").css("backgroundImage", "url('graphics/buttons/MultiplyPictureRight.png')");
				}
			}
			//check for shape (same logic as line)
			if (score['globalScore'] < score['shapeCost']) {
				var src = "graphics/buttons/ShapePictureLockedLeft.png";
				$("#BuyShapePictureLeft").attr("src", src);
				$("#BuyShapePictureRight").css("backgroundImage", "url('graphics/buttons/ShapePictureLockedRight.png')");
			} else {
				var src = "graphics/buttons/ShapePictureLeft.png";
				if ($("#BuyShapePictureLeft").attr("src") == "graphics/buttons/ShapePictureLockedLeft.png") {
					$("#BuyShapePictureLeft").attr("src", src);
					$("#BuyShapePictureRight").css("backgroundImage", "url('graphics/buttons/ShapePictureRight.png')");
				}
			}
			//check for circle (same logic as line)
			if (score['globalScore'] < score['circleCost']) {
				var src = "graphics/buttons/CirclePictureLockedLeft.png";
				$("#BuyCirclePictureLeft").attr("src", src);
				$("#BuyCirclePictureRight").css("backgroundImage", "url('graphics/buttons/CirclePictureLockedRight.png')");
			} else {
				var src = "graphics/buttons/CirclePictureLeft.png";
				if ($("#BuyCirclePictureLeft").attr("src") == "graphics/buttons/CirclePictureLockedLeft.png") {
					$("#BuyCirclePictureLeft").attr("src", src);
					$("#BuyCirclePictureRight").css("backgroundImage", "url('graphics/buttons/CirclePictureRight.png')");
				}
			}
			//check for custom shape (same logic as line)
			if (score['globalScore'] < score['customShapeCost']) {
				var src = "graphics/buttons/CustomShapePictureLockedLeft.png";
				$("#BuyCustomShapePictureLeft").attr("src", src);
				$("#BuyCustomShapePictureRight").css("backgroundImage", "url('graphics/buttons/CustomShapePictureLockedRight.png')");
			} else {
				var src = "graphics/buttons/CustomShapePictureLeft.png";
				if ($("#BuyCustomShapePictureLeft").attr("src") == "graphics/buttons/CustomShapePictureLockedLeft.png") {
					$("#BuyCustomShapePictureLeft").attr("src", src);
					$("#BuyCustomShapePictureRight").css("backgroundImage", "url('graphics/buttons/CustomShapePictureRight.png')");
				}
			}
			//make sure that the score doesn't extend past it's boundaries
			var x = $("#Score");
			while (x.width()+155 > $("#scoreWrapper").width()) {
				var newsize = parseInt(x.css('font-size')) - 1;
				newsize += "px";
				x.css("font-size", newsize);
			}
			if (parseInt(x.css('font-size')) < 100) {
				while (x.width()+150 < $("#scoreWrapper").width() && parseInt(x.css('font-size')) < 100) {
					var newsize = parseInt(x.css('font-size')) + 1;
					newsize += "px";
					x.css("font-size", newsize);
				}
			}
			
			//reset the canvas
			ctx.fillStyle = "white"
			ctx.fillRect(0, 0, canWindow.totalCanvasSize[0], canWindow.totalCanvasSize[1]);
			//redraw the grid
			for (var i=gridSize; i < canWindow.windowSize[0]+gridSize; i+=gridSize) {
				ctx.beginPath();
				ctx.moveTo(i, 0);
				ctx.lineTo(i, canWindow.windowSize[1]+gridSize);
				ctx.strokeStyle = "#000000";
				ctx.lineWidth = 0.1;
				ctx.stroke();
			}
			for (var i=gridSize; i<canWindow.totalCanvasSize[1]; i+=gridSize) {
				ctx.beginPath();
				ctx.moveTo(0, i);
				ctx.lineTo(canWindow.totalCanvasSize[0], i);
				ctx.strokeStyle = "#000000";
				ctx.lineWidth = 0.1;
				ctx.stroke();
			}
			//reduce opacity in array of the previous red, mouse-following dot marker
			for (var i=0; i<canWindow.pointPosition.length; i++) {
				for (var k=0; k<canWindow.pointPosition[i].length; k++) {
					//make sure to always save non-permanent data in values less than one
					if (canWindow.pointPosition[i][k] > 0 && canWindow.pointPosition[i][k] <= 1) {
						canWindow.pointPosition[i][k] -= 0.25;
					}
				}
			}
			//place a red dot marker as close as possible to the cursor
			if (canWindow.pointPosition[cursory][cursorx] == 0) {
				canWindow.pointPosition[cursory][cursorx] = 1;
			}
			//redraw the vertices
			for (var i=0; i<canWindow.pointPosition.length; i++) {
				for (var k=0; k<canWindow.pointPosition[i].length; k++) {
					var curPoint = canWindow.pointPosition[i][k];
					//red dot that follows the mouse (fade effect, has value of <1)
					if (!isNaN(curPoint)) {
						var posx = gridSize*k - canWindow.relX;
						var poxy = gridSize*i - canWindow.relY;
						ctx.fillStyle = "rgba(255, 0, 0, " + curPoint + ")";
						ctx.fillRect(posx-2, poxy-2, 4, 4);
					}
					//if the current point is an array
					if (curPoint instanceof Array) {
						//tick all the objects in array
						for (j=0; j<curPoint.length; j++) {
							if (curPoint[j] instanceof Point) {
								curPoint[j].tick();
							}
						}
					//else if it is an instancef point...
					} else if (curPoint instanceof Point) {
						//call the tick function
						curPoint.tick();
					}
				}
			}
			//draw all of the score mods
			for (var i=0; i<globalDisplayPoints.length; i++) {
				globalDisplayPoints[i].draw();
			}
			//draw the score
			$("#Score").html(score['globalScore']);
			$("#pageTitle").html(score['globalScore'] + " - Shape Clicker");
		}
//_______________________________________________________________________________________________________________________
		//function to calculate the score per second
		function calcSPS(addTo) {
			//increase the SPS total
			score['sps'] += addTo;
			//update the score
			$("#ScorePerSecond").html(score['sps']);
		}
//_______________________________________________________________________________________________________________________
		function calcActualFPS() {
			var aveFPS = 0;
			for (var i=0; i<FPSArray.length; i++) {
				aveFPS += FPSArray[i];
			}
			actualFPS = Math.round(aveFPS / FPSArray.length);
			$("#RealFPS").html(actualFPS);
			if (FPS - actualFPS < 6) {
				$("#LagStatus").css('color', '#008000');
				$("#LagStatus").html("Very Good");
			} else if (5 < FPS - actualFPS && FPS - actualFPS <= 11) {
				$("#LagStatus").css('color', '#00ff00');
				$("#LagStatus").html("Good");
			} else if (10 < FPS - actualFPS && FPS - actualFPS < 16) {
				$("#LagStatus").css('color', '#E6FE01');
				$("#LagStatus").html("Normal");
			} else if (15 < FPS - actualFPS && FPS - actualFPS < 25) {
				$("#LagStatus").css('color', '#ffA50');
				$("#LagStatus").html("Bad");
			} else {
				$("#LagStatus").css('color', '#ff0000');
				$("#LagStatus").html("Very Bad");
			}
		}
//_______________________________________________________________________________________________________________________
		//will be run FPS times per second.  Uses requestAnimationFrame to use GPU instead of CPU.
		//variables to help track FPS
		var lastLoop = new Date;
		var thisFPS = 0;
		var actualFPS = 0;
		var FPSArray = [];
		for (var i=0; i<20; i++) {
			FPSArray.push(0);
		}
		var FPSArrayPos = 0;
		var curTick = 0;
		//load a previously saved game
		//saveGame();
		loadGame();
		//main game loop
		tick();
		function tick() {
			setTimeout(function() {
				window.requestAnimationFrame(tick);
				//draw everything
				draw();
				//calculate ACTUAL frames per second
				var thisLoop = new Date;
				thisFPS = Math.round(1000 / (thisLoop - lastLoop));
				FPSArray[FPSArrayPos] = thisFPS;
				lastLoop = thisLoop;
				FPSArrayPos++;
				if (FPSArrayPos == FPSArray.length) {
					FPSArrayPos = 0;
				}
				curTick++;
				if (curTick % Math.round(1000/FPS) - 10 == 0) {
					calcActualFPS();
				}
				if (curTick % Math.round(10000/FPS) == 0) {
					saveGame();
				}
			}, Math.round(1000/FPS));
		}
	</script>
</body>