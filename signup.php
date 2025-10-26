<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
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
    
    <!-- style -->
    <link href="deprixa_components/content/cssefe4.css" rel="stylesheet"/>
	<script type="text/javascript" src="panel/js/jquery.min.js"></script>
	<script type="text/javascript" src="process/countries.js"></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="custom.css">
    <link type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet" />
    
    <link href="deprixa_components/styles/address-details.css" rel="stylesheet" />
    <link href="deprixa_components/styles/signup.css" rel="stylesheet" />

</head>

   <!-- Menu -->
<?php include_once "menu.php"; ?>
    <!-- /Menu -->
	
<div class="slide">
    
</div>
<main class="slide">
<section class="signup">
    <h2>Sign up</h2>
    <div class="well">
<form action="process/registration.php" method="post">
            <div class="col-md-4 form-col details">
                <div class="form-horizontal">
                    
<div id="personal-details" class="form-horizontal">
    <h4>Personal Details </h4>
    <div class="form-group">
        <label class="control-label col-md-4" for="PersonalDetails_Title">Title</label>
        <div class="col-md-8">
            <select class="form-control" id="PersonalDetails_Title" name="estado"><option value="1">Mr</option>
			<option value="1">Ms</option>
			<option value="1">Mrs</option>
			<option value="1">Other</option>
			</select>
            <span class="field-validation-valid text-danger" data-valmsg-for="PersonalDetails.Title" data-valmsg-replace="true"></span>
        </div>
    </div>

    <div class="form-group required">
        <label class="control-label col-md-4" for="PersonalDetails_FirstName">First Name</label>
        <div class="col-md-8">
            <input class="form-control text-box single-line" data-val="true" data-val-required="The First Name field is required." name="fname" required  type="text"  placeholder="First Name" />
            <span class="field-validation-valid text-danger" data-valmsg-for="PersonalDetails.FirstName" data-valmsg-replace="true"></span>
        </div>
    </div>

    <div class="form-group required">
        <label class="control-label col-md-4" for="PersonalDetails_Surname">Surname</label>
        <div class="col-md-8">
            <input class="form-control text-box single-line" data-val="true" data-val-required="The Surname field is required." id="PersonalDetails_Surname" name="lname"  type="text" required  placeholder="Last Name"  />
            <span class="field-validation-valid text-danger" data-valmsg-for="PersonalDetails.Surname" data-valmsg-replace="true"></span>
        </div>
    </div>

    <div class="form-group required">
        <label class="control-label col-md-4" for="PersonalDetails_Email">Email</label>
        <div class="col-md-8">
            <input class="form-control text-box single-line" data-val="true" data-val-email="The Email field is not a valid e-mail address." data-val-required="The Email field is required." id="PersonalDetails_Email" name="email" id="email" required  type="email" placeholder="name@domain.com" />
            <span class="field-validation-valid text-danger" data-valmsg-for="PersonalDetails.Email" data-valmsg-replace="true"></span>
        </div>
    </div>

</div>
                </div>
            </div>
            <div class="email-not-in-use">
                <div class="col-md-4 form-col">
                    <div class="form-horizontal">
                        <div id="personal-contact-details" class="form-horizontal simple-address">
    <h4>Contact Details</h4>

    <div class="form-group required">
        <label class="control-label col-md-4" for="PersonalContactDetails_Telephone">Telephone</label>
        <div class="col-md-8">
            <input class="form-control text-box single-line" data-val="true" data-val-regex="Please enter a valid telephone number." data-val-regex-pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" data-val-requiredphone="Please enter a landline or a mobile number." data-val-requiredphone-alt="Mobile" data-val-requiredphone-condition="" id="PersonalContactDetails_Telephone" name="phone"  type="text" placeholder="0-9" />
            <span class="field-validation-valid text-danger" data-valmsg-for="PersonalContactDetails.Telephone" data-valmsg-replace="true"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-4" for="PersonalContactDetails_Mobile">Company Name</label>
        <div class="col-md-8">
            <input class="form-control text-box single-line"  name="company" required  type="text"  placeholder="Name of the business" />
            <span class="field-validation-valid text-danger"></span>
        </div>
    </div>

    

