<?php
session_start();
require "./config/function.php";

// cek session
if (isset($_SESSION["logged_in"])) {
	echo "<script>document.location.href = 'index.php';</script>";
	exit;
}

if (isset($_POST["login"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];

	$query_data_user_login = "SELECT * FROM tb_user WHERE username='$username'";
	$data_data_user_login = $db_connect->prepare($query_data_user_login);
	$data_data_user_login->execute();
	$data_user = $data_data_user_login->fetch(PDO::FETCH_ASSOC);

	if ($data_user) {
		if ($data_user['status'] == "1") {

			if (password_verify($password, $data_user["password"])) {

				// set session
				$_SESSION['id_user'] = $data_user["id_user"];
				$_SESSION['logged_in'] = true;

				header("Location: index.php");
				exit;
			} else {
				$error = true;
				$pesan_gagal = "Password salah !";
			}
		} elseif ($data_user['status'] == "0") {
			$error = true;
			$pesan_gagal = "Akun anda tidak aktif !";
		}
	} else {
		$error = true;
		$pesan_gagal = "Username tidak ditemukan !";
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
	<title>LOGIN - SISTEM LAYANAN MASYARAKAT - DESA RASAU JAYA SATU</title>
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

</head>

<body class="antialiased border-top-wide border-primary d-flex flex-column" style="background: url('assets/images/background-login.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">

	<?php if (isset($error)) : ?>
		<script>
			Swal.fire(
				"Gagal !",
				"<?= $pesan_gagal; ?>",
				"error"
			)
		</script>
	<?php endif; ?>

	<div class="page page-center">
		<div class="container-tight">
			<div class="text-center mb-4">
				<a href="."><img src="./static/logo.svg" height="36" alt=""></a>
			</div>
			<form class="card card-md" action="" method="post" autocomplete="off">
				<div class="card-body">
					<h2 class="text-center">
						LOGIN APLIKASI
					</h2>
					<h4 class="text-center">
						SISTEM LAYANAN MASYARAKAT <br>
						DESA RASAU JAYA SATU
					</h4>
					<hr>

					<div class="mb-3">
						<label for="username" class="form-label">
							Username
						</label>
						<input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username ...">
					</div>

					<div class="mb-2">
						<label for="password" class="form-label">
							Password
						</label>
						<div class="input-group input-group-flat">
							<input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password ..." autocomplete="off">
							<span class="input-group-text">
								<a href="#" onclick="showPassword()" class="link-secondary" title="Tampilkan password" data-bs-toggle="tooltip">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none" />
										<circle cx="12" cy="12" r="2" />
										<path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
									</svg>
								</a>
							</span>
						</div>
					</div>
					<!-- <div class="mb-2">
						<label class="form-check">
							<input type="checkbox" class="form-check-input" />
							<span class="form-check-label">Remember me on this device</span>
						</label>
					</div> -->
					<div class="form-footer">
						<button type="submit" name="login" class="btn btn-primary w-100">
							<i class="fa fa-sign-in"></i> Masuk
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Libs JS -->
	<script src="dist/libs/apexcharts/dist/apexcharts.min.js"></script>
	<!-- Tabler Core -->
	<script src="dist/js/tabler.min.js"></script>

	<script>
		function showPassword() {
			var x = document.getElementById("password");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>
</body>

</html>