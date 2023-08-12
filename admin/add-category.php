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
    
    if(isset($_POST['save'])){
        $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
        $categoryId=mysqli_real_escape_string($connect,$_POST["Id"]);
        $categoryName=mysqli_real_escape_string($connect,$_POST["Name"]);

        $user_check_sql="select category_id from category where category_name='$categoryName' or category_id=$categoryId";
        $user_check_query=mysqli_query($connect,$user_check_sql) or die("Query Failed To Check Double User");
        if(mysqli_num_rows($user_check_query)>0){
            echo"<h2 style='text-align:center;' class='alert alert-danger'>This Category name or Id is already exist. <a class='add-new' href='add-category.php'><u>Add Category</u></a></h2>";                                                 
            die();
        }
        $sql="INSERT INTO `category`(`category_id`, `category_name`) VALUES ($categoryId,'$categoryName')";                   
        mysqli_query($connect,$sql) or die("Query Failed");
        mysqli_close($connect);
        header("Location:http://localhost/news_blog_site/admin/category.php");
    }
              
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Id</label>
                          <input type="text" name="Id" class="form-control" placeholder="Category Id" required>
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="Name" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>              
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
