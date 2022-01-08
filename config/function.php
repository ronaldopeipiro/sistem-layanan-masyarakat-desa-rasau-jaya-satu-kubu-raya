<?php
// error_reporting(0);
include 'database.php';

$connect_my_db = new createCon();
$db_connect = $connect_my_db->connect();

setlocale(LC_ALL, 'IND');
setlocale(LC_TIME, 'id_ID');
date_default_timezone_set('Asia/Jakarta');

function rupiah($angka)
{
	$hasil_rupiah = "Rp." . number_format($angka, 0, ',', '.');
	return $hasil_rupiah;
}

function rupiah_no_str($angka)
{
	$hasil_rupiah = number_format($angka, 0, ',', '.');
	return $hasil_rupiah;
}

function submit_data_layanan()
{
	global $db_connect;

	$waktu_data = date("Y-m-d H:i:s");

	$id_user = $_POST['id_user'];
	$nama = $_POST['nama'];
	$nik = $_POST['nik'];
	$keperluan = $_POST['keperluan'];
	$no_surat = $_POST['no_surat'];

	$status = "0";

	$sql_query = "INSERT INTO tb_layanan (waktu_data, id_user, nama, nik, keperluan, no_surat, status) VALUES (:waktu_data, :id_user, :nama, :nik, :keperluan, :no_surat, :status)";
	$query_data = $db_connect->prepare($sql_query);
	$query_data->bindParam(':waktu_data', $waktu_data);
	$query_data->bindParam(':id_user', $id_user);
	$query_data->bindParam(':nama', $nama);
	$query_data->bindParam(':nik', $nik);
	$query_data->bindParam(':keperluan', $keperluan);
	$query_data->bindParam(':no_surat', $no_surat);
	$query_data->bindParam(':status', $status);
	$query_data->execute();

	$error = $query_data->errorInfo();
	if ($error[0] == '00000') {
		return 1;
	} else {
		return 0;
	}
}


// Kelola User
function tambah_data_user()
{
	global $db_connect;

	$level = "1";
	$nama_lengkap = $_POST["nama_lengkap"];
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password_baru = $_POST["password_baru"];
	$konfirmasi_password = $_POST["konfirmasi_password"];

	if ($_FILES['foto']['error'] === 4) {
		$foto = "";
	} else {
		$foto = upload_foto_user();
	}

	$status = "Y";
	$tanggal_waktu = date("Y-m-d H:i:s");

	// cek username sudah ada atau belum
	$sql_query = "SELECT * FROM tb_user WHERE username = :username";
	$data_user = $db_connect->prepare($sql_query);
	$data_user->bindParam(':username', $username);
	$data_user->execute();

	if ($row = $data_user->fetch(PDO::FETCH_ASSOC)) {
		echo "
		<script>
			Swal.fire(
				'Gagal !',
				'Username telah digunakan, silahkan gunakan username lain !',
				'error'
				)
			</script>
		";
		echo '<meta http-equiv="refresh" content="1; URL=index.php?p=data-master-akun-user&tambah">';
		exit;
	}

	if ($password_baru != $konfirmasi_password) {
		echo "
					<script>
						Swal.fire(
							'Gagal !',
							'Password tidak sesuai dengan konfirmasi !',
							'error'
							)
						</script>
					";
		echo '<meta http-equiv="refresh" content="1; URL=index.php?p=data-master-akun-user&tambah">';
		exit;
	}

	$password = password_hash($password_baru, PASSWORD_DEFAULT);

	$sql_query = "INSERT INTO tb_user (level, username, password, nama_lengkap, foto, email, status, last_login) VALUES (:level, :username, :password, :nama_lengkap, :foto, :email, :status, :last_login)";
	$query_data = $db_connect->prepare($sql_query);
	$query_data->bindParam(':level', $level);
	$query_data->bindParam(':username', $username);
	$query_data->bindParam(':password', $password);
	$query_data->bindParam(':nama_lengkap', $nama_lengkap);
	$query_data->bindParam(':foto', $foto);
	$query_data->bindParam(':email', $email);
	$query_data->bindParam(':status', $status);
	$query_data->bindParam(':last_login', $tanggal_waktu);
	$query_data->execute();

	$error = $query_data->errorInfo();
	if ($error[0] == '00000') {
		return 1;
	} else {
		return 0;
	}
}

