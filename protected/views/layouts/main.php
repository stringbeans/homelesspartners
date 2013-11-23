<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
		<link href="/css/flatui/flat-ui.css" rel="stylesheet">

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	</head>

	<body>

		<header>
			HEADER GOES HERE
		</header>

		<?php echo $content; ?>

		<div class="bottom-menu bottom-menu-inverse">
			<div class="container">
				<div class="row">
					<div class="col-md-2 navbar-brand">
						<a href="#fakelink" class="fui-flat"></a>
					</div>

					<div class="col-md-8">
						<ul class="bottom-links">
							<li><a href="#fakelink">About Us</a></li>
							<li><a href="#fakelink">Store</a></li>
							<li class="active"><a href="#fakelink">Jobs</a></li>
							<li><a href="#fakelink">Privacy</a></li>
							<li><a href="#fakelink">Terms</a></li>
							<li><a href="#fakelink">Follow Us</a></li>
							<li><a href="#fakelink">Support</a></li>
							<li><a href="#fakelink">Links</a></li>
						</ul>
					</div>

					<div class="col-md-2">
						<ul class="bottom-icons">
							<li><a href="#fakelink" class="fui-pinterest"></a></li>
							<li><a href="#fakelink" class="fui-facebook"></a></li>
							<li><a href="#fakelink" class="fui-twitter"></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.27/jquery.form-validator.min.js"></script>	

	</body>
</html>