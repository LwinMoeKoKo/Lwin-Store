<?php

include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();

$id = $_GET['id'];
unset($_SESSION['cart']["id=$id"]);

HTTP::redirect("shopping-cart.php");