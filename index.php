<?php
session_start();

require "./config/function.php";

// cek session
if (empty($_SESSION["logged_in"])) {
	header("Location: login.php");
	exit;
} else {
	$id_user = $_SESSION['id_user'];

	$query_data_user_login = "SELECT * FROM tb_user WHERE id_user='$id_user'";
	$data_data_user_login = $db_connect->prepare($query_data_user_login);
	$data_data_user_login->execute();

	if ($row = $data_data_user_login->fetch(PDO::FETCH_ASSOC)) {
		$username = $row['username'];
		$user_nama = $row['nama_lengkap'];
		$user_email = $row['email'];
		$user_foto = $row['foto'];
		$user_level = $row['level'];
	}
}

?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<link rel="shortcut icon" href="assets/images/logo-kuburaya.png">
	<title>SISTEM LAYANAN MASYARAKAT - DESA RASAU JAYA SATU</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
	<!-- CSS files -->
	<link href="dist/css/tabler.min.css" rel="stylesheet" />
	<link href="dist/css/tabler-flags.min.css" rel="stylesheet" />
	<link href="dist/css/tabler-payments.min.css" rel="stylesheet" />
	<link href="dist/css/tabler-vendors.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="dist/libs/select2/css/select2.min.css">
	<link rel="stylesheet" href="dist/libs/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="dist/libs/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="dist/libs/datatables-responsive/css/responsive.bootstrap4.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="dist/css/demo.min.css" rel="stylesheet" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/js/fontawesome.min.js" integrity="sha512-xs1el+uLI2T4QTvRIv3kFBWvjQiPVAvKQM4kzZrJoLVZ1tSz1E0fkZch0cjd1f+sTk2MtBCHbP3PiVTdoFKAJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script src="dist/libs/select2/js/select2.min.js"></script>
	<script src="dist/libs/datatables/jquery.dataTables.min.js"></script>
	<script src="dist/libs/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="dist/libs/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="dist/libs/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

	<style>
		*,
		html,
		body {
			font-family: 'Poppins', sans-serif;
		}
	</style>
</head>

