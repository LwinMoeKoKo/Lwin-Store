<?php

include("../../vendor/autoload.php");

session_start();

use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Libs\Database\ProductsTable;

$table1 = new ProductsTable(new MySQL());

$email = $_POST['email'];
$password = $_POST['password'];
$csrf = $_POST['csrf'];

$table1->tokenCheck($csrf);


if(!$_POST['email']){
    $error = "Please Fill the email";
    HTTP::redirect("index.php","nullEmail=$error");
} elseif(!$_POST['password']){
    $error = "Please Fill the password";
    HTTP::redirect("index.php","nullPassword=$error");
}

$table = new UsersTable(new MySQL());

$user = $table->checkEmail($email);
$dbPassword = $user->password;

if($user &&  password_verify($password, $dbPassword)){
    session_start();
    $_SESSION['user'] = $user;
    if($user->role === 1){
        HTTP::redirect("admin/admin.php");
    } elseif($user->role === 0){
        HTTP::redirect("home.php");
    }
} else {
    HTTP::redirect("index.php","false=true");
}
        

