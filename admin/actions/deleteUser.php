<?php


include("../../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$auth = Auth::check();
$table = new UsersTable(new MySQL());

$id = $_GET['id'];
if($_GET['csrf'] === $_SESSION['csrf']){
    $table->deleteUser($id);
    
    HTTP::redirect("admin/usersTable.php","delete=true");
} else {
    unset($_SESSION['user']);
    unset($_SESSION['csrf']);
    HTTP::redirect("index.php");
}
       
