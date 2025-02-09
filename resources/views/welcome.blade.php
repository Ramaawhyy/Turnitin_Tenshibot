<!DOCTYPE html>
<html lang="en">
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Tenshibot</title>	

		<meta name="keywords" content="WebSite Template" />
		<meta name="description" content="Tenshibot - Turnitin">
		<meta name="author" content="okler.net">

		<link rel="icon" href="img/tenshibot/logo-tenshi.png" type="image/png" />
		

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
		<style>
			
			/* Hover Effect for Feature Items */
			.feature-item:hover {
				transform: translateY(-10px);
				box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
			}
	
			/* Smooth Transition */
			.feature-item {
				transition: transform 0.3s, box-shadow 0.3s;
			}
	
			/* Responsive Icon Sizes */
			@media (max-width: 767px) {
				.feature-item i.fas {
					font-size: 2.5rem; /* Smaller icons on mobile */
				}
			}
		</style>

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
										<a href="demo-auto-services.html">
											<img alt="Porto" width="" height="70" data-sticky-width="82" data-sticky-height="40" data-sticky-top="100" src="img/tenshibot/logo-tenshi.png">
										</a>
									</div>
									
									
									<ul class="header-extra-info custom-left-border-1 d-none d-xl-block d-lg-block d-md-block d-sm-block">
										<div class="d-flex justify-content-between">
											<a href="{{ route('register') }}" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation me-3" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.229), 0 4px 8px rgba(0, 0, 0, 0.15);">
												Daftar
												<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
													<polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
												</svg>
											</a>
											<a href="{{ route('login') }}" class="btn btn-white custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; margin-left: 5px; border: 2px solid #1C79BE; color: #1C79BE; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);">
												Masuk
												<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
													<polygon stroke="#1C79BE" stroke-width="0.1" fill="#1C79BE" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
												</svg>
											</a>
										</div>
									</ul>
									<ul class="header-extra-info custom-left-border-1 d-block d-xl-none d-lg-none d-md-none d-sm-none">
										<div class="d-flex justify-content-between">
											<a href="{{ route('register') }}" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation me-2" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.229), 0 4px 8px rgba(0, 0, 0, 0.15);">
												Daftar
												<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
													<polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
												</svg>
											</a>
											<a href="{{ route('login') }}" class="btn btn-white custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; border: 2px solid #1C79BE; color: #1C79BE; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);">
												Masuk
												<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
													<polygon stroke="#1C79BE" stroke-width="0.1" fill="#1C79BE" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
												</svg>
											</a>
										</div>
									</ul>
							</div>
						</div>
					</div>
				</div>
			</header>
			
			

			<div role="main" class="main">

				<section class="section custom-section-background position-relative border-0 overflow-hidden m-0 p-0">
						<div class="position-absolute top-0 left-0 right-0 bottom-0 animated fadeIn" style="animation-delay: 600ms;">
							<div class="background-image-wrapper custom-background-style-1 position-absolute top-0 left-0 right-0 bottom-0" 
								 style="background-image: url(img/tenshibot/test.png); 
										background-size: 110%; 
										background-position: center; 
										background-repeat: no-repeat; 
										animation-duration: 30s;">
							</div>
						</div>
						<div class="container position-relative py-sm-5 my-5">
							<div class="row mb-5 p-relative z-index-1" style="margin-top: 50px;">
								<div class="col-md-8 col-lg-6 col-xl-5">
									<h1 class="text-color-dark font-weight-bold text-7 pb-2 mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1100" style="font-size: 1.5rem; padding: 0 20px;">
										<span style="color: #1C79BE;">Tenshi Bot</span> : Cek orisinalitas karya tulis anda hanya dengan Rp.2000!
									</h1>
									<div class="overflow-hidden mb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1100">
										<h2 class="font-weight-normal text-color-grey text-5-6 line-height-2 line-height-sm-7 mb-2 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="800" style="font-size: 1.2rem; padding: 0 20px;">
											Tenshi menyediakan servis kilat cek plagiasi 
											<span style="color: black; font-weight: bold;">No Repository</span> 24 jam yang terintegrasi 
											dengan Turnitin.
										</h2>
										<div class="d-flex justify-content-between"> 
											<div>
												<h2 class="font-weight-semibold text-color-grey text-3-4 line-height-2 line-height-sm-7 mb-0" style="font-size: 1.2rem; padding: 0 20px;">
													Sobat Tenshi Terdaftar
												</h2>
												<h2 class="counter font-weight-bold text-color-black text-4-5 line-height-2 line-height-sm-7 mb-0" data-target="10000" style="font-size: 1.2rem; padding: 0 20px;">0+</h2>
											</div>
											<div>
												<h2 class="font-weight-semibold text-color-grey text-3-4 line-height-2 line-height-sm-7 mb-0" style="font-size: 1.2rem; padding: 0 20px; margin-right: 120px;">
													Total Pengecekan Dokumen
												</h2>
												<h2 class="counter font-weight-bold text-color-black text-4-5 line-height-2 line-height-sm-7 mb-0" data-target="50000" style="font-size: 1.2rem; padding: 0 20px;">
													0+
												</h2>
											</div>
										</div>
									</div>
									<br>
									<div class="d-flex justify-content-start">
										<a href="{{ route('cek-turnitin.index') }}" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation me-3" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.229), 0 4px 8px rgba(0, 0, 0, 0.15); padding: 10px 20px; margin-left: 15px;">
											Cek Dokumen Anda Disini
											<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
												<polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
											</svg>
										</a>
									</div>
								</div>
								<div class="col-md-4 col-lg-6 col-xl-7 d-flex justify-content-end align-items-center" style="margin-top: -200px;">
									<img src="img/tenshibot/tenshibot-2.png" alt="Deskripsi Gambar" class="img-fluid d-none d-md-block" style="border-radius: 10px; width: 130%; margin-left: 80px;">
								</div>
							</div>
						</div>
					</section>
			
			</div>
			

				<section class="custom-section-background position-relative border-0 overflow-hidden m-0 p-10">
					<div class="background-image-wrapper custom-background-style-1 position-absolute top-0 left-0 right-0 bottom-0" 
							 style="background-image: url(img/tenshibot/background2.png); 
									background-size: 110%; 
									background-position: center; 
									background-repeat: no-repeat; 
									animation-duration: 30s;">
						</div>
					<div class="container pt-md-4 pt-xl-0">
						
						<div class="row align-items-center justify-content-center pb-4 mb-5">
							
							<div class="row">
							
								<div class="col-lg-6 col-md-6 col-12 ps-lg-5 pe-5 appear-animation" data-appear-animation="fadeInRightShorterPlus" data-appear-animation-delay="1450" data-plugin-options="{'accY': -200}">
									<div class="position-relative">
										<div data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 0.2, 'transition': true, 'transitionDuration': 1000, 'isInsideSVG': true}">
											<img src="img/demos/auto-services/generic-1.png" class="img-fluid" alt="Gambar Utama" />
										</div>
										<div class="position-absolute transform3dxy-n50" style="top: 25%; left: 7%;">
											<div data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 0.5, 'transition': true, 'transitionDuration': 2000, 'isInsideSVG': false}">
												<img src="img/demos/auto-services/generic-1-1.png" class="appear-animation" alt="Gambar Layer 1" data-appear-animation="fadeInUpShorterPlus" data-appear-animation-delay="1700" />
											</div>
										</div>
										<div class="position-absolute transform3dxy-n50 ms-5 pb-5 ms-xl-0" style="top: 32%; left: 85%;">
											<div data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 1, 'transition': true, 'transitionDuration': 1500, 'isInsideSVG': false}">
												<img src="img/demos/auto-services/generic-1-2.png" class="appear-animation" alt="Gambar Layer 2" data-appear-animation="fadeInRightShorterPlus" data-appear-animation-delay="1900" />
											</div>
										</div>
										<div class="position-absolute transform3dxy-n50" style="top: 90%; left: 19%;">
											<div data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 2, 'transition': true, 'transitionDuration': 2500, 'isInsideSVG': false}">
												<img src="img/demos/auto-services/generic-1-3.png" class="appear-animation" alt="Gambar Layer 3" data-appear-animation="fadeInDownShorterPlus" data-appear-animation-delay="2100" />
											</div>
										</div>
									</div>
								</div>
							
								
								<div class="col-lg-6 col-md-6 col-12 pb-sm-4 pb-lg-0 mb-5 mb-lg-0 d-none d-md-block">
									<div class="overflow">
										<h4 class="font-weight-bold text-color-dark line-height-2 pb-2 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="300"><span style="color: #1C79BE;">Layanan Kami</span> </h4>
									</div>
									<div class="overflow">
										<h1 class="font-weight-bold text-color-dark line-height-2 pb-2 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="300">Mengapa Harus Menggunakan<br><span style="color: #1C79BE;">Tenshi Bot</span> ?</h1>
									</div>
									<p class="pb-1 text-4 mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="450" style="color: #878484;">Dengan menggunakan <b>Tenshi Bot</b>, kamu dapat melakukan pengecekan skor 
										plagiasi dengan mudah tanpa harus memiliki akses ke Turnitin.</p>
									<p class="pb-1 mb-4 text-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700" style="color: #878484;"><b>Tenshi Bot</b> melakukan pengecekan dokumen kamu secara otomatis dengan 
										integrasi layanan Turnitin. Kamu dapat mengelola banyak pengecekan 
										dokumen sekaligus dalam satu dashboard</p>
									<p class="pb-1 mb-4 text-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700" style="color: #878484;">Atau kamu juga bisa menggunakan layanan Cek Instant tanpa perlu 
										melakukan registrasi mulai dari Rp 2.000,00.</p>
									
									</div>
								</div>
							</div>
				</section>
				
				
				<section class="section custom-section-background position-relative border-0 overflow-hidden m-0 p-0">
					<div class="position-absolute top-0 left-0 right-0 bottom-0 animated fadeIn" style="animation-delay: 600ms;">
						<div class="background-image-wrapper custom-background-style-1 position-absolute top-0 left-0 right-0 bottom-0" 
							 style="background-image: url(img/tenshibot/background3.png); 
									background-size: 110%; 
									background-position: center; 
									background-repeat: no-repeat; 
									animation-duration: 30s;">
						</div>
					</div>
					<div class="container py-5 my-5">
						<div class="row justify-content-center">
							<div class="col-lg-9 col-xl-8 text-center">
								<div class="overflow-hidden">
									<h1 class="font-weight-bold text-color-dark line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="250"><span style="color: #1C79BE;">Tinggal Duduk Manis</span> File Anda Akan<br> 
										Di Proses Otomatis</h1>
								</div>
								<div class="d-inline-block custom-divider divider divider-primary divider-small my-3">
									
								</div>
								<p class="pb-1 text-5 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><b>Benefit</b> yang sobat Tenshi dapatkan ketika cek plagiasi di sini: 
									</p>
							</div>
						</div>
						
						<div class="container my-5">
							<div class="row justify-content-center">
								<div class="col-12 col-lg-15"> 
									<div class="text-center">
										<div class="card-body p-5" style="background-color: #ECF7FF; border-radius: 30px; border: 2px solid #1C79BE;">
											<!-- First Row of Icons -->
											<div class="row mb-5">
												<!-- Feature 1 -->
												<div class="col-md-4 mb-4 mb-md-0">
													<div class="feature-item p-4">
														<i class="fas fa-clock fa-3x mb-3" style="color: #1C79BE;"></i>
														<h5 class="mb-2">Buka 24 JAM</h5>
														<p class="text-muted">Pagi sampai ke pagi lagi, Tenshi selalu siap melayani kalian!</p>
													</div>
												</div>
												<!-- Feature 2 -->
												<div class="col-md-4 mb-4 mb-md-0">
													<div class="feature-item p-4">
														<i class="fas fa-bolt fa-3x mb-3" style="color: #1C79BE;"></i>
														<h5 class="mb-2">Proses Kilat</h5>
														<p class="text-muted">Sat-set, hanya 10-15 menit hasil pengecekan sudah keluar!</p>
													</div>
												</div>
												<!-- Feature 3 -->
												<div class="col-md-4">
													<div class="feature-item p-4">
														<i class="fas fa-filter fa-3x mb-3" style="color: #1C79BE;"></i>
														<h5 class="mb-2">Bebas Filter</h5>
														<p class="text-muted">Mau request filter apa saja bisa, hanya perlu centang filternya!</p>
													</div>
												</div>
											</div>
											<!-- Second Row of Icons -->
											<div class="row">
												<!-- Feature 4 -->
												<div class="col-md-4 mb-4 mb-md-0">
													<div class="feature-item p-4">
														<i class="fas fa-lock fa-3x mb-3" style="color: #1C79BE;"></i>
														<h5 class="mb-2">Data Terjamin Keamanannya</h5>
														<p class="text-muted">Semua file sobat Tenshi tidak masuk repository dan dijamin aman.</p>
													</div>
												</div>
												<!-- Feature 5 -->
												<div class="col-md-4 mb-4 mb-md-0">
													<div class="feature-item p-4">
														<i class="fas fa-headset fa-3x mb-3" style="color: #1C79BE;"></i>
														<h5 class="mb-2">Tersedia Customer Service</h5>
														<p class="text-muted">Jika ada kendala terkait layanan kita, tinggal lapor ke CS Tenshi, dijamin kembali Happy!</p>
													</div>
												</div>
												<!-- Feature 6 -->
												<div class="col-md-4">
													<div class="feature-item p-4">
														<i class="fas fa-comments fa-3x mb-3" style="color: #1C79BE;"></i>
														<h5 class="mb-2">Layanan Tanya Jawab</h5>
														<p class="text-muted">Tenshibot siap membantu kamu melalui DM IG atau WhatsApp!</p>
													</div>
												</div>
											</div>
										</div>
								
						
						
										
												
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					</section>
					<section class="section custom-section-background position-relative border-0 overflow-hidden m-0 p-0">
						<div class="background-image-wrapper custom-background-style-1 position-absolute top-0 left-0 right-0 bottom-0" 
								 style="background-image: url(img/tenshibot/background2.png); 
										background-size: 110%; 
										background-position: center; 
										background-repeat: no-repeat; 
										animation-duration: 30s;">
							</div>
						<div class="container pb-3 my-5"> 
							<div class="row justify-content-center pb-3 mb-4">
								<div class="col text-center">
									<h2 class="font-weight-bold text-color-dark line-height-1 mb-0 text-center">Testimoni Tenshi</h2>
									<div class="d-inline-block custom-divider divider divider-primary divider-small my-3 text-center">
										<hr class="my-0">
									</div>
									<p class="font-weight-bold text-3-5 mb-1 text-center">Respon positif dari Sobat Tenshi atas layanan kami!</p>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="owl-carousel nav-outside nav-style-1 nav-dark nav-arrows-thin nav-font-size-lg custom-carousel-box-shadow-1 mb-0 text-center" data-plugin-options="{'responsive': {'0': {'items': 1}, '479': {'items': 1}, '768': {'items': 2}, '979': {'items': 2}, '1199': {'items': 3}}, 'autoplay': true, 'autoplayTimeout': 5000, 'autoplayHoverPause': true, 'dots': false, 'nav': true, 'loop': true, 'margin': 15, 'stagePadding': '75'}">
										<div>
											<div class="card custom-border-radius-1 h-100 text-center">
												<div class="card-body text-center">
													<div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote text-center mb-0">
														<blockquote class="text-center">
															<p class="text-color-dark text-3 font-weight-light px-0 mb-2 text-center" style="margin-left: 10px;">AAA TERIMAKASIH BANGET BUAT TENSHI BOT! ga nyangka nemuin jasa cek plagiasi yang otomatis, 24 jam, dan cepet banget pemrosesan filenya! Pokoknya the best buat tenshi!</p>
														</blockquote>
														<div class="testimonial-author text-center">
															<p class="text-center"><strong class="font-weight-extra-bold text-center">Nadia – Universitas Brawijaya</strong></p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div>
											<div class="card custom-border-radius-1 h-100 text-center">
												<div class="card-body text-center">
													<div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote text-center mb-0">
														<blockquote class="text-center">
															<p class="text-color-dark text-3 font-weight-light px-0 mb-2 text-center" style="margin-left: 10px;">Proses pengecekkan cepat, harganya murah, dan yang penting selalu buka kapanpun dibutuhin.<span style="visibility:hidden;">isi yang kosong dengan teks tetapi asli tidak terlihat gituu tidak terlihat hahaha geilo</span></p>
														</blockquote>
														<div class="testimonial-author text-center">
															<p class="text-center"><strong class="font-weight-extra-bold text-center">Amir Syaifullah – Universitas Mulawarman</strong></p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div>
											<div class="card custom-border-radius-1 h-100 text-center">
												<div class="card-body text-center">
													<div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote text-center mb-0">
														<blockquote class="text-center">
															<p class="text-color-dark text-3 font-weight-light px-0 mb-2 text-center" style="margin-left: 10px;">Tenshi bot selalu jadi pilihan kalau lagi butuh pengecekkan plagiasi turnitin. Mudah, cepet, dan juga aman. <span style="visibility:hidden;">isi yang kosong dengan teks tetapi asli tidak terlihat gituu tidak terlihat hahaha geilo</span></p>
														</blockquote>
														<div class="testimonial-author text-center">
															<p class="text-center"><strong class="font-weight-extra-bold text-center">Aditya Habibie – Universitas Pamulang</strong></p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div>
											<div class="card custom-border-radius-1 h-100 text-center">
												<div class="card-body text-center">
													<div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote text-center mb-0">
														<blockquote class="text-center">
															<p class="text-color-dark text-3 font-weight-light px-0 mb-2 text-center" style="margin-left: 10px;">Terimakasih tenshi bot udah 24/7  selalu bantu kita untuk cek plagiasi! Sehat-sehat mimin Tenshi! <span style="visibility:hidden;">isi yang  <span style="visibility:hidden;">isi yang kosong dengan teks tetapi asli tidak terlihat gituu tidak terlihat hahaha geilo</span></p>
														</blockquote>
														<div class="testimonial-author text-center">
															<p class="text-center"><strong class="font-weight-extra-bold text-center">Mikhaila – Binus University</strong></p>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div>
											<div class="card custom-border-radius-1 h-100 text-center">
												<div class="card-body text-center">
													<div class="custom-testimonial-style-1 testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote text-center mb-0">
														<blockquote class="text-center">
															<p class="text-color-dark text-3 font-weight-light px-0 mb-2 text-center" style="margin-left: 10px;">Mantap Tenshi Bot, gapernah nyesal kalau cek plagiasi disini. <span style="visibility:hidden;">isi yang kosong dengan teks tetapi asli tidak terlihat gituu tidak terlihat hahaha geilo  tidak terlihat hahaha geilo  tidak terlihat hahaha geilo</span></p>
														</blockquote>
														<div class="testimonial-author text-center">
															<p class="text-center"><strong class="font-weight-extra-bold text-center">Fariz S. – Universitas Trunojoyo</strong></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				<section class="section section-height-3 border-0 m-0" style="background-color: #ECF7FF; background-image: url('img/tenshibot/2 2.png'); background-position: left center; background-repeat: no-repeat;">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-6 col-xl-7 text-center text-lg-start mb-4 mb-lg-0">
								<h3 class="font-weight-bold text-color-dark text-transform-none text-8 line-height-2 line-height-lg-1 mb-1">Yakin,<span style="color: #1C79BE;">Karya Tulis</span> Kamu Bebas Plagiasi?</h3>
								<p class="font-weight-bold text-color-dark text-4 opacity-7 mb-0">Dapatkan hasil pemeriksaan plagiasi dalam waktu kurang dari 2 menit.</p>
							</div>
							<div class="col-lg-6 col-xl-5">
								<div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
									<div class="feature-box align-items-center mb-3 mb-lg-0">
										
									
									</div>
									<a href="{{ route('cek-turnitin.index') }}" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation me-3" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.229), 0 4px 8px rgba(0, 0, 0, 0.15);">
										Bergabung Sekarang
										<svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
											<polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
										</svg>
									</a>
								</div>
							</div>
						</div>
					</div>
				</section>

				

				

				

				

			</div> 

			<footer id="footer" class="border-0 mt-0">
				<div class="container py-5">
					<div class="row py-3">
						<div class="col-md-4 mb-5 mb-md-0">
							<div class="feature-box flex-column flex-xl-row align-items-center align-items-lg-center text-center text-lg-start">
								<div class="feature-box-icon bg-transparent mb-4 mb-xl-0 p-0">
									<i class="fab fa-instagram text-9 text-color-light position-relative top-4"></i>
								</div>
								<div class="feature-box-info line-height-1 ps-2">
									<a href="https://www.instagram.com/tenshi.turnitin/" target="_blank" class="d-block font-weight-bold text-color-light text-5 mb-2">Instagram</a>
									<a href="https://www.instagram.com/tenshi.turnitin/" target="_blank" class="text-color-light text-4 line-height-4 font-weight-light mb-0">@tenshi.turnitin</a>
								</div>
							</div>
						</div>
						
						
					</div>
				</div>
				<hr class="bg-light opacity-2 my-0">
				<div class="container pb-5">
					<div class="row text-center text-md-start py-4 my-5">
						<div class="col-md-6 col-lg-3 align-self-center text-center text-md-start text-lg-center mb-5 mb-lg-0">
							<a href="demo-auto-services.html" class="text-decoration-none">
								<img src="img/tenshibot/logo-tenshi.png" class="img-fluid" alt="logotenshibot" />
							</a>
						</div>
						<div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
							<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4">Media Sosial</h5>
							<ul class="list list-unstyled">
								
							</ul>
							<ul class="social-icons social-icons-medium">
								<li class="social-icons-instagram">
									<a href="http://www.instagram.com/tenshi.turnitin" class="no-footer-css" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
								</li>
								<li class="social-icons-twitter mx-2">
									<a href="http://www.twitter.com/" class="no-footer-css" target="_blank" title="Twitter"><i class="fab fa-x-twitter"></i></a>
								</li>
								<li class="social-icons-facebook">
									<a href="http://www.facebook.com/" class="no-footer-css" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
								</li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-2 mb-5 mb-md-0">
							<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4">Layanan Kami</h5>
							<ul class="list list-unstyled mb-0">
								<li class="mb-0">Buka 24 JAM<</li>
								<li class="mb-0">Proses Kilat</li>
								<li class="mb-0">Bebas Filter</li>
								<li class="mb-0">Data Terjamin Keamanannya</li>
								<li class="mb-0">Tersedia Customer Service</li>
								<li class="mb-0">Layanan Tanya Jawab</li>
							</ul>
						</div>
						<div class="col-md-6 col-lg-3 offset-lg-1">
							<h5 class="text-transform-none font-weight-bold text-color-light text-4-5 mb-4">Opening Hours</h5>
							<ul class="list list-unstyled list-inline custom-list-style-1 mb-0">
								<li>24 jam</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>

		</div>
		
		<!-- Vendor -->
		<script src="vendor/plugins/js/plugins.min.js"></script>
		<script src="vendor/bootstrap-star-rating/js/star-rating.min.js"></script>
		<script src="vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.min.js"></script>

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
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const counters = document.querySelectorAll('.counter');
			
				const options = {
					root: null,
					rootMargin: '0px',
					threshold: 0.5 // 50% elemen terlihat
				};
			
				const startCounter = (counter) => {
					const target = +counter.getAttribute('data-target');
					const duration = 2000; // Durasi animasi dalam milidetik
					const startTime = performance.now();
			
					const updateCounter = (currentTime) => {
						const elapsed = currentTime - startTime;
						const progress = Math.min(elapsed / duration, 1);
						const currentCount = Math.floor(progress * target);
			
						counter.innerText = currentCount.toLocaleString('id-ID') + ' +';
			
						if (progress < 1) {
							requestAnimationFrame(updateCounter);
						} else {
							counter.innerText = target.toLocaleString('id-ID') + ' +';
						}
					};
			
					requestAnimationFrame(updateCounter);
				};
			
				const observerCallback = (entries, observer) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							startCounter(entry.target);
							observer.unobserve(entry.target); // Hentikan observasi setelah animasi dimulai
						}
					});
				};
			
				const observer = new IntersectionObserver(observerCallback, options);
			
				counters.forEach(counter => {
					observer.observe(counter);
				});
			});
			</script>
				
				
				<!-- Sertakan CountUp.js sebelum skrip inisialisasi -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.umd.js"></script>


	</body>
</html>
