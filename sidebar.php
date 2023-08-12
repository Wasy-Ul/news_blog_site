<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        
        <?php
                         
            $connect=mysqli_connect("localhost","root","","news_site") or die("Database connection failed");                                       
            $sql="select * from post left join user on post.author=user.user_id inner join category on post.category=category.category_id order by post_id desc limit 3";
            $query=mysqli_query($connect,$sql) or die("Query Failed");                            
            if(mysqli_num_rows($query)>0)
            {
                while($row=mysqli_fetch_assoc($query))
                {

                            
        ?>

        <div class="recent-post">
            <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>">
                <img src="admin/upload/<?php echo $row['post_img'] ?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a  href="category.php?cid=<?php echo $row['category'] ?>"><?php echo $row['category_name'] ?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo $row['post_date'] ?>
                </span>
                <a class="read-more" href="single.php?id=<?php echo $row['post_id'] ?>">read more</a>
            </div>
        </div>

        <?php
                }}
                else{
                    echo "<p class='alert alert-danger'>No Post Available.</p>";
                }
        ?>
    </div>
    <!-- /recent posts box -->
</div>
