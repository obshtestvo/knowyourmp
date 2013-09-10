<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Опознай депутата</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />

	<!-- project styles -->
	<link rel="stylesheet" href="/css/main.css" />
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

</head>

<body>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Навигация</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Опознай депутата</a>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<?php
				$this->widget('zii.widgets.CMenu', array(
					'htmlOptions' => array('class' => 'nav navbar-nav'),
					'items'=>array(
							array('label'=>'Начало', 'url'=>array('/game/index')),
							array('label'=>'Играта', 'url'=>array('/game/play')),
							array('label'=>'Класиране', 'url'=>array('/game/hall')),
						),
					));
				?>
			</div>
		</div>
	</nav>

	<div class="container">
		<?php echo $content; ?>
	</div>
<script>
/mobile/i.test(navigator.userAgent) && !window.location.hash && setTimeout(function () {
  window.scrollTo(0, 1);
}, 200);
</script>
</body>
</html>