<div class="form-horizontal address-entry-element">

    <div class="address-entry-address-fields ">
        <div class="form-group address-entry-extended-view">
            <label class="control-label col-md-3 col-xs-3" for="PersonalContactDetails_Address_Company">Address</label>
            <div class="col-md-8 col-sm-8">
                <input class="form-control address-entry-company text-box single-line" id="PersonalContactDetails_Address_Company" name="address" required  type="address"  rows="2" placeholder="Address" />
                <span class="field-validation-valid text-danger" data-valmsg-for="PersonalContactDetails.Address.Company" data-valmsg-replace="true"></span>
            </div>
        </div>
        <div class="residentialAddressMessage"></div>
        <div class="form-group required">
            <label class="control-label col-md-3 col-xs-3" for="PersonalContactDetails_Address_FirstLine">Country</label>
            <div class="col-md-8 col-sm-8">
                <span id="inter_origin" style="display: block;"> 
				<select onchange="print_state('state', this.selectedIndex);" id="country" required  name ="country" class="fa-glass booking_form_dropdown form-control"/></select> </span> 											
				<script language="javascript">print_country("country");</script>	
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-xs-3" for="PersonalContactDetails_Address_SecondLine">State</label>
            <div class="col-md-8 col-sm-8">
                <select  name ="state" required  id ="state" class="fa-glass booking_form_dropdown form-control"><option value="">Select state</option></select>    
				<span class="field-validation-valid text-danger" ></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-xs-3" for="PersonalContactDetails_Address_ThirdLine">Zipcode</label>
            <div class="col-md-8 col-sm-8">
                <input class="form-control address-entry-line3 text-box single-line" id="PersonalContactDetails_Address_ThirdLine" name="zipcode"  placeholder="0-9"/>
                <span class="field-validation-valid text-danger" data-valmsg-for="PersonalContactDetails.Address.ThirdLine" data-valmsg-replace="true"></span>
            </div>
        </div>	
    </div>
</div>
</div>
      </div>
            </div>
                <div class="col-md-4 form-col">
                    <div class="form-horizontal">
                            
							<div id="personall-account-details" class="form-horizontal">
								<h4>Account Details</h4>

								
								<input id="PersonalAccountDetails_Currency" name="PersonalAccountDetails.Currency" type="hidden" value="GBP" />

								<div class="form-group required">
									<label class="control-label col-md-5" for="PersonalAccountDetails_Password">Password</label>
									<div class="col-md-7">
										<input class="form-control text-box single-line password" data-val="true" data-val-regex="Password must be at least 6 characters (letters, numbers and basic punctuation)." data-val-regex-pattern="^[\u00c0-\u01ffa-zA-Z0-9&#39;-@%\+\\/!#\$\^\?:,\(\)\{\}\[\]~_]{6,30}$" data-val-required="The Password field is required." id="PersonalAccountDetails_Password" name="password" type="password" placeholder="Password" />
										<span class="field-validation-valid text-danger" data-valmsg-for="PersonalAccountDetails.Password" data-valmsg-replace="true"></span>
									</div>
								</div>

								<div class="form-group required">
									<label class="control-label col-md-5" for="PersonalAccountDetails_ConfirmPassword">Confirm Password</label>
									<div class="col-md-7">
										<input class="form-control text-box single-line password" data-val="true" data-val-equalto="The passwords do not match" data-val-equalto-other="*.Password" data-val-required="The Confirm Password field is required." id="PersonalAccountDetails_ConfirmPassword" name="password" type="password" placeholder="Confirm Password" />
										<span class="field-validation-valid text-danger" data-valmsg-for="PersonalAccountDetails.ConfirmPassword" data-valmsg-replace="true"></span>
									</div>
								</div>

								<div class="form-group">
								   
									<div class="col-md-12 terms-check">
										<p>By continuing your are accepting our <a href="terms-and-conditions.php" target="_blank">terms &amp; conditions.</a></p>     
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-12">
										<input type="submit" value="Sign up" class="btn btn-primary pull-right signup-btn" />
									</div>
								</div>

							</div>
                    </div>
                </div>
            </div>
</form>        <div class="clearfix"></div>
    </div>
</section>
</main>
    <!-- Footer -->
 <?php include_once "footer.php"; ?>
    <!-- /Footer -->
    </div>
    <script src="deprixa_components/bundles/jquery"></script>
    <script src="deprixa_components/bundles/bootstrap"></script>
    <script src="deprixa_components/bundles/modernizr"></script>
    <script src="deprixa_components/scripts/CookieManager.js"></script>
    <script src="deprixa_components/scripts/MPD/Common/ga-events.js"></script>
    <script src="deprixa_components/bundles/jqueryval"></script>
    <script src="deprixa_components/scripts/postcode-validation.js"></script>
    <script src="deprixa_components/scripts/required-phone-validation.js"></script>
    <script src="deprixa_components/scripts/address-entry.js"></script>
    <script src="deprixa_components/scripts/signup.js"></script>
    <script src="deprixa_components/scripts/pop-up-window.js"></script>
    <script src="deprixa_components/scripts/placeholder-shim.js"></script>
    <script src="deprixa_components/scripts/trimFields.js"></script>
</body>

</html>
