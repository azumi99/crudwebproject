<?php
session_start();

// database conection
$conn = mysqli_connect("localhost", "root", "", "db_transaksi");

// insert stock
if (isset($_POST['inserhp'])) {
	$merk_hp = $_POST['merk_hp'];
	$tipe_hp = $_POST['tipe_hp'];
	$harga_hp = $_POST['harga_hp'];
	$stock_hp = $_POST['stock_hp'];
	$spek_hp = $_POST['spek'];

	$tambahkb = mysqli_query($conn, "insert into handphone (merk, tipe, harga_hp, stock_hp, spesifikasi) values ('$merk_hp', '$tipe_hp', '$harga_hp', '$stock_hp', '$spek_hp')");
	if ($tambahkb) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
}

//update stock
if (isset($_POST['updatehp'])) {
	$merk_hp = $_POST['merk'];
	$tipe_hp = $_POST['tipe'];
	$harga_hp = $_POST['harga'];
	$stock_hp = $_POST['stock'];
	$spek_hp = $_POST['spek'];
	$id_hp = $_POST['idhp'];
	// print_r($iduser);
	// exit();
	$updatehp = mysqli_query($conn, "update handphone set merk='$merk_hp', tipe='$tipe_hp', harga_hp='$harga_hp' , stock_hp='$stock_hp', spesifikasi='$spek_hp' where handphone.id_hp='$id_hp' ");
	if ($updatehp) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
}

//delete stock
if (isset($_POST['deletehp'])) {
	$id_hanphone = $_POST['idhp'];

	$deletehp = mysqli_query($conn, "delete from handphone where id_hp='$id_hanphone'");
	if ($deletehp) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
}

//insert pegawai
if (isset($_POST['savepgw'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];

	$tambahpgw = mysqli_query($conn, "insert into pegawai (nama_pgw, alamat_pgw, telp_pgw) values ('$nama', '$alamat', '$no_hp')");
	if ($tambahpgw) {
		header('location:pegawai.php');
	} else {
		echo "gagal";
		header('location:pegawai.php');
	}
}

//update pegawai
if (isset($_POST['updatepgw'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];
	$id_pgw = $_POST['idpgw'];

	$updatepgw = mysqli_query($conn, "update pegawai set nama_pgw='$nama', alamat_pgw='$alamat, telp_pgw='$no_hp' where id_pegawai='$id_pgw'");
	if ($updatepgw) {
		header('location:pegawai.php');
	} else {
		echo "gagal";
		header('location:pegawai.php');
	}
}

//delete pegawai
if (isset($_POST['deletepgw'])) {
	$id_pgw = $_POST['idpgw'];

	$deletepgw = mysqli_query($conn, "delete from pegawai where id_pegawai='$id_pgw'");
	if ($deletepgw) {
		header('location:pegawai.php');
	} else {
		echo "gagal";
		header('location:pegawai.php');
	}
}


//insert pembeli
if (isset($_POST['savepembeli'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];

	$tambahpembeli = mysqli_query($conn, "insert into pembeli (nama, alamat, no_hp) values ('$nama', '$alamat', '$no_hp')");
	if ($tambahpembeli) {
		header('location:pembeli.php');
	} else {
		echo "gagal";
		header('location:pembeli.php');
	}
}

//update pembeli
if (isset($_POST['updatepembeli'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];
	$idpembeli = $_POST['id_pembeli'];

	$updatepembeli = mysqli_query($conn, "update pembeli set nama='$nama', alamat='$alamat', no_hp='$no_hp' where id_pembeli='$idpembeli'");
	if ($updatepembeli) {
		header('location:pembeli.php');
	} else {
		echo "gagal";
		header('location:pembeli.php');
	}
}

//delete pembeli
if (isset($_POST['deletepembeli'])) {
	$idpembeli = $_POST['id_pembeli'];

	$deletepembeli = mysqli_query($conn, "delete from pembeli where id_pembeli='$idpembeli'");
	if ($deletepembeli) {
		header('location:pembeli.php');
	} else {
		echo "gagal";
		header('location:pembeli.php');
	}
}

// insert transaksi
if (isset($_POST['savetransaksi'])) {
	$pembeli = $_POST['pembeli'];
	$pegawai = $_POST['pgw'];
	$handphone = explode('_', $_POST['handphone']); //[0]=>3, [1]=>1200
	$jumlah = $_POST['jumlah'];
	$harga = $_POST['harga'];

	$lihatstock = mysqli_query($conn, "select * from handphone where id_hp='$handphone[0]'");
	$stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
	$stockskrg = $stocknya['stock_hp'];

	if ($jumlah <= $stockskrg) {
		$stockupdate = $stockskrg - $jumlah;
		$updatestock = mysqli_query($conn, "update handphone set stock_hp='$stockupdate' where id_hp='$handphone[0]'");
		$tambahtransaksi = mysqli_query($conn, "insert into transaksi (id_pembeli, id_pegawai, id_hp, total_harga, jumlah) values ('$pembeli', '$pegawai', '$handphone[0]', '$harga', '$jumlah')");
		header('location:transaksi.php');
	} else {
		echo "gagal";
		header('location:transaksi.php');
	}
}


// delete transaksi
if (isset($_POST['deletetransaksi'])) {
	$id_transaksi = $_POST['id_transaksi'];
	$id_hp = $_POST['id_hp'];
	$jumlah = $_POST['jumlah'];

	$lihatstock = mysqli_query($conn, "select * from handphone where id_hp='$id_hp'");
	$stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
	$stockskrg = $stocknya['stock_hp'];

	$stockupdate = $stockskrg + $jumlah;
	$updatestock = mysqli_query($conn, "update handphone set stock_hp='$stockupdate' where id_hp='$id_hp'");
	$tambahtransaksi = mysqli_query($conn, "delete from transaksi where id_transaksi='$id_transaksi'");

	header('location:transaksi.php');
}
