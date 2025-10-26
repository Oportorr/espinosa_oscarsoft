<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	 <title>Track My Parcel  | CARGO v10.1</title>
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--html5 ie include-->
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
    
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="/Styles/ie-fixes.css" />
    <![endif]-->    
    <link rel="canonical" href="tracking.php" />  
    <!-- style -->
    <link href="deprixa_components/content/cssefe4.css" rel="stylesheet"/>  
    <link href="deprixa_components/styles/track-order.css" rel="stylesheet" />

</head>

   <!-- Menu -->
<?php include_once "menu.php"; ?>
    <!-- /Menu -->

<div class="slide">   
    </div>
       <main class="slide">
        <div class="fw">
            <section class="title">
                <header>
                    <h1><img src="deprixa_components/images/global/tracking-search.png" />Is it nearly there yet?</h1>
					
                    <p class="mobHide">
                        The pick-up and delivery is easy with us, and doing so Could not be simpler.  Once your delivery You have booked through us, a tracking number is assigned example something like <strong>AWB-472304198</strong> Just input This unique number into the box below and, ta-dah, you can find out exactly Where it is!
                    </p>
                </header>
				<div class="media-left">
                    
                </div>
            </section>
        </div>
        <div class="fw green-bg">
            <section class="track-num">
                <h3>Enter your Booking Reference</h3>
                <div class="search-bar">
				<form action="tracking-result.php" method="post" name="form" id="form" >
                    <div class="form-group mob-track">
                        <div class="input-group">
                            <!--<div class="input-group-addon">MPD</div>-->
                            <input type="text" class="form-control" name="Consignment" id="Consignment" placeholder="Example AWB-472304198">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="Submit" onClick="MM_validateForm('Consignment','','R');return document.MM_returnValue"><img src="deprixa/images/Tracking.png" alt="x" />Track my parcel</button>
                    <div class="wait-message" style="text-align:center; display:none;">
                        <img src="deprixa_components/images/global/loading-green.gif" />
                        Searching... Please wait.
                    </div>
                </div>
				</form>
            </section>
        </div>   

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
                        <h3>Parcel not yet collected?</h3>
                        <p>Sorry, this doesn’t happen often, we’re sure there’s a good reason. If it’s after 6pm on the booked collection day, then reschedule a collection here.</p>
                        <a href="login.php" class="btn btn-primary">Reschedule collection</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="pod">
                    <div class="media-body">
                        <span class="track-icon-back3 mpdRed"></span>
                        <h3>Need a fast answer?</h3>
                        <p>If you’ve any questions at all about your delivery, then don’t hesitate to get in touch with our UK based customer service team. But first check out our FAQ's page</a> as the answer you’re looking for will probably be there.</p>
                        <a href="contact-us.php" class="btn btn-primary">Contact us</a>
                    </div>
                </div>
            </div>
        </section>
    
</div>
        </main>

    <!-- Footer -->
 <?php include_once "footer.php"; ?>
    <!-- /Footer -->
    </div>

    <script src="deprixa_components/bundles/jquery"></script>
   <script src="deprixa_components/bundles/bootstrap"></script>
    <script src="deprixa_components/bundles/modernizr"></script>
    <script src="deprixa_components/scripts/CookieManager.js"></script>
    <script src="deprixa_components/Scripts/MPD/Common/ga-events.js"></script>   
    <script src="deprixa_components/bundles/jqueryval"></script>
    <script src="deprixa_components/scripts/tracking.js"></script>
    <script src="deprixa_components/scripts/placeholder-shim.js"></script>
    <script src="deprixa_components/scripts/trimFields.js"></script>

</body>
</html>
