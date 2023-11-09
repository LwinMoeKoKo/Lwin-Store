<?php
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

$table = new ProductsTable(new MySQL());
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from preview.colorlib.com/theme/cozastore/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Oct 2023 01:41:44 GMT -->
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="images/icons/favicon.png" />

<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">

<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">

<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">

<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">

<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">

<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">

<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">

<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">

<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">

<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">

<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="admin/dist/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="admin/plugins/fontawesome-free/css/all.css">
<style>
	a{
		text-decoration: none !important;
	}
</style>

<script nonce="058126a7-81c1-4476-a935-85c37bf6bd98">(function(w,d){!function(bb,bc,bd,be){bb[bd]=bb[bd]||{};bb[bd].executed=[];bb.zaraz={deferred:[],listeners:[]};bb.zaraz.q=[];bb.zaraz._f=function(bf){return async function(){var bg=Array.prototype.slice.call(arguments);bb.zaraz.q.push({m:bf,a:bg})}};for(const bh of["track","set","debug"])bb.zaraz[bh]=bb.zaraz._f(bh);bb.zaraz.init=()=>{var bi=bc.getElementsByTagName(be)[0],bj=bc.createElement(be),bk=bc.getElementsByTagName("P_name")[0];bk&&(bb[bd].t=bc.getElementsByTagName("P_name")[0].text);bb[bd].x=Math.random();bb[bd].w=bb.screen.width;bb[bd].h=bb.screen.height;bb[bd].j=bb.innerHeight;bb[bd].e=bb.innerWidth;bb[bd].l=bb.location.href;bb[bd].r=bc.referrer;bb[bd].k=bb.screen.colorDepth;bb[bd].n=bc.characterSet;bb[bd].o=(new Date).getTimezoneOffset();if(bb.dataLayer)for(const bo of Object.entries(Object.entries(dataLayer).reduce(((bp,bq)=>({...bp[1],...bq[1]})),{})))zaraz.set(bo[0],bo[1],{scope:"page"});bb[bd].q=[];for(;bb.zaraz.q.length;){const br=bb.zaraz.q.shift();bb[bd].q.push(br)}bj.defer=!0;for(const bs of[localStorage,sessionStorage])Object.keys(bs||{}).filter((bu=>bu.startsWith("_zaraz_"))).forEach((bt=>{try{bb[bd]["z_"+bt.slice(7)]=JSON.parse(bs.getItem(bt))}catch{bb[bd]["z_"+bt.slice(7)]=bs.getItem(bt)}}));bj.referrerPolicy="origin";bj.src="../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(bb[bd])));bi.parentNode.insertBefore(bj,bi)};["complete","interactive"].includes(bc.readyState)?zaraz.init():bb.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body class="animsition">

<header>

<div class="container-menu-desktop">

<div class="wrap-menu-desktop">
<nav class="limiter-menu-desktop container">

<a href="#" class="logo">
<h3 class="logo text-dark text-uppercase"><span class="small font-weight-bold">Lwin </span>
	<span class="small">Store</span> </h3>
</a>

<div class="menu-desktop">
<ul class="main-menu">
<li class="active-menu">
<a href="home.php">Home</a>
</li>
<li>
<a href="product.html">Shop</a>
</li>
<li>
<a href="about.html">About</a>
</li>
<li>
<a href="contact.html">Contact</a>
</li>
</ul>
</div>

<div class="wrap-icon-header flex-w flex-r-m">
<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
<i class="zmdi zmdi-search"></i>
</div>
<?php 
	$totalCart = 0;
	if(isset($_SESSION['cart'])){
		foreach($_SESSION['cart'] as $cart){
			$totalCart += $cart;
		}
	}
?>
	  
<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?= $totalCart  ?>">
<i class="zmdi zmdi-shopping-cart"></i>
</div>
<a href="admin/actions/logout.php" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
<i class="zmdi zmdi-daydream-setting"></i>
</a>
</div>
</nav>
</div>
</div>

<div class="wrap-header-mobile">

<div class="logo-mobile">
    <h3 class="logo text-dark text-uppercase"><span class="small font-weight-bold">Lwin </span>
	<span class="small">Store</span> </h3>
</div>

<div class="wrap-icon-header flex-w flex-r-m m-r-15">
<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
<i class="zmdi zmdi-search"></i>
</div>
<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="<?= $totalCart  ?>">
<i class="zmdi zmdi-shopping-cart"></i>
</div>
</div>

<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
<span class="hamburger-box">
<span class="hamburger-inner"></span>
</span>
</div>
</div>

<div class="menu-mobile">
<ul class="main-menu-m">
	<li>
		<a href="home.php">Home</a>
<span class="arrow-main-menu-m">
<i class="fa fa-angle-right" aria-hidden="true"></i>
</span>
</li>
<li>
	<a href="product.html">Shop</a>
</li>
<li>
	<a href="about.html">About</a>
</li>
<li>
<a href="contact.html">Contact</a>
</li>
</ul>
</div>

<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
<div class="container-search-header">
<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
<img src="images/icons/icon-close2.png" alt="CLOSE">
</button>
<form action="home.php" class="wrap-search-header flex-w p-l-15" method="post">
<button class="flex-c-m trans-04">
<i class="zmdi zmdi-search"></i>
</button>
<input class="plh3" type="text" name="P_name" placeholder="Search...">
</form>
</div>
</div>
</header>
<div class="wrap-header-cart js-panel-cart">
<div class="s-full js-hide-cart"></div>
<div class="header-cart flex-col-l p-l-65 p-r-25">
<div class="header-cart-title flex-w flex-sb-m p-b-8">
<span class="mtext-103 cl2">
Your Cart
</span>
<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
<i class="zmdi zmdi-close"></i>
</div>
</div>
<div class="header-cart-content flex-w js-pscroll">
<ul class="header-cart-wrapitem w-full">
  <?php if(isset($_SESSION['cart'])) : ?>
	<?php 
		$totalPrice = 0;
		foreach($_SESSION['cart'] as $idKey => $cart) :
			$id = substr($idKey,3,4);

			$product = $table->getProduct($id);
			$totalPrice += $product->price * $cart;
	 ?>
  <li class="header-cart-item flex-w flex-t m-b-12">
	  <div class="header-cart-item-img">
		  <img src="admin/actions/photos/<?= $product->image ?>" alt="IMG">
		</div>
		<div class="header-cart-item-txt p-t-8">
			<a href="product-detail.php?id=<?= $product->id ?>" class="header-cart-item-name m-b-18 hov-cl1 trans-04 text-decoration-none">
				<?= $product->name ?>
			</a>
			<span class="header-cart-item-info">
			<?= $cart ?> x $<?= $product->price ?>
			</span>
		</div>
	</li>
	<?php endforeach ?>
	<?php endif ?>
</ul>
<div class="w-full">
	<div class="header-cart-total w-full p-tb-40 text-center">
		Total:  $<?= $totalPrice ?? 0 ?>
	</div>
	<div class="header-cart-buttons flex-w w-full">
		<a href="shopping-cart.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10 text-decoration-none">
			View Cart
		</a>
		<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10 text-decoration-none">
			Check Out
		</a>
	</div>
</div>
</div>
</div>
</div>
