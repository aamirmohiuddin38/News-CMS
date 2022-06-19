<?php
    include "config.php";
    if(empty($_FILES['new-image']['name'])){
        $file_name = $_POST['old-image'];
    }else{
        if(isset($_FILES['new-image'])){
            $errors = array();
    
            $file_name = $_FILES['new-image']['name'];
            $file_size = $_FILES['new-image']['size'];
            $file_tmp = $_FILES['new-image']['tmp_name'];
            $file_type = $_FILES['new-image']['type'];
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
                move_uploaded_file($file_tmp, "upload/".$file_name);
            }else{
                print_r($errors);
                die();
            }
        }
    }
    $sql = "UPDATE post SET title='{$_POST["post_title"]}', description='{$_POST["postdesc"]}', category={$_POST["category"]}, post_img='{$file_name}' 
            WHERE post_id={$_POST["post_id"]};";
        if($_POST['old_category'] != $_POST['category']){
            $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
            $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']};";
        }
    
    $result = mysqli_multi_query($conn, $sql);

    if($result){
        header("Location: {$hostname}/admin/post.php");
    }else{
        echo "Query Failed";
    }
?>