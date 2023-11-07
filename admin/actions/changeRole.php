<?php


include("../../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Libs\Database\UsersTable;

$role = $_GET['role'];
$id = $_GET['id'];
$csrf =  $_GET['csrf'];
$auth = Auth::check();

$table = new UsersTable(new MySQL());

if($csrf === $_SESSION['csrf']){
    $table->changeRoleUser($id, $role);
    unset($_SESSION['csrf']);
    HTTP::redirect("admin/usersTable.php","change=true");
} else {
    unset($_SESSION['user']);
    unset($_SESSION['csrf']);
    HTTP::redirect("/index.php");
}
    
    