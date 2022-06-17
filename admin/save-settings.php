<?php
    include "config.php";
    if(empty($_FILES['logo']['name'])){
        $file_name = $_POST['old_logo'];
    }else{
        if(isset($_FILES['logo'])){
            $errors = array();
    
            $file_name = $_FILES['logo']['name'];
            $file_size = $_FILES['logo']['size'];
            $file_tmp = $_FILES['logo']['tmp_name'];
            $file_type = $_FILES['logo']['type'];
            $exp = explode('.', $file_name);
            $file_ext = end($exp);
            $extensions = array("jpeg","jpg","png","webp");
    
            if(in_array($file_ext, $extensions) === false){
                $errors[] = "Invalid Image extension, try jpg, jpeg, png or webp.";
            }
    
            if($file_size > 2097152){
                $errors[] = "File size exceeds 2MB";
            }
    
            if(empty($errors) == true){
                move_uploaded_file($file_tmp, "images/".$file_name);
            }else{
                print_r($errors);
                die();
            }
        }
    }
    $sql = "UPDATE settings SET sitename='{$_POST["website_name"]}', footerdesc='{$_POST["footer_desc"]}', mainlogo='{$file_name}'";
    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: {$hostname}/admin/settings.php");
    }else{
        echo "Query Failed";
    }
?>