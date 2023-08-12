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
        $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Lost: ".mysqli_connect_error());
        $id=mysqli_real_escape_string($connect,$_POST['user_id']);
        $fname=mysqli_real_escape_string($connect,$_POST['f_name']);
        $lname=mysqli_real_escape_string($connect,$_POST['l_name']);
        $username=mysqli_real_escape_string($connect,$_POST['username']);         
        $role=mysqli_real_escape_string($connect,$_POST['role']);        
        $sql2="update user set first_name='$fname', last_name='$lname', username='$username', role='$role' where user_id=$id ";
        mysqli_query($connect,$sql2) or die("Update Query Failed");
        mysqli_close($connect);
        header("Location:http://localhost/news_blog_site/admin/users.php");
    }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                  <?php 
                        $id=$_GET['id'];
                        $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Lost: ".mysqli_connect_error());
                        $sql="select * from user where user_id=$id";
                        $query=mysqli_query($connect,$sql);
                        $record=mysqli_fetch_assoc($query);
                  ?>
                  <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $record['user_id']; ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $record['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $record['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $record['username']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role">
                            <?php
                                if($record['role']==0)
                                {
                                    echo "<option selected value='0'>Normal User</option>";                                    
                                    echo "<option   value='1'>Admin</option>";
                                    
                                }
                                else{
                                    echo "<option selected value='1'>Admin</option>";
                                    echo "<option  value='0'>Normal User</option>";                                    
                                }
                            ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
