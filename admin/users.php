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
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>                         
                      
                      <tbody>
                       
                          <?php 
                                 $connect=mysqli_connect("localhost","root","","news_site") or exit("Database Connection Lost: ".mysqli_connect_error());                                 
                                 $sql1="select * from user order by user_id desc";
                                 $query1=mysqli_query($connect,$sql1) or exit("Query Failed");
                                 if(isset($_GET['page']))
                                 {
                                    $page=$_GET['page'];
                                 }
                                 else{
                                    $page=1;
                                 }
                                 $totalRecord=mysqli_num_rows($query1);
                                 $limit=3;
                                 $totalPage=ceil($totalRecord/$limit);
                                 $offset=$limit*($page-1);

                                 $sql="select * from user order by user_id desc limit $offset,$limit";
                                 $query=mysqli_query($connect,$sql) or exit("Query Failed");

                                 if(mysqli_num_rows($query)>0){ 
                                 while($record=mysqli_fetch_assoc($query))
                                 {
                          ?>
                          <tr>
                              <td class='id'><?php echo $record['user_id'] ?></td>
                              <td><?php echo $record['first_name'] ." ".$record['last_name']  ?></td>
                              <td><?php echo $record['username'] ?></td>
                              <td><?php 
                                        if($record['role']==0){
                                            echo "Normal User";
                                        }
                                        else{
                                            echo "Admin";
                                        } 
                                   ?>
                                </td>
                              <td class='edit'><a href="update-user.php?id=<?php echo $record['user_id'] ?>"><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href="delete-user.php?id=<?php echo $record['user_id'] ?>"><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                           <?php } ?>                           
                      </tbody>
                  </table>   
                  <?php               
                        echo "<ul class='pagination admin-pagination'>";
                        if($page!=1)
                        {
                             
                            echo '<li><a href="users.php?page='.($page-1).'">Prev</a></li>';    
                        }
                        for($i=1;$i<=$totalPage;$i++){
                            if($i==$page) {
                                echo '<li class="active"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            else{
                                echo '<li><a href="users.php?page='.$i.'">'.$i.'</a></li>';    
                            }
                             
                        }
                        //<li class="active"><a>1</a></li>
                         if($page!=$totalPage)
                         {
                             
                            echo '<li><a href="users.php?page='.($page+1).'">Next</a></li>';    
                         }
                        echo "</ul>";
                  ?> 
              </div>
                  <?php }
                        else{
                            echo "<h1 style='text-align:center;color:red;'>Data Not Found</h1>";
                        } 
                  ?>
                  <?php 
                        mysqli_close($connect);
                  ?>
          </div>
      </div>
  </div>
 
