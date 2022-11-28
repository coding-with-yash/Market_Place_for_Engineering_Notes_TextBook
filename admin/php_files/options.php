<?php

include 'database.php';


    if(isset($_POST['update'])){
        // echo json_encode(array('error'=>'Options ID is missing.')); exit;
        if(!isset($_POST['s_no']) || empty($_POST['s_no'])){
            echo json_encode(array('error'=>'Options ID is missing.')); exit;
        }elseif(!isset($_POST['site_name']) || empty($_POST['site_name'])){
            echo json_encode(array('error'=>'Site Name Field is Empty.')); exit;
        }elseif(!isset($_POST['site_title']) || empty($_POST['site_title'])){
            echo json_encode(array('error'=>'Site Title Field is Empty.')); exit;
        }elseif(!isset($_POST['footer_text']) || empty($_POST['footer_text'])){
            echo json_encode(array('error'=>'Footer text Field is Empty.')); exit;
        }elseif(!isset($_POST['currency_format']) || empty($_POST['currency_format'])){
            echo json_encode(array('error'=>'Currency Format Field is Empty.')); exit;
        }elseif(!isset($_POST['site_desc']) || empty($_POST['site_desc'])){
            echo json_encode(array('error'=>'Description Field is Empty.')); exit;
        }elseif(!isset($_POST['contact_email']) || empty($_POST['contact_email'])){
            echo json_encode(array('error'=>'Email Field is Empty.')); exit;
        }elseif(!isset($_POST['contact_phone']) || empty($_POST['contact_phone'])){
            echo json_encode(array('error'=>'Phone Field is Empty.')); exit;
        }elseif(!isset($_POST['contact_address']) || empty($_POST['contact_address'])){
            echo json_encode(array('error'=>'Address Field is Empty.')); exit;
        }else if(empty($_POST['old_logo']) && empty($_FILES['new_logo']['name'])){
            echo json_encode(array('error'=>'Site Logo Field is Empty.')); exit;
        }else{

            if(!empty($_POST['old_logo'])  && empty($_FILES['new_logo']['name'])){
                $file_name = $_POST['old_logo'];

            }else if(!empty($_POST['old_logo']) && !empty($_FILES['new_logo']['name'])){
                $errors= array();
                 /* get details of the uploaded file */
                $file_name = $_FILES['new_logo']['name'];
                $file_size =$_FILES['new_logo']['size'];
                $file_tmp =$_FILES['new_logo']['tmp_name'];
                $file_type=$_FILES['new_logo']['type'];
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
                if(file_exists('images/'.$_POST{'old_logo'})){
                    unlink('images/'.$_POST{'old_logo'});
                }
                $file_name = time().str_replace(array(' ','_'), '-', $file_name);

            }else if(empty($_POST['old_logo']) && !empty($_FILES['new_logo']['name'])){
                $errors= array();
                 /* get details of the uploaded file */
                $file_name = $_FILES['new_logo']['name'];
                $file_size =$_FILES['new_logo']['size'];
                $file_tmp =$_FILES['new_logo']['tmp_name'];
                $file_type=$_FILES['new_logo']['type'];
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
            // echo json_encode(array('1'=>'1')); exit;
            if(!empty($errors)){
               echo json_encode($errors); exit;
            }else{
                

                $db = new Database();

                $params = [
                    'site_name' => $db->escapeString($_POST['site_name']),
                    'site_title' => $db->escapeString($_POST['site_title']),
                    'site_logo' => $db->escapeString($file_name),
                    'footer_text' => $db->escapeString($_POST['footer_text']),
                    'currency_format' => $db->escapeString($_POST['currency_format']),
                    'site_desc' => $db->escapeString($_POST['site_desc']),
                    'contact_phone' => $db->escapeString($_POST['contact_phone']),
                    'contact_email' => $db->escapeString($_POST['contact_email']),
                    'contact_address' => $db->escapeString($_POST['contact_address'])
                ];

                $db->update('options',$params,"s_no='{$_POST['s_no']}'");
                
                $response = $db->getResult();
                if(!empty($response)){

                    if(!empty($_FILES['new_logo']['name'])){
                        /* directory in which the uploaded file will be moved */
                        move_uploaded_file($file_tmp,"../../images/".$file_name);
                    }
                    echo json_encode(array('success'=>$response[0])); exit;
                }
            }
        }
    }

?>