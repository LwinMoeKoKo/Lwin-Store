<?php 
include("vendor/autoload.php");

use Helpers\Auth;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Libs\Database\OrdersTable;

$auth = Auth::check();
$table = new OrdersTable(new MySQL());
$table1 = new ProductsTable(new MySQL());

if(isset($_SESSION['cart'])){
	$totalPrice = 0;
	foreach($_SESSION['cart'] as $idKey => $cart) {
		$id = substr($idKey,3,3);
		$product = $table1->getProduct($id);
		$totalPrice += $product->price * $cart;
	}

	$orderId = $table->addOrder($auth->id,$totalPrice);

	if($orderId){
		foreach($_SESSION['cart'] as $idKey => $cart) {
			$id = substr($idKey,3,3);
			$product = $table1->getProduct($id);
			
			$table->addOrderDetail($orderId,$product->id,$cart);

			$updateQuantity = $product->quantity - $cart;

			$table1->updateProductQuantity($updateQuantity,$id);
		}
	}
	unset($_SESSION['cart']);
}


// if(isset($_SESSION['cart'])){
// 	$totalPrice = 0;
// 	foreach($_SESSION['cart'] as $idKey => $cart) {
// 		$id = substr($idKey,3,3);
// 		$product = $table1->getProduct($id);
// 		$totalPrice += $product->price * $cart;
// 	}
	
// 	$orderId = $table->addOrder($auth->id,$totalPrice);
	
// 	if($orderId){
// 		foreach($_SESSION['cart'] as $idKey => $cart) {
// 			$id = substr($idKey,3,3);
// 			$product = $table1->getProduct($id);
			
// 			$table->addOrderDetail($orderId,$product->id,$cart);
	
// 			$updateQuantity = $product->quantity - $cart;
	
// 			$table1->updateProductQuantity($updateQuantity,$product->id);
// 		}
// 	}
// 	unset($_SESSION['cart']);
// } else {
// 	HTTP::redirect("home.php");
// }

?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from preview.colorlib.com/theme/cozastore/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Oct 2023 01:42:51 GMT -->
<head>
<title>Confirmation</title>
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

<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">

<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/main.css">

