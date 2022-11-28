<?php

	include 'database.php';

	if(isset($_POST['user_view'])){
		$db = new Database();

		$id = $db->escapeString($_POST['user_view']);

		$db->select('user','f_name,l_name,username,email,mobile,address,city,user_role',null,"user_id = '{$id}'",null,null);
		$result = $db->getResult();
		echo json_encode($result); exit;
	}

	if(isset($_POST['status_id'])){
		$id = $_POST['user_id'];
		$status_id = $_POST['status_id'];

		$db = new Database();
		if($status_id == '1'){
			$db->update('user',array('user_role'=>'0'),"user_id = '{$id}'");
		}else{
			$db->update('user',array('user_role'=>'1'),"user_id = '{$id}'");
		}
		$response = $db->getResult();
		if(!empty($response)){
			echo json_encode(array('sucess'=>'success'));
		}

	}


	if(isset($_POST['delete_id'])){

		$db = new Database();

		$id = $db->escapeString($_POST['delete_id']);
        $db->delete('user',"user_id ='{$id}'");
        $response = $db->getResult();
        if(!empty($response)){
            echo json_encode(array('success'=>$response)); exit;
        }

		
	} 


?>