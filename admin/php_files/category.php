<?php
	include 'database.php';

    if( isset($_POST['create']) ){
    	if(!isset($_POST['cat']) || empty($_POST['cat'])){
    		echo json_encode(array('error'=>'Category Field is Empty.'));
    	}else{
    		$db = new Database();

    		$category = $db->escapeString($_POST['cat']);

    		$db->select('categories','cat_title',null,"cat_title = '{$category}'",null,null);
    		$exist = $db->getResult();
    		if(!empty($exist)){
    			echo json_encode(array('error'=>'Category Already exists.'));
    		}else{
				$db->insert('categories',array('cat_title'=>$category));
				$response = $db->getResult();

				if(!empty($response)){
					echo json_encode(array('success'=>$response));
				}
    		}
    	}
    } 


    if( isset($_POST['update']) ){
    	if(!isset($_POST['cat_id']) || empty($_POST['cat_id'])){
    		echo json_encode(array('error'=>'ID is Empty.')); exit;
    	}if(!isset($_POST['cat_name']) || empty($_POST['cat_name'])){
    		echo json_encode(array('error'=>'Category Field is Empty.')); exit;
    	}else{
    		$db = new Database();

    		$cat_id = $db->escapeString($_POST['cat_id']);
    		$cat_name = $db->escapeString($_POST['cat_name']);

    		$db->update('categories',array('cat_title'=>$cat_name),"cat_id = '{$cat_id}'");
    		$response = $db->getResult();

    		if(!empty($response)){
    			echo json_encode(array('success'=>$response)); exit;
    		}
    	}
    }

    if(isset($_POST['delete_id'])){

		$db = new Database();

		$id = $db->escapeString($_POST['delete_id']);

		$db->delete('categories',"cat_id ='{$id}'");
		$response = $db->getResult();
		if(!empty($response)){
			echo json_encode(array('success'=>$response)); exit;
		}
	} 

?>  
