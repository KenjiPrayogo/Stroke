<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Forms / Layouts - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

    <?php
    
    include 'connect.php';
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }
    #cek input
    if(isset($_POST["nama"]) 
        && isset($_POST["umur"]) 
        && isset($_POST["jenis_kelamin"])  
        && isset($_POST["jenis_pekerjaan"])
        && isset($_POST["status_pernikahan"])
        && isset($_POST["tempat_tinggal"])
        && isset($_POST["status_merokok"])
        && isset($_POST["hipertensi"])
        && isset($_POST["penyakit_jantung"])
        && isset($_POST["glukosa"])
        && isset($_POST["bmi"])){       
        #normalisasi
        $nama = $_POST["nama"];
        if($_POST['umur'] > 0 && $_POST['umur'] <= 18){
            $umur = normalisasi(1, 1, 4);
        }elseif($_POST['umur'] > 18 && $_POST['umur'] <= 40){
            $umur = normalisasi(2, 1, 4);
        }elseif($_POST['umur'] > 40 && $_POST['umur'] <= 60){
            $umur = normalisasi(3, 1, 4);
        }elseif($_POST['umur'] > 60){
            $umur = normalisasi(4, 1, 4);
        }
        
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $jenis_pekerjaan = normalisasi($_POST["jenis_pekerjaan"], 1, 5);
        $status_pernikahan = $_POST["status_pernikahan"];
        $tempat_tinggal = $_POST["tempat_tinggal"];
        $status_merokok = $_POST["status_merokok"] / 2;
        $hipertensi = $_POST["hipertensi"];
        $penyakit_jantung = $_POST["penyakit_jantung"];
        if($_POST['glukosa'] > 0 && $_POST['glukosa'] <= 70){ # Rendah
            $glukosa = normalisasi(1, 1, 4);
        }elseif($_POST['glukosa'] > 70 && $_POST['glukosa'] <= 100){ # Normal
            $glukosa = normalisasi(2, 1, 4);
        }elseif($_POST['glukosa'] > 100 && $_POST['glukosa'] <= 120){ # Pre Diabete
            $glukosa = normalisasi(3, 1, 4);
        }elseif($_POST['glukosa'] > 120){ # Diabetes
            $glukosa = normalisasi(4, 1, 4);
        }
        if($_POST['bmi'] > 0 && $_POST['bmi'] < 18.5){ # Underweight
            $bmi = normalisasi(1, 1, 4);
        }elseif($_POST['bmi'] >= 18.5 && $_POST['bmi'] < 25){ # Normal
            $bmi = normalisasi(2, 1, 4);
        }elseif($_POST['bmi'] >= 25 && $_POST['bmi'] < 30){ #Overweight
            $bmi = normalisasi(3, 1, 4);
        }elseif($_POST['bmi'] >= 30){ #Obese
            $bmi = normalisasi(4, 1, 4);
        }
    }
    else if(!isset($_POST["nama"]) 
        || !isset($_POST["umur"]) 
        || !isset($_POST["jenis_kelamin"])  
        || !isset($_POST["jenis_pekerjaan"])
        || !isset($_POST["status_pernikahan"])
        || !isset($_POST["tempat_tinggal"])
        || !isset($_POST["status_merokok"])
        || !isset($_POST["hipertensi"])
        || !isset($_POST["penyakit_jantung"])
        || !isset($_POST["glukosa"])
        || !isset($_POST["bmi"])){
        header ('location: index.html');
    }
    
    #pembobotan
    $w_umur = 1;
    $w_jenis_kelamin = 1;
    $w_jenis_pekerjaan = 1;
    $w_status_pernikahan = 1;
    $w_tempat_tinggal = 1;
    $w_status_merokok = 1;
    $w_hipertensi = 1;
    $w_penyakit_jantung = 1;
    $w_glukosa = 1;
    $w_bmi = 1;

    $sql = "SELECT * FROM data_kasus_2";
    $query = mysqli_query($conn, $sql);
    $hasil = [];
    $hasil_stroke = [];
    $hasil_id = [];

    if (mysqli_query($conn, $sql)) {
        while($row = mysqli_fetch_assoc($query)){
            # similaritas
            # = akar ( (sigma(f(si.ti)^2 * wi^2)) / sigma(wi^2))
            # f(si.ti) = si - ti = kasus lama ke i - kasus baru ke i
            # hasil similaritas masuk ke array hasil
            array_push($hasil, 1 - sqrt(((pow(($row['umur'] - $umur), 2) * pow($w_umur, 2)) + 
                        (pow(($row['jenis_kelamin'] - $jenis_kelamin), 2) * pow($w_jenis_kelamin, 2)) + 
                        (pow(($row['jenis_pekerjaan'] - $jenis_pekerjaan), 2) * pow($w_jenis_pekerjaan, 2)) + 
                        (pow(($row['status_pernikahan'] - $status_pernikahan), 2) * pow($w_status_pernikahan, 2)) + 
                        (pow(($row['tempat_tinggal'] - $tempat_tinggal), 2) * pow($w_tempat_tinggal, 2)) + 
                        (pow(($row['status_merokok'] - $status_merokok), 2) * pow($w_status_merokok, 2)) + 
                        (pow(($row['hipertensi'] - $hipertensi), 2) * pow($w_hipertensi, 2)) + 
                        (pow(($row['penyakit_jantung'] - $penyakit_jantung), 2) * pow($w_penyakit_jantung, 2)) + 
                        (pow(($row['glukosa'] - $glukosa), 2) * pow($w_glukosa, 2)) + 
                        (pow(($row['bmi'] - $bmi), 2) * pow($w_bmi, 2))) / 
                        (pow($w_umur, 2) +
                        pow($w_jenis_kelamin, 2) +
                        pow($w_jenis_pekerjaan, 2) +
                        pow($w_status_pernikahan, 2) +
                        pow($w_tempat_tinggal, 2) +
                        pow($w_status_merokok, 2) +
                        pow($w_hipertensi, 2) +
                        pow($w_penyakit_jantung, 2) +
                        pow($w_glukosa, 2) +
                        pow($w_bmi, 2))));
            
            array_push($hasil_stroke, $row['stroke']);
            array_push($hasil_id, $row['id']);
		}
        
        # dilakukan sorting untuk hasil similaritas dan stroke
        
        for ($i = 0; $i <= count($hasil); $i++) {
            for ($j = 0; $j < count($hasil)-1; $j++) {
                if($hasil[$j] > $hasil[$j+1]){
                    $temp = $hasil[$j];
                    $hasil[$j] = $hasil[$j + 1];
                    $hasil[$j + 1] = $temp; 
                    $temp2 = $hasil_stroke[$j];
                    $hasil_stroke[$j] = $hasil_stroke[$j + 1];
                    $hasil_stroke[$j + 1] = $temp2; 
                    $temp3 = $hasil_id[$j];
                    $hasil_id[$j] = $hasil_id[$j + 1];
                    $hasil_id[$j + 1] = $temp3;
                }
            } 
        }
        # diambil hasil yang terbesar
        $prediksi = $hasil_stroke[count($hasil_stroke)-1];
        $similaritas = $hasil[count($hasil)-1];
        $similar_dengan_id_ke = $hasil_id[count($hasil_id)-1];

        
        
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    function normalisasi($x, $MinValue, $MaxValue, $MinRange=0, $MaxRange=1){
        return ($MinRange + (($x-$MinValue)*($MaxRange-$MinRange)) / ($MaxValue-$MinValue));
    }
?>
</head>
<body>
<section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Identitas</h5>

              <!-- Horizontal Form -->
              <form action="save.php" method="post">
                <input type="hidden" name="nama" value="<?php echo $_POST['nama'] ?>">
                <input type="hidden" name="umur" value="<?php echo $umur?>">
                <input type="hidden" name="jenis_kelamin" value="<?php echo $_POST['jenis_kelamin'] ?>">
                <input type="hidden" name="jenis_pekerjaan" value="<?php echo $jenis_pekerjaan?>">
                <input type="hidden" name="status_pernikahan" value="<?php echo $status_pernikahan ?>">
                <input type="hidden" name="tempat_tinggal" value="<?php echo $tempat_tinggal?>">
                <input type="hidden" name="status_merokok" value="<?php echo $status_merokok ?>">
                <input type="hidden" name="hipertensi" value="<?php echo $hipertensi ?>">
                <input type="hidden" name="penyakit_jantung" value="<?php echo $penyakit_jantung ?>">
                <input type="hidden" name="glukosa" value="<?php echo $glukosa ?>">
                <input type="hidden" name="bmi" value="<?php echo $bmi ?>">
                <input type="hidden" name="prediksi" value="<?php echo $prediksi ?>">
                <input type="hidden" name="similaritas" value="<?php echo $similaritas ?>">
                <input type="hidden" name="similar_dengan_id_ke" value="<?php echo $similar_dengan_id_ke ?>">
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Nama </label>
                  <div class="col-sm-10">
                  
                    <div><?php echo $nama?></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Umur </label>
                  <div class="col-sm-10">
                  
                    <div><?php echo $_POST["umur"]?></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">BMI </label>
                  <div class="col-sm-10">
                  
                    <div><?php echo $_POST["bmi"]?></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Gula Darah </label>
                  <div class="col-sm-10">
                  
                    <div><?php echo $_POST["glukosa"]?>mg/dL</div>
                  </div>
                </div>
                <h5 class="card-title">Hasil </h5>

                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Prediksi </label>
                  <div class="col-sm-10">
                    <div><?php if($prediksi == 1){
                        echo "Stroke";
                        }else{
                            echo "Tidak Stroke";
        }?></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Similaritas </label>
                  <div class="col-sm-10">
                  
                    <div><?php echo $similaritas?></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Similar dengan id </label>
                  <div class="col-sm-10">
                  <div><?php echo $similar_dengan_id_ke?></div>
                  </div>
                </div>
                
                <div class="text-center">
                  <a href=""><button type="submit" class="btn btn-primary">Save</button></a>
                  <a href="index.html"><button type="submit" class="btn btn-primary">Cancel</button></a>
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>

          <!-- End floating Labels Form -->

            </div>
          </div>

        </div>
      </div>
    </section>

    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
