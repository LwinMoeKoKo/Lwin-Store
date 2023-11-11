<?php
require("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\CategoriesTable;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

$auth = Auth::adminCheck();

$table1 = new ProductsTable(new MySQL());
$table = new CategoriesTable(new MySQL());

$token = $table1->tokenCsrf();
$allCategories = $table->allCategories();

if (isset($_GET['id'])) {
  $product = $table1->getProduct($_GET['id']);
}

if ($_POST) {
  if (!($_POST['name']) || !($_POST['description']) || !($_POST['quantity']) 
      || !($_POST['price'])  || !($_POST['category'])) {
    if (!($_POST['name'])) {
      $nameNull = "Please fill the product name";
    }
    if (!($_POST['description'])) {
      $descriptionNull = "Please fill the product description";
    }
    if (!($_POST['quantity'])) {
      $quantityNull = "Please fill the product quantity";
    } 
    if (!($_POST['category'])) {
      $categoryNull = "Please select the product category";
    }
    if (!($_POST['price'])) {
      $priceNull = "Please fill the product price";
    } 
    if (!($_FILES['image'])) {
      $imageNull = "Please fill the product image";
    }
  } else {
    // print "<pre>";
    // var_dump($_POST);
    // print(is_numeric($_POST['price']));
    // print(is_numeric($_POST['quantity']));
    
    if (is_numeric($_POST['price']) != 1) {
      $priceNotInt = "Product price should be integer value";
    }
    if (is_numeric($_POST['quantity']) != 1) {
      $quantityNotInt = "Product Quantity should be integer value";
    }
    if($priceNotInt == null && $quantityNotInt == null){
      if($_FILES['image']['name'] != null){
          exit();    
          $id = $_POST['id'];
          $name = $_POST['name'];
          $description = $_POST['description'];
          $category_id = $_POST['category'];
          $quantity = $_POST['quantity'];
          $price = $_POST['price'];
          $imgName = $_FILES['image']['name'];
          $imgTmp =  $_FILES['image']['tmp_name'];
          $imgType =  $_FILES['image']['type'];
      
          if (
            $imgError && $imgType !== "image/jpeg"
            && $imgType !== "image/jpg" && $imgType !== "png"
          ) {
            if ($imgError) {
              $imgErr = "Product photo can not be uploaded.";
            }
            if ($imgType !== "image/jpeg"  && $imgType !== "image/jpg" && $imgType !== "png") {
              $imgTypeErr = "Product photo type must be jpeg,jpg or png.";
            }
          } else {
            $table1->token();
            move_uploaded_file($imgTmp, "actions/photos/$imgName");
      
            $data = [
              ':name' => $name,
              ':description' => $description,
              ':quantity' => $quantity,
              ':category_id' => $category_id,
              ':price' => $price,
              ':image' => $imgName ?? $product->image,
              ':id' => $id,
            ];
      
            $table1->editProductWithImage($data);
            HTTP::redirect("admin/admin.php", "edit=true");
          }
        } else {
      
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category_id = $_POST['category'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
              $table1->token();
        
              $data = [
                ':name' => $name,
                ':description' => $description,
                ':quantity' => $quantity,
                ':category_id' => $category_id,
                ':price' => $price,
                ':id' => $id,
              ];
        
              $table1->editProduct($data);
              HTTP::redirect("admin/admin.php", "edit=true");
        }

    }
    $product = $table1->getProduct($_POST['id']);
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
  <title>Admin Edit User Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../phpCRUD/css/bootstrap.css">
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
            <a href="#" class="d-block text-decoration-none">Admin <?= $table1->h($auth->name) ?></a>
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
                    <p>All Admins & Users
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
                  <div class="card card-danger w-75">
                    <div class="card-header">
                      <h3 class="card-title">Edit Product</h3>
                    </div>
                    <div class="card-body  bg-gradient">
                      <form action="productEdit.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf" value="<?= $token ?>">
                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <div class="mb-3">
                          <label for="Product Name" class="form-label">Product Name</label>
                          <?php if (isset($nameNull)) : ?>
                            <p class="text-danger">*<?= $nameNull ?></p>
                          <?php endif ?>
                          <input type="text" class="form-control" name="name" id="Product Name" value="<?= $product->name ?>">
                        </div>
                        <div class="mb-3">
                          <label for="description" class="form-label">description</label><br>
                          <?php if (isset($descriptionNull)) : ?>
                            <p class="text-danger">*<?= $descriptionNull ?></p>
                          <?php endif ?>
                          <textarea name="description" id="description" cols="30" rows="5" class="form-control"><?= $product->description ?></textarea>
                        </div>
                        <div class="mb-3">
                          <label for="category" class="form-label">category</label><br>
                          <?php if (isset($categoryNull)) : ?>
                            <p class="text-danger">*<?= $categoryNull ?></p>
                          <?php endif ?>
                          <select class="form-control" name="category" id="category">
                            <!-- <option value="">Select Category</option> -->
                            <?php foreach ($allCategories as $category) : ?>
                              <?php if ($category->id === $product->category_id) : ?>
                                <option value="<?= $category->id ?>" selected><?= $category->name ?> </option>
                              <?php else : ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                              <?php endif ?>
                            <?php endforeach ?>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label for="quantity" class="form-label">Product Quantity</label>
                          <?php if (isset($quantityNull)) : ?>
                            <p class="text-danger">*<?= $quantityNull ?></p>
                          <?php endif ?>
                          <?php if (isset($quantityNotInt)) : ?>
                            <p class="text-danger">*<?= $quantityNotInt ?></p>
                          <?php endif ?>
                          <input type="text" class="form-control" name="quantity" id="quantity" value="<?= $product->quantity ?>">
                        </div>
                        <div class="mb-3">
                          <label for="price" class="form-label">Product Price</label>
                          <?php if (isset($priceNull)) : ?>
                            <p class="text-danger">*<?= $priceNull ?></p>
                          <?php endif ?>
                          <?php if (isset($priceNotInt)) : ?>
                            <p class="text-danger">*<?= $priceNotInt ?></p>
                          <?php endif ?>
                          <div class="input-group">
                            <div class="input-group-text">
                              <i class="fas fa-dollar-sign"></i>
                            </div>
                            <input type="text" class="form-control" name="price" id="price" value="<?= $product->price ?>">
                          </div>
                        </div>
                        <?php if (isset($imageRequire)) : ?>
                          <p class="text-danger">*<?= $imageRequire ?></p>
                        <?php endif ?>
                        <?php if (isset($imageNull)) : ?>
                          <p class="text-danger">*<?= $imageNull ?></p>
                        <?php endif ?>
                        <?php if (isset($imgErr)) : ?>
                          <p class="text-danger">*<?= $imgErr ?></p>
                        <?php endif ?>
                        <?php if (isset($imgTypeErr)) : ?>
                          <p class="text-danger">*<?= $imgTypeErr ?></p>
                        <?php endif ?>
                        <img src="../admin/actions/photos/<?= $product->image ?>" alt="product image" class="img-thumbnail w-25 h-50 mb-2">
                        <div class="input-group mb-3">
                          <div class="input-group-text">
                            <i class="fas fa-file-image"></i>
                          </div>
                          <input type="file" class="form-control" name="image" value="<?= $product->image ?>">
                          <!-- <a href="#" class="btn btn-primary">Upload</a> -->
                        </div>
                        <button type="submit" class="btn btn-outline-danger">Edit</button>
                        <a href="admin.php" class="btn btn-outline-dark">Back</a>
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

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../phpCRUD/js/bootstrap.bundle.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>