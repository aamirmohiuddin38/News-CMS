<?php
    // echo $_SERVER['PHP_SELF'];
    include "config.php";
    $page = basename($_SERVER['PHP_SELF']);
    // echo $page;
    switch($page){
        case "single.php":
            if(isset($_GET['id'])){
                $sql_title = "SELECT * FROM post where post_id = {$_GET['id']}";
                $result_title = mysqli_query($conn, $sql_title) or die("Title Query Failed");
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = $row_title['title'];
            }else{
                $page_title = "Not Found";
            }
            break;
        case "category.php":
            if(isset($_GET['cid'])){
                $sql_title = "SELECT * FROM category where category_id = {$_GET['cid']}";
                $result_title = mysqli_query($conn, $sql_title) or die("Title Query Failed");
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title = $row_title['category_name'] . " News";
            }else{
                $page_title = "Not Found";
            }
            break;
        case "author.php":
            if(isset($_GET['authid'])){
                $sql_title = "SELECT * FROM user where user_id = {$_GET['authid']}";
                $result_title = mysqli_query($conn, $sql_title) or die("Title Query Failed");
                $row_title = mysqli_fetch_assoc($result_title);
                $page_title ="News By " .$row_title['username'];
            }else{
                $page_title = "Not Found";
            }
            break;
        case "search.php":
            if(isset($_GET['search'])){
                $page_title = $_GET['search'];
            }else{
                $page_title = "No Result Found";
            }
            break;
        default:
            $page_title = "NewsBLOG";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
                <?php
                    $sql = "SELECT * FROM settings";
                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)) {
                            if($row['mainlogo'] == ""){
                                echo '<a href="index.php"><h1>'.$row['sitename'].'</h1></a>';
                            }else{
                            echo '<a href="index.php" id="logo"><img src="admin/images/'.$row['mainlogo'].'"></a>';
                            }
                        }
                    }
                ?>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    include "config.php";
                    if(isset($_GET['cid'])){
                        $cat_id = $_GET['cid'];
                    }
                    $sql = "SELECT * FROM category WHERE post > 0";
                    $result = mysqli_query($conn, $sql) or die("Query Failed: Category");
                    if(mysqli_num_rows($result)>0){
                ?>
                <ul class='menu'>
                <li><a href="<?php echo $hostname ?>">Home</a></li>
                        <?php while($row = mysqli_fetch_assoc($result)){ 
                            $active = "";
                            if(isset($_GET['cid'])){
                                if($row['category_id']== $cat_id){
                                    $active = "active";
                                }else{
                                    $active = "";
                                }
                            }
                            ?>
                            <li><a class= '<?php echo "{$active}"?>' href='category.php?cid=<?php echo $row['category_id'] ?>'><?php echo $row['category_name'] ?></a></li>
                        <?php } ?>
                </ul>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
