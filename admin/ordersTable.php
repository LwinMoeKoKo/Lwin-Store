<?php
require("../vendor/autoload.php");

use Helpers\Auth;
use Libs\Database\MySQL;
use Libs\Database\OrdersTable;
use Libs\Database\ProductsTable;

// print "<pre>";
// print_r($_SESSION);
// exit();    
$auth = Auth::adminCheck();

$table = new ProductsTable(new MySQL());
$table1 = new OrdersTable(new MySQL());

$allOrders = $table1->getOrders();
$pageN0 = 1;

if(isset($_GET['id'])){
    global $pageN0;
    $pageN0 = $_GET['id'];
} else {
    $pageN0 = 1;
}

$offset = 10;
$start = ($pageN0-1) * $offset;
$totalPages = ceil(count($allOrders) / $offset);

$allOrdersLimit =  $table1->getOrdersLimit($start,$offset);
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
                        <a href="#" class="d-block">Admin <?= $table->h($auth->name)  ?></a>
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
                        <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li> -->
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



                            <h1 class="my-3">Orders Table</h1>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Orders<span class="right badge badge-danger ms-2"><?= count($allOrders) ?></span></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px"><i class="fas fa-hashtag"></i></th>
                                                <th>Name</th>
                                                <th>Total Price</th>
                                                <th>Order Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            ?>
                                            <?php foreach ($allOrdersLimit as $order) : ?>
                                                <tr>
                                                    <td><?= $i ?> </td>
                                                    <td><?= $table->h($order->name) ?></td>
                                                    <td><?= $table->h($order->total_price) ?></td>
                                                    <td><?= $table->h(date("Y-m-d"),strtotime($order->order_date)) ?></td>
                                                    <td>
                                                        <a href="ordersDetailsTable.php?id=<?= $order->id ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-search-plus"></i></a>
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
                                                <a href="<?php if ($pageN0 >= $totalPages) {
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
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="dist/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
</body>

</html>