function ubah_data_user()
{
	global $db_connect;

	$id_user = $_POST["id_user"];
	$nama_lengkap = $_POST["nama_lengkap"];
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password_baru = $_POST['password_baru'];
	$konfirmasi_password = $_POST['konfirmasi_password'];
	$foto_lama = $_POST["foto_lama"];

	if ($_FILES['foto']['error'] === 4) {
		$foto = $foto_lama;
	} else {
		$foto = upload_foto_user();

		if ($foto_lama != "") {
			unlink("assets/images/profil/" . $foto_lama);
		}
	}

	// cek username sudah ada atau belum
	$sql_query = "SELECT * FROM tb_user WHERE username=:username AND id_user!=:id_user ";
	$data_user = $db_connect->prepare($sql_query);
	$data_user->bindParam(':username', $username);
	$data_user->bindParam(':id_user', $id_user);
	$data_user->execute();

	if ($row = $data_user->fetch(PDO::FETCH_ASSOC)) {
		echo "
		<script>
			Swal.fire(
				'Gagal !',
				'Username telah digunakan, silahkan gunakan username lain !',
				'error'
				)
			</script>
		";
		echo '<meta http-equiv="refresh" content="1; URL=index.php?p=ubah-data-master-akun-user&id=' . $id_user . '">';
		exit;
	}

	$sql_query = "UPDATE tb_user SET username=:username, nama_lengkap=:nama_lengkap, foto=:foto, email=:email WHERE id_user=:id_user";
	$query_data = $db_connect->prepare($sql_query);
	$query_data->bindParam(':nama_lengkap', $nama_lengkap);
	$query_data->bindParam(':username', $username);
	$query_data->bindParam(':email', $email);
	$query_data->bindParam(':foto', $foto);
	$query_data->bindParam(':id_user', $id_user);
	$query_data->execute();

	$error = $query_data->errorInfo();

	if (($password_baru != "") and ($konfirmasi_password != "")) {
		if ($password_baru != $konfirmasi_password) {
			echo "
					<script>
						Swal.fire(
							'Gagal !',
							'Password tidak sesuai dengan konfirmasi !',
							'error'
							)
						</script>
					";
			echo '<meta http-equiv="refresh" content="1; URL=index.php?p=ubah-data-master-akun-user&id=' . $id_user . '">';
			exit;
		}

		$password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);

		$sql_query_ubah_password = "UPDATE tb_user SET password = :password WHERE id_user = :id_user ";
		$query_ubah_password = $db_connect->prepare($sql_query_ubah_password);
		$query_ubah_password->bindParam(':id_user', $id_user);
		$query_ubah_password->bindParam(':password', $password_baru_hash);
		$query_ubah_password->execute();
		$error = $query_ubah_password->errorInfo();
	}

	if ($error[0] == '00000') {
		return 1;
	} else {
		return 0;
	}
}


function hapus_akun_user()
{
	global $db_connect;

	$id_user = $_POST['id_user'];
	$status = "N";

	$sql_query = "UPDATE tb_user SET status = :status WHERE id_user=:id_user ";
	$query_data = $db_connect->prepare($sql_query);
	$query_data->bindParam(':status', $status);
	$query_data->bindParam(':id_user', $id_user);
	$query_data->execute();

	$error = $query_data->errorInfo();
	if ($error[0] == '00000') {
		return 1;
	} else {
		return 0;
	}
}


// Akhir kelola user

