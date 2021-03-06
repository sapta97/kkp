<?php
 require_once("../../auth.php");
 require_once("../../config.php");
 



if(isset($_POST['tambah_produk'])){

    $deskripsi = filter_input(INPUT_POST, 'deskripsi', FILTER_SANITIZE_STRING);
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $stok = filter_input(INPUT_POST, 'stok', FILTER_SANITIZE_STRING);
    $harga = filter_input(INPUT_POST, 'harga', FILTER_SANITIZE_STRING);
    $created_at = filter_input(INPUT_POST, 'created_at', FILTER_SANITIZE_STRING);
    $kode_barang = filter_input(INPUT_POST, 'kode_barang', FILTER_SANITIZE_STRING);

    $ekstensi_diperbolehkan = array('png','jpg');
    $namaKodeBarang = $_FILES['file_img']['name'];
  
    $x = explode('.', $namaKodeBarang);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file_img']['size'];
    $file_img = $_FILES['file_img']['tmp_name']; 

    move_uploaded_file($file_img, '../../file/'.$namaKodeBarang);
            
    //menyiapkan query
    $sql = "INSERT INTO produk ( kode_barang, nama, deskripsi, stok, harga, file_img, created_by ) 
    VALUES ( :kode_barang, :nama, :deskripsi, :stok, :harga, :file_img, :created_by)";

    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":kode_barang" => $kode_barang,
        ":nama" => $nama,
        ":deskripsi" => $deskripsi,
        ":stok" => $stok,
        ":harga" => $harga,
        ":file_img" => $namaKodeBarang,
        ":created_by" => $_SESSION["admin"]["nama"],
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka produk sudah terdaftar
    // maka alihkan ke halaman list
     header("Location: list.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Produk</title>

    <!-- menyisipkan bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-capitalize">Hai <?php echo $_SESSION["admin"]["nama"] ?></h3>
                        <p><?php echo $_SESSION["admin"]["email"] ?>
                            <br><small><?php echo $_SESSION["admin"]["role"] == 0 ? 'Karyawan' : 'Manager'?></small>
                        </p>

                        <p><a href="../logout.php">Logout</a></p>
                    </div>
                </div>
                <div class="list-group">
                    <a href="../home.php" class="list-group-item list-group-item-action " aria-current="true">
                        Dashboard
                    </a>
                    <a href="../produk/list.php" class="list-group-item list-group-item-action active">Produk</a>
                    <a href="list.php" class="list-group-item list-group-item-action ">Karyawan</a>
                    <a href="../transaksi/list.php" class="list-group-item list-group-item-action">Transaksi</a>
                </div>
            </div>
            <div class="col-md-6">

                <p>&larr; <a href="list.php">Kembali</a>


                    <form  method="POST" action="" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input class="form-control" type="text" name="kode_barang" placeholder="Kode barang " />
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Barang</label>
                            <input class="form-control" type="text" name="nama" placeholder="Nama barang " />
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi </label>
                            <input class="form-control" type="text" name="deskripsi" placeholder="Deskripsi barang" />
                        </div>

                        <div class="form-group">
                            <label for="stok">Stok </label>
                            <input class="form-control" type="text" name="stok" placeholder="Stok barang" />
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input class="form-control" type="text" name="harga" placeholder="Harga barang" />
                        </div>

                        <div class="form-group <?php echo (!empty($file_img)) ?  'has-error' : '';?>">
                            <label for="file_img">Gambar</label>
                            <div class="col-sm-10">
                                    <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"
                                        value="<?php echo isset($data['file_img']) ? $data['file_img'] : 'tidak ada gambar' ; ?>"
                                        name="file_img">
                                
                                </div>
                        </div>

                        <input type="submit" class="btn btn-success btn-block mt-3" name="tambah_produk" value="Simpan" required />
                        <input type="reset" class="btn btn-danger btn-block mt-3" name="reset" value="Kosongkan"/>

                    </form>

            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>

</html>