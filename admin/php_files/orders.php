<?php 
include 'database.php';

if(isset($_POST['complete'])){

	$db = new Database();
	$order_id = $db->escapeString($_POST['complete']);
	$db->update('order_products',['delivery'=>'1'],"order_id='{$order_id}'");
	$result = $db->getResult();
	if($result[0] == '1'){
		echo 'true'; exit;
	}
}

 ?>