// Pengaturan Akun user
function ubah_nama_username()
{
	global $db_connect;

	$id_user = $_POST['id_user'];
	$nama_lengkap = $_POST["nama_lengkap"];
	$username = $_POST["username"];
	$email = $_POST["email"];

	// cek username sudah ada atau belum
	$sql_query = "SELECT * FROM tb_user WHERE username=:username AND id_user!=:id_user ";
	$data_user = $db_connect->prepare($sql_query);
	$data_user->bindParam(':username', $username);
	$data_user->bindParam(':id_user', $id_user);
	$data_user->execute();

	if ($row = $data_user->fetch(PDO::FETCH_ASSOC)) {
		echo "
		<script>
			Swal.fire(
				'Gagal !',
				'Username telah digunakan, silahkan gunakan username lain !',
				'error'
				)
			</script>
		";
		echo '<meta http-equiv="refresh" content="1; URL=index.php?p=pengaturan">';
		exit;
	}

	$sql_query = "UPDATE tb_user SET nama_lengkap=:nama_lengkap, username=:username, email=:email WHERE id_user=:id_user ";
	$query_data = $db_connect->prepare($sql_query);
	$query_data->bindParam(':id_user', $id_user);
	$query_data->bindParam(':nama_lengkap', $nama_lengkap);
	$query_data->bindParam(':username', $username);
	$query_data->bindParam(':email', $email);
	$query_data->execute();

	$error = $query_data->errorInfo();
	if ($error[0] == '00000') {
		return 1;
	} else {
		return 0;
	}
}

function ubah_password()
{
	global $db_connect;

	$id_user = $_POST['id_user'];

	$password_lama = $_POST['password_lama'];
	$password_baru = $_POST['password_baru'];
	$konfirmasi_password = $_POST['konfirmasi_password'];

	$query_data_user_login = "SELECT * FROM tb_user WHERE id_user=:id_user";
	$data_data_user_login = $db_connect->prepare($query_data_user_login);
	$data_data_user_login->bindParam(':id_user', $id_user);
	$data_data_user_login->execute();

	if ($data_user = $data_data_user_login->fetch(PDO::FETCH_ASSOC)) {
		if (password_verify($password_lama, $data_user["password"])) {
			if ($password_baru != $konfirmasi_password) {
				echo "
					<script>
						Swal.fire(
							'Gagal !',
							'Password tidak sesuai dengan konfirmasi !',
							'error'
							)
						</script>
					";
				echo '<meta http-equiv="refresh" content="1; URL=index.php?p=pengaturan">';
				exit;
			}

			$password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);

			$sql_query = "UPDATE tb_user SET password=:password WHERE id_user=:id_user ";
			$query_data = $db_connect->prepare($sql_query);
			$query_data->bindParam(':id_user', $id_user);
			$query_data->bindParam(':password', $password_baru_hash);
			$query_data->execute();

			$error = $query_data->errorInfo();
			if ($error[0] == '00000') {
				return 1;
			} else {
				return 0;
			}
		} else {
			echo "
			<script>
				Swal.fire(
					'Gagal !',
					'Password lama yang anda masukkan salah !',
					'error'
					)
				</script>
			";
			echo '<meta http-equiv="refresh" content="1; URL=index.php?p=pengaturan">';
			exit;
		}
	}
}

function ubah_foto()
{
	global $db_connect;

	$id_user = $_POST['id_user'];

	$foto = upload_foto_user();

	if (!$foto) {
		return false;
	}

	$sql_query = "SELECT * FROM tb_user WHERE id_user=:id_user ";
	$data_user = $db_connect->prepare($sql_query);
	$data_user->bindParam(':id_user', $id_user);
	$data_user->execute();

	if ($row = $data_user->fetch(PDO::FETCH_ASSOC)) {
		$hapusfoto = $row["foto"];
		unlink("assets/images/profil/" . $hapusfoto);
	}

	$sql_query = "UPDATE tb_user SET foto=:foto WHERE id_user=:id_user ";
	$query_data = $db_connect->prepare($sql_query);
	$query_data->bindParam(':id_user', $id_user);
	$query_data->bindParam(':foto', $foto);
	$query_data->execute();

	$error = $query_data->errorInfo();
	if ($error[0] == '00000') {
		return 1;
	} else {
		return 0;
	}
}

function upload_foto_user()
{
	$namafile = $_FILES['foto']['name'];
	$tmpname = $_FILES['foto']['tmp_name'];

	// cek apakah yang akan diupload adalah gambar
	$ekstensifotovalid = ['jpg', 'jpeg', 'png'];
	$ekstensifoto = explode('.', $namafile);
	$ekstensifoto = strtolower(end($ekstensifoto));

	// generate nama file agar unik
	$namafilebaru = uniqid();
	$namafilebaru .= '.';
	$namafilebaru .= $ekstensifoto;

	move_uploaded_file($tmpname, 'assets/images/profil/' . $namafilebaru);
	return $namafilebaru;
}
// Akhir Pengaturan Akun user
