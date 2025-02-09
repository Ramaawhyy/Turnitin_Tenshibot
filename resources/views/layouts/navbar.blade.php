<!DOCTYPE html>
<html lang="en">
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Tenshibot - Cek Plagiarisme Turnitin</title>	

		<meta name="keywords" content="WebSite Template" />
		<meta name="description" content="Porto - Multipurpose Website Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="icon" type="image/png" href="{{ url('img/tenshibot/logologin.png') }}">
		

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-star-rating/css/star-rating.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">

		<!-- Demo CSS -->
		<link rel="stylesheet" href="css/demos/demo-auto-services.css">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="css/skins/skin-auto-services.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">
		<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

	</head>
	<body>

		<div class="body">
			<div class="notice-top-bar bg-primary" data-sticky-start-at="100">
				<button class="hamburguer-btn hamburguer-btn-light notice-top-bar-close m-0 active" data-set-active="false">
					<span class="close">
						<span></span>
						<span></span>
					</span>
				</button>
				
			</div>
			<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyStartAt': 54, 'stickySetTop': '-54px', 'stickyChangeLogo': false}">
				<div class="header-body header-body-bottom-border-fixed">
					
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column w-100">
								<div class="header-row justify-content-between">
									<div class="header-logo z-index-2 col-lg-2 px-0">
										<a href="{{ url('/') }}">
											<img alt="Porto" width="" height="70" data-sticky-width="82" data-sticky-height="40" data-sticky-top="100" src="img/tenshibot/logo-tenshi.png">
										</a>
									</div>
									
									
									
									<ul class="header-extra-info custom-left-border-1 d-none d-xl-flex">
										<li class="nav-item">
											<a href="{{ route('register') }}" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation me-3" data-appear-animation="fadeInUpShorter"  style="border-radius: 20px; box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.229), 0 4px 8px rgba(0, 0, 0, 0.15); transition: background-color 0.3s;">
												Daftar
												<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
													<polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
												</svg>
											</a>
										</li>
										<li class="nav-item">
											<a href="{{ route('login') }}" class="btn btn-white custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation" data-appear-animation="fadeInUpShorter"  style="border-radius: 20px; margin-left: 5px; border: 2px solid #1C79BE; color: #1C79BE; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);">
												Masuk
												<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
													<polygon stroke="#1C79BE" stroke-width="0.1" fill="#1C79BE" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
												</svg>
											</a>
										</li>
										
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
<div class="container mt-5">
    @yield('content')
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Vendor -->
<script src="vendor/plugins/js/plugins.min.js"></script>
<script src="vendor/bootstrap-star-rating/js/star-rating.min.js"></script>
<script src="vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>

<!-- Current Page Vendor and Views -->
<script src="js/views/view.contact.js"></script>
<script src="js/views/view.shop.js"></script>

<!-- Demo -->
<script src="js/demos/demo-auto-services.js"></script>

<!-- Theme Custom -->
<script src="js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>
</body>
</html>
