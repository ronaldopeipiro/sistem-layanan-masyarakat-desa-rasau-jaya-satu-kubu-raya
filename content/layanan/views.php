<?php

if (isset($_POST['hapus_data'])) {
	if (hapus_data_layanan() == 1) {
		$berhasil = true;
		$pesan_berhasil = "Data berhasil dihapus !";
		echo '<meta http-equiv="refresh" content="1; url=index.php?p=data-layanan">';
	} else {
		$gagal = true;
		$pesan_gagal = "Data gagal dihapus !";
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
					<div class="card-header">
						<h4>
							<i class="fa fa-table"></i>
							DATA LAYANAN
						</h4>
					</div>
					<div class="card-body">

						<div class="row mb-4">
							<div class="col-lg-4">
								<label for="keperluanSelect">Keperluan</label>
								<div id="keperluanSelect"></div>
							</div>
						</div>

						<table class="table table-sm table-bordered table-hover table-responsive" id="data-table-custom" style="font-size: 12px;">
							<thead>
								<tr class="text-center">
									<th>No.</th>
									<th>Tanggal</th>
									<th>Waktu</th>
									<th>Nama</th>
									<th>NIK</th>
									<th>No. KK</th>
									<th>Keperluan</th>
									<th>No. Surat</th>
									<?php if ($user_level == "operator") : ?>
										<th>Aksi</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;

								if ($user_level == "atasan") {
									$query_layanan = "SELECT * FROM tb_layanan ORDER BY id_layanan DESC";
								} elseif ($user_level == "operator") {
									$query_layanan = "SELECT * FROM tb_layanan WHERE id_user='$id_user' ORDER BY id_layanan DESC";
								}

								$data_layanan = $db_connect->prepare($query_layanan);
								$data_layanan->execute();
								?>
								<?php while ($row = $data_layanan->fetch(PDO::FETCH_ASSOC)) : ?>
									<tr>
										<td style="vertical-align: middle;" class="text-center"><?= $no++; ?>.</td>
										<td style="vertical-align: middle;" class="text-center">
											<?= strftime('%d/%m/%Y', strtotime($row['waktu_data'])); ?>
										</td>
										<td style="vertical-align: middle;" class="text-center">
											<?= strftime('%H:%M:%S WIB', strtotime($row['waktu_data'])); ?>
										</td>
										<td style="vertical-align: middle;"><?= $row['nama']; ?></td>
										<td class="text-center" style="vertical-align: middle;"><?= $row['nik']; ?></td>
										<td class="text-center" style="vertical-align: middle;"><?= $row['no_kk']; ?></td>
										<td style="vertical-align: middle;"><?= $row['keperluan']; ?></td>
										<td style="vertical-align: middle;"><?= $row['no_surat']; ?></td>
										<?php if ($user_level == "operator") : ?>
											<td style="vertical-align: middle;">
												<div class="list-unstyled d-flex justify-content-center">
													<li>
														<a href="index.php?p=edit-data-layanan&id=<?= $row['id_layanan']; ?>" class="btn btn-warning" title="Ubah Data">
															<i class="fa fa-edit"></i>
														</a>
													</li>
													<li style="margin-left: 5px;">
														<form action="" enctype="multipart/form-data" method="post">
															<input type="hidden" name="id_layanan" value="<?= $row['id_layanan']; ?>">
															<button type="submit" name="hapus_data" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')" class="btn btn-danger" title="Ubah Data">
																<i class="fa fa-trash"></i>
															</button>
														</form>
													</li>
												</div>
											</td>
										<?php endif; ?>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var datetime = new Date();
		var tanggalHariIni = datetime.getDate() + '-' + datetime.getMonth() + '-' + datetime.getFullYear();

		var tabel_user = $('#data-table-custom').DataTable({
			"paging": true,
			"responsive": true,
			"searching": true,
			"deferRender": true,
			// "dom": 'lBfrtipS',
			"initComplete": function() {
				var keperluan = this.api().column(6);
				var keperluanSelect = $('<select class="filter form-control js-select-2"><option value="">Semua</option></select>')
					.appendTo('#keperluanSelect')
					.on('change', function() {
						var val = $(this).val();
						keperluan.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				keperluan.data().unique().sort().each(function(d, j) {
					keperluanSelect.append('<option value="' + d + '">' + d + '</option>');
				});
			},
			"lengthMenu": [
				[10, 25, 50, 100, 500, -1],
				['10', '25', '50', '100', '500', 'Semua']
			],
		});

	});
</script>