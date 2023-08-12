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
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                         <?php 
                            $connect=mysqli_connect("localhost","root","","news_site");
                            $sql="select * from category order by category_id desc";
                            $query=mysqli_query($connect,$sql);
                            if(isset($_GET['page']))
                            {
                                $page=$_GET['page'];
                            }
                            else{
                                $page=1;
                            }
                            $limit=3;
                            $totalRec=mysqli_num_rows($query);$totalPage=ceil($totalRec/$limit);
                            $offset=$limit*($page-1);
                            $sql2="select * from category order by category_id desc limit $offset,$limit";
                            $query2=mysqli_query($connect,$sql2);
                            $serialNumber=$offset+1;
                            if(mysqli_num_rows($query2))
                            {
                                while($record=mysqli_fetch_assoc($query2))
                                {                                                            
                         ?>                         
                            <tr>
                                <td class='id'><?php echo $serialNumber; ?></td>
                                <td><?php echo $record['category_name'] ?></td>
                                <td><?php echo $record['post'] ?></td>
                                <td class='edit'><a href="update-category.php?id=<?php echo $record['category_id'] ?>"><i class='fa fa-edit'></i></a></td>
                                <td class='delete'><a href="delete-category.php?id=<?php echo $record['category_id'] ?>"><i class='fa fa-trash-o'></i></a></td>
                            </tr>
                        <?php $serialNumber++;}
                              } 
                              else{
                                  echo "<h2 style='text-align:center;' class='alert alert-danger'>Data Not Found</h2>";
                              }
                        ?>
                    </tbody>
                </table>
                <ul class='pagination admin-pagination'>
                    
                     <?php
                        if($page!=1)
                        {
                            echo '<li><a href="category.php?page='.($page-1).'">Prev</a></li>';
                        }
                        for($i=1;$i<=$totalPage;$i++)
                        {
                            if($i==$page)
                            {
                                echo '<li class="active"><a href="category.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            else{
                                echo '<li><a href="category.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            
                        }
                        if($page!=$totalPage)
                        {
                           echo '<li><a href="category.php?page='.($page+1).'">Next</a></li>';
                        }
                     ?>
                </ul>
                 
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
