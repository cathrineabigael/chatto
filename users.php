<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['iduser'])) {
  header("location: login.php");
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Chat App | Project Full Stack</title>
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>

  <div class="container">
    <div class="wrapper">
      <section class="users">
        <header>
          <div class="content">
            <?php
            $sql = "SELECT * FROM users WHERE idusers='" . $_SESSION['iduser'] . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
            ?>
                <img src="img/<?php echo $row['idusers'] . $row['ext'] ?>" alt="">
                <div class="details">
                  <span><?php echo $row['name'] ?></span>
                  <p><?php echo $row['status']; ?></p>
                </div>
            <?php
              }
            } else {
              echo "failed to select user!";
            }
            ?>
          </div>
          <a href="php/logout.php?logout_id=<?php echo $_SESSION['iduser']; ?>" class="logout">Logout</a>
        </header>
        <div class="search">
          <span class="text" class="pilihkontak">Pilih kontak dahulu</span>
          <input type="text" placeholder="Cari berdasarkan nama" id="txtSearch">
          <button id="searchIcon"><i class="fas fa-search"></i></button>
        </div>
        <div class="users-list">

        </div>
      </section>
    </div>
    <div class="chat">
      <div class="chattengah">
        <center>
          <img src="img/icon.png" alt="" srcset="">
        <!-- Illustration by <a href="https://icons8.com/illustrations/author/5c07e68d82bcbc0092519bb6">Icons 8</a> from <a href="https://icons8.com/illustrations">Ouch!</a> -->
        <br>
        <p style="font-size: 40px;">Mulai percakapan</p></center>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    var user_id;

    //for chat
    $('body').on('click', '.contact', function() {
      user_id = $(this).data('value');
      loadChat();

      // inputActive();

      loadChatBox();
    });



    $(document).ready(function() {

      // for userslist
      searchContact();
      setInterval(function() {
        updateStatusContact()
      }, 500);

      // //for chat
      inputActive();

      //biar ga ilang message error nya karena ke refresh 
      $("form").submit(function() {
        event.preventDefault();
      });


      $(document).on('mouseenter', '.chat-box', function() {
        $(".chat-box").addClass("active");
      });

      $(document).on('mouseleave', '.chat-box', function() {
        $(".chat-box").removeClass("active");
      });

      $('.chat').css('display', 'block');

      // update Message
      setInterval(function() {
        reloadChatBox()
      }, 500);


    });

    $(document).on('click', '#button', function() {
      //insertChat
      insertChat();
      $(".input-field").focus();
      loadChatBox();

    });

    $('.chat').on('keydown', '.input-field', function(e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        e.stopImmediatePropagation();

        //insertChat
        insertChat();
        $(".input-field").focus();
        loadChatBox();

      }
    });


    function searchContact() {
      $(document).on('click', '#searchIcon', function() {

        $("#txtSearch").toggleClass("show");
        $("#searchIcon").toggleClass("active");
        $("#txtSearch").focus();
        if ($("#txtSearch").hasClass("active")) {
          $("#txtSearch").val("");
          $("#txtSearch").removeClass("active");
        }
      });

      $(document).on('keyup', '#txtSearch', function() {
        var searchQuery = $('#txtSearch').val();
        //biar bisa ngetik
        if (searchQuery == "") {
          $("#txtSearch").removeClass("active");
        } else {
          $("#txtSearch").addClass("active");
        }

        $.ajax({
          type: 'POST',
          url: "php/search.php",
          data: {
            searchQuery: searchQuery
          },
          success: function(data) {
            $(".users-list").html(data);
          },
          error: function(data) {
            alert("error");
          }
        });
      });
    }

    function updateStatusContact() {
      $.ajax({
        type: 'GET',
        url: "php/users.php",
        success: function(data) {
          if (!($("#txtSearch").hasClass("active"))) {
            $(".users-list").html(data);
          }
        },
        error: function(data) {
          alert("error");
        }
      });
    }

    function inputActive() {
      $(document).on('keyup', '.input-field', function() {
        if ($(".input-field").val() != "") {
          $("#button").addClass("active");
        } else {
          $("#button").removeClass("active");
        }
      });
    }

    function insertChat() {
      $.ajax({
        type: 'POST',
        url: "php/insert-chat.php",
        data: {
          idpenerima: $('#idpenerima').val(),
          message: $('#message').val()
        },
        success: function(data) {
          if (data != "true") {
            alert(data);
          } else {
            $(".input-field").val("");
          }

        },
        error: function(data) {
          alert("error");
        }
      });
    }

    function loadChat() {
      $.ajax({
        type: 'POST',
        url: "php/get-chat1.php",
        data: {
          user_id: user_id
        },
        success: function(data) {
          $(".chat").html(data);
          $(".input-field").focus();
        },
        error: function(data) {
          alert("error");
        }
      });

    }

    function loadChatBox() {
      $.ajax({
        type: 'POST',
        url: "php/get-chat.php",
        data: {
          user_id: user_id
        },
        success: function(data) {
          $(".chat-box").html(data);
          $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
        },
        error: function(data) {
          alert("error");
        }
      });


    }

    function reloadChatBox() {
      $.ajax({
        type: 'POST',
        url: "php/get-chat.php",
        data: {
          user_id: user_id
        },
        success: function(data) {
          $(".chat-box").html(data);

        },
        error: function(data) {
          alert("error");
        }
      });


    }
  </script>

</body>

</html>