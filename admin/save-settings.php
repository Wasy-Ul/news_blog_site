<?php    
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("Location:http://localhost/news_blog_site/admin/");
        die();
    } 
    if($_SESSION['role']==0)
    {
        header("Location:http://localhost/news_blog_site/admin/post.php");         
        die();
    }
    if(isset($_POST['submit']))
    {
            $img_name=$_FILES['logo']['name'];
            $tmp_name=$_FILES['logo']['tmp_name'];
            $size=$_FILES['logo']['size'];
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
            $sql="select Logo from setting ";
            $query=mysqli_query($connect,$sql) or die("Query Failed 1");
            $record=mysqli_fetch_assoc($query);
            unlink("images/".$record['Logo']);
            move_uploaded_file($tmp_name,"images/".time()."-".$img_name);                    
            $finalImage=time()."-".$img_name;   
            
            

            $title=htmlentities(mysqli_real_escape_string($connect,$_POST['website_name']));
            $fotter=htmlentities(mysqli_real_escape_string($connect,$_POST['footer_desc']));          
            $sql2="update setting set Name='$title' ,Fotter='$fotter' ,Logo='$finalImage'";          
            
            mysqli_query($connect,$sql2) or die("Query Failed 3");
            mysqli_close($connect);
            header("Location:http://localhost/news_blog_site/admin/settings.php");
        }
        else{
            header("Location:http://localhost/news_blog_site/admin/settings.php");
        }
?>