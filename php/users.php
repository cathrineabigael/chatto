<?php
    session_start();
    include_once "config.php";
    $idsekarang = $_SESSION['iduser'];
    $output = "";

    $sql = "SELECT * FROM users WHERE NOT idusers = '$idsekarang' ORDER BY idusers DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $you="";
            $id=$row['idusers'];
            $sql2 = "SELECT * FROM messages WHERE (idreceive = '$id' OR idsend = '$id') AND (idsend = '$idsekarang' OR idreceive = '$idsekarang') ORDER BY idmessages DESC LIMIT 1";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while($row1 = $result2->fetch_assoc()) {
                    $msg= $row1['message'];
                    
                    if ($row1['idsend']==$idsekarang) {
                        $you="Anda: ";
                        if(strlen($msg)>28) {
                            $msg=substr($msg, 0,10)."...";
                        }
                    }else{
                        $you="";
                        if(strlen($msg)>28) {
                            $msg=substr($msg, 0,15)."...";
                        }
                    }
                }
            }else{
                $msg="Belum ada chat";
            }
            ($row['status'] == "offline") ? $offline = "offline" : $offline = "";

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
        $output .= "Tidak ada user lain yang dapat di chat";
    }
    echo $output;
?>