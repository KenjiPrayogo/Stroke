<?php
include_once 'connect.php';

        $nama = $_POST["nama"];
        $umur = $_POST["umur"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $jenis_pekerjaan = $_POST["jenis_pekerjaan"];
        $status_pernikahan = $_POST["status_pernikahan"];
        $tempat_tinggal = $_POST["tempat_tinggal"];
        $status_merokok = $_POST["status_merokok"];
        $hipertensi = $_POST["hipertensi"];
        $penyakit_jantung = $_POST["penyakit_jantung"];
        $glukosa = $_POST["glukosa"];
        $bmi = $_POST["bmi"];
        $stroke = $_POST["prediksi"];
        $similaritas = $_POST["similaritas"];
        $similar_dengan_id_ke = $_POST["similar_dengan_id_ke"];
       
$sql = "INSERT INTO data_hasil(nama, umur, jenis_kelamin, jenis_pekerjaan, status_pernikahan, tempat_tinggal,status_merokok,hipertensi,penyakit_jantung,glukosa,bmi,stroke,similaritas, similar_dengan) 
VALUES ('" . $nama . "', '" . $umur . "', '".$jenis_kelamin."', '" . $jenis_pekerjaan . "','" . $status_pernikahan . "','".$tempat_tinggal."'
,'".$status_merokok."','".$hipertensi."','".$penyakit_jantung."','".$glukosa."','".$bmi."','".$stroke."','".$similaritas."','".$similar_dengan_id_ke."')";


if ($conn->query($sql)) {
    header('location: index.html');
} else {
    echo "Error :" . $conn->error;
}