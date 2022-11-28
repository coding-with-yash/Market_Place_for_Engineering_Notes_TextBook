<?php 
include 'config.php';
session_start(); ?>
<?php
if(($_GET['payment_request_id'] == $_SESSION['TID']) && $_GET['payment_status'] == 'Credit'){
	$title = 'Payment Successful';
	$response = '<div class="panel-body">
				  	<i class="fa fa-check-circle text-success"></i>
				    <h3>Payment Successful</h3>
				    <p>Your Product Will be Delivered within 4 to 7 days.</p>
				  	<a href="'.$hostname.'" class="btn btn-md btn-primary">Continue Shopping</a>
				  </div>';

	  // reduce purchased quantity from products
	    $db = new Database();
	    $db->select('order_products','product_id,product_qty',null,"pay_req_id ='{$_GET['payment_request_id']}'",null,null);
	    $result = $db->getResult();
	    $products = array_filter(explode(',',$result[0]['product_id']));
	    $qty = array_filter(explode(',',$result[0]['product_qty']));
	    for($i=0;$i<count($products);$i++){
	    	$db->sql("UPDATE products SET qty = qty - '{$qty[$i]}' WHERE product_id = '{$products[$i]}'");
	    }
	    $res = $db->getResult();


	  // remove cart items
	  	if(isset($_COOKIE['user_cart'])){
	        setcookie('cart_count','',time() - (180),'/','','',TRUE);
			setcookie('user_cart','',time() - (180),'/','','',TRUE);
	    }
}else{
	$title = 'Payment UnSuccessful';
	$response = '<div class="panel-body">
				  	<i class="fa fa-times-circle text-danger"></i>
				    <h3>Payment Unsuccessful</h3>
				  	<a href="'.$hostname.'" class="btn btn-md btn-primary">Continue Shopping</a>
				  </div>';
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="payment-response">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-3 col-md-6">
					<div class="panel panel-default">
					  <?php echo $response; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>


