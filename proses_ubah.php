<?php
// Include / load file koneksi.php
include "koneksi.php";

// Ambil data yang dikirim dari form
$nim = $_POST['nim']; // Ambil data nis dan masukkan ke variabel nis
$nama = $_POST['nama']; // Ambil data nama dan masukkan ke variabel nama
$prodi = $_POST['prodi'];
$username = $_POST['username']; // Ambil data jenis_kelamin dan masukkan ke variabel jenis_kelamin
$semester = $_POST['semester']; // Ambil data telp dan masukkan ke variabel telp
$alamat = $_POST['alamat']; // Ambil data alamat dan masukkan ke variabel alamat

// Cek apakah user ingin mengubah fotonya atau tidak
if(isset($_POST['ubah_foto'])){ // Jika user menceklis checkbox yang ada di form ubah, lakukan :
	// Ambil data foto yang dipilih dari form
	$foto = $_FILES['foto']['name'];
	$tmp = $_FILES['foto']['tmp_name'];
	
	// Rename nama fotonya dengan menambahkan tanggal dan jam upload
	$fotobaru = date('dmYHis').$foto;
	
	// Set path folder tempat menyimpan fotonya
	$path = "foto/".$fotobaru;

	// Proses upload
	// Cek apakah gambar berhasil diupload atau tidak
	if(move_uploaded_file($tmp, $path)){ // Jika proses upload sukses
		// Query untuk menampilkan data siswa berdasarkan NIS yang dikirim
		$sqlcek = $pdo->prepare("SELECT * FROM siswa WHERE nim=:nim");
		$sqlcek->bindParam(':nim', $nim);
		$sqlcek->execute(); // Eksekusi / Jalankan query
		$data = $sqlcek->fetch(); // Ambil data dari hasil eksekusi $sqlcek
		
		// Cek apakah file foto sebelumnya ada di folder foto
		if(is_file("foto/".$data['foto'])) // Jika foto ada
			unlink("foto/".$data['foto']); // Hapus file foto sebelumnya yang ada di folder foto
		
		// Proses ubah ke Database
		$sql = $pdo->prepare("UPDATE siswa SET nama=:nama, prodi=:prodi, username=:username, semester=:semester, alamat=:alamat, foto=:foto WHERE nim=:nim");
		$sql->bindParam(':nama', $nama);
		$sql->bindParam(':prodi', $prodi);
		$sql->bindParam(':username', $username);
		$sql->bindParam(':semester', $semester);
		$sql->bindParam(':alamat', $alamat);
		$sql->bindParam(':foto', $fotobaru);
		$sql->bindParam(':nim', $nim);
		$sql->execute(); // Eksekusi query insert
		
		// Load ulang view.php agar data diubah tadi bisa terubah di tabel pada view.php
		ob_start();
		include "view.php";
		$html = ob_get_contents();
		ob_end_clean();
		
		// Buat variabel reponse yang nantinya akan diambil pada proses ajax ketika sukses
		$response = array(
			'status'=>'sukses', // Set status
			'pesan'=>'Data berhasil diubah', // Set pesan
			'html'=>$html // Set html
		);
	}else{ // Jika proses upload gagal
		$response = array(
			'status'=>'gagal', // Set status
			'pesan'=>'Gambar gagal untuk diupload', // Set pesan
		);
	}
}else{ // Jika user tidak menceklis checkbox yang ada di form, lakukan :
	// Proses ubah ke Database
	$sql = $pdo->prepare("UPDATE siswa SET nama=:nama, prodi=:prodi, username=:username, semester=:semester, alamat=:alamat WHERE nim=:nim");
	$sql->bindParam(':nama', $nama);
	$sql->bindParam(':prodi', $prodi);
	$sql->bindParam(':username', $username);
	$sql->bindParam(':semester', $semester);
	$sql->bindParam(':alamat', $alamat);
	$sql->bindParam(':nim', $nim);
	$sql->execute(); // Eksekusi query insert
	
	// Load ulang view.php agar data diubah tadi bisa terubah di tabel pada view.php
	ob_start();
	include "view.php";
	$html = ob_get_contents();
	ob_end_clean();
	
	// Buat variabel reponse yang nantinya akan diambil pada proses ajax ketika sukses
	$response = array(
		'status'=>'sukses', // Set status
		'pesan'=>'Data berhasil diubah', // Set pesan
		'html'=>$html // Set html
	);
}

echo json_encode($response); // konversi variabel response menjadi JSON
?>
