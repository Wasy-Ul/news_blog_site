<div id ="footer">
    <div class="container">
        <div class="row">
            <?php 
                $connect=mysqli_connect("localhost","root","","news_site") or die("Database Connection Lost");
                $sql="select Fotter from setting";
                $query=mysqli_query($connect,$sql) or die("Query Faield");
                $row=mysqli_fetch_assoc($query);
            ?>
            <div class="col-md-12">
                <span><?php echo $row['Fotter'];  ?></a></span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
