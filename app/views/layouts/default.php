<!DOCTYPE html>
<html>
	<head>
		<title>Meridian</title>
		<?php //echo HTML::css_inc(baseurl().'css/meridian.css'); ?>
		<?php //echo HTML::js_inc('http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js'); ?>
	</head>
	<body>
		<div id="wrapper">
			<header>
				<h1>Meridian</h1>
			</header>
			<section id="page">
<?php echo $output; ?>
			</section>
			<div class="clearfix"></div>
		</div>
		<footer>
			Copyright &copy; <?php echo date("Y")?>
		</footer>
	</body>
</html>