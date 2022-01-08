<?php
if (isset($_POST['ubah_nama_username'])) {
	if (ubah_nama_username() == 1) {
		$berhasil = true;
		$pesan_berhasil = "Data berhasil diubah !";
		echo '<meta http-equiv="refresh" content="1; URL=index.php?p=pengaturan">';
	} else {
		$gagal = true;
		$pesan_gagal = "Data gagal diubah !";
	}
}

if (isset($_POST['ubah_foto'])) {
	if (ubah_foto() == 1) {
		$berhasil = true;
		$pesan_berhasil = "Data berhasil diubah !";
		echo '<meta http-equiv="refresh" content="1; URL=index.php?p=pengaturan">';
	} else {
		$gagal = true;
		$pesan_gagal = "Data gagal diubah !";
	}
}

if (isset($_POST['ubah_password'])) {
	if (ubah_password() == 1) {
		$berhasil = true;
		$pesan_berhasil = "Data berhasil diubah !";
		echo '<meta http-equiv="refresh" content="1; URL=index.php?p=pengaturan">';
	} else {
		$gagal = true;
		$pesan_gagal = "Data gagal diubah !";
	}
}
?>


<?php if (isset($berhasil)) : ?>
	<script>
		Swal.fire(
			"Berhasil !",
			"<?= $pesan_berhasil; ?>",
			"success"
		)
	</script>
<?php elseif (isset($gagal)) : ?>
	<script>
		Swal.fire(
			"Gagal !",
			"<?= $pesan_gagal; ?>",
			"error"
		)
	</script>
<?php endif; ?>

<div class="page-body">
	<div class="container-xl">
		<div class="row row-deck row-cards">

			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>
							<i class="fa fa-cogs"></i>
							PENGATURAN
						</h4>
					</div>
					<div class="card-body">

						<div class="row">
							<div class="col-md-8 mb-3">

								<div class="card h-100">
									<div class="card-header">
										<h5 class="card-title">
											<i class="fa fa-user-edit"></i> Ubah Data Akun
										</h5>
									</div>

									<div class="card-body">

										<form action="" method="POST" enctype="multipart/form-data">

											<input type="hidden" name="id_user" value="<?= $id_user; ?>">

											<div class="form-group row mt-3">
												<label for="nama_lengkap" class="col-sm-4 col-form-label">
													Nama Akun
												</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama akun ..." value="<?= $user_nama; ?>">
												</div>
											</div>

											<div class="form-group row mt-3">
												<label for="username" class="col-sm-4 col-form-label">
													Username
												</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username ..." value="<?= $username; ?>">
												</div>
											</div>

											<div class="form-group row mt-3">
												<label for="email" class="col-sm-4 col-form-label">
													Email
												</label>
												<div class="col-sm-8">
													<input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email ..." value="<?= $user_email; ?>">
												</div>
											</div>

											<div class="form-group row mt-3 mt-5">
												<div class="col-sm-8 offset-4">
													<button type="submit" name="ubah_nama_username" class="btn btn-success pl-4 pr-4">
														<i class="fa fa-save"></i> SIMPAN
													</button>
												</div>
											</div>

										</form>

									</div>

								</div>
							</div>

							<div class="col-md-4 mb-3">

								<div class="card h-100">
									<div class="card-header">
										<h5 class="card-title">
											<i class="fa fa-image"></i> Ubah Foto
										</h5>
									</div>

									<div class="card-body">

										<form action="" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="id_user" value="<?= $id_user; ?>">

											<div class="form-group row mt-3 justify-content-center">
												<div class="col-12 text-center">
													<img id="fotobaru" src="<?= (empty($user_foto)) ? 'assets/images/noimg.png' : 'assets/images/profil/' . $user_foto; ?>" style="height: 180px; width: 180px; border-radius: 50%; object-fit: cover;">
												</div>
												<div class="col-sm-12 mt-4 d-flex align-items-center">
													<div class="custom-file">
														<label class="custom-file-label" for="foto">Pilih Foto</label>
														<input type="file" class="custom-file-input" id="foto" name="foto" onchange="readURL(this)" required>
													</div>
												</div>
											</div>

											<div class="form-group row mt-3 mt-5">
												<div class="col-sm-12">
													<button type="submit" name="ubah_foto" class="btn btn-success pl-4 pr-4">
														<i class="fa fa-save"></i> SIMPAN
													</button>
												</div>
											</div>

										</form>

									</div>

								</div>
							</div>

							<div class="col-md-12 mt-3">

								<div class="card">
									<div class="card-header">
										<h5 class="card-title">
											<i class="fa fa-key"></i> Ubah Password
										</h5>
									</div>

									<div class="card-body">

										<form action="" method="POST" enctype="multipart/form-data">

											<input type="hidden" name="id_user" value="<?= $id_user; ?>">

											<div class="form-group row mt-3">
												<label for="password_lama" class="col-sm-4 col-form-label">
													Password Lama
												</label>
												<div class="col-sm-8">
													<input type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Masukkan password lama ...">
												</div>
											</div>

											<div class="form-group row mt-3">
												<label for="password_baru" class="col-sm-4 col-form-label">
													Password Baru
												</label>
												<div class="col-sm-8">
													<input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Masukkan password baru ...">
												</div>
											</div>

											<div class=" form-group row mt-3">
												<label for="konfirmasi_password" class="col-sm-4 col-form-label">
													Konfirmasi Password Baru
												</label>
												<div class="col-sm-8">
													<input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukkan konfirmasi password ...">
												</div>
											</div>

											<div class=" form-group row mt-3 mt-5">
												<div class="col-sm-8 offset-4">
													<button type="submit" name="ubah_password" class="btn btn-success pl-4 pr-4">
														<i class="fa fa-save"></i> SIMPAN
													</button>
												</div>
											</div>

										</form>

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