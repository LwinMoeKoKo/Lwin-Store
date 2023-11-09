<?php

include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

$auth = Auth::check();

$table = new ProductsTable(new MySQL());
 

