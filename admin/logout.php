<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: http://localhost/news_blog_site/admin/");
?>
