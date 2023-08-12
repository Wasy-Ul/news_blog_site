<?php 
    include "header.php";
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

?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Website Settings</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                 <?php
                    $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
                    $sql="select * from setting";
                    $query=mysqli_query($connect,$sql) or die("Query Failed");
                    $row=mysqli_fetch_assoc($query);
                 ?>
                  <!-- Form -->
                  <form  action="save-settings.php" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="website_name">Website Name</label>
                          <input type="text" name="website_name" value="<?php echo $row['Name']; ?>" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="logo">Website Logo</label>
                          <input type="file" name="logo" required>
                          <img src="images/<?php echo $row['Logo']; ?>">
                          <input type="hidden" name="old_logo" value=" " >
                      </div>
                      <div class="form-group">
                          <label for="footer_desc">Footer Description</label>
                          <textarea name="footer_desc" class="form-control" rows="5" required><?php echo $row['Fotter']; ?></textarea>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
                   
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
