<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:http://localhost/news_blog_site/admin/");
        die();
    }

    if(isset($_FILES['fileToUpload']))
    {
        $filename=$_FILES['fileToUpload']['name'];
        $tmp_name=$_FILES['fileToUpload']['tmp_name'];
        $size=$_FILES['fileToUpload']['size'];  
        $filename_explode=explode('.',$filename);
        $file_ext= strtolower(end($filename_explode));
        $extension=["jpeg","jpg","png"];

        if(in_array($file_ext,$extension)==false)
        {
            echo "<h2 style='text-align:center' class='alert alert-danger'>File extension is not support, Choose jpeg, jpg or png file</h2>";
            die();
        }

        if( $size>2097152)
        {
            echo "<h2 style='text-align:center' class='alert alert-danger'>Please choose the file less than 2mb</h2>";
            die();
        }
        move_uploaded_file($tmp_name,"upload/".time()."-".$filename);
        $filename=time()."-".$filename;
         
    }
    $connect=mysqli_connect("localhost","root","","news_site") or die("Database connection lost");
    $title=htmlentities(mysqli_real_escape_string($connect,$_POST['post_title']));
    $desc=htmlentities(mysqli_real_escape_string($connect,$_POST['postdesc']));
    $category=htmlentities(mysqli_real_escape_string($connect,$_POST['category']));
    $date=date("d-M-Y");
    $author=$_SESSION['user_id'];
    $sql="INSERT INTO `post`(`title`, `description`, `category`, `post_date`, `author`, `post_img`) VALUES ('$title','$desc',$category,'$date','$author','$filename'); update category set post=post+1 where category_id=$category;";
    $query=mysqli_multi_query($connect,$sql) or die("Query Failed");
    mysqli_close($connect);
    header("Location:http://localhost/news_blog_site/admin/post.php");

?>