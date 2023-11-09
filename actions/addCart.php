<?php

include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

$auth = Auth::check();

$table = new ProductsTable(new MySQL());


if($_POST){
    $id = $_POST['id'];
    $cartQuantity = $_POST['cart'];
    $csrf = $_POST['csrf'];
    
    $product = $table->checkQuantity($id);
    $quantity = $product->quantity;

    if($quantity > $cartQuantity){
        if(isset($_SESSION['cart']["id=$id"])){
            $_SESSION['cart']["id=$id"] += $cartQuantity;
        } else{
            $_SESSION['cart']["id=$id"] = $cartQuantity;
        }
        HTTP::redirect("home.php");
    } else {
        HTTP::redirect("product-detail.php","notEnough=true&id=$id");
    }
}
        





