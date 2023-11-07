<?php


include("../../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Libs\Database\PostsTable;
// print "<pre>";
// print_r($_POST);
// print_r($_FILES);
// exit(); 
$table = new UsersTable(new MySQL());
$auth = Auth::check();
// print "<pre>";
// print_r($_POST);
// print_r($_FILES);
// exit();    


// if($_POST){
//     if(empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])){
//         HTTP::redirect("/create.php","Required=true");
//     } else {
//         $table1->tokenCheck($_POST['csrf']);
//         $title = $table1->h($_POST['title']) ;
//         $content = $table1->h($_POST['content']);  
//         $imgName = $table1->h($_FILES['image']['name']);
//         $imgError = $_FILES['image']['error'];
//         $imgTmp = $_FILES['image']['tmp_name'];
//         $imgType = $_FILES['image']['type'];
//         if($imgError){
//             HTTP::redirect("/create.php","error=file");
//         }
//         if($imgType === "image/jpeg" ||
//         $imgType === "image/jpg" ||
//         $imgType === "image/png" ){
//             move_uploaded_file($imgTmp, "photos/$imgName");
//                 $table->createPost($title,$content,$imgName,$auth->id);
//                 HTTP::redirect("/admin.php","createSuccess=true");
//             } else {
//                 HTTP::redirect("/create.php","error=type");
//             }
//         }
// }
        
            







