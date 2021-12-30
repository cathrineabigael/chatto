<?php 
  session_start();

  if(isset($_SESSION['iduser'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>Chatto | Masuk</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text" id="error"></div>
        <div class="field input">
          <label>Alamat Email</label>
          <input type="text" name="email" id=txtemail placeholder="Masukkan email anda" required>
        </div>
        <div class="field input">
          <label>Kata sandi</label>
          <input type="password" name="password" id="txtpass" placeholder="Masukkan kata sandi anda" required>
          <i class="fas fa-eye" id="password" data-check="no"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Masuk">
        </div>
      </form>
      <div class="link">Belum terdaftar? <a href="index.php">Daftar sekarang</a></div>
    </section>
  </div>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- <script type="text/javascript" src="../../js/jquery-3.5.1.min.js"></script> -->
  <script  type="text/javascript">
    $(document).ready(function(){
        $("form").submit(function(){
          var email=$("#txtemail").val();
          var password=$("#txtpass").val()
          if (email=="") {
            alert("Mohon lengkapi kolom email anda terlebih dahulu!");
          }else{
            if (password=="") {
              alert("Mohon lengkapi kolom password anda terlebih dahulu!")
            }else{
              login(email,password);
            }
          }
          //buat ga ilang message errornya karena ke refresh
          event.preventDefault();
        });


        function login(email, password)
        {
            $.ajax({
                url:"php/login.php",
                method:"POST",
                data:{email:email, password:password},
                dataType:"json",
                success:function(data)
                {
                  if(data.status == "fail"){
                    $("#error").css("display", "block");
                    $("#error").text(data.message);
                  }else{
                    location.reload();
                  }
                }
            });
        }

        
        $(document).on('click','#password', function(){
          //untuk set ikon lihat password
          if ($('#password').data('check')=="no") {
            $('#txtpass').attr('type', 'text');
            $("#password").addClass("active");
            $('#password').data('check',"yes");
          }else{
            $('#txtpass').attr('type', 'password');
            $("#password").removeClass("active");
            $('#password').data('check',"no");
          }
        });
    });
  </script>

</body>
</html>