<script nonce="0ddb3891-1531-4199-82a3-38207bbd7872">(function(w,d){!function(bb,bc,bd,be){bb[bd]=bb[bd]||{};bb[bd].executed=[];bb.zaraz={deferred:[],listeners:[]};bb.zaraz.q=[];bb.zaraz._f=function(bf){return async function(){var bg=Array.prototype.slice.call(arguments);bb.zaraz.q.push({m:bf,a:bg})}};for(const bh of["track","set","debug"])bb.zaraz[bh]=bb.zaraz._f(bh);bb.zaraz.init=()=>{var bi=bc.getElementsByTagName(be)[0],bj=bc.createElement(be),bk=bc.getElementsByTagName("title")[0];bk&&(bb[bd].t=bc.getElementsByTagName("title")[0].text);bb[bd].x=Math.random();bb[bd].w=bb.screen.width;bb[bd].h=bb.screen.height;bb[bd].j=bb.innerHeight;bb[bd].e=bb.innerWidth;bb[bd].l=bb.location.href;bb[bd].r=bc.referrer;bb[bd].k=bb.screen.colorDepth;bb[bd].n=bc.characterSet;bb[bd].o=(new Date).getTimezoneOffset();if(bb.dataLayer)for(const bo of Object.entries(Object.entries(dataLayer).reduce(((bp,bq)=>({...bp[1],...bq[1]})),{})))zaraz.set(bo[0],bo[1],{scope:"page"});bb[bd].q=[];for(;bb.zaraz.q.length;){const br=bb.zaraz.q.shift();bb[bd].q.push(br)}bj.defer=!0;for(const bs of[localStorage,sessionStorage])Object.keys(bs||{}).filter((bu=>bu.startsWith("_zaraz_"))).forEach((bt=>{try{bb[bd]["z_"+bt.slice(7)]=JSON.parse(bs.getItem(bt))}catch{bb[bd]["z_"+bt.slice(7)]=bs.getItem(bt)}}));bj.referrerPolicy="origin";bj.src="../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(bb[bd])));bi.parentNode.insertBefore(bj,bi)};["complete","interactive"].includes(bc.readyState)?zaraz.init():bb.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body class="animsition">

<?php include("header.php") ?>

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
<li class="header-cart-item flex-w flex-t m-b-12">
<div class="header-cart-item-img">
<img src="images/item-cart-01.jpg" alt="IMG">
</div>
<div class="header-cart-item-txt p-t-8">
<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
White Shirt Pleat
</a>
<span class="header-cart-item-info">
1 x $19.00
</span>
</div>
</li>
<li class="header-cart-item flex-w flex-t m-b-12">
<div class="header-cart-item-img">
<img src="images/item-cart-02.jpg" alt="IMG">
</div>
<div class="header-cart-item-txt p-t-8">
<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
Converse All Star
</a>
<span class="header-cart-item-info">
1 x $39.00
</span>
</div>
</li>
<li class="header-cart-item flex-w flex-t m-b-12">
<div class="header-cart-item-img">
<img src="images/item-cart-03.jpg" alt="IMG">
</div>
<div class="header-cart-item-txt p-t-8">
<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
Nixon Porter Leather
</a>
<span class="header-cart-item-info">
1 x $17.00
</span>
</div>
</li>
</ul>
<div class="w-full">
<div class="header-cart-total w-full p-tb-40">
Total: $75.00
</div>
<div class="header-cart-buttons flex-w w-full">
<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
View Cart
</a>
<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
Check Out
</a>
</div>
</div>
</div>
</div>
</div>

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
<h2 class="ltext-105 cl0 txt-center">
Confirmation
</h2>
</section>

<section class="bg0 p-t-104 p-b-116">
<div class="container">
<div class="text-center text-dark display-4 mb-4">Your order have been received.</div>
<div class="text-center text-dark h1">Thank You.</div>
</div>
</section>

<div class="map">
<div class="size-303" id="google_map" data-map-x="40.691446" data-map-y="-73.886787" data-pin="images/icons/pin.png" data-scrollwhell="0" data-draggable="1" data-zoom="11"></div>
</div>

<footer class="bg3 p-t-75 p-b-32">
<div class="container">
<div class="row">
<div class="col-sm-6 col-lg-3 p-b-50">
<h4 class="stext-301 cl0 p-b-30">
Categories
</h4>
<ul>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
Women
</a>
</li>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
Men
</a>
</li>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
Shoes
</a>
</li>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
Watches
</a>
</li>
</ul>
</div>
<div class="col-sm-6 col-lg-3 p-b-50">
<h4 class="stext-301 cl0 p-b-30">
Help
</h4>
<ul>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
Track Order
</a>
</li>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
Returns
</a>
</li>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
Shipping
</a>
</li>
<li class="p-b-10">
<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
FAQs
</a>
</li>
</ul>
</div>
<div class="col-sm-6 col-lg-3 p-b-50">
<h4 class="stext-301 cl0 p-b-30">
GET IN TOUCH
</h4>
<p class="stext-107 cl7 size-201">
Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
</p>
<div class="p-t-27">
<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
<i class="fa fa-facebook"></i>
</a>
<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
<i class="fa fa-instagram"></i>
</a>
<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
<i class="fa fa-pinterest-p"></i>
</a>
</div>
</div>
<div class="col-sm-6 col-lg-3 p-b-50">
<h4 class="stext-301 cl0 p-b-30">
Newsletter
</h4>
<form>
<div class="wrap-input1 w-full p-b-4">
<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
<div class="focus-input1 trans-04"></div>
</div>
<div class="p-t-18">
<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
Subscribe
</button>
</div>
</form>
</div>
</div>
<div class="p-t-40">
<div class="flex-c-m flex-w p-b-18">
<a href="#" class="m-all-1">
<img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
</a>
<a href="#" class="m-all-1">
<img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
</a>
<a href="#" class="m-all-1">
<img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
</a>
<a href="#" class="m-all-1">
<img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
</a>
<a href="#" class="m-all-1">
<img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
</a>
</div>
<p class="stext-107 cl6 txt-center">

Copyright &copy;<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com/" target="_blank">Colorlib</a>

</p>
</div>
</div>
</footer>

<div class="btn-back-to-top" id="myBtn">
<span class="symbol-btn-back-to-top">
<i class="zmdi zmdi-chevron-up"></i>
</span>
</div>

<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

<script src="vendor/animsition/js/animsition.min.js"></script>

<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="vendor/select2/select2.min.js"></script>
<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>

<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>

<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
<script src="js/map-custom.js"></script>

<script src="js/main.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"81cf78bc8c0340b4","b":1,"version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from preview.colorlib.com/theme/cozastore/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Oct 2023 01:42:52 GMT -->
</html>