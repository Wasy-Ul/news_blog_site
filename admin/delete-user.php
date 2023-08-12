<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:http://localhost/news_blog_site/admin/");
        die();
    }
    if($_SESSION['role']==0)
    {
        header("Location:http://localhost/news_blog_site/admin/post.php");
        die();
    }
    $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Lost: ".mysqli_connect_error());
    $id=$_GET['id'];
    $sql="update post set author=0 where author=$id;delete from user where user_id=$id";
    mysqli_multi_query($connect,$sql) or die("Data Deletion Failed");
    mysqli_close($connect);
    header("Location:http://localhost/news_blog_site/admin/users.php");
?>