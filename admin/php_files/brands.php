<?php
	include 'database.php';

    if( isset($_POST['create']) ){
    	if(!isset($_POST['brand_name']) || empty($_POST['brand_name'])){
    		echo json_encode(array('error'=>'Title Field is Empty.'));
    	}elseif(!isset($_POST['brand_cat']) || empty($_POST['brand_cat'])){
            echo json_encode(array('error'=>'Brand Category Field is Empty.'));
        }else{
    		$db = new Database();

    		$title = $db->escapeString($_POST['brand_name']);
            $brand_cat = $db->escapeString($_POST['brand_cat']);

    		$db->select('brands','brand_title',null,"brand_title = '{$title}' AND  brand_cat = '{$brand_cat}'",null,null);
    		$exist = $db->getResult();
    		if(!empty($exist)){
    			echo json_encode(array('error'=>'This Title Already exists.'));
    		}else{
				$db->insert('brands',array('brand_title'=>$title,'brand_cat'=>$brand_cat));
				$response = $db->getResult();

				if(!empty($response)){
					echo json_encode(array('success'=>$response));
				}
    		}
    	}
    } 


    if( isset($_POST['update']) ){
    	if(!isset($_POST['brand_id']) || empty($_POST['brand_id'])){
    		echo json_encode(array('error'=>'ID is Empty.')); exit;
    	}elseif(!isset($_POST['brand_name']) || empty($_POST['brand_name'])){
            echo json_encode(array('error'=>'Title Field is Empty.'));
        }elseif(!isset($_POST['brand_cat']) || empty($_POST['brand_cat'])){
            echo json_encode(array('error'=>'Brand Category Field is Empty.'));
        }else{
    		$db = new Database();

    		$brand_id = $db->escapeString($_POST['brand_id']);
    		$brand_name = $db->escapeString($_POST['brand_name']);
            $brand_cat = $db->escapeString($_POST['brand_cat']);

    		$db->update('brands',array('brand_title'=>$brand_name,'brand_cat'=>$brand_cat),"brand_id = '{$brand_id}'");
    		$response = $db->getResult();

    		if(!empty($response)){
    			echo json_encode(array('success'=>$response)); exit;
    		}
    	}
    }

    if(isset($_POST['delete_id'])){

		$db = new Database();

		$id = $db->escapeString($_POST['delete_id']);

        // $db->select('sub_categories','cat_parent',null,"sub_cat_id = '{$id}'",null,null);
        // $count = $db->getResult();
        // if($count[0]['cat_parent'] > '0'){
        //     echo json_encode(array('error'=>'not delete')); exit;
        // }else{
            $db->delete('brands',"brand_id ='{$id}'");
            $response = $db->getResult();
            if(!empty($response)){
                echo json_encode(array('success'=>$response)); exit;
            }
        //}

		
	} 

?>  
