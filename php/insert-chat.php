<?php 
    session_start();
    if(isset($_SESSION['iduser'])){
        include_once "config.php";
        $idpengirim = $_SESSION['iduser'];
        $idpenerima = $_POST['idpenerima'];
        $message = $_POST['message'];
        if(!is_null($message)){
            $sql = "INSERT INTO messages (idreceive, idsend, message, waktu) VALUES ('$idpenerima', '$idpengirim', '$message',now())";
            if ($conn->query($sql) === TRUE) {
                echo "true";
            }else{
                echo "error";
            }
        }
    }else{
        header("location: ../login.php");
    }

?>