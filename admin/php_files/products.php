<?php
 include 'database.php';

 // get sub category and brands 
 // ==========================
 if(isset($_POST['p_cat'])){
    $cat = $_POST['p_cat'];
    $db = new Database();
    $db->select('sub_categories','*',null,"cat_parent = $cat",null,null);
    $sub_category = $db->getResult();

    $output = [];
    if ($sub_category > 0) {
        $output['sub_category'] = $sub_category;
    }

    $db->select('brands','*',null,"brand_cat = $cat",null,null);
    $brands = $db->getResult();
    if ($sub_category > 0) {
        $output['brands'] = $brands;
    }
    echo json_encode($output);
}


// product insert script
// ============================
if(isset($_POST['create'])){
	if(!isset($_POST['product_title']) || empty($_POST['product_title'])){
		echo json_encode(array('error'=>'Title Field is Empty.')); exit;
	}elseif(!isset($_POST['product_cat']) || empty($_POST['product_cat'])){
		echo json_encode(array('error'=>'Category Field is Empty.')); exit;
	}elseif(!isset($_POST['product_sub_cat']) || empty($_POST['product_sub_cat'])){
		echo json_encode(array('error'=>'Sub Category Field is Empty.')); exit;
	}elseif(!isset($_POST['product_desc']) || empty($_POST['product_desc'])){
		echo json_encode(array('error'=>'Description Field is Empty.')); exit;
	}elseif(!isset($_POST['product_price']) || empty($_POST['product_price'])){
		echo json_encode(array('error'=>'Price Field is Empty.')); exit;
	}elseif(!isset($_POST['product_qty']) || empty($_POST['product_qty'])){
        echo json_encode(array('error'=>'Quantity Field is Empty.')); exit;
    }elseif(!isset($_POST['product_status']) || empty($_POST['product_status'])){
		echo json_encode(array('error'=>'Status Field is Empty.')); exit;
	}elseif(!isset($_FILES['featured_img']['name']) || empty($_FILES['featured_img']['name'])){
		echo json_encode(array('error'=>'Image Field is Empty.')); exit;
    }else{

		$errors= array();
        /* get details of the uploaded file */
        $file_name = $_FILES['featured_img']['name'];
        $file_size = $_FILES['featured_img']['size'];
        $file_tmp = $_FILES['featured_img']['tmp_name'];
        $file_type = $_FILES['featured_img']['type'];
        $file_name = str_replace(array(',',' '),'',$file_name);
        $file_ext = explode('.',$file_name);
        $file_ext = strtolower(end($file_ext));
        $extensions = array("jpeg","jpg","png");
        if(in_array($file_ext,$extensions)=== false){
            $errors[]='<div class="alert alert-danger"> extension not allowed, please choose a JPEG or PNG file.</div>';
        }
        if($file_size > 2097152){
            $errors[]='<div class="alert alert-danger">File size must be exactely 2 MB</div>';
        }
        // check image errors
        if(!empty($errors)){
        	echo json_encode($errors); exit;
        }else{
        	
            $file_name = time().str_replace(array(' ','_'), '-', $file_name);

            if(isset($_POST['product_brand']) && !empty($_POST['product_brand'])){
    			$product_brand = $_POST['product_brand'];
	    	}else{
				$product_brand = '0';
	    	}
		    	
            
            $db = new Database();

        	$params = [
                'product_title' => $db->escapeString($_POST['product_title']),
                'product_code' => uniqid(),
        		'product_cat' => $db->escapeString($_POST['product_cat']),
        		'product_sub_cat' => $db->escapeString($_POST['product_sub_cat']),
        		'product_brand' => $db->escapeString($product_brand),
        		'featured_image' => $db->escapeString($file_name),
        		'product_desc' => $db->escapeString($_POST['product_desc']),
        		'product_price' => $db->escapeString($_POST['product_price']),
                'qty' => $db->escapeString($_POST['product_qty']),
        		'product_status' => $db->escapeString($_POST['product_status'])
        	];

        	$db->select('products','product_title',null,"product_title = '{$params['product_title']}'",null,null);
        	$exist = $db->getResult();

        	if(!empty($exist)){
        		echo json_encode(array('error'=>'Title is Already Exists.')); exit;
        	}else{
        		$db->insert('products',$params);
        		$db->sql("UPDATE sub_categories SET cat_products = cat_products + 1 WHERE sub_cat_id = {$params['product_sub_cat']}");
        		$response = $db->getResult();
        		if(!empty($response)){
        			/* directory in which the uploaded file will be moved */
            		move_uploaded_file($file_tmp,"../../product-images/".$file_name);

            		echo json_encode(array('success'=>$response)); exit;
        		}
        	}
        }
    }
}




