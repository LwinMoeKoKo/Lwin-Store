<?php
require("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Libs\Database\ProductsTable;

$auth = Auth::check();

$table = new ProductsTable(new MySQL());
$table1 = new UsersTable(new MySQL());
$token = $table->tokenCsrf();

if ($_POST) {
  if (
    !($_POST['name'])
    || !($_POST['email'])
    || !($_POST['password'])
    || strlen($_POST['password']) < 8
  ) {
    if (!(($_POST['name']))) {
      $nameNull = "Please fill the name";
    }
    if (!(($_POST['email']))) {
      $emailNull = "Please fill the email";
    }
    if (!(($_POST['password']))) {
      $passwordNull = "Please fill the password";
    }
    if (strlen($_POST['password']) < 8) {
      $passwordLength = "Your password must have at least 8 characters";
    }
  } else {
    $table->tokenCheck($_POST['csrf']);
    $name = $table->h($_POST['name']);
    $email = $table->h($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 0;
    $checkEmail = $table1->checkEmail($email);
    if ($checkEmail) {
      HTTP::redirect("admin/addUser.php", "havingEmail=true");
    }

    if ($_POST['role'] === "yes") {
      global $role;
      $role = 1;
    } else {
      $role = 0;
    }

    $data = [
      "name" => $name,
      "email" => $email,
      "password" => $password,
      'role' => $role,
    ];

    $table1->registerUser($data);
    HTTP::redirect("usersTable.php", "add=true");
  }
}



?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Add User Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/bootstrap.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>          
      <!-- Left navbar links -->
      <!-- Right navbar links -->
      <!-- <ul class="navbar-nav ml-auto"> -->
        <!-- Navbar Search -->
        <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->


      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link text-decoration-none">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">BlogAdmin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block text-decoration-none">Admin <?= $auth->name ?></a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="admin.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Products
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="admin.php" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                      All Products
                    </p>
                  </a>
                <li class="nav-item">
                  <a href="productAdd.php" class="nav-link">
                    <i class="nav-icon fas fa-plus-circle"></i>
                    <p>Add Product</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="categories.php" class="nav-link">
                <i class="nav-icon fas fa-list-alt"></i>
                <p>
                  Categories
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="categories.php" class="nav-link">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>
                      All Categories
                    </p>
                  </a>
                <li class="nav-item">
                  <a href="CategoriesAdd.php" class="nav-link">
                    <i class="nav-icon fas fa-plus-circle"></i>
                    <p>Add Categories</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="ordersTable.php" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>Orders</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="usersTable.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Admins & Users</p>
                <i class="fas fa-angle-left right"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="usersTable.php" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>All Admins & Users</p>
                  </a>
                <li class="nav-item">
                  <a href="addUser.php" class="nav-link">
                    <i class="nav-icon fas fa-user-plus"></i>
                    <p>Add user</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="weekly_report.php" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>Reports</p>
                <i class="fas fa-angle-left right"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="weekly_report.php" class="nav-link">
                    <i class="nav-icon fas fa-sort-amount-up"></i>
                    <p>Weekly Report</p>
                  </a>
                <li class="nav-item">
                  <a href="monthly_report.php" class="nav-link">
                    <i class="nav-icon fas fa-jedi"></i>
                    <p>Monthly Report</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="top_customer.php" class="nav-link">
                    <i class="nav-icon fas fa-heart"></i>
                    <p>Platinum Members</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="best_seller.php" class="nav-link">
                    <i class="nav-icon fas fa-money-bill-wave"></i>
                    <p>Best Seller</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="actions/logout.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col">
              <div class="card">

                <!-- /.card-header -->
                <div class="card-body">
                  <div class="card card-danger w-50">
                    <div class="card-header">
                      <h3 class="card-title">Add User OR Admin</h3>
                    </div>
                    <div class="card-body  bg-gradient">
                      <form id="quickForm" action="addUser.php" method="post" enctype="multipart/form-data">
                        <?php if (isset($_GET['havingEmail'])) : ?>
                          <div class="alert alert-warning">Your Email is already have.</div>
                        <?php endif ?>
                        <input type="hidden" name="csrf" value="<?= $token ?>">
                        <div class="mb-3">
                          <label for="Name" class="form-label">Name</label>
                          <?php if (isset($nameNull)) : ?>
                            <p class="text-danger">*<?= $nameNull ?> </p>
                          <?php endif ?>
                          <input type="text" class="form-control" id="Name" name="name" placeholder="Name">
                          <div class="valid-feedback">Valid</div>
                          <div class="invalid-feedback">Please fill the user name</div>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Email</label>
                          <?php if (isset($emailNull)) : ?>
                            <p class="text-danger">*<?= $emailNull ?> </p>
                          <?php endif ?>
                          <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder=" Email">
                          <div class="valid-feedback">Valid</div>
                          <div class="invalid-feedback">Please fill the user email</div>
                        </div>
                        <!-- <div class="mb-3">
                               <label for="address" class="form-label">Address</label>
                               <?php if (isset($addressNull)) : ?>
                                  <p class="text-danger">*<?= $addressNull ?> </p>
                                <?php endif ?>
                               <input type="address" class="form-control" id="address" name="address" placeholder=" address">
                               <div class="valid-feedback">Valid</div>
                               <div class="invalid-feedback">Please fill the user address</div>
                             </div>
                             <div class="mb-3">
                               <label for="phone" class="form-label">Phone</label>
                               <?php if (isset($phoneNull)) : ?>
                                  <p class="text-danger">*<?= $phoneNull ?> </p>
                                <?php endif ?>
                               <input type="phone" class="form-control" id="phone" name="phone" placeholder="phone">
                               <div class="valid-feedback">Valid</div>
                               <div class="invalid-feedback">Please fill the user phone</div>
                             </div> -->
                        <div class="mb-3">
                          <label for="Password" class="form-label">Password</label>
                          <?php if (isset($passwordNull)) : ?>
                            <p class="text-danger">*<?= $passwordNull ?> </p>
                          <?php endif ?>
                          <?php if (isset($passwordLength)) : ?>
                            <p class="text-danger">*<?= $passwordLength ?> </p>
                          <?php endif ?>
                          <input type="password" class="form-control" id="Password" name="password" placeholder=" Password">
                          <div class="valid-feedback">Valid</div>
                          <div class="invalid-feedback">Please fill the user password</div>
                        </div>
                        <div class="mb-3 form-switch">
                          <input type="checkbox" class="form-check-input" id="role" name="role" value="yes">
                          <label for="role" class="form-check-label">Admin</label>
                          <!-- <div class="valid-feedback">Admin</div>
                                 <div class="invalid-feedback">User</div> -->
                        </div>

                        <!-- <?php if (isset($_GET['error'])) : ?>
                              <div class="alert alert-danger">Your photo cannot be uploaded. </div>
                              <?php endif ?>
                             <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fas fa-file-image"></i>
                                </div>
                                <input type="file" class="form-control" name="image">
                                <a href="#" class="btn btn-primary">Upload</a>
                             </div> -->
                        <button type="submit" class="btn btn-outline-danger">Add</button>
                        <a href="usersTable.php" class="btn btn-outline-dark">Back</a>
                      </form>

                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->


                </div>
                <!-- /.card-body -->
              </div>
            </div><!-- /.col -->

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>



      <!-- /.content-header -->
      <!-- Main Footer -->
      <!-- <footer class="main-footer">
      <div class="float-right">
        Blog App
      </div> -->
      <!-- Default to the left -->
      <!-- <div class="float-left">
        <strong>Copyright &copy; 2024 <a href="#">AdminLwinKo</a>.</strong> All rights reserved.
      </div>
    </footer> -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->

    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
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
          name: {
            required: true,
            text: true,
          }
        },
        messages: {
          email: {
            required: "Please enter a email address",
            email: "Please enter a valid email address"
          },
          name: {
            required: "Please enter your name",
            Text: "Please enter your name"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 8 characters long"
          },

          terms: "Please accept our terms"
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.check').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    </script>
</body>

</html>