<?php
session_start();
include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

$table = new ProductsTable(new MySQL());

$token = sha1(rand(1,1000).time(). 'csrf secret');
$_SESSION['csrf'] = $token;
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<!-- Mirrored from preview.colorlib.com/theme/karma/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Oct 2023 01:45:46 GMT -->
<head>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="shortcut icon" href="img/fav.png">

<meta name="author" content="CodePixar">

<meta name="description" content>

<meta name="keywords" content>

<meta charset="UTF-8">

<title>Lwin Store Login</title>

<link rel="stylesheet" href="karma/css/linearicons.css">
<link rel="stylesheet" href="karma/css/owl.carousel.css">
<link rel="stylesheet" href="karma/css/themify-icons.css">
<link rel="stylesheet" href="karma/css/font-awesome.min.css">
<link rel="stylesheet" href="karma/css/nice-select.css">
<link rel="stylesheet" href="karma/css/nouislider.min.css">
<link rel="stylesheet" href="karma/css/bootstrap.css">
<link rel="stylesheet" href="karma/css/main.css">
<link rel="stylesheet" href="admin/dist/css/bootstrap.css">

<script nonce="85bb67b6-22f6-4c43-8e1f-5bf7faa3d1b3">(function(w,d){!function(bb,bc,bd,be){bb[bd]=bb[bd]||{};bb[bd].executed=[];bb.zaraz={deferred:[],listeners:[]};bb.zaraz.q=[];bb.zaraz._f=function(bf){return async function(){var bg=Array.prototype.slice.call(arguments);bb.zaraz.q.push({m:bf,a:bg})}};for(const bh of["track","set","debug"])bb.zaraz[bh]=bb.zaraz._f(bh);bb.zaraz.init=()=>{var bi=bc.getElementsByTagName(be)[0],bj=bc.createElement(be),bk=bc.getElementsByTagName("title")[0];bk&&(bb[bd].t=bc.getElementsByTagName("title")[0].text);bb[bd].x=Math.random();bb[bd].w=bb.screen.width;bb[bd].h=bb.screen.height;bb[bd].j=bb.innerHeight;bb[bd].e=bb.innerWidth;bb[bd].l=bb.location.href;bb[bd].r=bc.referrer;bb[bd].k=bb.screen.colorDepth;bb[bd].n=bc.characterSet;bb[bd].o=(new Date).getTimezoneOffset();if(bb.dataLayer)for(const bo of Object.entries(Object.entries(dataLayer).reduce(((bp,bq)=>({...bp[1],...bq[1]})),{})))zaraz.set(bo[0],bo[1],{scope:"page"});bb[bd].q=[];for(;bb.zaraz.q.length;){const br=bb.zaraz.q.shift();bb[bd].q.push(br)}bj.defer=!0;for(const bs of[localStorage,sessionStorage])Object.keys(bs||{}).filter((bu=>bu.startsWith("_zaraz_"))).forEach((bt=>{try{bb[bd]["z_"+bt.slice(7)]=JSON.parse(bs.getItem(bt))}catch{bb[bd]["z_"+bt.slice(7)]=bs.getItem(bt)}}));bj.referrerPolicy="origin";bj.src="../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(bb[bd])));bi.parentNode.insertBefore(bj,bi)};["complete","interactive"].includes(bc.readyState)?zaraz.init():bb.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body>



<section class="banner-area organic-breadcrumb">
<div class="container">
<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
<div class="col-first">
  <div class="display-3 text-white text-uppercase"><strong>Lwin</strong>Store</div>
<nav class="d-flex align-items-center">
  <h3 class="text-light">Login Page</h3>
</nav>
</div>
</div>
</div>
</section>


<section class="login_box_area section_gap position-relative">
<div class="container">
<div class="row">
<div class="col-lg-6">
<div class="login_box_img">
<img class="img-fluid" src="images/product-05.jpg" alt>
<div class="hover">
<h4>New to our website?</h4>
<p>Welcome to our LWIN online shopping store.<br>Discover a world of convenience and endless choices as you explore our website.Happy shopping!</p>
<a class="primary-btn text-decoration-none" href="register.php">Create an Account</a>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="login_form_inner">
<h3>Log in to enter</h3>
<form class="row login_form was-validated" action="admin/actions/login.php" method="post" id="contactForm" novalidate="novalidate">
<input type="hidden" name="csrf" value="<?= $token ?>">
<div class="col-md-12 form-group">
<?php if(isset($_GET['register'])) : ?>
  <div class="alert alert-success mb-3">Successfully Registered,Please Login.</div>
<?php endif ?>
<?php if(isset($_GET['false'])) : ?>
  <div class="alert alert-danger mb-3">Your Email or Password is wrong.</div>
<?php endif ?>
  <?php if(isset($_GET['nullEmail'])) : ?>
    <p class="text-danger text-start">*<?= $_GET['nullEmail'] ?></p>
  <?php endif ?>
  <input type="email" class="form-control" id="email" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required>
  <div class="valid-feedback text-start">True</div>
  <div class="invalid-feedback text-start">Write Your Email</div>
  </div>
  <div class="col-md-12 form-group">
    <?php if(isset($_GET['nullPassword'])) : ?>
    <p class="text-danger text-start">*<?= $_GET['nullPassword'] ?></p>
    <?php endif ?>
    <input type="text" class="form-control" id="name" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
    <div class="valid-feedback text-start">True</div>
    <div class="invalid-feedback text-start">Write Your Email</div>
</div>
<div class="col-md-12 form-group mt-3">
<button type="submit" value="submit" class="primary-btn">Log In</button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>



<div class="container">

<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
<p class="footer-text">
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://lwinko.com/" target="_blank">LwinKo</a>

</p>
</div>
</div>
<script src="karma/js/vendor/jquery-2.2.4.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="karma/js/vendor/bootstrap.min.js"></script>
<script src="karma/js/jquery.ajaxchimp.min.js"></script>
<script src="karma/js/jquery.nice-select.min.js"></script>
<script src="karma/js/jquery.sticky.js"></script>
<script src="karma/js/nouislider.min.js"></script>
<script src="karma/js/jquery.magnific-popup.min.js"></script>
<script src="karma/js/owl.carousel.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
<script src="karma/js/gmaps.min.js"></script>
<script src="karma/js/main.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.karma/js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"81cf7cd7b9a0ab4f","b":1,"version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from preview.colorlib.com/theme/karma/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Oct 2023 01:45:47 GMT -->
</html>