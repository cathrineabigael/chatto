<?php
    session_start();
    if(isset($_SESSION['iduser'])){
        include_once "config.php";
        $logout_id = $_GET['logout_id'];
        if(isset($logout_id)){
            $status = "offline";
            $sql1 = "UPDATE users SET status = '$status' WHERE idusers = '$logout_id'";
            if ($conn->query($sql1) === TRUE) {
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>