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
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                <?php 
                    $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Failed");
                     
                     $limit=3; 
                     if(isset($_GET['page']))
                     {
                        $page=$_GET['page'];
                     }
                     else{
                        $page=1;
                     }

                     $offset=($page-1)*$limit;

                     if($_SESSION['role']==1)
                     {
                        $sql="select post.category, user.username, category_name, post_id, post.title, post.post_date from post left join category on post.category=category.category_id left join user on  post.author = user.user_id order by post.post_id desc limit $offset,$limit;";                         
                     }
                     else{
                        $sql="select user.username, post.category, category_name, post_id, post.title, post.post_date from post left join category on post.category=category.category_id left join user on  post.author = user.user_id  WHERE post.author = {$_SESSION['user_id']} order by post.post_id desc limit $offset,$limit;";                         
                     }
                     $serialNumber=$offset+1;
                     
                    $query=mysqli_query($connect,$sql) or die("Query Failed");                 
                    if(mysqli_num_rows($query))
                    {
                    
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                           
                           <?php
                                while($row=mysqli_fetch_assoc($query))
                                {                                
                           ?>                          
                          <tr>
                              <td class='id'><?php echo $serialNumber; ?></td>
                              <td><?php echo $row['title']; ?></td>                               
                              <td><?php echo $row['category_name']; ?></td>
                              <td><?php echo $row['post_date']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row["post_id"]; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row["post_id"]; ?>&cat=<?php echo $row["category"]; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php $serialNumber++;} ?>
                      </tbody>
                  </table>
                  <?php
                    }
                    else{
                        echo "<h2 style='text-align:center;color:red'>Data not found</h2>";
                    }
                  ?>
                  <?php
                        if($_SESSION['role']==1)
                        {
                           $sql="select user.username, category_name, post_id, post.title, post.post_date from post inner join category on post.category=category.category_id inner join user on  post.author = user.user_id order by post.post_id desc  ;";
                           $query=mysqli_query($connect,$sql) or die("Query Failed");
                           $totRec=mysqli_num_rows($query);
                        }
                        else{
                           $sql="select user.username, category_name, post_id, post.title, post.post_date from post inner join category on post.category=category.category_id inner join user on  post.author = user.user_id  WHERE post.author = {$_SESSION['user_id']} order by post.post_id desc  ";
                           $query=mysqli_query($connect,$sql) or die("Query Failed");
                           $totRec=mysqli_num_rows($query);
                        }
                        $totPage=ceil($totRec/$limit);   
                        echo "<ul class='pagination admin-pagination'>";
                        if($page!=1)
                        {
                            echo '<li><a href="post.php?page='.($page-1).'">Prev</a></li>';
                        }
                        for($i=1;$i<=$totPage;$i++)
                        {                                                      
                                if($i==$page)      
                                {
                                    echo '<li class="active"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                                }
                                else{
                                    echo '<li><a href="post.php?page='.$i.'">'.$i.'</a></li>';    
                                }
                                 
                        }
                        if($page!=$totPage)
                        {
                            echo '<li><a href="post.php?page='.($page+1).'">Next</a></li>';
                        }
                        echo "</ul>";
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
