<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th class="text-center">ID</th>
			<th class="text-center">FOTO</th>
			<th>NIM</th>
			<th>NAMA</th>
			<th>USERNAME</th>
			<th>PRODI</th>
			<th>SEMESTER</th>
			<th>ALAMAT</th>
			<th colspan="2" class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
		</tr>
		<?php
		// Include / load file koneksi.php
		include "koneksi.php";
		
		// Buat query untuk menampilkan semua data siswa
		$sql = $pdo->prepare("SELECT * FROM siswa");
		$sql->execute(); // Eksekusi querynya
		
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
		?>
			<tr>
				<td class="align-middle text-center"><?php echo $no; ?></td>
				<td class="align-middle text-center">
					<img src="foto/<?php echo $data['foto']; ?>" width="80" height="80">
				</td>
				<td class="align-middle"><?php echo $data['nim']; ?></td>
				<td class="align-middle"><?php echo $data['nama']; ?></td>
				<td class="align-middle"><?php echo $data['prodi']; ?></td>
				<td class="align-middle"><?php echo $data['username']; ?></td>
				<td class="align-middle"><?php echo $data['semester']; ?></td>
				<td class="align-middle"><?php echo $data['alamat']; ?></td>
				<td class="align-middle text-center">
					<a href="javascript:void();" data-toggle="modal" data-target="#form-modal" onclick="edit(<?php echo $no; ?>);" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
				<td class="align-middle text-center">
					<a href="javascript:void();" data-toggle="modal" data-target="#delete-modal" onclick="hapus(<?php echo $no; ?>);" class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span></a>
				</td>
			</tr>
			<!--
			-- Membuat sebuah textbox hidden yang akan digunakan untuk form ubah
			-->
			<input type="hidden" id="nim-value-<?php echo $no; ?>" value="<?php echo $data['nim']; ?>">
			<input type="hidden" id="nama-value-<?php echo $no; ?>" value="<?php echo $data['nama']; ?>">
			<input type="hidden" id="prodi-value-<?php echo $no; ?>" value="<?php echo $data['prodi']; ?>">
			<input type="hidden" id="username-value-<?php echo $no; ?>" value="<?php echo $data['username']; ?>">
			<input type="hidden" id="semester-value-<?php echo $no; ?>" value="<?php echo $data['semester']; ?>">
			<input type="hidden" id="alamat-value-<?php echo $no; ?>" value="<?php echo $data['alamat']; ?>">
		<?php
			$no++; // Tambah 1 setiap kali looping
		}
		?>
	</table>
</div>

<script>
// Fungsi ini akan dipanggil ketika tombol edit diklik
function edit(no){
	$("#btn-simpan").hide(); // Sembunyikan tombol simpan
	$("#btn-ubah, #checkbox_foto").show(); // Munculkan tombol ubah dan checkbox foto
	
	// Set judul modal dialog menjadi Form Ubah Data
	$("#modal-title").html("Form Ubah data");
	
	var nim = $("#nim-value-" + no).val(); // Ambil nis dari input type hidden
	var nama = $("#nama-value-" + no).val(); // Ambil nama dari input type hidden
	var prodi = $("#prodi-value-" + no).val();
	var username = $("#username-value-" + no).val(); // Ambil jenis kelamin dari input type hidden
	var semester = $("#semester-value-" + no).val(); // Ambil telp dari input type hidden
	var alamat = $("#alamat-value-" + no).val(); // Ambil alamat dari input type hidden
	
	// Set value dari textbox nis yang ada di form
	// Set textbox nis menjadi Readonly
	$("#nim").val(nis).attr("readonly","readonly");
	
	$("#nama").val(nama); // Set value dari textbox nama yang ada di form
	$("#prodi").val(prodi);
	$("#username").val(username); // Set value dari textbox nama yang ada di form
	$("#semester").val(semester); // Set value dari textbox nama yang ada di form
	$("#alamat").val(alamat); // Set value dari textbox nama yang ada di form
	$("#foto").val("");
}

// Fungsi ini akan dipanggil ketika tombol hapus diklik
function hapus(no){
	var nim = $("#nim-value-" + no).val(); // Ambil nis dari input type hidden
	
	// Set textbox hidden nis yang ada di modal dialog hapus
	$("#data-nim").val(nim);
}
</script>
