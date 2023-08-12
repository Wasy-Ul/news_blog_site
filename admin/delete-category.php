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
  $connect=mysqli_connect("localhost","root","","news_site") or die("Connection Failed");
  $id=$_GET['id'];
  $sql="delete from category where category_id=$id";
  mysqli_query($connect,$sql) or die("Query Failed");
  mysqli_close($connect);
  header("Location:http://localhost/news_blog_site/admin/category.php");

?>
