<?php
session_start();
if (isset($_SESSION['iduser'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['iduser'];
    $incoming_id = $_POST['user_id'];
    // $iduser=$_POST['user_id'];
    $output = "";
    
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.idusers = messages.idsend
                WHERE (idsend = '$outgoing_id' AND idreceive = '$incoming_id')
                OR (idsend = '$incoming_id' AND idreceive = '$outgoing_id') ORDER BY idmessages";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            if ($row['idsend'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>' . $row['message'] . '</p>
                                    </div>
                                </div>
                                <div class="chat outgoing">
                                    <div class="details">
                                        <span>' . substr($row['waktu'],0, 16) . '</span>
                                    </div>
                                </div>
                                ';
            } else {
                $output .= '<div class="chat incoming">
                                <img src="img/' . $row['idusers'] . $row['ext'] . '" alt="">
                                <div class="details">
                                    <p>' . $row['message'] . '</p>
                                </div>
                                </div>
                                <div class="chat incoming">
                                    <div class="details">
                                        <span>' .substr($row['waktu'],0, 16) . '</span>
                                    </div>
                                </div>';
            }
         
        }
      
    } else {
       '<div class="text">Belum ada pesan yang terkirim. Jika anda mengirimkan pesan maka akan ditampilkan dalam kolom pesan ini.</div>';
    }
    echo $output;
} else {
    header("location: ../login.php");
}
