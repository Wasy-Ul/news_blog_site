<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                <?php
                    $search_term=$_GET['search'];
                    echo "<h2 class='page-heading'>Search : $search_term</h2>";
                    $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connectiion Lost: ".mysqli_connect_error());
                    $sql="select * from post left join user on post.author=user.user_id inner join category on post.category=category.category_id where post.title like '%$search_term%' or description like '%$search_term%';";
                    $query=mysqli_query($connect,$sql) or die("Query Failed");                     

                    $page=1;
                    if(isset($_GET['page']))
                    {
                        $page=$_GET['page'];
                    }
                    $totRec=mysqli_num_rows($query);$limit=3;
                    $totPage=ceil($totRec/$limit); $offset=$limit*($page-1);

                    $sql1="select * from post left join user on post.author=user.user_id inner join category on post.category=category.category_id where post.title like '%$search_term%' or description like '%$search_term%' limit $offset,$limit;";
                    $query1=mysqli_query($connect,$sql1) or die("Query Failed");                     
                     
                    if(mysqli_num_rows($query1)>0)
                    {
                        while($row=mysqli_fetch_assoc($query1))
                        {                                            
                ?>
                  
                <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">                                     
                                <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href="category.php?cid=<?php echo $row['category'] ?>"><?php echo $row['category_name'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['user_id'] ?>'><?php echo $row['username'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date'] ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                    <?php echo substr($row['description'],0,130) ?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                     <?php 
                        }
                         }
                        else{
                            echo "<h2 class='alert alert-danger'>Result not found about: $search_term</h2>";
                        }
                     ?>
                    <?php
                        echo "<ul class='pagination'>";
                            if($page!=1)
                            {                                                                  
                                echo '<li><a href="search.php?page='.($page-1).'&search='.$search_term.'">Prev</a></li>';
                            }
                            for($i=1;$i<=$totPage;$i++)
                            {
                                if($page==$i)
                                {
                                    echo "<li class='active'><a href='search.php?search=$search_term&page=$i'>$i</a></li>";
                                }
                                else{
                                    echo "<li><a href='search.php?search=$search_term&page=$i'>$i</a></li>";
                                }                                                                                                  
                            }
                            if($page!=$totPage)
                            {
                                echo '<li><a href="search.php?page='.($page+1).'&search='.$search_term.'">Next</a></li>';                                 
                            }
                        echo "</ul>";
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
