<?php
require("../vendor/autoload.php");

use Helpers\HTTP;
use Helpers\Auth;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Libs\Database\UsersTable;
// print "<pre>";
// print_r($_SESSION);
// exit();    
$auth = Auth::adminCheck();

$table = new ProductsTable(new MySQL());
$table1 = new UsersTable(new MySQL());
$pageN0 = 1;

$link = $_SERVER['PHP_SELF'];
$linkArray = explode("/", $link);
$page = end($linkArray);

if (isset($_POST['name'])) {
  setcookie("name", $_POST['name'], time() + 86400, "/");
} else if ($page === "usersTable.php") {
  setcookie("name", "", time() - 1, "/");
}



$allUsers = $table1->getUsers();
$token = $table->tokenCsrf();
if (!isset($_POST['name']) && !isset($_COOKIE['name'])) {
  $allUsers = $table1->getUsers();
  if (isset($_GET['pageNo'])) {
    global $pageNO;
    $pageN0 = $_GET['pageNo'];
  } else {
    $pageN0 = 1;
  }
  $offset = 10;
  $start = ($pageN0 - 1) * $offset;
  $totalPages = ceil(count($allUsers) / $offset);

  $allUserLimit = $table1->getUsersLimit($start, $offset);
} else {
  $name = $_POST['name'] ?? $_COOKIE['name'];
  if (isset($_GET['pageNo'])) {
    global $pageNO;
    $pageN0 = $_GET['pageNo'];
  } else {
    $pageN0 = 1;
  }
  $allUsers = $table1->searchUsers($name);
  $offset = 10;
  $start = ($pageN0 - 1) * $offset;
  $totalPages = ceil(count($allUsers) / $offset);

  $allUserLimit = $table1->searchUsersLimit($name, $start, $offset);
}

// print "<pre>";
// print_r($totalPages);
// print_r($allUserLimit);

// $pageN0 = 1;
// if(isset($_POST['name'])){
//   setcookie("name",$_POST['name'],time()+86400,"/");
// } else {
//   if(!isset($_GET['pageNo'])){
//    setcookie("name","",time()-1,"/");
//   }
// };

// if(isset($_GET['pageNo'])){
//   global $pageN0;
//   $pageN0 = $_GET['pageNo'];
// } else {
//   $pageN0 = 1;
// }

// $allUsers = $table->getUsers();
//  if(!isset($_POST['name']) && !isset($_COOKIE['name'])) {
//   $offset = 5;
//   $totalPages =  ceil(count($allUsers) / $offset);
//   $start = ($pageN0-1) * $offset;
//   $limitUsers = $table->getUserLimit($start,$offset);

//   $token = $table->tokenCsrf();
// } else {
//     $name = $_POST['name'] ?? $_COOKIE['name'];
//     $users = $table->searchUser($name);

//     $offset = 1;
//     $totalPages =  ceil(count($users) / $offset);
//     $start = ($pageN0-1) * $offset;
//     $limitUsers = $table->searchUserLimit($name,$start,$offset); 

//     $token = $table->tokenCsrf();

