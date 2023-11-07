<?php
session_start();
include("../../vendor/autoload.php");

use Helpers\HTTP;

// print_r($_SESSION['user']);
unset($_SESSION['user']);
HTTP::redirect('index.php');