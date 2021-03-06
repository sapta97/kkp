<?php
    require_once("../../auth.php");
    require_once("../../config.php");

    if(isset($_GET["nip"])){
        // Prepared statement untuk menghapus data
        $query = $db->prepare("DELETE FROM `admin` WHERE nip=:nip");
        $query->bindParam(":nip", $_GET["nip"]);
        
        // Jalankan Perintah SQL
        $query->execute();

        echo 'test';

        // Alihkan ke index.php
        header("location: list.php");
    }
?>