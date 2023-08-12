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
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="save_data.php" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control" required>
                            <?php
                                $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Lost");
                                $sql="select * from category";
                                $query=mysqli_query($connect,$sql) or die("Query Failed");
                                if(mysqli_num_rows($query)>0)
                                {
                                    echo "<option value='' disabled selected> Select Category</option>";
                                    while($row=mysqli_fetch_assoc($query))
                                    {
                                        echo '<option value='.$row["category_id"].' >'.$row["category_name"].'</option>';
                                    }
                                }
                                else{
                                    echo "<option value='' disabled selected>There are no category</option>";
                                }
                            ?>
                              
                               
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
