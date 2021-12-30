<?php
    session_start();
    include_once "config.php";

    $idsekarang = $_SESSION['iduser'];
    $searchQuery =  $_POST['searchQuery'];

    $output = "";
    $sql = "SELECT * FROM users WHERE NOT idusers = '$idsekarang' AND (name LIKE '%$searchQuery%')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $you="";
            $id=$row['idusers'];
            $sql2 = "SELECT * FROM messages WHERE (idreceive = '$id' OR idsend = '$id') AND (idsend = '$idsekarang' OR idreceive = '$idsekarang') ORDER BY idmessages DESC LIMIT 1";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while($row1 = $result2->fetch_assoc()) {
                    $msg= $row1['message'];
                    if(strlen($msg)>28) {
                        $msg=substr($result, 0,28)."...";
                    }
                    if ($row1['idsend']==$idsekarang) {
                        $you="Kamu: ";
                    }else{
                        $you="";
                    }
                }
            }else{
                $msg="Belum ada chat";
            }
            ($row['status'] == "offline") ? $offline = "offline" : $offline = "";
            ($idsekarang == $row['idusers']) ? $hid_me = "hide" : $hid_me = "";

            $output .= '<a href="#" data-value='. $row['idusers'].' class="contact">
                        <div class="content">
                        <img src="img/'.$row['idusers'].$row['ext'].'" alt="">
                        <div class="details">
                            <span>'. $row['name'] .'</span>
                            <p>'. $you . $msg .'</p>
                        </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';
        }
    }else{
        $output .= 'Tidak ada user dengan nama '.$searchQuery;
    }
    echo $output;
?>