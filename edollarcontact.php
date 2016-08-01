<?php
session_start();

require_once('php/simple-php-captcha/simple-php-captcha.php');
require_once('php/php-mailer/PHPMailerAutoload.php');

// Step 1 - Enter your email address below.
$email = 'you@domain.com';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 0;

if(isset($_POST['emailSent'])) {

	$subject = $_POST['subject'];

	// Step 2 - If you don't want a "captcha" verification, remove that IF.
	if (strtolower($_POST['captcha']) == strtolower($_SESSION['captcha']['code'])) {

		// Step 3 - Configure the fields list that you want to receive on the email.
		$fields = array(
			0 => array(
				'text' => 'Name',
				'val' => $_POST['name']
			),
			1 => array(
				'text' => 'Email address',
				'val' => $_POST['email']
			),
			2 => array(
				'text' => 'Message',
				'val' => $_POST['message']
			),
			3 => array(
				'text' => 'Checkboxes',
				'val' => implode($_POST['checkboxes'], ", ")
			),
			4 => array(
				'text' => 'Radios',
				'val' => $_POST['radios']
			)
		);

		$message = '';

		foreach($fields as $field) {
			$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
		}

		$mail = new PHPMailer(true);

		try {

			$mail->SMTPDebug = $debug;                            // Debug Mode

			// Step 3 (Optional) - If you don't receive the email, try to configure the parameters below:

			//$mail->IsSMTP();                                         // Set mailer to use SMTP
			//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
			//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
			//$mail->Username = 'user@example.com';                    // SMTP username
			//$mail->Password = 'secret';                              // SMTP password
			//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
			//$mail->Port = 587;   								       // TCP port to connect to

			$mail->AddAddress($email);	 						       // Add a recipient

			//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add another recipient
			//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
			//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

			$mail->SetFrom($email, $_POST['name']);
			$mail->AddReplyTo($_POST['email'], $_POST['name']);

			$mail->IsHTML(true);                                  // Set email format to HTML

			$mail->CharSet = 'UTF-8';

			$mail->Subject = $subject;
			$mail->Body    = $message;

			// Step 4 - If you don't want to attach any files, remove that code below
			if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
				$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
			}

			$mail->Send();

			$arrResult = array ('response'=>'success');

		} catch (phpmailerException $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
		} catch (Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
		}

	} else {

		$arrResult = array ('response'=>'captchaError');

	}

}
?>
<!DOCTYPE html><html class="dark">
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>EDollar</title>	

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">
		<link rel="stylesheet" href="css/theme-animate.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body>
		<div class="body">
			<header id="header" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 0, "stickySetTop": "0", "stickyChangeLogo": false}'>
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="index.html">
										<img alt="Porto" width="140" height="27" data-sticky-width="82" data-sticky-height="40" data-sticky-top="33" src="img/edollarlogo.png">
									</a>
								</div>
							</div>
							<div class="header-column">
								<div class="header-row">
									<div class="header-search hidden-xs">
										<form id="searchForm" action="page-search-results.html" method="get">
											<div class="input-group">
												<input type="text" class="form-control" name="q" id="q" placeholder="Search..." required>
												<span class="input-group-btn">
													<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div>
										</form>
									</div>
									<nav class="header-nav-top">
										<ul class="nav nav-pills">
											<li class="hidden-xs">
												<a href="about-us.html"><i class="fa fa-angle-right"></i> About Us</a>
											</li>
											<li class="hidden-xs">
												<a href="contact-us.html"><i class="fa fa-angle-right"></i> Contact Us</a>
											</li>
											<li>
												<span class="ws-nowrap"><i class="fa fa-phone"></i> 03-4144 3505</span>
											</li>
																					<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
											<i class="fa fa-bars"></i>
										</button>
										</ul>
									</nav>
								</div>
								<div class="header-row">
									<div class="header-nav">

										<ul class="header-social-icons social-icons hidden-xs">
											<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
											<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
											<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
										</ul>
										<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
											<nav>
												<ul class="nav nav-pills" id="mainNav">
													<li class="dropdown">
														<a href="index.html">
															Home
														</a>
													</li>
													<li class="dropdown dropdown-mega">
														<a class="dropdown-toggle" href="products.html">
															Products
														</a>
														<ul class="dropdown-menu">
															<li>
																<div class="dropdown-mega-content">
																	<div class="row">
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"><center>MW1321 GAMING MOUSE</center></span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="#"><center><img src="img/black.png"/></center></a></li>
																				<li><a href="#"><center><img src="img/beige.png"/></center></a></li>
																				<li><a href="#"><center><img src="img/yellowred.png"/></center></a></li>
																			</ul>
																		</div>
																		
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"><center>KW1333 KEYBOARD</center></span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="#"><center><img src="img/kblackblue.png" width="200px" height="100px"/></center></a></li>
																				<li><a href="#"><center><img src="img/kcopper.png" width="200px" height="100px"/></center></a></li>
																				<li><a href="#"><center><img src="img/kblackblue.png" width="200px" height="100px"/></center></a></li>
																			</ul>
																		</div>
																		
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"><center>BLADE SOLDIER YD2718</center></span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="#"><center><img src="img/black.png"/></center></a></li>
																				<li><a href="#"><center><img src="img/beige.png"/></center></a></li>
																				<li><a href="#"><center><img src="img/yellowred.png"/></center></a></li>
																			</ul>
																		</div>
																		
																		<div class="col-md-3">
																			<span class="dropdown-mega-sub-title"><center>DESKTOP</center></span>
																			<ul class="dropdown-mega-sub-nav">
																				<li><a href="#"><center><img src="img/black.png"/></center></a></li>
																				<li><a href="#"><center><img src="img/beige.png"/></center></a></li>
																				<li><a href="#"><center><img src="img/yellowred.png"/></center></a></li>
																			</ul>
																		</div>
																	</div>
																</div>
															</li>
														</ul>
													</li>
													<li class="dropdown active">
														<a href="#">
															About Us
														</a>
													</li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div role="main" class="main">

				<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Home</a></li>
									<li class="active">Contact Us</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>About Us</h1>
							</div>
						</div>
					</div>
				</section>



				<div class="container">

					<div class="row">
						<div class="col-md-6">

							<div class="offset-anchor" id="contact-sent"></div>

							<?php
							if (isset($arrResult)) {
								if($arrResult['response'] == 'success') {
								?>
								<div class="alert alert-success" id="contactSuccess">
									<strong>Success!</strong> Your message has been sent to us.
								</div>
								<?php
								} else if($arrResult['response'] == 'error') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> There was an error sending your message.
									<span class="font-size-xs mt-sm display-block" id="mailErrorMessage"><?php echo $arrResult['errorMessage'];?></span>
								</div>
								<?php
								} else if($arrResult['response'] == 'captchaError') {
								?>
								<div class="alert alert-danger" id="contactError">
									<strong>Error!</strong> Verification failed.
								</div>
								<?php
								}
							}
							?>

							<h2 class="mb-sm mt-sm"><strong>Contact</strong> Us</h2>
							<form id="contactFormAdvanced" action="<?php echo basename($_SERVER['PHP_SELF']); ?>#contact-sent" method="POST" enctype="multipart/form-data">
								<input type="hidden" value="true" name="emailSent" id="emailSent">
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<label>Your name *</label>
											<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
										</div>
										<div class="col-md-6">
											<label>Your email address *</label>
											<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Subject</label>
											<select data-msg-required="Please enter the subject." class="form-control" name="subject" id="subject" required>
												<option value="">...</option>
												<option value="Option 1">Option 1</option>
												<option value="Option 2">Option 2</option>
												<option value="Option 3">Option 3</option>
												<option value="Option 4">Option 4</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Checkboxes</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="checkbox-group" data-msg-required="Please select at least one option.">
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox1" value="option1"> 1
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox2" value="option2"> 2
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox3" value="option3"> 3
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox4" value="option4"> 4
														</label>
														<label class="checkbox-inline">
															<input type="checkbox" name="checkboxes[]" id="inlineCheckbox5" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-12">
													<label>Radios</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="radio-group" data-msg-required="Please select one option.">
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio1" value="option1"> 1
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio2" value="option2"> 2
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio3" value="option3"> 3
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio4" value="option4"> 4
														</label>
														<label class="radio-inline">
															<input type="radio" name="radios" id="inlineRadio5" value="option5"> 5
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Attachment</label>
											<input type="file" name="attachment" id="attachment">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Message *</label>
											<textarea maxlength="5000" data-msg-required="Please enter your message." rows="6" class="form-control" name="message" id="message" required></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Human Verification *</label>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-4">
											<div class="captcha form-control">
												<div class="captcha-image">
													<?php
													$_SESSION['captcha'] = simple_php_captcha(array(
														'min_length' => 6,
														'max_length' => 6,
														'min_font_size' => 22,
														'max_font_size' => 22,
														'angle_max' => 3
													));

													$_SESSION['captchaCode'] = $_SESSION['captcha']['code'];

													echo '<img id="captcha-image" src="' . "php/simple-php-captcha/simple-php-captcha.php/" . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
													?>
												</div>
												<div class="captcha-refresh">
													<a href="#" id="refreshCaptcha"><i class="fa fa-refresh"></i></a>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<input type="text" value="" maxlength="6" data-msg-captcha="Wrong verification code." data-msg-required="Please enter the verification code." placeholder="Type the verification code." class="form-control input-lg captcha-input" name="captcha" id="captcha" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input type="submit" id="contactFormSubmit" value="Send Message" class="btn btn-primary btn-lg pull-right" data-loading-text="Loading...">
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6">

							<h4 class="heading-primary mt-lg">About&nbsp;<strong>Us</strong></h4>
							<p class="lead">
								Edollar Sdn Bhd started with production and network services on high speed wireless network card and other electronic 
								products With its experience and good contact in the internet industry, Edollar has diversified into business development 
								of internet cafes both at home and aboard.   
							</p>

							<p>
							We are committed to continue building the brand which already won wide spread praises amongst our peers in the internet industry.
							</p>

							<hr>

							<h4 class="heading-primary">The <strong>Office</strong></h4>
							<ul class="list list-icons list-icons-style-3 mt-xlg">
								<li><i class="fa fa-map-marker"></i> <strong>Address:</strong> No 80-1, Platinum Walk,Jalan Langkawi, Danau Kota,Setapak 53300, Kuala Lumpur.</li>
								<li><i class="fa fa-phone"></i> <strong>Phone:</strong> 03-4144 3505</li>
								<li><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:sales@edollar.com.my">sales@edollar.com.my</a></li>
							</ul>

							<div class="row lightbox mt-xl" data-plugin-options='{"delegate": "a", "type": "image", "gallery": {"enabled": true}}'>
								<div class="col-md-4">
									<a class="img-thumbnail" href="img/our-office-1.jpg" data-plugin-options='{"type":"image"}'>
										<img class="img-responsive" src="img/our-office-1.jpg" alt="Office">
										<span class="zoom">
											<i class="fa fa-search"></i>
										</span>
									</a>
								</div>
								<div class="col-md-4">
									<a class="img-thumbnail" href="img/our-office-2.jpg" data-plugin-options='{"type":"image"}'>
										<img class="img-responsive" src="img/our-office-2.jpg" alt="Office">
										<span class="zoom">
											<i class="fa fa-search"></i>
										</span>
									</a>
								</div>
								<div class="col-md-4">
									<a class="img-thumbnail" href="img/our-office-3.jpg" data-plugin-options='{"type":"image"}'>
										<img class="img-responsive" src="img/our-office-3.jpg" alt="Office">
										<span class="zoom">
											<i class="fa fa-search"></i>
										</span>
									</a>
								</div>
							</div>

							<hr>

							<h4 class="heading-primary">Business <strong>Hours</strong></h4>
							<ul class="list list-icons list-dark mt-xlg">
								<li><i class="fa fa-clock-o"></i> Monday - Friday - 9am to 5pm</li>
								<li><i class="fa fa-clock-o"></i> Saturday - 9am to 2pm</li>
								<li><i class="fa fa-clock-o"></i> Sunday - Closed</li>
							</ul>

						</div>
					</div>

				</div>

				<br/><br/>
				
				<!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
				<div id="googlemaps" class="google-map"></div>				
				
				
			</div>

			<footer id="footer">
				<div class="container">
					<div class="row">
						<div class="footer-ribbon">
							<span>About Us</span>
						</div>
						<div class="col-md-4">
							<div class="contact-details">
								<h4>Contact Us</h4>
								<ul class="contact">
									<li><p><i class="fa fa-map-marker"></i> <strong>Address:</strong> No 80-1, Platinum Walk,Jalan Langkawi, Danau Kota,Setapak 53300, Kuala Lumpur.</p></li>
									<li><p><i class="fa fa-phone"></i> <strong>Phone:</strong> 03-4144 3505</p></li>
									<li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:sales@edollar.com.my">sales@edollar.com.my</a></p></li>
								</ul>
							</div>
						</div>
						<div class="col-md-2">
							<h4>Follow Us</h4>
							<ul class="social-icons">
								<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						<div class="row">
							<div class="col-md-1">
								<a href="index.html" class="logo">
									<img alt="Porto Website Template" class="img-responsive" src="img/logo-footer.png">
								</a>
							</div>
							<div class="col-md-7">
								<p>© Copyright 2016. All Rights Reserved.</p>
							</div>
							<!--<div class="col-md-4">
								<nav id="sub-menu">
									<ul>
										<li><a href="page-faq.html">FAQ's</a></li>
										<li><a href="sitemap.html">Sitemap</a></li>
										<li><a href="contact-us.html">Contact</a></li>
									</ul>
								</nav>
							</div>-->
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="vendor/jquery-cookie/jquery-cookie.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/common/common.min.js"></script>
		<script src="vendor/jquery.validation/jquery.validation.min.js"></script>
		<script src="vendor/jquery.stellar/jquery.stellar.min.js"></script>
		<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="vendor/isotope/jquery.isotope.min.js"></script>
		<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="vendor/vide/vide.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="js/views/view.contact.js"></script>
		
		<!-- Theme Custom -->
		<script src="js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<script src="http://maps.google.com/maps/api/js"></script>
		<script>

			/*
			Map Settings

				Find the Latitude and Longitude of your address:
					- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
					- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

			*/

			// Map Markers
			var mapMarkers = [{
				address: "217 Summit Boulevard, Birmingham, AL 35243",
				html: "<strong>Alabama Office</strong><br>217 Summit Boulevard, Birmingham, AL 35243<br><br><a href='#' onclick='mapCenterAt({latitude: 33.44792, longitude: -86.72963, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			},{
				address: "645 E. Shaw Avenue, Fresno, CA 93710",
				html: "<strong>California Office</strong><br>645 E. Shaw Avenue, Fresno, CA 93710<br><br><a href='#' onclick='mapCenterAt({latitude: 36.80948, longitude: -119.77598, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			},{
				address: "New York, NY 10017",
				html: "<strong>New York Office</strong><br>New York, NY 10017<br><br><a href='#' onclick='mapCenterAt({latitude: 40.75198, longitude: -73.96978, zoom: 16}, event)'>[+] zoom here</a>",
				icon: {
					image: "img/pin.png",
					iconsize: [26, 46],
					iconanchor: [12, 46]
				}
			}];

			// Map Initial Location
			var initLatitude = 37.09024;
			var initLongitude = -95.71289;

			// Map Extended Settings
			var mapSettings = {
				controls: {
					draggable: (($.browser.mobile) ? false : true),
					panControl: true,
					zoomControl: true,
					mapTypeControl: true,
					scaleControl: true,
					streetViewControl: true,
					overviewMapControl: true
				},
				scrollwheel: false,
				markers: mapMarkers,
				latitude: initLatitude,
				longitude: initLongitude,
				zoom: 5
			};

			var map = $("#googlemaps").gMap(mapSettings),
				mapRef = $("#googlemaps").data('gMap.reference');

			// Map Center At
			var mapCenterAt = function(options, e) {
				e.preventDefault();
				$("#googlemaps").gMap("centerAt", options);
			}

			// Create an array of styles.
			var mapColor = "#0088cc";

			var styles = [{
				stylers: [{
					hue: mapColor
				}]
			}, {
				featureType: "road",
				elementType: "geometry",
				stylers: [{
					lightness: 0
				}, {
					visibility: "simplified"
				}]
			}, {
				featureType: "road",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}]
			}];

			var styledMap = new google.maps.StyledMapType(styles, {
				name: "Styled Map"
			});

			mapRef.mapTypes.set('map_style', styledMap);
			mapRef.setMapTypeId('map_style');

		</script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
			ga('create', 'UA-12345678-1', 'auto');
			ga('send', 'pageview');
		</script>
		 -->

	</body>
</html>
