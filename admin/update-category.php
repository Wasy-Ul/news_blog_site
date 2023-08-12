<?php 
     include "header.php";
    if(!isset($_SESSION['username'])){
        header("Location:http://localhost/news_blog_site/admin/");
        die();
    }
    if($_SESSION['role']==0)
    {
        header("Location:http://localhost/news_blog_site/admin/post.php");
        die();
    }
     
    if(isset($_POST['submit'])){
        echo "Enter";
        $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
        $categoryId=mysqli_real_escape_string($connect,$_POST["cat_id"]);
        $categoryName=mysqli_real_escape_string($connect,$_POST["cat_name"]);
        $sql2="update category set category_name='$categoryName' where category_id=$categoryId";
        mysqli_query($connect,$sql2) or die("Query Failed 1");
        mysqli_close($connect);
        header("Location:http://localhost/news_blog_site/admin/category.php");
        die();
    }
              
    ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php
                 
                    $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
                    $id=$_GET['id'];
                    $sql="select * from category where category_id=$id";
                    $query=mysqli_query($connect,$sql) or die("Query Failed 1");
                    $row=mysqli_fetch_assoc($query);
                 
                ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id']; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']; ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                </div>
              </div>
              
            </div>
          </div>
<?php include "footer.php"; ?>
