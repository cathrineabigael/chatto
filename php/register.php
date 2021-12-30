<?php
    session_start();
    include_once "config.php";
    $info="";
    $message="";

    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    if(!is_null($name) && !is_null($email) && !is_null($password)){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $info="fail";
            $message="Email yang dimasukkan sudah digunakan, mohon gunakan email lainnya!";
        }else{    
            if(isset($_FILES['image'])){
                $lastID=1;
                $sql1 = "SELECT * FROM users ORDER BY idusers desc limit 1";
                $result1 = $conn->query($sql1);
                if ($result1->num_rows > 0) {
                    while($row = $result1->fetch_assoc()) {
                        $lastID=$row['idusers']+1;
                    }
                }
                $path = $_FILES['image']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $extdb=".".$ext;
                $extensions = ["jpeg", "png", "jpg"];
                $namaSementara = $_FILES['image']['tmp_name'];
                if (in_array($ext, $extensions)) {
                     // tentukan lokasi file akan dipindahkan
                    $dirUpload = "../img/";
                    $terupload = move_uploaded_file($namaSementara, $dirUpload.$lastID.$extdb);
                    if($terupload){
                        $status = "online";
                        $sql2 = "INSERT INTO users VALUES ('$lastID', '$name','$email', '$password', '$extdb', '$status')";
                        if ($conn->query($sql2) === TRUE) {
                            $sql3 = "SELECT * FROM users WHERE email = '$email'";
                            $result3 = $conn->query($sql3);
                            if ($result3->num_rows > 0) {
                                while($row = $result3->fetch_assoc()) {
                                    $_SESSION['iduser'] = $row['idusers'];
                                    $info="success";
                                }
                            }else{
                                $info="fail";
                                $message="Gagal session idusers!";
                            }
                        }else {
                            $info="fail";
                            $message="Maaf terjadi kesalahan, sistem tidak dapat menambahkan data pengguna!";
                        }
                    }
                }else{
                    $info="fail";
                    $message="Mohon masukkan tipe gambar jpg/png/jpeg!";
                }
            }
        }
    }else{
        $info="fail";
        $message="Mohon lengkapi data diri yang tersedia!";
    }

    $data= array(
        'status'=>$info,
        'message'=>$message
    );
    echo json_encode($data);
?>