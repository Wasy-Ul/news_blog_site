<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:http://localhost/news_blog_site/admin/");
        die();
    }
    $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
    $postId=$_GET['id'];
    $categoryId=$_GET['cat'];
    $sql="select * from post where post_id=$postId";
    $query=mysqli_query($connect,$sql);
    $record=mysqli_fetch_assoc($query);
    unlink("upload/".$record['post_img']);
    $sql="delete from post where post_id=$postId; update category set post=post-1 where category_id=$categoryId;";    
    mysqli_multi_query($connect,$sql) or die("Query Failed");
    mysqli_close($connect);
    header("Location:http://localhost/news_blog_site/admin/post.php");
?>