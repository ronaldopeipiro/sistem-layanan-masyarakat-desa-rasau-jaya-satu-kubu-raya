<?php

$id_layanan = $_GET['id'];

$query_layanan = "SELECT * FROM tb_layanan WHERE id_layanan=:id_layanan";
$data_layanan = $db_connect->prepare($query_layanan);
$data_layanan->bindParam('id_layanan', $id_layanan);
$data_layanan->execute();
$layanan = $data_layanan->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['simpan'])) {
	if (ubah_data_layanan() == 1) {
		$berhasil = true;
		$pesan_berhasil = "Data berhasil diubah !";
		echo '<meta http-equiv="refresh" content="0; url=index.php?p=data-layanan">';
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

<style>
	input,
	textarea {
		font-size: 20px !important;
	}
</style>

<div class="page-body">
	<div class="container-xl">
		<div class="row row-deck row-cards">

			<div class="col-lg-12">
				<div class="card">
					<form action="" method="post" enctype="multipart/form-data">
						<div class="card-header">
							<h4>
								<i class="fa fa-edit"></i>
								FORMULIR LAYANAN MASYARAKAT
							</h4>
						</div>
						<div class="card-body">

							<input type="hidden" name="id_user" value="<?= $id_user; ?>">
							<input type="hidden" name="id_layanan" value="<?= $id_layanan; ?>">

							<div class="form-group mb-4">
								<label class="mb-2" for="nama">
									Nama Lengkap
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<input type="text" autofocus name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap anda ..." required value="<?= $layanan['nama']; ?>">
							</div>

							<div class="form-group mb-4">
								<label class="mb-2" for="nik">
									NIK
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan 16 Digit NIK ..." required minlength="16" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?= $layanan['nik']; ?>">
							</div>

							<div class="form-group mb-4">
								<label class="mb-2" for="no_kk">
									No. Kartu Keluarga
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<input type="text" name="no_kk" id="no_kk" class="form-control" placeholder="Masukkan 16 Digit No. KK ..." required minlength="16" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?= $layanan['no_kk']; ?>">
							</div>

							<div class="form-group mb-4">
								<label class="mb-2" for="keperluan">
									Keperluan
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<textarea name="keperluan" id="keperluan" rows="3" class="form-control" required placeholder="Masukkan keperluan anda ..."><?= $layanan['keperluan']; ?></textarea>
							</div>

							<div class="form-group mb-4">
								<label class="mb-2" for="no_surat">
									Nomor Surat
								</label>
								<input type="text" name="no_surat" id="no_surat" class="form-control" placeholder="Masukkan nomor surat ..." value="<?= $layanan['no_surat']; ?>">
							</div>

							<div class="form-group mt-4">
								<button type="submit" name="simpan" class="btn btn-lg btn-block btn-success" style="width: 100%;">
									<i class="fa fa-save" style="margin-right: 10px;"></i> SUBMIT
								</button>
							</div>

						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>