<?php

if (isset($_POST['simpan'])) {
	if (submit_data_layanan() == 1) {
		$berhasil = true;
		$pesan_berhasil = "Data berhasil ditambah !";
		// echo '<meta http-equiv="refresh" content="0">';
	} else {
		$gagal = true;
		$pesan_gagal = "Data gagal ditambah !";
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

						<table class="table table-bordered table-hover" id="data-table-custom">
							<thead>
								<tr class="text-center">
									<th>No.</th>
									<th>Tanggal</th>
									<th>Waktu</th>
									<th>Nama</th>
									<th>NIK</th>
									<th>Keperluan</th>
									<th>No. Surat</th>
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
										<td style="vertical-align: middle;"><?= $row['nik']; ?></td>
										<td style="vertical-align: middle;"><?= $row['keperluan']; ?></td>
										<td style="vertical-align: middle;"><?= $row['no_surat']; ?></td>
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
				var keperluan = this.api().column(5);
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