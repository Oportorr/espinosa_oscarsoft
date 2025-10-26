<?php 
// *************************************************************************
// *                                                                       *
// * CARGO v10.0 -  logistics Worldwide Software                           *
// * Copyright (c) CNSWARE INC. All Rights Reserved                        *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: INFO@CNSWARE.COM                                               *
// * Website: http://www.cnsware.com                                       *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// *                                                                       *
// *                                                                       *
// *                                                                       *
// *************************************************************************
 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once('database.php');
require_once('library.php');
isUser();
?>
<!DOCTYPE html>
<html>
 
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- Page Description and Author -->
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App title -->
        <title>WELCOME TO CARGO V10.1</title>

        <!--Morris Chart CSS -->
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">

        <!-- Switchery css -->
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <!-- App CSS -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
		

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- Modernizr js -->
        <script src="assets/js/modernizr.min.js"></script>
		<script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-79190402-1', 'auto');
          ga('send', 'pageview');

        </script>

    </head>


    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="admin.php" class="logo">
                            <span><img src="image_logo.php?id=1"></span>
                        </a>
                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav pull-right">

                            <li class="nav-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>


                            <li class="nav-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/users/power1.png" alt="user" class="img-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="text-overflow"><small>Welcome ! <?php echo $_SESSION['user_type']; ?></small> </h5> 
                                    </div>
									<?php
										if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
									?>
                                    <!-- item-->
                                    <a href="preferences.php" class="dropdown-item notify-item">
                                        <i class="zmdi zmdi-settings"></i> <span>Settings</span>
                                    </a>
									<?php } ?>
									<?php
										if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Employee') {
									?>
                                    <!-- item-->
                                    <a href="preferences_user.php" class="dropdown-item notify-item">
                                        <i class="zmdi zmdi-settings"></i> <span>Settings</span>
                                    </a>
									<?php } ?>
                                    <!-- item-->
                                    <a href="process.php?action=logOut" class="dropdown-item notify-item">
                                        <i class="zmdi zmdi-power"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>

                    </div> <!-- end menu-extras -->
                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->


            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <li>
                                <a href="admin.php"><i class="zmdi zmdi-view-dashboard"></i> <span> Dashboard </span> </a>
                            </li>
							<?php
								if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
							?>
							<li class="has-submenu">
                                <a href="#"><i class="fa fa-users"></i> <span> MANAGEMENT OF ACCOUNTS </span> </a>
                                <ul class="submenu">
									<li><a href="add-new-users-admin.php"><i class="fa fa-users"></i>&nbsp;&nbsp;Account administrator</a></li>
									<li><a href="add-new-users.php"><i class="fa fa-users"></i>&nbsp;&nbsp;Account Employee</a></li>
									<li><a href="customer.php"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;Account Customers</a></li>
                                </ul>
                            </li>
							<li class="has-submenu">
                                <a href="#"><i class="fa fa-gear (alias)"></i> <span> SETTINGS </span> </a>
                                <ul class="submenu">
		                            <li><a href="service_mode.php"><i class="fa fa-gift"></i>&nbsp;&nbsp;Type of Shipments</a></li>
									<li><a href="type-of-shipments.php"><i class="fa fa-truck"></i>&nbsp;&nbsp;Product Types</a></li>
									<li><a href="add-office.php"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;Location</a></li>
                                    <li><a href="container.php"><i class="fa fa-truck"></i>&nbsp;&nbsp;Container</a></li>
                                    <li><a href="zone.php"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;Zone</a></li>
                                </ul>
                            </li>
								<?php } ?>	
							<li class="has-submenu">
                                <a href="add-courier.php"><i class="fa fa-cubes"></i> <span> ADD SHIPPING </span> </a>
                            </li>
								<?php				
									isUser();
									if($_SESSION['user_type']=='client'){ header('Location: customer'); }
									$result0 = mysql_query("SELECT * FROM online_booking WHERE  status='Pending'");
										$nobookings = dbNumRows($result0); 
								?>
						<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Employee') { ?>
                            <li class="has-submenu">
                                <a href="customer.php"><i class="fa fa-users"></i> <span>ADD CUSTOMER</span> </a>
                            </li>
                        <?php } ?>    
							<li class="has-submenu">
                                <a href="online-bookings.php"><i class="fa fa-envelope">&nbsp;&nbsp;<font color="#FF0000"><strong><?php echo $nobookings; ?></strong></font></i> <span> ONLINE BOOKINGS </span> </a>
								<ul class="submenu">										
		                            <li><a href="transfer-bank.php"><i class="fa fa-money"></i>&nbsp;&nbsp;List of payments, bank transfer</a></li>									
                                </ul>
                            </li>
							<li class="has-submenu">
                                <a href="transfer-form.php"><i class="fa fa-exchange" aria-hidden="true"></i> <span>TRANSFER </span> </a>
                            </li>
							<li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-collection-text"></i> <span> REPORTS </span> </a>
                                <ul class="submenu">
									<li><a href="shipping-list.php"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;List of Shipments</a></li>
		                            <li><a href="delivered-list.php"><i class="fa fa-truck"></i>&nbsp;&nbsp;List of delivered Shipments</a></li>
									<li><a href="delivered-list-online.php"><i class="fa fa-truck"></i>&nbsp;&nbsp;List of delivered Shipments Online</a></li>
									<li><a href="list-of-shipping-paid.php"><i class="fa fa-money"></i>&nbsp;&nbsp;List of Shipping Paid</a></li>
									<li><a href="list-of-shipping-topaid.php"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;List of Shipping ToPay</a></li>
									<li><a href="list-of-shipping-cash-on-delivery.php"><i class="fa fa-usd"></i>&nbsp;&nbsp;List of Shipping Cash on Delivery</a></li>
									<li><a href="employee_payment_report.php"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Employee Payment Report</a></li>
									<li><a href="container_report.php"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Container Report</a></li>
                                    <li><a href="container_invoice.php"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Container Invoice</a></li>
								    <li class="active"><a href="container_details_list_report.php"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Container details Listing</a></li>
								    <li class="active"><a href="container_details_sender_list.php"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Container Sender</a></li>

                                </ul>
                            </li>
							<?php
								if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
							?>
							<li class="has-submenu">
                                <a> <span> | </span> </a>
                            </li>							
							<li class="has-submenu">
                                <a href="preferences.php"><i class="fa fa-briefcase"></i> <span> COMPANY </span> </a>
                            </li>
								<?php } ?>
                        </ul>
                        <!-- End navigation menu  -->
                    </div>
                </div>
            </div>
        </header>
        <!-- End Navigation Bar-->   