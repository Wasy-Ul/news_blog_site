<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <?php 
        $connect=mysqli_connect("localhost","root","","news_site")  or die("Database Connection Failed");
        $fileName=basename($_SERVER['PHP_SELF']);
        switch($fileName)
        {
            case 'index.php':
                $titleSql="select * from setting";
                $titleQuery=mysqli_query($connect,$titleSql) or die("Query Failed");
                $titleRecord=mysqli_fetch_assoc($titleQuery);
                $pageTitle=$titleRecord['Name'];break;
            case 'category.php':
                $titleSql="select * from post inner join category on post.category=category.category_id where category={$_GET['cid']}";
                            
                $titleQuery=mysqli_query($connect,$titleSql) or die("Query Failed");
                $titleResult=mysqli_fetch_assoc($titleQuery);
                $pageTitle=$titleResult['category_name']." News";break;                 
            case 'author.php':
                $titleSql="select * from post inner join category on post.category=category.category_id inner join user on post.author=user.user_id where author={$_GET['aid']}";
                            
                $titleQuery=mysqli_query($connect,$titleSql) or die("Query Failed");
                $titleResult=mysqli_fetch_assoc($titleQuery);
                $pageTitle=$titleResult['username']." News";break;                                 
            case 'single.php':
                $titleSql="select * from post left join user on post.author=user.user_id inner join category on post.category=category.category_id  where post_id={$_GET['id']}";
                            
                $titleQuery=mysqli_query($connect,$titleSql) or die("Query Failed");
                $titleResult=mysqli_fetch_assoc($titleQuery);
                $pageTitle=$titleResult['title'];break;                                                 
            case 'search.php':                
                $pageTitle=$_GET['search']." News";break;                                                                 
        }
    ?>
    <title><?php echo $pageTitle; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <?php
                  
                 $logoSql="select * from setting";
                 $logoQuery=mysqli_query($connect,$logoSql) or die("Query Failed");
                 $logoRecord=mysqli_fetch_assoc($logoQuery);
            ?>
            <div class=" col-md-offset-4 col-md-4">
                <a href="index.php" id="logo"><img src="admin/images/<?php echo $logoRecord['Logo']; ?>"></a>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class='menu'>
                    <?php
                        
                        $sql="select * from category where post>0";
                        $query=mysqli_query($connect,$sql) or die("Query Failed");
                        $cid=0;$hl8="";
                        if(isset($_GET['cid']))
                        {
                            $cid=$_GET['cid'];
                        }
                        
                        if($cid==0)
                        {
                            $hl8='background-color:#1E90FF;';
                        }
                        echo "<li style=''><a href='index.php'>Home</a></li>";
                        if(mysqli_num_rows($query)>0)
                        {                            
                            while($row=mysqli_fetch_assoc($query))
                            {
                                if($cid==$row['category_id'])
                                {
                                    echo "<li style='background-color:#1E90FF;'><a href='category.php?cid=".$row['category_id']."'>".$row['category_name']."</a></li>";
                                }
                                else{
                                    echo "<li><a href='category.php?cid=".$row['category_id']."'>".$row['category_name']."</a></li>";
                                }
                                 
                            }
                        }                                                  
                        echo "<li><a target='blank' href='admin/index.php'>Admin</a></li>";
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
