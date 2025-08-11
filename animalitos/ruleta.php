<?
(function($) {
				$.fn.fortune = function(options) {

				var fortune = this;
				var prices = options.prices?options.prices:options;
				var duration = options.duration || 1000;
				var separation = options.separation || 2;
				var prices_amount = Array.isArray(prices) ? prices.length : prices;
				var prices_delta = 360 / prices_amount;
				var is_spinning = false;
				var min_random_spins = options.min_spins || 10;
				var max_random_spins = options.max_spins || 15;
				var default_needle_angle = options.needle_angle || 275;
				var onSpinBounce = options.onSpinBounce || function() {};

				var clockWise = true;
				if (undefined !== options.clockWise) {
				clockWise = options.clockWise;
			}

			fortune.spin = function() {
			var directionModifier = 1;
			if (!clockWise) {
			directionModifier = -1;
		}

		price = Math.floor( Math.random() * prices_amount );
		sub_price = -1;
		var deferred = $.Deferred();
		var randBet = randomBetween(separation, prices_delta - separation);
		var position = Math.floor(
		prices_delta * (price - 1/2) + randBet
		);
		var offsetPos = 185 - position;

		if ( price < prices.length && undefined !== prices[price].length ) {
		sub_amount = prices[price].length;
		sub_price = Math.floor(Math.random() * sub_amount);
		position = Math.floor(
		prices_delta * (price - 1/2) + (prices_delta/sub_amount) * sub_price +
		randomBetween(separation, prices_delta/sub_amount - separation)
		);
	}
	var spins = randomBetween(min_random_spins, max_random_spins);
	var final_position = directionModifier * (360 * spins + directionModifier * offsetPos);
	var prev_position = 0;
	var is_bouncing = false;

	is_spinning = true;

	fortune
	.css({
	"transform": "rotate(" + final_position + "deg)",
	"-webkit-transform": "rotate(" + final_position + "deg)",
	"transition": "transform " + duration + "ms cubic-bezier(.13,.96,.48,1)",
	"-webkit-transition": "-webkit-transform " + duration + "ms cubic-bezier(.13,.96,.48,1)"
}).siblings('.spin').removeClass('bounce');

var bounceSpin = function() {
var curPosition = Math.floor(getRotationDegrees(fortune)),
mod = Math.floor((curPosition + prices_delta*0.5) % prices_delta),
diff_position,
position_threshold = prices_delta/5,
distance_threshold = prices_delta/10;

prev_position = Math.floor(
curPosition < prev_position ?
prev_position - 360 * directionModifier :
prev_position);
diff_position = curPosition - prev_position;

if ((mod < position_threshold && diff_position < distance_threshold) ||
(mod < position_threshold*3 && diff_position >= distance_threshold)) {
if (!is_bouncing) {
fortune.siblings('.spin').addClass('bounce');
onSpinBounce(fortune.siblings('.spin'));
is_bouncing = true;
}
} else {
fortune.siblings('.spin').removeClass('bounce');
is_bouncing = false;
}

if (is_spinning) {
prev_position = curPosition;
requestAnimationFrame(bounceSpin);
}
};

var animSpin = requestAnimationFrame(bounceSpin);

setTimeout(function() {
fortune
.css({
"transform": "rotate(" + offsetPos + "deg)",
"-webkit-transform": "rotate(" + offsetPos + "deg)",
"transition": "",
"-webkit-transition": ""
}).siblings('.spin').removeClass('bounce');

cancelAnimationFrame(animSpin);
result = prices[price] || price;
if (sub_price != -1) {
result = prices[price][sub_price];
}
deferred.resolve(result);
is_spinning = false;
}, duration);

return deferred.promise();
};

var getRotationDegrees = function(obj) {
var angle = 0,
matrix = obj.css("-webkit-transform") ||
obj.css("-moz-transform")    ||
obj.css("-ms-transform")     ||
obj.css("-o-transform")      ||
obj.css("transform");
if (matrix !== 'none') {
var angle,
values = matrix.split('(')[1].split(')')[0].split(','),
a = values[0],
b = values[1],
radians = Math.atan2(b, a);

if ( radians < 0 ) {
radians += (2 * Math.PI);
}

angle = Math.round( radians * (180/Math.PI));
}

return angle;
};

var randomBetween = function(min, max) {
return Math.floor(Math.random() * (max - min + 1)) + min;
};

fortune.getCurrentPosition = function() {
return getRotationDegrees( fortune );
};

return fortune;
};
}) (jQuery);

var apiUrl = 'http://lotoanimalito.com/data/animals/stats/';

var animals = [{
animal: "Hormiga",
number: 36
}, {
animal: "Gato",
number: 11
}, {
animal: "Caiman",
number: 30
}, {
animal: "Raton",
number: 8
}, {
animal: "Cebra",
number: 23
}, {
animal: "Tigre",
number: 10
}, {
animal: "Leon",
number: 5
}, {
animal: "Iguana",
number: 24
}, {
animal: "Oso",
number: 16
}, {
animal: "Panda",
number: 33
}, {
animal: "Carnero",
number: 1
}, {
animal: "Puerco",
number: 20
}, {
animal: "Paloma",
number: 14
}, {
animal: "Lapa",
number: 31
}, {
animal: "Aguila",
number: 9
}, {
animal: "Camello",
number: 22
}, {
animal: "Burro",
number: 18
}, {
animal: "Elefante",
number: 29
}, {
animal: "Loro",
number: 7
}, {
animal: "Zamuro",
number: 28
}, {
animal: "Caballo",
number: 12
}, {
animal: "Tiburon",
number: 35
}, {
animal: "Cienpies",
number: 3
}, {
animal: "Vaca",
number: 26
}, {
animal: "Murcielago",
number: 32
}, {
animal: "Zorro",
number: 15
}, {
animal: "Cabra",
number: 19
}, {
animal: "Alacran",
number: 4
}, {
animal: "Gallo",
number: 21
}, {
animal: "Toro",
number: 2
}, {
animal: "Gallina",
number: 25
}, {
animal: "Pavo",
number: 17
}, {
animal: "Pulpo",
number: 34
}, {
animal: "Sapo",
number: 6
},
{
	animal: "Perro",
	number: 27
}, {
animal: "Mono",
number: 13
}
];

var options        = {};
options.prices     = animals;
options.clockWise  = false;
options.duration   = 20000;
options.separation = 0;
options.clockWise  = true;

$(function() {
var $r = $('.roulette')
.fortune(options);
var clickHandler = function() {
$('.spinner').off('click');
$('.spinner span').hide();

$r.spin().done(function(win) {
$.getJSON(apiUrl + win.number , function(data) {
$('#animal').text(win.animal);
$('#number').text(win.number);
$('div.second').css('background-image', 'url(' + data.imagePath + ')');
$('.img-animal').show();
$('#winner-amount').text(data.winnersCount);
$('#percent').text(data.percentWinners);
});
$('.spinner').on('click', clickHandler);
$('.spinner span').show();
});
};

$('.spinner').on('click', clickHandler);
});
?>
