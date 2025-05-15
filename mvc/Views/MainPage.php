<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>suhohome</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="ShopProject/assets/css/all.min.css">
	<!-- fontawesome -->
	<link rel="stylesheet" href="/ShopProject/assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="/ShopProject/assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="/ShopProject/assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="/ShopProject/assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="/ShopProject/assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="/ShopProject/assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="/ShopProject/assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="/ShopProject/assets/css/responsive.css">
	<!-- Product page -->
	<link rel="stylesheet" href="/ShopProject/assets/css/product.css">
		<!-- Post page -->
	<link rel="stylesheet" href="/ShopProject/assets/css/post.css">


</head>


<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.html">
								<img src="./assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="/ShopProject/Home">Home</a>
									
								</li>
								<li><a href="/ShopProject/About">About</a></li>
								
								<li><a href="/ShopProject/PostList">News</a>
									<ul class="sub-menu">
										<li><a href="./NewListPage.php">News</a></li>
									</ul>
								</li>
								<li><a href="/ShopProject/Contact">Contact</a></li>
								<li><a href="/ShopProject/ProductList">Shop</a>
								</li>
								<li>
									
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
    <?php  
        if(isset($data["Page"])) {
            require($data["Page"].".php");
        }
            
    ?>
	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>34/8, East Hukupara, Gifirtok, Sadan.</li>
							<li>support@fruitkha.com</li>
							<li>+00 111 222 3333</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box pages">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="index.html">Home</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="services.html">Shop</a></li>
							<li><a href="news.html">News</a></li>
							<li><a href="contact.html">Contact</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box subscribe">
						<h2 class="widget-title">Subscribe</h2>
						<p>Subscribe to our mailing list to get the latest updates.</p>
						<form action="index.html">
							<input type="email" placeholder="Email">
							<button type="submit"><i class="fas fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>,  All Rights Reserved.<br>
						Distributed By - <a href="https://themewagon.com/">Themewagon</a>
					</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->


	<!-- jquery -->
	<script src="/ShopProject/assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="/ShopProject/assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="/ShopProject/assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="/ShopProject/assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="/ShopProject/assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="/ShopProject/assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="/ShopProject/assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="/ShopProject/assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="/ShopProject/assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="/ShopProject/assets/js/main.js"></script>
	<script src="/ShopProject/assets/js/post.js"></script>


    </body>

</html>