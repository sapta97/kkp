<?php

require_once("../../config.php");
require_once("../../auth.php");

if(isset($_POST['register'])){

    // filter data yang diinputkan
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $nomor_telp = filter_input(INPUT_POST, 'nomor_telp', FILTER_SANITIZE_STRING);
    $nip = filter_input(INPUT_POST, 'nip', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    $jk = filter_input(INPUT_POST, 'jk', FILTER_SANITIZE_STRING);
    
    $ekstensi_diperbolehkan = array('png','jpg');
    $namakaryawan = $_FILES['file_img']['name'];
  
    $x = explode('.', $namakaryawan);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file_img']['size'];
    $file_img = $_FILES['file_img']['tmp_name']; 

    move_uploaded_file($file_img, '../../file/'.$namakaryawan);
    
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


    // menyiapkan query
    $sql = "INSERT INTO admin (nip, nama, email, password, role, nomor_telp , jk , file_img) 
            VALUES (:nip, :nama, :email, :password, :role, :nomor_telp, :jk, :file_img)";

    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":nip" => $nip,
        ":nama" => $nama,
        ":email" => $email,
        ":password" => $password,
        ":role" => $role,
        ":nomor_telp" => $nomor_telp,
        ":jk" => $jk, 
        ":file_img" => $namakaryawan
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);


    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman list
    if($saved) header("Location: list.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Karyawan</title>

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
                    <a href="../produk/list.php" class="list-group-item list-group-item-action">Produk</a>
                    <a href="list.php" class="list-group-item list-group-item-action active">Karyawan</a>
                    <a href="../transaksi/list.php" class="list-group-item list-group-item-action">Transaksi</a>
                </div>
            </div>
            <div class="col-md-6">

                <p>&larr; <a href="list.php">Kembali</a>


                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="nama">NIP</label>
                            <input class="form-control" type="text" name="nip" placeholder="NIP karyawan" />
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input class="form-control" type="text" name="nama" placeholder="Nama karyawan" />
                        </div>

                        <div class="form-group">
                            <label for="usernama">Email</label>
                            <input class="form-control" type="email" name="email" placeholder="Email karyawan" />
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Password" />
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-select" name="role">
                                <option selected>Pilih Jabatan</option>
                                <option value="0">Karyawan</option>
                                <option value="1">Manager</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nama">Nomor Telepon</label>
                            <input class="form-control" type="text" name="nomor_telp"
                                placeholder="Nomor Telepon karyawan" />
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-select" name="jk" aria-label="Default select example">
                                <option selected>Jenis Kelamin</option>
                                <option value="0">Laki-laki</option>
                                <option value="1">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group <?php echo (!empty($file_img)) ?  'has-error' : '';?>">
                            <label for="file_img">Gambar</label>
                            <div class="col-sm-10">
                                    <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"
                                        value="<?php echo isset($data['file_img']) ? $data['file_img'] : 'tidak ada gambar' ; ?>"
                                        name="file_img">
                                
                                </div>
                        </div>

                        <input type="submit" class="btn btn-success btn-block mt-3" name="register" value="Daftar" />

                    </form>

            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>

</html>