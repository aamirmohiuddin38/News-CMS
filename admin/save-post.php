<?php
    include "config.php";
    // Check if file is uploaded
    if(isset($_FILES['fileToUpload'])){
        $errors = array();

        $file_name = $_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_ext = end(explode('.', $file_name));
        $extensions = array("jpeg","jpg","png","webp");

        if(in_array($file_ext, $extensions) === false){
            $errors[] = "Invalid Image extension, try jpg, jpeg, png or webp.";
        }

        if($file_size > 2097152){
            $errors[] = "File size exceeds 2MB";
        }

        $new_name = time(). "-".basename($file_name);
        $target = "upload/".$new_name;

        if(empty($errors) == true){
            move_uploaded_file($file_tmp, $target);
        }else{
            print_r($errors);
        }
    }
    // Prepare post data
    session_start();
    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $description = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = date("d M, Y");
    $author = $_SESSION['user_id'];

    $sql = "INSERT INTO post(title, description, category, post_date, author, post_img)
            VALUES('{$title}','{$description}',{$category},'{$date}','{$author}','{$new_name}');";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

    if(mysqli_multi_query($conn, $sql)){
        header("Location: {$hostname}/admin/post.php");
    }else{
        echo "<div class='alert alert-danger'>Query Failed</div>";
    }
?>