window.flipTime = 150;
window.inTransition = false;
window.origPrices = [10,15,20,15];
var prices = [10,15,20,15];

Array.prototype.min = function() {
var min = this[0];
var len = this.length;
for (var i = 1; i < len; i++) if (this[i] < min) min = this[i];
return min;
}

//Redraws all the prices on the page
function updateAllPrices() {
	//debugMe(window.prices.join(','));
	if (window.nowrite && data == "2,2,2,2") {
		//alert("hej;")
		initiateCrash();
		return false;
	} else if (window.nowrite && data == window.prices.join(',')) {
		return false;
	}
	//debugMe(newPrices[0]+','+newPrices[1]+','+newPrices[2]+','+newPrices[3]); 
	$('#price-1').updatePrice(window.prices[0]);
	$('#price-2').updatePrice(window.prices[1]);
	$('#price-3').updatePrice(window.prices[2]);
	$('#price-4').updatePrice(window.prices[3]);
}

//"Buys" one of the priced objects, increasing its price, decreasing all othe objects' prices
function hausse (myItem) {
	window.prices[0]-=1; window.prices[1]-=1; window.prices[2]-=1; window.prices[3]-=1;
	window.prices[myItem-1]+=4;
	if (window.prices.min() < 2) {
		initiateCrash();
		return false;
	};
	//debugMe('Clicked hausse #'+myItem);
	if (window.nowrite) { return false; }
	updateAllPrices();
}

function isInTransition () {
	//if ($('.rotated').length) { return true; }
	return false;
}

function initiateCrash () {
	//debugMe('BEGIN MARKET CRASH');
	marketCrash();
	window.crashing = true;
	$('#veil').fadeIn('slow');
	$('#crashmsg').fadeIn('slow');
	setTimeout(function () {
		$('#crashmsg').fadeOut('slow', function () {
			$('.btns').fadeOut('fast');
		});
		$('#price-1').updatePrice(2);
		$('#price-2').updatePrice(2);
		$('#price-3').updatePrice(2);
		$('#price-4').updatePrice(2);
		var secs = 5;
		setTimeout(function () {
			$('#bailoutmsg').html('Bailout in<br />'+secs).fadeIn('slow');
			var bailoutTimer = setInterval(function () {
				secs--;
				$('#bailoutmsg').html('Bailout in<br />'+secs);
				//debugMe(secs);
				if (!secs) {
					$('#bailoutmsg').fadeOut('fast');
					$('#veil').fadeOut('slow', function () {
						$('.btns').fadeIn('slow');
						//debugMe('END MARKET CRASH');
						window.crashing = false;
						resetPrices();
					});
					clearInterval(bailoutTimer);
				};
			}, 1000);
		}, 3000);
	}, 2000);
}

function resetPrices () {
	if (window.nowrite) {
		return false;
	}
	window.prices = window.origPrices;
	//debugMe(window.origPrices);
	updateAllPrices();
}

function marketCrash () {
	if (window.nowrite) {
		window.prices = [2,2,2,2];
		return false;
	}
}

//Get number from digit div
jQuery.fn.getDigit = function () {
	var myString = this.attr('class');
	var myNumber = parseInt(myString[myString.length-1]);
	return myNumber;
}
	
	//Flip digit; iterate +1
jQuery.fn.flip = function () {
	//inTransition = true;
	var obj = this;
	//debugMe(obj.attr('class'));
	var myNum = obj.getDigit();
	digitTop = obj.find($('.top'));
	digitTop.addClass('rotated');
	setTimeout(function () {
		if (myNum == 9) { myNum = -1 }
		obj.fillDigit(myNum+1);
	}, window.flipTime-50);
}

//Redraw and refill digit
jQuery.fn.fillDigit = function (var_num) {
	next_num = parseInt(var_num) + 1;
	if (next_num > 9) { next_num = 0 }
 	this.attr('class', 'digit num'+var_num).html("<div class=\"top\"><div class=\"front\"><span>"+var_num+"</span></div><div class=\"back\"><span>"+next_num+"</span></div></div><div class=\"bottom\"><span>"+var_num+"</span></div><span class=\"lowest\">"+next_num+"</span>");
}

//Iterates a single digit up to newNum
jQuery.fn.flipTo = function (newNum) {
	var obj = this;
	setTimeout(function () {
		
		var myNum = obj.getDigit();
		var diff = newNum-myNum;
		if (diff < 0) {diff = 10+diff}
		if (!diff) { return false; }
		obj.flipTimer(diff);
	}, Math.random()*500);
}

//Iteration helper
jQuery.fn.flipTimer = function (diff) {
	var n = 0;
	var obj = this;
	//debugMe(diff)
	var flipTimer = setInterval(function () {
		n++;
		obj.flip();
		if( n >= diff ){clearInterval(flipTimer)}
	}, window.flipTime+10);
}

//Flips digits to change contents of price dib
jQuery.fn.updatePrice = function (newprice) {
	debugMe(newprice);
	var priceString = ''+newprice;
	
	if (priceString.length == 1) {priceString = 0+priceString}
	//alert(priceString.length);
	var obj = this;
	obj.children('.digit:eq(0)').flipTo(parseInt(priceString[0]));
	obj.children('.digit:eq(1)').flipTo(parseInt(priceString[1]));
}

$(document).ready(function () {
	/*setInterval(function () {
		updateAllPrices();
	}, 2000);*/
});
