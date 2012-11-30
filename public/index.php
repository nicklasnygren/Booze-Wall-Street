<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
		<style>
			<?php 
				if ($_GET['readonly'] == 'true') {
					echo ".btns {display: none !important;}";
				}
			?>
		</style>
		<link rel="stylesheet" type="text/css" href="css/standard.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>	
		<script type="text/javascript" src="scripts/wallstreet.core.js"></script>	
		<script type="text/javascript">
			$(document).ready(function () {
				window.crashing = false;
				<?php 
					if ($_GET['readonly'] == 'true') {
						echo "window.nowrite = true;";
					} else {
						echo "window.nowrite = false;";
					}
				?>
				scaleWindow();
				$('style').html($('style').html()+'.top{-webkit-transition: -webkit-transform '+window.flipTime+'ms;}');
				$('.price div').fillDigit(0);
				updateAllPrices();
				if (window.nowrite) {
					var updateTimer = setInterval(function () {
						if (!window.crashing) {
							updateAllPrices();	
													
						}
						//debugMe(window.crashing);
					}, 100); 
				}
				
				$('.haussebtn').click(function (e) {
					var myId = this.id;
					var myNum = parseInt(myId[myId.length-1]);
					
					hausse(myNum);
				});
				
				$('#crash').click(function (e) {
					initiateCrash();
				});
				
				$('#reset').click(function (e) {
					resetPrices();
				});
			});
			
			function scaleWindow () {
				var myHeight = $(window).height();
				var myWidth = $(window).width();
				//debugMe(myHeight);
				if(myWidth < myHeight) {
					$('body').css('zoom', myWidth/($('#wrapper').width()+650));
					return false;
				}
				$('body').css('zoom', myHeight/1200);
				//alert(myHeight);
			}
			
			$(window).resize(function () {
				scaleWindow();
			});
			
			
			function debugMe (debugString) {
				//$('#debug').html($('#debug').html()+'<br />'+debugString);
        console.log(debugString);
			}
		</script>
	</head>
	<body>
		<div class="hidden">
			<img src="gfx/digits/whole/0.png" alt="preload"/>
			<img src="gfx/digits/whole/1.png" alt="preload"/>
			<img src="gfx/digits/whole/2.png" alt="preload"/>
			<img src="gfx/digits/whole/3.png" alt="preload"/>
			<img src="gfx/digits/whole/4.png" alt="preload"/>
			<img src="gfx/digits/whole/5.png" alt="preload"/>
			<img src="gfx/digits/whole/6.png" alt="preload"/>
			<img src="gfx/digits/whole/7.png" alt="preload"/>
			<img src="gfx/digits/whole/8.png" alt="preload"/>
			<img src="gfx/digits/whole/9.png" alt="preload"/>
		</div>
		<div id="wrapper">
		<ul id="btns" class="btns">
			<li><input class="haussebtn" id="hausse-1" type="button" value="BUY!"/></li>
			<li><input class="haussebtn" id="hausse-2" type="button" value="BUY!"/></li>
			<li><input class="haussebtn" id="hausse-3" type="button" value="BUY!"/></li>
			<li><input class="haussebtn" id="hausse-4" type="button" value="BUY!"/></li>
		</ul>
		<ul id="labels">
			<li>Pilsner</li>
			<li>Cider</li>
			<li>Grogg</li>
			<li>Shot</li>
		</ul>
		<div id="pricelist">
			<div class="price" id="price-1">
				<div class=""></div>
				<div class=""></div>
			</div>
			<div class="price" id="price-2">
				<div class=""></div>
				<div class=""></div>
			</div>
			<div class="price" id="price-3">
				<div class=""></div>
				<div class=""></div>
			</div>
			<div class="price" id="price-4">
				<div class=""></div>
				<div class=""></div>
			</div>
		</div>
		<ul id="btns2" class="btns">
			<li></li>
			<li></li>
			<li><input id="crash" type="button" value="CRASH!"/></li>
			<li><input id="reset" type="button" value="RESET!"/></li>
		</ul>
		</div>
		<div id="veil" class=""></div>
		<div id="crashmsg" class="bigmsg">Market<br />crash!!!</div>
		<div id="bailoutmsg" class="bigmsg"></div>
	</body>
</html>
