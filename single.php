<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                    <div class="post-container">
                        <div class="post-content single-post">
                            <?php
                                if(!isset($_GET['id']))
                                {
                                    echo "<h3 class='alert alert-danger'>No Post Found.</h3>";
                                    die();    
                                }                                 
                                $connect=mysqli_connect("localhost","root","","news_site") or die("Database connection failed");
                                $sql="select * from post left join user on post.author=user.user_id inner join category on post.category=category.category_id  where post_id={$_GET['id']}";
                                $query=mysqli_query($connect,$sql) or die("Query Failed");                            
                                $result=mysqli_fetch_assoc($query);
                            ?>
                            <h3><?php echo $result['title']?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <a href="category.php?cid=<?php echo $result['category'] ?>"><?php echo $result['category_name'] ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href="author.php?aid=<?php echo $result['author'] ?>"><?php echo $result['username']?></a>
                                </span>
                                <span>
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    <?php echo $result['post_date']?>
                                </span>
                            </div>
                            <img class="single-feature-image" src="admin/upload/<?php echo $result['post_img'] ?>" alt=""/>
                            <p class="description">
                            <?php echo $result['description']?>
                            </p>
                        </div>
                    </div>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
