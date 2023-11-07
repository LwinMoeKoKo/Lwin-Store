<?php


include("../vendor/autoload.php");

use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Libs\Database\PostsTable;

$table = new UsersTable(new MySQL());


if($_POST){
  if(!($_POST['name']) 
  || !($_POST['email']) 
  || !($_POST['password']) 
  || strlen($_POST['password']) < 8){
    if(!(($_POST['name']))){
      $nameNull = "Please fill the name";
    }
    if(!(($_POST['email']))){
      $emailNull = "Please fill the email";
    } 
    if(!(($_POST['password']))){
      $passwordNull = "Please fill the password";
    } 
    if(strlen($_POST['password']) < 8){
      $passwordLength = "Your password must have at least 8 characters";
    }
 } else {
    $name = $table1->h($_POST['name']);
    $email = $table1->h($_POST['email']);
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT) ;
    $checkEmail = $table->checkEmail($email);
    if($checkEmail){
        HTTP::redirect("/register.php","havingEmail=true");
    }
    // $table->registerUser($name, $email, $password);
    HTTP::redirect("/index.php","success=true");
  }
}
    
 ?> 
   