// product update script
// ============================
if(isset($_POST['update'])){

	if(!isset($_POST['product_id']) || empty($_POST['product_id'])){
		echo json_encode(array('error'=>'Product ID is missing.')); exit;
	}elseif(!isset($_POST['product_title']) || empty($_POST['product_title'])){
		echo json_encode(array('error'=>'Title Field is Empty.')); exit;
	}elseif(!isset($_POST['product_cat']) || empty($_POST['product_cat'])){
		echo json_encode(array('error'=>'Category Field is Empty.')); exit;
	}elseif(!isset($_POST['product_sub_cat']) || empty($_POST['product_sub_cat'])){
		echo json_encode(array('error'=>'Sub Category Field is Empty.')); exit;
	}elseif(!isset($_POST['product_desc']) || empty($_POST['product_desc'])){
		echo json_encode(array('error'=>'Description Field is Empty.')); exit;
	}elseif(!isset($_POST['product_price']) || empty($_POST['product_price'])){
		echo json_encode(array('error'=>'Price Field is Empty.')); exit;
	}elseif(!isset($_POST['product_qty']) || empty($_POST['product_qty'])){
        echo json_encode(array('error'=>'Quantity Field is Empty.')); exit;
    }elseif(!isset($_POST['product_status']) || empty($_POST['product_status'])){
		echo json_encode(array('error'=>'Status Field is Empty.')); exit;
	}else if(empty($_POST['old_image']) && empty($_FILES['new_image']['name'])){
        echo json_encode(array('error'=>'Image Field is Empty.')); exit;
    }else{


        if(!empty($_POST['old_image'])  && empty($_FILES['new_image']['name'])){
            $file_name = $_POST['old_image'];
        
        }else if(!empty($_POST['old_image']) && !empty($_FILES['new_image']['name'])){
            $errors= array();
             /* get details of the uploaded file */
            $file_name = $_FILES['new_image']['name'];
            $file_size =$_FILES['new_image']['size'];
            $file_tmp =$_FILES['new_image']['tmp_name'];
            $file_type=$_FILES['new_image']['type'];
            $file_name = str_replace(array(',',' '),'',$file_name);
            $file_ext=explode('.',$file_name);
            $file_ext=strtolower(end($file_ext));
            $extensions= array("jpeg","jpg","png");
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if($file_size > 2097152){
                $errors[]='File size must be excately 2 MB';
            }
            if(file_exists('../../product-images/'.$_POST{'old_image'})){
                unlink('../../product-images/'.$_POST{'old_image'});
            }
            $file_name = time().str_replace(array(' ','_'), '-', $file_name);

        }else if(empty($_POST['old_image']) && !empty($_FILES['new_image']['name'])){
            $errors= array();
             /* get details of the uploaded file */
            $file_name = $_FILES['new_image']['name'];
            $file_size =$_FILES['new_image']['size'];
            $file_tmp =$_FILES['new_image']['tmp_name'];
            $file_type=$_FILES['new_image']['type'];
            $file_name = str_replace(array(',',' '),'',$file_name);
            $file_ext=explode('.',$file_name);
            $file_ext=strtolower(end($file_ext));
            $extensions= array("jpeg","jpg","png");
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            if($file_size > 2097152){
                $errors[]='File size must be excately 2 MB';
            }
            $file_name = time().str_replace(array(' ','_'), '-', $file_name);
        }

        if(!empty($errors)){
    	   echo json_encode($errors); exit;
        }else{
            

            if(isset($_POST['product_brand']) && !empty($_POST['product_brand'])){
    			$product_brand = $_POST['product_brand'];
	    	}else{
				$product_brand = '0';
	    	}
        	
            $db = new Database();

        	$params = [
        		'product_title' => $db->escapeString($_POST['product_title']),
        		'product_cat' => $db->escapeString($_POST['product_cat']),
        		'product_sub_cat' => $db->escapeString($_POST['product_sub_cat']),
        		'product_brand' => $db->escapeString($product_brand),
        		'featured_image' => $db->escapeString($file_name),
        		'product_desc' => $db->escapeString($_POST['product_desc']),
        		'product_price' => $db->escapeString($_POST['product_price']),
                'qty' => $db->escapeString($_POST['product_qty']),
        		'product_status' => $db->escapeString($_POST['product_status'])
        	];

    		$db->update('products',$params,"product_id='{$_POST['product_id']}'");
    		
    		$response = $db->getResult();
    		if(!empty($response)){

    			if(!empty($_FILES['new_image']['name'])){
    				/* directory in which the uploaded file will be moved */
                    move_uploaded_file($file_tmp,"../../product-images/".$file_name);
                }
        		echo json_encode(array('success'=>$response[0])); exit;
    		}
        }
    }
}
 
if(isset($_POST['delete_id'])){

	$db = new Database();

	$id = $db->escapeString($_POST['delete_id']);
	$sub_cat = $db->escapeString($_POST['p_subcat']);

	$db->delete('products',"product_id ='{$id}'");
	$db->sql("UPDATE sub_categories SET cat_products = cat_products - 1 WHERE sub_cat_id = {$sub_cat}");
	$response = $db->getResult();
	if(!empty($response)){
		echo json_encode(array('success'=>$response)); exit;
	}
}

?>