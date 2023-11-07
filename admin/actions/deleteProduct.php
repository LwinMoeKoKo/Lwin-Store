<?php


include("../../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

$auth = Auth::check();
$table = new ProductsTable(new MySQL());

$id = $_GET['id'];
$csrf = $_GET['csrf'];

if($csrf === $_SESSION['csrf']){
    $table->deleteProduct($id);
    HTTP::redirect("admin/admin.php","delete=true");
} else {
    unset($_SESSION['csrf']);
    unset($_SESSION['user']);
    HTTP::redirect("index.php");
}