<?php
    
    require_once("../../auth.php");
    require_once("../../config.php");

    if(!isset($_GET['nip'])){
        die("Error: NIP Tidak Dimasukkan");
    }
    
    $query = $db->prepare("SELECT * FROM `admin` WHERE nip = :nip");
    $query->bindParam(":nip", $_GET['nip']);
    $query->execute();

    if($query->rowCount() == 0){
        die("Error: NIP Karyawan Tidak Ditemukan");
    } else {
        $data = $query->fetch();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
            <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-capitalize" >Hai <?php echo $_SESSION["admin"]["nama"] ?></h3>
                        <p><?php echo $_SESSION["admin"]["email"] ?>
                        <br><small><?php echo $_SESSION["admin"]["role"] == 0 ? 'Karyawan' : 'Manager'?></small>
                        </p>
                        <small><?php echo $_SESSION["admin"]["role"] == 0 ? 'Karyawan' : 'Manager'?></small>
                        <p><a href="../logout.php">Logout</a></p>
                    </div>
                </div>
                <div class="list-group">
                    <a href="../home.php" class="list-group-item list-group-item-action " aria-current="true">
                        Dashboard
                    </a>
                    <a href="../produk/list.php" class="list-group-item list-group-item-action">Produk</a>
                    <a href="../karyawan/list.php" class="list-group-item list-group-item-action active">Karyawan</a>
                    <a href="../transaksi/list.php" class="list-group-item list-group-item-action">Transaksi</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            <h5 class="text-capitalize">Data Karyawan <?php echo $data['nama'] ?></h5>
                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">NIP</label>
                                <div class="col-sm-10">
                                    <label class="mt-2"><strong><?php echo $data['nip'] ?></strong></label>
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled class="form-control" value="<?php echo $data['nama'] ?>"
                                        name="nama">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" disabled class="form-control" value="<?php echo $data['email'] ?>"
                                        name="email">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Nomor Telp</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled class="form-control" value="<?php echo $data['nomor_telp'] ?>"
                                        name="nomor_telp">
                                </div>
                            </div>
                            <div class="mb-2 row" <?php  $_SESSION["admin"]["role"] == 1 ?>>
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" disabled value="<?php echo $data['password'] ?>" class="form-control"
                                        id="inputPassword">
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <select class="form-select" disabled value="<?php echo $data['role'] ?>" name="role"
                                        aria-label="Default select example">
                                        <option value="<?php echo $data['role'] ?>" selected>
                                            <?php echo $data['role'] == 0 ? 'Karyawan' : 'Manager' ?></option>
                                        <option value="0">Karyawan</option>
                                        <option value="1">Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="form-select" disabled value="<?php echo $data['jk'] ?>" name="jk"
                                        aria-label="Default select example">
                                        <option value="<?php echo $data['jk'] ?>" selected>
                                            <?php echo $data['jk'] == 0 ? 'Laki-laki' : 'Perempuan' ?></option>
                                        <option value="0">Laki-laki</option>
                                        <option value="1">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-2 row" <?php echo (!empty($file_img)) ?  'has-error' : '';?>>
                                <label for="staticEmail" class="col-sm-2 col-form-label">Gambar</label>
                                <div class="col-sm-10">
                                        <img src="<?php echo "../../file/".$data['file_img']; ?>" width="120" height="120" class="mt-2">
                                </div>
                            </div>

                            <a class="btn btn-primary mt-3 mb-3 col-md-3" href="../karyawan/list.php"  style="float:right !important"
                               > Kembali</a>
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