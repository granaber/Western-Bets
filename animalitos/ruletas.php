<html lang="en">
<head>
  <meta charset="utf-8">
  <title>effect demo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <style>
  .col-one { width: 30%; float: left; position: relative; top: 350px; }
  .col-one { margin-right: 3%; }

  </style>
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

<p>Click anywhere to apply the effect.</p>

<div class="col-one col">
          <img src="imag/3.png" alt="" />
</div>

<script>
speedOne = 1000

speedOne = Math.floor(Math.random()*1000) + 500;
function ifReadyThenReset() {

	columnReadyCounter++;

	if (columnReadyCounter == 3) {
		$(".col").not(".current .col").css("top", 350);
		columnReadyCounter = 0;
	}

};
$(".col").css("top", 0);
$colOne = $(".col-one");

$colOne.click( function (){
  this.animate({
    "top": -$colOne.height()
  }, speedOne);

})


$(".col-one").animate({
  				"top": 0
  			}, speedOne, function() {
  				ifReadyThenReset();
  			});


</script>

</body>
</html>
