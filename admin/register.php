<?php


include("vendor/autoload.php");

use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Libs\Database\ProductsTable;

$table = new UsersTable(new MySQL());
$table1 = new ProductsTable(new MySQL());

if($_POST){
  if(!($_POST['name']) 
  || !($_POST['email']) 
  || !($_POST['password']) 
  || strlen($_POST['password']) < 8){
    if(!(($_POST['name']))){
      $nameNull = "Please fill the name";
    }
    if(!(($_POST['email']))){
      $emailNull = "Please fill the email";
    } 
    if(!(($_POST['password']))){
      $passwordNull = "Please fill the password";
    } 
    if(strlen($_POST['password']) < 8){
      $passwordLength = "Your password must have at least 8 characters";
    }
 } else {
    $name = $table1->h($_POST['name']);
    $email = $table1->h($_POST['email']);
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT) ;
    $checkEmail = $table->checkEmail($email);
    if($checkEmail){
        HTTP::redirect("/register.php","havingEmail=true");
    }
    // $table->registerUser($name, $email, $password);
    
    HTTP::redirect("/index.php","success=true");
  }
}
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width: 400px !important;">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <div class="h1"><b>Blog</b></div>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register your account</p>

      <form action="register.php" method="post">
            <?php if(isset($_GET['havingEmail'])): ?>
                <div class="alert alert-warning">Your Email is already have.</div>
            <?php endif ?> 
            <?php if(isset($nameNull)) : ?>
                <p class="text-danger">*<?= $nameNull ?> </p>
            <?php endif ?>                        
            <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" placeholder="Full name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <?php if(isset($emailNull)) : ?>
              <p class="text-danger">*<?= $emailNull ?> </p>
          <?php endif ?>                        
          <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <?php if(isset($passwordNull)) : ?>
            <p class="text-danger">*<?= $passwordNull ?> </p>
        <?php endif ?>                        
        <?php if(isset($passwordLength)) : ?>
            <p class="text-danger">*<?= $passwordLength ?> </p>
        <?php endif ?>                        
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
    </form>

      <a href="index.php" class="text-center">I already have an account.</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
// $(function () {
//   $.validator.setDefaults({
//     submitHandler: function () {
//       alert( "Form successful submitted!" );
//     }
//   });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 8
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
</script>  
</body>
</html>
