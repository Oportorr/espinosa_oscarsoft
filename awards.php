<!DOCTYPE html>

<html>


<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <title>Comparison | CARGO v10.1 </title>
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link rel="stylesheet" href="deprixa_components/css/bootstrap-mpd.css" />
	<link rel="stylesheet" href="deprixa_components/css/global.css" />
	<link rel="stylesheet" href="deprixa_components/css/awards.css" />
	<script src="deprixa_components/js/jquery.min.js"></script>
	<script src="deprixa_components/scripts/bootstrap.min.js"></script>
	<script src="deprixa_components/scripts/jquery-validate.min.js"></script>
	<script src="deprixa_components/scripts/jquery-validate-unobtrusive.min.js"></script>
	<script src="deprixa_components/scripts/modernizr-2.6.2.js"></script>
	<script src="deprixa_components/scripts/html5shiv.js"></script>  
    <link href="deprixa_components/content/csse1bf.css" rel="stylesheet"/>
	
	<link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />	

</head>
   <!-- Menu -->
<?php include_once "menu.php"; ?>
    <!-- /Menu -->

<main class="slide">

<div class="fw grey-bg">
<section class="awards"><header>
<h1>Awards</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
</header>
<div class="container js-masonry">
<div class="item"><img alt="Innovation, Excellence in Services 2016" src="deprixa_components/images/award1.jpg" />
<h2>Innovation &amp; Excellence 2016</h2>
<p>WSed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
</div>
<div class="item"><img alt="BUSINESS OF THE YEAR AWARD 2016" src="deprixa_components/images/award2.jpg" />
<h2>BUSINESS OF THE YEAR AWARD 2016</h2>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
</div>
<div class="item"><img alt="Entrepreneur Award 2016" src="deprixa_components/images/award3.jpg" />
<h2>Entrepreneur Award 2016</h2>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
</div>
</div>
</section>
</div>

</main>

    <!-- Footer -->
<?php include_once "footer.php"; ?>
    <!-- /Footer -->
	</div>

	<script src="deprixa_components/scripts/Awards/imagesLoaded.js"></script>
    <script src="deprixa_components/scripts/Awards/pkgd.min.js"></script>	
	<script>
	// options
	$(document).ready(function(){
		var $container = $('.container');
			$container.imagesLoaded( function(){
			  $container.masonry({
				gutter: 25,
				itemSelector : '.item'
			});
		});
	});
</script>

</body>

</html>
