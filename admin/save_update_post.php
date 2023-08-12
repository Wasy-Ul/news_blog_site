<?php 

    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:http://localhost/news_blog_site/admin/");
        die();
    }
    if(isset($_POST['submit']))
    {
         $img_name=$_FILES['new-image']['name'];
         $tmp_name=$_FILES['new-image']['tmp_name'];
         $size=$_FILES['new-image']['size'];          
         
         $img_explode=explode(".",$img_name);         
         $file_extension=strtolower(end($img_explode));
         $extension=['jpeg','jpg','png'];
         if(in_array($file_extension,$extension)==false)
         {
            echo "<h2 style='text-align:center' class='alert alert-danger'>File extension is not support, Choose jpeg, jpg or png file</h2>";
            die();            
         }
         if( $size>2097152)
         {
            echo "<h2 style='text-align:center' class='alert alert-danger'>Please choose the file less than 2mb</h2>";
            die();
         }
         $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
         $sql="select post_img ,category from post where post_id={$_POST['post_id']}";
         $query=mysqli_query($connect,$sql) or die("Query Failed");
         $record=mysqli_fetch_assoc($query);
         unlink("upload/".$record['post_img']);
         move_uploaded_file($tmp_name,"upload/".time()."-".$img_name);
         $img_name=time()."-".$img_name;
          
         $sql3="update category set post=post-1 where category_id={$record['category']}";
         mysqli_query($connect,$sql3) or die("Update Query Failed");

         $title=htmlentities(mysqli_real_escape_string($connect,$_POST['post_title']));
         $description=htmlentities(mysqli_real_escape_string($connect,$_POST['postdesc']));
         $category=htmlentities(mysqli_real_escape_string($connect,$_POST['category']));
         $sql2="update post set title='$title' ,description='$description' ,category=$category , post_img='$img_name' where post_id={$_POST['post_id']}; update category set post=post+1 where category_id={$category}";
         echo $sql2;
          
         mysqli_multi_query($connect,$sql2) or die("Query Failed");
         mysqli_close($connect);
         header("Location:http://localhost/news_blog_site/admin/post.php");
    }
    else{
        header("Location:http://localhost/news_blog_site/admin/post.php");
        die();
    }

?>