// }



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
  <title>Users Table Page</title>

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
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline" action="usersTable.php" method="post">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" name="name" type="search" placeholder="Search user" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="submit" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>


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
            <a href="#" class="d-block text-decoration-none">Admin <?= $table->h($auth->name) ?></a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <form action="usersTable.php" method="post">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search User" aria-label="Search" name="name">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </form>
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
                    <p>All Admins & Users
                      <span class="badge badge-danger right"><?= count($allUsers) ?></span>
                    </p>
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
            <div class="container-fluid">
              <div class="flex-fill"></div>
              <div class="float-right">
                <a class="btn btn-outline-dark" href="addUser.php">Add User</a>
              </div>
            </div>
            <div class="col">
              <!-- <h1 class="my-3 h4">Manage User and Admins</h1> -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold">Manage User and Admins <span class="right badge badge-danger ms-2"><?= count($allUsers) ?></span></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <?php if (isset($_GET['change'])) : ?>
                    <div class="alert alert-success">User account change role successfully. </div>
                  <?php endif ?>
                  <?php if (isset($_GET['add'])) : ?>
                    <div class="alert alert-success">User account added successfully. </div>
                  <?php endif ?>
                  <?php if (isset($_GET['delete'])) : ?>
                    <div class="alert alert-secondary">User account deleted successfully. </div>
                  <?php endif ?>
                  <?php if (isset($_GET['notFound'])) : ?>
                    <div class="alert alert-primary">User is not found on database. </div>
                  <?php endif ?>
                  <?php if (isset($_GET['edit'])) : ?>
                    <div class="alert alert-info">User account edited successfully. </div>
                  <?php endif ?>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px"><i class="fas fa-hashtag"></i></th>
                        <th><i class="fas fa-user-graduate me-1"></i>Name</th>
                        <th><i class="fas fa-mail-bulk me-1"></i>Email</th>
                        <th><i class="fas fa-user-shield me-1"></i>Role</th>
                        <th><i class="fas fa-edit me-1">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($allUserLimit as $user) : ?>
                        <tr>
                          <td><?= $i ?> </td>
                          <td><?= $table->h($user->name)  ?></td>
                          <td><?= $table->h($user->email)  ?></td>
                          <td>
                            <?php if ($user->role === 1) : ?>
                              <span class="badge bg-gradient-danger">Admin</span>
                            <?php else : ?>
                              <span class="badge bg-gradient-fuchsia">User</span>
                            <?php endif ?>
                          </td>
                          <td>
                            <div class="btn-group btn-group-sm">
                              <button class="btn btn-primary dropdown dropdown-toggle" data-bs-toggle="dropdown">Change Role</button>
                              <ul class="dropdown-menu dropdown-menu-dark">
                                <li class="dropdown-item">
                                  <a href="actions/changeRole.php?id=<?= $user->id ?>&role=1&csrf=<?= $token ?> " class="text-white text-decoration-none">Admin</a>
                                </li>
                                <li class="dropdown-item">
                                  <a href="actions/changeRole.php?id=<?= $user->id ?>&role=0&csrf=<?= $token ?> " class="text-white text-decoration-none">User</a>
                                </li>
                              </ul>
                              <a href="editUser.php?id=<?= $user->id ?>" class="btn btn-warning">Edit</a>
                              <?php if ($auth->id !== $user->id) : ?>
                                <a href="actions/deleteUser.php?id=<?= $user->id ?>&csrf=<?= $token ?>" class="btn btn-danger" onclick="return confirm('Are You Sure?')">Delete</a>
                              <?php endif ?>
                            </div>
                          </td>
                        </tr>
                        <?php $i++ ?>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                  <nav class="float-right mt-2">
                    <ul class="pagination">
                      <li class="page-item "><a href="?pageNo=1" class="page-link">First</a></li>
                      <li class="page-item <?php if ($pageN0 <= 1) echo "disabled" ?>">
                        <a href="<?php if ($pageN0 <= 1) {
                                    echo "#";
                                  } else {
                                    print("?pageNo=" . $pageN0 - 1);
                                  } ?>" class="page-link">Previous</a>
                      </li>
                      <li class="page-item"><a href="#" class="page-link"><?= $pageN0 ?></a></li>
                      <li class="page-item <?php if ($pageN0 >= $totalPages) echo "disabled" ?>">
                        <a href=" <?php if ($pageN0 >= $totalPages) {
                                    echo "#";
                                  } else {
                                    print("?pageNo=" . $pageN0 + 1);
                                  } ?>" class="page-link">Next</a>
                      </li>
                      <li class="page-item"><a href="?pageNo=<?= $totalPages ?>" class="page-link">Last</a></li>
                    </ul>
                  </nav>
                </div>
                <!-- /.card-body -->
              </div>
            </div><!-- /.col -->

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>