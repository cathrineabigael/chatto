<?php 
    session_start();
    include_once "config.php";
    $email=$_POST['email'];
    $password = $_POST['password'];
    $info="";
    $message="";
    if(!is_null($email) && !is_null($password)){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            if ($password==$row['password']) {
                $status = "online";
                $iduser=$row['idusers'];
                $sql2 = "UPDATE users SET status = '$status' WHERE idusers = '$iduser'";
                if ($conn->query($sql2) === TRUE) {
                    $_SESSION['iduser'] = $row['idusers'];
                    $info="success";
                    $message="Berhasil Login";
                } else {
                    $info="fail";
                    $message="Maaf terjadi sistem error dalam menampung session!";
                }
            }
            else
            {
                $info="fail";
                $message="Password yang anda masukkan tidak sesuai!";
            }
          }
        } else {
            $info="fail";
            $message="Email yang anda masukkan tidak terdaftar!";
        }   
    }
    $data= array(
        'status'=>$info,
        'message'=>$message
    );
    echo json_encode($data);
    $conn->close();