<body class="antialiased">

	<div class="wrapper">
		<div class="sticky-top">
			<header class="navbar navbar-expand-md navbar-dark sticky-top d-print-none">
				<div class="container-xl">
					<button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
						<span class="navbar-toggler-icon"></span>
					</button>

					<h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
						<a href="./" style="text-decoration: none;">
							<div class="d-flex align-items-center">
								<img src="assets/images/logo-kuburaya.png" style="height: 40px; margin-right: 5px;">
								<div class="d-block d-lg-none">
									SLM - RASAU JAYA SATU
								</div>
								<div class="d-none d-lg-block">
									SISTEM LAYANAN MASYARAKAT - DESA RASAU JAYA SATU
								</div>
							</div>
						</a>
					</h1>

					<div class="navbar-nav flex-row order-md-last">
						<div class="nav-item dropdown me-3">
							<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="35" height="35" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
									<path d="M9 17v1a3 3 0 0 0 6 0v-1" />
								</svg>
								<span class="badge bg-red"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
								<div class="card">
									<div class="card-body">
										<h4>
											Notifikasi
										</h4>
										<p>
											Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, explicabo?
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="nav-item dropdown">
							<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
								<span class="avatar avatar-sm" style="background-image: url('<?= (empty($user_foto)) ? 'assets/images/noimg.png' : 'assets/images/profil/' . $user_foto; ?>')"></span>
								<div class="d-none d-xl-block ps-2 pt-3">
									<div>
										<?= $user_nama; ?>
									</div>
									<p class="mt-1 text-muted" style="font-size: 10px;">
										<?= $username; ?>
									</p>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
								<div class="text-center mt-3">
									<img src="<?= (empty($user_foto)) ? 'assets/images/noimg.png' : 'assets/images/profil/' . $user_foto; ?>" style="width: 100px; height: 100px; background: #fff; border-radius: 50%;">
									<div>
										<span>
											<?= $user_nama; ?>
										</span>
										<p class="mt-1" style="font-size: 10px;">
											<?= $username; ?>
										</p>
									</div>
								</div>
								<a href="index.php?p=pengaturan" class="dropdown-item">
									Pengaturan
								</a>
								<a href="logout.php" class="dropdown-item btn-logout">
									Keluar
								</a>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="navbar-expand-md d-xl-block d-lg-block d-md-block d-sm-none d-xs-none">
				<div class="collapse navbar-collapse" id="navbar-menu">
					<div class="navbar navbar-light ">
						<div class="container-xl">

							<ul class="navbar-nav">
								<li class="nav-item">
									<a class="nav-link" href="./">
										<span class="nav-link-icon d-md-none d-lg-inline-block">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="5 12 3 12 12 3 21 12 19 12" />
												<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
												<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
											</svg>
										</span>
										<span class="nav-link-title">
											Dashboard
										</span>
									</a>
								</li>

								<?php if ($user_level == "operator") : ?>
									<li class="nav-item">
										<a class="nav-link" href="index.php?p=data-layanan">
											<span class="nav-link-icon d-md-none d-lg-inline-block">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
													<path stroke="none" d="M0 0h24v24H0z" fill="none" />
													<circle cx="17" cy="17" r="4" />
													<path d="M17 13v4h4" />
													<path d="M12 3v4a1 1 0 0 0 1 1h4" />
													<path d="M11.5 21h-6.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v2m0 3v4" />
												</svg>
											</span>
											<span class="nav-link-title">
												Data Layanan
											</span>
										</a>
									</li>
								<?php endif; ?>

								<li class="nav-item">
									<a class="nav-link" href="index.php?p=pengaturan">
										<span class="nav-link-icon d-md-none d-lg-inline-block">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="12" cy="7" r="4" />
												<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
											</svg>
										</span>
										<span class="nav-link-title">
											Pengaturan
										</span>
									</a>
								</li>

							</ul>

						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="page-wrapper pb-5 pb-lg-2">

			<div class="content-min-height" style="min-height: 72vh;">
				<?php include "content.php"; ?>
			</div>

		</div>

		<footer class="footer footer-transparent d-print-none">
			<div class="container">
				<div class="row text-center align-items-center flex-row-reverse">
					<div class="col-lg-auto ms-lg-auto">
						<ul class="list-inline list-inline-dots mb-0">
							<li class="list-inline-item">
								<a href="https://informatika.untan.ac.id" target="_blank" class="link-secondary" rel="noopener">
									Jurusan Informatika
								</a>
							</li>
							<li class="list-inline-item">
								<a href="https://teknik.untan.ac.id" target="_blank" class="link-secondary" rel="noopener">
									Fakultas Teknik
								</a>
							</li>
							<li class="list-inline-item">
								<a href="https://untan.ac.id" target="_blank" class="link-secondary" rel="noopener">
									Universitas Tanjungpura
								</a>
							</li>
						</ul>
					</div>
					<div class="col-12 col-lg-auto mt-3 mt-lg-0">
						<ul class="list-inline list-inline-dots mb-0">
							<li class="list-inline-item">
								Copyright &copy; <?= date("Y"); ?>
								<a href="." class="link-secondary"></a>
							</li>
							<li class="list-inline-item">
								<a href="./changelog.html" class="link-secondary" rel="noopener">V 1.0.0</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>

	</div>

	<!-- Libs JS -->
	<script src="dist/libs/apexcharts/dist/apexcharts.min.js"></script>
	<!-- Tabler Core -->
	<script src="dist/js/tabler.min.js"></script>

	<script>
		$(document).ready(function() {

			$('.btn-hapus').on('click', function(e) {
				event.preventDefault(); // prevent form submit

				Swal.fire({
					title: 'Apakah anda yakin ?',
					text: "Pilih ya, jika anda ingin menghapus data !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, hapus data !',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents('form');
						form.submit();
					}
				});
			});

			$('.btn-logout').on('click', function(e) {
				event.preventDefault(); // prevent form submit

				Swal.fire({
					title: 'Konfirmasi ?',
					text: "Apakah anda yakin ingin keluar dari aplikasi ?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
					cancelButtonText: 'Tidak'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = $('.btn-logout').attr('href');
					}
				});
			});
		});

		$(function() {
			$('.js-select-2').select2();

			$('#data-table').DataTable({
				"paging": true,
				"responsive": true,
				"searching": true
			});
		})

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#fotobaru')
						.attr('src', e.target.result);
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
</body>

</html>