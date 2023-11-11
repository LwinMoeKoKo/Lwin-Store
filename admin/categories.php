<?php
require("../vendor/autoload.php");

use Helpers\Auth;
use Libs\Database\CategoriesTable;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

// print "<pre>";
// print_r($_SESSION);
// exit();    
$auth = Auth::adminCheck();

$table1 = new ProductsTable(new MySQL());

$table = new CategoriesTable(new MySQL());

$pageN0 = 1;

$token = $table1->tokenCsrf();

if (isset($_POST['Cat_title'])) {
  setcookie("Cat_title", $_POST['Cat_title'], time() + 86400, "/");
} elseif (!isset($_GET['pageNo'])) {
  setcookie("Cat_title", "", time() - 1, "/");
};

if (!isset($_POST['Cat_title']) && !isset($_COOKIE['Cat_title'])) {
  $allCategories = $table->allCategories();
  if (isset($_GET['pageNo'])) {
    $pageN0 = $_GET['pageNo'];
  } else {
    global $pageN0;
    $pageNO = 1;
  }
  
  $numOfRecords = 10;
  $offset = ($pageN0 - 1) * $numOfRecords;
  $totalPages = ceil(count($allCategories) / $numOfRecords);
  
  $limitCategories = $table->allCategoriesLimit($offset, $numOfRecords);
} else {
  $Cat_title = $_POST['Cat_title'] ?? $_COOKIE['Cat_title'];
  if (isset($_GET['pageNo'])) {
    $pageN0 = $_GET['pageNo'];
  } else {
    global $pageN0;
    $pageNO = 1;
  }
  // $csrfToken = $_POST['csrf'];

  // $table1->tokenCheck($csrfToken);
  $allCategories = $table->searchCategory($Cat_title);

  $numOfRecords = 10;
  $offset = ($pageN0 - 1) * $numOfRecords;
  $totalPages = ceil(count($allCategories) / $numOfRecords);

  $limitCategories = $table->searchCategoryLimit($Cat_title, $offset, $numOfRecords);
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
  <title>Admin Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline" action="categories.php" method="post">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" name="Cat_title" type="search" placeholder="Search Category" aria-label="Search">
                <input type="hidden" name="csrf" value="<?= $token ?>">
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
        </li>


      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Online Store Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Admin <?= $table1->h($auth->name)  ?></a>
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
                      <span class="badge badge-danger right"><?= count($allCategories) ?></span>
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



              <h1 class="my-3">Categories Table</h1>
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Categories <span class="right badge badge-danger ms-2"><?= count($allCategories) ?></span></h3>
                  <a href="CategoriesAdd.php" class="btn btn-outline-success float-right">Create New</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <?php if (isset($_GET['editSuccess'])) : ?>
                    <div class="alert alert-success">Your category edited successfully. </div>
                  <?php endif ?>
                  <?php if (isset($_GET['addSuccess'])) : ?>
                    <div class="alert alert-success">Your category added successfully. </div>
                  <?php endif ?>
                  <?php if (isset($_GET['notFound'])) : ?>
                    <div class="alert alert-primary">category is not found on database. </div>
                  <?php endif ?>
                  <?php if (isset($_GET['delete'])) : ?>
                    <div class="alert alert-secondary">category deleted successfully. </div>
                  <?php endif ?>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px"><i class="fas fa-hashtag"></i></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($limitCategories as $category) : ?>
                        <tr>
                          <td><?= $i ?> </td>
                          <td><?= $table1->h($category->name) ?></td>
                          <td><?= $table1->h(substr($category->description, 0, 70))   ?>...</td>
                          <td>

                            <a href="CategoriesEdit.php?id=<?= $category->id ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                            <a href="actions/deleteCategory.php?id=<?= $category->id ?>&csrf=<?= $token ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are You Sure?')"><i class="fas fa-trash"></i></a>

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
      <!-- Main Footer -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../phpCRUD/js/bootstrap.bundle.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>





