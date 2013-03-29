<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Subs Reader : <?php echo $title_for_layout; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<?php echo $this->Html->css('bootstrap'); ?>
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
		</style>
		<?php echo $this->Html->css('bootstrap-responsive'); ?>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<?php echo $this->Html->script('html5shiv.js'); ?>
		<![endif]-->

		<script type="application/javascript">
			// Global configuration options
			var baseURL = '<?php echo $this->base; ?>';
		</script>

		<?php
			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>

		<!-- Fav and touch icons 
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="../assets/ico/favicon.png">
		-->
	</head>

	<body>


		<?php echo $this->element('main_menu'); ?>
			
		<div class="container">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>

			<hr>

			<footer>
				<p>&copy; Exwebris <?php echo date('Y'); ?></p>
			</footer>

		</div> <!-- /container -->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->

		<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'); ?>
		<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js'); ?>
		<?php echo $this->Html->script('bootstrap'); ?>
		<?php echo $this->Html->script('global'); ?>

	</body>
</html>

