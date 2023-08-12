<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                   
                    <?php

                        $connect=mysqli_connect("localhost","root","","news_site") or die("Database connection failed");
                        $sql1="select * from post inner join category on post.category=category.category_id inner join user on post.author=user.user_id where author={$_GET['aid']}";

                        $query1=mysqli_query($connect,$sql1) or die("Query Failed");
                        $result1=mysqli_fetch_assoc($query1);
                        $authName=$result1['username'];
                        echo "<h2 class='page-heading'>$authName</h2>";  

                        $totRec=mysqli_num_rows($query1);$limit=2;
                        $numOfPage=ceil($totRec/$limit); $page=1;
                        if(isset($_GET['page']))
                        {
                            $page=$_GET['page'];
                        }
                        $offset=$limit*($page-1);                            

                        $sql="select * from post left join user on post.author=user.user_id inner join category on post.category=category.category_id where author={$_GET['aid']} limit $offset,$limit";
                        $query=mysqli_query($connect,$sql) or die("Query Failed");                            
                        if(mysqli_num_rows($query)>0)
                        {
                            while($row=mysqli_fetch_assoc($query))
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
                                <?php echo substr($row['description'],0,130); ?>
                                </p>
                                <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read more</a>
                            </div>
                        </div>
                        </div>
                        </div>
                        <?php 
                        } }
                        else{
                        echo "<h2 class='alert alert-danger'> No Post Found</h2>";
                        }
                        ?>
                        <?php
                        echo "<ul class='pagination'>";                             
                        if($page!=1)
                        { 
                            $author=$result1['author'];
                            echo '<li><a href="author.php?page='.($page-1).'&aid='.$author.'">Prev</a></li>';
                        }

                        for($i=1;$i<=$numOfPage;$i++)
                        {   
                            if($page==$i)                             
                            {
                                $author=$result1['author'];
                                echo "<li class='active'><a href='author.php?page=$i&aid=$author'>$i</a></li>";
                            }
                            else{
                                $author=$result1['author'];
                                echo "<li><a href='author.php?page=$i&aid=$author'>$i</a></li>";
                            }                                                                                                                                               
                        }
                        if($page!=$numOfPage)
                        {                                     
                            $author=$result1['author'];
                            echo '<li><a href="author.php?page='.($page+1).'&aid='.$author.'">Next</a></li>';
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
