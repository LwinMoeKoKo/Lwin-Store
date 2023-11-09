<?php

include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();

unset($_SESSION['cart']);

HTTP::redirect("shopping-cart.php");