<?php

include("vendor/autoload.php");

use Helpers\Auth;
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;

$auth = Auth::check();
$table = new ProductsTable(new MySQL()); 

$token = $table->tokenCsrf();
?>

<?php include("header.php") ?>

<form class="bg0 p-t-75 p-b-85">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
				<div class="m-l-25 m-r--38 m-lr-0-xl">
					<div class="wrap-table-shopping-cart">
						<form action="actions/updateCart.php" method="post">
						<?php if(isset($_SESSION['cart'])) : ?>
						<table class="table-shopping-cart">
							<tr class="table_head">
								<th class="column-1">Product</th>
								<th class="column-2"></th>
								<th class="column-3">Price</th>
								<th class="column-4">Quantity</th>
								<th class="column-5">Total</th>
								<th class="column-6">Actions</th>
							</tr>
							<?php 
							$totalPrice = 0;
							foreach($_SESSION['cart'] as $idKey => $cart) :
							//   print_r($cart);
							//   print($idKey);
							$id = substr($idKey,3,3);
							$product = $table->getProduct($id);
							$totalPrice += $product->price * $cart;
							?>
							<tr class="table_row">
								<td class="column-1">
									<div class="how-itemcart1">
										<img src="admin/actions/photos/<?= $table->h($product->image) ?>" alt="IMG">
									</div>
								</td>
								<td class="column-2"><?= $table->h($product->name) ?></td>
								<td class="column-3">$<?= $table->h($product->price) ?></td>
								<td class="column-4">
									<div class="wrap-num-product flex-w m-l-auto m-r-0">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>
										<input class="mtext-104 cl3 txt-center num-product" type="number" name="cartId=<?= $product->id ?>" value="<?= $cart ?>">
										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>
									<input type="hidden" name="id=<?= $product->id ?>" value="<?= $product->id ?>">
									<td class="column-5">$<?= $table->h($product->price * $cart) ?></td>
									<td class="column-6">
										<!-- <a href="actions/clearCartId.php?id=<?= $product->id ?>" class="btn  btn-sm btn-outline-dark mb-2">
											<i class="fas fa-edit"></i>
										</a> -->
				<a href="actions/clearCartId.php?id=<?= $product->id ?>" class="btn btn-sm btn-outline-dark">
				  Clear
				</a>
			</td>
		  </tr>	  	
		  <?php endforeach ?>
		</table>
		
	</div>
	<!-- <button type="submit" class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
		Update Cart
	</button> -->
	<div class="flex-w  bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm" style="justify-content: flex-end !important;">
		<a href="actions/remove_cart.php" class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15  trans-04 pointer m-tb-5 me-4">Clear All
			</a>
	<div class="flex-w flex-m m-r-20 m-tb-5">
		<a href="home.php" class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5" >Back</a>
	</div>
   </div>
	<?php endif ?>	
</div>
</div>
</form>
<?php if(!isset($_SESSION['cart'])) : ?> 
<h4 class="mtext-109 cl2 p-b-30 text-center display-3">
	No Carts Add. 
	</h4>
<?php endif ?>	

<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
	<?php if(isset($_SESSION['cart'])) : ?>
	<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
		<h4 class="mtext-109 cl2 p-b-30">
		Cart Totals 
	</h4>
	<div class="flex-w flex-t bor12 p-b-13">
	<?php    $totalPrice = 0;
	    foreach($_SESSION['cart'] as $idKey => $cart) :
			$id = substr($idKey,3,4);
			$product = $table->getProduct($id);

			$totalPrice += $product->price * $cart;
			?>
<div class="w-75 mb-2">
	<span class="stext-110 cl2">
		<?= $product->name ?>
	</span>
</div>
<div class="w-25 mb-2">
	<span class="mtext-110 cl2">
		$<?= $product->price * $cart ?>
	</span>
</div>
<?php endforeach ?>
</div>
<!-- <div class="flex-w flex-t bor12 p-t-15 p-b-30">
<div class="size-208 w-full-ssm">
	<span class="stext-110 cl2">
		Shipping:
	</span>
</div>
<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
<p class="stext-111 cl6 p-t-2">
There are no shipping methods available. Please double check your address, or contact us if you need any help.
</p>
<div class="p-t-15">
	<span class="stext-112 cl8">
		Calculate Shipping
	</span>
<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
	<select class="js-select2" name="time">
		<option>Select a country...</option>
<option>USA</option>
<option>UK</option>
</select>
<div class="dropDownSelect2"></div>
</div>
<div class="bor8 bg0 m-b-12">
	<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="State /  country">
</div>
<div class="bor8 bg0 m-b-22">
	<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Postcode / Zip">
</div>
<div class="flex-w">
<div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
	Update Totals
</div>
</div>
</div>
</div>
</div> -->
<div class="flex-w flex-t p-t-27 p-b-33">
	<div class="w-75">
		<span class="mtext-101 cl2">
			Total:
		</span>
</div>
<div class="w-25 p-t-1">
<span class="mtext-110 cl2">
$<?= $totalPrice ? $totalPrice : 0 ?>
</span>
</div>
</div>
<button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
	<a href="confrimation.php" class="text-light">Proceed to Checkout</a>
</button>
<?php endif ?>
</div>
</div>
</div>
</div>
</form>



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

<script src="js/main.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"81cf78b5b9b840b2","b":1,"version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from preview.colorlib.com/theme/cozastore/shoping-cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Oct 2023 01:42:46 GMT -->
</html>