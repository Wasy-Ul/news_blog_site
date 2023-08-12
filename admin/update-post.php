<?php 
     include "header.php";
    if(!isset($_SESSION['username'])){
        header("Location:http://localhost/news_blog_site/admin/");
        die();
    }
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <?php
            $post_id=$_GET['id'];
            $connect=mysqli_connect("localhost","root","","news_site") or die("Database connection failed: ".mysqli_connect_error());
            if($_SESSION['role']==1)
            {
                $sql="select * from post inner join category on post.category=category.category_id where post_id=$post_id";
            }
            else{
                $sql="select * from post inner join category on post.category=category.category_id where post_id=$post_id and post.author={$_SESSION['user_id']}";    
            }
            
            $query=mysqli_query($connect,$sql) or die("Query Failed");
            if(mysqli_num_rows($query)>0)
            {
                $record=mysqli_fetch_assoc($query);   
             
        ?>
        <form action="save_update_post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $record['post_id']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $record['title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                <?php echo $record['description']; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                
                <select class="form-control" name="category">
                <?php 
                    $sql2="select * from category";
                    $query2=mysqli_query($connect,$sql2) or die("Query Failed");
                    while($row=mysqli_fetch_assoc($query2))
                    {                                    
                        if($row['category_id']==$record['category_id'])
                        {
                            echo "<option selected value=".$row['category_id'].">".$row['category_name']."</option>";
                        }
                        else{
                            echo "<option  value=".$row['category_id'].">".$row['category_name']."</option>";
                        }
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image" required>
                <img  src="upload/<?php echo $record['post_img']; ?>" height="150px">                                                    
                <!-- <input type="hidden" name="old-image" value=""> -->
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php 
            }
            else{
                header("Location:http://localhost/news_blog_site/admin/post.php");
            }
        ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
