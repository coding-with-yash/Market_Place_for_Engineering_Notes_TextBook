<?php
	include 'database.php';

    if( isset($_POST['create']) ){
    	if(!isset($_POST['sub_cat_name']) || empty($_POST['sub_cat_name'])){
    		echo json_encode(array('error'=>'Title Field is Empty.'));
    	}elseif(!isset($_POST['parent_cat']) || empty($_POST['parent_cat'])){
            echo json_encode(array('error'=>'Parent Category Field is Empty.'));
        }else{
    		$db = new Database();

    		$title = $db->escapeString($_POST['sub_cat_name']);
            $parent_cat = $db->escapeString($_POST['parent_cat']);

    		$db->select('sub_categories','sub_cat_title',null,"sub_cat_title = '{$title}' AND  cat_parent = '{$parent_cat}'",null,null);
    		$exist = $db->getResult();
    		if(!empty($exist)){
    			echo json_encode(array('error'=>'This Title Already exists.'));
    		}else{
				$db->insert('sub_categories',array('sub_cat_title'=>$title,'cat_parent'=>$parent_cat));
				$response = $db->getResult();

				if(!empty($response)){
					echo json_encode(array('success'=>$response));
				}
    		}
    	}
    } 


    if( isset($_POST['update']) ){
    	if(!isset($_POST['sub_cat_id']) || empty($_POST['sub_cat_id'])){
    		echo json_encode(array('error'=>'ID is Empty.')); exit;
    	}elseif(!isset($_POST['sub_cat_name']) || empty($_POST['sub_cat_name'])){
            echo json_encode(array('error'=>'Title Field is Empty.'));
        }elseif(!isset($_POST['parent_cat']) || empty($_POST['parent_cat'])){
            echo json_encode(array('error'=>'Parent Category Field is Empty.'));
        }else{
    		$db = new Database();

    		$cat_id = $db->escapeString($_POST['sub_cat_id']);
    		$cat_name = $db->escapeString($_POST['sub_cat_name']);
            $parent_cat = $db->escapeString($_POST['parent_cat']);

    		$db->update('sub_categories',array('sub_cat_title'=>$cat_name,'cat_parent'=>$parent_cat),"sub_cat_id = '{$cat_id}'");
    		$response = $db->getResult();

    		if(!empty($response)){
    			echo json_encode(array('success'=>$response)); exit;
    		}
    	}
    }

    if(isset($_POST['delete_id'])){

		$db = new Database();

		$id = $db->escapeString($_POST['delete_id']);

        $db->select('sub_categories','cat_parent',null,"sub_cat_id = '{$id}'",null,null);
        $count = $db->getResult();
        if($count[0]['cat_parent'] > '0'){
            echo json_encode(array('error'=>'not delete')); exit;
        }else{
            $db->delete('sub_categories',"sub_cat_id ='{$id}'");
            $response = $db->getResult();
            if(!empty($response)){
                echo json_encode(array('success'=>$response)); exit;
            }
        }

		
	} 

    if(isset($_POST['showInHeader'])){
        $status = $_POST['showInHeader'];
        $id = $_POST['id'];
        $db = new Database();

        $db->update('sub_categories',array('show_in_header'=>$status),"sub_cat_id = '{$id}'");
        $result = $db->getResult();

        if(!empty($result)){
            echo 'true'; exit;
        }
    }

    if(isset($_POST['showInFooter'])){
        $status = $_POST['showInFooter'];
        $id = $_POST['id'];
        $db = new Database();

        $db->update('sub_categories',array('show_in_footer'=>$status),"sub_cat_id = '{$id}'");
        $result = $db->getResult();

        if(!empty($result)){
            echo 'true'; exit;
        }
    }

?>  
