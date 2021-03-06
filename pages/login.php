<?php 

require_once("../config.php");

if(isset($_POST['login'])){

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM admin WHERE email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":email" => $email
    );

    $stmt->execute($params);
 
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($admin){
        // verifikasi password
        if(password_verify($password, $admin["password"])){
            // buat Session
            session_start();
            $_SESSION["admin"] = $admin;
            // login sukses, alihkan ke halaman home
            header("Location: home.php");
        } else {
            echo '<script language="javascript">
            window.alert("LOGIN GAGAL! Silakan coba lagi");
            window.location.href="./login.php";
          </script>';   
        }
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">

                <p>&larr; <a href="../index.php">Home</a>

                    <h4>Masuk</h4>
                    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

                    <form action="" method="POST">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" placeholder="email" />
                        </div>


                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Password" />
                        </div>

                        <input type="submit" class="btn btn-success btn-block mt-3" name="login" value="Masuk" />

                    </form>

            </div>

            <div class="col-md-6">
                <!-- isi dengan sesuatu di sini -->
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

</body>

</html>