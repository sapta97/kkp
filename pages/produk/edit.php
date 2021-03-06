<?php
require_once("../../auth.php");
require_once("../../config.php");

if(!isset($_GET['id'])){
    die("Error: Barang Tidak Ditemukan");
}

$query = $db->prepare("SELECT * FROM produk WHERE id =:id");
$query->bindParam(":id" , $_GET['id']);
$query->execute();


if($query->rowCount() == 0){
    die("Error: Kode Barang Tidak Ditemukan");
} else {
    $data = $query->fetch();
}


if(isset($_POST['submit'])){
    
    $kodebarang = filter_input(INPUT_POST, 'kode_barang', FILTER_SANITIZE_STRING);
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $deskripsi = filter_input(INPUT_POST, 'deskripsi', FILTER_SANITIZE_STRING);
    $stok = filter_input(INPUT_POST, 'stok', FILTER_SANITIZE_STRING);
    $harga = filter_input(INPUT_POST, 'harga', FILTER_SANITIZE_STRING);
    // $file_img = filter_input(INPUT_POST, 'file_img', FILTER_SANITIZE_STRING);
    $createdat = filter_input(INPUT_POST, 'created_at', FILTER_SANITIZE_STRING);
    
    $ekstensi_diperbolehkan = array('png','jpg');
    $namaKodeBarang = $_FILES['file_img']['name'];
  
    $x = explode('.', $namaKodeBarang);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file_img']['size'];
    $file_img = $_FILES['file_img']['tmp_name']; 

    move_uploaded_file($file_img, '../../file/'.$namaKodeBarang);
            
    //menyiapkan sql
    $sql = "UPDATE produk set `kode_barang` =:kode_barang, `nama`=:nama, `deskripsi` =:deskripsi, `stok` =:stok, `harga` =:harga, `file_img` =:file_img, `created_by` =:created_by, `created_at` = :created_at WHERE kode_barang =:kode_barang ";
    
    $params = array(
        ":kode_barang" =>$kodebarang,
        ":nama" =>$nama,
        ":deskripsi"=>$deskripsi,
        ":stok"=>$stok,
        ":harga"=>$harga,
        ":file_img"=> $namaKodeBarang,
        ":created_by"=> $_SESSION["admin"]["nama"],
        ":created_at"=>$createdat,
    );
    
    //ekseskui quert untuk menyimpan ke database
    $stmt = $db->prepare($sql);
    $saved = $stmt->execute($params);

    // echo '<pre>';
    //     print_r($saved);
    // echo '</pre>';

    // return;

    header("Location: list.php");
      
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTP-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewvort" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-capitalize">Hai <?php echo $_SESSION["admin"]["nama"]?></h3>
                        <p><?php echo $_SESSION["admin"]["email"]?>
                            <br><small><?php echo $_SESSION["admin"]["role"] == 0 ? 'Karyawan' : 'Manager' ?></small>
                        </p>
                        <small><?php echo $_SESSION["admin"]["role"] == 0 ? 'Karyawan' : 'Manager'?></small>
                    </div>
                </div>
                <div class="list-group">
                    <a href="../home.php" class="list-group-item list-group-actin ">Dasboard</a>
                    <a href="../produk/list.php" class="list-group-item list-group-actin active ">Produk</a>
                    <a href="../karyawan/list.php" class="list-group-item list-group-actin ">Karyawan</a>
                    <a href="../transaksi/list.php" class="list-group-item list-group-actin ">Transaksi</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <h5 class="text-capitalize">Data Produk
                                <?php echo isset($data['kode_barang']) ? $data['kode_barang'] : ''; ?></h5>
                         
                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Kode Barang</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo isset($data['kode_barang']) ? $data['kode_barang'] : 'tidak ada'; ?>"
                                        name="kode_barang">
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Nama Barang</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo isset($data['nama']) ? $data['nama'] : 'tidak ada'; ?>"
                                        name="nama">
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo isset($data['deskripsi']) ? $data['deskripsi'] : ''; ?>"
                                        name="deskripsi">
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Stok</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo isset($data['stok']) ? $data['stok'] : ''; ?>" name="stok">
                                </div>
                            </div>

                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Harga</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                        value="<?php echo isset($data['harga']) ? $data['harga'] : ''; ?>" name="harga">
                                </div>
                            </div>

                            <div class="mb-2 row" <?php echo (!empty($file_img)) ?  'has-error' : '';?>>
                                <label for="staticEmail" class="col-sm-2 col-form-label">Gambar</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"
                                        value="<?php echo isset($data['file_img']) ? $data['file_img'] : 'tidak ada gambar' ; ?>"
                                        name="file_img">
                                        <img src="<?php echo "../../file/".$data['file_img']; ?>" width="120" height="120" class="mt-2">
                                </div>
                            </div>

                            <input class="btn btn-primary mt-3 col-md-3" style="float:right !important" type="submit"
                                name="submit">
                            <a href="../produk/list.php" class="mt-3 mb-3 btn btn-warning "
                                style="float:right !important;margin-right:15px !important">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>

</html>