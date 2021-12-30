<?php
session_start();
if (isset($_SESSION['iduser'])) {
    include_once "config.php";
    $output = "<section class='chat-area'><header>";

    $iduser = $_POST['user_id'];
    $sql = "SELECT * FROM users WHERE idusers = '$iduser'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $status = "";
    if ($row['status'] == "online") {
        $status = $row['status'];
    }
    $output .= "<a href='#' class='back-icon'><i class='fas fa-arrow-left'></i></a>
    <img src='img/" . $row['idusers'] . "" . $row['ext'] . "' alt=''>
        <div class='details'>
          <span style='font-weight: 500;'>" . $row['name'] . "</span>
          <br>
          <p style='color: black; font-size: 13px;'>" . $status . "</p>
        </div>
      </header>
      <div class='chat-box'>

      </div>
      <form action='#' class='typing-area'>
        <input type='text' class='incoming_id' name='incoming_id' id='idpenerima' value='$iduser' hidden>
        <input type='text' name='message' id='message' class='input-field' placeholder='Ketikkan pesan anda di sini...' autocomplete='off'>
        <button id='button' type='button'><i class='fab fa-telegram-plane'></i></button>
      </form>
    </section>";

    echo $output;
} else {
    header("location: ../login.php");
}
