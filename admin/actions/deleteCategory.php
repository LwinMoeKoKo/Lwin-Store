<?php


include("../../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\CategoriesTable;
use Libs\Database\MySQL;

$table = new CategoriesTable(new MySQL());

$auth = Auth::check();

$id = $_GET['id'];
$csrf = $_GET['csrf'];

if($csrf === $_SESSION['csrf']){
    $table->deleteCategory($id);
    unset($_SESSION['csrf']);
    HTTP::redirect("admin/categories.php","delete=true");
} else {
    unset($_SESSION['user']);
    unset($_SESSION['csrf']);
    HTTP::redirect("index.php");
}


// if($_GET['csrf'] === $_SESSION['csrf']){
//     $table->deletePost($id);
    
//     HTTP::redirect("/admin.php","delete=true");   
// } else {
//     unset($_SESSION['user']);
//     unset($_SESSION['csrf']);
//     HTTP::redirect("/index.php");
// }