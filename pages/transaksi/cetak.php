<?php 
    
    require_once("../../auth.php");
    require_once("../../config.php");

    // $link = mysqli_connect("localhost", "root", "", "db_kkp");
 
    // // Check connection
    // if($link === false){
    //     die("ERROR: Could not connect. " . mysqli_connect_error());
    // }
    
    // $result = mysqli_query($link,"SELECT * FROM admin");

    //list semua data
    $sql = $db->prepare("SELECT * FROM transaksi ORDER BY nama ASC");
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">No Transaksi</th>
                <th scope="col">ID Produk</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Status</th>
                <th scope="col"> Harga</th>
                <th scope="col"> Total</th>
                <th scope="col">ID Admin</th>
                <th scope="col">ID Pelanggan</th>
                <th scope="col"> Tanggal</th>


            </tr>
        </thead>
        <tbody>
            <?php 
                            $i = 1;
                            foreach ($result as $user) {?>
            <tr>
                <th scope="row"><?php echo $i++ ?></th>
                <td><?php echo $user['tiket_trx'] ?></td>
                <td><?php echo $user['produk_id'] ?></td>
                <td><?php echo $user['kode_barang'] ?></td>
                <td><?php echo $user['nama'] ?></td>
                <td><?php echo $user['jumlah_jual'] ?></td>
                <td><?php echo $user['status'] ?></td>
                <td><?php echo $user['harga'] ?></td>
                <td><?php echo $user['total_bayar'] ?></td>
                <td><?php echo $user['id_admin'] ?></td>
                <td><?php echo $user['id_pelanggan'] ?></td>
                <td><?php echo date("d/m/Y", strtotime($user['created_at']));  ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>


    <script>
        window.print();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>

</html>