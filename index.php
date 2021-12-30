<?php 
  session_start();
  if(isset($_SESSION['iduser'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Chatto | Daftar </header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text" id="error"></div>
        <div class="field input">
            <label>Nama</label>
            <input type="text" name="name" id="txtname" placeholder="Masukkan nama anda" required>
        </div>
        <div class="field input">
          <label>Alamat Email</label>
          <input type="text" name="email" id="txtemail" placeholder="Masukkan email anda" required>
        </div>
        <div class="field input">
          <label>Kata sandi</label>
          <input type="password" name="password" id="txtpass" placeholder="Masukkan kata sandi baru" required>
          <i class="fas fa-eye" id="password"></i>
        </div>
        <div class="field image">
          <label>Pilih gambar</label>
          <input type="file" id="image" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Mendaftar">
        </div>
      </form>
      <div class="link">Sudah terdaftar? <a href="login.php">Masuk</a></div>
    </section>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
        $("form").submit(function(){
          //buat ga ilang message errornya karena ke refresh
          event.preventDefault();
          var formData = new FormData(this);
          $.ajax({
              type:'POST',
              url: "php/register.php",
              data:formData,
              dataType:"json",
              cache:false,
              contentType: false,
              processData: false,
              success:function(data){
                if(data.status == "fail"){
                  $("#error").css("display", "block");
                  $("#error").text(data.message);
                }else{
                  location.reload();
                }
              },
              error: function(data){
                  alert("error");
              }
          });
        });
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
