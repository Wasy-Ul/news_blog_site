<?php
    session_start();
    if(isset($_SESSION['username']))
    {
        header("Location:http://localhost/news_blog_site/admin/post.php");
        die();
    }
?>
<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <?php
                            $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
                            $logoSql="select * from setting";
                            $logoQuery=mysqli_query($connect,$logoSql) or die("Query Failed");
                            $logoRecord=mysqli_fetch_assoc($logoQuery);
                        ?>
                         
                        <a href="index.php"  ><img class="logo" src="images/<?php echo $logoRecord['Logo']; ?>"></a>
                        
                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                        </form>
                        <!-- /Form  End -->
                    </div>
                </div>
                <?php
                    if(isset($_POST['login']))
                    {   
                         
                        $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
                        $username=mysqli_real_escape_string($connect,$_POST['username']);                         
                        $password=mysqli_real_escape_string($connect,sha1($_POST['password']));                                                                            
                        $sql="select user_id,username,role from user where username='$username' and password='$password'";
                        $query=mysqli_query($connect,$sql) or die("Query Failed");
                         
                        if(mysqli_num_rows($query)>0){
                            $row=mysqli_fetch_assoc($query);
                            session_start();
                            $_SESSION['username']=$row['username'];
                            $_SESSION['user_id']=$row['user_id'];
                            $_SESSION['role']=$row['role'];
                            header("Location:http://localhost/news_blog_site/admin/post.php");
                        }
                        else{
                            echo"<h2 style='text-align:center;' class='alert alert-danger'> Password not matched.</h2>";
                        }
                    }

                ?>
            </div>
        </div>
    </body>
</html>
