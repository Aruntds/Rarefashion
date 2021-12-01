<?php

extract($_REQUEST);
include_once('jackus.php');
//print_r($_FILES); exit();
  $uploadDir = '../uploads/productmediagallery/';  
      if($id == ''){
    if (!empty($_FILES)) {  
     $tmpFile         =$_FILES['file']['tmp_name'];  
	 $image_type      =$_FILES['file']['name'];
     $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
	 $expensions= array("jpeg","jpg","png");
	  if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
	  if(empty($errors)==true) {
		
        $filename = $uploadDir.'/'. $_FILES['file']['name'];  
		 move_uploaded_file($tmpFile,$filename);  
         echo "Success";
      }else{
         print_r($errors);
      }
    } 
	  }	else {
		  $response = array('status'=>false);
			$filename = $uploadDir.''. $id;  
		  // echo 'Delete'. ' ' . BASEPATH . $filename;
			// if( file_exists(BASEPATH . $filename) ) {
				unlink($filename);
				$response['status'] = true;
			// }

			// Send JSON Data to AJAX Request
			echo json_encode($response);
	  }

?>