<?php
include("../../conf/db_conn.php");
const TARGET_DIR="../../image/logo/";
const ALLOWED_EXT = array('png', 'jpg', 'jpeg', 'gif'); 
const MAX_FILE_SIZE = 512000;

function checkImage($image)
{
    $filename = $_FILES[$image]['name']; 
    $ukuran = $_FILES[$image]['size']; 
    $tmp_file = $_FILES[$image]["tmp_name"]; 
    $ext = pathinfo($filename, PATHINFO_EXTENSION); 
    $target_file = TARGET_DIR . basename($filename); 
    
    // cek apakah ada file yang diupload
    if ($_FILES[$image]['error'] !== UPLOAD_ERR_OK) {
        return "Tidak ada file yang diupload atau error!";
    }

    $image_info = getimagesize($tmp_file);
    // cek apakah file image atau bukan 
    if(!$image_info){
        return "File yang diupload bukan image!";
    }
    
    // cek apakah file sudah ada
    if (file_exists($target_file)) {
        return "File yang diupload sudah ada, silahkan ganti nama file!";
    }
    
    // cek ukuran file
    if ($ukuran > MAX_FILE_SIZE) { 
        return "File yang diupload melebihi 512kb!"; 
    } 
    
    // cek ekstensi file
    if(!in_array($ext, ALLOWED_EXT)) {
        return "Ekstensi file yang diupload tidak diperbolehkan (upload hanya .png, .jpg, .jpeg, .gif)!";
    } 
    
    if (move_uploaded_file($tmp_file, $target_file)){ 
        return "OK"; 
    } else { 
        return "Gagal mengupload file! $target_file"; 
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $kabupaten_kota = $_POST['kabupaten_kota']; 
    $pusat_pemerintahan = $_POST['pusat_pemerintahan'];
    $bupati_walikota = $_POST['bupati_walikota'];
    $tanggal_berdiri = $_POST['tanggal_berdiri'];
    $luas_wilayah = $_POST['luas_wilayah']; 
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $jumlah_kecamatan = $_POST['jumlah_kecamatan'];
    $jumlah_kelurahan = $_POST['jumlah_kelurahan'];
    $jumlah_desa = $_POST['jumlah_desa'];
    $url_peta_wilayah = $_POST['url_peta_wilayah'];
    $deskripsi = $_POST['deskripsi']; 
    $filename = $_FILES['logo']['name']; 

    $result = checkImage("logo"); 
    if($result != "OK") { 
        echo "<script>alert('$result');</script>"; 
        echo "<script>window.location ='../../index.php?page=tambah_kabkota';</script>"; 
    } else { 
        $query = "INSERT INTO tb_kab_kota SET
            kabupaten_kota = '$kabupaten_kota', 
            pusat_pemerintahan = '$pusat_pemerintahan',
            bupati_walikota = '$bupati_walikota', 
            tanggal_berdiri = '$tanggal_berdiri', 
            luas_wilayah = '$luas_wilayah', 
            jumlah_penduduk = '$jumlah_penduduk', 
            jumlah_kecamatan = '$jumlah_kecamatan',
            jumlah_kelurahan = '$jumlah_kelurahan', 
            jumlah_desa = '$jumlah_desa', 
            url_peta_wilayah = '$url_peta_wilayah', 
            deskripsi = '$deskripsi',
            logo = '$filename'";

        $result = mysqli_query($conn, $query); 
        if($result) {
            echo "<script>alert('Berhasil menambahkan data $kabupaten_kota!');</script>"; 
            echo "<script>window.location='../../index.php?page=data_kabkota';</script>"; 
        } else { 
            echo "<script>alert('Gagal menambahkan data $kabupaten_kota, coba cek isian anda!');</script>"; 
            echo "<script>window.location='../../index.php?page=tambah_kabkota';</script>";
        } 
    } 
}
?>
