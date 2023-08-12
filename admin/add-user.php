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
        if($connect=mysqli_connect("localhost","root","","news_site"))
        {
            $id=mysqli_real_escape_string($connect,$_POST['id']);
            $fname=mysqli_real_escape_string($connect,$_POST['fname']);
            $lname=mysqli_real_escape_string($connect,$_POST['lname']);
            $username=mysqli_real_escape_string($connect,$_POST['user']);
            $password=mysqli_real_escape_string($connect,sha1($_POST['password']));             
            $role=mysqli_real_escape_string($connect,$_POST['role']);
            $user_check_sql="select user_id from user where username='$username' or user_id=$id";
            $user_check_query=mysqli_query($connect,$user_check_sql) or die("Query Failed To Check Double User");
            if(mysqli_num_rows($user_check_query)>0){
                echo"<h2 style='text-align:center;' class='alert alert-danger'>This user name or User Id is already exist. <a class='add-new' href='add-user.php'><u>Add User</u></a></h2>";                                                 
                die();
            }
             
            $sql="insert into user values ($id,'$fname','$lname','$username','$password','$role') ";
            mysqli_query($connect,$sql) or die("Query Failed to Insert Data.");
            mysqli_close($connect);
            header("Location:http://localhost/news_blog_site/admin/users.php");
            
        }
        else{
            echo "Database Connection Lost: ".mysqli_connect_error(); 
        }
        
    }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>User Id</label>
                          <input type="text" name="id" class="form-control" placeholder="User Id" required>
                      </div>

                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>
