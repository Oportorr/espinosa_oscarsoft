<html>
<head>
  <meta charset="utf-8" />
  <title>Track My Parcel  | CARGO v10.1</title>
        <meta name="description" content="CARGO V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--html5 ie include-->
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
    
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />   
    <link rel="canonical" href="tracking.php" />
    
    <!-- style -->
    <link href="deprixa_components/content/cssefe4.css" rel="stylesheet"/>
    <link href="deprixa_components/styles/track-order.css" rel="stylesheet" />	
	<script src="deprixa_components/hub/scripts/bootstrap.min.js"></script>
	<script src="deprixa_components/hub/scripts/jquery-validate.min.js"></script>
	<script src="deprixa_components/hub/scripts/jquery-validate-unobtrusive.min.js"></script>
	<script type="text/javascript" src="process/countries.js"></script> 		
	<link rel="stylesheet" href="deprixa_components/hub/css/global.css" />
	<link rel="stylesheet" href="deprixa_components/hub/css/services.css" />
	<link rel="stylesheet" href="deprixa_components/hub/css/dSwiper.css" />
	<link rel="stylesheet" href="deprixa_components/hub/css/bootstrap-mpd.css" />				
    
   <!-- style -->  
    <link href="deprixa_components/styles/home1d2d.css" rel="stylesheet"/>
	<link href="deprixa_components/styles/nivo-slider.css" rel="stylesheet"/>
	<link rel="stylesheet" href="deprixa_components/styles/default.css" /> 
</head>

   <!-- Menu -->
<?php include_once "menu.php"; ?>
    <!-- /Menu -->
		
<!--SLIDER -->	
<div class="slider-wrapper theme-default">
      <div id="slider" class="nivoSlider">
		<img src="deprixa_components/images/slider/1.png" data-thumb="deprixa_components/images/demo/news/1.jpg" alt="" title="#caption1" />
		<a href="#"><img src="deprixa_components/images/slider/2.png" data-thumb="deprixa_components/images/demo/news/2.jpg" alt="" title="#caption2"  /></a>
</div>
		
</div>
<main class="slide">
   
<div class="fw grey-bg">
    <section class="history">
        <div id="TrackingEventsContainer">

        </div>
    </section> 

        <section class="trackorder-boxes">
            <div class="col-sm-6">
                <div class="pod">
                    <div class="media-body">
                        <span class="track-icon-close40 mpdLightBlue"></span>
                        <h3>FREE SHIPPING</h3>
                        <p><img src="deprixa_components/images/freeshipping.png" alt="DPD" /></p>
						<br><br>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="pod">
                    <div class="media-body">
                        <span class="track-icon-back3 mpdRed"></span>
                        <h3>HOW IT WORKS</h3>
                        <p><img src="deprixa_components/images/dropshipping.png" alt="DPD" /></p>
						<br><br>
                        <a href="contact-us.php" class="btn btn-primary">Contact us</a>
                    </div>
                </div>
            </div>
        </section>
    
</div>

<section class="mpd-couriers">
    <header>
        <h2>Compare Our Couriers</h2>
    </header>
    <ul class="col-sm-12">

        <li class="mpd-dpd"><img src="deprixa_components/images/global/courier-logos/dpd-logo.png" alt="DPD" /></li>
        <li class="mpd-hermes"><img src="deprixa_components/images/global/courier-logos/hermes-logo.png" alt="Hermes" /></li>
        <li class="mpd-parcel-force"><img src="deprixa_components/images/global/courier-logos/parcelforce-logo.png" alt="Parcel Force" /></li>
        <li class="mpd-mpd"><img src="deprixa_components/images/global/courier-logos/mpd-logo.png" alt="MPD" /></li>
        <li class="mpd-collect-plus"><img src="deprixa_components/images/global/courier-logos/collectplus-logo.png" alt="Collect+" /></li>
        <li class="mpd-dx"><img src="deprixa_components/images/global/courier-logos/dx-logo.png" alt="DX" /></li>
        <li class="mpd-ups"><img src="deprixa_components/images/global/courier-logos/ups-logo.png" alt="UPS" /></li>
        <li class="mpd-ajg"><img src="deprixa_components/images/global/courier-logos/ajg-logo.png" alt="AJG" /></li>

    </ul>
</section>
</main>

<?php include_once "footer.php"; ?>

</div>

    <script src="deprixa_components/bundles/jquery"></script>
    <script src="deprixa_components/bundles/bootstrap"></script>
    <script src="deprixa_components/bundles/modernizr"></script>
    <script src="deprixa_components/scripts/CookieManager.js"></script>
    <script src="deprixa_components/scripts/MPD/Common/ga-events.js"></script>    
    <script src="deprixa_components/bundles/jqueryval"></script>
    <script src="deprixa_components/scripts/tracking.js"></script>
    <script src="deprixa_components/scripts/placeholder-shim.js"></script>
    <script src="deprixa_components/scripts/trimFields.js"></script>
	<script src="deprixa_components/scripts/trimFields.js"></script>
	<script type="text/javascript" src="deprixa_components/scripts/jquery.nivo.slider.pack.js"></script>
	<script type="text/javascript" src="deprixa_components/hub/script/jquery.nivo.slider.pack.js"></script>	
	<script>
	/*jshint jquery:true */
	jQuery.noConflict();

	jQuery(window).load(function() {
		"use strict";
		jQuery('#slider').nivoSlider({ controlNav: false});	
	});
	jQuery(document).ready(function() {
		"use strict";
		jQuery('input.datepicker').Zebra_DatePicker();
		// Carousel
		jQuery("#carousel-type1").carouFredSel({
			responsive: true,
			width: '100%',
			auto: false,
			circular : false,
			infinite : false, 
				items: {visible: {min: 1,max: 4},
			},
			scroll: {
				items: 1,
				pauseOnHover: true
			},
			prev: {
				button: "#prev2",
				key: "left"
			},
			next: {
				button: "#next2",
				key: "right"
			},
			swipe: true
		});		
		jQuery(".work_slide ul").carouFredSel({
			circular: false,
			infinite: true,
			auto: false,
			scroll:{items:1},
			items: {visible: {min: 3,max: 3}},
			prev: {	button: "#slide_prev", key: "left"},
			next: { button: "#slide_next",key: "right"}
		});
		jQuery("#testimonial_slide").carouFredSel({
			circular: false,
			infinite: true,
			auto: false,
			scroll:{items:1},
			prev: {	button: "#slide_prev1", key: "left"},
			next: { button: "#slide_next1",key: "right"}
		});				
	});  		
	</script>

</body>
</html>
