
<!-----------------------------------------------------------------------------------
    Item Name: Carrot - Multipurpose eCommerce HTML Template.
    Author: ashishmaraviya
    Version: 2.0
    Copyright 2024
----------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">

	<title>YKTB - Siswa</title>

	<!-- App favicon -->

	<!-- Icon CSS -->
	<link href="assets/css/vendor/materialdesignicons.min.css" rel="stylesheet">
	<link href="assets/css/vendor/remixicon.css" rel="stylesheet">
	<link href="assets/css/vendor/owl.carousel.min.css" rel="stylesheet">

	<!-- Vendor CSS -->
	<link href='assets/css/vendor/datatables.bootstrap5.min.css' rel='stylesheet'>
	<link href='assets/css/vendor/responsive.datatables.min.css' rel='stylesheet'>
	<link href='assets/css/vendor/daterangepicker.css' rel='stylesheet'>
	<link href="assets/css/vendor/simplebar.css" rel="stylesheet">
	<link href="assets/css/vendor/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/vendor/apexcharts.css" rel="stylesheet">
	<link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet">

	<!-- Main CSS -->
	<link id="main-css" href="assets/css/style.css" rel="stylesheet">
    @yield('style')

</head>

<body>
	<main class="wrapper sb-default ecom">
		<!-- Loader -->
		<div id="cr-overlay">
			<div class="loader"></div>
		</div>

		<!-- Header -->
		<header class="cr-header">
			<div class="container-fluid">
				<div class="cr-header-items">
					<div class="left-header">
						<a href="javascript:void(0)" class="cr-toggle-sidebar">
							<span class="outer-ring">
								<span class="inner-ring"></span>
							</span>
						</a>
					</div>
					<div class="right-header">
						<div class="cr-right-tool display-screen">
							<a class="cr-screen full" href="javascript:void(0)"><i
									class="ri-fullscreen-line"></i></a>
							<a class="cr-screen reset" href="javascript:void(0)"><i
									class="ri-fullscreen-exit-line"></i></a>
						</div>
						<div class="cr-right-tool display-dark">
							<a class="cr-mode dark" href="javascript:void(0)"><i class="ri-moon-clear-line"></i></a>
							<a class="cr-mode light" href="javascript:void(0)"><i class="ri-sun-line"></i></a>
						</div>
						<div class="cr-right-tool cr-user-drop">
							<div class="cr-hover-drop">
								<div class="cr-hover-tool">
									<img class="user" src="assets/img/user/3135715.png" alt="user">
								</div>
								<div class="cr-hover-drop-panel right">
									<div class="details">
										<h6>{{Auth::user()->name}}</h6>
										<p>{{Auth::user()->email}}</p>
									</div>
									<ul class="border-top">
										<li><a href="team-profile.html">Profile</a></li>
									</ul>
									<ul class="border-top">
										<li>
                                            <a class="dropdown-item" href="{{ route('login-siswa.logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                <i class="ri-logout-circle-r-line"></i>
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('login-siswa.logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<!-- sidebar -->
		<div class="cr-sidebar-overlay"></div>
		<div class="cr-sidebar" data-mode="light">
			<div class="cr-sb-logo">
                <h4 class="sb-full">PPDB - YKTB</h4>
                <h4 class="sb-collapse">PPDB</h4>
			</div>
			<div class="cr-sb-wrapper">
				<div class="cr-sb-content">
					<ul class="cr-sb-list">
						<li class="cr-sb-item sb-drop-item">
							<a href="{{route('dashboard-siswa.index')}}" class="cr-drop-toggle">
								<i class="ri-dashboard-3-line"></i><span class="condense">Dashboard</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- Main content -->
		<div class="cr-main-content">
			<div class="container-fluid">
				@yield('content')
			</div>
		</div>

		<!-- Footer -->
		<footer>
			<div class="container-fluid">
				<div class="copyright">
					<p><span id="copyright_year"></span> © Carrot, All rights Reserved.</p>
					<p>Design by MaraviyaInfotech.</p>
				</div>
			</div>
		</footer>

	</main>

	<!-- Vendor Custom -->
	<script src="assets/js/vendor/jquery-3.6.4.min.js"></script>
	<script src="assets/js/vendor/simplebar.min.js"></script>
	<script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
	<script src="assets/js/vendor/apexcharts.min.js"></script>
	<script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/js/vendor/owl.carousel.min.js"></script>
	<!-- Data Tables -->
	<script src='assets/js/vendor/jquery.datatables.min.js'></script>
	<script src='assets/js/vendor/datatables.bootstrap5.min.js'></script>
	<script src='assets/js/vendor/datatables.responsive.min.js'></script>
	<!-- Caleddar -->
	<script src="assets/js/vendor/jquery.simple-calendar.js"></script>
	<!-- Date Range Picker -->
	<script src="assets/js/vendor/moment.min.js"></script>
	<script src="assets/js/vendor/daterangepicker.js"></script>
	<script src="assets/js/vendor/date-range.js"></script>
	<script src="assets/js/vendor/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<!-- Main Custom -->
	<script src="assets/js/main.js"></script>
    @yield('script')
</body>

</html>
